<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Expense Management') }}</title>

    {{-- Fonts (optional) --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    {{-- Styles / Scripts (Vite-aware) --}}
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="antialiased bg-white text-slate-800 font-sans">
    <div class="min-h-screen flex flex-col">
        <header class="w-full py-5 bg-white border-b-2 border-blue-100 shadow-sm">
            <div class="max-w-6xl mx-auto px-4 flex items-center justify-between">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center shadow-md">
                        <span class="text-white font-bold text-xl">💰</span>
                    </div>
                    <span class="text-2xl font-bold text-gray-800">{{ config('app.name', 'Expense Management') }}</span>
                </a>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold text-base hover:bg-blue-700 transition-colors duration-200 shadow-md">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-3 text-gray-700 border-2 border-gray-300 rounded-lg hover:border-blue-600 hover:text-blue-600 transition-colors duration-200 font-medium text-base">Sign In</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md text-base">Get Started</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <main class="flex-1 bg-gray-50">
            <section class="py-20">
                <div class="max-w-6xl mx-auto px-4 text-center">
                    <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-800 px-5 py-2 rounded-full font-semibold mb-8">
                        <span class="w-3 h-3 bg-blue-600 rounded-full"></span>
                        Trusted by 1000+ companies worldwide
                    </div>
                    
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 leading-tight mb-6">
                        Manage Expenses<br>
                        <span class="text-blue-600">Effortlessly</span>
                    </h1>
                    <p class="text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed mb-10">
                        Capture receipts, route approvals, and get clear reports — all in one simple workflow built for modern teams who value efficiency.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold text-base shadow-lg hover:bg-blue-700 transition-colors duration-200">Go to Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-8 py-3 border-2 border-gray-400 text-gray-800 rounded-lg font-semibold text-base hover:border-blue-600 hover:text-blue-600 transition-colors duration-200">Sign In</a>
                        @endauth
                    </div>

                    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-6 bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow duration-200 text-left">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-xl mb-4">
                                📸
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Smart Capture</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">Snap receipts and auto-fill expense details with AI-powered technology to save time and reduce errors.</p>
                        </div>
                        <div class="p-6 bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow duration-200 text-left">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-xl mb-4">
                                ✅
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Flexible Approvals</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">Route expenses to the right approvers with customizable workflows and keep complete control over spending.</p>
                        </div>
                        <div class="p-6 bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow duration-200 text-left">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-xl mb-4">
                                📊
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Reports & Export</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">Generate comprehensive reports and export data in multiple formats for accounting and audit purposes.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white relative overflow-hidden">
            <!-- Subtle background pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-0 left-0 w-full h-full" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="7" cy="7" r="1"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            </div>
            
            <div class="max-w-6xl mx-auto px-4 py-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Company Info -->
                    <div class="md:col-span-2">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-md">
                                <span class="text-white font-bold text-base">💰</span>
                            </div>
                            <span class="text-lg font-bold text-white">{{ config('app.name', 'Expense Management') }}</span>
                        </div>
                        <p class="text-gray-300 text-sm leading-relaxed max-w-sm">
                            Streamline your expense management with our modern platform designed for efficiency and control.
                        </p>
                        <!-- Social Links -->
                        <div class="flex gap-3 mt-4">
                            <a href="#" class="w-8 h-8 bg-gray-700 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                            </a>
                            <a href="#" class="w-8 h-8 bg-gray-700 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                            <a href="#" class="w-8 h-8 bg-gray-700 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-110">
                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.719-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.իւ4.215-.402.402-1.033.402-1.684 0-.402-.402-.402-1.033-.804-1.684-.402-.402-.402-1.033-.402-1.684 0-.402.402-.402 1.033.402 1.684z"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-base font-semibold mb-3 text-white flex items-center gap-1">
                            <span class="w-1 h-4 bg-blue-500 rounded-full"></span>
                            Product
                        </h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center gap-1 group">
                                <span class="w-1 h-1 bg-gray-500 rounded-full group-hover:bg-blue-400 transition-colors"></span>
                                Features
                            </a></li>
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center gap-1 group">
                                <span class="w-1 h-1 bg-gray-500 rounded-full group-hover:bg-blue-400 transition-colors"></span>
                                Pricing
                            </a></li>
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center gap-1 group">
                                <span class="w-1 h-1 bg-gray-500 rounded-full group-hover:bg-blue-400 transition-colors"></span>
                                Integrations
                            </a></li>
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center gap-1 group">
                                <span class="w-1 h-1 bg-gray-500 rounded-full group-hover:bg-blue-400 transition-colors"></span>
                                API Docs
                            </a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h4 class="text-base font-semibold mb-3 text-white flex items-center gap-1">
                            <span class="w-1 h-4 bg-green-500 rounded-full"></span>
                            Support
                        </h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center gap-1 group">
                                <span class="w-1 h-1 bg-gray-500 rounded-full group-hover:bg-green-400 transition-colors"></span>
                                Help Center
                            </a></li>
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center gap-1 group">
                                <span class="w-1 h-1 bg-gray-500 rounded-full group-hover:bg-green-400 transition-colors"></span>
                                Contact Us
                            </a></li>
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center gap-1 group">
                                <span class="w-1 h-1 bg-gray-500 rounded-full group-hover:bg-green-400 transition-colors"></span>
                                Privacy Policy
                            </a></li>
                            <li><a href="#" class="text-gray-400 text-sm hover:text-white hover:translate-x-1 transition-all duration-200 flex items-center gap-1 group">
                                <span class="w-1 h-1 bg-gray-500 rounded-full group-hover:bg-green-400 transition-colors"></span>
                                Terms
                            </a></li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Section -->
                <div class="relative mt-6 pt-6">
                    <!-- Beautiful decorative line with gradient and dots -->
                    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-gray-600/40 to-transparent"></div>
                    <div class="absolute top-0 left-1/4 w-1/2 h-px bg-gradient-to-r from-blue-500/20 via-purple-500/40 to-blue-500/20"></div>
                    
                    <!-- Decorative dots -->
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                        <div class="flex items-center gap-1">
                            <div class="w-1 h-1 bg-purple-500/60 rounded-full"></div>
                            <div class="w-1.5 h-1.5 bg-blue-500/80 rounded-full"></div>
                            <div class="w-1 h-1 bg-purple-500/60 rounded-full"></div>
                        </div>
                    </div>
                    
                    <!-- Side accent dots -->
                    <div class="absolute top-0 left-16 transform -translate-y-1/2">
                        <div class="w-1 h-1 bg-blue-400/50 rounded-full"></div>
                    </div>
                    <div class="absolute top-0 right-16 transform -translate-y-1/2">
                        <div class="w-1 h-1 bg-purple-400/50 rounded-full"></div>
                    </div>
                    
                    <div class="flex flex-col md:flex-row items-center justify-between gap-3">
                    <div class="flex items-center gap-4 text-center md:text-left">
                        <p class="text-gray-400 text-sm">© {{ date('Y') }} {{ config('app.name', 'Expense Management') }}. All rights reserved.</p>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <!-- Theme Toggle -->
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-400">Theme:</span>
                            <button id="themeToggle" class="flex items-center gap-1 px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded-full transition-all duration-300 border border-gray-600 group">
                                <svg id="lightIcon" class="w-3 h-3 text-yellow-400 transition-opacity duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                                </svg>
                                <svg id="darkIcon" class="w-3 h-3 text-blue-400 opacity-0 transition-opacity duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                                </svg>
                                <span id="themeText" class="text-xs text-gray-300 font-medium">Light</span>
                            </button>
                        </div>
                        
                        <div class="flex items-center gap-1 text-xs text-gray-500">
                            <span>Built with</span>
                            <span class="text-red-400">❤️</span>
                            <span>using</span>
                            <span class="font-medium text-orange-400">Laravel</span>
                        </div>
                        <div class="flex items-center gap-1 px-2 py-1 bg-green-500/10 rounded-full border border-green-500/20">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-green-400 text-xs font-medium">Online</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Theme Toggle Functionality
        const themeToggle = document.getElementById('themeToggle');
        const lightIcon = document.getElementById('lightIcon');
        const darkIcon = document.getElementById('darkIcon');
        const themeText = document.getElementById('themeText');
        const body = document.body;

        // Check for saved theme preference or default to 'dark'
        const currentTheme = localStorage.getItem('theme') || 'dark';
        
        // Apply the current theme
        function applyTheme(theme) {
            if (theme === 'dark') {
                body.classList.add('dark');
                lightIcon.style.opacity = '0';
                darkIcon.style.opacity = '1';
                themeText.textContent = 'Dark';
                // Add dark theme styles
                body.style.backgroundColor = '#1a202c';
                body.style.color = '#e2e8f0';
            } else {
                body.classList.remove('dark');
                lightIcon.style.opacity = '1';
                darkIcon.style.opacity = '0';
                themeText.textContent = 'Light';
                // Reset to light theme
                body.style.backgroundColor = '';
                body.style.color = '';
            }
        }

        // Initialize theme
        applyTheme(currentTheme);

        // Theme toggle event listener
        themeToggle.addEventListener('click', function() {
            const newTheme = body.classList.contains('dark') ? 'light' : 'dark';
            applyTheme(newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Add a nice animation effect
            themeToggle.style.transform = 'scale(0.95)';
            setTimeout(() => {
                themeToggle.style.transform = 'scale(1)';
            }, 150);
        });

        // Add smooth theme transition
        document.documentElement.style.setProperty('--transition', 'all 0.3s ease');
        
        // Optional: Add keyboard support
        themeToggle.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                themeToggle.click();
            }
        });
    </script>
</body>
</html>
