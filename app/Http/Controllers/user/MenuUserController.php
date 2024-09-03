<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuUserController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::with('category')->get();
        $categories = Category::all();
        return view('user.menu.index', compact('menuItems', 'categories'));
    }
}
