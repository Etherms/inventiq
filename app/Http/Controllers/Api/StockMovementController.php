<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    public function statistics()
    {
        $thisWeekStart = now()->startOfWeek();
        $lastWeekStart = now()->subWeek()->startOfWeek();
        $lastWeekEnd = now()->subWeek()->endOfWeek();

        $totalMovements = StockMovement::count();
        $stockIn = StockMovement::where('type', 'in')->count();
        $stockOut = StockMovement::where('type', 'out')->count();
        $todayMovements = StockMovement::whereDate('created_at', today())->count();

        $thisWeekTotal = StockMovement::whereBetween('created_at', [$thisWeekStart, now()])->count();
        $lastWeekTotal = StockMovement::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();

        $thisWeekIn = StockMovement::where('type', 'in')->whereBetween('created_at', [$thisWeekStart, now()])->count();
        $lastWeekIn = StockMovement::where('type', 'in')->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();

        $thisWeekOut = StockMovement::where('type', 'out')->whereBetween('created_at', [$thisWeekStart, now()])->count();
        $lastWeekOut = StockMovement::where('type', 'out')->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();

        return response()->json([
            'success' => true,
            'data' => [
                'totalMovements' => $totalMovements,
                'stockIn' => $stockIn,
                'stockOut' => $stockOut,
                'todayMovements' => $todayMovements,
                'changes' => [
                    'totalMovements' => $this->percentChange($thisWeekTotal, $lastWeekTotal),
                    'stockIn' => $this->percentChange($thisWeekIn, $lastWeekIn),
                    'stockOut' => $this->percentChange($thisWeekOut, $lastWeekOut),
                    'todayMovements' => 0,
                ],
            ],
        ]);
    }

    private function percentChange($current, $previous): float
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }
}