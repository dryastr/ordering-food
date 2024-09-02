<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Http\Request;

class ListOrdersController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('menuItem');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $orders = $query->get();

        $menuItems = MenuItem::all();

        return view('admin.koki.orders.index', compact('orders', 'menuItems'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:proses,selesai',
        ]);

        $order->status = $request->input('status');
        $order->save();

        return redirect()->route('list-orders.index')->with('success', 'Status order berhasil diubah');
    }
}
