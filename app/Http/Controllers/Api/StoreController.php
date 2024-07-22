<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    //index
    public function index(Request $request)
    {
        $stores = User::where('roles', 'seller')->get();
        return response()->json([
            'stores' => 'success',
            'message' => 'Stores retrieved successfully',
            'data' => $stores,
        ]);
    }

    //products by store
    public function productByStore(Request $request, $id)
    {
        $products = Product::where('seller_id', $id)->get();
        return response()->json([
            'products' => 'success',
            'message' => 'Products retrieved successfully',
            'data' => $products,
        ]);
    }

    //
}