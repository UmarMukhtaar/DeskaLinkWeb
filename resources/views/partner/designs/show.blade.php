<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Desain') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <a href="{{ route('partner.designs.index') }}" class="text-red-600 hover:text-red-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Kembali
                        </a>
                        <a href="{{ route('partner.designs.edit', $design->id) }}" class="text-red-600 hover:text-red-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit
                        </a>
                    </div>

                    <!-- Image Gallery -->
                    <div class="mb-8">
                        <div class="relative h-auto w-full rounded-lg overflow-hidden mb-4">
                            <img src="{{ $design->thumbnail }}" alt="{{ $design->title }}" class="w-full h-full object-cover">
                        </div>
                        
                        @if($design->previews && count($design->previews) > 0)
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach($design->previews as $preview)
                                    <div class="relative h-32 rounded-lg overflow-hidden">
                                        <img src="{{ $preview }}" alt="Preview {{ $loop->iteration }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $design->title }}</h1>
                            <div class="price-info mt-2">
                                <p class="text-2xl font-bold text-red-600">
                                    Rp {{ number_format($design->original_price, 0, ',', '.') }}
                                    <span class="text-gray-500 text-sm">(+5%: Rp {{ number_format($design->price - $design->original_price, 0, ',', '.') }})</span>
                                </p>
                                <p class="text-gray-500 text-sm">
                                    Total: Rp {{ number_format($design->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium 
                                @if($design->status == 'approved') bg-green-100 text-green-800
                                @elseif($design->status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                @if($design->status == 'approved')
                                    Disetujui
                                @elseif($design->status == 'pending')
                                    Menunggu Persetujuan
                                @else
                                    Ditolak
                                @endif
                            </span>
                        </div>

                        @if($design->status === 'banned' && $design->rejection_reason)
                            <div class="mt-2 bg-red-50 border border-red-200 text-red-800 px-4 py-2 rounded">
                                <strong>Alasan Penolakan:</strong>
                                <p class="mt-1 whitespace-pre-line">{{ $design->rejection_reason }}</p>
                            </div>
                        @endif

                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Deskripsi</h2>
                            <p class="mt-2 text-gray-600 whitespace-pre-line">{{ $design->description }}</p>
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-500">
                                Dibuat pada: {{ $design->created_at->format('d M Y H:i') }}
                            </p>
                            @if($design->updated_at)
                                <p class="text-sm text-gray-500 mt-1">
                                    Terakhir diperbarui: {{ $design->updated_at->format('d M Y H:i') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>