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
                            <a href="{{ url('/dashboard') }}" class="px-10 py-4 bg-blue-600 text-white rounded-lg font-bold text-lg shadow-lg hover:bg-blue-700 transition-colors duration-200">Go to Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="px-10 py-4 bg-blue-600 text-white rounded-lg font-bold text-lg shadow-lg hover:bg-blue-700 transition-colors duration-200">Get Started Free</a>
                            <a href="{{ route('login') }}" class="px-10 py-4 border-2 border-gray-400 text-gray-800 rounded-lg font-bold text-lg hover:border-blue-600 hover:text-blue-600 transition-colors duration-200">Sign In</a>
                        @endauth
                    </div>

                    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="p-8 bg-white rounded-xl shadow-md border text-left">
                            <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center text-3xl mb-6">
                                📸
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Smart Capture</h3>
                            <p class="text-gray-700 text-lg leading-relaxed">Snap receipts and auto-fill expense details with AI-powered technology to save time and reduce errors.</p>
                        </div>
                        <div class="p-8 bg-white rounded-xl shadow-md border text-left">
                            <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center text-3xl mb-6">
                                ✅
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Flexible Approvals</h3>
                            <p class="text-gray-700 text-lg leading-relaxed">Route expenses to the right approvers with customizable workflows and keep complete control over spending.</p>
                        </div>
                        <div class="p-8 bg-white rounded-xl shadow-md border text-left">
                            <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center text-3xl mb-6">
                                📊
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Reports & Export</h3>
                            <p class="text-gray-700 text-lg leading-relaxed">Generate comprehensive reports and export data in multiple formats for accounting and audit purposes.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-gray-800 text-white">
            <div class="max-w-6xl mx-auto px-4 py-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Company Info -->
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-xl">💰</span>
                            </div>
                            <span class="text-2xl font-bold text-white">{{ config('app.name', 'Expense Management') }}</span>
                        </div>
                        <p class="text-gray-300 text-lg leading-relaxed">
                            Streamline your expense management with our platform designed for modern businesses.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-xl font-bold mb-4 text-white">Product</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-300 text-lg hover:text-white transition-colors duration-200">Features</a></li>
                            <li><a href="#" class="text-gray-300 text-lg hover:text-white transition-colors duration-200">Pricing</a></li>
                            <li><a href="#" class="text-gray-300 text-lg hover:text-white transition-colors duration-200">Integrations</a></li>
                            <li><a href="#" class="text-gray-300 text-lg hover:text-white transition-colors duration-200">API Docs</a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h4 class="text-xl font-bold mb-4 text-white">Support</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-300 text-lg hover:text-white transition-colors duration-200">Help Center</a></li>
                            <li><a href="#" class="text-gray-300 text-lg hover:text-white transition-colors duration-200">Contact Us</a></li>
                            <li><a href="#" class="text-gray-300 text-lg hover:text-white transition-colors duration-200">Privacy Policy</a></li>
                            <li><a href="#" class="text-gray-300 text-lg hover:text-white transition-colors duration-200">Terms</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                    <p class="text-gray-300 text-lg">© {{ date('Y') }} {{ config('app.name', 'Expense Management') }}. All rights reserved.</p>
                    <p class="text-gray-400 text-base mt-2">Built with ❤️ using Laravel</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
