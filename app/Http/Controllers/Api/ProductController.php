<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductLike;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['likes' => function($query) {
            $query->where('user_id', auth()->id());
        }])->get();

        return response()->json([
            'products' => $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock_quantity' => $product->stock_quantity,
                    'image_url' => $product->image_url,
                    'is_liked' => $product->likes->isNotEmpty(),
                    'is_in_stock' => $product->isInStock(),
                ];
            })
        ]);
    }

    public function show(Product $product)
    {
        $product->load(['likes' => function($query) {
            $query->where('user_id', auth()->id());
        }]);

        return response()->json([
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock_quantity' => $product->stock_quantity,
                'image_url' => $product->image_url,
                'is_liked' => $product->likes->isNotEmpty(),
                'is_in_stock' => $product->isInStock(),
                'model' => $product->model,
                'code' => $product->code,
            ]
        ]);
    }

    public function toggleLike(Product $product)
    {
        $user = auth()->user();
        
        $like = ProductLike::where('user_id', $user->id)
                          ->where('product_id', $product->id)
                          ->first();

        if ($like) {
            $like->delete();
            $message = 'Product unliked successfully';
        } else {
            ProductLike::create([
                'user_id' => $user->id,
                'product_id' => $product->id
            ]);
            $message = 'Product liked successfully';
        }

        return response()->json([
            'message' => $message,
            'is_liked' => !$like
        ]);
    }

    public function favorites()
    {
        $favorites = auth()->user()->likedProducts()->with(['likes' => function($query) {
            $query->where('user_id', auth()->id());
        }])->get();

        return response()->json([
            'favorites' => $favorites->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock_quantity' => $product->stock_quantity,
                    'image_url' => $product->image_url,
                    'is_liked' => true,
                    'is_in_stock' => $product->isInStock(),
                ];
            })
        ]);
    }
} 







































