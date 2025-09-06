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
        <div class="row align-items-center">
            <div class="col-2 d-flex justify-content-center">
                <img src="{{ asset('images/logo.png') }}" style="height:130px;padding:0" alt="SQL Safari"
                    class="game-logo">
            </div>

            <div class="col-8 d-flex justify-content-center">
                <!-- optional centered title or nav -->
            </div>

            <div class="col-1 d-flex justify-content-center">
                <a href="{{ route('achievements') }}" class="text-decoration-none"
                    style="display:inline-block; padding:6px 10px; border-radius:9999px; background:#f3f4f6; font-weight:600;">
                    Achievements
                </a>
            </div>

            <div class="col-1 d-flex justify-content-center">
            </div>
        </div>
        <div class="row align-items-center">

            <div class="col-11 d-flex justify-content-center">
                <!-- optional centered title or nav -->
            </div>
            <div class="col-1" style="margin-left:-125px;margin-top:-40px">
                <a href="#" class="text-decoration-none"
                    style="color:aliceblue;padding:6px;border-radius:9999px; background:#ed078a; font-weight:600;"
                    data-bs-toggle="modal" data-bs-target="#resetModal">
                    Reset Game
                </a>
            </div>
        </div>

    </header>

    <main class="game-container">
        @yield('content')
    </main>

    <footer class="game-footer">
        <button class="nav-btn" onclick="window.history.back()">⬅ Back</button>

        <form action="{{ route('sql.intro.next') }}" method="GET" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-primary">Next</button>
        </form>

    </footer>

    <!-- Warning Modal -->
    <div class="modal fade" id="resetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">⚠️ Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to reset the game?
                    This will permanently delete your current progress!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <form action="{{ route('game.reset') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Continue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')
</body>
<script>
    const clickSound = new Audio("{{ asset('audio/run-btn-sound.mp3') }}");
    document.getElementById("run-btn").addEventListener("click", () => {
        clickSound.currentTime = 0; // restart if clicked repeatedly
        clickSound.play();
    });

    const taskWin = new Audio("{{ asset('audio/task-win-sound.mp3') }}");

    function playTaskWinSound() {
        taskWin.currentTime = 0;
        taskWin.play();
    }

    const levelWin = new Audio("{{ asset('audio/level-win-sound.mp3') }}");

    function playLevelWinSound() {
        levelWin.currentTime = 0;
        levelWin.play();
    }
</script>

</html>
