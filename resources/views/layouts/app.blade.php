<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'DeskaLink Web') }}</title>

    <link rel="icon" href="{{ asset('images/Logo Deskalink.png') }}" type="image/png">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Alpine.js for interactive components -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>

    <!-- Swiper.js CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- Swiper.js JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @auth
            @if(auth()->user()->role === 'admin')
                @include('layouts.navigation_admin')
            @elseif(auth()->user()->role === 'partner')
                @include('layouts.navigation_partner')
            @else
                @include('layouts.navigation_client')
            @endif
        @else
            @include('layouts.navigation_guest')
        @endauth

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto py-20 px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
      AOS.init({
        duration: 800,
        once: false
      });
    </script>

    <!-- SweetAlert2 Toast -->
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: '{{ session('error') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: '{{ session('warning') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    </script>

    <script>
        // Menunggu hingga seluruh halaman, termasuk gambar dan aset lainnya, selesai dimuat
        window.addEventListener('load', function() {
            const skeleton = document.getElementById('skeleton-loader');
            const realContent = document.getElementById('real-content');

            // Menambahkan sedikit jeda agar transisi tidak terlalu cepat dan terlihat
            setTimeout(() => {
                if (skeleton && realContent) {
                    // Sembunyikan skeleton
                    skeleton.classList.add('hidden');
                    
                    // Tampilkan konten asli
                    realContent.classList.remove('hidden');
                    AOS.refresh(); 
                }
            }, 500); // Jeda 0.5 detik
        });
    </script>
</body>
</html>
