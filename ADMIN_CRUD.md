# Admin CRUD Buku - Literasa

## Fitur yang Sudah Diimplementasi

### 1. **Daftar Buku (Index)**

-   URL: `/admin/buku`
-   Menampilkan semua buku dalam grid layout
-   Informasi: Cover, Judul, Pengarang, Harga, Stok, Kategori, Status
-   Tombol aksi: Edit dan Hapus
-   Pesan sukses setelah operasi CRUD

### 2. **Tambah Buku (Create)**

-   URL: `/admin/buku/create`
-   Form input lengkap:
    -   Judul Buku (required)
    -   ISBN (required, unique)
    -   Kategori (required, dropdown)
    -   Pengarang
    -   Penerbit
    -   Harga (required, numeric)
    -   Stok (required, integer)
    -   Cover (image, max 2MB)
    -   Deskripsi (textarea)
    -   Status Aktif (checkbox)
-   Validasi error ditampilkan per field
-   Upload gambar cover

### 3. **Edit Buku (Edit)**

-   URL: `/admin/buku/{id}/edit`
-   Form pre-filled dengan data buku
-   Preview cover yang sudah ada
-   Opsi untuk mengganti cover atau tidak
-   Validasi yang sama dengan create

### 4. **Hapus Buku (Delete)**

-   Konfirmasi JavaScript sebelum delete
-   Hapus file cover dari storage jika ada
-   Redirect dengan pesan sukses

## Validasi

-   **Judul**: Required, max 150 karakter
-   **ISBN**: Required, unique
-   **Kategori**: Required
-   **Harga**: Required, numeric, min 0
-   **Stok**: Required, integer, min 0
-   **Cover**: Optional, harus image (jpg/png), max 2MB

## Upload File

-   Folder: `storage/app/public/covers/`
-   Public access: `public/storage/covers/`
-   Symlink: `php artisan storage:link` (sudah dibuat)

## Pesan Flash

-   Success message ditampilkan setelah:
    -   Buku berhasil ditambahkan
    -   Buku berhasil diupdate
    -   Buku berhasil dihapus

## Controller Methods

File: `app/Http/Controllers/Admin/AdminBukuController.php`

-   `index()`: Menampilkan daftar buku dengan pagination
-   `create()`: Menampilkan form tambah buku
-   `store()`: Menyimpan buku baru
-   `edit($id)`: Menampilkan form edit buku
-   `update($id)`: Update data buku
-   `destroy($id)`: Hapus buku dan covernya

## Routes

File: `routes/web.php`

```php
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('buku', AdminBukuController::class);
});
```

## Testing

1. Login sebagai admin: `admin@literasa.com` / `password`
2. Akses: `http://127.0.0.1:8000/admin/buku`
3. Test semua operasi CRUD
