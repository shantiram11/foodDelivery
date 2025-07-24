<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --accent-color: #cda45e;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen flex">
            <!-- Left Panel - Form -->
            <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white">
                <div class="mx-auto w-full max-w-sm lg:w-96">
                    <div class="mb-8">
                        <a href="/" class="inline-flex items-center justify-center">
                        
                                <img src="{{ asset('frontend/img/logo.svg') }}" alt="Foodymat" style="height: 32px; width: auto;">
                          
                        </a>
                    </div>

                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome back</h2>
                        <p class="text-gray-600 mb-8">Sign in to your account to continue</p>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <p class="text-sm text-green-800">{{ session('status') }}</p>
                                </div>
                            </div>
                        @endif


                        

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf

                            <!-- Email Address -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                        </svg>
                                    </div>
                                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:border-transparent transition-colors duration-200 text-gray-900"
                                           style="focus:ring-color: var(--accent-color);"
                                           placeholder="Enter your email">
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <input id="password" name="password" type="password" required autocomplete="current-password"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:border-transparent transition-colors duration-200 text-gray-900"
                                           style="focus:ring-color: var(--accent-color);"
                                           placeholder="Enter your password">
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me and Forgot Password -->
                            <div class="flex items-center justify-between">
                                <label for="remember_me" class="flex items-center">
                                    <input id="remember_me" name="remember" type="checkbox" 
                                           class="h-4 w-4 rounded border-gray-300 focus:ring-2 focus:ring-offset-2 transition-colors duration-200"
                                           style="color: var(--accent-color); focus:ring-color: var(--accent-color);">
                                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm font-medium hover:underline transition-colors duration-200" style="color: var(--accent-color);">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02]"
                                    style="background-color: var(--accent-color); focus:ring-color: var(--accent-color);">
                                Sign in to your account
                            </button>
                        </form>

                        <!-- Sign up link -->
                        <div class="mt-8 text-center">
                            <p class="text-sm text-gray-600">
                                Don't have an account? 
                                <a href="{{ route('register') }}" class="font-medium hover:underline transition-colors duration-200" style="color: var(--accent-color);">
                                    Create an account
                                </a>
                            </p>
                        </div>

                        <!-- Divider -->
                        <div class="relative mb-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">or continue with email</span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Right Panel - Illustration -->
            <div class="hidden lg:block relative flex-1">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('frontend/img/gallery/gallery-1.jpg') }}');">
                    <div class="absolute inset-0 bg-black opacity-40"></div>
                </div>
                
                <div class="relative h-full flex flex-col justify-center items-center px-12 text-white z-10">
                    <div class="max-w-md text-center">
                        <!-- Illustration Icons -->
                        <div class="mb-8 flex justify-center space-x-4">
                            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V7h10v2z"/>
                                </svg>
                            </div>
                            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 11H7v3h2v-3zm4 0h-2v3h2v-3zm4 0h-2v3h2v-3zm2-7h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                                </svg>
                            </div>
                        </div>

                        <h2 class="text-3xl font-bold mb-4">
                            Delicious Food Delivered
                        </h2>
                        <p class="text-lg text-white text-opacity-90 leading-relaxed">
                            Experience the finest flavors from your favorite restaurants, delivered fresh to your doorstep in minutes.
                        </p>

                        <!-- Decorative Elements -->
                        <div class="mt-12 flex justify-center space-x-2">
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                            <div class="w-8 h-2 bg-white bg-opacity-60 rounded-full"></div>
                            <div class="w-2 h-2 bg-white bg-opacity-40 rounded-full"></div>
                        </div>
                    </div>

                    <!-- Floating Elements -->
                    <div class="absolute top-20 left-20 w-20 h-20 bg-white bg-opacity-10 rounded-full animate-pulse"></div>
                    <div class="absolute bottom-32 right-16 w-16 h-16 bg-white bg-opacity-10 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
                    <div class="absolute top-1/3 right-32 w-12 h-12 bg-white bg-opacity-10 rounded-full animate-pulse" style="animation-delay: 2s;"></div>
                </div>
            </div>
        </div>
    </body>
</html>
