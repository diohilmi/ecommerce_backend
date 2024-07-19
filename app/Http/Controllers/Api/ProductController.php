<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //index
    public function index(Request $request)
    {
        $products = Product::where('seller_id', $request->user()->id)->with('seller')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Products retrieved successfully',
            'data' => $products
        ], 200);
    }

    //store product
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'name' => ['required','string'],
            'description' => ['string'],
            'price' => ['required','numeric'],
            'stock' => ['required','integer'],
            'photo' => ['required','image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);

        $photo = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('assets/products', 'public');
        }

        $product = Product::create([
            'seller_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'photo' => $photo
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully.',
            'data' => $product
        ], 201);
    }

    //update product
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => ['required','numeric','exists:categories,id'],
            'name' => ['required','string'],
            'description' => ['string'],
            'price' => ['required','numeric'],
            'stock' => ['required','integer'],
            'photo' => ['image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }

        
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);
        
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('assets/products', 'public');
            $product->photo = $photo;
            $product->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully.',
            'data' => $product
        ]);
    }

    //destroy product
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found',
            ], 404);
        }
        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully.',
        ]);
    }
        
}
