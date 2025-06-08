<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="text-center">
            <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <h1 class="mt-2 text-2xl font-bold text-gray-900">Pesanan Berhasil!</h1>
            <p class="mt-1 text-gray-600">Pesanan Anda telah berhasil diproses.</p>
            
            <div class="mt-6">
                <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Lihat Pesanan
                </a>
            </div>
        </div>
    </div>
</x-app-layout>