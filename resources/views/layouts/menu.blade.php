<nav class="navbar navbar-expand-sm bg-white navbar-light mb-4">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                       href="{{ url('/') }}">Home</a>
                </li>

                @unlessrole('driver')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" 
                       href="{{ route('products.index') }}">Products</a>
                </li>
                
                @unlessrole('manager')
                <li class="nav-item position-relative">
                    <a class="nav-link" href="{{ route('cart.show') }}">
                        <i class="fas fa-shopping-cart"></i>
                        Cart
                        @php $cartCount = session('cart') ? collect(session('cart'))->sum('quantity') : 0; @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </li>
                @endunlessrole
                @endunlessrole

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.favourites') ? 'active' : '' }}" 
                       href="{{ route('products.favourites') }}">
                        <i class="fas fa-star"></i> Favourites
                    </a>
                </li>

                @auth
                    @role('manager')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.manage') ? 'active' : '' }}" href="{{ route('users.manage') }}">
                            <i class="fas fa-users-cog"></i> Manage Users
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-chart-bar"></i> Reports
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
                            <li><a class="dropdown-item" href="{{ route('reports.sales') }}">Sales Report</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.products') }}">Popular Products</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.stock') }}">Stock Report</a></li>
                        </ul>
                    </li>
                    @endrole
                    @role('customer')
                    @endrole
                    
                    @hasanyrole('admin|employee')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.create') ? 'active' : '' }}" 
                           href="{{ route('products.create') }}">Add Product</a>
                    </li>
                    @endhasanyrole
                    
                    @role('admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.hero.edit') ? 'active' : '' }}" 
                           href="{{ route('admin.hero.edit') }}">
                            <i class="fas fa-image"></i> Manage Hero Section
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" 
                           href="{{ route('admin.orders.index') }}">
                            <i class="fas fa-shopping-cart"></i> Orders
                        </a>
                    </li>
                    @endrole

                    @role('driver')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('driver.orders.index') ? 'active' : '' }}" 
                           href="{{ route('driver.orders.index') }}">
                            <i class="fas fa-truck"></i> My Deliveries
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('driver.orders.status') ? 'active' : '' }}" 
                           href="{{ route('driver.orders.status') }}">
                            <i class="fas fa-clipboard-list"></i> Order Status
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('driver.locations') ? 'active' : '' }}" 
                           href="{{ route('driver.locations') }}">
                            <i class="fas fa-map-marker-alt"></i> Customer Locations
                        </a>
                    </li>
                    @endrole
                @endauth
            </ul>
            
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @else
                    @role('customer')
                    <li class="nav-item">
                        <span class="nav-link credit-balance">
                            Credit: ${{ number_format(auth()->user()->getCreditBalance(), 2) }}
                        </span>
                    </li>
                    @endrole
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('users.profile') }}">Profile</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest

                <!-- Show current date -->
                <li class="nav-item">
                    <span class="nav-link text-muted">
                        {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
                    </span>
                </li>
            </ul>
        </div>
    </div>
</nav>
