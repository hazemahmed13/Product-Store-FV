@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Stock Report</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Current Stock</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No products data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 