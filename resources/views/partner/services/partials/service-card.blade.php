<!-- resources/views/partner/services/partials/service-card.blade.php -->
<div class="service-card border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 h-full flex flex-col">
    <a href="{{ route('partner.services.show', $service->id) }}" class="block flex-grow">
        <div class="p-4 flex-grow">
            <div class="flex items-start h-full">
                @if($service->thumbnail)
                    <img src="{{ $service->thumbnail }}" alt="{{ $service->title }}" class="w-16 h-16 object-cover rounded mr-4">
                @else
                    <div class="w-16 h-16 bg-gray-200 rounded mr-4 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
                
                <div class="flex-1 flex flex-col h-full">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="service-title font-bold text-lg">{{ $service->title }}</h3>
                            <div class="price-info">
                                <p class="text-red-600 font-semibold">
                                    Rp {{ number_format($service->original_price, 0, ',', '.') }}
                                    <span class="text-gray-500 text-sm">(+5%: Rp {{ number_format($service->price - $service->original_price, 0, ',', '.') }})</span>
                                </p>
                                <p class="text-gray-500 text-xs">
                                    Total: Rp {{ number_format($service->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($service->status == 'approved') bg-green-100 text-green-800
                            @elseif($service->status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $service->status }}
                        </span>
                    </div>
                    
                    @if($service->description)
                        <p class="service-description mt-2 text-gray-600 line-clamp-2">{{ $service->description }}</p>
                        
                        @if(str_contains($service->description, '#'))
                            <div class="service-hashtags mt-2 flex flex-wrap gap-1">
                                @foreach(explode(' ', $service->description) as $word)
                                    @if(str_starts_with($word, '#'))
                                        <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">
                                            {{ $word }}
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </a>
    
    <div class="bg-gray-50 px-4 py-3 flex justify-end space-x-2">
        <a href="{{ route('partner.services.edit', $service->id) }}" class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
            </svg>
        </a>
        <form action="{{ route('partner.services.destroy', $service->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="button" onclick="confirmDelete(this.form)" class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
        </form>
    </div>
</div>

<script>
    function confirmDelete(form) {
        if (confirm('Apakah Anda yakin ingin menghapus jasa ini?')) {
            form.submit();
        }
    }
</script>