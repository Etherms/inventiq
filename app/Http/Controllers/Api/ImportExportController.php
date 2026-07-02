<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ImportExportController extends Controller
{
    private array $resources = [
        'categories' => [
            'model' => Category::class,
            'filename' => 'categories.csv',
            'columns' => ['name', 'description'],
            'unique' => 'name',
        ],
        'suppliers' => [
            'model' => Supplier::class,
            'filename' => 'suppliers.csv',
            'columns' => ['name', 'contact_person', 'email', 'phone', 'address'],
            'unique' => 'email',
        ],
        'products' => [
            'model' => Product::class,
            'filename' => 'products.csv',
            'columns' => [
                'sku',
                'name',
                'description',
                'category_id',
                'supplier_id',
                'cost_price',
                'selling_price',
                'stock',
                'reorder_level',
                'status',
            ],
            'unique' => 'sku',
        ],
    ];

    public function export(string $resource)
    {
        abort_unless(isset($this->resources[$resource]), 404);

        $config = $this->resources[$resource];
        $model = $config['model'];
        $columns = $config['columns'];

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$config['filename']}",
        ];

        $callback = function () use ($model, $columns) {
            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

            $model::orderBy('id')->chunk(100, function ($records) use ($file, $columns) {
                foreach ($records as $record) {
                    fputcsv($file, collect($columns)->map(fn ($column) => $record->{$column})->toArray());
                }
            });

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function import(Request $request, string $resource)
    {
        abort_unless(isset($this->resources[$resource]), 404);

        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $config = $this->resources[$resource];
        $model = $config['model'];
        $columns = $config['columns'];
        $uniqueColumn = $config['unique'];

        $file = fopen($request->file('file')->getRealPath(), 'r');

        fgetcsv($file);

        $imported = 0;
        $duplicates = [];

        while (($row = fgetcsv($file)) !== false) {
            $data = [];

            foreach ($columns as $index => $column) {
                $data[$column] = trim($row[$index] ?? '');
            }

            if (empty($data[$uniqueColumn])) {
                continue;
            }

            if ($model::where($uniqueColumn, $data[$uniqueColumn])->exists()) {
                $duplicates[] = $data[$uniqueColumn];
                continue;
            }

            $model::create($data);
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