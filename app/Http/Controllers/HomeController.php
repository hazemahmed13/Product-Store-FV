<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\Product;

class HomeController extends Controller
{
    public function home()
    {
        $hero = HeroSection::first();

        // Get featured products (latest 8 products)
        $featuredProducts = Product::latest()
            ->where('stock_quantity', '>', 0)
            ->take(8)
            ->get();

        // Get popular products (you can modify this logic based on your needs)
        $popularProducts = Product::where('stock_quantity', '>', 0)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('home', compact('hero', 'featuredProducts', 'popularProducts'));
    }
}