<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function show()
    {
        $cart = Session::get('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $items[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'image_url' => $product->image_url,
                    'subtotal' => $product->price * $item['quantity']
                ];
                $total += $product->price * $item['quantity'];
            }
        }

        return response()->json([
            'items' => $items,
            'total' => $total
        ]);
    }

    public function add(Product $product, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $quantity = $request->quantity;

        if (!$product->isInStock() || $quantity > $product->stock_quantity) {
            return response()->json([
                'message' => 'Product is out of stock or not enough quantity available.'
            ], 422);
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'quantity' => $quantity
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'message' => 'Product added to cart successfully',
            'cart' => $this->show()->original
        ]);
    }

    public function update(Product $product, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $quantity = $request->quantity;

        if ($quantity > $product->stock_quantity) {
            return response()->json([
                'message' => 'Not enough quantity available.'
            ], 422);
        }

        $cart = Session::get('cart', []);

        if ($quantity === 0) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id]['quantity'] = $quantity;
        }

        Session::put('cart', $cart);

        return response()->json([
            'message' => 'Cart updated successfully',
            'cart' => $this->show()->original
        ]);
    }

    public function remove(Product $product)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            Session::put('cart', $cart);
        }

        return response()->json([
            'message' => 'Product removed from cart successfully',
            'cart' => $this->show()->original
        ]);
    }
} 































