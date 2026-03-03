<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalPesanan = Pesanan::count();
        $totalPelanggan = User::where('role', 'pelanggan')->count();
        $totalKategori = KategoriBuku::count();
        
        $pesananBaru = Pesanan::where('status_pesanan', 'menunggu_konfirmasi')->count();
        $totalPendapatan = Pesanan::where('status_pesanan', 'selesai')->sum('total_pembayaran');
        
        $recentOrders = Pesanan::with('user')
            ->orderBy('tanggal_pesanan', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalBuku',
            'totalPesanan',
            'totalPelanggan',
            'totalKategori',
            'pesananBaru',
            'totalPendapatan',
            'recentOrders'
        ));
    }
}
