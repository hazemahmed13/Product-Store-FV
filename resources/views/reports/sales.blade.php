@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Sales Report</h2>

    <form action="{{ route('reports.sales') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Total Orders</th>
                <th>Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salesData as $sale)
                <tr>
                    <td>{{ $sale->date }}</td>
                    <td>{{ $sale->total_orders }}</td>
                    <td>${{ number_format($sale->total_revenue, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No sales data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 