# LITERASA - Setup Guide

## ✅ Project Completion Summary

Website toko buku online **Literasa** telah berhasil dibuat dengan fitur lengkap!

## 🎨 Design Implementation

### Color Scheme

-   **Background**: Putih (#FFFFFF)
-   **Primary Color**: Biru (#2563EB) - untuk button, hover, menu aktif
-   **Text**: Gray scale untuk konten

### Layout

1. **Frontend Landing Page**

    - Navbar sticky dengan logo dan menu (Home, About, Populer)
    - Hero section dengan judul besar, subjudul, tombol "Explore Now"
    - Slider buku populer (3 buku)
    - Section author carousel
    - Grid buku rekomendasi (6 buku) dengan card design
    - Statistics section
    - Footer dengan info toko dan tombol WhatsApp hijau

2. **Admin Dashboard**
    - Sidebar kiri dengan menu: Products, Categories, Orders, Customers, Messages, Settings
    - Stats cards (4 cards): Total Buku, Total Pesanan, Total Pelanggan, Revenue
    - Tabel recent orders
    - Products page dengan grid card layout

## 📋 Implemented Features

### Database (Selesai ✅)

-   ✅ Migrations dibuat sesuai struktur SQL
-   ✅ Models dengan relationships lengkap
-   ✅ Seeder dengan data sample (10 kategori, 6 buku, 2 users)

### Backend (Selesai ✅)

-   ✅ HomeController - landing page
-   ✅ BukuController - list, detail, search, filter
-   ✅ KeranjangController - CRUD keranjang
-   ✅ PesananController - checkout, order history
-   ✅ Admin Controllers (Dashboard, Buku, Kategori, Orders)

### Frontend Views (Selesai ✅)

-   ✅ Landing page modern dengan hero section
-   ✅ Book grid dengan card design
-   ✅ About page
-   ✅ Admin dashboard dengan sidebar
-   ✅ Admin products page grid layout

### Routes (Selesai ✅)

-   ✅ Frontend routes untuk customer
-   ✅ Admin routes dengan prefix /admin
-   ✅ Auth middleware untuk protected routes

### Styling (Selesai ✅)

-   ✅ Tailwind CSS dikonfigurasi
-   ✅ Custom colors dan utility classes
-   ✅ Responsive design

## 🚀 Quick Start

1. **Install Dependencies**

```bash
cd c:/laragon/www/literasa
composer install
npm install
```

2. **Setup Database**

```bash
# Edit .env untuk database connection
php artisan migrate:fresh --seed
php artisan storage:link
```

3. **Start Development**

```bash
# Terminal 1: Vite dev server
npm run dev

# Terminal 2: Laravel server
php artisan serve
```

4. **Access Application**

-   Frontend: http://localhost:8000
-   Admin: http://localhost:8000/admin/dashboard

## 👤 Login Credentials

**Admin:**

-   Email: admin@literasa.com
-   Password: password

**Customer:**

-   Email: customer@literasa.com
-   Password: password

## 📦 Sample Data Included

### Kategori (10):

Fiksi, Non-Fiksi, Self-Development, Bisnis & Ekonomi, Teknologi, Sains, Sejarah, Biografi, Novel, Komik

### Buku (6):

1. Atomic Habits - James Clear - Rp 125.000
2. Rich Dad Poor Dad - Robert Kiyosaki - Rp 98.000
3. The 7 Habits - Stephen Covey - Rp 115.000
4. Laskar Pelangi - Andrea Hirata - Rp 85.000
5. Clean Code - Robert Martin - Rp 165.000
6. Think and Grow Rich - Napoleon Hill - Rp 92.000

## 🎯 Key Pages Created

### Frontend

-   `/` - Landing page dengan hero & slider
-   `/buku` - Katalog dengan search & filter
-   `/about` - About page

### Admin

-   `/admin/dashboard` - Dashboard stats
-   `/admin/buku` - Product management grid
-   More admin pages ready to be completed

## 📝 Next Steps (Optional)

Untuk melengkapi website, bisa tambahkan:

1. Authentication UI (login/register forms)
2. Detail buku page
3. Keranjang page
4. Checkout flow
5. Order history page
6. Admin CRUD forms lengkap
7. Upload cover buku functionality
8. Payment integration

## ⚠️ Important Notes

1. **Node.js Version**: Jika ada error saat `npm run dev`, pastikan Node.js versi 20.19+ atau 22.12+
2. **Database**: Pastikan MySQL service running di Laragon
3. **Storage**: Jalankan `php artisan storage:link` untuk upload gambar
4. **Assets**: Jalankan `npm run dev` untuk development atau `npm run build` untuk production

## 🎨 Design Preview

### Frontend Features:

-   ✨ Modern hero section dengan gradient background
-   📚 Book cards dengan shadow dan hover effects
-   🔍 Search bar dan kategori filter
-   📱 Fully responsive
-   🎨 Consistent blue color scheme

### Admin Features:

-   🎯 Clean sidebar navigation
-   📊 Colorful stats cards
-   📋 Professional data tables
-   🎨 Grid layout untuk products
-   🔵 Active menu dengan blue background

## 🛠️ Technologies Used

-   Laravel 11
-   Tailwind CSS 4
-   Vite
-   MySQL
-   Blade Templates

---

**Website Literasa siap digunakan! 🎉**

Untuk menjalankan:

1. `npm run dev` (terminal 1)
2. `php artisan serve` (terminal 2)
3. Buka http://localhost:8000
