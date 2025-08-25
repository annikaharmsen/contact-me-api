<!DOCTYPE html>
<html>
<head>
    <title>Contact Form Mail</title>
</head>
<body>
    <p><span style='font-weight: bold'>{{ $data['subject'] ?? 'Contact Form' }}</span>
    <p>{{ $data['message'] }}</p>
    <p style='color: gray'>Form accessed from {{ config('app.request_domain') }}</p>
</body>
</html>
