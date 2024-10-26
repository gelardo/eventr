<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Event Invitation</title>
    <style>
        /* Inline styling for better compatibility with email clients */
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; }
        .header { background-color: #007BFF; color: #ffffff; padding: 20px; text-align: center; }
        .content { padding: 20px; font-size: 16px; line-height: 1.6; color: #333333; }
        .footer { text-align: center; font-size: 12px; color: #888888; padding: 20px; }
        .btn { display: inline-block; padding: 10px 20px; color: #ffffff; background-color: #28a745; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ __("You're Invited!") }}</h1>
        </div>
        <div class="content">
            <p>Hello</p>
            <p>We are excited to invite you to our upcoming event:</p>
            <h2>{{ $event->title }}</h2>
            <p>{{ $event->description }}</p>
            <p><strong>Date:</strong> {{ $event->start_datetime->format('F j, Y') }}</p>
            <p><strong>Time:</strong> {{ $event->start_datetime->format('h:i A') }} - {{ $event->end_datetime->format('h:i A') }}</p>
            <p>We look forward to seeing you there!</p>
            <p>Best regards,<br>The Events Team</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Our Company. All rights reserved.
        </div>
    </div>
</body>
</html>
