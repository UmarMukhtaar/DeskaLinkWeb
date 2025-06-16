<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Partner Dashboard</h1>

        <div class="flex justify-between items-center mb-6">
            <button onclick="generatePDF()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Download PDF Report
            </button>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Approved Content -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Konten Disetujui</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $stats['approved_content'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Pending Content -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Menunggu Moderasi</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $stats['pending_content'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Total Pesanan</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $stats['order_count'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Total Pendapatan</h3>
                        <p class="text-lg font-semibold text-gray-900">Rp{{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('partner.services.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Jasa Baru
                </a>
                <a href="{{ route('partner.designs.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Desain Baru
                </a>
            </div>
        </div>

        <!-- Chart and Notifications Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Transaction Chart (2/3 width) -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden h-full">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Tren Transaksi 6 Bulan Terakhir</h3>
                    </div>
                    <div class="p-4">
                        <canvas id="transactionChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Notifications (1/3 width) -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Notifikasi Penting</h3>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            {{ $notifications->count() }} Baru
                        </span>
                    </div>
                </div>
                <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                    @forelse($notifications as $notification)
                    <div class="px-6 py-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 pt-1">
                                @if($notification['type'] === 'rejection')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                @endif
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $notification['title'] }}
                                </div>
                                <div class="text-sm text-gray-500 mt-1">
                                    {{ $notification['message'] }}
                                </div>
                                <div class="mt-2 text-xs text-gray-500">
                                    {{ $notification['time'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-4 text-center text-sm text-gray-500">
                        Tidak ada notifikasi baru
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Content -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Konten Terbaru Saya</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentContent as $content)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $content['type'] === 'service' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $content['type'] === 'service' ? 'Jasa' : 'Desain' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $content['title'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Rp{{ number_format($content['price'], 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $content['status'] === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($content['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($content['status']) }}
                                </span>
                                @if($content['status'] === 'banned' && $content['rejection_reason'])
                                <div class="text-xs text-gray-500 mt-1">{{ $content['rejection_reason'] }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $content['created_at']->format('d M Y') }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                Anda belum memiliki konten
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Orders and Messages -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- KOLOM KIRI (LEBIH LEBAR) UNTUK PESANAN -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden h-full flex flex-col">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Pesanan Terbaru</h3>
                    </div>
                    <div class="overflow-x-auto flex-grow">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap"><div class="flex items-center"><div class="flex-shrink-0 h-10 w-10"><img class="h-10 w-10 rounded-full" src="{{ $order->client->profile_photo_url }}" alt="{{ $order->client->full_name }}"></div></div></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-medium text-gray-900">{{ $order->title }}</div><div class="text-sm text-gray-500">{{ $order->item_type === 'service' ? 'Jasa' : 'Desain' }}</div></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-900">Rp{{ number_format($order->price, 0, ',', '.') }}</div></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</div></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">{{ ucfirst($order->status) }}</span></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">@if($order->status === 'pending')<form action="{{ route('orders.accept.item', $order) }}" method="POST" class="inline">@csrf<button type="submit" class="text-green-600 hover:text-green-900 mr-2">Terima</button></form><button type="button" onclick="openRejectModal({{ $order->id }}, '{{ $order->title }}')" class="text-yellow-600 hover:text-yellow-900">Tolak</button>@elseif($order->status === 'processing')<a href="{{ route('orders.submit.show', $order) }}" class="text-blue-600 hover:text-blue-900">Kirim Hasil</a>@endif</td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada pesanan terbaru</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN (LEBIH KECIL) UNTUK PESAN -->
            <div class="space-y-8">
                <!-- Widget Pesan Terbaru -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Pesan Terbaru</h3>
                        <a href="{{ route('chat.index') }}" class="text-sm font-medium text-red-600 hover:text-red-900">Lihat Semua</a>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($conversations as $conversation)
                            <a href="{{ route('chat.index', ['conversation' => $conversation->id]) }}" class="block p-4 hover:bg-gray-50 transition">
                                <div class="flex items-center space-x-3">
                                    @php $partner = $conversation->users->where('id', '!=', auth()->id())->first(); @endphp
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $partner->profile_photo_url ?? 'https://via.placeholder.com/40' }}" alt="{{ $partner->name ?? 'User' }}">
                                    <div class="flex-1 overflow-hidden">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $partner->name ?? 'User Dihapus' }}</p>
                                        <p class="text-sm text-gray-500 truncate">{{ $conversation->latestMessage->body ?? 'Klik untuk memulai percakapan...' }}</p>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ $conversation->updated_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada pesan terbaru.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Balance Card (Fixed at bottom right) -->
    <div class="fixed bottom-4 right-4 bg-white rounded-lg shadow-lg p-4 border border-gray-200">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-purple-100 text-purple-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-gray-500">Saldo Saat Ini</h3>
                <p class="text-lg font-semibold text-gray-900">Rp{{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 overflow-y-auto z-50 hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <form id="rejectForm" method="POST">
                    @csrf
                    <div>
                        <h3 class="text-lg font-medium mb-4">Tolak Pesanan</h3>
                        <div class="mb-2">
                            <p class="text-sm text-gray-600">Item: <span id="modalOrderTitle"></span></p>
                        </div>
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                        <textarea id="rejection_reason" name="rejection_reason" rows="3" 
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" 
                            required
                            placeholder="Berikan alasan penolakan pesanan"></textarea>
                    </div>
                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:col-start-2 sm:text-sm">
                            Tolak Pesanan
                        </button>
                        <button type="button" onclick="closeRejectModal()" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        // Transaction Chart
        document.addEventListener('DOMContentLoaded', function() {
            const transactionCtx = document.getElementById('transactionChart').getContext('2d');
            const transactionChart = new Chart(transactionCtx, {
                type: 'bar',
                data: {
                    labels: @json($transactionLabels ?? []),
                    datasets: [
                        {
                            label: 'Jumlah Pesanan',
                            data: @json($transactionData ?? []),
                            backgroundColor: 'rgba(79, 70, 229, 0.7)',
                            borderColor: 'rgba(79, 70, 229, 1)',
                            borderWidth: 1,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Pendapatan (Rp)',
                            data: @json($transactionRevenueData ?? []),
                            backgroundColor: 'rgba(16, 185, 129, 0.7)',
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 1,
                            type: 'line',
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Jumlah Pesanan'
                            },
                            beginAtZero: true
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Pendapatan (Rp)'
                            },
                            beginAtZero: true,
                            grid: {
                                drawOnChartArea: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });

        // PDF Generation
        function generatePDF() {
            Swal.fire({
                title: 'Generating PDF Report',
                html: 'Please wait while we prepare your report...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                    
                    // Use html2canvas and jsPDF to generate PDF
                    const { jsPDF } = window.jspdf;
                    
                    html2canvas(document.querySelector('.container')).then(canvas => {
                        const imgData = canvas.toDataURL('image/png');
                        const pdf = new jsPDF('p', 'mm', 'a4');
                        const imgProps = pdf.getImageProperties(imgData);
                        const pdfWidth = pdf.internal.pageSize.getWidth();
                        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                        
                        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                        pdf.save('partner-dashboard-' + new Date().toISOString().slice(0, 10) + '.pdf');
                        
                        Swal.close();
                    }).catch(err => {
                        Swal.fire('Error', 'Failed to generate PDF: ' + err.message, 'error');
                    });
                }
            });
        }
        
        function openRejectModal(orderItemId, orderTitle) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            const titleElement = document.getElementById('modalOrderTitle');
            
            // Gunakan route helper Laravel dengan replace placeholder
            form.action = '{{ route("orders.reject.item", ["orderItem" => "PLACEHOLDER"]) }}'.replace('PLACEHOLDER', orderItemId);
            
            // Set order title in modal
            titleElement.textContent = orderTitle;
            
            // Show modal
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            const textarea = document.getElementById('rejection_reason');
            
            // Reset form
            textarea.value = '';
            
            // Hide modal
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

    </script>
    @endpush
</x-app-layout>