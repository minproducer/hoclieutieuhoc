<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Google Drive Connection Status --}}
        <x-filament::section>
            <x-slot name="heading">Trạng thái kết nối Google Drive</x-slot>

            <div class="flex items-center justify-between">
                @if ($this->isGoogleDriveConnected())
                    <div class="flex items-center gap-3">
                        <div class="h-3 w-3 rounded-full bg-green-500"></div>
                        <span class="text-green-600 dark:text-green-400 font-medium">Đã kết nối Google Drive</span>
                    </div>
                    <x-filament::button
                        wire:click="disconnectGoogleDrive"
                        color="danger"
                        size="sm"
                    >
                        Ngắt kết nối
                    </x-filament::button>
                @else
                    <div class="flex items-center gap-3">
                        <div class="h-3 w-3 rounded-full bg-red-500"></div>
                        <span class="text-red-600 dark:text-red-400 font-medium">Chưa kết nối Google Drive</span>
                    </div>
                    <a href="{{ route('admin.drive.auth') }}"
                       class="fi-btn fi-btn-size-sm inline-grid grid-flow-col items-center justify-center gap-1.5 rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Kết nối Google Drive
                    </a>
                @endif
            </div>
        </x-filament::section>

        {{-- Settings Form --}}
        <x-filament-panels::form wire:submit="save">
            {{ $this->form }}

            <div class="fi-form-actions">
                <x-filament::button type="submit">
                    Lưu cài đặt
                </x-filament::button>
            </div>
        </x-filament-panels::form>
    </div>
</x-filament-panels::page>
