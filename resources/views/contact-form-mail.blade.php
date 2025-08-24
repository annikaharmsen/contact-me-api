<!DOCTYPE html>
<html>
<head>
    <title>Contact Form Mail</title>
</head>
<body>
    <h1>{{ $data['subject'] ?? 'Contact Form' }}</h1>
    <p>{{ $data['message'] }}</p>
    <p>Form accessed from {{ config('mail.request_domain') }}</p>
</body>
</html>
