<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
    @yield('style')
    <title>@yield('title', 'DLH Garut')</title>
    <link rel="icon" href="{{ asset('default_image/logo.jpg') }}">


</head>
<style>
    /* =========================
   Tier Besar (Profile Page)
   ========================= */

    .pointer {
        cursor: pointer;
    }

    /* Bronze */
    .tier-bronze {
        border: 4px solid #cd7f32;
    }

    /* Silver */
    .tier-silver {
        border: 4px solid #c0c0c0;
    }

    /* Gold Glow */
    .tier-gold {
        border: 4px solid #ffd700;
        animation: goldGlow 2s infinite alternate;
    }

    @keyframes goldGlow {
        from {
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }

        to {
            box-shadow: 0 0 25px rgba(255, 215, 0, 1);
        }
    }

    /* Diamond Glow + Shine */
    .tier-platinum {
        position: relative;
        border: 4px solid #0040ff;
        animation: platinumGlow 2s infinite alternate;
        overflow: hidden;
    }

    .tier-platinum::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(120deg, transparent 0%, rgba(255, 255, 255, 0.6) 50%, transparent 100%);
        transform: rotate(25deg);
        animation: platinumShine 3s linear infinite;
    }

    @keyframes platinumGlow {
        from {
            box-shadow: 0 0 20px rgba(0, 234, 255, 0.6);
        }

        to {
            box-shadow: 0 0 40px #0040ff;
        }
    }

    @keyframes platinumShine {
        0% {
            transform: rotate(25deg) translateX(-150%);
        }

        100% {
            transform: rotate(25deg) translateX(150%);
        }
    }

    /* Diamond Glow + Shine */
    .tier-diamond {
        position: relative;
        border: 4px solid skyblue;
        animation: diamondGlow 2s infinite alternate;
        overflow: hidden;
    }

    .tier-diamond::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(120deg, transparent 0%, rgba(255, 255, 255, 0.6) 50%, transparent 100%);
        transform: rotate(25deg);
        animation: diamondShine 3s linear infinite;
    }

    @keyframes diamondGlow {
        from {
            box-shadow: 0 0 20px rgba(0, 234, 255, 0.6);
        }

        to {
            box-shadow: 0 0 40px skyblue;
        }
    }

    @keyframes diamondShine {
        0% {
            transform: rotate(25deg) translateX(-150%);
        }

        100% {
            transform: rotate(25deg) translateX(150%);
        }
    }

    /* =========================
   Tier Kecil (Navbar)
   ========================= */

    /* Bronze */
    .avatar-sm.tier-bronze {
        border: 2px solid #cd7f32;
    }

    /* Silver */
    .avatar-sm.tier-silver {
        border: 2px solid #c0c0c0;
    }

    /* Gold Glow Small */
    .avatar-sm.tier-gold {
        border: 2px solid #ffd700;
        animation: goldGlowSmall 2s infinite alternate;
    }

    @keyframes goldGlowSmall {
        from {
            box-shadow: 0 0 5px rgba(255, 215, 0, 0.5);
        }

        to {
            box-shadow: 0 0 10px rgba(255, 215, 0, 1);
        }
    }

    /* Platinum Glow + Shine Small */
    .avatar-sm.tier-platinum {
        position: relative;
        border: 2px solid #0040ff;
        animation: platinumGlowSmall 2s infinite alternate;
        overflow: hidden;
    }

    .avatar-sm.tier-platinum::after {
        content: '';
        position: absolute;
        top: -100%;
        left: -100%;
        width: 300%;
        height: 300%;
        background: linear-gradient(120deg, transparent 0%, rgba(255, 255, 255, 0.4) 50%, transparent 100%);
        transform: rotate(25deg);
        animation: platinumShineSmall 3s linear infinite;
    }

    @keyframes platinumGlowSmall {
        from {
            box-shadow: 0 0 5px rgba(0, 234, 255, 0.6);
        }

        to {
            box-shadow: 0 0 10px #0040ff;
        }
    }

    @keyframes platinumShineSmall {
        0% {
            transform: rotate(25deg) translateX(-150%);
        }

        100% {
            transform: rotate(25deg) translateX(150%);
        }
    }

    /* Diamond Glow + Shine Small */
    .avatar-sm.tier-diamond {
        position: relative;
        border: 2px solid skyblue;
        animation: diamondGlowSmall 2s infinite alternate;
        overflow: hidden;
    }

    .avatar-sm.tier-diamond::after {
        content: '';
        position: absolute;
        top: -100%;
        left: -100%;
        width: 300%;
        height: 300%;
        background: linear-gradient(120deg, transparent 0%, rgba(255, 255, 255, 0.4) 50%, transparent 100%);
        transform: rotate(25deg);
        animation: diamondShineSmall 3s linear infinite;
    }

    @keyframes diamondGlowSmall {
        from {
            box-shadow: 0 0 5px rgba(0, 234, 255, 0.6);
        }

        to {
            box-shadow: 0 0 10px skyblue;
        }
    }

    @keyframes diamondShineSmall {
        0% {
            transform: rotate(25deg) translateX(-150%);
        }

        100% {
            transform: rotate(25deg) translateX(150%);
        }
    }
