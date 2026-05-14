#!/bin/bash
# =====================================================
# setup-cpanel.sh — Chạy MỘT LẦN DUY NHẤT trên cPanel SSH
# để clone repo và setup Laravel lần đầu
#
# CÁCH DÙNG trên cPanel SSH Terminal:
#   bash <(curl -s https://raw.githubusercontent.com/minproducer/hoclieutieuhoc/master/setup-cpanel.sh)
# =====================================================

set -e

GITHUB_REPO="https://github.com/minproducer/hoclieutieuhoc.git"

echo ""
echo "🐯 HocLieuTieuHoc — First-time Setup"
echo "======================================"

# Tự detect thư mục web
if [ -d "$HOME/public_html" ]; then
    APP_DIR="$HOME/public_html"
elif [ -d "$HOME/www" ]; then
    APP_DIR="$HOME/www"
else
    echo "Nhập đường dẫn thư mục web (VD: /home/username/public_html):"
    read APP_DIR
fi

echo "📁 App directory: $APP_DIR"

# Backup nếu đã có file
if [ "$(ls -A $APP_DIR 2>/dev/null)" ]; then
    echo "⚠️  Thư mục không trống. Backup vào ${APP_DIR}_backup..."
    mv "$APP_DIR" "${APP_DIR}_backup_$(date +%Y%m%d%H%M%S)"
    mkdir -p "$APP_DIR"
fi

echo ""
echo "[1/6] Clone từ GitHub..."
git clone "$GITHUB_REPO" "$APP_DIR"
cd "$APP_DIR"

echo ""
echo "[2/6] Composer install..."
php8.2 $(which composer) install --no-dev --optimize-autoloader --no-interaction

echo ""
echo "[3/6] Setup .env..."
if [ ! -f ".env" ]; then
    cp .env.example .env
    php8.2 artisan key:generate
    echo ""
    echo "⚠️  Chưa có .env — Đã tạo từ .env.example và generate APP_KEY"
    echo "    👉 Hãy chỉnh sửa .env (DB, MAIL, GOOGLE...) rồi chạy lại:"
    echo "    php8.2 artisan migrate --force"
    echo ""
else
    echo "   .env đã tồn tại, giữ nguyên."
fi

echo ""
echo "[4/6] Storage link + permissions..."
php8.2 artisan storage:link 2>/dev/null || true
find storage bootstrap/cache -type d -exec chmod 755 {} \;
find storage bootstrap/cache -type f -exec chmod 644 {} \;

echo ""
echo "[5/6] Cache..."
php8.2 artisan config:cache
php8.2 artisan route:cache
php8.2 artisan view:cache

echo ""
echo "[6/6] Copy pull.sh về home..."
cp pull.sh ~/pull.sh
chmod +x ~/pull.sh
echo "   pull.sh đã sẵn sàng: bash ~/pull.sh"

echo ""
echo "✅ Setup xong!"
echo "======================================"
echo ""
echo "📋 VIỆC CẦN LÀM:"
echo "   1. Sửa .env: nano $APP_DIR/.env"
echo "   2. Chạy migrate: cd $APP_DIR && php8.2 artisan migrate --force"
echo "   3. Lần sau deploy: bash ~/pull.sh"
echo ""
