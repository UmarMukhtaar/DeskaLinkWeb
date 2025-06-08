<div class="design-card border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 h-full flex flex-col">
    <a href="{{ route('partner.designs.show', $design->id) }}" class="block flex-grow">
        <div class="p-4 flex-grow">
            <div class="flex items-start h-full">
                <img src="{{ $design->thumbnail }}" alt="{{ $design->title }}" class="w-16 h-16 object-cover rounded mr-4">
                
                <div class="flex-1 flex flex-col h-full">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="design-title font-bold text-lg">{{ $design->title }}</h3>
                            <div class="price-info">
                                <p class="text-red-600 font-semibold">
                                    Rp {{ number_format($design->original_price, 0, ',', '.') }}
                                    <span class="text-gray-500 text-sm">(+5%: Rp {{ number_format($design->price - $design->original_price, 0, ',', '.') }})</span>
                                </p>
                                <p class="text-gray-500 text-xs">
                                    Total: Rp {{ number_format($design->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($design->status == 'approved') bg-green-100 text-green-800
                            @elseif($design->status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $design->status }}
                        </span>
                    </div>
                    
                    <p class="mt-2 text-gray-600 line-clamp-2 text-justify">{{ $design->description }}</p>
                    
                    @if(str_contains($design->description, '#'))
                        <div class="service-hashtags mt-2 flex flex-wrap gap-1">
                            @foreach(explode(' ', $design->description) as $word)
                                @if(str_starts_with($word, '#'))
                                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">
                                        {{ $word }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    
                    @if($design->previews)
                        <p class="mt-2 text-xs text-gray-500">
                            {{ count($design->previews) + 1 }} Gambar
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </a>
    
    <div class="bg-gray-50 px-4 py-3 flex justify-end space-x-2">
        <a href="{{ route('partner.designs.edit', $design->id) }}" class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
            </svg>
        </a>
        <form action="{{ route('partner.designs.destroy', $design->id) }}" method="POST" class="inline">
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
        if (confirm('Apakah Anda yakin ingin menghapus desain ini?')) {
            form.submit();
        }
    }
</script>