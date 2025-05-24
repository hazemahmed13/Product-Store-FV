@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Login</h4>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{route('do_login')}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">
                                    <strong>Error!</strong> {{$error}}
                                </div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" placeholder="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="password" name="password" required>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('password.request') }}" class="btn btn-link">Forgot Your Password?</a>
                        </div>
                        <div class="text-center mt-3">
                             <a href="{{ url('auth/google') }}" class="btn btn-outline-primary">
                                 Login with Google
                             </a>
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
