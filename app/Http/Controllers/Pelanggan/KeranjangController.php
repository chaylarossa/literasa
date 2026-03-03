<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $items = Keranjang::with('buku')->where('id_pengguna', Auth::id())->get();
        $total = $items->sum(function($item) {
            return $item->buku->harga * $item->jumlah;
        });
        
        return view('pelanggan.keranjang.index', compact('items', 'total'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:buku,id_buku',
            'jumlah' => 'required|integer|min:1'
        ]);
        
        $buku = Buku::findOrFail($request->id_buku);
        
        if ($buku->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi');
        }
        
        $item = Keranjang::where('id_pengguna', Auth::id())
            ->where('id_buku', $request->id_buku)
            ->first();
        
        if ($item) {
            $newJumlah = $item->jumlah + $request->jumlah;
            
            if ($buku->stok < $newJumlah) {
                return back()->with('error', 'Stok tidak mencukupi');
            }
            
            $item->jumlah = $newJumlah;
            $item->save();
        } else {
            Keranjang::create([
                'id_pengguna' => Auth::id(),
                'id_buku' => $request->id_buku,
                'jumlah' => $request->jumlah
            ]);
        }
        
        return back()->with('success', 'Buku berhasil ditambahkan ke keranjang');
    }
    
    public function update(Request $request, $id)
    {
        $item = Keranjang::findOrFail($id);
        
        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);
        
        if ($item->buku->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi');
        }
        
        $item->jumlah = $request->jumlah;
        $item->save();
        
        return back()->with('success', 'Keranjang berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $item = Keranjang::findOrFail($id);
        $item->delete();
        
        return back()->with('success', 'Item berhasil dihapus dari keranjang');
    }
    
    public function count()
    {
        $count = Keranjang::where('id_pengguna', Auth::id())->count();
        
        return response()->json(['count' => $count]);
    }
}
