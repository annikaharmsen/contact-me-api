<!DOCTYPE html>
<html>
<head>
    <title>Confirmation: Your message has been sent!</title>
</head>
<body>
    <p>Thank you for reaching out! Your message has been sent to my inbox.</p>

    <p>
        <span style='color: gray'>Your message:</span>
        <br/>
        <span style='font-weight: bold'>Subject: {{ $data['subject'] }}</span>
        <br/>
        {{ $data['message']}}
    </p>
    <p style='color: gray'>Form accessed from {{ config('app.request_domain') }}</p>
</body>
</html>
