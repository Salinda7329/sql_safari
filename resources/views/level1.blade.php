@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>🌴 SQL Travels – Province: {{ $level->province }}</h2>
        <p><b>Story:</b> {{ $level->story }}</p>
        <pre><b>Dialogue:</b> {{ $level->dialogue }}</pre>

        <div class="alert alert-info">
            Attempts left: <span id="attempts-left">{{ $progress->attempts_left }}</span>
        </div>

        <div id="task-container">
            @foreach ($tasks as $task)
                <div class="card mb-3 task-block" data-task-id="{{ $task->id }}">
                    <div class="card-body">
                        <h5 class="card-title">Task</h5>
                        <p>{{ $task->task }}</p>
                        <textarea class="form-control query-box" placeholder="Write your SQL here..."></textarea>
                        <button class="btn btn-primary mt-2 run-btn">Run Query</button>
                        <div class="result mt-3"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="next-level"></div>
    </div>
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('.run-btn').forEach(button => {
            button.addEventListener('click', function() {
                let taskBlock = this.closest('.task-block');
                let taskId = taskBlock.dataset.taskId;
                let query = taskBlock.querySelector('.query-box').value;

                fetch(`/sql-game/{{ $level->id }}/run`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            query: query,
                            task_id: taskId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        let resultBox = taskBlock.querySelector('.result');
                        resultBox.innerHTML = `<p>${data.message}</p>`;
                        if (data.result) {
                            resultBox.innerHTML += `<pre>${JSON.stringify(data.result, null, 2)}</pre>`;
                        }
                        if (data.clue) {
                            resultBox.innerHTML += `<p><i>Hint: ${data.clue}</i></p>`;
                        }

                        if (data.force_level_down) {
                            // 🚨 send the player back to previous level
                            setTimeout(() => {
                                window.location.href = "/sql-game/" + ({{ $level->id }} - 1);
                            }, 2000);
                        }

                        // update attempts counter from response
                        if (document.getElementById('attempts-left') && data.attempts_left !==
                            undefined) {
                            document.getElementById('attempts-left').textContent = data.attempts_left;
                        }
                    });
            });
        });
    </script>
@endsection
