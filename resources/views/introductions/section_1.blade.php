@extends('layouts.app')

{{-- at the very top of the template (or just before the form) --}}
@php
    $levelId = isset($level->id) ? (int) $level->id : (int) request()->route('level');
@endphp

@section('title', 'Section 1 – Arrival in Colombo')

@section('content')
    <div class="level-screen">
        <div class="city-banner text-center">
            <h2>✈️ Arrival in Colombo</h2>
        </div>

        <!-- Start Story Button -->
        <div class="text-center mt-5">
            <button class="btn btn-lg btn-success" id="start-story">🌟 Begin Story 🌟</button>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="dialogueModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-3">
                <div class="modal-body d-flex align-items-center justify-content-between">
                    <div id="left-speaker" class="text-center flex-fill">
                        <img id="left-img" src="" class="img-fluid" style="max-width:180px; display:none;">
                        <p id="left-text" class="fs-5 mt-3"></p>
                    </div>
                    <div id="right-speaker" class="text-center flex-fill">
                        <img id="right-img" src="" class="img-fluid" style="max-width:180px; display:none;">
                        <p id="right-text" class="fs-5 mt-3"></p>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" id="dialogue-continue" class="btn btn-primary">Continue ➡️</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .city-banner h2 {
            font-size: 2rem;
            margin-top: 30px;
        }

        #left-text,
        #right-text {
            background: #fff8e7;
            border: 2px solid #ff9800;
            border-radius: 12px;
            padding: 10px;
            display: inline-block;
            max-width: 80%;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }

        #left-text {
            text-align: left;
        }

        #right-text {
            text-align: right;
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

        // Dialogue sequence
        const dialogues = [
            {
                speaker: "nila",
                side: "left",
                text: "🌴 Welcome, Alex! This is Sri Lanka — full of adventures and hidden treasures."
            },
            {
                speaker: "ravi",
                side: "right",
                text: "But first things first… after a long flight, you need a good hotel to rest."
            },
            {
                speaker: "alex",
                side: "left",
                text: "Hmm… but how do we choose the right one quickly?"
            },
            {
                speaker: "nila",
                side: "right",
                text: "There are hundreds of hotels in Colombo. Some are expensive, some are affordable."
            },
            {
                speaker: "ravi",
                side: "left",
                text: "Don’t worry! We’ll guide you. Together we’ll explore all options and meet new friends from around the world."
            },
            {
                speaker: "nila",
                side: "right",
                text: "Let’s start by exploring the hotels in Colombo. Ready to begin?"
            }
        ];

        let index = 0;

        function showDialogue(dialogue) {
            // Reset
            document.getElementById("left-img").style.display = "none";
            document.getElementById("right-img").style.display = "none";
            document.getElementById("left-text").textContent = "";
            document.getElementById("right-text").textContent = "";

            if (dialogue.side === "left") {
                document.getElementById("left-img").src = images[dialogue.speaker];
                document.getElementById("left-img").style.display = "block";
                document.getElementById("left-text").textContent = dialogue.text;
            } else {
                document.getElementById("right-img").src = images[dialogue.speaker];
                document.getElementById("right-img").style.display = "block";
                document.getElementById("right-text").textContent = dialogue.text;
            }
        }

        document.getElementById("start-story").onclick = () => {
            index = 0;
            showDialogue(dialogues[index]);
            dialogueModal.show();
        };

        document.getElementById("dialogue-continue").onclick = () => {
            index++;
            if (index < dialogues.length) {
                showDialogue(dialogues[index]);
            } else {
                // ✅ redirect directly to the level page after last dialogue
                dialogueModal.hide();
                window.location.href = "/sql-game/{{ $levelId }}";
            }
        };
    </script>
@endsection
