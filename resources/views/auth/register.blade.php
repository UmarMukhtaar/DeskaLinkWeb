<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Register') }}</title>
    <link rel="icon" href="{{ asset('images/Logo Deskalink.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'slide-in-right': 'slideInRight 0.5s ease-out',
                        'slide-in-left': 'slideInLeft 0.5s ease-out',
                        'fade-in': 'fadeIn 0.3s ease-out',
                        'bounce-in': 'bounceIn 0.6s ease-out',
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
        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }
        .bg-register-image {
            background-image: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(59, 130, 246, 0.1)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="%23e5e7eb" stroke-width="0.5" opacity="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            background-size: cover, 20px 20px;
            background-position: center, center;
        }
        .form-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .form-transition:focus-within {
            transform: translateY(-2px);
        }
        .scrollable-form {
            max-height: calc(70vh - 70px);
            overflow-x: auto;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #ef4444 #e5e7eb;
            padding-right: 15px;
            margin-right: -15px;
        }
        .scrollable-form::-webkit-scrollbar {
            width: 6px;
        }
        .scrollable-form::-webkit-scrollbar-track {
            background: #e5e7eb;
            border-radius: 10px;
        }
        .scrollable-form::-webkit-scrollbar-thumb {
            background-color: #ef4444;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl w-full">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden animate-fade-in">
                <div class="flex flex-col lg:flex-row">
                    <!-- Left Side: Image/Illustration -->
                    <div class="lg:w-1/2 bg-[url('/images/register-bg.webp')] bg-cover bg-center relative overflow-hidden animate-slide-in-left">
                        <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                        <div class="relative z-10 p-8 h-full flex flex-col justify-between text-white min-h-96">
                            <div>
                                <h1 class="text-3xl font-bold mb-2">{{ config('app.name', 'Laravel') }}</h1>
                                <p class="text-lg opacity-90">Join our community today</p>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3 animate-slide-in-left" style="animation-delay: 0.2s;">
                                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span>Free Account Creation</span>
                                </div>
                                <div class="flex items-center space-x-3 animate-slide-in-left" style="animation-delay: 0.3s;">
                                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                        </svg>
                                    </div>
                                    <span>Full Dashboard Access</span>
                                </div>
                                <div class="flex items-center space-x-3 animate-slide-in-left" style="animation-delay: 0.4s;">
                                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span>Choose Your Role</span>
                                </div>
                                <div class="flex items-center space-x-3 animate-slide-in-left" style="animation-delay: 0.5s;">
                                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm4.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span>Reap The Rewards</span>
                                </div>
                            </div>

                            <div class="text-center animate-bounce-in">
                                <p class="text-sm opacity-75">Already have an account?</p>
                                <a href="{{ route('login') }}" class="inline-block mt-2 px-6 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg font-medium transition-all duration-200 transform hover:scale-105">
                                    Sign In
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Registration Form -->
                    <div class="lg:w-1/2 p-8 lg:p-12 animate-slide-in-right">
                        <div class="max-w-md mx-auto">
                            <div class="text-center mb-8">
                                <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Create Account') }}</h2>
                                <p class="text-gray-600">{{ __('Join us and start your journey') }}</p>
                            </div>

                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <form method="POST" action="{{ route('register') }}" class="space-y-5 scrollable-form">
                                @csrf

                                <!-- Full Name -->
                                <div class="form-transition">
                                    <x-input-label for="full_name" :value="__('Full Name')" class="text-gray-700 font-medium" />
                                    <x-text-input id="full_name"
                                        class="mt-2 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 placeholder-gray-500 transition-all duration-200"
                                        type="text"
                                        name="full_name"
                                        :value="old('full_name')"
                                        required
                                        autofocus
                                        autocomplete="full_name"
                                        placeholder="Enter your full name" />
                                    <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                                </div>

                                <!-- Username -->
                                <div class="form-transition">
                                    <x-input-label for="username" :value="__('Username')" class="text-gray-700 font-medium" />
                                    <x-text-input id="username" 
                                        class="mt-2 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 placeholder-gray-500 transition-all duration-200" 
                                        type="text" 
                                        name="username" 
                                        :value="old('username')" 
                                        required 
                                        autocomplete="username"
                                        placeholder="Choose a username" />
                                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                                </div>

                                <!-- Email Address -->
                                <div class="form-transition">
                                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
                                    <x-text-input id="email" 
                                        class="mt-2 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 placeholder-gray-500 transition-all duration-200" 
                                        type="email" 
                                        name="email" 
                                        :value="old('email')" 
                                        required 
                                        autocomplete="username"
                                        placeholder="Enter your email address" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Phone Number -->
                                <div class="form-transition">
                                    <x-input-label for="phone" :value="__('Phone Number')" class="text-gray-700 font-medium" />
                                    <x-text-input id="phone" 
                                        class="mt-2 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 placeholder-gray-500 transition-all duration-200" 
                                        type="tel" 
                                        name="phone" 
                                        :value="old('phone')" 
                                        required 
                                        autocomplete="tel"
                                        placeholder="Enter your phone number" />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>

                                <!-- Role Selection -->
                                <div class="form-transition">
                                    <x-input-label for="role" :value="__('Register as')" class="text-gray-700 font-medium" />
                                    <select id="role" name="role" 
                                        class="mt-2 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 transition-all duration-200" 
                                        required>
                                        <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client (Buyer of Services & Designs)</option>
                                        <option value="partner" {{ old('role') == 'partner' ? 'selected' : '' }}>Partner (Seller of Services & Digital Designs)</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div class="form-transition">
                                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                                    <x-text-input id="password" 
                                        class="mt-2 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 placeholder-gray-500 transition-all duration-200"
                                        type="password"
                                        name="password"
                                        required 
                                        autocomplete="new-password"
                                        placeholder="Create a strong password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-transition">
                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-medium" />
                                    <x-text-input id="password_confirmation" 
                                        class="mt-2 block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-gray-900 placeholder-gray-500 transition-all duration-200"
                                        type="password"
                                        name="password_confirmation"
                                        required 
                                        autocomplete="new-password"
                                        placeholder="Confirm your password" />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <!-- Terms & Conditions -->
                                <div class="flex items-start">
                                    <input id="terms" type="checkbox" 
                                        class="mt-1 rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500 bg-gray-50" 
                                        name="terms" required>
                                    <label for="terms" class="ml-3 text-sm text-gray-600 leading-relaxed">
                                        {{ __('I agree to the') }} 
                                        <a href="#" class="text-red-600 hover:text-red-500 font-medium transition-colors duration-200">
                                            {{ __('Terms & Conditions') }}
                                        </a> 
                                        {{ __('and') }} 
                                        <a href="#" class="text-red-600 hover:text-red-500 font-medium transition-colors duration-200">
                                            {{ __('Privacy Policy') }}
                                        </a>
                                    </label>
                                </div>

                                <div>
                                    <x-primary-button class="w-full justify-center py-3 px-4 bg-red-600 hover:bg-red-700 focus:ring-red-500 text-white font-medium rounded-lg shadow-lg transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                                        {{ __('Create Account') }}
                                    </x-primary-button>
                                </div>

                                <!-- Social Login Divider -->
                                <!-- <div class="relative">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                                        <span class="px-2 bg-white text-gray-500">{{ __('Or register with') }}</span>
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