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
APP_DIR="$HOME/var/www/vhosts/rophieubaitap123.com"

# Nếu dùng subdomain/addon domain, ví dụ:
# APP_DIR="$HOME/hoclieu.minproducer.com/public_html"

echo ""
echo "🐯 HocLieuTieuHoc — Server Deploy"
echo "=================================="

cd "$APP_DIR"

echo ""
echo "[1/5] Git pull từ GitHub..."
git pull origin master

echo ""
echo "[2/5] Composer install (no dev)..."
php8.2 $(which composer) install --no-dev --optimize-autoloader --no-interaction

echo ""
echo "[3/5] Artisan migrate + cache..."
php8.2 artisan migrate --force
php8.2 artisan config:cache
php8.2 artisan route:cache
php8.2 artisan view:cache
php8.2 artisan storage:link 2>/dev/null || true

echo ""
echo "[4/5] Fix permissions..."
find storage bootstrap/cache -type d -exec chmod 755 {} \;
find storage bootstrap/cache -type f -exec chmod 644 {} \;

echo ""
echo "[5/5] Done! ✅"
echo "=================================="
echo "🌐 https://hoclieu.minproducer.com"
echo ""
