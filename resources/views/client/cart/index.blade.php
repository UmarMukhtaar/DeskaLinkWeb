<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">Keranjang Belanja</h1>
        
        @if($cartItems->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Keranjang Anda kosong</h3>
                <p class="mt-1 text-sm text-gray-500">Tambahkan beberapa item untuk memulai</p>
                <div class="mt-6">
                    <a href="{{ route('client.market') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Mulai Belanja
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <ul class="divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                        <li class="p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-16 w-16">
                                    <img class="h-16 w-16 object-cover" src="{{ $item->thumbnail }}" alt="{{ $item->title }}" onerror="this.onerror=null;this.src='https://via.placeholder.com/100?text=Image+Not+Available'">
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-gray-900">
                                            {{ $item->title }}
                                        </h3>
                                        <p class="ml-4 text-sm font-medium text-gray-900">
                                            Rp{{ number_format($item->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between mt-2">
                                        <p class="text-sm text-gray-500">
                                            {{ $item->item_type == 'service' ? 'Jasa' : 'Desain' }} oleh {{ $item->partner->full_name }}
                                        </p>
                                        <form action="{{ route('client.cart.remove', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                
                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-between text-base font-medium text-gray-900">
                        <p>Total</p>
                        <p>Rp{{ number_format($totalPrice, 0, ',', '.') }}</p>
                    </div>
                    <div class="mt-6">
                        <form action="{{ route('client.checkout.process') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>