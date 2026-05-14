<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\GoogleDriveService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DriveController extends Controller
{
    public function __construct(private GoogleDriveService $driveService)
    {
    }

    public function auth(): RedirectResponse
    {
        $redirectUri = route('admin.drive.callback');
        $authUrl = $this->driveService->getOAuthUrl($redirectUri);

        return redirect()->away($authUrl);
    }

    public function callback(Request $request): RedirectResponse
    {
        $code = $request->input('code');

        if (! $code) {
            return redirect()->route('filament.admin.pages.settings-page')
                ->with('error', 'Google OAuth bị huỷ hoặc lỗi.');
        }

        try {
            $redirectUri = route('admin.drive.callback');
            $tokens = $this->driveService->exchangeCodeForTokens($code, $redirectUri);

            if (empty($tokens['refresh_token'])) {
                return redirect()->route('filament.admin.pages.settings-page')
                    ->with('error', 'Không nhận được refresh token từ Google. Hãy thu hồi quyền truy cập tại myaccount.google.com/permissions rồi thử lại.');
            }

            Setting::set('google_oauth_refresh_token', $tokens['refresh_token']);

            return redirect()->route('filament.admin.pages.settings-page')
                ->with('success', 'Kết nối Google Drive thành công!');
        } catch (\Exception $e) {
            return redirect()->route('filament.admin.pages.settings-page')
                ->with('error', 'Lỗi kết nối: ' . $e->getMessage());
        }
    }
}
