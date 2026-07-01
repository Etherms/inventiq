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
    public function index(Request $request)
    {
        $allowedSorts = [
            'created_at',
            'type',
            'quantity',
            'previous_stock',
            'new_stock',
            'ref_number',
        ];

        $sortBy = in_array($request->get('sort_by'), $allowedSorts)
            ? $request->get('sort_by')
            : 'created_at';

        $sortDirection = $request->get('sort_direction') === 'asc'
            ? 'asc'
            : 'desc';

        $perPage = $request->get('per_page', 8);

        $query = StockMovement::with(['product', 'user']);

        if ($request->filter === 'in' || $request->type === 'in') {
            $query->where('type', 'in');
        }

        if ($request->filter === 'out' || $request->type === 'out') {
            $query->where('type', 'out');
        }

        if ($request->filter === 'today') {
            $query->whereDate('created_at', today());
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('ref_number', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($productQuery) use ($search) {
                        $productQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('sku', 'like', "%{$search}%");
                    });
            });
        }

        return response()->json(
            $query
                ->orderBy($sortBy, $sortDirection)
                ->paginate($perPage)
                ->withQueryString()
        );
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

    public function export(Request $request)
    {
        $query = StockMovement::with(['product', 'user']);

        if ($request->filter === 'in' || $request->type === 'in') {
            $query->where('type', 'in');
        }

        if ($request->filter === 'out' || $request->type === 'out') {
            $query->where('type', 'out');
        }

        if ($request->filter === 'today') {
            $query->whereDate('created_at', today());
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('ref_number', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($productQuery) use ($search) {
                        $productQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('sku', 'like', "%{$search}%");
                    });
            });
        }

        $movements = $query->latest()->get();

        $fileName = 'stock-movements-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        return response()->stream(function () use ($movements) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Date',
                'Product',
                'SKU',
                'Type',
                'Quantity',
                'Previous Stock',
                'New Stock',
                'Reference Number',
                'User',
                'Notes',
            ]);

            foreach ($movements as $movement) {
                fputcsv($file, [
                    $movement->created_at?->format('Y-m-d H:i:s'),
                    $movement->product?->name,
                    $movement->product?->sku,
                    strtoupper($movement->type),
                    $movement->quantity,
                    $movement->previous_stock,
                    $movement->new_stock,
                    $movement->ref_number,
                    $movement->user?->name,
                    $movement->notes,
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'CSV import endpoint is ready. Import logic can be added next.',
        ]);
    }
}