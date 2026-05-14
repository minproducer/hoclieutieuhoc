<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use App\Jobs\UploadToDriveJob;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    protected ?string $stableFilePath = null;
    protected ?string $originalFileName = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['uploader_id'] = auth()->id();

        $raw = $data['upload_file'] ?? null;
        if ($raw instanceof TemporaryUploadedFile) {
            $this->moveToStableLocation($raw);
        }

        unset($data['upload_file']);
        return $data;
    }

    protected function afterCreate(): void
    {
        if (! $this->stableFilePath) {
            return;
        }

        UploadToDriveJob::dispatchAfterResponse(
            $this->record->id,
            $this->stableFilePath,
            $this->originalFileName ?? basename($this->stableFilePath),
        );

        \Filament\Notifications\Notification::make()
            ->title('Tệp đang được upload lên Google Drive')
            ->body('Tài liệu đã lưu. Drive upload đang chạy nền — vài phút sau kiểm tra lại tài liệu.')
            ->info()
            ->seconds(8)
            ->send();
    }

    /**
     * Move Livewire temp file to a stable location so the async job can access it
     * after the HTTP response has been sent.
     */
    private function moveToStableLocation(TemporaryUploadedFile $file): void
    {
        $realPath = $file->getRealPath();
        if (! $realPath || ! file_exists($realPath)) {
            return;
        }

        $originalName = $file->getClientOriginalName();
        $ext          = pathinfo($originalName, PATHINFO_EXTENSION)
            ?: pathinfo($realPath, PATHINFO_EXTENSION);

        $dir = storage_path('app/tmp-uploads');
        if (! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $stablePath = $dir . DIRECTORY_SEPARATOR . uniqid('drv_', true) . ($ext ? ".{$ext}" : '');

        // rename() is instant on same filesystem; fall back to copy+unlink
        $moved = @rename($realPath, $stablePath);
        if (! $moved) {
            $moved = copy($realPath, $stablePath);
            if ($moved) {
                @unlink($realPath);
            }
        }

        if ($moved) {
            $this->stableFilePath  = $stablePath;
            $this->originalFileName = $originalName;
        }

        try {
            $file->delete();
        } catch (\Exception) {}
    }
}
