{{-- resources/views/sections/section_2.blade.php --}}
@extends('layouts.app')

@section('title', 'Section 2 – Arrival in Kandy')

@section('content')
<div class="level-screen">
  <div class="city-banner text-center">
    <h2>Arrival in Kandy</h2>
  </div>

  {{-- Autoplay YouTube video (muted by default). User can tap to enable sound. --}}
  <div class="ratio ratio-16x9 mt-4" id="video-wrapper">
    <div id="yt-player"></div>
    <button id="unmute-btn" class="unmute-overlay">Tap to unmute</button>
  </div>
  <div class="text-center mt-2">
    <small>If the video does not start automatically, please click Play.</small>
  </div>
</div>

<!-- Dialogue Modal -->
<div class="modal fade" id="dialogueModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
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

{{-- Hidden form to mark intro complete in DB, then land on /sql-game/{level} --}}
<form id="intro-complete-form"
      action="{{ route('sql.intro.complete', ['level' => request()->route('level') ?? 2]) }}"
      method="POST" style="display:none;">
  @csrf
</form>
@endsection

@section('styles')
<style>
  .city-banner h2 { font-size: 2rem; margin-top: 30px; }
  #left-text, #right-text {
    background: #fff8e7;
    border: 2px solid #ff9800;
    border-radius: 12px;
    padding: 10px;
    display: inline-block;
    max-width: 80%;
    box-shadow: 0 3px 8px rgba(0,0,0,0.2);
  }
  #left-text  { text-align: left; }
  #right-text { text-align: right; }

  /* Unmute overlay for YouTube autoplay policy */
  #video-wrapper { position: relative; }
  .unmute-overlay{
    position: absolute;
    left: 50%;
    bottom: 10%;
    transform: translateX(-50%);
    background: #111;
    color: #fff;
    border: 0;
    padding: 10px 16px;
    border-radius: 999px;
    cursor: pointer;
    opacity: .9;
    font-weight: 600;
    letter-spacing: .3px;
  }
</style>
@endsection

@section('scripts')
<script src="https://www.youtube.com/iframe_api"></script>
<script>
  // Level to enter after dialogues
  const nextLevel = parseInt(@json(request()->route('level'))) || 2;

  // Character images
  const images = {
    "nila": "{{ asset('images/nila.png') }}",
    "ravi": "{{ asset('images/ravi.png') }}",
    "alex": "{{ asset('images/alex.png') }}"
  };

  // Dialogue sequence to show after the video
  const dialogues = [
    { speaker: "nila", side: "left",  text: "We have arrived in Kandy. The train ride through the hills was beautiful." },
    { speaker: "alex", side: "right", text: "I am ready to work on tasks related to tourists and hotels in Kandy." },
    { speaker: "ravi", side: "left",  text: "In this level you will practice WHERE, AND, OR, and LIKE filters." },
    { speaker: "nila", side: "right", text: "When you are ready, we will begin Level 2." }
  ];

  // Modal helpers
  const dialogueModalEl = document.getElementById('dialogueModal');
  const dialogueModal   = new bootstrap.Modal(dialogueModalEl, { backdrop: 'static', keyboard: false });

  function showDialogue(d){
    // reset panels
    document.getElementById("left-img").style.display  = "none";
    document.getElementById("right-img").style.display = "none";
    document.getElementById("left-text").textContent   = "";
    document.getElementById("right-text").textContent  = "";

    if (d.side === "left"){
      document.getElementById("left-img").src = images[d.speaker];
      document.getElementById("left-img").style.display = "block";
      document.getElementById("left-text").textContent  = d.text;
    } else {
      document.getElementById("right-img").src = images[d.speaker];
      document.getElementById("right-img").style.display = "block";
      document.getElementById("right-text").textContent  = d.text;
    }
  }

  function startDialogues(){
    // stop and hide video
    try { if (player && player.stopVideo) player.stopVideo(); } catch(e){}
    document.getElementById('video-wrapper').style.display = 'none';

    let i = 0;
    showDialogue(dialogues[i]);
    dialogueModal.show();

    document.getElementById('dialogue-continue').onclick = () => {
      i++;
      if (i < dialogues.length){
        showDialogue(dialogues[i]);
      } else {
        dialogueModal.hide();
        // Mark intro complete and move to /sql-game/{level}
        document.getElementById('intro-complete-form').submit();
      }
    };
  }

  // YouTube Iframe API
  let player;
  function onYouTubeIframeAPIReady(){
    player = new YT.Player('yt-player', {
      // The provided link is a YouTube Short; use the ID below
      videoId: 'iYNweZN2qPo',
      playerVars: {
        autoplay: 1,
        mute: 1,           // required for autoplay across browsers
        controls: 1,
        rel: 0,
        modestbranding: 1,
        playsinline: 1,
        enablejsapi: 1,
        origin: window.location.origin
      },
      events: {
        onReady: (e) => { try { e.target.playVideo(); } catch(_){} },
        onStateChange: onPlayerStateChange
      }
    });
  }
  window.onYouTubeIframeAPIReady = onYouTubeIframeAPIReady;

  // Unmute on user gesture
  const unmuteBtn = document.getElementById('unmute-btn');
  function enableSound(){
    try{
      player.unMute();
      player.setVolume(100);
      player.playVideo();
      unmuteBtn.style.display = 'none';
    }catch(_){}
  }
  unmuteBtn.addEventListener('click', enableSound);
  document.getElementById('video-wrapper').addEventListener('click', enableSound, { once: true });

  let transitioned = false;
  function onPlayerStateChange(e){
    if (e.data === YT.PlayerState.ENDED && !transitioned){
      transitioned = true;
      startDialogues();
    }
  }

  // Fallback timer (if autoplay or API is blocked). Adjust length to video duration if needed.
  setTimeout(() => {
    if (!transitioned){
      transitioned = true;
      startDialogues();
    }
  }, 35000);
</script>
@endsection
