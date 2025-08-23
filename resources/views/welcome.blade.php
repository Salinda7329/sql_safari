<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Safari – Introduction</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Animated background particles */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-animation::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"><animate attributeName="cy" values="20;80;20" dur="3s" repeatCount="indefinite"/></circle><circle cx="50" cy="60" r="1.5" fill="rgba(255,255,255,0.1)"><animate attributeName="cy" values="60;10;60" dur="4s" repeatCount="indefinite"/></circle><circle cx="80" cy="40" r="1" fill="rgba(255,255,255,0.1)"><animate attributeName="cy" values="40;90;40" dur="5s" repeatCount="indefinite"/></circle></svg>') repeat;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            100% { transform: translateY(-100px); }
        }

        section {
            min-height: 100vh;
            padding: 80px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }

        /* Hero section with special styling */
        .hero {
            background: linear-gradient(135deg, rgba(255, 102, 0, 0.9), rgba(255, 204, 0, 0.9));
            color: white;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: pulse 2s ease-in-out infinite alternate;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.05); }
        }

        .hero p {
            font-size: 1.4rem;
            font-weight: 300;
            max-width: 800px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        /* Section backgrounds with gradients */
        .story-section {
            background: linear-gradient(135deg, rgba(103, 178, 111, 0.9), rgba(76, 162, 205, 0.9));
            color: white;
            clip-path: polygon(0 15%, 100% 0, 100% 85%, 0 100%);
        }

        .how-to-section {
            background: linear-gradient(135deg, rgba(255, 159, 67, 0.9), rgba(255, 107, 107, 0.9));
            color: white;
            clip-path: polygon(0 15%, 100% 0, 100% 85%, 0 100%);
        }

        .flow-section {
            background: linear-gradient(135deg, rgba(116, 75, 162, 0.9), rgba(102, 126, 234, 0.9));
            color: white;
            clip-path: polygon(0 15%, 100% 0, 100% 85%, 0 100%);
        }

        .final-section {
            background: linear-gradient(135deg, rgba(255, 102, 0, 0.9), rgba(255, 204, 0, 0.9));
            color: white;
            clip-path: polygon(0 15%, 100% 0, 100% 100%, 0 100%);
        }

        h1 {
            font-size: 3.5rem;
            margin-bottom: 25px;
            font-weight: 700;
        }

        h2 {
            font-size: 2.5rem;
            margin: 25px 0;
            font-weight: 600;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 15px auto;
            font-weight: 300;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            max-width: 100%;
            margin-top: 40px;
            width: 100%;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-size: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #333;
        }

        .card:hover {
            transform: translateY(-15px) rotateY(5deg);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 1);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            border-radius: 20px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .card:hover::before {
            opacity: 1;
        }

        .timeline {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 40px;
            flex-wrap: wrap;
            max-width: 1200px;
        }

        .timeline div {
            text-align: center;
            font-size: 1rem;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            color: #333;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .timeline div::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }

        .timeline div:hover::before {
            left: 100%;
        }

        .timeline div:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-start {
            margin-top: 40px;
            padding: 18px 45px;
            font-size: 1.4rem;
            font-weight: 600;
            background: linear-gradient(45deg, #ff6600, #ffcc00, #ff6600);
            background-size: 200% 200%;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            color: white;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(255, 102, 0, 0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            animation: gradient-shift 3s ease infinite;
        }

        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .btn-start::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-start:hover::before {
            left: 100%;
        }

        .btn-start:hover {
            transform: translateY(-5px) scale(1.08);
            box-shadow: 0 20px 40px rgba(255, 102, 0, 0.6);
        }

        .btn-start:active {
            transform: translateY(-2px) scale(1.05);
        }

        /* Floating elements */
        .floating-emoji {
            position: absolute;
            font-size: 2rem;
            animation: float-around 8s ease-in-out infinite;
            /* opacity: 0.7; */
        }

        @keyframes float-around {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(5deg); }
            50% { transform: translateY(-10px) rotate(-5deg); }
            75% { transform: translateY(-15px) rotate(3deg); }
        }

        .floating-emoji:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
        .floating-emoji:nth-child(2) { top: 20%; right: 15%; animation-delay: 1s; }
        .floating-emoji:nth-child(3) { bottom: 30%; left: 20%; animation-delay: 2s; }
        .floating-emoji:nth-child(4) { bottom: 20%; right: 20%; animation-delay: 3s; }

        /* Scroll indicator */
        .scroll-indicator {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            animation: bounce 2s infinite;
            color: white;
            font-size: 2rem;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
            40% { transform: translateX(-50%) translateY(-10px); }
            60% { transform: translateX(-50%) translateY(-5px); }
        }

        /* Progress bar */
        .progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 4px;
            background: linear-gradient(90deg, #ff6600, #ffcc00);
            z-index: 1000;
            transition: width 0.3s ease;
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #ff6600, #ffcc00);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #e55a00, #e6b800);
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            h2 {
                font-size: 2rem;
            }

            .cards {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .timeline {
                flex-direction: column;
                align-items: center;
            }

            .timeline div {
                width: 200px;
            }
        }

        /* Enhanced hover effects for interactive elements */
        .interactive {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .interactive:hover {
            filter: brightness(1.1);
        }

        /* Glowing text effect */
        .glow {
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }

        /* Particle effect on scroll */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            pointer-events: none;
            animation: particle-float 3s ease-out forwards;
        }

        @keyframes particle-float {
            0% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            100% {
                opacity: 0;
                transform: translateY(-100px) scale(0);
            }
        }
    </style>
</head>

<body>
    <div class="bg-animation"></div>
    <div class="progress-bar" id="progressBar"></div>

    <!-- Floating decorative elements -->
    <div class="floating-emoji">🌴</div>
    <div class="floating-emoji">🐘</div>
    <div class="floating-emoji">🏛️</div>
    <div class="floating-emoji">💎</div>

    <section class="hero" data-aos="zoom-in" data-aos-duration="1000">
        <h1 class="glow">🌴 Welcome to SQL Safari: Sri Lanka! 🌴</h1>
        <p data-aos="fade-up" data-aos-delay="300">Embark on an epic journey across the beautiful island of Sri Lanka while mastering SQL step by step!</p>
    </section>

    <section class="story-section" data-aos="fade-right" data-aos-duration="1200">
        <h2>🌍 Your Epic Adventure Awaits</h2>
        <p data-aos="fade-left" data-aos-delay="200">You are Alex, an intrepid traveler exploring the wonders of Sri Lanka. Alongside Nila, your knowledgeable tour guide, and Ravi, your experienced driver, you'll discover ancient temples, pristine beaches, and bustling cities while unlocking the powerful secrets of SQL!</p>
        <div data-aos="zoom-in" data-aos-delay="400" style="margin-top: 30px; font-size: 1.1rem; font-style: italic;">
            "Every query you write brings you closer to both SQL mastery and Sri Lankan cultural treasures!"
        </div>
    </section>

    <section class="how-to-section" data-aos="fade-left" data-aos-duration="1200">
        <h2>🎮 Master the Game</h2>
        <div class="cards">
            <div class="card interactive" data-aos="flip-left" data-aos-delay="100">
                <div style="font-size: 2rem; margin-bottom: 10px;">📝</div>
                <strong>Write SQL Queries</strong><br>
                Type powerful SQL commands into the interactive query box and watch the magic happen.
            </div>
            <div class="card interactive" data-aos="flip-left" data-aos-delay="200">
                <div style="font-size: 2rem; margin-bottom: 10px;">✅</div>
                <strong>Instant Feedback</strong><br>
                Get immediate validation! Correct queries unlock stunning new locations across Sri Lanka.
            </div>
            <div class="card interactive" data-aos="flip-left" data-aos-delay="300">
                <div style="font-size: 2rem; margin-bottom: 10px;">❤️</div>
                <strong>Three Lives System</strong><br>
                You have 3 precious attempts per challenge. Use them wisely on your SQL quest!
            </div>
            <div class="card interactive" data-aos="flip-left" data-aos-delay="400">
                <div style="font-size: 2rem; margin-bottom: 10px;">🎉</div>
                <strong>Progressive Unlocking</strong><br>
                Conquer each province to reveal the next breathtaking destination on your journey.
            </div>
        </div>
    </section>

    <section class="flow-section" data-aos="fade-right" data-aos-duration="1200">
        <h2>🗺️ Your Journey Through Sri Lanka</h2>
        <p data-aos="fade-up" data-aos-delay="200">Follow the path from the bustling capital to ancient kingdoms, pristine beaches to sacred temples!</p>
        <div class="timeline">
            <div class="interactive" data-aos="fade-up" data-aos-delay="100">
                <div style="font-size: 1.5rem;">📍</div>
                <strong>Colombo</strong><br>
                <small>Commercial Capital</small>
            </div>
            <div class="interactive" data-aos="fade-down" data-aos-delay="200">
                <div style="font-size: 1.5rem;">🚂</div>
                <strong>Kandy</strong><br>
                <small>Cultural Heart</small>
            </div>
            <div class="interactive" data-aos="fade-up" data-aos-delay="300">
                <div style="font-size: 1.5rem;">🏖️</div>
                <strong>Galle</strong><br>
                <small>Dutch Fort City</small>
            </div>
            <div class="interactive" data-aos="fade-down" data-aos-delay="400">
                <div style="font-size: 1.5rem;">🏯</div>
                <strong>Jaffna</strong><br>
                <small>Northern Peninsula</small>
            </div>
            <div class="interactive" data-aos="fade-up" data-aos-delay="500">
                <div style="font-size: 1.5rem;">🏖️</div>
                <strong>Pasikuda</strong><br>
                <small>Golden Beaches</small>
            </div>
            <div class="interactive" data-aos="fade-down" data-aos-delay="600">
                <div style="font-size: 1.5rem;">🏛️</div>
                <strong>Anuradhapura</strong><br>
                <small>Ancient Capital</small>
            </div>
            <div class="interactive" data-aos="fade-up" data-aos-delay="700">
                <div style="font-size: 1.5rem;">🌉</div>
                <strong>Badulla</strong><br>
                <small>Hill Country</small>
            </div>
            <div class="interactive" data-aos="fade-down" data-aos-delay="800">
                <div style="font-size: 1.5rem;">💎</div>
                <strong>Ratnapura</strong><br>
                <small>Gem City</small>
            </div>
            <div class="interactive" data-aos="fade-up" data-aos-delay="900">
                <div style="font-size: 1.5rem;">⛰️</div>
                <strong>Kurunegala</strong><br>
                <small>Coconut Triangle</small>
            </div>
        </div>
    </section>

    <section class="final-section" data-aos="zoom-in" data-aos-duration="1000">
        <h2 data-aos="fade-down">🚀 Ready for the Ultimate SQL Adventure?</h2>
        <p data-aos="fade-up" data-aos-delay="200">Join thousands of learners who have transformed their SQL skills while exploring one of the world's most beautiful destinations!</p>
        <button class="btn-start interactive" data-aos="bounce-in" data-aos-delay="400" onclick="startAdventure()">
            🌟 Begin Your SQL Safari 🌟
        </button>
        <div data-aos="fade-up" data-aos-delay="600" style="margin-top: 20px; font-size: 0.9rem; opacity: 0.9;">
            Adventure awaits • Skills guaranteed • Memories included
        </div>
    </section>

    <div class="scroll-indicator" id="scrollIndicator">
        ⬇️
    </div>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Initialize AOS with enhanced settings
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: false,
            mirror: true,
            offset: 100
        });

        // Progress bar functionality
        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset;
            const docHeight = document.body.offsetHeight - window.innerHeight;
            const scrollPercent = (scrollTop / docHeight) * 100;
            document.getElementById('progressBar').style.width = scrollPercent + '%';

            // Hide scroll indicator when user starts scrolling
            const scrollIndicator = document.getElementById('scrollIndicator');
            if (scrollTop > 100) {
                scrollIndicator.style.opacity = '0';
            } else {
                scrollIndicator.style.opacity = '1';
            }
        });

        // Particle effect on click
        document.addEventListener('click', (e) => {
            for (let i = 0; i < 6; i++) {
                createParticle(e.clientX, e.clientY);
            }
        });

        function createParticle(x, y) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = x + 'px';
            particle.style.top = y + 'px';
            particle.style.left = (x + (Math.random() - 0.5) * 50) + 'px';
            particle.style.top = (y + (Math.random() - 0.5) * 50) + 'px';
            document.body.appendChild(particle);

            setTimeout(() => {
                particle.remove();
            }, 3000);
        }

        // Enhanced start button functionality
        function startAdventure() {
            // Create burst effect
            for (let i = 0; i < 20; i++) {
                createParticle(
                    window.innerWidth / 2 + (Math.random() - 0.5) * 100,
                    window.innerHeight * 0.8 + (Math.random() - 0.5) * 100
                );
            }

            // Add some delay for effect, then redirect
            setTimeout(() => {
                window.location.href = '/introduction/section_1';
            }, 500);
        }

        // Add subtle parallax effect
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelectorAll('.floating-emoji');
            const speed = 0.5;

            parallax.forEach((element, index) => {
                const yPos = -(scrolled * speed * (index + 1) * 0.1);
                element.style.transform = `translateY(${yPos}px) rotate(${scrolled * 0.1}deg)`;
            });
        });

        // Enhanced card interactions
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', (e) => {
                const rect = e.target.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                e.target.style.setProperty('--mouse-x', x + 'px');
                e.target.style.setProperty('--mouse-y', y + 'px');
            });
        });

        // Timeline province info on hover
        document.querySelectorAll('.timeline div').forEach((province, index) => {
            province.addEventListener('mouseenter', () => {
                province.style.transform = 'translateY(-5px) scale(1.05)';
                // Add a subtle rotation based on position
                const rotation = (index % 2 === 0) ? '2deg' : '-2deg';
                province.style.transform += ` rotate(${rotation})`;
            });

            province.addEventListener('mouseleave', () => {
                province.style.transform = 'translateY(0) scale(1) rotate(0deg)';
            });
        });

        // Typewriter effect for hero subtitle (optional enhancement)
        function typeWriter(element, text, speed = 50) {
            let i = 0;
            element.innerHTML = '';

            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            }
            type();
        }

        // Add some sparkle effects on button hover
        document.querySelector('.btn-start').addEventListener('mouseenter', function(e) {
            for (let i = 0; i < 5; i++) {
                setTimeout(() => {
                    createParticle(
                        e.target.getBoundingClientRect().left + Math.random() * e.target.offsetWidth,
                        e.target.getBoundingClientRect().top + Math.random() * e.target.offsetHeight
                    );
                }, i * 100);
            }
        });
    </script>
</body>

</html>
