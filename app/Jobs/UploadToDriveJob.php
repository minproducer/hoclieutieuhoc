<?php

namespace App\Jobs;

use App\Models\Document;
use App\Services\GoogleDriveService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UploadToDriveJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(
        public readonly int $documentId,
        public readonly string $filePath,
        public readonly string $originalName,
        public readonly ?string $oldDriveFileId = null,
    ) {}

    public function handle(): void
    {
        $document = Document::find($this->documentId);

        if (! $document) {
            @unlink($this->filePath);
            return;
        }

        if (! file_exists($this->filePath)) {
            Log::warning("UploadToDriveJob: file not found at {$this->filePath} for document #{$this->documentId}");
            return;
        }

        try {
            $ext      = pathinfo($this->originalName, PATHINFO_EXTENSION)
                ?: pathinfo($this->filePath, PATHINFO_EXTENSION);
            $mimeType = mime_content_type($this->filePath) ?: 'application/octet-stream';
            $slug     = Str::slug($document->title) ?: 'document';
            $fileName = $ext ? "{$slug}.{$ext}" : $slug;

            $driveService = app(GoogleDriveService::class);

            // Delete old Drive file when replacing
            if ($this->oldDriveFileId) {
                try {
                    $driveService->deleteFile($this->oldDriveFileId);
                } catch (\Exception) {
                    // ignore — old file may already be gone
                }
            }

            $result = $driveService->uploadFile($this->filePath, $fileName, $mimeType);

            $fileType    = $this->detectFileType($mimeType, $this->originalName);
            $fileSizeKb  = (int) ceil(filesize($this->filePath) / 1024);

            // Only preserve thumbnail if it is a locally uploaded file (not a Drive-generated URL).
            // Drive-generated thumbnails are derived on-the-fly from drive_file_id by
            // getThumbnailDisplayUrlAttribute(), so we clear them here to avoid stale old-file IDs.
            $existingThumb = $document->thumbnail_url;
            $isLocalThumb  = $existingThumb
                && ! str_contains($existingThumb, 'googleusercontent.com')
                && ! str_contains($existingThumb, 'drive.google.com');

            $thumbnailUrl = $isLocalThumb ? $existingThumb : null;

            $document->update([
                'drive_file_id'   => $result['fileId'],
                'drive_view_link' => $result['viewLink'],
                'file_type'       => $fileType,
                'file_size_kb'    => $fileSizeKb,
                'thumbnail_url'   => $thumbnailUrl,
            ]);

        } catch (\Exception $e) {
            Log::error("UploadToDriveJob failed for document #{$this->documentId}: " . $e->getMessage());
        } finally {
            @unlink($this->filePath);
        }
    }

    private function detectFileType(string $mimeType, string $fileName): string
    {
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        return match ($ext) {
            'pdf'              => 'pdf',
            'docx', 'doc'      => 'docx',
            'pptx', 'ppt'      => 'pptx',
            'xlsx', 'xls'      => 'xlsx',
            'zip', 'rar', '7z' => 'zip',
            'jpg', 'jpeg', 'png', 'webp', 'gif' => 'image',
            default => match (true) {
                str_contains($mimeType, 'pdf')         => 'pdf',
                str_contains($mimeType, 'word')        => 'docx',
                str_contains($mimeType, 'powerpoint') || str_contains($mimeType, 'presentation') => 'pptx',
                str_contains($mimeType, 'excel')      || str_contains($mimeType, 'spreadsheet')  => 'xlsx',
                str_contains($mimeType, 'zip')         => 'zip',
                str_contains($mimeType, 'image')       => 'image',
                default                                => 'pdf',
            },
        };
    }
}
