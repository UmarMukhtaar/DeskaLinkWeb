<section>
    <header class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and settings.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Photo Section -->
        <div class="flex flex-col items-center space-y-4 p-6 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
            <div class="relative">
                @if($user->profile_photo_url)
                    <img id="profile-preview" src="{{ $user->profile_photo_url }}" alt="Profile Photo" 
                         class="h-32 w-32 rounded-full object-cover border-4 border-white dark:border-gray-600 shadow-lg">
                @else
                    <div id="profile-preview" class="h-32 w-32 rounded-full bg-gray-200 dark:bg-gray-600 border-4 border-white dark:border-gray-600 shadow-lg flex items-center justify-center">
                        <svg class="h-16 w-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                @endif
                <label for="profile_photo" class="absolute bottom-0 right-0 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full p-2 cursor-pointer shadow-lg transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </label>
            </div>
            
            <div class="text-center">
                <input type="file" id="profile_photo" name="profile_photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Click the camera icon to upload a new photo') }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                    {{ __('JPG, PNG or GIF (max. 2MB)') }}
                </p>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <!-- Personal Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="username" :value="__('Username')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                <x-text-input id="username" name="username" type="text" 
                             class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" 
                             :value="old('username', $user->username)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>

            <div>
                <x-input-label for="full_name" :value="__('Full Name')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                <x-text-input id="full_name" name="full_name" type="text" 
                             class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" 
                             :value="old('full_name', $user->full_name)" required autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
            </div>
        </div>

        <!-- Contact Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                <x-text-input id="email" name="email" type="email" 
                             class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" 
                             :value="old('email', $user->email)" required autocomplete="email" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('Phone Number')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                <x-text-input id="phone" name="phone" type="tel" 
                             class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" 
                             :value="old('phone', $user->phone)" autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
        </div>

        <!-- Description -->
        <div>
            <x-input-label for="description" :value="__('Description')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
            <textarea id="description" name="description" rows="4"
                     class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm resize-none"
                     placeholder="{{ __('Tell us about yourself...') }}">{{ old('description', $user->description) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <!-- Save Button -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center space-x-4">
                <x-primary-button class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Save Changes') }}
                </x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                       class="text-sm text-green-600 dark:text-green-400 flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Profile updated successfully!') }}
                    </p>
                @endif
            </div>
        </div>
    </form>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('profile-preview');
            const file = input.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        // Replace the placeholder div with an img element
                        const img = document.createElement('img');
                        img.id = 'profile-preview';
                        img.src = e.target.result;
                        img.alt = 'Profile Photo';
                        img.className = 'h-32 w-32 rounded-full object-cover border-4 border-white dark:border-gray-600 shadow-lg';
                        preview.parentNode.replaceChild(img, preview);
                    }
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</section>