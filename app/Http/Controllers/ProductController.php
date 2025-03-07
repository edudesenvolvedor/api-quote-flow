<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'data' => Product::paginate()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'status' => 'string',
            'type'=> 'string',
        ]);

        $product = Product::create($request->all());

        if(!$product) return response()->json([
            'status_code' => 400,
            'message' => 'Failed',
            'data' => $product
        ]);

        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'data' => $product
        ]);
    }

    public function show(string $id)
    {
        $product = Product::find($id);

        if(!$product) return response()->json([
            'status_code' => 404,
            'message' => 'Product not found',
        ]);

        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'data' => $product
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ' string',
            'price' => 'numeric',
            'description' => 'string',
            'status' => 'string',
            'type'=> 'string',
        ]);

        $product = Product::find($id)->update($request->all());

        if(!$product) return response()->json([
            'status_code' => 404,
            'message' => 'Product not found',
        ]);

        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'data' => $product
        ]);
    }

    public function destroy(string $id)
    {
        $product = Product::destroy($id);

        if(!$product) return response()->json([
            'status_code' => 404,
            'message' => 'Product not found',
        ]);

        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'data' => $product
        ]);
    }
}
