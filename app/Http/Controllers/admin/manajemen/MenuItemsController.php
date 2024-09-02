<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menuItems = MenuItem::with('category')->get();
        $categories = Category::all();
        return view('admin.admin.menu_items.index', compact('menuItems', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('menu_photos', 'public');
        } else {
            $path = null;
        }

        MenuItem::create([
            'photo' => $path,
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => $request->price,
        ]);

        return redirect()->route('menu_items.index')->with('success', 'Menu Item berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Opsional: implementasi jika diperlukan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Opsional: jika menggunakan separate edit view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menuItem = MenuItem::findOrFail($id);

        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('photo')) {
            if ($menuItem->photo && Storage::disk('public')->exists($menuItem->photo)) {
                Storage::disk('public')->delete($menuItem->photo);
            }
            $path = $request->file('photo')->store('menu_photos', 'public');
            $menuItem->photo = $path;
        }

        $menuItem->name = $request->name;
        $menuItem->description = $request->description;
        $menuItem->category_id = $request->category_id;
        $menuItem->price = $request->price;

        $menuItem->save();

        return redirect()->route('menu_items.index')->with('success', 'Menu Item berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menuItem = MenuItem::findOrFail($id);

        if ($menuItem->photo && Storage::disk('public')->exists($menuItem->photo)) {
            Storage::disk('public')->delete($menuItem->photo);
        }

        $menuItem->delete();

        return redirect()->route('menu_items.index')->with('success', 'Menu Item berhasil dihapus.');
    }
}
