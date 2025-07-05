<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Shringa CRM'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Custom Styles -->
        <style>
            body {
                background-image: radial-gradient(circle at top right, rgba(14, 153, 233, 0.08), rgba(130, 87, 246, 0.03), rgba(255, 255, 255, 0) 70%),
                                 radial-gradient(circle at bottom left, rgba(14, 153, 233, 0.05), rgba(130, 87, 246, 0.02), rgba(255, 255, 255, 0) 70%);
                background-attachment: fixed;
            }
            
            .card-hover {
                transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            }
            
            .card-hover:hover {
                transform: translateY(-2px);
            }
            
            .glass-card {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            .glass-nav {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            /* Ensure dropdowns have no transparency effects */
            .dropdown-no-blur {
                backdrop-filter: none !important;
                -webkit-backdrop-filter: none !important;
                background: #ffffff !important;
            }
            
            /* Force dropdown visibility when shown */
            nav .dropdown-no-blur[x-show="open"] {
                z-index: 99999 !important;
                position: absolute !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="min-h-screen pt-16">
            @include('layouts.navigation')

            <!-- New Sticky Page Header -->
            @hasSection('page_header')
                <div class="sticky top-16 z-10 bg-white border-b border-gray-200 shadow-sm">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                @yield('page_icon')
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">@yield('page_title')</h1>
                                    @hasSection('page_subtitle')
                                        <p class="text-sm text-gray-600 mt-1">@yield('page_subtitle')</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                @yield('page_actions')
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="pt-4 pb-3">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 animate-fade-in">
                    @if (session('success'))
                        <div class="mb-6 bg-success-100 border-l-4 border-success-500 text-success-700 p-4 rounded-md shadow-sm animate-slide-up" role="alert">
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 bg-danger-100 border-l-4 border-danger-500 text-danger-700 p-4 rounded-md shadow-sm animate-slide-up" role="alert">
                            <p class="font-medium">{{ session('error') }}</p>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="mb-6 bg-warning-100 border-l-4 border-warning-500 text-warning-700 p-4 rounded-md shadow-sm animate-slide-up" role="alert">
                            <p class="font-medium">{{ session('warning') }}</p>
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="mb-6 bg-primary-100 border-l-4 border-primary-500 text-primary-700 p-4 rounded-md shadow-sm animate-slide-up" role="alert">
                            <p class="font-medium">{{ session('info') }}</p>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-100 shadow-sm py-6 mt-12 glass-nav">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">
                                &copy; {{ date('Y') }} Shringa Interior Design CRM. All rights reserved.
                            </p>
                        </div>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-500 hover:text-primary-500 transition-colors duration-200">
                                <span class="sr-only">Support</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-primary-500 transition-colors duration-200">
                                <span class="sr-only">Settings</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
