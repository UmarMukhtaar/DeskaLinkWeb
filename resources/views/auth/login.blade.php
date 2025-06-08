<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Login') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'slide-in-right': 'slideInRight 0.5s ease-out',
                        'slide-in-left': 'slideInLeft 0.5s ease-out',
                        'fade-in': 'fadeIn 0.3s ease-out',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideInLeft {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .bg-login-image {
            background-image: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(168, 85, 247, 0.1)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="%23ffffff" stroke-width="0.5" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            background-size: cover, 20px 20px;
            background-position: center, center;
        }
    </style>
</head>
<body class="bg-white">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl w-full">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden animate-fade-in">
                <div class="flex flex-col lg:flex-row">
                    <!-- Left Side: Image/Illustration -->
                    <div class="lg:w-1/2 bg-[url('/images/login-bg-1.webp')] bg-cover bg-center relative overflow-hidden animate-slide-in-left">
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                        <div class="relative z-10 p-8 h-full flex flex-col justify-between text-white min-h-96">
                            <div>
                                <h1 class="text-3xl font-bold mb-2">{{ config('app.name', 'Laravel') }}</h1>
                                <p class="text-lg opacity-90">Welcome back to your account</p>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span>Secure Authentication</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span>Fast & Reliable</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span>24/7 Support</span>
                                </div>
                            </div>

                            <div class="text-center">
                                <p class="text-sm opacity-75">Don't have an account?</p>
                                <a href="{{ route('register') }}" class="inline-block mt-2 px-6 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg font-medium transition-all duration-200 transform hover:scale-105">
                                    Create Account
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Login Form -->
                    <div class="lg:w-1/2 p-8 lg:p-12 animate-slide-in-right">
                        <div class="max-w-md mx-auto">
                            <div class="text-center mb-8">
                                <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Welcome Back') }}</h2>
                                <p class="text-gray-600">{{ __('Please sign in to your account') }}</p>
                            </div>

                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                                @csrf

                                <!-- Email Address -->
                                <div>
                                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
                                    <x-text-input id="email" 
                                        class="mt-2 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 placeholder-gray-500 transition-all duration-200" 
                                        type="email" 
                                        name="email" 
                                        :value="old('email')" 
                                        required 
                                        autofocus 
                                        autocomplete="username"
                                        placeholder="Enter your email" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div>
                                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                                    <x-text-input id="password" 
                                        class="mt-2 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 placeholder-gray-500 transition-all duration-200"
                                        type="password"
                                        name="password"
                                        required 
                                        autocomplete="current-password"
                                        placeholder="Enter your password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Remember Me -->
                                <div class="flex items-center justify-between">
                                    <!-- <label for="remember_me" class="inline-flex items-center">
                                        <input id="remember_me" type="checkbox" 
                                            class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500 bg-gray-50"
                                            name="remember">
                                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                    </label> -->

                                    <!-- @if (Route::has('password.request'))
                                        <a class="text-sm text-red-600 hover:text-red-500 font-medium transition-colors duration-200" href="{{ route('password.request') }}">
                                            {{ __('Forgot your password?') }}
                                        </a>
                                    @endif -->
                                </div>

                                <div>
                                    <x-primary-button class="w-full justify-center py-3 px-4 bg-red-600 hover:bg-red-700 focus:ring-red-500 text-white font-medium rounded-lg shadow-lg transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                                        {{ __('Sign In') }}
                                    </x-primary-button>
                                </div>

                                <!-- Social Login Divider -->
                                <!-- <div class="relative">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                                        <span class="px-2 bg-white text-gray-500">{{ __('Or continue with') }}</span>
                                    </div>
                                </div> -->

                                <!-- Social Login Buttons -->

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>