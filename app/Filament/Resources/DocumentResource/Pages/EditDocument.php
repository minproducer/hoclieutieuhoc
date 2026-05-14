<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use App\Jobs\UploadToDriveJob;
use App\Services\GoogleDriveService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

    protected ?string $stableFilePath  = null;
    protected ?string $originalFileName = null;
    protected ?string $oldDriveFileId  = null;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('delete_drive_file')
                ->label('Xóa file Drive')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->outlined()
                ->visible(fn () => filled($this->record->drive_file_id))
                ->requiresConfirmation()
                ->modalHeading('Xóa file khỏi Google Drive?')
                ->modalDescription('File sẽ bị xóa vĩnh viễn khỏi Google Drive. Thao tác này không thể hoàn tác.')
                ->modalSubmitActionLabel('Xóa')
                ->action(function () {
                    $driveService = app(GoogleDriveService::class);
                    try {
                        if ($this->record->drive_file_id) {
                            $driveService->deleteFile($this->record->drive_file_id);
                        }
                        $this->record->update([
                            'drive_file_id'   => null,
                            'drive_view_link' => null,
                            'file_size_kb'    => null,
                        ]);
                        $this->refreshFormData(['drive_file_id', 'drive_view_link', 'file_size_kb']);
                        \Filament\Notifications\Notification::make()
                            ->title('Đã xóa file khỏi Google Drive')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        \Filament\Notifications\Notification::make()
                            ->title('Lỗi xóa file')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $raw = $data['upload_file'] ?? null;
        if ($raw instanceof TemporaryUploadedFile) {
            // Capture old Drive file ID before moving the new file into place
            $this->oldDriveFileId = $this->record->drive_file_id;
            $this->moveToStableLocation($raw);
        }

        unset($data['upload_file']);
        return $data;
    }

    protected function afterSave(): void
    {
        if (! $this->stableFilePath) {
            return;
        }

        UploadToDriveJob::dispatchAfterResponse(
            $this->record->id,
            $this->stableFilePath,
            $this->originalFileName ?? basename($this->stableFilePath),
            $this->oldDriveFileId,
        );

        \Filament\Notifications\Notification::make()
            ->title('Tệp đang được upload lên Google Drive')
            ->body('Đã lưu. Drive upload đang chạy nền — vài phút sau kiểm tra lại tài liệu.')
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

        $moved = @rename($realPath, $stablePath);
        if (! $moved) {
            $moved = copy($realPath, $stablePath);
            if ($moved) {
                @unlink($realPath);
            }
        }

        if ($moved) {
            $this->stableFilePath   = $stablePath;
            $this->originalFileName = $originalName;
        }

        try {
            $file->delete();
        } catch (\Exception) {}
    }
}
