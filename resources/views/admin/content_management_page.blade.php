<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Jasa & Desain') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Search and Filter Section -->
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="searchInput" class="block text-sm font-medium text-gray-700">Cari berdasarkan ID, judul, atau deskripsi</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="searchInput" name="search" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Cari berdasarkan ID, judul, atau deskripsi" value="{{ request('search') }}">
                            </div>
                        </div>
                        <div>
                            <label for="statusFilter" class="block text-sm font-medium text-gray-700">Filter Status</label>
                            <select id="statusFilter" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px" id="myTab" data-tabs-toggle="#myTabContent">
                                <li class="mr-2">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg active" 
                                        id="services-tab" data-tabs-target="#services" type="button">
                                        <i class="fas fa-briefcase mr-2"></i>Jasa
                                    </button>
                                </li>
                                <li class="mr-2">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" 
                                        id="designs-tab" data-tabs-target="#designs" type="button">
                                        <i class="fas fa-paint-brush mr-2"></i>Desain
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div id="myTabContent">
                        <div class="hidden p-4 rounded-lg bg-gray-50" id="services">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Partner</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($services as $service)
                                        <tr class="service-row" data-status="{{ $service->status }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10" src="{{ $service->thumbnail }}" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $service->title }}</div>
                                                        <div class="text-sm text-gray-500">ID: {{ $service->id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $service->partner->full_name }}</div>
                                                <div class="text-sm text-gray-500">{{ $service->partner->username }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($service->status == 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                @elseif($service->status == 'approved')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    {{-- Tombol detail --}}
                                                    <button onclick="showDetailModal('service', {{ json_encode($service) }})"
                                                        class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                    </button>

                                                    {{-- Tombol setujui --}}
                                                    @if($service->status == 'pending' || $service->status == 'banned')
                                                    <button onclick="approveContent('service', {{ $service->id }})"
                                                        class="text-green-600 hover:text-green-900" title="Setujui">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                    </button>
                                                    @endif

                                                    {{-- Tombol tolak --}}
                                                    @if($service->status == 'pending')
                                                    <button onclick="showRejectModal('service', {{ $service->id }})"
                                                        class="text-red-600 hover:text-red-900" title="Tolak">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                    @endif

                                                    {{-- Tombol hapus --}}
                                                    <button onclick="confirmDelete('service', {{ $service->id }})"
                                                        class="text-gray-600 hover:text-gray-900" title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a1 1 0 011 1v0a1 1 0 01-1 1H7a1 1 0 01-1-1v0a1 1 0 011-1h10z"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $services->links() }}
                            </div>
                        </div>

                        <div class="hidden p-4 rounded-lg bg-gray-50" id="designs">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Partner</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($designs as $design)
                                        <tr class="design-row" data-status="{{ $design->status }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10" src="{{ $design->thumbnail }}" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $design->title }}</div>
                                                        <div class="text-sm text-gray-500">ID: {{ $design->id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $design->partner->full_name }}</div>
                                                <div class="text-sm text-gray-500">{{ $design->partner->username }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($design->status == 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                @elseif($design->status == 'approved')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2 items-center">
                                                    {{-- Detail (Heroicon: Information Circle) --}}
                                                    <button onclick="showDetailModal('design', {{ json_encode($design) }})" 
                                                        class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                    </button>

                                                    {{-- Setujui (Heroicon: Check Circle) --}}
                                                    @if($design->status == 'pending' || $design->status == 'banned')
                                                        <button onclick="approveContent('design', {{ $design->id }})" 
                                                            class="text-green-600 hover:text-green-900" title="Setujui">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                        </button>
                                                    @endif

                                                    {{-- Tolak (Heroicon: X Circle) --}}
                                                    @if($design->status == 'pending')
                                                        <button onclick="showRejectModal('design', {{ $design->id }})" 
                                                            class="text-red-600 hover:text-red-900" title="Tolak">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        </button>
                                                    @endif

                                                    {{-- Hapus (Heroicon: Trash) --}}
                                                    <button onclick="confirmDelete('design', {{ $design->id }})" 
                                                        class="text-gray-600 hover:text-gray-900" title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a1 1 0 011 1v0a1 1 0 01-1 1H7a1 1 0 01-1-1v0a1 1 0 011-1h10z"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $designs->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle"></h3>
                    <div class="mt-2">
                        <div class="flex justify-center mb-4">
                            <img id="modalThumbnail" src="" alt="" class="h-40 object-cover">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">ID:</p>
                                <p class="text-sm font-medium text-gray-900" id="modalId"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Partner:</p>
                                <p class="text-sm font-medium text-gray-900" id="modalPartner"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status:</p>
                                <p class="text-sm font-medium text-gray-900" id="modalStatus"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Harga:</p>
                                <p class="text-sm font-medium text-gray-900" id="modalPrice"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Harga Asli:</p>
                                <p class="text-sm font-medium text-gray-900" id="modalOriginalPrice"></p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">Deskripsi:</p>
                            <p class="text-sm font-medium text-gray-900" id="modalDescription"></p>
                        </div>
                        <div id="previewsContainer" class="mt-4 hidden">
                            <p class="text-sm text-gray-500">Previews:</p>
                            <div class="grid grid-cols-3 gap-2 mt-2" id="previewsGrid"></div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeModal('detailModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Rejection Modal -->
    <div id="rejectModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Tolak Konten</h3>
                    <div class="mt-2">
                        <input type="hidden" id="rejectContentId">
                        <input type="hidden" id="rejectContentType">
                        <div class="mb-4">
                            <label for="rejectReason" class="block text-sm font-medium text-gray-700">Alasan penolakan</label>
                            <textarea id="rejectReason" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="rejectContent()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Tolak
                    </button>
                    <button type="button" onclick="closeModal('rejectModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Konfirmasi Hapus</h3>
                    <div class="mt-2">
                        <input type="hidden" id="deleteContentId">
                        <input type="hidden" id="deleteContentType">
                        <p class="text-sm text-gray-500">Yakin ingin menghapus konten ini?</p>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="deleteContent()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Hapus
                    </button>
                    <button type="button" onclick="closeModal('deleteModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('[data-tabs-toggle] [data-tabs-target]');

            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    const target = document.querySelector(this.getAttribute('data-tabs-target'));

                    // Sembunyikan semua konten tab
                    document.querySelectorAll('#myTabContent > div').forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Tampilkan konten tab yang dipilih
                    target.classList.remove('hidden');

                    // Update tampilan tab aktif
                    document.querySelectorAll('[data-tabs-toggle] button').forEach(btn => {
                        btn.classList.remove('border-red-500', 'text-red-600');
                        btn.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    });

                    this.classList.add('border-red-500', 'text-red-600');
                    this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                });
            });

            // === Default tab: set "Jasa" as active on load ===
            const defaultTab = document.querySelector('[data-tabs-target="#services"]');
            if (defaultTab) {
                defaultTab.click(); // Trigger click to activate
            }

            // === Search functionality ===
            document.getElementById('searchInput').addEventListener('input', function () {
                const query = this.value.toLowerCase();
                const statusFilter = document.getElementById('statusFilter').value;

                document.querySelectorAll('.service-row, .design-row').forEach(row => {
                    const title = row.querySelector('div.text-sm.font-medium').textContent.toLowerCase();
                    const id = row.querySelector('div.text-sm.text-gray-500').textContent.toLowerCase();
                    const status = row.getAttribute('data-status');

                    const matchesSearch = title.includes(query) || id.includes(query);
                    const matchesStatus = statusFilter === 'all' || status === statusFilter;

                    row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
                });
            });

            // === Status filter functionality ===
            document.getElementById('statusFilter').addEventListener('change', function () {
                const query = document.getElementById('searchInput').value.toLowerCase();
                const statusFilter = this.value;

                document.querySelectorAll('.service-row, .design-row').forEach(row => {
                    const title = row.querySelector('div.text-sm.font-medium').textContent.toLowerCase();
                    const id = row.querySelector('div.text-sm.text-gray-500').textContent.toLowerCase();
                    const status = row.getAttribute('data-status');

                    const matchesSearch = title.includes(query) || id.includes(query);
                    const matchesStatus = statusFilter === 'all' || status === statusFilter;

                    row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
                });
            });
        });

        function showDetailModal(type, data) {
            console.log('Data received:', data); // Debugging
            try {
                document.getElementById('modalTitle').textContent = data.title;
                document.getElementById('modalThumbnail').src = data.thumbnail;
                document.getElementById('modalId').textContent = data.id;
                document.getElementById('modalPartner').textContent = `${data.partner.full_name} (${data.partner.username})`;
                document.getElementById('modalStatus').textContent = 
                    data.status === 'pending' ? 'Pending' : 
                    data.status === 'approved' ? 'Disetujui' : 'Ditolak';
                document.getElementById('modalPrice').textContent = `Rp ${data.price.toLocaleString()}`;
                document.getElementById('modalOriginalPrice').textContent = `Rp ${data.original_price.toLocaleString()}`;
                document.getElementById('modalDescription').textContent = data.description;
                
                const previewsContainer = document.getElementById('previewsContainer');
                if (type === 'design' && data.previews) {
                    const previewsGrid = document.getElementById('previewsGrid');
                    previewsGrid.innerHTML = '';
                    data.previews.forEach(preview => {
                        const img = document.createElement('img');
                        img.src = preview;
                        img.className = 'h-24 w-full object-cover rounded';
                        previewsGrid.appendChild(img);
                    });
                    previewsContainer.classList.remove('hidden');
                } else {
                    previewsContainer.classList.add('hidden');
                }
                
                document.getElementById('detailModal').classList.remove('hidden');
            } catch (error) {
                console.error('Error in showDetailModal:', error);
                alert('Terjadi kesalahan saat menampilkan detail');
            }
        }

        function showRejectModal(type, id) {
            document.getElementById('rejectContentId').value = id;
            document.getElementById('rejectContentType').value = type;
            document.getElementById('rejectReason').value = '';
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function confirmDelete(type, id) {
            document.getElementById('deleteContentId').value = id;
            document.getElementById('deleteContentType').value = type;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function approveContent(type, id) {
            fetch(`/admin/${type}s/${id}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Gagal menyetujui konten');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyetujui konten');
            });
        }

        function rejectContent() {
            const id = document.getElementById('rejectContentId').value;
            const type = document.getElementById('rejectContentType').value;
            const reason = document.getElementById('rejectReason').value;
            
            if (!reason.trim()) {
                alert('Alasan penolakan harus diisi');
                return;
            }

            fetch(`/admin/${type}s/${id}/reject`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ reason: reason })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Gagal menolak konten');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menolak konten');
            });
        }

        function deleteContent() {
            const id = document.getElementById('deleteContentId').value;
            const type = document.getElementById('deleteContentType').value;
            
            fetch(`/admin/${type}s/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Gagal menghapus konten');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus konten');
            });
        }
    </script>
</x-app-layout>