<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = Keranjang::where('id_pengguna', Auth::id())
            ->with('buku')
            ->get();
            
        $total = $keranjang->sum(function($item) {
            return $item->buku->harga * $item->jumlah;
        });
        
        return view('keranjang.index', compact('keranjang', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:buku,id_buku',
            'jumlah' => 'required|integer|min:1'
        ]);

        $existing = Keranjang::where('id_pengguna', Auth::id())
            ->where('id_buku', $request->id_buku)
            ->first();

        if ($existing) {
            $existing->jumlah += $request->jumlah;
            $existing->save();
        } else {
            Keranjang::create([
                'id_pengguna' => Auth::id(),
                'id_buku' => $request->id_buku,
                'jumlah' => $request->jumlah
            ]);
        }

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke keranjang');
    }

    public function update(Request $request, $id)
    {
        $keranjang = Keranjang::where('id_pengguna', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
            
        $keranjang->jumlah = $request->jumlah;
        $keranjang->save();
        
        return redirect()->back()->with('success', 'Keranjang berhasil diupdate');
    }

    public function destroy($id)
    {
        Keranjang::where('id_pengguna', Auth::id())
            ->where('id', $id)
            ->delete();
            
        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang');
    }
}
