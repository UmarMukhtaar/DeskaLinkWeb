<x-app-layout>
    <div class="bg-white" x-data="partnerProfile">
        <!-- Profile Header -->
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row items-start md:items-center">
                <!-- Back Button for Mobile -->
                <div class="md:hidden mb-4">
                    <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                </div>

                <!-- Profile Picture -->
                <div class="flex-shrink-0 mr-6">
                    <img class="h-20 w-20 md:h-32 md:w-32 rounded-full object-cover" 
                         src="{{ $partner->profile_photo_url }}" 
                         alt="{{ $partner->full_name }}"
                         onerror="this.onerror=null;this.src='https://i.postimg.cc/qqChrG8y/profile.png';">
                </div>

                <!-- Profile Info -->
                <div class="flex-1">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $partner->full_name }}</h1>
                    <p class="text-gray-600">{{ '@' . $partner->username }}</p>

                    <!-- Stats -->
                    <div class="flex items-center mt-4 space-x-6">
                        <div class="text-center">
                            <span class="block text-lg font-bold">{{ $serviceCount }}</span>
                            <span class="block text-sm text-gray-500">Jasa</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-lg font-bold">{{ $designCount }}</span>
                            <span class="block text-sm text-gray-500">Desain</span>
                        </div>
                        @if($partner->created_at)
                        <div class="hidden md:block text-sm text-gray-500 ml-auto">
                            Bergabung {{ $partner->created_at->format('M Y') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($partner->description)
            <div class="mt-6">
                <p class="text-gray-700">{{ $partner->description }}</p>
            </div>
            @endif

            <!-- Contact Info -->
            <div class="mt-6 space-y-2">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-gray-700">{{ $partner->email }}</span>
                </div>
                @if($partner->phone)
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <span class="text-gray-700">{{ $partner->phone }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 mt-6">
            <nav class="container mx-auto px-4 -mb-px flex">
                <button @click="activeTab = 'services'" 
                        :class="{'border-red-500 text-red-500': activeTab === 'services', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'services'}" 
                        class="py-4 px-6 text-center border-b-2 font-medium text-sm flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Jasa
                </button>
                <button @click="activeTab = 'designs'" 
                        :class="{'border-red-500 text-red-500': activeTab === 'designs', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'designs'}" 
                        class="py-4 px-6 text-center border-b-2 font-medium text-sm flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                    </svg>
                    Desain
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="container mx-auto px-4 py-6">
            <!-- Services Tab -->
            <div x-show="activeTab === 'services'" x-transition>
                @if($services->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada jasa yang tersedia</h3>
                        <p class="mt-1 text-sm text-gray-500">Partner ini belum memiliki jasa yang ditawarkan.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($services as $service)
                            <a href="{{ route('client.service.detail', $service->id) }}" class="block bg-white shadow overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <div class="p-4">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $service->title }}</h3>
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $service->description }}</p>
                                    <p class="mt-2 text-md font-medium text-gray-900">
                                        Rp{{ number_format($service->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Designs Tab -->
            <div x-show="activeTab === 'designs'" x-transition style="display: none;">
                @if($designs->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada desain yang tersedia</h3>
                        <p class="mt-1 text-sm text-gray-500">Partner ini belum memiliki desain yang ditawarkan.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($designs as $design)
                            <a href="{{ route('client.design.detail', $design->id) }}" class="block bg-white shadow overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <div class="relative h-48 bg-gray-200">
                                    <img src="{{ $design->thumbnail }}" alt="{{ $design->title }}" 
                                        class="w-full h-full object-cover"
                                        onerror="this.onerror=null;this.src='https://via.placeholder.com/300x180?text=Image+Not+Available';">
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-bold text-gray-900 truncate">{{ $design->title }}</h3>
                                    <p class="mt-2 text-md font-medium text-gray-900">
                                        Rp{{ number_format($design->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Alpine.js Script -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('partnerProfile', () => ({
                activeTab: 'services',
                
                init() {
                    // Check URL hash for initial tab
                    if (window.location.hash === '#designs') {
                        this.activeTab = 'designs';
                    }
                    
                    // Update hash when tab changes
                    this.$watch('activeTab', (value) => {
                        window.location.hash = value;
                    });
                }
            }));
        });
    </script>
</x-app-layout>