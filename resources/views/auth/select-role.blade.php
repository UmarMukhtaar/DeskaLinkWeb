<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Select Your Role') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">{{ __('Complete Your Registration') }}</h2>
                    <p class="mt-2 text-gray-600">{{ __('Please select your role to continue') }}</p>
                </div>

                <form method="POST" action="{{ route('role.process') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input id="role-client" name="role" type="radio" value="client" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300" checked>
                            <label for="role-client" class="ml-3 block text-sm font-medium text-gray-700">
                                <span class="font-bold">{{ __('Client') }}</span>
                                <p class="text-gray-500 text-sm mt-1">{{ __('I want to browse and purchase designs/services') }}</p>
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input id="role-partner" name="role" type="radio" value="partner" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300">
                            <label for="role-partner" class="ml-3 block text-sm font-medium text-gray-700">
                                <span class="font-bold">{{ __('Partner') }}</span>
                                <p class="text-gray-500 text-sm mt-1">{{ __('I want to sell designs/services on the platform') }}</p>
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            {{ __('Continue') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>