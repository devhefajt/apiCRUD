<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductAPIController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // Check if user is authorized to create a product
        $this->authorize('create', Product::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product = Product::create(array_merge(
            $request->all(),
            ['user_id' => Auth::id()] // Associate product with the authenticated user
        ));

        return response()->json([
            'message' => 'Product created successfully!',
            'product' => $product
        ], 201);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Check if user is authorized to update the product
        $this->authorize('update', $product);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $product->update($request->all());

        return response()->json([
            'message' => 'Product updated successfully!',
            'product' => $product
        ]);
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Check if user is authorized to delete the product
        $this->authorize('delete', $product);

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully!']);
    }
}
