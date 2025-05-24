<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->purchases()
            ->with('product')
            ->latest()
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'product' => [
                        'id' => $order->product->id,
                        'name' => $order->product->name,
                        'image_url' => $order->product->image_url,
                    ],
                    'quantity' => $order->quantity,
                    'total_price' => $order->total_price,
                    'order_status' => $order->order_status,
                    'delivery_method' => $order->delivery_method,
                    'delivery_address' => $order->delivery_address,
                    'pickup_branch' => $order->pickup_branch,
                    'created_at' => $order->created_at,
                    'estimated_delivery_time' => $order->estimated_delivery_time,
                    'delivered_at' => $order->delivered_at,
                ];
            });

        return response()->json(['orders' => $orders]);
    }

    public function show(Purchase $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order->load('product');

        return response()->json([
            'order' => [
                'id' => $order->id,
                'product' => [
                    'id' => $order->product->id,
                    'name' => $order->product->name,
                    'image_url' => $order->product->image_url,
                ],
                'quantity' => $order->quantity,
                'total_price' => $order->total_price,
                'order_status' => $order->order_status,
                'delivery_method' => $order->delivery_method,
                'delivery_address' => $order->delivery_address,
                'pickup_branch' => $order->pickup_branch,
                'created_at' => $order->created_at,
                'estimated_delivery_time' => $order->estimated_delivery_time,
                'delivered_at' => $order->delivered_at,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required|in:home,pickup',
            'delivery_address' => 'required_if:delivery_method,home',
            'pickup_branch' => 'required_if:delivery_method,pickup',
            'payment_method' => 'required|in:cod,card',
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return response()->json(['message' => 'Cart is empty'], 422);
        }

        try {
            DB::beginTransaction();

            $user = auth()->user();
            $orders = [];

            foreach ($cart as $productId => $item) {
                $product = Product::findOrFail($productId);
                
                if (!$product->isInStock() || $item['quantity'] > $product->stock_quantity) {
                    throw new \Exception("Product {$product->name} is out of stock or not enough quantity available.");
                }

                $totalPrice = $product->price * $item['quantity'];

                if ($request->payment_method === 'card' && $user->getCreditBalance() < $totalPrice) {
                    throw new \Exception('Insufficient credit balance.');
                }

                $order = Purchase::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'total_price' => $totalPrice,
                    'delivery_method' => $request->delivery_method,
                    'delivery_address' => $request->delivery_method === 'home' ? $request->delivery_address : null,
                    'pickup_branch' => $request->delivery_method === 'pickup' ? $request->pickup_branch : null,
                    'payment_method' => $request->payment_method,
                    'order_status' => 'Pending'
                ]);

                $product->decreaseStock($item['quantity']);

                if ($request->payment_method === 'card') {
                    $user->deductCredit($totalPrice);
                }

                $orders[] = $order;
            }

            DB::commit();
            Session::forget('cart');

            return response()->json([
                'message' => 'Orders placed successfully',
                'orders' => $orders
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function tracking(Purchase $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'order' => [
                'id' => $order->id,
                'status' => $order->order_status,
                'estimated_delivery_time' => $order->estimated_delivery_time,
                'delivered_at' => $order->delivered_at,
                'delivery_method' => $order->delivery_method,
                'delivery_address' => $order->delivery_address,
                'pickup_branch' => $order->pickup_branch,
            ]
        ]);
    }
} 