<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Safari - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/game.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @yield('head')
</head>

<body>
    <header class="game-header">
        <img src="{{ asset('images/logo.png') }}" alt="SQL Safari" class="game-logo">
    </header>

    <main class="game-container">
        @yield('content')
    </main>

    <footer class="game-footer">
        <button class="nav-btn" onclick="window.history.back()">⬅ Back</button>

        <form action="{{ route('sql.next') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-primary">Next ▶</button>
        </form>
    </footer>


    @yield('scripts')
</body>

</html>
