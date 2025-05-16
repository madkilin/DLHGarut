<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
    @yield('style')
</head>

<body class="flex flex-col min-h-screen">
    {{-- navbar --}}
    @include('layout.admin.navbar')
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
