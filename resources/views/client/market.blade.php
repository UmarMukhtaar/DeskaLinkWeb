<x-app-layout>
    @auth
        @if(empty(auth()->user()->role))
            <script>
                window.location.href = "{{ route('role.selection') }}";
            </script>
        @endif
    @endauth
    
    <div class="container mx-auto px-4 py-8">
        <!-- Search Bar -->
        <div class="mb-6">
            <div class="relative">
                <input 
                    type="text" 
                    id="searchInput" 
                    placeholder="Cari {{ $activeTab === 'services' ? 'jasa...' : 'desain...' }}" 
                    class="w-full px-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                >
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Tab Bar -->
        <div class="mb-6 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px">
                <li class="mr-2">
                    <a 
                        href="{{ route('client.market', ['tab' => 'services']) }}" 
                        class="inline-flex items-center py-4 px-4 border-b-2 font-medium text-sm {{ $activeTab === 'services' ? 'border-red-500 text-red-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Jasa
                    </a>
                </li>
                <li class="mr-2">
                    <a 
                        href="{{ route('client.market', ['tab' => 'designs']) }}" 
                        class="inline-flex items-center py-4 px-4 border-b-2 font-medium text-sm {{ $activeTab === 'designs' ? 'border-red-500 text-red-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                        aria-current="page"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                        Desain
                    </a>
                </li>
                @auth
                    <li class="mr-2">
                        <a href="{{ route('chat.index') }}" class="inline-flex items-center py-4 px-4 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                            </svg>
                            Pesan Saya
                        </a>
                    </li>
                @endauth
            </ul>
        </div>

        <!-- Content -->
        <div id="searchResults">
            @if($activeTab === 'services')
                @if($services->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada jasa tersedia</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada jasa yang tersedia untuk ditampilkan.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($services as $service)
                            <div class="search-item bg-white shadow overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <a href="{{ route('client.service.detail', $service->id) }}" class="block p-4">
                                    <div class="flex items-start">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-bold text-gray-900">{{ $service->title }}</h3>
                                            <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $service->description }}</p>
                                            <p class="mt-2 text-md font-medium text-gray-900">
                                                Rp{{ number_format($service->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                @if($designs->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada desain tersedia</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada desain yang tersedia untuk ditampilkan.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($designs as $design)
                            <div class="search-item bg-white shadow overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <a href="{{ route('client.design.detail', $design->id) }}" class="block">
                                    <div class="relative h-48 bg-gray-200">
                                        <img 
                                            src="{{ $design->thumbnail }}" 
                                            alt="{{ $design->title }}" 
                                            class="w-full h-full object-cover"
                                            onerror="this.onerror=null;this.src='https://via.placeholder.com/300x180?text=Image+Not+Available';"
                                        >
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-lg font-bold text-gray-900 truncate">{{ $design->title }}</h3>
                                        <p class="mt-2 text-md font-medium text-gray-900">
                                            Rp{{ number_format($design->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </a>
                                    
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const items = document.querySelectorAll('.search-item');
                
                items.forEach(item => {
                    const title = item.querySelector('h3').textContent.toLowerCase();
                    const description = item.querySelector('p.text-gray-600')?.textContent.toLowerCase() || '';
                    
                    if (title.includes(searchTerm) || description.includes(searchTerm)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
</x-app-layout>