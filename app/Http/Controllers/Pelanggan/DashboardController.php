<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalPesanan = Pesanan::where('id_pengguna', $user->id_pengguna)->count();
        $pesananProses = Pesanan::where('id_pengguna', $user->id_pengguna)
            ->whereIn('status_pesanan', ['menunggu_konfirmasi', 'diproses', 'dikirim'])->count();
        $pesananSelesai = Pesanan::where('id_pengguna', $user->id_pengguna)
            ->where('status_pesanan', 'selesai')->count();
        
        $recentOrders = Pesanan::where('id_pengguna', $user->id_pengguna)
            ->with('items.buku')
            ->orderBy('tanggal_pesanan', 'desc')
            ->take(5)
            ->get();
        
        return view('pelanggan.dashboard', compact('totalPesanan', 'pesananProses', 'pesananSelesai', 'recentOrders'));
    }
}
