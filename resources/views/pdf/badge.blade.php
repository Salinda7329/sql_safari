<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }

        .certificate {
            border: 10px solid gold;
            padding: 40px;
        }

        h1 {
            color: #ff6600;
        }
    </style>
</head>

<body>
    <div class="certificate">
        <h1>🏆 Certificate of Achievement</h1>
        <p>This is proudly presented to</p>
        <h2>{{ $user->name }}</h2>
        <p>for earning the badge:</p>
        <h3>{{ $achievement->name }}</h3>
        <img src="{{ public_path('images/badges/' . $achievement->badge_image) }}" width="120">
        <p>{{ $achievement->description }}</p>
        <p><i>Issued on {{ now()->toFormattedDateString() }}</i></p>
    </div>
</body>

</html>
