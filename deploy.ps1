# =====================================================
# DEPLOY SCRIPT - HocLieuTieuHoc
# Chạy: .\deploy.ps1
# Hoặc: .\deploy.ps1 -Message "fix: sua loi gi do"
# =====================================================
param(
    [string]$Message = ""
)

$ErrorActionPreference = "Stop"
$ProjectDir = $PSScriptRoot

Set-Location $ProjectDir

Write-Host "`n🐯 HocLieuTieuHoc Deploy" -ForegroundColor Cyan
Write-Host "================================" -ForegroundColor Cyan

# 1. Build assets
Write-Host "`n[1/4] Building assets (npm run build)..." -ForegroundColor Yellow
npm run build
if ($LASTEXITCODE -ne 0) { Write-Host "❌ Build failed!" -ForegroundColor Red; exit 1 }
Write-Host "✅ Build OK" -ForegroundColor Green

# 2. Commit message
if (-not $Message) {
    $timestamp = Get-Date -Format "yyyy-MM-dd HH:mm"
    $Message = "deploy: update $timestamp"
}

# 3. Git add + commit + push
Write-Host "`n[2/4] Git commit: $Message" -ForegroundColor Yellow
git add -A
$changes = git status --porcelain
if (-not $changes) {
    Write-Host "  (Không có thay đổi mới)" -ForegroundColor Gray
} else {
    git commit -m $Message
}

Write-Host "`n[3/4] Pushing to GitHub..." -ForegroundColor Yellow
git push origin master
if ($LASTEXITCODE -ne 0) { Write-Host "❌ Push failed!" -ForegroundColor Red; exit 1 }
Write-Host "✅ Push OK" -ForegroundColor Green

# 4. Hướng dẫn bước cuối
Write-Host "`n[4/4] Vào cPanel SSH Terminal và chạy lệnh sau:" -ForegroundColor Yellow
Write-Host "----------------------------------------" -ForegroundColor DarkGray
Write-Host "  bash ~/pull.sh" -ForegroundColor White -BackgroundColor DarkGreen
Write-Host "----------------------------------------" -ForegroundColor DarkGray

Write-Host "`n✅ Push xong! Giờ vào cPanel SSH chạy lệnh trên là done.`n" -ForegroundColor Green
