@extends('layouts.app')

@section('content')
    <div class="game-screen">
        <div class="dialogue-box">
            <p>👩‍💻 {{ $level->dialogue }}</p>
        </div>

        <div class="task-panel">
            <h4>Task</h4>
            <p>{{ $task->task }}</p>
            <textarea id="query-box" class="form-control" rows="3" placeholder="Write your SQL here..."></textarea>
            <button id="run-btn" class="btn btn-primary mt-2">Run Query</button>
            <div id="result" class="mt-3"></div>
        </div>

        <div class="footer-controls">
            <span>Attempts left: <b id="attempts-left">{{ $progress->attempts_left }}</b></span>
            <button class="btn btn-secondary" onclick="window.history.back()">⬅ Back</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('run-btn').addEventListener('click', function() {
            let query = document.getElementById('query-box').value;

            fetch(`/sql-game/{{ $level->id }}/run`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        query: query,
                        task_id: {{ $task->id }}
                    })
                })
                .then(res => res.json())
                .then(data => {
                    let resultBox = document.getElementById('result');
                    resultBox.innerHTML = `<p>${data.message}</p>`;
                    if (data.result) {
                        resultBox.innerHTML += `<pre>${JSON.stringify(data.result, null, 2)}</pre>`;
                    }
                    if (data.clue) {
                        resultBox.innerHTML += `<p><i>Hint: ${data.clue}</i></p>`;
                    }
                    if (data.attempts_left !== undefined) {
                        document.getElementById('attempts-left').textContent = data.attempts_left;
                    }
                    if (data.success) {
                        setTimeout(() => {
                            window.location.reload(); // load next task in same level
                        }, 1500);
                    }
                });
        });
    </script>
@endsection
