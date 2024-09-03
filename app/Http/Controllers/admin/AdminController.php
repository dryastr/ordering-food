<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Role;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Hitung total karyawan dengan role koki, kasir, atau pelayan
        $roleIds = Role::whereIn('name', ['koki', 'kasir', 'pelayan'])->pluck('id')->toArray();
        $totalEmployees = User::whereIn('role_id', $roleIds)->count();

        // Hitung total pendapatan
        $totalRevenue = Order::join('menu_items', 'orders.menu_id', '=', 'menu_items.id')
            ->selectRaw('SUM(orders.qty * menu_items.price) as total_revenue')
            ->value('total_revenue');

        // Dapatkan data pendapatan per hari selama 1 minggu
        $dailyRevenueData = $this->getDailyRevenue();

        return view('admin.admin.dashboard', [
            'totalEmployees' => $totalEmployees,
            'totalRevenue' => $totalRevenue,
            'dailyRevenue' => $dailyRevenueData['dailyRevenue'],
            'dates' => $dailyRevenueData['dates'],
        ]);
    }

    private function getDailyRevenue()
    {
        $startDate = Carbon::now()->startOfWeek(); // Mulai dari hari Senin minggu ini
        $endDate = Carbon::now()->endOfWeek();     // Akhir minggu ini

        $dailyRevenue = Order::join('menu_items', 'orders.menu_id', '=', 'menu_items.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->selectRaw('DATE(orders.created_at) as date, SUM(orders.qty * menu_items.price) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                $item->date = Carbon::parse($item->date)->format('D, d M'); // Format tanggal
                return $item;
            });

        // Generate dates for the whole week if there are missing days
        $dates = collect();
        for ($i = 0; $i < 7; $i++) {
            $dates->push($startDate->copy()->addDays($i)->format('D, d M'));
        }

        return [
            'dailyRevenue' => $dailyRevenue->keyBy('date')->map(fn($item) => $item->revenue)->toArray(),
            'dates' => $dates->toArray()
        ];
    }
}
