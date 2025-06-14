<x-app-layout>
    {{-- Kontainer untuk Skeleton Loader --}}
    <div id="skeleton-loader" class="container mx-auto p-8 animate-pulse">
        
        {{-- Skeleton untuk Hero Section --}}
        <div class="flex flex-col md:flex-row items-center md:space-x-10 py-8">
            {{-- Skeleton untuk Ilustrasi Lottie (kiri) --}}
            <div class="md:w-1/2 flex justify-center items-center mb-10 md:mb-0">
                <div class="w-full max-w-[450px] h-96 bg-gray-300 rounded-lg"></div>
            </div>
            
            {{-- Skeleton untuk Teks (kanan) --}}
            <div class="md:w-1/2 space-y-5">
                {{-- Judul Besar --}}
                <div class="h-10 bg-gray-300 rounded-md w-3/4"></div>
                <div class="h-10 bg-gray-300 rounded-md w-1/2"></div>
                {{-- Paragraf --}}
                <div class="space-y-3 pt-4">
                    <div class="h-4 bg-gray-300 rounded-md w-full"></div>
                    <div class="h-4 bg-gray-300 rounded-md w-5/6"></div>
                </div>
                {{-- Tombol CTA --}}
                <div class="flex flex-col sm:flex-row sm:space-x-4 pt-4">
                    <div class="h-12 bg-gray-300 rounded-md w-full sm:w-48"></div>
                    <div class="h-12 bg-gray-300 rounded-md w-full sm:w-48 mt-4 sm:mt-0"></div>
                </div>
                {{-- Testimoni --}}
                <div class="h-24 bg-gray-200 rounded-lg mt-6"></div>
            </div>
        </div>

        {{-- Skeleton untuk Section Lain --}}
        <div class="pt-16 space-y-12">
            {{-- Judul Section --}}
            <div class="h-8 bg-gray-300 rounded-md w-1/3 mx-auto"></div>
            {{-- Anggota Tim --}}
            <div class="flex items-center space-x-6">
                <div class="w-52 h-52 bg-gray-300 rounded-full"></div>
                <div class="flex-1 space-y-4">
                    <div class="h-6 bg-gray-300 rounded-md w-1/2"></div>
                    <div class="h-4 bg-gray-300 rounded-md w-1/4"></div>
                    <div class="h-4 bg-gray-300 rounded-md w-full"></div>
                </div>
            </div>
            {{-- Grid Fitur --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pt-8">
                <div class="h-40 bg-gray-300 rounded-lg"></div>
                <div class="h-40 bg-gray-300 rounded-lg"></div>
                <div class="h-40 bg-gray-300 rounded-lg"></div>
                <div class="h-40 bg-gray-300 rounded-lg"></div>
            </div>
        </div>
    </div>
    <div id="real-content" class="hidden">
            <div class="text-gray-800 min-h-screen">
            <!-- Hero Section -->
            <div class="relative">
                <div class="hero-content">
                    <div class="container mx-auto px-8 py-16">
                        <div class="flex flex-col md:flex-row items-center md:space-x-10">
                            <!-- Ilustrasi -->
                            <div class="md:w-1/2 flex justify-center items-center mb-10 md:mb-0">
                            <script
                            src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs"
                            type="module"
                            ></script>
                            <dotlottie-player
                            src="https://lottie.host/54bc181f-8674-4373-a188-cc55f4b8939f/6JGxqIrzey.lottie"
                            background="transparent"
                            speed="1"
                            style="width: 100%; max-width: 450px; height: auto;"
                            loop
                            autoplay
                            ></dotlottie-player>
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
                                <div class="group mt-8 bg-white bg-opacity-80 backdrop-blur-sm p-3 rounded-lg shadow-md border border-red-100 transform transition duration-300 hover:scale-100 hover:shadow-xl">
                                    <p class="italic text-gray-700 transition-colors duration-300 group-hover:text-gray-900">
                                        "Saya berhasil menjual desain pertama saya dalam waktu seminggu!"
                                    </p>
                                    <p class="text-red-500 mt-2 font-semibold transition-colors duration-300 group-hover:text-red-600">
                                        - Adi, Desainer Digital
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Team Section -->
            <section id="team" class="container mx-auto mt-16 p-8 text-center">
                <h2 class="text-3xl font-semibold text-red-500" data-aos="fade-up">Profil Tim Developer</h2>
                <p class="mt-4 text-lg text-gray-600" data-aos="fade-up" data-aos-delay="100">Kami adalah tim ahli di bidang Web Development, UI/UX, dan Database Management.</p>
            
                <div class="mt-8 space-y-16">
                    <!-- Anggota 1 (Foto Kiri) -->
                    <div class="flex flex-col md:flex-row items-center text-center md:text-left" data-aos="fade-right">
                        <img src="{{ asset('images/team1.webp') }}" alt="James Petra"
                            class="w-52 h-52 rounded-full border-4 border-red-500">
                        <div class="md:ml-10 flex flex-col justify-center">
                            <h3 class="text-3xl font-semibold text-gray-900">James Petra Benaya P. N</h3>
                            <p class="text-red-500 text-xl font-medium">Full-Stack Developer</p>
                            <p class="text-gray-600 mt-3">Ahli dalam mengembangkan aplikasi web dari frontend hingga backend menggunakan teknologi modern.</p>
                        </div>
                    </div>
            
                    <!-- Anggota 2 (Foto Kanan) -->
                    <div class="flex flex-col md:flex-row-reverse items-center text-center md:text-right" data-aos="fade-left">
                        <img src="{{ asset('images/team2.webp') }}" alt="Umar Mukhtar"
                            class="w-52 h-52 rounded-full border-4 border-red-500">
                        <div class="md:mr-10 flex flex-col justify-center">
                            <h3 class="text-3xl font-semibold text-gray-900">Umar Mukhtar</h3>
                            <p class="text-red-500 text-xl font-medium">Backend & Database Engineer</p>
                            <p class="text-gray-600 mt-3">Mengembangkan dan mengelola sistem database serta API untuk menjaga performa aplikasi tetap optimal.</p>
                        </div>
                    </div>
            
                    <!-- Anggota 3 (Foto Kiri) -->
                    <div class="flex flex-col md:flex-row items-center text-center md:text-left" data-aos="fade-right">
                        <img src="{{ asset('images/team3.webp') }}" alt="Mokhammad Afrylianto"
                            class="w-52 h-52 rounded-full border-4 border-red-500">
                        <div class="md:ml-10 flex flex-col justify-center">
                            <h3 class="text-3xl font-semibold text-gray-900">Mokhammad Afrylianto Aryo Abdi</h3>
                            <p class="text-red-500 text-xl font-medium">UI/UX Designer</p>
                            <p class="text-gray-600 mt-3">Membuat desain antarmuka yang menarik dan user-friendly untuk pengalaman pengguna yang lebih baik.</p>
                        </div>
                    </div>
            
                    <!-- Anggota 4 (Foto Kanan) -->
                    <div class="flex flex-col md:flex-row-reverse items-center text-center md:text-right" data-aos="fade-left">
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
                <h2 class="text-3xl font-semibold text-red-500" data-aos="fade-up">Keunggulan DeskaLink</h2>
                <p class="mt-4 text-lg text-gray-700 max-w-2xl mx-auto"data-aos="fade-up" data-aos-delay="100">
                    DeskaLink memberikan pengalaman terbaik dalam memesan jasa desain dan membeli karya digital dengan aman dan nyaman.
                </p>
            
                <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-lg border border-red-100 transform transition duration-300 hover:scale-105 hover:shadow-2xl" data-aos="fade-up" data-aos-delay="100">
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

                    <div class="bg-white p-6 rounded-lg shadow-lg border border-red-100 transform transition duration-300 hover:scale-105 hover:shadow-2xl" data-aos="fade-up" data-aos-delay="200">
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

                    <div class="bg-white p-6 rounded-lg shadow-lg border border-red-100 transform transition duration-300 hover:scale-105 hover:shadow-2xl" data-aos="fade-up" data-aos-delay="300">
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

                    <div class="bg-white p-6 rounded-lg shadow-lg border border-red-100 transform transition duration-300 hover:scale-105 hover:shadow-2xl" data-aos="fade-up" data-aos-delay="400">
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
                <h2 class="text-3xl font-semibold text-red-500" data-aos="zoom-in">Masalah yang Ingin Diselesaikan</h2>
                <p class="mt-4 text-lg max-w-2xl mx-auto text-gray-700" data-aos="zoom-in" data-aos-delay="100">Minimnya platform yang secara khusus menggabungkan penjualan desain digital siap pakai dan penawaran jasa desain custom dalam satu tempat.</p>
            </section>
            
            <!-- Footer -->
            <footer class="pt-12 mt-10 border-t border-slate-800" data-aos="fade-up">
                <div class="max-w-7xl mx-auto px-6 sm:px-6 lg:px-8 text-center">
                    <div class="flex justify-center mb-6">
                        <a href="{{ url('/') }}" class="text-2xl font-bold text-red-400 hover:text-red-300 transition-colors duration-300">
                            DeskaLink
                        </a>
                    </div>
                    <p class="mb-6 max-w-2xl mx-auto text-sm text-gray-400">
                        Platform revolusioner yang menghubungkan desainer digital terbaik dengan klien yang membutuhkan solusi kreatif berkualitas tinggi di seluruh Indonesia.
                    </p>
                    <div class="flex justify-center space-x-6 mb-8">
                        <a href="#" class="text-gray-400 hover:text-red-400 transition-all duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-red-400 transition-all duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.286 2.553 7.94 6.205 9.49.5.092.682-.217.682-.482 0-.237-.008-.868-.013-1.703-2.482.538-3.004-1.198-3.004-1.198-.455-1.157-1.11-1.465-1.11-1.465-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.942 0-1.09.39-1.984 1.03-2.682-.103-.253-.446-1.27.098-2.646 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.82c.85.004 1.705.115 2.504.336 1.909-1.296 2.747-1.027 2.747-1.027.546 1.375.202 2.393.1 2.646.64.698 1.03 1.592 1.03 2.682 0 3.84-2.337 4.685-4.566 4.935.359.308.678.92.678 1.852 0 1.336-.012 2.41-.012 2.736 0 .267.18.577.688.48A10.001 10.001 0 0022 12c0-5.523-4.477-10-10-10z" clip-rule="evenodd" /></svg>
                        </a>
                    </div>
                    <div class="text-sm text-gray-500">
                        &copy; {{ date('Y') }} DeskaLink. All Rights Reserved.
                    </div>
                </div>
            </footer>
        </div>
    </div>
</x-app-layout>