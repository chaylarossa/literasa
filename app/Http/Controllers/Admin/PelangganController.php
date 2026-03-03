<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'pelanggan');
        
        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status);
        }
        
        $pelanggan = $query->withCount('pesanan')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.pelanggan.index', compact('pelanggan'));
    }
    
    public function show($id)
    {
        $pelanggan = User::where('role', 'pelanggan')
            ->withCount('pesanan')
            ->findOrFail($id);
        
        $pesanan = Pesanan::where('id_pengguna', $id)
            ->with('items.buku')
            ->orderBy('tanggal_pesanan', 'desc')
            ->paginate(10);
        
        $totalBelanja = Pesanan::where('id_pengguna', $id)
            ->where('status_pesanan', 'selesai')
            ->sum('total_pembayaran');
        
        return view('admin.pelanggan.show', compact('pelanggan', 'pesanan', 'totalBelanja'));
    }
    
    public function toggleStatus($id)
    {
        $pelanggan = User::where('role', 'pelanggan')->findOrFail($id);
        $pelanggan->update([
            'is_active' => !$pelanggan->is_active
        ]);
        
        $status = $pelanggan->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Pelanggan berhasil {$status}");
    }
    
    public function destroy($id)
    {
        $pelanggan = User::where('role', 'pelanggan')->findOrFail($id);
        
        // Check if has orders
        if ($pelanggan->pesanan()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus pelanggan yang memiliki riwayat pesanan');
        }
        
        $pelanggan->delete();
        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus');
    }
}
