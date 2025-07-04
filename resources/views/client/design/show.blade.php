<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Main Card Section -->
        <div class="bg-white shadow-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Image Gallery (Left Side - Half Width) -->
                <div class="w-full md:w-1/2">
                    <div class="h-64 md:h-80 bg-gray-200 overflow-hidden">
                        @if($design->previews && count($design->previews) > 0)
                            <div class="swiper-container h-full relative">
                                <div class="swiper-wrapper">
                                    <!-- Main thumbnail -->
                                    <div class="swiper-slide">
                                        <img src="{{ $design->thumbnail }}" alt="{{ $design->title }}" class="w-full h-full object-cover">
                                    </div>
                                    <!-- Additional previews -->
                                    @foreach($design->previews as $preview)
                                        <div class="swiper-slide">
                                            <img src="{{ $preview }}" alt="Preview {{ $loop->index }}" class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Navigation arrows -->
                                <div class="swiper-button-next" style="color: #ef4444; right: 10px;"></div>
                                <div class="swiper-button-prev" style="color: #ef4444; left: 10px;"></div>
                                <!-- Pagination dots -->
                                <div class="swiper-pagination"></div>
                            </div>
                        @else
                            <img src="{{ $design->thumbnail }}" alt="{{ $design->title }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                </div>

                <!-- Right Content Section (Half Width) -->
                <div class="w-full md:w-1/2 flex flex-col justify-between">
                    <!-- Title and Price -->
                    <div class="mb-4">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ $design->title }}</h1>
                        <p class="text-xl md:text-2xl font-bold text-red-500">
                            Rp{{ number_format($design->price, 0, ',', '.') }}
                        </p>
                    </div>

                    <!-- Partner Info -->
                    <div class="border-t border-b border-gray-200 py-4 mb-4">
                        <h2 class="text-lg font-bold text-gray-900 mb-3">Ditawarkan oleh</h2>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-4">
                                <img class="h-12 w-12 rounded-full object-cover" 
                                     src="{{ $partner->profile_photo_url }}" 
                                     alt="{{ $partner->full_name }}"
                                     onerror="this.onerror=null;this.src='https://i.postimg.cc/qqChrG8y/profile.png';">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $partner->full_name }}</p>
                                <p class="text-sm text-gray-500">{{ $serviceCount }} Jasa • {{ $designCount }} Desain</p>
                            </div>
                            <div class="ml-4">
                                <a href="{{ route('client.partner.profile', $partner->id) }}" class="text-sm font-medium text-red-500 hover:text-red-700">
                                    Kunjungi
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons (aligned to bottom) -->
                    <div class="mt-auto">
                        <div class="flex flex-col sm:flex-row gap-4">
                            @auth
                                @if(auth()->user()->id !== $partner->id)
                                    <form action="{{ route('chat.start', $partner->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full flex items-center justify-center py-3 px-4 bg-blue-500 text-white font-medium hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                                            </svg>
                                            Hubungi Penjual
                                        </button>
                                    </form>
                                @endif
                            @endauth
                            <form action="{{ route('client.cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $design->id }}">
                                <input type="hidden" name="item_type" value="design">
                                @auth
                                <button type="submit" 
                                        class="w-full py-3 px-4 bg-white text-red-500 font-medium border border-red-500 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-md">
                                    Tambahkan ke Keranjang
                                </button>
                                @else
                                <a href="{{ route('login') }}" 
                                class="block w-full py-6 px-4 bg-white text-red-500 font-medium border border-red-500 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 text-center">
                                    Tambahkan ke Keranjang
                                </a>
                                @endauth
                            </form>
                            <form action="{{ route('client.checkout.direct') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $design->id }}">
                                <input type="hidden" name="item_type" value="design">
                                @auth
                                <button type="submit" 
                                        class="w-full py-6 px-4 bg-red-500 text-white font-medium hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-md">
                                    Beli Sekarang
                                </button>
                                @else
                                <a href="{{ route('login') }}" 
                                class="block w-full py-3 px-4 bg-red-500 text-white font-medium hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 text-center">
                                    Beli Sekarang
                                </a>
                                @endauth
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Card (Below Main Card) -->
        <div class="bg-white shadow-lg p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-3">Deskripsi</h2>
            <p class="text-gray-700 whitespace-pre-line">{{ $design->description }}</p>
        </div>
    </div>

    @if($design->previews && count($design->previews) > 0)
        <!-- Initialize Swiper -->
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <style>
            .swiper-pagination {
                bottom: 10px !important;
                left: 50% !important;
                transform: translateX(-50%) !important;
                width: auto !important;
                text-align: center !important;
            }
            .swiper-pagination-bullet {
                background: rgba(255, 255, 255, 0.8) !important;
                border: 2px solid rgba(0, 0, 0, 0.2) !important;
                opacity: 1 !important;
            }
            .swiper-pagination-bullet-active {
                background: #ef4444 !important;
                border-color: #ef4444 !important;
            }
            .swiper-container {
                position: relative;
            }
        </style>
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new Swiper('.swiper-container', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });

                // Add click event for login buttons
                document.querySelectorAll('a[href="{{ route('login') }}"]').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Anda perlu login terlebih dahulu',
                            text: 'Silakan login untuk menambahkan item ke keranjang atau melakukan pembelian',
                            confirmButtonText: 'Login',
                            showCancelButton: true,
                            cancelButtonText: 'Batal',
                            confirmButtonColor: '#ef4444',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('login') }}";
                            }
                        });
                    });
                });
            });
        </script>
    @else
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add click event for login buttons when no previews
                document.querySelectorAll('a[href="{{ route('login') }}"]').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Anda perlu login terlebih dahulu',
                            text: 'Silakan login untuk menambahkan item ke keranjang atau melakukan pembelian',
                            confirmButtonText: 'Login',
                            showCancelButton: true,
                            cancelButtonText: 'Batal',
                            confirmButtonColor: '#ef4444',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('login') }}";
                            }
                        });
                    });
                });
            });
        </script>
    @endif
</x-app-layout>