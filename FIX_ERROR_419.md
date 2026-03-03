# Cara Mengatasi Error 419 Page Expired

## Sudah Diperbaiki:

1. ✅ Session driver diubah dari `database` ke `file` (lebih stabil)
2. ✅ Config cache sudah di-clear
3. ✅ Application cache sudah di-clear
4. ✅ View cache sudah di-clear

## Langkah untuk User:

### 1. Clear Browser Cache & Cookies

**Chrome/Edge:**

-   Tekan `Ctrl + Shift + Delete`
-   Pilih "Cookies and other site data"
-   Pilih "Cached images and files"
-   Klik "Clear data"

**Firefox:**

-   Tekan `Ctrl + Shift + Delete`
-   Centang "Cookies" dan "Cache"
-   Klik "Clear Now"

### 2. Hard Refresh Browser

-   Tekan `Ctrl + Shift + R` (atau `Ctrl + F5`)
-   Atau buka Incognito/Private mode

### 3. Test Login

1. Buka: `http://127.0.0.1:8000/login`
2. Login dengan credentials:
    - **Pelanggan**: email yang didaftarkan / password
    - **Admin**: admin@literasa.com / password

### 4. Jika Masih Error

Jalankan command berikut di terminal:

```bash
cd /c/laragon/www/literasa
php artisan optimize:clear
php artisan config:cache
```

## Penyebab Error 419:

-   CSRF token expired karena session tidak tersimpan dengan benar
-   Browser cache yang lama
-   Session driver database yang tidak ter-setup dengan baik

## Solusi yang Diterapkan:

-   Mengubah SESSION_DRIVER dari `database` ke `file` di file `.env`
-   File session akan disimpan di `storage/framework/sessions/`
-   Lebih reliable dan tidak perlu database table
