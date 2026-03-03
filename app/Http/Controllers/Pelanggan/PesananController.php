<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::where('id_pengguna', Auth::id())
            ->with('items.buku')
            ->orderBy('tanggal_pesanan', 'desc')
            ->paginate(10);
        
        return view('pelanggan.pesanan.index', compact('pesanan'));
    }
    
    public function show($id)
    {
        $pesanan = Pesanan::with('items.buku')
            ->where('id_pengguna', Auth::id())
            ->findOrFail($id);
        
        return view('pelanggan.pesanan.show', compact('pesanan'));
    }
    
    public function checkout()
    {
        $items = Keranjang::with('buku')->where('id_pengguna', Auth::id())->get();
        
        if ($items->count() == 0) {
            return redirect()->route('pelanggan.katalog.index')
                ->with('error', 'Keranjang kosong');
        }
        
        $total = $items->sum(function($item) {
            return $item->buku->harga * $item->jumlah;
        });
        
        return view('pelanggan.pesanan.checkout', compact('items', 'total'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
            'ekspedisi' => 'required|string|max:50',
            'ongkir' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:transfer,ewallet,qris'
        ]);
        
        $items = Keranjang::with('buku')
            ->where('id_pengguna', Auth::id())
            ->get();
        
        if ($items->count() == 0) {
            return redirect()->route('pelanggan.katalog.index')
                ->with('error', 'Keranjang kosong');
        }
        
        // Check stock availability
        foreach ($items as $item) {
            if ($item->buku->stok < $item->jumlah) {
                return back()->with('error', 'Stok buku ' . $item->buku->judul . ' tidak mencukupi');
            }
        }
        
        $totalProduk = $items->sum(function($item) {
            return $item->buku->harga * $item->jumlah;
        });
        
        DB::beginTransaction();
        try {
            // Create order
            $pesanan = Pesanan::create([
                'id_pengguna' => Auth::id(),
                'nama_penerima' => $request->nama_penerima,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'kode_pos' => $request->kode_pos,
                'ekspedisi' => $request->ekspedisi,
                'ongkir' => $request->ongkir,
                'total_produk' => $totalProduk,
                'total_pembayaran' => $totalProduk + $request->ongkir,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pesanan' => 'menunggu_konfirmasi',
            ]);
            
            // Create order items and update stock
            foreach ($items as $item) {
                PesananItem::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_buku' => $item->id_buku,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->buku->harga
                ]);
                
                // Update stock
                $item->buku->decrement('stok', $item->jumlah);
            }
            
            // Clear cart
            Keranjang::where('id_pengguna', Auth::id())->delete();
            
            DB::commit();
            
            return redirect()->route('pelanggan.pesanan.invoice', $pesanan->id_pesanan)
                ->with('success', 'Pesanan berhasil dibuat');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function invoice($id)
    {
        $pesanan = Pesanan::with('items.buku', 'user')
            ->where('id_pengguna', Auth::id())
            ->findOrFail($id);
        
        return view('pelanggan.pesanan.invoice', compact('pesanan'));
    }
}
