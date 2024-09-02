<?php

namespace App\Http\Controllers\Admin\Manajemen;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;

class SalariesController extends Controller
{
    public function index()
    {
        $salaries = Salary::with('user')->get();
        $users = User::with('role')->whereHas('role', function ($query) {
            $query->where('name', '!=', 'admin');
        })->get();
        return view('admin.admin.salaries.index', compact('salaries', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Salary::create($request->all());

        return redirect()->route('salaries.index')->with('success', 'Gaji berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $salary = Salary::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $salary->update($request->all());

        return redirect()->route('salaries.index')->with('success', 'Gaji berhasil diubah');
    }

    public function destroy($id)
    {
        $salary = Salary::findOrFail($id);
        $salary->delete();

        return redirect()->route('salaries.index')->with('success', 'Gaji berhasil dihapus');
    }
}
