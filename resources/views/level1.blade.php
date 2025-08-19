@extends('layouts.app')

@section('title', 'Level 1 - Colombo')

@section('content')
    <div class="level-screen">
        <div class="city-banner">
            <h2>🌴 Colombo, Sri Lanka</h2>
        </div>

        <div class="character-section">
            <img id="nila-img" src="{{ asset('images/nila.png') }}" alt="Nila" class="character nila d-none">
            <img id="ravi-img" src="{{ asset('images/ravi.png') }}" alt="Ravi" class="character ravi d-none">
            <img id="alex-img" src="{{ asset('images/alex.png') }}" alt="Alex" class="character alex d-none">
        </div>

        <div class="task-box d-none" id="task-text-box">
            <h3>📝 Task</h3>
            <p>{{ $task->task }}</p>
            <textarea id="query-box" class="sql-input form-control mb-3" rows="3" placeholder="Write your SQL query here..."></textarea>
            <button id="run-btn" class="btn btn-primary">Run Query</button>
            <div id="result" class="result-box mt-3"></div>
        </div>

        <div class="db-preview mt-4 d-none" id="db-table-preview">
            <h3>📊 Database Preview</h3>
            <div id="db-tables"></div>
        </div>


        <div class="attempts-box mt-3">
            Attempts left: <span id="attempts-left">{{ $progress->attempts_left }}</span>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="dialogueModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-3">
                <img id="dialogue-character" src="" class="img-fluid mx-auto d-block" style="max-width:150px;">
                <div class="modal-body">
                    <p id="dialogue-text" class="fs-5"></p>
                    <button type="button" id="dialogue-continue" class="btn btn-warning mt-3">Continue</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .character-section {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin: 30px 0;
        }

        .character {
            width: 150px;
            border-radius: 10px;
        }

        .hidden {
            display: none !important;
        }

        .db-preview table {
            background: #fff;
            font-size: 0.9rem;
            border: 1px solid #ddd;
        }

        .db-preview th {
            background: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .db-preview tr:nth-child(even) {
            background: #8f8c8c;
        }
    </style>
@endsection

@section('scripts')
    <script>
        const dialogueModalEl = document.getElementById('dialogueModal');
        const dialogueModal = new bootstrap.Modal(dialogueModalEl, {
            backdrop: 'static',
            keyboard: false
        });

        const images = {
            "nila": "{{ asset('images/nila.png') }}",
            "ravi": "{{ asset('images/ravi.png') }}",
            "alex": "{{ asset('images/alex.png') }}"
        };

        function setDialogue(speaker, message) {
            document.getElementById("dialogue-character").src = images[speaker] || "";
            document.getElementById("dialogue-text").textContent = message;
        }

        function showDialogueChain(dialogues, onComplete) {
            let index = 0;

            function renderDialogue() {
                setDialogue(dialogues[index].speaker, dialogues[index].text);
                if (typeof dialogues[index].action === "function") {
                    dialogues[index].action();
                }
            }

            renderDialogue();
            dialogueModal.show();

            const btn = document.getElementById("dialogue-continue");
            btn.onclick = () => {
                index++;
                if (index < dialogues.length) {
                    renderDialogue();
                } else {
                    dialogueModal.hide();
                    if (onComplete) onComplete();
                }
            };
        }


        // 🔹 On page load → show dialogue chain with Nila → Alex → Nila
        document.addEventListener("DOMContentLoaded", () => {
            showDialogueChain([{
                    speaker: "nila",
                    text: "🌴 Welcome to Sri Lanka! I am Nila, your tour guide. I’ll help you practice SQL by finding hotels in Colombo. 🌆"
                },
                {
                    speaker: "alex",
                    text: "Hi Nila! Sounds interesting, I’m ready to try.",
                    action: () => {
                        document.getElementById("db-table-preview").classList.remove("d-none");
                    }
                },
                {
                    speaker: "nila",
                    text: "Great! Let’s begin with something simple, Alex. Show me all the hotels in our database.",
                    action: () => {
                        document.getElementById("task-text-box").classList.remove("d-none");
                    }
                }
            ], () => {
                // Reveal character images after dialogues finish
                document.getElementById("nila-img").classList.remove("d-none");
                document.getElementById("alex-img").classList.remove("d-none");
            });
        });



        // Run query logic stays the same
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
                .then(async data => {
                    if (data.attempts_left !== undefined) {
                        document.getElementById('attempts-left').textContent = data.attempts_left;
                    }

                    if (data.success) {
                        const taskDialogues = {
                            1: {
                                speaker: "nila",
                                text: "✅ Good work, Alex!"
                            },
                            2: {
                                speaker: "ravi",
                                text: "Great job! Now, can you list the tourists and where they come from?"
                            },
                            3: {
                                speaker: "nila",
                                text: "Perfect! Now, can you show me the different nationalities of all tourists?"
                            }
                        };

                        if (taskDialogues[{{ $task->id }}]) {
                            showDialogueChain([taskDialogues[{{ $task->id }}]]);
                        }

                        if ({{ $task->id }} == 3) {
                            showDialogueChain([{
                                    speaker: "nila",
                                    text: "🎉 Excellent start, Alex! You’ve mastered the basics."
                                },
                                {
                                    speaker: "nila",
                                    text: "Let’s head to Kandy next!"
                                }
                            ], () => window.location.href = "/sql-game/2");
                        } else {
                            setTimeout(() => window.location.reload(), 2500);
                        }
                    } else {
                        let speaker = Math.random() > 0.5 ? "nila" : "ravi";
                        showDialogueChain([{
                            speaker: speaker,
                            text: data.clue ? "Hint: " + data.clue : data.message
                        }]);
                    }
                });
        });

        function loadSchema() {
            fetch(`/sql-game/{{ $level->id }}/schema`)
                .then(res => res.json())
                .then(data => {
                    let html = `<h5 class="mb-3">Table: <code>${data.table}</code></h5>`;
                    html += '<table class="table table-bordered table-striped">';

                    // Table headers
                    html += '<thead><tr>';
                    data.columns.forEach(col => {
                        html += `<th>${col.Field}</th>`;
                    });
                    html += '</tr></thead><tbody>';

                    // Rows
                    data.rows.forEach(row => {
                        html += '<tr>';
                        data.columns.forEach(col => {
                            html += `<td>${row[col.Field]}</td>`;
                        });
                        html += '</tr>';
                    });

                    html += '</tbody></table>';
                    document.getElementById('db-tables').innerHTML = html;
                });
        }

        // 🔹 Load schema preview when page loads
        document.addEventListener("DOMContentLoaded", () => {
            loadSchema();
        });
    </script>
@endsection
