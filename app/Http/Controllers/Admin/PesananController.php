<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $pesanan = Pesanan::with('user')
            ->when($status, fn ($query) => $query->where('status_pesanan', $status))
            ->orderBy('tanggal_pesanan', 'desc')
            ->paginate(20)
            ->withQueryString();
        
        return view('admin.pesanan.index', compact('pesanan'));
    }
    
    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'items.buku'])
            ->findOrFail($id);
        
        return view('admin.pesanan.show', compact('pesanan'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:menunggu_konfirmasi,diproses,dikirim,selesai,dibatalkan'
        ]);
        
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'status_pesanan' => $request->status_pesanan
        ]);
        
        return back()->with('success', 'Status pesanan berhasil diupdate');
    }
}
