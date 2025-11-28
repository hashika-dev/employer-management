<!DOCTYPE html>
<html>
<head>
    <title>Welcome to StaffFlow</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { background-color: #ffffff; padding: 30px; border-radius: 8px; max-width: 500px; margin: 0 auto; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #3b82f6; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #1e293b; }
        .content { color: #334155; line-height: 1.6; }
        .box { background-color: #f1f5f9; padding: 15px; border-radius: 6px; margin: 20px 0; border: 1px solid #cbd5e1; }
        .label { font-weight: bold; color: #475569; }
        .value { color: #0f172a; font-family: monospace; font-size: 16px; }
        .button { display: block; width: 100%; text-align: center; background-color: #3b82f6; color: #ffffff; padding: 12px 0; border-radius: 6px; text-decoration: none; font-weight: bold; margin-top: 20px; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">StaffFlow System</div>
        </div>
        
        <div class="content">
            <p>Welcome to the team! Your account has been created.</p>
            
            <p>Please log in using your <strong>Employee Number</strong> and the default password below:</p>
            
            <div class="box">
                <div><span class="label">Employee Number:</span> <span class="value">{{ $user->employee_number }}</span></div>
                <div style="margin-top: 10px;"><span class="label">Password:</span> <span class="value">{{ $password }}</span></div>
            </div>

            <p>For your security, please change your password immediately after logging in.</p>

            <a href="{{ route('login') }}" class="button">Login to Portal</a>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} StaffFlow Management. All rights reserved.
        </div>
    </div>
</body>
</html>