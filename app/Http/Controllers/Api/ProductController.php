<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $allowedSorts = [
            'name',
            'selling_price',
            'stock',
            'supplier_id',
            'status',
            'created_at',
        ];

        $sortBy = in_array($request->get('sort_by'), $allowedSorts)
            ? $request->get('sort_by')
            : 'created_at';

        $sortDirection = $request->get('sort_direction') === 'asc'
            ? 'asc'
            : 'desc';

        return response()->json(
            Product::with(['category', 'supplier'])
                ->orderBy($sortBy, $sortDirection)
                ->paginate(8)
        );
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',

            'sku' => 'required|string|max:255|unique:products,sku',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',

            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',

            'stock' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',

            'status' => 'required|boolean',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully.',
            'data' => $product,
        ], 201);
    }

    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'data' => $product->load(['category', 'supplier']),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',

            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',

            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',

            'stock' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',

            'status' => 'required|boolean',
        ]);

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully.',
            'data' => $product,
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.',
        ]);
    }
}