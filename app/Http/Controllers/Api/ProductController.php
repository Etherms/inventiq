<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category','supplier'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Products fetched successfully',
            'data' => $products
        ]);
    }
}
