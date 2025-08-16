<!DOCTYPE html>
<html>

<head>
    <title>SQL Game - {{ $level->province }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        textarea {
            width: 100%;
            height: 120px;
        }

        #result {
            margin-top: 15px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        #next-level {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>SQL Travels – Province: {{ $level->province }}</h2>
    <p><b>Story:</b> {{ $level->story }}</p>
    <p><b>Task:</b> {{ $task->task }}</p>

    <form id="sqlForm">
        <textarea name="query" placeholder="Write your SQL here..."></textarea><br>
        <button type="submit">Run Query</button>
    </form>

    <div id="result"></div>
    <div id="next-level"></div>

    <script>
        document.getElementById('sqlForm').addEventListener('submit', function(e) {
            e.preventDefault();

            fetch('/sql-game/{{ $level->id }}/run', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        query: document.querySelector('textarea').value,
                        task_id: {{ $task->id }}
                    })
                })
                .then(res => res.json())
                .then(data => {
                    let output = `<p>${data.message}</p>`;
                    if (data.result) {
                        output += `<pre>${JSON.stringify(data.result, null, 2)}</pre>`;
                    }
                    if (data.clue) {
                        output += `<p><i>💡 Hint: ${data.clue}</i></p>`;
                    }
                    document.getElementById('result').innerHTML = output;

                    // ✅ Auto redirect if next level unlocked
                    if (data.success && data.next_level) {
                        document.getElementById('next-level').innerHTML =
                            `<p>🎉 Level cleared! Redirecting to Level ${data.next_level}...</p>`;
                        setTimeout(() => {
                            window.location.href = `/sql-game/${data.next_level}`;
                        }, 2000);
                    }
                    // ✅ Reload current page if next task exists
                    else if (data.success) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                });
        });
    </script>
</body>

</html>
