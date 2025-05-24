<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $query = Purchase::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total_orders'), DB::raw('SUM(total_price) as total_revenue'))
                         ->groupBy('date')
                         ->orderBy('date', 'desc');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $salesData = $query->get();

        return view('reports.sales', compact('salesData'));
    }

    public function products()
    {
        $products = Product::withCount('purchases')
                         ->orderBy('purchases_count', 'desc')
                         ->get();

        return view('reports.products', compact('products'));
    }

    public function stock()
    {
        $products = Product::orderBy('stock_quantity', 'asc')
                         ->get();

        return view('reports.stock', compact('products'));
    }
}











































