<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
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
            background-color: #4a90e2;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4a90e2;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reset Your Password</h1>
    </div>
    
    <div class="content">
        <p>Hello {{ $name }},</p>
        
        <p>We received a request to reset your password. Click the button below to create a new password:</p>
        
        <div style="text-align: center;">
            <a href="{{ $resetLink }}" class="button">Reset Password</a>
        </div>
        
        <p>If you didn't request a password reset, you can safely ignore this email.</p>
        
        <p>This password reset link will expire in 60 minutes.</p>
        
        <p>If you're having trouble clicking the button, copy and paste this URL into your web browser:</p>
        <p style="word-break: break-all;">{{ $resetLink }}</p>
    </div>
    
    <div class="footer">
        <p>This is an automated message, please do not reply to this email.</p>
    </div>
</body>
</html> 