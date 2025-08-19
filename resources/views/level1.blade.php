@extends('layouts.app')

@section('title', 'Level 1 - Colombo')

@section('content')
    <div class="level-screen">
        <div class="city-banner">
            <h2>🌴 Colombo, Sri Lanka</h2>
        </div>

        <div class="character-section">
            <img src="{{ asset('images/nila.png') }}" alt="Nila" class="character nila">
            <img src="{{ asset('images/ravi.png') }}" alt="Ravi" class="character ravi">
            <img src="{{ asset('images/alex.png') }}" alt="Alex" class="character alex">
        </div>

        <div class="task-box">
            <h3>📝 Task</h3>
            <p>{{ $task->task }}</p>
            <textarea id="query-box" class="sql-input form-control mb-3" rows="3" placeholder="Write your SQL query here..."></textarea>
            <button id="run-btn" class="btn btn-primary">Run Query</button>
            <div id="result" class="result-box mt-3"></div>
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

        function showDialogueChain(dialogues) {
            let index = 0;
            setDialogue(dialogues[index].speaker, dialogues[index].text);
            dialogueModal.show();

            const btn = document.getElementById("dialogue-continue");
            btn.onclick = () => {
                index++;
                if (index < dialogues.length) {
                    setDialogue(dialogues[index].speaker, dialogues[index].text);
                } else {
                    dialogueModal.hide();
                }
            };
        }

        // 🔹 Show intro dialogues on page load
        document.addEventListener("DOMContentLoaded", () => {
            showDialogueChain([{
                    speaker: "nila",
                    text: "🌴 Welcome to Sri Lanka! I am Nila, your tour guide. I’ll help you practice SQL by finding hotels in Colombo. 🌆"
                },
                {
                    speaker: "nila",
                    text: "Let’s begin with something simple, Alex. Show me all the hotels in our database."
                }
            ]);
        });

        // Example usage on query run
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
                            ]);
                            setTimeout(() => window.location.href = "/sql-game/2", 3500);
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
    </script>
@endsection
