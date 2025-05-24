@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Customer Locations</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer Name</th>
                                    <th>Delivery Address</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>
                                        {{ $order->delivery_address ?? 'No address provided' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $order->order_status === 'Pending' ? 'warning' : 'info' }}">
                                            {{ $order->order_status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('driver.orders.show', $order->id) }}" 
                                           class="btn btn-primary btn-sm">
                                            View Details
                                        </a>
                                        @if($order->order_status === 'Pending')
                                        <form action="{{ route('driver.orders.updateStatus', $order->id) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            <input type="hidden" name="order_status" value="On the way">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                Start Delivery
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No active deliveries found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 