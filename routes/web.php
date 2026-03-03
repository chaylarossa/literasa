<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminBukuController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Admin\PelangganController as AdminPelangganController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;
use App\Http\Controllers\Pelanggan\KatalogController;
use App\Http\Controllers\Pelanggan\KeranjangController as PelangganKeranjangController;
use App\Http\Controllers\Pelanggan\PesananController as PelangganPesananController;
use App\Http\Controllers\Pelanggan\ProfileController as PelangganProfileController;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/populer', [BukuController::class, 'populer'])->name('populer');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Buku Routes
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');

// Keranjang Routes
Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/add', [KeranjangController::class, 'add'])->name('keranjang.add');
    Route::put('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    
    // Pesanan Routes
    Route::get('/checkout', [PesananController::class, 'checkout'])->name('checkout');
    Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
});

// Pelanggan Dashboard Routes
Route::prefix('pelanggan')->middleware('auth')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');
    
    // Katalog
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
    Route::get('/katalog/{id}', [KatalogController::class, 'show'])->name('katalog.show');
    
    // Keranjang
    Route::get('/keranjang', [PelangganKeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/add', [PelangganKeranjangController::class, 'add'])->name('keranjang.add');
    Route::put('/keranjang/{id}', [PelangganKeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [PelangganKeranjangController::class, 'destroy'])->name('keranjang.destroy');
    Route::get('/keranjang/count', [PelangganKeranjangController::class, 'count'])->name('keranjang.count');
    
    // Pesanan
    Route::get('/pesanan', [PelangganPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/checkout', [PelangganPesananController::class, 'checkout'])->name('pesanan.checkout');
    Route::post('/pesanan', [PelangganPesananController::class, 'store'])->name('pesanan.store');
    Route::get('/pesanan/{id}', [PelangganPesananController::class, 'show'])->name('pesanan.show');
    Route::get('/pesanan/{id}/invoice', [PelangganPesananController::class, 'invoice'])->name('pesanan.invoice');
    
    // Profile
    Route::get('/profile', [PelangganProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [PelangganProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [PelangganProfileController::class, 'updatePassword'])->name('profile.password');
});

// Admin Routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Buku Management
    Route::get('/buku', [AdminBukuController::class, 'index'])->name('admin.buku.index');
    Route::get('/buku/create', [AdminBukuController::class, 'create'])->name('admin.buku.create');
    Route::post('/buku', [AdminBukuController::class, 'store'])->name('admin.buku.store');
    Route::get('/buku/{id}/edit', [AdminBukuController::class, 'edit'])->name('admin.buku.edit');
    Route::put('/buku/{id}', [AdminBukuController::class, 'update'])->name('admin.buku.update');
    Route::delete('/buku/{id}', [AdminBukuController::class, 'destroy'])->name('admin.buku.destroy');
    
    // Kategori Management
    Route::get('/kategori', [AdminKategoriController::class, 'index'])->name('admin.kategori.index');
    Route::get('/kategori/create', [AdminKategoriController::class, 'create'])->name('admin.kategori.create');
    Route::post('/kategori', [AdminKategoriController::class, 'store'])->name('admin.kategori.store');
    Route::get('/kategori/{id}/edit', [AdminKategoriController::class, 'edit'])->name('admin.kategori.edit');
    Route::put('/kategori/{id}', [AdminKategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/kategori/{id}', [AdminKategoriController::class, 'destroy'])->name('admin.kategori.destroy');
    
    // Order Management
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    
    // Pesanan Management
    Route::get('/pesanan', [AdminPesananController::class, 'index'])->name('admin.pesanan.index');
    Route::get('/pesanan/{id}', [AdminPesananController::class, 'show'])->name('admin.pesanan.show');
    Route::put('/pesanan/{id}/status', [AdminPesananController::class, 'updateStatus'])->name('admin.pesanan.updateStatus');
    
    // Pelanggan Management
    Route::get('/pelanggan', [AdminPelangganController::class, 'index'])->name('admin.pelanggan.index');
    Route::get('/pelanggan/{id}', [AdminPelangganController::class, 'show'])->name('admin.pelanggan.show');
    Route::put('/pelanggan/{id}/toggle-status', [AdminPelangganController::class, 'toggleStatus'])->name('admin.pelanggan.toggleStatus');
    Route::delete('/pelanggan/{id}', [AdminPelangganController::class, 'destroy'])->name('admin.pelanggan.destroy');
    
    // Profile Management
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.password');
});
