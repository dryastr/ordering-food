<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class UserController extends Controller
{
    public function index()
    {
        $userName = Auth::user()->name;

        $totalOrders = Order::where('customer', $userName)->count();

        $totalPurchase = Order::where('customer', $userName)
            ->join('menu_items', 'orders.menu_id', '=', 'menu_items.id')
            ->selectRaw('SUM(orders.qty * menu_items.price) as total_purchase')
            ->value('total_purchase');

        return view('user.dashboard', compact('totalOrders', 'totalPurchase'));
    }
}
