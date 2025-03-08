<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuoteController extends Controller
{

    public function index()
    {
        $quotes = Quote::paginate();

        if(!$quotes) return response()->json([
            'status_code' => 404,
            'message' => 'Quotes not found',
        ]);

        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'data' => $quotes
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $code = Str::uuid();
        $short_code = "S".Carbon::now()->year. substr($code, 0, 6);

        $request->merge(['code' => $code, 'short_code' => $short_code]);

        $quote = Quote::create($request->all());

        if(!$quote) return response()->json([
            'status_code' => 404,
            'message' => 'Quote created',
        ]);

        return response()->json([
            'status_code' => 200,
            'message' => 'Quote created',
            'data' => $quote
        ]);
    }

    public function show(string $id)
    {
        $quote = Quote::find($id);

        if(!$quote) return response()->json([
            'status_code' => 404,
            'message' => 'Quote not found',
        ]);

        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'data' => $quote
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'string',
            'description' => 'string',
        ]);

        $quote = Quote::find($id);

        if(!$quote) return response()->json([
            'status_code' => 404,
            'message' => 'Quote not found',
        ]);

        $quote->update($request->all());

        return response()->json([
            'status_code' => 200,
            'message' => 'Quote updated',
        ]);
    }

    public function destroy(string $id)
    {
        $quote = Quote::find($id)->delete();

        if(!$quote) return response()->json([
            'status_code' => 404,
            'message' => 'Quote not found',
        ]);

        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
        ]);
    }

    public function getProduct(string $quote_id, string $product_id)
    {
        $quote = Quote::find($quote_id)->products()->find($product_id);

        if(!$quote) return response()->json([
            'status_code' => 404,
            'message' => 'Quote not found',
        ]);

        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'data' => $quote
        ]);
    }

    public function getAllProducts(string $quote_id)
    {
        $quote = Quote::find($quote_id);

        if(!$quote) return response()->json([
            'status_code' => 404,
            'message' => 'Quote not found',
        ]);

        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'data' => $quote->products()->get()
        ]);
    }

    public function addProducts(Request $request, string $quote_id)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.name' => 'required|string',
            'products.*.price' => 'required|numeric',
            'products.*.description' => 'required|string',
            'products.*.status' => 'nullable|string',
            'products.*.type' => 'nullable|string',
        ]);

        $quote = Quote::find($quote_id);

        if (!$quote) {
            return response()->json([
                'status_code' => 404,
                'message' => 'Quote not found',
            ]);
        }

        $products = $quote->products()->createMany($request->input('products'));

        return response()->json([
            'status_code' => 200,
            'message' => 'Success',
            'data' => $products,
        ]);
    }

    public function deleteProduct(string $quote_id, string $product_id)
    {
        $quote = Quote::find($quote_id)->products()->find($product_id)->delete();

        if(!$quote) return response()->json([
            'status_code' => 404,
            'message' => 'Quote not found',
        ]);

        return response()->json([
            'status_code' => 200,
            'message' => 'Success'
        ]);
    }
}
