<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::with('user');
        
        if ($request->has('status')) {
            $query->where('status_pesanan', $request->status);
        }
        
        $orders = $query->orderBy('tanggal_pesanan', 'desc')->paginate(20);
        
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Pesanan::with(['user', 'items.buku'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:menunggu_konfirmasi,diproses,dikirim,selesai,dibatalkan'
        ]);

        $order = Pesanan::findOrFail($id);
        $order->status_pesanan = $request->status_pesanan;
        $order->save();

        return redirect()->back()
            ->with('success', 'Status pesanan berhasil diupdate');
    }
}
