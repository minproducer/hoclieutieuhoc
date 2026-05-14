#!/bin/bash
# =====================================================
# pull.sh — Chạy trên cPanel SSH Terminal sau mỗi lần push
# CÁCH DÙNG: bash ~/pull.sh
#
# Lần đầu: copy file này vào home directory trên cPanel
#   cp /path/to/project/pull.sh ~/pull.sh
#   chmod +x ~/pull.sh
# =====================================================

set -e

# ⚠️  THAY ĐỔI đường dẫn này cho đúng với cPanel của bạn
# Tìm bằng lệnh: pwd (khi đang ở thư mục web)
APP_DIR="/var/www/vhosts/rophieubaitap123.com/httpdocs"

# PHP 8.3 CLI tren Plesk
PHP="/opt/plesk/php/8.3/bin/php"
COMPOSER="/usr/lib/plesk-php83-composer/bin/composer"

echo ""
echo "🐯 HocLieuTieuHoc — Server Deploy"
echo "=================================="

cd "$APP_DIR"

echo ""
echo "[1/5] Git pull từ GitHub..."
git pull origin master

echo ""
echo "[2/5] Composer install (no dev)..."
$PHP $COMPOSER install --no-dev --optimize-autoloader --no-interaction

echo ""
echo "[3/5] Artisan migrate + cache..."
$PHP artisan migrate --force
$PHP artisan config:cache
$PHP artisan route:cache
$PHP artisan view:cache
$PHP artisan storage:link 2>/dev/null || true

echo ""
echo "[4/5] Fix permissions..."
find storage bootstrap/cache -type d -exec chmod 755 {} \;
find storage bootstrap/cache -type f -exec chmod 644 {} \;

echo ""
echo "[5/5] Done! ✅"
echo "=================================="
echo "🌐 https://hoclieu.minproducer.com"
echo ""
