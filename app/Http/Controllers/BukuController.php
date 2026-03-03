<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::where('is_active', true)->with('kategori');
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%");
            });
        }
        
        // Filter by category
        if ($request->has('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }
        
        $buku = $query->paginate(12);
        $kategori = KategoriBuku::all();
        
        return view('buku.index', compact('buku', 'kategori'));
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        $relatedBooks = Buku::where('id_kategori', $buku->id_kategori)
            ->where('id_buku', '!=', $id)
            ->where('is_active', true)
            ->take(4)
            ->get();
            
        return view('buku.show', compact('buku', 'relatedBooks'));
    }

    public function populer()
    {
        $bukuPopuler = Buku::where('is_active', true)
            ->with('kategori')
            ->orderBy('id_buku', 'desc')
            ->paginate(12);
            
        return view('buku.populer', compact('bukuPopuler'));
    }
}
