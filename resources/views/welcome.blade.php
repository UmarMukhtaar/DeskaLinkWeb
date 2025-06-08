<x-app-layout>
    <div class="text-gray-800 min-h-screen">
        <!-- Hero Section -->
        <div class="relative">
            <div class="hero-content">
                <div class="container mx-auto px-8 py-16">
                    <div class="flex flex-col md:flex-row items-center md:space-x-10">
                        <!-- Ilustrasi -->
                        <div class="md:w-1/2 flex justify-center mb-10 md:mb-0">
                            <img src="{{ asset('images/hero-image.webp') }}" alt="Ilustrasi Marketplace Digital" 
                                class="rounded-lg shadow-lg max-w-full">
                        </div>
                        
                        <!-- Teks -->
                        <div class="md:w-1/2 text-left">
                            <h2 class="text-5xl font-semibold leading-tight text-gray-900">Navigating the Digital Marketplace</h2>
                            <p class="mt-6 text-lg text-gray-700">DeskaLink adalah platform yang membantu desainer digital menjual karya mereka dan memudahkan pengguna dalam memesan jasa desain secara online.</p>
                            
                            <!-- CTA -->
                            <div class="mt-8 flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
                                <a href="{{ route('client.market') }}" class="px-6 py-3 bg-red-500 text-white rounded-md hover:bg-red-600 transition text-center">
                                    Jelajahi Marketplace
                                </a>
                                <a href="{{ route('register') }}" class="px-6 py-3 border border-red-500 text-red-500 rounded-md hover:bg-red-500 hover:text-white transition text-center">
                                    Daftar Sekarang
                                </a>
                            </div>
                            
                            <!-- Testimoni Singkat -->
                            <div class="mt-8 bg-white bg-opacity-80 backdrop-blur-sm p-3 rounded-lg shadow-md border border-red-100">
                                <p class="italic text-gray-700">"Saya berhasil menjual desain pertama saya dalam waktu seminggu!"</p>
                                <p class="text-red-500 mt-2 font-semibold">- Adi, Desainer Digital</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Team Section -->
        <section id="team" class="container mx-auto mt-16 p-8 text-center">
            <h2 class="text-3xl font-semibold text-red-500">Profil Tim Developer</h2>
            <p class="mt-4 text-lg text-gray-600">Kami adalah tim ahli di bidang Web Development, UI/UX, dan Database Management.</p>
        
            <div class="mt-8 space-y-16">
                <!-- Anggota 1 (Foto Kiri) -->
                <div class="flex flex-col md:flex-row items-center text-center md:text-left">
                    <img src="{{ asset('images/team1.webp') }}" alt="James Petra"
                        class="w-52 h-52 rounded-full border-4 border-red-500">
                    <div class="md:ml-10 flex flex-col justify-center">
                        <h3 class="text-3xl font-semibold text-gray-900">James Petra Benaya P. N</h3>
                        <p class="text-red-500 text-xl font-medium">Full-Stack Developer</p>
                        <p class="text-gray-600 mt-3">Ahli dalam mengembangkan aplikasi web dari frontend hingga backend menggunakan teknologi modern.</p>
                    </div>
                </div>
        
                <!-- Anggota 2 (Foto Kanan) -->
                <div class="flex flex-col md:flex-row-reverse items-center text-center md:text-right">
                    <img src="{{ asset('images/team2.webp') }}" alt="Umar Mukhtar"
                        class="w-52 h-52 rounded-full border-4 border-red-500">
                    <div class="md:mr-10 flex flex-col justify-center">
                        <h3 class="text-3xl font-semibold text-gray-900">Umar Mukhtar</h3>
                        <p class="text-red-500 text-xl font-medium">Backend & Database Engineer</p>
                        <p class="text-gray-600 mt-3">Mengembangkan dan mengelola sistem database serta API untuk menjaga performa aplikasi tetap optimal.</p>
                    </div>
                </div>
        
                <!-- Anggota 3 (Foto Kiri) -->
                <div class="flex flex-col md:flex-row items-center text-center md:text-left">
                    <img src="{{ asset('images/team3.webp') }}" alt="Mokhammad Afrylianto"
                        class="w-52 h-52 rounded-full border-4 border-red-500">
                    <div class="md:ml-10 flex flex-col justify-center">
                        <h3 class="text-3xl font-semibold text-gray-900">Mokhammad Afrylianto Aryo Abdi</h3>
                        <p class="text-red-500 text-xl font-medium">UI/UX Designer</p>
                        <p class="text-gray-600 mt-3">Membuat desain antarmuka yang menarik dan user-friendly untuk pengalaman pengguna yang lebih baik.</p>
                    </div>
                </div>
        
                <!-- Anggota 4 (Foto Kanan) -->
                <div class="flex flex-col md:flex-row-reverse items-center text-center md:text-right">
                    <img src="{{ asset('images/team4.webp') }}" alt="Dimas Rhoyhan"
                        class="w-52 h-52 rounded-full border-4 border-red-500">
                    <div class="md:mr-10 flex flex-col justify-center">
                        <h3 class="text-3xl font-semibold text-gray-900">Dimas Rhoyhan Budi S.</h3>
                        <p class="text-red-500 text-xl font-medium">Frontend Developer</p>
                        <p class="text-gray-600 mt-3">Mengembangkan antarmuka aplikasi dengan teknologi modern agar lebih responsif dan interaktif.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Features Section -->
        <section id="features" class="container mx-auto mt-16 p-8 text-center">
            <h2 class="text-3xl font-semibold text-red-500">Keunggulan DeskaLink</h2>
            <p class="mt-4 text-lg text-gray-700 max-w-2xl mx-auto">
                DeskaLink memberikan pengalaman terbaik dalam memesan jasa desain dan membeli karya digital dengan aman dan nyaman.
            </p>
        
            <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Fitur 1: Jual Beli Jasa -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition border border-red-100">
                    <div class="flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500 w-12 h-12">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mt-4 text-gray-900">Jual Beli Jasa</h3>
                    <p class="text-gray-600 mt-2">Platform terbaik untuk menawarkan atau memesan jasa desain profesional sesuai kebutuhan Anda.</p>
                </div>
        
                <!-- Fitur 2: Jual Beli Desain Digital -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition border border-red-100">
                    <div class="flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500 w-12 h-12">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27,6.96 12,12.01 20.73,6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mt-4 text-gray-900">Jual Beli Desain Digital</h3>
                    <p class="text-gray-600 mt-2">Marketplace khusus untuk menjual dan membeli produk desain digital siap pakai berkualitas tinggi.</p>
                </div>
        
                <!-- Fitur 3: Dashboard Pengelolaan Pesanan -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition border border-red-100">
                    <div class="flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500 w-12 h-12">
                            <rect width="7" height="7" x="3" y="3" rx="1"></rect>
                            <rect width="7" height="7" x="14" y="3" rx="1"></rect>
                            <rect width="7" height="7" x="14" y="14" rx="1"></rect>
                            <rect width="7" height="7" x="3" y="14" rx="1"></rect>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mt-4 text-gray-900">Dashboard Pengelolaan</h3>
                    <p class="text-gray-600 mt-2">Kelola semua pesanan dan proyek Anda dengan mudah melalui dashboard yang user-friendly.</p>
                </div>
        
                <!-- Fitur 4: Program Partnership -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition border border-red-100">
                    <div class="flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500 w-12 h-12">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mt-4 text-gray-900">Bergabung Sebagai Partner</h3>
                    <p class="text-gray-600 mt-2">Daftarkan diri sebagai kreator dan mulai dapatkan penghasilan dari karya desain Anda.</p>
                </div>
            </div>
        </section>
        
        <!-- Problem Section -->
        <section id="problem" class="container mx-auto mt-10 p-6 text-center">
            <h2 class="text-3xl font-semibold text-red-500">Masalah yang Ingin Diselesaikan</h2>
            <p class="mt-4 text-lg max-w-2xl mx-auto text-gray-700">Minimnya platform yang secara khusus menggabungkan penjualan desain digital siap pakai dan penawaran jasa desain custom dalam satu tempat.</p>
        </section>
        
        <!-- Footer -->
        <footer class="w-full bg-white py-4 text-center mt-10">
            <p class="text-black">&copy; 2025 DeskaLink. Semua Hak Dilindungi.</p>
        </footer>
    </div>
</x-app-layout>