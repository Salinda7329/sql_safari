@extends('layouts.app')

@section('title', 'Level 1 - Colombo')

@section('content')
    <div class="level-screen">
        <div class="city-banner row">
            <div class="col-10">
                <h2>🌴 Colombo, Sri Lanka</h2>
            </div>
            <div class="col">
                <span style="background:#dc3545; color:#fff; padding:6px 12px; border-radius:9999px; display:inline-block;"
                    title="Remaining Attempts">
                    Attempts left: <span id="attempts-left">{{ $progress->attempts_left }}</span>
                </span>
            </div>
        </div>

        <div class="row">
            <div class="col-2">
                <div class="character-section">
                    <img id="nila-img" src="{{ asset('images/nila.png') }}" alt="Nila" class="character nila d-none">
                    <img id="ravi-img" src="{{ asset('images/ravi.png') }}" alt="Ravi" class="character ravi d-none">
                </div>
            </div>
            <div class="col-8">
                <div id="reference-tables" class="mt-4 d-none"></div>
                <div class="task-box d-none" id="task-text-box">
                    <h3>📝 Task</h3>
                    <p>{{ $task->task }}</p>
                    <textarea id="query-box" class="sql-input form-control mb-3" rows="3" placeholder="Write your SQL query here..."></textarea>
                    <button id="run-btn" class="btn btn-primary">Run Query</button>
                </div>
            </div>
            <div class="col-2">
                <img id="alex-img" src="{{ asset('images/alex.png') }}" alt="Alex" class="character alex d-none">
            </div>
        </div>
    </div>

    <!-- Character messages Bootstrap Modal -->
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
    {{-- Help Guide Model  --}}
    <div class="modal fade" id="helpModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content bg-light text-dark">
                <div class="modal-header">
                    <h5 class="modal-title">📖 Help Guide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="help-content"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Result Modal -->
    <div class="modal fade" id="resultModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-light text-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">📊 Query Result</h5>
                    <button type="button" id="result_model_close" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="result-content"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Warning Modal -->
    <div class="modal fade" id="warningModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">⚠️ Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Please Enter a Query Before Selecting Run Query.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Wrong Query Modal -->
    <div class="modal fade" id="wrongQueryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">⚠️ Wrong Query</h5>
                    <button type="button" id="wbtn" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="sql_error"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
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
            "alex": "{{ asset('images/alex.png') }}",
            "professor": "{{ asset('images/professor.png') }}"
        };

        function setDialogue(speaker, message) {
            document.getElementById("dialogue-character").src = images[speaker] || "";
            document.getElementById("dialogue-text").innerHTML = message; // allow HTML for buttons
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

        function loadReferenceTables(taskId, showRows = false, rows = []) {
            fetch(`/sql-game/reference-tables/${taskId}`)
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById("reference-tables");
                    container.innerHTML = "";

                    if (data.error) {
                        container.innerHTML = `<p class="text-danger">${data.error}</p>`;
                        return;
                    }

                    for (const [table, info] of Object.entries(data)) {
                        if (info.error) {
                            container.innerHTML += `<p class="text-danger">${info.error}</p>`;
                            continue;
                        }

                        let html = `<h5 class="mt-3">📊 ${table}</h5>`;
                        html += "<table class='table table-bordered table-sm'><thead><tr>";

                        info.columns.forEach(col => {
                            html += `<th>${col}</th>`;
                        });
                        html += "</tr></thead><tbody>";

                        // ✅ only show rows if flag is true
                        if (showRows && rows.length > 0) {
                            rows.forEach(row => {
                                html += "<tr>";
                                info.columns.forEach(col => {
                                    html += `<td>${row[col] ?? ''}</td>`;
                                });
                                html += "</tr>";
                            });
                        }

                        html += "</tbody></table>";
                        container.innerHTML += html;
                    }
                })
                .catch(err => {
                    console.error(err);
                    document.getElementById("reference-tables").innerHTML =
                        "<p class='text-danger'>Failed to load reference tables.</p>";
                });
        }


        function showHelpModal(helpText) {
            document.getElementById("help-content").innerHTML = helpText;
            const helpModal = new bootstrap.Modal(document.getElementById("helpModal"), {
                backdrop: 'static',
                keyboard: false
            });
            helpModal.show();
        }

        //when warning modal is closed, enable run button
        document.getElementById("warningModal").addEventListener("hidden.bs.modal", function() {
            document.getElementById('run-btn').disabled = false;
        });

        // 🔹 On page load → show dialogue chain with Nila → Alex → Nila
        document.addEventListener("DOMContentLoaded", () => {
            showDialogueChain([{
                    speaker: "nila",
                    text: @json($task->introduction)
                },
                {
                    speaker: "alex",
                    text: @json($task->task_accepting),
                    action: () => document.getElementById("reference-tables").classList.remove("d-none")
                },
                {
                    speaker: "nila",
                    text: @json($task->task),
                    action: () => document.getElementById("task-text-box").classList.remove("d-none")
                }
            ], () => {
                document.getElementById("nila-img").classList.remove("d-none");
                document.getElementById("alex-img").classList.remove("d-none");
            });
        });

        // Run query logic
        document.getElementById('run-btn').addEventListener('click', function() {
            //disable run button to prevent multiple clicks
            this.disabled = true;
            let query = document.getElementById('query-box').value;

            if (!query) {
                // Show modal if query is empty
                let warning_modal = new bootstrap.Modal(document.getElementById('warningModal'));
                warning_modal.show();
                return;
            }

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
                    // 🔹 Update attempts counter
                    if (data.attempts_left !== undefined) {
                        document.getElementById('attempts-left').textContent = data.attempts_left;
                    }

                    // 🔹 Prepare result modal
                    const resultContent = document.getElementById("result-content");
                    resultContent.innerHTML = "";

                    // Prepare wrong query modal
                    const sql_error = document.getElementById("sql_error");
                    sql_error.innerHTML = "";
                    // 🔹 Render raw DB result or error
                    // if (data.result && data.result.length > 0) {
                    if (data.message === "correct") {
                        //disable run button to prevent multiple clicks
                        this.disabled = true;
                        let table = "<table class='table table-bordered table-sm'><thead><tr>";
                        Object.keys(data.result[0]).forEach(col => {
                            table += `<th>${col}</th>`;
                        });
                        table += "</tr></thead><tbody>";
                        data.result.forEach(row => {
                            table += "<tr>";
                            Object.values(row).forEach(val => {
                                table += `<td>${val}</td>`;
                            });
                            table += "</tr>";
                        });
                        table += "</tbody></table>";
                        resultContent.innerHTML = table;
                        document.getElementById("modal_title").innerHTML = "✅ Correct! Result.";

                    } else if (data.message === "wrong_answer") {

                        // sql_error.innerHTML =
                        //     `<p class="text-danger">"❌ Wrong query"}</p>`;
                        // // Show wrong query modal
                        // const resultwrongQueryModal = new bootstrap.Modal(document.getElementById(
                        //     "wrongQueryModal"), {
                        //     backdrop: 'static',
                        //     keyboard: false
                        // });
                        // resultwrongQueryModal.show();

                        // document.getElementById("wrongQueryModal").addEventListener("hidden.bs.modal",
                        //     function onClose() {
                        //         this.removeEventListener("hidden.bs.modal", onClose);

                        let table = "<table class='table table-bordered table-sm'><thead><tr>";

                        Object.keys(data.result[0]).forEach(col => {
                            table += `<th>${col}</th>`;
                        });
                        table += "</tr></thead><tbody>";
                        data.result.forEach(row => {
                            table += "<tr>";
                            Object.values(row).forEach(val => {
                                table += `<td>${val}</td>`;
                            });
                            table += "</tr>";
                        });
                        table += "</tbody></table>";
                        resultContent.innerHTML = table;

                        document.getElementById("modal_title").innerHTML =
                            "⚠️ Wrong Query..fix your SQL.. Try Again";

                        // });

                    } else {

                        document.getElementById("modal_title").innerHTML = "🔺 Error";

                        resultContent.innerHTML =
                            `<p class="mb-0">Nothing to Show.. Your Query is Wrong.. Try Again</p>`;

                        // Add error styling
                        resultContent.classList.add("bg-danger", "text-white", "p-3", "rounded");
                    }

                    // ✅show result modal
                    const resultModal = new bootstrap.Modal(document.getElementById("resultModal"), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    resultModal.show();

                    // 🔹 When modal is closed → trigger game logic
                    document.getElementById("resultModal").addEventListener("hidden.bs.modal",
                        function onClose() {
                            this.removeEventListener("hidden.bs.modal", onClose);

                            // Reset modal title
                            document.getElementById("modal_title").innerHTML = "Result";

                            // Reset content
                            resultContent.innerHTML = "";
                            resultContent.classList.remove("bg-danger", "text-white", "p-3", "rounded");

                            // 🔹 Game logic after showing results
                            if (data.success) {
                                // also load reference tables with rows
                                loadReferenceTables({{ $task->id }}, true, data.result);

                                if ({{ $task->id }} == 3) {
                                    showDialogueChain([{
                                            speaker: "alex",
                                            text: "I'll stay in Colombo Grand Hotel"
                                        },
                                        {
                                            speaker: "nila",
                                            text: "Okay, let’s check in to the hotel"
                                        },
                                        {
                                            speaker: "professor",
                                            text: `You have mastered the basics! Now it's time to earn your first badge.
                   <br><br>
                   <button class='btn btn-success' onclick="awardBadge(1)">🎖️ Get Badge</button>`,
                                            action: () => {
                                                // 👇 hide continue when this dialogue is shown
                                                document.getElementById("dialogue-continue")
                                                    .style.display = "none";
                                            }
                                        }
                                    ]);
                                } else {
                                    playTaskWinSound();
                                    // Hide the default continue button
                                    document.getElementById("dialogue-continue").style.display = "none";
                                    showDialogueChain([{
                                        speaker: "nila",
                                        text: "✅ Good work, Alex! <br><br><button class='btn btn-primary' onclick=\"window.location.reload()\">Next Task ➡️</button>"
                                    }]);
                                }

                            } else {
                                // ❌ Incorrect query logic
                                if (data.attempts_left > 0) {
                                    showDialogueChain([{
                                        speaker: "ravi",
                                        text: data.clue ? "💡 " + data.clue : data.message
                                    }]);
                                } else {
                                    showHelpModal(@json($task->help));
                                }
                            }
                            // Re-enable run button
                            document.getElementById('run-btn').disabled = false;
                        });
                });
        });

        function awardBadge(id) {
            playLevelWinSound();
            fetch(`/achievements/award/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest', // <-- makes $request->ajax() true
                        'Accept': 'application/json'
                    }
                })
                .then(async (res) => {
                    if (!res.ok) throw new Error(await res.text());
                    return res.json();
                })
                .then((data) => {
                    // ✅ Update the dialogue modal content
                    document.getElementById("dialogue-character").src = "{{ asset('images/professor.png') }}";
                    document.getElementById("dialogue-text").innerHTML = `
            🎉 ${data.message || 'Badge awarded!'} <br><br>
            <button class="btn btn-primary" onclick="window.location.href='${data.redirect || '/achievements'}'">
                Go to Achievements
            </button>
        `;

                    // Hide the continue button
                    document.getElementById("dialogue-continue").style.display = "none";

                    // Show the modal
                    dialogueModal.show();
                })
                .catch((err) => {
                    console.error(err);

                    document.getElementById("dialogue-character").src = "{{ asset('images/professor.png') }}";
                    document.getElementById("dialogue-text").innerHTML = `❌ Failed to award badge. Please try again.`;
                    document.getElementById("dialogue-continue").style.display = "none";

                    dialogueModal.show();
                });
        }


        document.addEventListener("DOMContentLoaded", () => {
            loadReferenceTables({{ $task->id }});
        });
    </script>
@endsection
