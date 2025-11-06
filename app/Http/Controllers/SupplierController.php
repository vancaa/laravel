<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    // -----------------------------
    // WEB VIEW: Halaman utama
    // -----------------------------
    public function index()
    {
        $suppliers = Supplier::paginate(4);
        return view('supplier.index', compact('suppliers'));
    }

    public function lihat()
    {
        return Supplier::all();
    }

    public function lihat_byid($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) return response()->json(['message' => 'Supplier not found'], 404);
        return $supplier;
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'pic_supplier' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $supplier = new Supplier();
        $supplier->supplier_name = $request->supplier_name;
        $supplier->pic_supplier = $request->pic_supplier;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('suppliers', 'public');
            $supplier->photo = $photoPath;
        }

        $supplier->save();

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.show', compact('supplier'));
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'pic_supplier' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $supplier->supplier_name = $request->supplier_name;
        $supplier->pic_supplier = $request->pic_supplier;

        if ($request->hasFile('photo')) {
            if ($supplier->photo && Storage::disk('public')->exists($supplier->photo)) {
                Storage::disk('public')->delete($supplier->photo);
            }

            $photoPath = $request->file('photo')->store('suppliers', 'public');
            $supplier->photo = $photoPath;
        }

        $supplier->save();

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus!');
    }
}
