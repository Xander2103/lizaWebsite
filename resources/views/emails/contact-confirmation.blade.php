<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>We received your message</title>
</head>
<body style="font-family: Arial, sans-serif; color: #10202f; line-height: 1.6;">
    <p>Dear {{ $data['name'] ?? 'there' }},</p>

    <p>
        Thank you for your message. Your request has been received successfully.
    </p>

    <p>
        Dr Sue-Liza Eta or her team will review your message and get back to you as soon as possible.
    </p>

    <p>
        Please note that this contact form is not intended for urgent medical issues.
        For urgent matters, please contact the clinic by phone or book directly via Doctoranytime.
    </p>

    <p>
        Kind regards,<br>
        Dr Sue-Liza Eta<br>
        Stockel Medical Center
    </p>
</body>
</html>