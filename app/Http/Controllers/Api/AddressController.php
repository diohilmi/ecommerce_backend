<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    //index
    public function index(Request $request)
    {
        $addresses = $request->user()->addresses;
        return response()->json([
            'status' => 'success',
            'message' => 'Addresses retrieved successfully',
            'data' => $addresses
        ], 200);
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'address' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:255'],
            'is_default' => ['required', 'boolean'],

        ]);

        $address = Address::create([
            'user_id' => $request->user()->id,
            'address' => $request->address,
            'country' => $request->country,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'postcode' => $request->postcode,
            'is_default' => $request->is_default,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Address created successfully',
            'data' => $address
        ], 201);
    }

    //update
    public function update(Request $request, $id)
    {
        $request->validate([
            'address' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:255'],
            'is_default' => ['required', 'boolean'],
        ]);

        $address = Address::find($id);
        $address->update([
            'address' => $request->address,
            'country' => $request->country,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'postcode' => $request->postcode,
            'is_default' => $request->is_default,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Address updated successfully',
            'data' => $address
        ], 200);
    }

    //delete
    public function destroy($id)
    {
        $address = Address::find($id);
        $address->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Address deleted successfully',
        ], 200);
    }
}
