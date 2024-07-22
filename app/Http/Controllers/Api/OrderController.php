<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
    //createOrder
    public function createOrder(Request $request)
    {
        $request->validate([
            'address_id' => 'required|integer',
            'seller_id' => 'required|integer',
            'items' => 'required|array',
            'items,*.product_id' => 'required|integer',
            'items,*.quantity' => 'required|integer',
            'shipping_price' => 'required|numeric',
            'shipping_service' => 'required|string',
            // 'shipping_number' => 'required|string',
        ]);

        $user = $request->user();

        $totalPrice = 0;
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found',
                ], 404);
            }
            $totalPrice += $product->price * $item['quantity'];
        }

        $grandTotal = $totalPrice + $request->shipping_price;



        $order = Order::create([
            'user_id' => $user->id,
            'address_id' => $request->address_id,
            'seller_id' => $request->seller_id,
            'shipping_price' => $request->shipping_price,
            'shipping_service' => $request->shipping_service,
            'shipping_number' => $request->shipping_number,
            'status' => 'pending',
            'total_price' => $totalPrice,
            'grand_total' => $grandTotal,
            'transaction_number' => 'TRX-'.time(),
        ]);

        foreach ($request->items as $item) {
            // $order->items()->create([
            //     'product_id' => $item['product_id'],
            //     'quantity' => $item['quantity'],
            //     'price' => $item['price'],
            // ]);
            OrderItem::created([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'price' => $product->price,
                'quantity' => $item['quantity'],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully',
            'data' => $order,
        ], 201);
    }
    
    //update shipping number
    public function updateShippingNumber(Request $request, $id)
    {
        $request->validate([
            'shipping_number' => 'required|string',
        ]);
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }
        $order->shipping_number = $request->shipping_number;
        $order->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Shipping number updated successfully',
            'data' => $order,
        ], 200);
    }

    //history order buyer
    public function historyOrderBuyer(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)->get();
        return response()->json([
            'orders' => 'success',
            'message' => 'Orders retrieved successfully',
            'data' => $orders,
        ]);
    }

    //history order seller
    public function historyOrderSeller(Request $request)
    {
        $orders = Order::where('seller_id', $request->user()->id)->get();
        return response()->json([
            'orders' => 'success',
            'message' => 'Orders retrieved successfully',
            'data' => $orders,
        ]);
    }
}
