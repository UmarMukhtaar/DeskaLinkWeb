<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">Catatan Pesanan</h1>
        
        <form action="{{ route('client.checkout.save-direct-notes') }}" method="POST">
            @csrf
            
            <input type="hidden" name="total" value="{{ $totalPrice }}">
            <input type="hidden" name="from_cart" value="1">
            
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Detail Pesanan
                    </h3>
                </div>
                
                <div class="border-t border-gray-200">
                    @foreach($items as $index => $item)
                        <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200">
                            <input type="hidden" name="items[{{ $index }}][item_id]" value="{{ $item['item_id'] }}">
                            <input type="hidden" name="items[{{ $index }}][item_type]" value="{{ $item['item_type'] }}">
                            <input type="hidden" name="items[{{ $index }}][title]" value="{{ $item['title'] }}">
                            <input type="hidden" name="items[{{ $index }}][price]" value="{{ $item['price'] }}">
                            <input type="hidden" name="items[{{ $index }}][partner_id]" value="{{ $item['partner_id'] }}">
                            
                            <div class="text-sm font-medium text-gray-900">
                                {{ $item['title'] }}
                            </div>
                            <div class="mt-1 text-sm text-gray-500 sm:mt-0">
                                {{ $item['item_type'] == 'service' ? 'Jasa' : 'Desain' }}
                            </div>
                            <div class="mt-1 text-sm text-gray-900 sm:mt-0">
                                Rp{{ number_format($item['price'], 0, ',', '.') }}
                            </div>
                            
                            <div class="mt-4 sm:col-span-3">
                                <label for="notes[{{ $index }}]" class="block text-sm font-medium text-gray-700">
                                    Catatan untuk partner (opsional)
                                </label>
                                <div class="mt-1">
                                    <textarea id="notes[{{ $index }}]" name="notes[{{ $index }}]" rows="3" class="shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="px-4 py-5 sm:px-6">
                        <div class="flex justify-between text-lg font-medium text-gray-900">
                            <p>Total Pesanan</p>
                            <p>Rp{{ number_format($totalPrice, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    
                    <div class="px-4 py-4 sm:px-6 bg-gray-50">
                        <button type="submit" class="w-full flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Konfirmasi Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>