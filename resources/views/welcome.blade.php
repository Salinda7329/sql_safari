<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SQL Safari – Introduction</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <style>
    /* ✅ Keep your existing styles exactly (already perfect) */
    * {margin:0;padding:0;box-sizing:border-box;}
    body {font-family:'Poppins',sans-serif;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#333;line-height:1.6;overflow-x:hidden;}
    .bg-animation{position:fixed;top:0;left:0;width:100%;height:100%;z-index:-1;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);}
    .bg-animation::before{content:'';position:absolute;top:0;left:0;width:100%;height:100%;background:url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"><animate attributeName="cy" values="20;80;20" dur="3s" repeatCount="indefinite"/></circle><circle cx="50" cy="60" r="1.5" fill="rgba(255,255,255,0.1)"><animate attributeName="cy" values="60;10;60" dur="4s" repeatCount="indefinite"/></circle><circle cx="80" cy="40" r="1" fill="rgba(255,255,255,0.1)"><animate attributeName="cy" values="40;90;40" dur="5s" repeatCount="indefinite"/></circle></svg>') repeat;animation:float 20s infinite linear;}
    @keyframes float{0%{transform:translateY(0)}100%{transform:translateY(-100px)}}
    section{min-height:100vh;padding:80px 20px;display:flex;flex-direction:column;justify-content:center;align-items:center;text-align:center;position:relative;}
    .hero{background:linear-gradient(135deg,rgba(255,102,0,0.9),rgba(255,204,0,0.9));color:white;clip-path:polygon(0 0,100% 0,100% 85%,0 100%);}
    .hero h1{font-size:4rem;font-weight:700;margin-bottom:20px;text-shadow:2px 2px 4px rgba(0,0,0,0.3);animation:pulse 2s ease-in-out infinite alternate;}
    @keyframes pulse{0%{transform:scale(1)}100%{transform:scale(1.05)}}
    .hero p{font-size:1.4rem;font-weight:300;max-width:800px;text-shadow:1px 1px 2px rgba(0,0,0,0.3);}
    .story-section{background:linear-gradient(135deg,rgba(103,178,111,0.9),rgba(76,162,205,0.9));color:white;clip-path:polygon(0 15%,100% 0,100% 85%,0 100%);}
    .how-to-section{background:linear-gradient(135deg,rgba(255,159,67,0.9),rgba(255,107,107,0.9));color:white;clip-path:polygon(0 15%,100% 0,100% 85%,0 100%);}
    .flow-section{background:linear-gradient(135deg,rgba(116,75,162,0.9),rgba(102,126,234,0.9));color:white;clip-path:polygon(0 15%,100% 0,100% 85%,0 100%);}
    .final-section{background:linear-gradient(135deg,rgba(255,102,0,0.9),rgba(255,204,0,0.9));color:white;clip-path:polygon(0 15%,100% 0,100% 100%,0 100%);}
    h1{font-size:3.5rem;margin-bottom:25px;font-weight:700;}
    h2{font-size:2.5rem;margin:25px 0;font-weight:600;text-shadow:1px 1px 2px rgba(0,0,0,0.2);}
    p{font-size:1.2rem;max-width:800px;margin:15px auto;font-weight:300;}
    .cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:25px;margin-top:40px;width:100%;}
    .card{background:rgba(255,255,255,0.95);backdrop-filter:blur(10px);border-radius:20px;padding:30px 20px;box-shadow:0 15px 35px rgba(0,0,0,0.1);transition:all .4s cubic-bezier(.175,.885,.32,1.275);font-size:1rem;border:1px solid rgba(255,255,255,0.2);color:#333;}
    .card:hover{transform:translateY(-15px) rotateY(5deg);box-shadow:0 25px 50px rgba(0,0,0,0.2);background:#fff;}
    .timeline{display:flex;justify-content:center;gap:15px;margin-top:40px;flex-wrap:wrap;max-width:1200px;}
    .timeline div{text-align:center;font-size:1rem;padding:15px 20px;background:rgba(255,255,255,0.95);backdrop-filter:blur(10px);border-radius:15px;box-shadow:0 8px 25px rgba(0,0,0,0.1);transition:.3s;color:#333;font-weight:500;position:relative;overflow:hidden;}
    .btn-start{margin-top:40px;padding:18px 45px;font-size:1.4rem;font-weight:600;background:linear-gradient(45deg,#ff6600,#ffcc00,#ff6600);background-size:200% 200%;border:none;border-radius:50px;cursor:pointer;color:white;transition:all .4s cubic-bezier(.175,.885,.32,1.275);box-shadow:0 10px 30px rgba(255,102,0,0.4);text-transform:uppercase;letter-spacing:1px;position:relative;overflow:hidden;animation:gradient-shift 3s ease infinite;}
    @keyframes gradient-shift{0%,100%{background-position:0% 50%}50%{background-position:100% 50%}}
    .floating-emoji{position:absolute;font-size:2rem;animation:float-around 8s ease-in-out infinite;}
    @keyframes float-around{0%,100%{transform:translateY(0) rotate(0)}25%{transform:translateY(-20px) rotate(5deg)}50%{transform:translateY(-10px) rotate(-5deg)}75%{transform:translateY(-15px) rotate(3deg)}}
    .scroll-indicator{position:fixed;bottom:30px;left:50%;transform:translateX(-50%);z-index:1000;animation:bounce 2s infinite;color:white;font-size:2rem;}
    @keyframes bounce{0%,20%,50%,80%,100%{transform:translateX(-50%) translateY(0)}40%{transform:translateX(-50%) translateY(-10px)}60%{transform:translateX(-50%) translateY(-5px)}}
    .progress-bar{position:fixed;top:0;left:0;height:4px;background:linear-gradient(90deg,#ff6600,#ffcc00);z-index:1000;transition:width .3s;}
  </style>
</head>

<body>
  <div class="bg-animation"></div>
  <div class="progress-bar" id="progressBar"></div>

  <!-- Floating Emojis -->
  <div class="floating-emoji">🌴</div>
  <div class="floating-emoji">🐘</div>
  <div class="floating-emoji">🏛️</div>
  <div class="floating-emoji">💎</div>

  <!-- Hero -->
  <section class="hero" data-aos="zoom-in">
    <h1 class="glow">🌴 Welcome to SQL Safari: Sri Lanka! 🌴</h1>
    <p data-aos="fade-up">A gamified adventure where you travel across Sri Lanka with Alex, Ravi, and Nila while mastering SQL step by step.</p>
  </section>

  <!-- Story -->
  <section class="story-section" data-aos="fade-right">
    <h2>🌍 Meet Your Companions</h2>
    <p>You are <strong>Alex</strong>, a curious traveler from Europe. At the airport you meet <strong>Ravi</strong>, a witty cab driver who becomes your guide. Soon after, <strong>Nila</strong>, Ravi’s tech-savvy cousin, introduces you to the SQL Terminal.</p>
    <p>Together you’ll unlock provinces, solve SQL challenges, and record progress in the <em>Travel Log</em>. In the final province, you will face <strong>Professor Senanayake</strong>, a legendary data scientist, for the ultimate SQL challenge!</p>
    <div style="margin-top:30px;font-style:italic;">"Every query you write brings you closer to both SQL mastery and Sri Lankan cultural treasures!"</div>
  </section>

  <!-- How-to -->
  <section class="how-to-section" data-aos="fade-left">
    <h2>🎮 How to Play</h2>
    <div class="cards">
      <div class="card">📝 <br><strong>Write SQL Queries</strong><br>Type commands like <code>SELECT * FROM Hotels;</code> to explore data.</div>
      <div class="card">✅ <br><strong>Instant Feedback</strong><br>Correct queries unlock new locations and achievements.</div>
      <div class="card">❤️ <br><strong>Three Lives</strong><br>You get 3 attempts per task — Ravi and Nila will drop hints if needed.</div>
      <div class="card">🎉 <br><strong>Achievements</strong><br>Earn badges, collect hidden Easter Eggs, and fill your Travel Log.</div>
    </div>
  </section>

  <!-- Flow -->
  <section class="flow-section" data-aos="fade-right">
    <h2>🗺️ Provinces & SQL Skills</h2>
    <p>Each province teaches a new SQL skill — from basics in Colombo to advanced joins, subqueries, and updates in Ratnapura and Kurunegala.</p>
    <div class="timeline">
      <div>📍 Colombo<br><small>SELECT *</small></div>
      <div>🚂 Kandy<br><small>WHERE & ORDER BY</small></div>
      <div>🏖️ Galle<br><small>Sorting</small></div>
      <div>🏯 Jaffna<br><small>JOINS</small></div>
      <div>🏖️ Pasikuda<br><small>GROUP BY</small></div>
      <div>🏛️ Anuradhapura<br><small>HAVING</small></div>
      <div>🌉 Badulla<br><small>Subqueries</small></div>
      <div>💎 Ratnapura<br><small>INSERT/UPDATE</small></div>
      <div>⛰️ Kurunegala<br><small>Final Boss</small></div>
    </div>
  </section>

  <!-- Final -->
  <section class="final-section" data-aos="zoom-in">
    <h2>🚀 Ready to Begin?</h2>
    <p>Join Alex, Ravi, and Nila, travel through Sri Lanka, and become a <strong>SQL Master Explorer</strong>!</p>
    <button class="btn-start" onclick="startAdventure()">🌟 Start Your Journey 🌟</button>
  </section>

  <div class="scroll-indicator" id="scrollIndicator">⬇️</div>

  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({duration:800,easing:'ease-out-cubic',once:false,mirror:true,offset:100});
    window.addEventListener('scroll',()=>{const t=window.pageYOffset,d=document.body.offsetHeight-window.innerHeight,s=(t/d)*100;document.getElementById('progressBar').style.width=s+'%';document.getElementById('scrollIndicator').style.opacity=t>100?'0':'1';});
    function startAdventure(){window.location.href='/introduction/section/1';}
  </script>
</body>
</html>
