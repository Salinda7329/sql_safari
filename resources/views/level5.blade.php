@extends('layouts.app')

@section('title', 'Level 1 - Colombo')

@section('content')
    <div class="level-screen">
        <div class="city-banner">
            <h2>🌴 Colombo, Sri Lanka</h2>
        </div>

        <div class="character-section">
            <img src="{{ asset('images/nila.png') }}" alt="Nila" class="character nila">
            <div class="speech-bubble">
                Welcome to Sri Lanka! I am <b>Nila</b>, your tour guide.
                I’ll help you practice SQL by finding hotels in Colombo. 🌆
            </div>
            <img src="{{ asset('images/alex.png') }}" alt="Alex" class="character alex">
        </div>

        <div class="task-box">
            <h3>📝 Task</h3>
            <p>{{ $task->task }}</p>
            <textarea id="query-box" class="sql-input" rows="3" placeholder="Write your SQL query here..."></textarea>
            <button id="run-btn" class="run-query-btn">Run Query</button>
            <div id="result" class="result-box"></div>
        </div>

        <div class="attempts-box">
            Attempts left: <span id="attempts-left">{{ $progress->attempts_left }}</span>
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
                        resultBox.innerHTML += `<p class="hint">💡 Hint: ${data.clue}</p>`;
                    }
                    if (data.attempts_left !== undefined) {
                        document.getElementById('attempts-left').textContent = data.attempts_left;
                    }
                    if (data.success) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                });
        });
    </script>
@endsection
