<html>
<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }
    </style>
</head>
<body>
<p>Hello {{ $name }},</p>

<p>Your account has been approved. Please <a target="_blank" href="{{ env('APP_URL').'/chat' }}">click here</a> to chat.</p>

<p>Thank you for choosing GameChanger7.</p>

<p>Best regards,</p>
<p>GameChanger7 Team</p>

</body>
</html>