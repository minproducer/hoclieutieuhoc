<?php

namespace App\Services;

use App\Models\Setting;
use Google\Client as GoogleClient;
use Google\Http\MediaFileUpload;
use Google\Service\Drive as GoogleDrive;
use Google\Service\Drive\DriveFile;

class GoogleDriveService
{
    private GoogleClient $client;

    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->client->setClientId(Setting::get('google_oauth_client_id', ''));
        $this->client->setClientSecret(Setting::get('google_oauth_client_secret', ''));
        $this->client->addScope(GoogleDrive::DRIVE);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('consent');

        $refreshToken = Setting::get('google_oauth_refresh_token', '');
        if ($refreshToken) {
            $this->client->refreshToken($refreshToken);
        }
    }

    public function getOAuthUrl(string $redirectUri): string
    {
        $this->client->setRedirectUri($redirectUri);
        return $this->client->createAuthUrl();
    }

    public function exchangeCodeForTokens(string $code, string $redirectUri): array
    {
        $this->client->setRedirectUri($redirectUri);
        $token = $this->client->fetchAccessTokenWithAuthCode($code);

        if (isset($token['error'])) {
            throw new \RuntimeException('Google OAuth error: ' . ($token['error_description'] ?? $token['error']));
        }

        // Google may store the refresh_token internally even if not in the response array
        $refreshToken = $token['refresh_token'] ?? $this->client->getRefreshToken();

        return [
            'access_token'  => $token['access_token'] ?? null,
            'refresh_token' => $refreshToken,
        ];
    }

    public function uploadFile(string $tmpPath, string $fileName, string $mimeType): array
    {
        $drive = new GoogleDrive($this->client);

        $folderId = Setting::get('google_drive_folder_id', null);

        $fileMetadata = new DriveFile([
            'name'    => $fileName,
            'parents' => $folderId ? [$folderId] : [],
        ]);

        $fileSize = filesize($tmpPath);
        if ($fileSize === false) {
            throw new \RuntimeException('Không đọc được kích thước tệp upload.');
        }

        $this->client->setDefer(true);

        try {
            $createRequest = $drive->files->create($fileMetadata, [
                'mimeType'   => $mimeType,
                'uploadType' => 'resumable',
                'fields'     => 'id, webViewLink, thumbnailLink',
            ]);

            $chunkSizeBytes = 8 * 1024 * 1024; // 8MB chunks to keep memory usage stable
            $media = new MediaFileUpload(
                $this->client,
                $createRequest,
                $mimeType,
                null,
                true,
                $chunkSizeBytes
            );
            $media->setFileSize($fileSize);

            $handle = fopen($tmpPath, 'rb');
            if ($handle === false) {
                throw new \RuntimeException('Không mở được tệp để upload.');
            }

            $driveFile = null;
            while (! feof($handle)) {
                $chunk = fread($handle, $chunkSizeBytes);
                if ($chunk === false) {
                    fclose($handle);
                    throw new \RuntimeException('Đọc tệp thất bại khi upload lên Google Drive.');
                }

                if ($chunk === '') {
                    continue;
                }

                $driveFile = $media->nextChunk($chunk);
            }

            fclose($handle);

            if (! $driveFile) {
                throw new \RuntimeException('Upload Google Drive thất bại, không nhận được thông tin tệp.');
            }
        } finally {
            $this->client->setDefer(false);
        }

        // Make the file publicly readable
        $permission = new \Google\Service\Drive\Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]);
        $drive->permissions->create($driveFile->getId(), $permission);

        return [
            'fileId'        => $driveFile->getId(),
            'viewLink'      => $driveFile->getWebViewLink(),
            'thumbnailLink' => method_exists($driveFile, 'getThumbnailLink') ? $driveFile->getThumbnailLink() : null,
        ];
    }

    public function getThumbnailUrl(string $fileId): string
    {
        return "https://drive.google.com/thumbnail?id={$fileId}&sz=w1200";
    }

    public function deleteFile(string $fileId): void
    {
        $drive = new GoogleDrive($this->client);
        $drive->files->delete($fileId);
    }

    public function getPreviewUrl(string $fileId): string
    {
        return "https://drive.google.com/file/d/{$fileId}/preview";
    }

    public function getDownloadUrl(string $fileId): string
    {
        return "https://drive.google.com/uc?export=download&id={$fileId}";
    }

    public function isConfigured(): bool
    {
        $clientId = Setting::get('google_oauth_client_id', '');
        $clientSecret = Setting::get('google_oauth_client_secret', '');
        $refreshToken = Setting::get('google_oauth_refresh_token', '');

        return ! empty($clientId) && ! empty($clientSecret) && ! empty($refreshToken);
    }
}
