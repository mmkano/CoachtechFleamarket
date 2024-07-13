<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $subject }}</title>
    <link rel="stylesheet" href="{{ asset('css/emails/admin_notification.css') }}">
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ $subject }}</h1>
        </div>
        <div class="email-body">
            <p>{{ $messageContent }}</p>
        </div>
    </div>
</body>
</html>
