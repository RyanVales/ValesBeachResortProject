<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vales Beach Resort - Your Paradise Awaits</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-sm shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-blue-600">Vales Beach Resort</h1>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#home" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Home</a>
                        <a href="#rooms" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Rooms</a>
                        <a href="#amenities" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Amenities</a>
                        <a href="#contact" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Contact</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative h-screen bg-gradient-to-r from-blue-600 to-blue-800">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative z-10 flex items-center justify-center h-full">
            <div class="text-center text-white px-4">
                <h1 class="text-5xl md:text-7xl font-bold mb-6">Welcome to Paradise</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">Experience luxury and comfort at Vales Beach Resort. Where crystal clear waters meet pristine beaches and unforgettable memories are made.</p>
                <div class="space-x-4">
                    <a href="#rooms" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block">Book Now</a>
                    <a href="#amenities" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors inline-block">Explore</a>
                </div>
            </div>
        </div>
        <!-- Background pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="beach-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <circle cx="10" cy="10" r="2" fill="white"/>
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#beach-pattern)"/>
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose Vales Beach Resort?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Discover what makes our resort the perfect destination for your next vacation</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Luxury Accommodations</h3>
                    <p class="text-gray-600">Spacious rooms and suites with ocean views, modern amenities, and elegant furnishings.</p>
                </div>

                <div class="text-center bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">World-Class Service</h3>
                    <p class="text-gray-600">24/7 concierge service, daily housekeeping, and personalized attention to every detail.</p>
                </div>

                <div class="text-center bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Premium Amenities</h3>
                    <p class="text-gray-600">Spa, fitness center, multiple restaurants, pools, and direct beach access.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Section -->
    <section id="rooms" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Rooms & Suites</h2>
                <p class="text-xl text-gray-600">Choose from our selection of beautifully appointed accommodations</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="h-64 bg-gradient-to-br from-blue-400 to-blue-600"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Ocean View Room</h3>
                        <p class="text-gray-600 mb-4">Comfortable room with stunning ocean views and modern amenities.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-blue-600">$199/night</span>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="h-64 bg-gradient-to-br from-green-400 to-green-600"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Deluxe Suite</h3>
                        <p class="text-gray-600 mb-4">Spacious suite with separate living area and premium amenities.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-blue-600">$299/night</span>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Book Now</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="h-64 bg-gradient-to-br from-purple-400 to-purple-600"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Presidential Suite</h3>
                        <p class="text-gray-600 mb-4">Ultimate luxury with panoramic views and exclusive amenities.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-blue-600">$499/night</span>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Book Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Vales Beach Resort</h3>
                    <p class="text-gray-400">Your premier destination for luxury beach vacations and unforgettable experiences.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#home" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="#rooms" class="hover:text-white transition-colors">Rooms</a></li>
                        <li><a href="#amenities" class="hover:text-white transition-colors">Amenities</a></li>
                        <li><a href="#contact" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Info</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>123 Beach Paradise Lane</li>
                        <li>Tropical Island, TI 12345</li>
                        <li>Phone: (555) 123-4567</li>
                        <li>Email: info@valesbeachresort.com</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Facebook</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Instagram</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Twitter</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Vales Beach Resort. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>