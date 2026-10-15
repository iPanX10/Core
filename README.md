# CORE — Computer Hardware Store

CORE adalah aplikasi e-commerce berbasis web yang dikembangkan menggunakan Laravel untuk penjualan komponen dan perangkat keras komputer, seperti RAM, CPU, VGA, motherboard, dan komponen lainnya.

## Teknologi yang Digunakan

- PHP
- Laravel
- MySQL
- HTML, CSS, dan JavaScript
- Git dan GitHub
- XAMPP

## Persyaratan

Pastikan perangkat sudah memiliki:
- Git
- PHP dengan versi yang kompatibel dengan project
- Composer
- MySQL atau XAMPP

## Instalasi Project

### 1. Clone Repository

```bash
git clone https://github.com/USERNAME/CORE.git
```

### 2. Masuk ke Direktori Project

```bash
cd CORE
```

### 3. Install Dependency

```bash
composer install
```

### 4. Konfigurasi Environment

Salin file konfigurasi:

```bash
copy .env.example .env
```

Kemudian sesuaikan pengaturan database pada file `.env`.

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Buat Database

Buat database MySQL dengan nama `core`, atau gunakan nama lain sesuai konfigurasi `.env`.

Contoh konfigurasi:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=core
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan username dan password dengan konfigurasi MySQL masing-masing.

### 7. Jalankan Migrasi dan Seeder

```bash
php artisan migrate --seed
```

Perintah ini membuat tabel database dan mengisi data awal yang disediakan oleh seeder.

### 8. Jalankan Aplikasi

```bash
php artisan serve
```

Buka `http://127.0.0.1:8000` di browser.

## Catatan

- File `.env` bersifat lokal dan tidak perlu diunggah ke repository.
- Jangan mengunggah password, API key, atau informasi rahasia lainnya.
- Pastikan MySQL berjalan sebelum menjalankan migrasi.
- Jika terdapat perubahan dependency, jalankan `composer install` kembali.
- Setiap anggota tim menggunakan konfigurasi database lokal masing-masing.

## Kontribusi

1. Clone repository.
2. Buat branch baru untuk fitur atau perbaikan.
3. Lakukan perubahan dan pengujian.
4. Commit perubahan.
5. Push branch ke GitHub dan ajukan Pull Request jika diperlukan.

Contoh:

```bash
git checkout -b fitur-nama-fitur
git add .
git commit -m "Menambahkan fitur baru"
git push origin fitur-nama-fitur
```
---

**CORE — Computer Hardware Store**
