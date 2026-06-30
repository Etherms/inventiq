<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    /**
     * List all stock movements.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => StockMovement::with(['product', 'user'])
                ->latest()
                ->get(),
        ]);
    }

    /**
     * Stock In
     */
    public function stockIn(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'ref_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $request) {

            $product = Product::findOrFail($validated['product_id']);

            $previousStock = $product->stock;
            $newStock = $previousStock + $validated['quantity'];

            $product->update([
                'stock' => $newStock,
            ]);

            StockMovement::create([
                'product_id'     => $product->id,
                'user_id'        => auth()->id(),
                'type'           => 'in',
                'quantity'       => $validated['quantity'],
                'previous_stock' => $previousStock,
                'new_stock'      => $newStock,
                'ref_number'     => $validated['ref_number'] ?? null,
                'notes'          => $validated['notes'] ?? null,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Stock added successfully.',
        ]);
    }

    /**
     * Stock Out
     */
    public function stockOut(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'ref_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $request) {

            $product = Product::findOrFail($validated['product_id']);

            if ($validated['quantity'] > $product->stock) {
                abort(422, 'Insufficient stock.');
            }

            $previousStock = $product->stock;
            $newStock = $previousStock - $validated['quantity'];

            $product->update([
                'stock' => $newStock,
            ]);

            StockMovement::create([
                'product_id'     => $product->id,
                'user_id'        => auth()->id(),
                'type'           => 'out',
                'quantity'       => $validated['quantity'],
                'previous_stock' => $previousStock,
                'new_stock'      => $newStock,
                'ref_number'     => $validated['ref_number'] ?? null,
                'notes'          => $validated['notes'] ?? null,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Stock deducted successfully.',
        ]);
    }

    /**
     * View history for a single product.
     */
    public function history(Product $product)
    {
        return response()->json([
            'success' => true,
            'data' => $product->stockMovements()
                ->with('user')
                ->latest()
                ->get(),
        ]);
    }
}