@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Order Status</h4>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary active" data-filter="all">All</button>
                        <button type="button" class="btn btn-outline-warning" data-filter="Pending">Pending</button>
                        <button type="button" class="btn btn-outline-info" data-filter="On the way">In Transit</button>
                        <button type="button" class="btn btn-outline-success" data-filter="Delivered">Delivered</button>
                    </div>
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
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr class="order-row" data-status="{{ $order->order_status }}">
                                    <td>#{{ $order->id }}</td>
                                    <td>
                                        <div>{{ $order->user->name }}</div>
                                        <small class="text-muted">{{ $order->user->email }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $order->product->name }}</div>
                                        <small class="text-muted">Qty: {{ $order->quantity }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $order->created_at->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $order->order_status === 'Pending' ? 'warning' : 
                                            ($order->order_status === 'On the way' ? 'info' : 'success') 
                                        }}">
                                            {{ $order->order_status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('driver.orders.show', $order->id) }}" 
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            @if($order->order_status !== 'Delivered')
                                            <form action="{{ route('driver.orders.updateStatus', $order->id) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                <input type="hidden" name="order_status" 
                                                       value="{{ $order->order_status === 'Pending' ? 'On the way' : 'Delivered' }}">
                                                <button type="submit" 
                                                        class="btn btn-{{ $order->order_status === 'Pending' ? 'success' : 'info' }} btn-sm">
                                                    <i class="fas fa-{{ $order->order_status === 'Pending' ? 'truck' : 'check' }}"></i>
                                                    {{ $order->order_status === 'Pending' ? 'Start Delivery' : 'Mark Delivered' }}
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No orders found.</td>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('[data-filter]');
    const orderRows = document.querySelectorAll('.order-row');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            
            orderRows.forEach(row => {
                if (filter === 'all' || row.dataset.status === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endpush
@endsection 