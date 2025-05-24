@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Change Password</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('save_password', $user->id) }}" method="POST">
                        @csrf
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(auth()->id() == $user->id)
                            <div class="mb-3">
                                <label for="old_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror" 
                                       id="old_password" name="old_password" required>
                                @error('old_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="showPasswordToggle" onclick="togglePasswordVisibility()">
                            <label class="form-check-label" for="showPasswordToggle">
                                Show Passwords
                            </label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('users.profile', $user->id) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function togglePasswordVisibility() {
    const pwFields = ['password', 'password_confirmation', 'old_password'];
    pwFields.forEach(function(id) {
        const field = document.getElementById(id);
        if (field) {
            field.type = field.type === 'password' ? 'text' : 'password';
        }
    });
}
</script>
@endsection

















































