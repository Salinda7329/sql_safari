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
    </style>
</head>

<body>
    <h2>SQL Travels – Province: {{ $level->province }}</h2>
    <p><b>Story:</b> {{ $level->story }}</p>
    <p><b>Task:</b> {{ $level->task }}</p>

    <form id="sqlForm">
        <textarea name="query" placeholder="Write your SQL here..."></textarea><br>
        <button type="submit">Run Query</button>
    </form>

    <div id="result"></div>

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
                        query: document.querySelector('textarea').value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    let output = `<p>${data.message}</p>`;
                    if (data.result) {
                        output += `<pre>${JSON.stringify(data.result, null, 2)}</pre>`;
                    }
                    document.getElementById('result').innerHTML = output;
                });
        });
    </script>
</body>

</html>
