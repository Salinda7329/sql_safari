@extends('layouts.app')

{{-- Resolve level id even if $level is not set --}}
@php
    $levelId = isset($level->id) ? (int) $level->id : (int) request()->route('level');
@endphp

@section('title', 'Section 1 – Arrival in Colombo')

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

        /* Simple journey banner inside the journey modal */
        .journey-banner {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .plane-path {
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: center;
            font-size: 1.25rem;
            margin: 12px 0 4px;
        }

        .plane {
            display: inline-block;
            animation: fly 2.2s ease-in-out infinite;
        }

        @keyframes fly {
            0% {
                transform: translateX(0) translateY(0) rotate(0);
            }

            50% {
                transform: translateX(8px) translateY(-3px) rotate(3deg);
            }

            100% {
                transform: translateX(0) translateY(0) rotate(0);
            }
        }

        /* Optional helper in case Bootstrap isn't loaded with .d-none in your global CSS */
        .d-none {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    <div class="level-screen">
        <div class="city-banner text-center">
            <h2>✈️ Arrival in Colombo</h2>
        </div>
    </div>

    <!-- Journey Modal (shown on page load) -->
    <div class="modal fade" id="journeyModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-3">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Alex’s Journey: Europe ➜ Colombo</h5>
                </div>
                <div class="modal-body">
                    <div class="journey-banner">From Europe to the heart of Sri Lanka 🇱🇰</div>
                    <div class="plane-path">
                        🌍 Europe <span class="plane">✈️</span> 🇱🇰 Colombo
                    </div>
                    <p class="mt-2 mb-0 text-muted">
                        Alex travels across continents—soaring over seas and cities—arriving in vibrant Colombo, ready to
                        begin the SQL Safari adventure.
                    </p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="journey-play" class="btn btn-outline-secondary d-none">▶️ Tap to Play Audio</button>
                    <button id="journey-continue" class="btn btn-primary" disabled>Continue ➡️</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Dialogue Modal (reused for each step) -->
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
                    <button id="dialogue-play" class="btn btn-outline-secondary d-none">▶️ Tap to Play Audio</button>
                    <button type="button" id="dialogue-continue" class="btn btn-primary" disabled>Continue ➡️</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Bootstrap modals
            const journeyModalEl = document.getElementById('journeyModal');
            const journeyModal = new bootstrap.Modal(journeyModalEl, {
                backdrop: 'static',
                keyboard: false
            });

            const dialogueModalEl = document.getElementById('dialogueModal');
            const dialogueModal = new bootstrap.Modal(dialogueModalEl, {
                backdrop: 'static',
                keyboard: false
            });

            // Shared audio element (reused)
            const voice = new Audio();
            voice.preload = 'auto';

            // Buttons
            const journeyPlayBtn = document.getElementById('journey-play');
            const journeyContinueBtn = document.getElementById('journey-continue');

            const dialoguePlayBtn = document.getElementById('dialogue-play');
            const dialogueContinueBtn = document.getElementById('dialogue-continue');

            // Speaker images
            const images = {
                nila: "{{ asset('images/nila.png') }}",
                ravi: "{{ asset('images/ravi.png') }}",
                alex: "{{ asset('images/alex.png') }}"
            };

            // Dialogue sequence (update texts as needed). Audio names follow nila1, ravi1, alex1, etc.
            const dialogues = [{
                    speaker: "nila",
                    side: "left",
                    text: "🌴 Welcome, Alex! This is Sri Lanka — full of adventures and hidden treasures.",
                    audio: "{{ asset('audio/nila1.mp3') }}"
                },
                {
                    speaker: "ravi",
                    side: "right",
                    text: "But first things first… after a long flight, you need a good hotel to rest.",
                    audio: "{{ asset('audio/ravi1.mp3') }}"
                },
                {
                    speaker: "alex",
                    side: "left",
                    text: "Hmm… but how do we choose the right one quickly?",
                    audio: "{{ asset('audio/alex1.mp3') }}"
                },
                {
                    speaker: "nila",
                    side: "right",
                    text: "There are hundreds of hotels in Colombo. Some are expensive, some affordable.",
                    audio: "{{ asset('audio/nila2.mp3') }}"
                },
                {
                    speaker: "ravi",
                    side: "left",
                    text: "Don’t worry! We’ll guide you and meet new friends from around the world.",
                    audio: "{{ asset('audio/ravi2.mp3') }}"
                },
                {
                    speaker: "nila",
                    side: "right",
                    text: "Let’s start by exploring the hotels in Colombo. Ready to begin?",
                    audio: "{{ asset('audio/nila3.mp3') }}"
                },
            ];

            // Journey audio (rename if needed)
            const journeyAudioUrl = "{{ asset('audio/journey1.mp3') }}";

            // Helpers
            function resetDialogueBubbles() {
                // Hide images & clear texts
                document.getElementById("left-img").style.display = "none";
                document.getElementById("right-img").style.display = "none";
                document.getElementById("left-text").textContent = "";
                document.getElementById("right-text").textContent = "";
            }

            function renderDialogueStep(step) {
                resetDialogueBubbles();
                if (step.side === "left") {
                    const li = document.getElementById("left-img");
                    li.src = images[step.speaker];
                    li.style.display = "block";
                    document.getElementById("left-text").textContent = step.text;
                } else {
                    const ri = document.getElementById("right-img");
                    ri.src = images[step.speaker];
                    ri.style.display = "block";
                    document.getElementById("right-text").textContent = step.text;
                }
            }

            /**
             * Plays an audio and enables a continue button only when audio ends.
             * Shows a "Tap to Play" button if autoplay is blocked.
             */
            function playBlockingAudio(src, continueBtn, playBtn) {
                return new Promise((resolve) => {
                    continueBtn.disabled = true;
                    playBtn?.classList.add('d-none');

                    voice.src = src;
                    voice.currentTime = 0;

                    const onEnded = () => {
                        continueBtn.disabled = false;
                        voice.removeEventListener('ended', onEnded);
                        resolve();
                    };
                    voice.addEventListener('ended', onEnded, {
                        once: true
                    });

                    voice.play().catch(() => {
                        // Autoplay blocked -> require user gesture
                        if (playBtn) {
                            playBtn.classList.remove('d-none');
                            playBtn.onclick = () => {
                                playBtn.classList.add('d-none');
                                voice.play().catch(() => {
                                    // If still fails, enable continue so they are not stuck
                                    continueBtn.disabled = false;
                                });
                            };
                        } else {
                            // No play button provided -> allow continue
                            continueBtn.disabled = false;
                        }
                    });
                });
            }

            // Flow control
            let idx = 0;

            // Step 1: Show Journey on Page Load
            journeyModal.show();
            playBlockingAudio(journeyAudioUrl, journeyContinueBtn, journeyPlayBtn);

            journeyContinueBtn.addEventListener('click', () => {
                journeyModal.hide();
                // Step 2: Start dialogue sequence
                idx = 0;
                renderDialogueStep(dialogues[idx]);
                dialogueModal.show();
                // Play first dialogue audio
                playBlockingAudio(dialogues[idx].audio, dialogueContinueBtn, dialoguePlayBtn);
            });

            // Dialogue "Continue"
            dialogueContinueBtn.addEventListener('click', () => {
                idx++;
                if (idx < dialogues.length) {
                    renderDialogueStep(dialogues[idx]);
                    playBlockingAudio(dialogues[idx].audio, dialogueContinueBtn, dialoguePlayBtn);
                } else {
                    // End of sequence -> redirect to level page
                    dialogueModal.hide();
                    window.location.href = "/sql-game/{{ $levelId }}";
                }
            });
        });
    </script>
@endsection
