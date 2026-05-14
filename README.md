# HocLieu — Vietnamese Educational Document Library

Laravel 11 + Filament v3 application for sharing educational documents.

---

## Requirements

- PHP 8.2+ with extensions: pdo_mysql, mbstring, json, xml, curl, zip, gd
- MySQL 8.0+
- Composer (for local setup before uploading to cPanel)

---

## Local Setup (Run Once Before Uploading)

```bash
# 1. Install dependencies
composer install --no-dev --optimize-autoloader

# 2. Copy environment file
cp .env.example .env

# 3. Generate application key
php artisan key:generate

# 4. Run migrations and seed
php artisan migrate --seed

# 5. Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## cPanel Shared Hosting Deployment

### Step 1 — Upload Files

Upload the entire project to your hosting, e.g.:

```
/home/username/hoclieu/          ← Laravel root (NOT public_html)
/home/username/public_html/      ← or addon domain root
```

If using an addon domain, point its document root to:

```
/home/username/hoclieu/public/
```

Alternatively, upload to `public_html/hoclieu/` and the root `.htaccess`
will rewrite all traffic to `/public/`.

### Step 2 — Create MySQL Database

In cPanel > MySQL Databases:

1. Create database: `hoclieu_db`
2. Create user: `hoclieu_user` with a strong password
3. Add user to database with ALL PRIVILEGES

### Step 3 — Configure Environment

Copy `.env.example` to `.env` and fill in:

```env
APP_NAME=HocLieu
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
APP_KEY=                    # Generate with: php artisan key:generate

DB_HOST=127.0.0.1
DB_DATABASE=hoclieu_db
DB_USERNAME=hoclieu_user
DB_PASSWORD=your_password
```

### Step 4 — Run Migrations

**Option A** — cPanel Terminal (if available):

```bash
cd /home/username/hoclieu
php artisan migrate --seed
php artisan key:generate
```

**Option B** — phpMyAdmin:
Run each migration SQL file in order from `database/migrations/`.

**Option C** — PHP script (one-time, delete after use):
Create `public/setup.php`:

```php
<?php require '../vendor/autoload.php';
$app = require '../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->call('migrate', ['--seed' => true, '--force' => true]);
echo "Done!";
```

Visit `https://yourdomain.com/setup.php` then delete the file.

### Step 5 — File Permissions

```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### Step 6 — Configure Google Drive (via Admin Panel)

1. Go to `https://yourdomain.com/admin`
2. Login with: `admin@hoclieu.vn` / `Admin@123`  
   **(Change password immediately!)**
3. Go to Settings → enter Google OAuth Client ID and Secret
4. Click "Kết nối Google Drive" to authorize
5. The refresh token will be saved automatically

### Step 7 — Google API Console Setup

1. Go to https://console.cloud.google.com
2. Create a project → Enable Google Drive API
3. Create OAuth 2.0 credentials (Web application type)
4. Add authorized redirect URI:  
   `https://yourdomain.com/admin/drive/callback`
5. Copy Client ID and Client Secret to Settings page

---

## Admin Panel

URL: `https://yourdomain.com/admin`

Default credentials:

- Email: `admin@hoclieu.vn`
- Password: `Admin@123`

**Change the password immediately after first login!**

---

## File Structure

```
hoclieu/
├── app/
│   ├── Filament/          # Admin panel resources, pages, widgets
│   ├── Http/Controllers/  # Frontend controllers
│   ├── Models/            # Eloquent models
│   ├── Providers/         # Service providers
│   └── Services/          # GoogleDriveService
├── bootstrap/             # Laravel bootstrap
├── config/                # Configuration files
├── database/
│   ├── migrations/        # Database migrations
│   └── seeders/           # Database seeders
├── public/                # Document root (point server here)
│   └── index.php
├── resources/views/       # Blade templates
├── routes/web.php         # Application routes
└── vendor/                # Composer dependencies (run composer install)
```

---

## Notes for Shared Hosting

- **No symlink needed**: Documents are stored on Google Drive, not local storage
- **Session driver**: File-based (works without Redis)
- **Cache driver**: File-based (works without Redis)
- **Queue driver**: Sync (no worker needed)
- **Filament assets**: Run `php artisan filament:assets` if admin panel CSS/JS doesn't load,
  or ensure `vendor/filament` assets are published to `public/`

### Publishing Filament Assets (if needed)

```bash
php artisan filament:assets
# or
php artisan vendor:publish --tag=filament-assets
```

---

## Troubleshooting

**500 Error**: Check `storage/logs/laravel.log`. Usually missing APP_KEY or wrong DB credentials.

**Admin 404**: Ensure `public/.htaccess` is present and mod_rewrite is enabled.

**Google Drive Upload Fails**: Verify OAuth is connected in Settings page.

**Fulltext Search**: Requires MySQL InnoDB with FULLTEXT support (MySQL 5.6+). Short queries (<3 chars) fall back to LIKE search.
