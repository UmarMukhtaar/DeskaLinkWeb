<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 border-b border-gray-200 font-semibold text-lg">
                {{ __('Dashboard') }}
            </div>

            <div class="px-6 py-4">
                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- <p class="text-gray-700">
                    {{ __('You are logged in as :name!', ['name' => Auth::user()->full_name]) }}
                </p> -->
                
                <p class="text-gray-700">
                    {{ __('You are logged in as :username!', ['username' => Auth::user()->username]) }}
                </p>
            </div>
        </div>
    </div>
</x-app-layout>