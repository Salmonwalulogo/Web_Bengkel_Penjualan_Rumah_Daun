# Web Bengkel

Aplikasi manajemen bengkel berbasis Laravel untuk customer, admin, mekanik, dan kasir.

## Struktur Kode

- `app/`, `routes/`, dan `database/`: backend Laravel, aturan bisnis, API web, dan database.
- `resources/views/frontend/`: halaman publik (`home`, `pages`, dan `public`).
- `resources/views/backend/`: dashboard dan halaman internal role (`admin`, `customer`, `cashier`, `mechanic`, `cart`, dan `profile`).
- `resources/views/auth/`, `resources/views/components/`, dan `resources/views/layouts/guest.blade.php`: view shared untuk autentikasi.
- `resources/css/frontend/frontend.css`: asset dasar halaman publik dan pengunjung.
- `resources/css/backend/backend.css`: asset dasar dashboard dan halaman internal role.
- `resources/css/auth.css`: asset login, register, reset password, dan verifikasi email.
- `resources/css/app.css`: asset Laravel/Tailwind umum.
- `resources/js/`: JavaScript frontend bersama dan Alpine.
- `public/build/`: hasil build Vite, dibuat saat deployment dan tidak diedit manual.

Saat menambah tampilan baru, letakkan aturan CSS di file area yang sesuai. Blade sebaiknya berisi struktur HTML, data, dan class, bukan blok CSS panjang.

## Kebutuhan Server

- PHP 8.2 atau lebih baru dengan extension Laravel standar
- MySQL 8+ atau MariaDB yang kompatibel
- Composer 2+
- Node.js 20+ dan npm
- Web server mengarah ke folder `public`, bukan root project

## Menjalankan Lokal

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan storage:link
php artisan serve
```

Isi koneksi database pada `.env` sebelum menjalankan migration.

## Deployment Production

1. Upload source code tanpa folder `vendor` dan `node_modules` bila server menyediakan Composer/Node.
2. Buat `.env` dari `.env.example`, lalu isi nilai nyata:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com
APP_KEY=base64:...

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=...
MAIL_FROM_NAME="Web Bengkel"

SESSION_SECURE_COOKIE=true
```

3. Jalankan perintah release:

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link
npm ci
npm run build
php artisan optimize
```

4. Atur document root virtual host ke `public/` dan aktifkan HTTPS.
5. Pastikan user web server dapat menulis ke `storage/` dan `bootstrap/cache/`.

## Worker Dan Scheduler

Jika queue database digunakan, jalankan worker sebagai service supervisor/systemd:

```bash
php artisan queue:work --sleep=3 --tries=3 --timeout=90
```

Tambahkan scheduler Laravel setiap menit pada cron:

```cron
* * * * * cd /path/ke/project && php artisan schedule:run >> /dev/null 2>&1
```

## Keamanan

- Jangan commit `.env`, password database, atau credential SMTP.
- Gunakan `APP_DEBUG=false` di production.
- Gunakan HTTPS dan cookie secure pada domain production.
- Jalankan backup database terjadwal dan uji restore secara berkala.
- Batasi akses database hanya dari host aplikasi.
- Pantau `storage/logs` dan kegagalan queue tanpa menampilkan detail error ke pengguna.
- Setelah mengubah environment, jalankan `php artisan optimize:clear` lalu `php artisan optimize`.

## Pemeriksaan Sebelum Release

```bash
composer validate --strict
composer audit --no-interaction
php artisan test
php artisan route:list --except-vendor
php artisan view:cache
php artisan migrate:status
```

Build dan test yang berhasil tidak menggantikan konfigurasi HTTPS, SMTP, firewall, backup, dan monitoring pada server production.
