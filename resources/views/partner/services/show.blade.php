<!-- resources/views/partner/services/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Jasa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <a href="{{ route('partner.services.index') }}" class="text-red-600 hover:text-red-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Kembali
                        </a>
                        <a href="{{ route('partner.services.edit', $service->id) }}" class="text-red-600 hover:text-red-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit
                        </a>
                    </div>

                    <div class="mb-8">
                        @if($service->thumbnail)
                            <img src="{{ $service->thumbnail }}" alt="{{ $service->title }}" class="w-full h-auto object-cover rounded-lg">
                        @else
                            <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $service->title }}</h1>
                            <div class="price-info mt-2">
                                <p class="text-2xl font-bold text-red-600">
                                    Rp {{ number_format($service->original_price, 0, ',', '.') }}
                                    <span class="text-gray-500 text-sm">(+5%: Rp {{ number_format($service->price - $service->original_price, 0, ',', '.') }})</span>
                                </p>
                                <p class="text-gray-500 text-sm">
                                    Total: Rp {{ number_format($service->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium 
                                @if($service->status == 'approved') bg-green-100 text-green-800
                                @elseif($service->status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                @if($service->status == 'approved')
                                    Disetujui
                                @elseif($service->status == 'pending')
                                    Menunggu Persetujuan
                                @else
                                    Ditolak
                                @endif
                            </span>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Deskripsi</h2>
                            <p class="mt-2 text-gray-600 whitespace-pre-line">{{ $service->description }}</p>
                            
                            @if(str_contains($service->description, '#'))
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach(explode(' ', $service->description) as $word)
                                        @if(str_starts_with($word, '#'))
                                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                                                {{ $word }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-500">
                                Dibuat pada: {{ $service->created_at->format('d M Y H:i') }}
                            </p>
                            @if($service->updated_at)
                                <p class="text-sm text-gray-500 mt-1">
                                    Terakhir diperbarui: {{ $service->updated_at->format('d M Y H:i') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>