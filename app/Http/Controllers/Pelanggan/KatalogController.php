<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori')->where('is_active', true);
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('pengarang', 'like', '%' . $search . '%')
                  ->orWhere('isbn', 'like', '%' . $search . '%');
            });
        }
        
        // Filter by category
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('id_kategori', $request->kategori);
        }
        
        // Sorting
        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'termurah':
                $query->orderBy('harga', 'asc');
                break;
            case 'termahal':
                $query->orderBy('harga', 'desc');
                break;
            case 'terpopuler':
                $query->orderBy('stok', 'desc');
                break;
            default:
                $query->orderBy('id_buku', 'desc');
        }
        
        $buku = $query->paginate(12);
        $kategori = KategoriBuku::all();
        
        return view('pelanggan.katalog.index', compact('buku', 'kategori'));
    }
    
    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        $relatedBooks = Buku::where('id_kategori', $buku->id_kategori)
            ->where('id_buku', '!=', $id)
            ->where('is_active', true)
            ->take(4)
            ->get();
        
        return view('pelanggan.katalog.show', compact('buku', 'relatedBooks'));
    }
}
