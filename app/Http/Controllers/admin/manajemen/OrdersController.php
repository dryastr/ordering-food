<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;

class OrdersController extends Controller
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
        $codeOrder = $this->generateOrderCode();

        return view('admin.admin.orders.index', compact('orders', 'menuItems', 'codeOrder'));
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

    public function store(Request $request)
    {
        $request->validate([
            'code_order' => 'required|unique:orders',
            'customer' => 'required',
            'table_number' => 'nullable',
            'menu_id' => 'required|exists:menu_items,id',
            'qty' => 'required|integer|min:1',
            'note' => 'nullable',
        ]);

        Order::create([
            'code_order' => $request->code_order,
            'customer' => $request->customer,
            'table_number' => $request->table_number,
            'pelayan_id' => Auth::id(),
            'qty' => $request->qty,
            'menu_id' => $request->menu_id,
            'note' => $request->note,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        // Not used in this example
    }

    public function edit(Order $order)
    {
        $menuItems = MenuItem::all();
        return view('admin.orders.edit', compact('order', 'menuItems'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'code_order' => 'required|unique:orders,code_order,' . $order->id,
            'customer' => 'required',
            'table_number' => 'nullable',
            'menu_id' => 'required|exists:menu_items,id',
            'qty' => 'required|integer|min:1',
            'note' => 'nullable',
        ]);

        $order->update([
            'code_order' => $request->code_order,
            'customer' => $request->customer,
            'table_number' => $request->table_number,
            'qty' => $request->qty,
            'menu_id' => $request->menu_id,
            'note' => $request->note,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }

    public function printOrders(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Order::with('menuItem');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $orders = $query->get();
        $totalPrice = $orders->sum(function ($order) {
            return $order->qty * $order->menuItem->price;
        });

        return view('admin.admin.orders.pdf', compact('orders', 'totalPrice'));
    }
}
