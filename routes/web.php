<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\KasirController;
use App\Http\Controllers\admin\KokiController;
use App\Http\Controllers\Admin\Manajemen\AddUsersController;
use App\Http\Controllers\admin\manajemen\CategoriesController;
use App\Http\Controllers\admin\manajemen\ListOrdersController;
use App\Http\Controllers\admin\manajemen\ListsOrderPelayanController;
use App\Http\Controllers\admin\manajemen\MenuItemsController;
use App\Http\Controllers\admin\manajemen\OrderKasirController;
use App\Http\Controllers\admin\manajemen\OrdersController;
use App\Http\Controllers\Admin\Manajemen\SalariesController;
use App\Http\Controllers\admin\PelayanController;
use App\Http\Controllers\user\MenuUserController;
use App\Http\Controllers\user\OrderUserController;
use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role->name === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role->name === 'koki') {
            return redirect()->route('koki.dashboard');
        } elseif ($user->role->name === 'kasir') {
            return redirect()->route('kasir.dashboard');
        } elseif ($user->role->name === 'pelayan') {
            return redirect()->route('pelayan.dashboard');
        } else {
            return redirect()->route('home');
        }
    }
    return redirect()->route('login');
})->name('home');

Auth::routes(['middleware' => ['redirectIfAuthenticated']]);


Route::middleware(['auth', 'role.admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('categories', CategoriesController::class);
    Route::resource('menu_items', MenuItemsController::class);
    Route::resource('orders', OrdersController::class);
    Route::resource('users', AddUsersController::class);
    Route::resource('salaries', SalariesController::class);

    Route::get('/print-orders', [OrdersController::class, 'printOrders'])->name('printOrders');
});

Route::middleware(['auth', 'role.koki'])->group(function () {
    Route::get('/koki', [KokiController::class, 'index'])->name('koki.dashboard');

    Route::resource('list-orders', ListOrdersController::class);
    Route::post('list-orders/{id}/update-status', [ListOrdersController::class, 'updateStatus'])->name('list-orders.updateStatus');
});

Route::middleware(['auth', 'role.kasir'])->group(function () {
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.dashboard');

    Route::resource('orders_kasir', OrderKasirController::class);
    Route::get('/orders_kasir/{id}/print', [OrderKasirController::class, 'print'])->name('orders_kasir.print');
});

Route::middleware(['auth', 'role.pelayan'])->group(function () {
    Route::get('/pelayan', [PelayanController::class, 'index'])->name('pelayan.dashboard');

    Route::resource('list-orders-waitress', ListsOrderPelayanController::class);
});

Route::middleware(['auth', 'role.user'])->group(function () {
    Route::get('/home', [UserController::class, 'index'])->name('home');

    Route::resource('list_menu', MenuUserController::class);
    Route::resource('orders-user', OrderUserController::class);
});

// Contoh
// Route::get('/', function () {
//     if (Auth::check()) {
//         $user = Auth::user();
//         if ($user->role->name === 'super_admin') {
//             return redirect()->route('super_admin.dashboard');
//         } elseif ($user->role->name === 'admin') {
//             return redirect()->route('admin.dashboard');
//         } elseif ($user->role->name === 'kaprog') {
//             return redirect()->route('kaprog.dashboard');
//         } elseif ($user->role->name === 'pemray') {
//             return redirect()->route('pemray.dashboard');
//         } else {
//             return redirect()->route('home');
//         }
//     }
//     return redirect()->route('login');
// })->name('home');
