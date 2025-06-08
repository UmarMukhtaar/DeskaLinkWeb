<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">Kirim Hasil Pekerjaan</h1>
        
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $orderItem->title }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Rp{{ number_format($orderItem->price, 0, ',', '.') }}
                </p>
            </div>
            
            <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                <form action="{{ route('orders.submit', $orderItem) }}" method="POST">
                    @csrf
                    
                    <div class="space-y-4">
                        <div>
                            <label for="result_url" class="block text-sm font-medium text-gray-700">
                                Link Hasil Pekerjaan
                            </label>
                            <div class="mt-1">
                                <input type="url" name="result_url" id="result_url" required class="shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Masukkan URL hasil pekerjaan yang akan dikirim ke client.
                            </p>
                        </div>
                        
                        <div class="pt-5">
                            <div class="flex justify-end">
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Kirim Hasil
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>