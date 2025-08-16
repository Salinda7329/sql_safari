@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>SQL Travels – Province: {{ $level->province }}</h2>
        <p><b>Story:</b> {{ $level->story }}</p>
        <pre><b>Dialogue:</b> {{ $level->dialogue }}</pre>

        <div id="task-container">
            @foreach ($tasks as $task)
                <div class="task-block" data-task-id="{{ $task->id }}">
                    <p><b>Task:</b> {{ $task->task }}</p>
                    <textarea class="query-box" placeholder="Write your SQL here..."></textarea><br>
                    <button class="run-btn">Run Query</button>
                    <div class="result"></div>
                </div>
                <hr>
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
                        if (data.success && data.next_level) {
                            document.getElementById('next-level').innerHTML =
                                `<a href="/sql-game/${data.next_level}" class="btn btn-success">➡ Go to Next Level</a>`;
                        }
                    });
            });
        });
    </script>
@endsection
