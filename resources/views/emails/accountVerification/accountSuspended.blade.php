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

<p>Your account has been suspend due to the following reason:</p>

<p><strong>{{ $reason }}</strong></p>
    
<p>Please navigate to the documents tab by <a target="_blank" href="{{ env('APP_URL').'/profile' }}">clicking here</a> to resubmit your verification documents.</p>

<p>Best regards,</p>
<p>GameChanger7 Team</p>

</body>
</html>