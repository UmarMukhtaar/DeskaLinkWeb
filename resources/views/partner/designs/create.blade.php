<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Desain Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('partner.designs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Thumbnail Upload -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="thumbnail">
                                Gambar Thumbnail
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-red-400 transition-colors duration-200" onclick="document.getElementById('thumbnail').click()">
                                <input type="file" id="thumbnail" name="thumbnail" class="hidden" accept="image/*" onchange="previewImage(this, 'thumbnail-preview')" required>
                                <div id="thumbnail-preview-placeholder" class="flex flex-col items-center justify-center py-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-500">Klik untuk mengunggah gambar thumbnail</p>
                                </div>
                                <img id="thumbnail-preview" class="hidden max-h-48 mx-auto rounded" src="#" alt="Preview" />
                            </div>
                            @error('thumbnail')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preview Images Upload -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Gambar Preview
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-red-400 transition-colors duration-200" onclick="document.getElementById('previews').click()">
                                <input type="file" id="previews" name="previews[]" class="hidden" accept="image/*" multiple onchange="previewMultipleImages(this, 'previews-container')">
                                <div id="previews-placeholder" class="flex flex-col items-center justify-center py-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-500">Klik untuk mengunggah gambar preview (bisa multiple)</p>
                                </div>
                                <div id="previews-container" class="hidden flex flex-wrap gap-2 mt-4"></div>
                            </div>
                            @error('previews')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                                Judul Desain
                            </label>
                            <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('title') border-red-500 @enderror" 
                                id="title" name="title" type="text" placeholder="Judul desain" value="{{ old('title') }}" required>
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="price">
                                Harga
                            </label>
                            <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('price') border-red-500 @enderror" 
                                id="price" name="price" type="number" placeholder="Harga desain" 
                                value="{{ old('price', isset($design) ? $design->original_price : '') }}" 
                                min="500" required>
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">
                                Minimal harga: Rp 500. Harga akan ditambah 5% (Rp <span id="admin-fee">0</span>) untuk pendapatan admin.
                                Total yang akan disimpan: Rp <span id="total-price">0</span>
                            </p>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                                Deskripsi
                            </label>
                            <textarea class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('description') border-red-500 @enderror" 
                                id="description" name="description" rows="4" placeholder="Deskripsi desain" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('partner.designs.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                                Batal
                            </a>
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Simpan Desain
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(previewId + '-placeholder');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewMultipleImages(input, containerId) {  // Diperbaiki dari previeMultipleImages
            const container = document.getElementById(containerId);
            const placeholder = document.getElementById('previews-placeholder');
            
            if (input.files && input.files.length > 0) {
                container.innerHTML = '';
                container.classList.remove('hidden');
                placeholder.classList.add('hidden');
                
                for (let i = 0; i < input.files.length; i++) {
                    const reader = new FileReader();
                    const img = document.createElement('img');
                    img.className = 'h-24 w-24 object-cover rounded';
                    
                    reader.onload = function(e) {
                        img.src = e.target.result;
                        container.appendChild(img);
                    }
                    
                    reader.readAsDataURL(input.files[i]);
                }
            }
        }

        document.getElementById('price').addEventListener('input', function() {
            const price = parseFloat(this.value) || 0;
            const adminFee = price * 0.05;
            const totalPrice = price + adminFee;
            
            document.getElementById('admin-fee').textContent = adminFee.toLocaleString('id-ID');
            document.getElementById('total-price').textContent = totalPrice.toLocaleString('id-ID');
        });

        // Initialize on page load
        document.getElementById('price').dispatchEvent(new Event('input'));
    </script>
</x-app-layout>