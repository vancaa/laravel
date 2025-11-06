<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Supplier;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // -----------------------------
    // WEB VIEW: Halaman utama
    // -----------------------------
    public function index(): View
    {
        $products = (new Product)->get_product()->latest()->paginate(4);
        return view('products.index', compact('products'));
    }

    // -----------------------------
    // API: Ambil semua produk (JSON)
    // -----------------------------
    public function lihat()
    {
        return Product::all();
    }

    public function lihat_byid($id)
    {
        $product = Product::find($id);
        if (!$product) return response()->json(['message' => 'Product not found'], 404);
        return $product;
    }

    public function create(): View
    {
        $categories = ProductCategory::all();
        $suppliers = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:10240',
            'title' => 'required|min:4',
            'id_supplier' => 'required|integer',
            'product_category_id' => 'required|integer',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        if ($request->hasFile('image')) {
            $request->file('image')->store('image', 'public');
            (new Product)->storeProduct($request, $request->file('image'));
            return redirect()->route('products.index')->with('success', 'Data berhasil disimpan!');
        }

        return redirect()->route('products.index')->with('error', 'Gagal mengunggah gambar.');
    }

    public function show(string $id): View
    {
        $product = (new Product)->get_product()->where('products.id', $id)->firstOrFail();
        return view('products.show', compact('product'));
    }

    public function edit(string $id): View
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::all();
        $suppliers = Supplier::all();

        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,jpg,png|max:10240',
            'title' => 'required|min:4',
            'id_supplier' => 'required|integer',
            'product_category_id' => 'required|integer',
            'description' => 'required|min:5',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        $productModel = new Product;
        $nameImage = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->store('image', 'public');
            $nameImage = $image->hashName();

            $dataProduct = $productModel->get_product()->where('products.id', $id)->firstOrFail();
            Storage::disk('public')->delete('image/' . $dataProduct->image);
        }

        $updateData = [
            'title' => $request->title,
            'supplier_id' => $request->id_supplier,
            'product_category_id' => $request->product_category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ];

        $productModel->updateProduct($id, $updateData, $nameImage);

        return redirect()->route('products.index')->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id): RedirectResponse
    {
        $productModel = new Product;
        $product = $productModel->get_product()->where('products.id', $id)->firstOrFail();

        Storage::disk('public')->delete('image/' . $product->image);
        DB::transaction(function() use ($product) {
            $product->detailTransaksiPenjualan()->delete();
            $product->delete();
        });
        return redirect()->route('products.index')->with('success', 'Data berhasil dihapus!');
    }
}
