<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\Keranjang;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::where('id_pengguna', Auth::id())
            ->orderBy('tanggal_pesanan', 'desc')
            ->get();
            
        return view('pesanan.index', compact('pesanan'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with('items.buku')
            ->where('id_pengguna', Auth::id())
            ->where('id_pesanan', $id)
            ->firstOrFail();
            
        return view('pesanan.show', compact('pesanan'));
    }

    public function checkout()
    {
        $keranjang = Keranjang::where('id_pengguna', Auth::id())
            ->with('buku')
            ->get();
            
        if ($keranjang->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong');
        }
        
        $total = $keranjang->sum(function($item) {
            return $item->buku->harga * $item->jumlah;
        });
        
        return view('pesanan.checkout', compact('keranjang', 'total'));
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
            'metode_pembayaran' => 'required|string'
        ]);

        DB::beginTransaction();
        try {
            $keranjang = Keranjang::where('id_pengguna', Auth::id())->with('buku')->get();
            
            $totalProduk = $keranjang->sum(function($item) {
                return $item->buku->harga * $item->jumlah;
            });
            
            $ongkir = $request->ongkir ?? 0;
            $totalPembayaran = $totalProduk + $ongkir;

            $pesanan = Pesanan::create([
                'id_pengguna' => Auth::id(),
                'nama_penerima' => $request->nama_penerima,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'kode_pos' => $request->kode_pos,
                'ekspedisi' => $request->ekspedisi,
                'ongkir' => $ongkir,
                'total_produk' => $totalProduk,
                'total_pembayaran' => $totalPembayaran,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pesanan' => 'menunggu_konfirmasi'
            ]);

            foreach ($keranjang as $item) {
                PesananItem::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_buku' => $item->id_buku,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->buku->harga
                ]);
                
                // Update stok
                $buku = Buku::find($item->id_buku);
                $buku->stok -= $item->jumlah;
                $buku->save();
            }

            // Clear keranjang
            Keranjang::where('id_pengguna', Auth::id())->delete();

            DB::commit();
            
            return redirect()->route('pesanan.show', $pesanan->id_pesanan)
                ->with('success', 'Pesanan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
