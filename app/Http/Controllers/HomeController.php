<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $bukuPopuler = Buku::where('is_active', true)
            ->orderBy('id_buku', 'desc')
            ->take(6)
            ->get();
            
        return view('home', compact('bukuPopuler'));
    }

    public function about()
    {
        return view('about');
    }
}
