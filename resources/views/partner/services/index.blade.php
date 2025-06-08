<!-- resources/views/partner/services/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Jasa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <div class="relative w-full max-w-md">
                            <input 
                                type="text" 
                                id="search" 
                                placeholder="Cari berdasarkan judul atau hashtag..." 
                                class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                                onkeyup="filterServices()">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('partner.services.create') }}" class="ml-4 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah Jasa
                        </a>
                    </div>

                    @if($services->isEmpty())
                        <div class="text-center py-10">
                            <p class="text-gray-500">Belum ada jasa yang ditambahkan.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-6">
                            @foreach($services as $service)
                                @include('partner.services.partials.service-card', ['service' => $service])
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterServices() {
            const query = document.getElementById('search').value.toLowerCase();
            const services = document.querySelectorAll('.service-card');
            
            services.forEach(service => {
                const title = service.querySelector('.service-title').textContent.toLowerCase();
                const description = service.querySelector('.service-description')?.textContent.toLowerCase() || '';
                const hashtags = service.querySelector('.service-hashtags')?.textContent.toLowerCase() || '';
                
                if (query === '' || 
                    title.includes(query) || 
                    description.includes(query) || 
                    hashtags.includes('#' + query)) {
                    service.style.display = 'block';
                } else {
                    service.style.display = 'none';
                }
            });
        }
    </script>
</x-app-layout>