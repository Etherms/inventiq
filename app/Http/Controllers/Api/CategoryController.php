<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
public function index(Request $request)
    {
        $query = Category::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        $allowedSorts = ['name', 'description', 'created_at'];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }

        $perPage = $request->get('per_page', 8);

        $categories = $query
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $categories->items(),
            'pagination' => [
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total(),
                'prev_page_url' => $categories->previousPageUrl(),
                'next_page_url' => $categories->nextPageUrl(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $category = Category::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully.',
            'data' => $category,
        ], 201);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $category->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully.',
            'data' => $category,
        ]);
    }

    public function destroy(Category $category)
    {
        $productsCount = $category->products()->count();

        if ($productsCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Cannot delete {$category->name} because it is being used by {$productsCount} product(s). Please move or delete the related products first.",
                'products_count' => $productsCount,
            ], 422);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.',
        ]);
}

    public function export()
    {
        $fileName = 'categories.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['name', 'description']);

            Category::orderBy('name')->chunk(100, function ($categories) use ($file) {
                foreach ($categories as $category) {
                    fputcsv($file, [
                        $category->name,
                        $category->description,
                    ]);
                }
            });

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $file = fopen($request->file('file')->getRealPath(), 'r');

        fgetcsv($file); // skip header

        $imported = 0;
        $duplicates = [];

        while (($row = fgetcsv($file)) !== false) {
            $name = trim($row[0] ?? '');
            $description = trim($row[1] ?? '');

            if (!$name) {
                continue;
            }

            $exists = Category::where('name', $name)->exists();

            if ($exists) {
                $duplicates[] = $name;
                continue;
            }

            Category::create([
                'name' => $name,
                'description' => $description,
            ]);

            $imported++;
        }

        fclose($file);

        return response()->json([
            'success' => true,
            'message' => 'Import completed.',
            'imported' => $imported,
            'duplicates_count' => count($duplicates),
            'duplicates' => $duplicates,
        ]);
    }
}