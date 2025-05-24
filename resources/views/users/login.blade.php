@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card login-card mt-5">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="text-center mb-0">Welcome Back</h4>
                    <p class="text-center text-muted mb-0">Sign in to your account</p>
                </div>
                <div class="card-body px-4 pb-4">
                    <!-- Display Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Social Login Buttons -->
                    <div class="social-login mb-4">
                        <a href="{{ route('social.redirect', 'facebook') }}" class="social-btn facebook-btn">
                            <i class="fab fa-facebook-f"></i>
                            Continue with Facebook
                        </a>
                        <a href="{{ route('social.redirect', 'github') }}" class="social-btn github-btn">
                            <i class="fab fa-github"></i>
                            Continue with GitHub
                        </a>
                    </div>

                    <div class="divider">
                        <span>OR</span>
                    </div>

                    <!-- Traditional Login Form -->
                    <form method="POST" action="{{ route('do_login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Sign In
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            @endif
                        </div>

                        <div class="text-center mt-2">
                            <span class="text-muted">Don't have an account?</span>
                            <a href="{{ route('register') }}" class="text-decoration-none">Sign up</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .social-btn {
        width: 100%;
        margin-bottom: 10px;
        padding: 12px;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    .social-btn i {
        margin-right: 10px;
        font-size: 18px;
    }
    .facebook-btn {
        background-color: #1877f2;
        color: white;
        border: none;
    }
    .facebook-btn:hover {
        background-color: #166fe5;
        color: white;
    }
    .github-btn {
        background-color: #333;
        color: white;
        border: none;
    }
    .github-btn:hover {
        background-color: #24292e;
        color: white;
    }
    .divider {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }
    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #dee2e6;
    }
    .divider span {
        background: white;
        padding: 0 15px;
        color: #6c757d;
        font-size: 14px;
    }
    .login-card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: none;
        border-radius: 12px;
    }
</style>
