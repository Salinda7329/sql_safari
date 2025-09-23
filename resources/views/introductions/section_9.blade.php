{{-- resources/views/sections/section_8.blade.php --}}
@extends('layouts.app')

@section('title', 'Section 9 – Arrival in Kurunegala')

@section('content')
    <div class="level-screen"
        style="margin:0; padding:0; display:flex; flex-direction:column; justify-content:center; align-items:center; background:#000; overflow:hidden;">
        <div class="city-banner text-center" style="position:absolute; top:20px; left:50%; transform:translateX(-50%);">
            <h2 style="color:#ff6600;">Arrival in Kurunegala</h2>
        </div>

        {{-- Flexbox centered YouTube video --}}
        <div id="video-wrapper" style="display:flex; justify-content:center; align-items:center; width:100%; height:100%;">
            <div id="yt-player" style="max-width:100%; max-height:100%;"></div>
        </div>

        <div class="text-center mt-2" style="position:absolute; bottom:20px; color:white;">
            <small>Wait until the video finishes to continue.</small>
        </div>
    </div>

    <!-- Dialogue Modal -->
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
                    <button type="button" id="dialogue-continue" class="btn btn-warning">Continue</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden form --}}
    <form id="intro-complete-form" action="{{ route('sql.intro.complete', ['level' => request()->route('level') ?? 9]) }}"
        method="POST" style="display:none;">
        @csrf
    </form>
@endsection

@section('scripts')
    <!-- Load YouTube IFrame API -->
    <script src="https://www.youtube.com/iframe_api"></script>
    <script>
        const images = {
            "nila": "{{ asset('images/nila.png') }}",
            "ravi": "{{ asset('images/ravi.png') }}",
            "alex": "{{ asset('images/alex.png') }}",
            "professor": "{{ asset('images/professor.png') }}"
        };

        // Kurunegala introduction dialogues
        const dialogues = [
            {
                speaker: "nila",
                side: "left",
                text: "Welcome to Kurunegala! 🐘 Famous for its Elephant Rock and a city surrounded by legends."
            },
            {
                speaker: "alex",
                side: "right",
                text: "This city is full of stories and trade routes. Let’s see how SQL can reveal insights into transport, markets, and history here."
            },
            {
                speaker: "ravi",
                side: "left",
                text: "In this level, you’ll practice working with complex queries — multiple JOINs, grouping, and conditions to explore linked data."
            },
            {
                speaker: "nila",
                side: "right",
                text: "Be ready — Kurunegala’s challenges will put your SQL mastery to the test!"
            }
        ];

        const dialogueModalEl = document.getElementById('dialogueModal');
        const dialogueModal = new bootstrap.Modal(dialogueModalEl, {
            backdrop: 'static',
            keyboard: false
        });

        function showDialogue(d) {
            document.getElementById("left-img").style.display = "none";
            document.getElementById("right-img").style.display = "none";
            document.getElementById("left-text").textContent = "";
            document.getElementById("right-text").textContent = "";

            if (d.side === "left") {
                document.getElementById("left-img").src = images[d.speaker];
                document.getElementById("left-img").style.display = "block";
                document.getElementById("left-text").textContent = d.text;
            } else {
                document.getElementById("right-img").src = images[d.speaker];
                document.getElementById("right-img").style.display = "block";
                document.getElementById("right-text").textContent = d.text;
            }
        }

        function startDialogues() {
            try {
                if (player && player.stopVideo) player.stopVideo();
            } catch (e) {}
            let i = 0;
            showDialogue(dialogues[i]);
            dialogueModal.show();

            document.getElementById('dialogue-continue').onclick = () => {
                i++;
                if (i < dialogues.length) {
                    showDialogue(dialogues[i]);
                } else {
                    dialogueModal.hide();
                    document.getElementById('intro-complete-form').submit();
                }
            };
        }

        let player;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('yt-player', {
                videoId: '-cdnMXuUI-U', // ✅ Kurunegala Shorts video ID
                playerVars: {
                    autoplay: 1,
                    mute: 1,
                    controls: 1,
                    rel: 0,
                    modestbranding: 1,
                    playsinline: 1,
                    enablejsapi: 1,
                    origin: window.location.origin
                },
                events: {
                    onReady: (e) => {
                        try { e.target.playVideo(); } catch (_) {}
                    },
                    onStateChange: onPlayerStateChange
                }
            });
        }
        window.onYouTubeIframeAPIReady = onYouTubeIframeAPIReady;

        let transitioned = false;

        function onPlayerStateChange(e) {
            if (e.data === YT.PlayerState.ENDED && !transitioned) {
                transitioned = true;
                startDialogues();
            }
        }

        // Fallback if the video doesn’t end (timeout)
        setTimeout(() => {
            if (!transitioned) {
                transitioned = true;
                startDialogues();
            }
        }, 35000);
    </script>
@endsection
