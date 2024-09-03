<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderUserController extends Controller
{
    public function index(Request $request)
    {
        $userName = Auth::user()->name;

        $query = Order::with('menuItem')->where('customer', $userName);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $orders = $query->get();

        $menuItems = MenuItem::all();

        return view('user.orders.index', compact('orders', 'menuItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menu_items,id',
            'qty' => 'required|integer|min:1',
            'note' => 'nullable',
        ]);

        // Generate order code
        $orderCode = $this->generateOrderCode();

        Order::create([
            'code_order' => $orderCode,
            'customer' => Auth::user()->name,
            'table_number' => $orderCode,
            'menu_id' => $request->menu_id,
            'qty' => $request->qty,
            'note' => $request->note,
        ]);

        return redirect()->route('list_menu.index')->with('success', 'Order berhasil dibuat.');
    }

    private function generateOrderCode()
    {
        $latestOrder = Order::latest('id')->first();

        $latestCode = $latestOrder ? $latestOrder->code_order : 'RSTKD000';

        $number = (int)substr($latestCode, 5);

        $number++;

        $code = 'RSTKD' . str_pad($number, 3, '0', STR_PAD_LEFT);

        return $code;
    }
}
