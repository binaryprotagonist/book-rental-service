<!DOCTYPE html>
<html>
<head>
    <title>Overdue Rental Notification</title>
</head>
<body>
    <h1>Dear {{ $rental->user->name }},</h1>
    <p>We wanted to remind you that your rental for the book titled <strong>{{ $rental->book->title }}</strong> is overdue.</p>
    <p>Please return the book as soon as possible to avoid further penalties.</p>
    <p>Overdue Date: {{ \Carbon\Carbon::parse($rental->overdue_date)->format('d-M-Y') }}</p>
    <p>Thank you for using our service.</p>
</body>
</html>
