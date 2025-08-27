<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ProPangkat') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Scripts and Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>
        
        <style>
            /* Dark mode styles */
            :root {
                --gradient-from: rgb(125, 211, 252);
                --gradient-via: rgb(56, 189, 248);
                --gradient-to: rgb(45, 212, 191);
                --bg-blur-1: rgba(255, 255, 255, 0.1);
                --bg-blur-2: rgba(94, 234, 212, 0.1);
                --text-footer: rgb(224, 242, 254);
            }
    
            [data-theme="dark"] {
                --gradient-from: rgb(17, 24, 39);
                --gradient-via: rgb(31, 41, 55);
                --gradient-to: rgb(55, 65, 81);
                --bg-blur-1: rgba(229, 231, 235, 0.1);
                --bg-blur-2: rgba(19, 78, 74, 0.1);
                --text-footer: rgb(209, 213, 219);
            }
    
            body {
                background: linear-gradient(to bottom right, var(--gradient-from), var(--gradient-via), var(--gradient-to));
                transition: background 0.5s ease;
                min-height: 100vh;
            }
    
            /* Animations */
            @keyframes fadeInScale {
                from { opacity: 0; transform: scale(0.8); }
                to { opacity: 1; transform: scale(1); }
            }
    
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            @keyframes bgBlur {
                from { opacity: 0; transform: scale(0); }
                to { opacity: 0.1; transform: scale(1); }
            }
    
            .theme-toggle {
                animation: fadeInScale 0.3s ease forwards;
                animation-delay: 0.3s;
                opacity: 0;
            }
    
            .bg-blur-1 {
                animation: bgBlur 2s ease forwards;
                animation-delay: 0.5s;
                opacity: 0;
            }
    
            .bg-blur-2 {
                animation: bgBlur 2s ease forwards;
                animation-delay: 1s;
                opacity: 0;
            }
    
            .login-content {
                animation: fadeInUp 0.6s ease-out forwards;
                opacity: 0;
            }
    
            .footer-content {
                animation: fadeInUp 0.5s ease forwards;
                animation-delay: 1s;
                opacity: 0;
            }
            
            .login-card {
                backdrop-filter: blur(10px);
                transition: all 0.3s ease;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <!-- Theme Toggle Button -->
        <div class="theme-toggle fixed top-4 right-4 z-20">
            <button id="themeToggle" class="p-3 rounded-lg bg-white/20 dark:bg-gray-800/20 backdrop-blur-sm border border-white/30 dark:border-gray-600/30 hover:bg-white/30 dark:hover:bg-gray-700/30 transition-all">
                <i data-lucide="sun" class="w-5 h-5 text-yellow-500 dark:hidden"></i>
                <i data-lucide="moon" class="w-5 h-5 text-gray-300 hidden dark:block"></i>
            </button>
        </div>

        <!-- Background Effects -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="bg-blur-1 absolute -top-32 -right-32 w-64 h-64 bg-white dark:bg-gray-200 rounded-full blur-3xl"></div>
            <div class="bg-blur-2 absolute -bottom-32 -left-32 w-64 h-64 bg-teal-200 dark:bg-teal-800 rounded-full blur-3xl"></div>
        </div>

        <!-- Back to Home Button -->
        <div class="fixed top-4 left-4 z-20">
            <a href="/" class="flex items-center p-2 text-white hover:bg-white/10 rounded-lg transition-all">
                <i data-lucide="arrow-left" class="w-5 h-5 mr-1"></i>
                <span>Kembali</span>
            </a>
        </div>
        
        <div class="min-h-screen flex flex-col justify-center items-center p-4">
            <div class="login-content w-full max-w-xl">
                <div class="flex items-center justify-center mb-6">
                    <i data-lucide="shield" class="w-12 h-12 text-white mr-3"></i>
                    <div class="flex flex-col">
                        <h1 class="text-3xl font-bold text-white" style="text-shadow: 0 2px 10px rgba(0,0,0,0.2)">ProPangkat</h1>
                        <p class="text-sm text-white/80">Proses Kenaikan Pangkat Terintegrasi</p>
                    </div>
                </div>

                <div class="login-card bg-white/20 dark:bg-gray-800/30 border border-white/30 dark:border-gray-700/30 rounded-2xl p-8 shadow-xl">
                    {{ $slot }}
                </div>
                
                <!-- Information Box -->
                <div class="mt-6 bg-white/10 dark:bg-gray-800/30 backdrop-blur-sm rounded-xl p-4 border border-white/20 dark:border-gray-700/30">
                    <p class="text-white text-center text-sm">
                        <span class="font-semibold">Informasi:</span> Gunakan NIP 18 digit dan password yang telah diberikan untuk login. Jika mengalami kesulitan, hubungi administrator sistem.
                    </p>
                </div>
            </div>
            
            <!-- Footer -->
            <footer class="footer-content absolute bottom-4 w-full text-center">
                <p class="text-sky-100 dark:text-gray-300 text-xs font-medium" style="color: var(--text-footer)">
                    © {{ date('Y') }} Dinas Pendidikan dan Kebudayaan Prov. Kaltim Kalimantan Timur
                </p>
            </footer>
        </div>

        <!-- Toast Container -->
        <div id="toastContainer" class="fixed bottom-4 right-4 z-50"></div>

        <script>
            // Initialize Lucide icons
            lucide.createIcons();
    
            // Theme Toggle Functionality
            const themeToggle = document.getElementById('themeToggle');
            const html = document.documentElement;
            
            // Check for saved theme preference or default to light
            const currentTheme = localStorage.getItem('theme') || 'light';
            html.setAttribute('data-theme', currentTheme);
            
            // Update Tailwind dark mode class
            if (currentTheme === 'dark') {
                html.classList.add('dark');
            }
    
            themeToggle.addEventListener('click', () => {
                const newTheme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                
                // Toggle Tailwind dark mode
                if (newTheme === 'dark') {
                    html.classList.add('dark');
                } else {
                    html.classList.remove('dark');
                }
                
                // Re-initialize icons after theme change
                setTimeout(() => lucide.createIcons(), 100);
                
                // Show toast notification
                showToast(`Mode ${newTheme === 'dark' ? 'Gelap' : 'Terang'} Diaktifkan`);
            });
    
            // Simple Toast Notification Function
            function showToast(message) {
                const toast = document.createElement('div');
                toast.className = 'bg-white dark:bg-gray-800 text-gray-900 dark:text-white px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-y-full opacity-0 mb-2';
                toast.textContent = message;
                
                const container = document.getElementById('toastContainer');
                container.appendChild(toast);
                
                // Animate in
                setTimeout(() => {
                    toast.classList.remove('translate-y-full', 'opacity-0');
                }, 100);
                
                // Remove after 3 seconds
                setTimeout(() => {
                    toast.classList.add('translate-y-full', 'opacity-0');
                    setTimeout(() => container.removeChild(toast), 300);
                }, 3000);
            }
        </script>
    </body>
</html>
