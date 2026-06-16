<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New consultation enquiry</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1C2B3A; line-height: 1.6;">
    <h2 style="margin-bottom: 1rem;">New consultation enquiry — {{ config('site.name') }}</h2>

    <p><strong>Name:</strong> {{ $submission['name'] }}</p>
    <p><strong>Email:</strong> {{ $submission['email'] }}</p>
    @if(!empty($submission['phone']))
        <p><strong>Phone:</strong> {{ $submission['phone'] }}</p>
    @endif
    <p><strong>Service:</strong> {{ $submission['request_type'] }}</p>

    <p><strong>Message:</strong></p>
    <p>{{ $submission['message'] }}</p>
</body>
</html>
