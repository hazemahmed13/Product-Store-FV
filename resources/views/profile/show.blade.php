<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }
        .social-account-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .social-account-info {
            display: flex;
            align-items: center;
        }
        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            font-size: 18px;
        }
        .facebook-icon {
            background-color: #1877f2;
        }
        .github-icon {
            background-color: #333;
        }
        .btn-link-account {
            border: 2px dashed #dee2e6;
            background: #f8f9fa;
            color: #6c757d;
        }
        .btn-link-account:hover {
            border-color: #007bff;
            color: #007bff;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <!-- Profile Header -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="Profile Picture" class="profile-avatar me-3">
                            @else
                                <div class="profile-avatar bg-secondary d-flex align-items-center justify-content-center me-3">
                                    <i class="fas fa-user text-white" style="font-size: 30px;"></i>
                                </div>
                            @endif
                            <div>
                                <h4 class="mb-0">{{ $user->name }}</h4>
                                <p class="text-muted mb-0">{{ $user->email }}</p>
                                <small class="text-muted">Member since {{ $user->created_at->format('F Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Accounts Section -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Connected Accounts</h5>
                        <small class="text-muted">Manage your social login connections</small>
                    </div>
                    <div class="card-body">
                        <!-- Display Messages -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('info'))
                            <div class="alert alert-info">
                                {{ session('info') }}
                            </div>
                        @endif

                        <!-- Facebook Account -->
                        @if($user->hasSocialAccount('facebook'))
                            <div class="social-account-card">
                                <div class="social-account-info">
                                    <div class="social-icon facebook-icon">
                                        <i class="fab fa-facebook-f"></i>
                                    </div>
                                    <div>
                                        <strong>Facebook</strong>
                                        <div class="text-muted small">Connected</div>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('profile.unlink', 'facebook') }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                            onclick="return confirm('Are you sure you want to unlink your Facebook account?')">
                                        <i class="fas fa-unlink"></i> Disconnect
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="social-account-card btn-link-account">
                                <div class="social-account-info">
                                    <div class="social-icon facebook-icon">
                                        <i class="fab fa-facebook-f"></i>
                                    </div>
                                    <div>
                                        <strong>Facebook</strong>
                                        <div class="text-muted small">Not connected</div>
                                    </div>
                                </div>
                                <a href="{{ route('profile.link', 'facebook') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-link"></i> Connect
                                </a>
                            </div>
                        @endif

                        <!-- GitHub Account -->
                        @if($user->hasSocialAccount('github'))
                            <div class="social-account-card">
                                <div class="social-account-info">
                                    <div class="social-icon github-icon">
                                        <i class="fab fa-github"></i>
                                    </div>
                                    <div>
                                        <strong>GitHub</strong>
                                        <div class="text-muted small">Connected</div>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('profile.unlink', 'github') }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to unlink your GitHub account?')">
                                        <i class="fas fa-unlink"></i> Disconnect
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="social-account-card btn-link-account">
                                <div class="social-account-info">
                                    <div class="social-icon github-icon">
                                        <i class="fab fa-github"></i>
                                    </div>
                                    <div>
                                        <strong>GitHub</strong>
                                        <div class="text-muted small">Not connected</div>
                                    </div>
                                </div>
                                <a href="{{ route('profile.link', 'github') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-link"></i> Connect
                                </a>
                            </div>
                        @endif

                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i>
                                You can use any connected social account to sign in to your account.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Back to Dashboard -->
                <div class="text-center mt-4">
                    <a href="/home" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 