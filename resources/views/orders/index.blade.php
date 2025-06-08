<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">Pesanan</h1>
        
        <div x-data="{
            activeTab: '{{ request('tab', 'requested') }}',
            showDetailModal: false,
            selectedItem: null,
            showRejectModal: false,
            rejectionReason: '',
            role: '{{ $role }}'
        }" class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex">
                    <button 
                        @click="activeTab = 'requested'" 
                        :class="{ 'border-red-500 text-red-600': activeTab === 'requested', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'requested' }"
                        class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm"
                    >
                        {{ $role === 'client' ? 'Meminta Pesanan' : 'Permintaan Pesanan' }}
                    </button>
                    <button 
                        @click="activeTab = 'processing'" 
                        :class="{ 'border-red-500 text-red-600': activeTab === 'processing', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'processing' }"
                        class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm"
                    >
                        Pesanan Diproses
                    </button>
                    <button 
                        @click="activeTab = 'completed'" 
                        :class="{ 'border-red-500 text-red-600': activeTab === 'completed', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'completed' }"
                        class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm"
                    >
                        Pesanan Selesai
                    </button>
                    <button 
                        @click="activeTab = 'rejected'" 
                        :class="{ 'border-red-500 text-red-600': activeTab === 'rejected', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'rejected' }"
                        class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm"
                    >
                        Pesanan Ditolak
                    </button>
                </nav>
            </div>
            
            <div class="px-4 py-5 sm:p-6">
                <!-- Requested Items Tab -->
                <div x-show="activeTab === 'requested'">
                    @if($requestedItems->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">
                                {{ $role === 'client' ? 'Tidak ada pesanan yang diminta' : 'Tidak ada permintaan pesanan' }}
                            </h3>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($requestedItems as $item)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-medium">{{ $item->title }}</h3>
                                            <p class="text-gray-600">
                                                {{ $role === 'client' ? 'Partner: ' . $item->partner->full_name : 'Client: ' . $item->client->full_name }}
                                            </p>
                                            <p class="mt-1 text-gray-900">
                                                Rp{{ number_format($item->price, 0, ',', '.') }}
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                Dipesan pada: {{ $item->created_at->format('d M Y H:i') }}
                                            </p>
                                            @if($item->note)
                                                <p class="mt-1 text-sm text-gray-500">Catatan: {{ $item->note }}</p>
                                            @endif
                                        </div>
                                        <div class="flex space-x-2">
                                            @if($role === 'client')
                                                <button
                                                    @click="selectedItem = {{ $item->load(['partner', 'client'])->toJson() }}; showDetailModal = true"
                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                                >
                                                    Detail
                                                </button>

                                                <form action="{{ route('orders.cancel.item', $item) }}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                        Batalkan
                                                    </button>
                                                </form>
                                            @else
                                                <button
                                                    @click="selectedItem = {{ $item->load(['partner', 'client'])->toJson() }}; showDetailModal = true"
                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                                >
                                                    Detail
                                                </button>
                                                <form action="{{ route('orders.accept.item', $item) }}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                        Terima
                                                    </button>
                                                </form>
                                                <button 
                                                    @click="selectedItem = {{ json_encode($item->toArray()) }}; showRejectModal = true" 
                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                                                >
                                                    Tolak
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Processing Items Tab -->
                <div x-show="activeTab === 'processing'" x-cloak>
                    @if($processingItems->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">
                                Tidak ada pesanan yang diproses
                            </h3>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($processingItems as $item)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-medium">{{ $item->title }}</h3>
                                            <p class="text-gray-600">
                                                {{ $role === 'client' ? 'Partner: ' . $item->partner->full_name : 'Client: ' . $item->client->full_name }}
                                            </p>
                                            <p class="mt-1 text-gray-900">
                                                Rp{{ number_format($item->price, 0, ',', '.') }}
                                            </p>
                                            @if($item->note)
                                                <p class="mt-1 text-sm text-gray-500">Catatan: {{ $item->note }}</p>
                                            @endif
                                        </div>
                                        <div class="flex space-x-2">
                                            <button
                                                @click="selectedItem = {{ $item->load(['partner', 'client'])->toJson() }}; showDetailModal = true"
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                            >
                                                Detail
                                            </button>
                                            @if($role === 'partner')
                                                <a href="{{ route('orders.submit.show', $item) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                    Kirim Hasil
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Completed Items Tab -->
                <div x-show="activeTab === 'completed'" x-cloak>
                    @if($completedItems->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">
                                Tidak ada pesanan yang selesai
                            </h3>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($completedItems as $item)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-medium">{{ $item->title }}</h3>
                                            <p class="text-gray-600">
                                                {{ $role === 'client' ? 'Partner: ' . $item->partner->full_name : 'Client: ' . $item->client->full_name }}
                                            </p>
                                            <p class="mt-1 text-gray-900">
                                                Rp{{ number_format($item->price, 0, ',', '.') }}
                                            </p>
                                            @if($item->result_url)
                                                <div class="mt-2">
                                                    <p class="text-sm font-medium text-gray-900">Link Hasil:</p>
                                                    <a href="{{ $item->result_url }}" target="_blank" class="text-sm text-red-600 hover:underline">
                                                        {{ $item->result_url }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        <button
                                            @click="selectedItem = {{ $item->load(['partner', 'client'])->toJson() }}; showDetailModal = true"
                                            class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                        >
                                            Detail
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Rejected Items Tab -->
                <div x-show="activeTab === 'rejected'" x-cloak>
                    @if($rejectedItems->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">
                                Tidak ada pesanan yang ditolak
                            </h3>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($rejectedItems as $item)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-medium">{{ $item->title }}</h3>
                                            <p class="text-gray-600">
                                                {{ $role === 'client' ? 'Partner: ' . $item->partner->full_name : 'Client: ' . $item->client->full_name }}
                                            </p>
                                            <p class="mt-1 text-gray-900">
                                                Rp{{ number_format($item->price, 0, ',', '.') }}
                                            </p>
                                            <p class="mt-1 text-sm text-red-600">
                                                Alasan Penolakan: {{ $item->rejection_reason }}
                                            </p>
                                        </div>
                                        <button
                                            @click="selectedItem = {{ $item->load(['partner', 'client'])->toJson() }}; showDetailModal = true"
                                            class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                        >
                                            Detail
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Global Detail Modal -->
                <div x-show="showDetailModal" class="fixed inset-0 overflow-y-auto z-50" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Detail Pesanan
                                </h3>
                                <div class="mt-4 space-y-4" x-show="selectedItem">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Nama Layanan:</p>
                                        <p class="mt-1 text-sm text-gray-900" x-text="selectedItem.title"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">{{ $role === 'client' ? 'Partner' : 'Client' }}:</p>
                                        <p x-text="role === 'client' ? selectedItem.partner.full_name : selectedItem.client.full_name" class="mt-1 text-sm text-gray-900"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Harga:</p>
                                        <p class="mt-1 text-sm text-gray-900" x-text="'Rp' + new Intl.NumberFormat('id-ID').format(selectedItem.price)"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Tanggal Pesan:</p>
                                        <p class="mt-1 text-sm text-gray-900" x-text="new Date(selectedItem.created_at).toLocaleString('id-ID')"></p>
                                    </div>
                                    <div x-show="selectedItem.note">
                                        <p class="text-sm font-medium text-gray-500">Catatan:</p>
                                        <p class="mt-1 text-sm text-gray-900" x-text="selectedItem.note"></p>
                                    </div>
                                    <div x-show="selectedItem.rejection_reason">
                                        <p class="text-sm font-medium text-gray-500">Alasan Penolakan:</p>
                                        <p class="mt-1 text-sm text-red-600" x-text="selectedItem.rejection_reason"></p>
                                    </div>
                                    <div x-show="selectedItem.result_url">
                                        <p class="text-sm font-medium text-gray-500">Link Hasil:</p>
                                        <a :href="selectedItem.result_url" target="_blank" class="mt-1 text-sm text-red-600 hover:underline" x-text="selectedItem.result_url"></a>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Status:</p>
                                        <p class="mt-1 text-sm text-gray-900 capitalize" x-text="
                                            selectedItem.status === 'pending' ? 'Menunggu konfirmasi' : 
                                            selectedItem.status === 'processing' ? 'Sedang diproses' :
                                            selectedItem.status === 'delivered' ? 'Selesai' :
                                            selectedItem.status === 'canceled' ? 'Dibatalkan' : selectedItem.status
                                        "></p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-6">
                                <button @click="showDetailModal = false" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Reject Modal -->
                <div x-show="showRejectModal" class="fixed inset-0 overflow-y-auto z-50" style="display: none;">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <form x-bind:action="'{{ route('orders.reject.item', ['orderItem' => 'PLACEHOLDER']) }}'.replace('PLACEHOLDER', selectedItem.id)" method="POST">
                                @csrf
                                @method('POST')
                                <div>
                                    <h3 class="text-lg font-medium mb-4">Tolak Pesanan</h3>
                                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                                    <textarea id="rejection_reason" name="rejection_reason" x-model="rejectionReason" rows="3" 
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                                        required
                                        placeholder="Berikan alasan penolakan pesanan"></textarea>
                                </div>
                                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:col-start-2 sm:text-sm">
                                        Tolak Pesanan
                                    </button>
                                    <button @click="showRejectModal = false; rejectionReason = ''" type="button" 
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>