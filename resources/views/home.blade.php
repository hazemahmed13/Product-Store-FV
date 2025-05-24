@extends('layouts.app')

@section('title', 'Product Store - Welcome')

@section('content')
    <!-- Hero Section -->
    @include('partials.hero-section', ['hero' => $hero])

    <!-- Featured Products Section -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="display-5 fw-bold mb-3">Featured Products</h2>
                    <p class="lead text-muted">Discover our latest and most popular items</p>
                </div>
            </div>

            @if($featuredProducts->count() > 0)
                <div class="row g-4">
                    @foreach($featuredProducts as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card h-100 shadow-sm product-card">
                                <div class="position-relative">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                             class="card-img-top"
                                             alt="{{ $product->name }}"
                                             style="height: 250px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                                             style="height: 250px;">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif

                                    @if($product->stock_quantity < 10)
                                        <span class="badge bg-warning position-absolute top-0 end-0 m-2">
                                            Low Stock
                                        </span>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text text-muted small flex-grow-1">
                                        {{ Str::limit($product->description, 80) }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <span class="h5 mb-0 text-primary">${{ number_format($product->price, 2) }}</span>
                                        <small class="text-muted">Stock: {{ $product->stock_quantity }}</small>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('products.show', $product) }}"
                                           class="btn btn-outline-primary btn-sm me-2">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                        @auth
                                            <form action="{{ route('cart.add', $product) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                                </button>
                                            </form>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('products.index') }}" class="btn btn-dark btn-lg">
                        View All Products <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No products available yet</h4>
                    <p class="text-muted">Check back later for amazing products!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="feature-box p-4">
                        <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                        <h4>Fast Delivery</h4>
                        <p class="text-muted">Quick and reliable shipping to your doorstep</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-box p-4">
                        <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                        <h4>Secure Payment</h4>
                        <p class="text-muted">Your payment information is safe and secure</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-box p-4">
                        <i class="fas fa-undo fa-3x text-primary mb-3"></i>
                        <h4>Easy Returns</h4>
                        <p class="text-muted">30-day return policy for your peace of mind</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Products Section -->
    @if($popularProducts->count() > 0)
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="display-5 fw-bold mb-3">Popular Products</h2>
                    <p class="lead text-muted">Customer favorites and trending items</p>
                </div>
            </div>

            <div class="row g-4">
                @foreach($popularProducts as $product)
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 shadow-sm product-card">
                            <div class="position-relative">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         class="card-img-top"
                                         alt="{{ $product->name }}"
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                                         style="height: 200px;">
                                        <i class="fas fa-image fa-2x text-muted"></i>
                                    </div>
                                @endif
                                <span class="badge bg-success position-absolute top-0 start-0 m-2">
                                    Popular
                                </span>
                            </div>

                            <div class="card-body">
                                <h6 class="card-title">{{ $product->name }}</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h6 mb-0 text-primary">${{ number_format($product->price, 2) }}</span>
                                    <a href="{{ route('products.show', $product) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Newsletter Section -->
    <section class="py-5 bg-dark text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="mb-3">Stay Updated</h3>
                    <p class="mb-0">Subscribe to our newsletter for the latest products and exclusive offers.</p>
                </div>
                <div class="col-md-6">
                    <form class="d-flex gap-2">
                        <input type="email" class="form-control" placeholder="Enter your email">
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.feature-box {
    transition: transform 0.3s ease;
}

.feature-box:hover {
    transform: translateY(-5px);
}

.hero-section {
    margin-top: -2rem;
}
</style>
@endpush