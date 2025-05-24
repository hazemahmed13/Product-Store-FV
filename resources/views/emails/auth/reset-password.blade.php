<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Password Reset Request</h1>
    </div>
    
    <div class="content">
        <p>Hello {{ $name }},</p>
        
        <p>You are receiving this email because we received a password reset request for your account.</p>
        
        <p style="text-align: center;">
            <a href="{{ url('reset-password/' . $token) }}" class="button">Reset Password</a>
        </p>
        
        <p>This password reset link will expire in 24 hours.</p>
        
        <p>If you did not request a password reset, no further action is required.</p>
        
        <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:</p>
        <p style="word-break: break-all;">{{ url('reset-password/' . $token) }}</p>
    </div>
    
    <div class="footer">
        <p>Regards,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html> 