</style>

<body class="flex flex-col min-h-screen">
    {{-- navbar --}}
    @php
    $user = Auth::user();
    @endphp

    @if (Auth::check())
    @if ($user->role_id == 1)
    @include('layout.admin.navbar')
    @elseif ($user->role_id == 2)
    @include('layout.petugas.navbar')
    @else
    @include('layout.navbar')
    @endif
    @else
    {{-- User belum login --}}
    @include('layout.navbar')
    @endif
    {{-- content --}}
    <main class="flex-1 mt-16">
        @yield('content')
    </main>
    {{-- footer --}}
    @include('layout.footer')

    @yield('script')
    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Navbar transparent/solid on scroll
        const navbar = document.getElementById('navbar');

        function updateNavbar() {
            if (window.scrollY > 50) {
                navbar.classList.remove('backdrop-blur-md', 'bg-[#007546]/90');
                navbar.classList.add('bg-[#007546]');
            } else {
                navbar.classList.remove('bg-[#007546]');
                navbar.classList.add('backdrop-blur-md', 'bg-[#007546]/90');
            }
        }
        updateNavbar();
        window.addEventListener('scroll', updateNavbar);

        // Hamburger menu toggle
        const menuButton = document.getElementById("menu-button");
        const mobileMenu = document.getElementById("mobile-menu");
        const menuPath = document.getElementById("menu-path");

        menuButton.addEventListener("click", function(e) {
            e.stopPropagation();
            mobileMenu.classList.toggle("hidden");

            const isOpen = !mobileMenu.classList.contains("hidden");
            menuPath.setAttribute("d", isOpen ?
                "M6 18L18 6M6 6l12 12" :
                "M4 6h16M4 12h16M4 18h16");
        });

        window.addEventListener("click", function(e) {
            if (!mobileMenu.contains(e.target) && !menuButton.contains(e.target)) {
                if (!mobileMenu.classList.contains("hidden")) {
                    mobileMenu.classList.add("hidden");
                    menuPath.setAttribute("d", "M4 6h16M4 12h16M4 18h16");
                }
            }
        });

        // Dropdown profile toggle
        const profileDropdownButton = document.getElementById('profileDropdownButton');
        const profileDropdownMenu = document.getElementById('profileDropdownMenu');

        profileDropdownButton?.addEventListener('click', (e) => {
            e.stopPropagation();
            profileDropdownMenu.classList.toggle('hidden');
        });

        window.addEventListener('click', function(e) {
            if (!profileDropdownButton?.contains(e.target) && !profileDropdownMenu?.contains(e.target)) {
                profileDropdownMenu?.classList.add('hidden');
            }
        });
    </script>
</body>

</html>