<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Http\Request;

class ListsOrderPelayanController extends Controller
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

        return view('admin.pelayan.orders.index', compact('orders', 'menuItems'));
    }
}
