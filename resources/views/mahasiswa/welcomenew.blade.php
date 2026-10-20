<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIREMA | Sistem Rekomendasi Tempat Magang</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- AOS --}}
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: 'Poppins', sans-serif;
    }

    .hero-overlay {
        background:
            linear-gradient(rgba(15, 23, 42, .80),
                rgba(37, 99, 235, .60));
    }

    .navbar-scroll {
        background: white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
    }

    .counter-card {
        transition: .35s;
    }

    .counter-card:hover {
        transform: translateY(-8px);
    }

    .scroll-indicator {
        animation: updown 1.5s infinite;
    }

    @keyframes updown {
        0% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0);
        }
    }
    </style>

</head>

<body class="bg-slate-50">

    <!-- ================= NAVBAR ================= -->

    <nav id="navbar" class="fixed top-0 left-0 w-full z-50 duration-300">

        <div class="max-w-7xl mx-auto px-6">

            <div class="flex justify-between items-center h-20">

                <a href="/" class="flex items-center gap-3">

                    <img src="{{ asset('images/logo-sirema.png') }}" class="h-11">



                </a>

                <div class="hidden md:flex items-center gap-10 font-medium">

                    <a href="#home" class="nav-link text-white hover:text-blue-300 duration-300">
                        Beranda
                    </a>

                    <a href="#tentang" class="nav-link text-white hover:text-blue-300 duration-300">
                        Tentang
                    </a>

                    <a href="#panduan" class="nav-link text-white hover:text-blue-300 duration-300">
                        Panduan
                    </a>

                    <a href="{{ route('login') }}"
                        class="bg-gradient-to-br from-[#071739] via-[#0B1736] to-[#2952E3] text-white px-6 py-2 rounded-full hover:bg-blue-700 duration-300">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                        class="bg-white text-blue-600 px-5 py-2 rounded-full hover:bg-gradient-to-br from-[#071739] via-[#0B1736] to-[#2952E3] hover:text-white duration-300">
                        Register
                    </a>

                </div>

            </div>

        </div>

    </nav>

    <!-- ================= HERO ================= -->

    <section id="home" class="relative h-screen overflow-hidden">

        <img src="{{ asset('images/hero-polindra.jpg') }}" class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0 hero-overlay"></div>

        <div class="relative z-10 h-full flex items-center">

            <div class="max-w-7xl mx-auto px-6">

                <div class="max-w-3xl">

                    <p data-aos="fade-down" class="uppercase tracking-[6px] text-blue-200 mb-5 font-medium">

                        WELCOME TO SIREMA

                    </p>

                    <h1 data-aos="fade-up" class="text-white text-5xl lg:text-7xl font-extrabold leading-tight">

                        Sistem Rekomendasi
                        <span class="text-blue-300">

                            Tempat Magang

                        </span>

                    </h1>

                    <p data-aos="fade-up" data-aos-delay="200" class="mt-8 text-lg text-slate-200 leading-8">

                        Membantu mahasiswa D3 Teknik Informatika Politeknik Negeri Indramayu
                        menemukan tempat magang yang sesuai
                        berdasarkan kompetensi, preferensi, dan metode
                        AHP serta WASPAS.

                    </p>

                    <div data-aos="fade-up" data-aos-delay="400" class="flex flex-wrap gap-5 mt-10">

                        <a href="{{ route('login') }}"
                            class="bg-blue-600 hover:bg-blue-700 px-8 py-4 rounded-full text-white font-semibold duration-300">

                            Mulai Sekarang

                        </a>

                        <a href="#tentang"
                            class="border border-white text-white hover:bg-white hover:text-slate-800 px-8 py-4 rounded-full duration-300">

                            Pelajari Lebih Lanjut

                        </a>

                    </div>

                </div>

            </div>

        </div>



    </section>



    <!-- ================= TENTANG SIREMA ================= -->

    <section id="tentang" class="py-24 bg-slate-50">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid lg:grid-cols-2 gap-16 items-center">

                {{-- Gambar --}}
                <div data-aos="fade-right" class="relative">

                    <div class="absolute -top-6 -left-6 w-40 h-40 bg-blue-100 rounded-3xl"></div>

                    <img src="{{ asset('images/polindra.jpeg') }}"
                        class="relative rounded-3xl shadow-2xl w-full object-cover hover:scale-105 duration-500">

                </div>

                {{-- Konten --}}
                <div data-aos="fade-left">

                    <span class="inline-block bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">

                        Tentang SIREMA

                    </span>

                    <h2 class="text-4xl font-bold text-slate-800 mt-6 leading-tight">

                        Membantu Mahasiswa Menentukan
                        Tempat Magang yang Tepat.

                    </h2>

                    <p class="text-gray-600 mt-6 leading-8">

                        SIREMA merupakan Sistem Rekomendasi Tempat Magang yang
                        dirancang untuk membantu mahasiswa Politeknik Negeri
                        Indramayu memperoleh perusahaan magang yang sesuai
                        dengan kompetensi akademik, minat, lokasi, dan biaya.

                    </p>

                    <p class="text-gray-600 mt-5 leading-8">

                        Sistem menggunakan metode
                        <strong>AHP</strong> untuk menentukan bobot setiap
                        kriteria dan <strong>WASPAS</strong> untuk melakukan
                        perankingan alternatif sehingga rekomendasi menjadi
                        lebih objektif, konsisten, dan akurat.

                    </p>

                    <div class="grid grid-cols-2 gap-5 mt-10">

                        <div class="bg-white rounded-2xl p-6 shadow">

                            <div class="text-3xl font-bold text-blue-600">

                                4

                            </div>

                            <p class="text-gray-600 mt-2">

                                Kriteria Penilaian

                            </p>

                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow">

                            <div class="text-3xl font-bold text-blue-600">

                                AHP + WASPAS

                            </div>

                            <p class="text-gray-600 mt-2">

                                Metode Pendukung Keputusan

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- ================= MANUAL BOOK ================= -->

    <section id="panduan" class="py-24 bg-gradient-to-br from-[#071739] via-[#0B1736] to-[#2952E3]">

        <div class="max-w-5xl mx-auto px-6 text-center text-white">

            <h2 class="text-4xl font-bold">
                Panduan Penggunaan SIREMA
            </h2>

            <p class="mt-6 text-blue-100 leading-8">
                Pelajari langkah-langkah penggunaan sistem mulai dari pengisian profil kompetensi hingga memperoleh
                hasil rekomendasi tempat magang.
            </p>

            <div class="mt-10">

                <a href="#"
                    class="inline-flex items-center gap-3 bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:scale-105 duration-300">

                    📖 Lihat Manual Book

                </a>

            </div>

        </div>

    </section>

    <!-- ================= CARA KERJA ================= -->

    <section class="py-24 bg-white">

        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-16" data-aos="fade-up">



                <h2 class="text-4xl font-bold mt-5">
                    Cara Menggunakan SIREMA
                </h2>

                <p class="text-gray-500 mt-5 max-w-3xl mx-auto">
                    Ikuti langkah-langkah berikut untuk memperoleh rekomendasi tempat magang.
                </p>

            </div>

            <div class="relative max-w-5xl mx-auto">

                <!-- Garis Timeline -->
                <div class="absolute left-8 top-0 bottom-0 w-1 bg-blue-200"></div>

                @php
                $steps = [
                ['1','Lengkapi Menu Kualifikasi','Lengkapi Profil Kompetensi dan Minat terlebih dahulu sebagai dasar
                penilaian kompetensi mahasiswa.'],
                ['2','Menu Rekomendasi','Buka menu Rekomendasi untuk memulai proses pencarian tempat magang.'],
                ['3','Input Perbandingan AHP','Lakukan perbandingan antar kriteria menggunakan metode AHP untuk
                menentukan bobot.'],
                ['4','Hitung Rekomendasi','Klik tombol Hitung Rekomendasi untuk memproses AHP dan WASPAS.'],
                ['5','Lihat Hasil Ranking','Sistem menampilkan perusahaan berdasarkan nilai rekomendasi tertinggi.'],
                ['6','Aktifkan Hold','Jika memilih perusahaan, aktifkan Hold agar kuota sementara dicadangkan.'],
                ['7','Upload Bukti','Setelah diterima perusahaan, unggah bukti penerimaan melalui menu Daftar
                Perusahaan.'],
                ];
                @endphp

                @foreach($steps as $step)

                <div class="relative flex gap-8 mb-12" data-aos="fade-up">

                    <div
                        class="z-10 w-16 h-16 rounded-full bg-gradient-to-br from-[#071739] via-[#0B1736] to-[#2952E3] text-white flex items-center justify-center text-xl font-bold shadow-lg flex-shrink-0">
                        {{ $step[0] }}
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg p-6 w-full hover:shadow-xl transition">

                        <h3 class="text-xl font-bold text-slate-800">
                            {{ $step[1] }}
                        </h3>

                        <p class="text-gray-600 mt-3 leading-7">
                            {{ $step[2] }}
                        </p>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </section>


    <!-- ================= FOOTER ================= -->

    <footer class="bg-gradient-to-br from-[#071739] via-[#0B1736] to-[#2952E3] text-white">

        <div class="max-w-7xl mx-auto px-6 py-20">

            <div class="grid lg:grid-cols-3 gap-10">

                <div>
                    <img src="{{ asset('images/sirema2.png') }}" class="h-14">

                    <h3 class="text-2xl font-bold mt-5">
                        SIREMA
                    </h3>

                    <p class="mt-5 text-slate-300 leading-8">
                        Sistem Rekomendasi Tempat Magang Mahasiswa menggunakan metode AHP dan WASPAS di Politeknik
                        Negeri Indramayu.
                    </p>

                </div>

                <div>

                    <h4 class="font-bold text-lg mb-6">
                        Menu
                    </h4>

                    <ul class="space-y-4 text-slate-300">

                        <li><a href="#home" class="hover:text-white">Beranda</a></li>
                        <li><a href="#tentang" class="hover:text-white">Tentang</a></li>
                        <li><a href="#panduan" class="hover:text-white">Panduan</a></li>

                    </ul>

                </div>

                <div>

                    <h4 class="font-bold text-lg mb-6">
                        Kontak
                    </h4>

                    <p class="text-slate-300 leading-8">

                        Politeknik Negeri Indramayu, Jl. Lohbener Lama No.08 Indramayu

                        <br><br>

                        Email:
                        sirema@polindra.ac.id

                    </p>

                </div>

            </div>

            <hr class="border-slate-700 my-10">

            <div class="text-center text-slate-400">

                © {{ date('Y') }} SIREMA • Tugas Akhir

            </div>

        </div>

    </footer>

    <!-- ================= BACK TO TOP ================= -->

    <button id="topButton"
        class="hidden fixed bottom-8 right-8 bg-blue-600 text-white w-14 h-14 rounded-full shadow-xl hover:bg-blue-700 duration-300">

        ↑

    </button>

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <script>
    AOS.init({
        duration: 900,
        once: true
    });

    const navbar = document.getElementById('navbar');

    const navLinks = document.querySelectorAll('.nav-link');

    const navText = document.querySelector('.nav-text');

    window.addEventListener('scroll', () => {

        if (window.scrollY > 80) {

            navbar.classList.add('navbar-scroll');

            navText.classList.remove('text-white');
            navText.classList.add('text-slate-800');

            navLinks.forEach(link => {

                link.classList.remove('text-white');

                link.classList.add('text-slate-700');

            });

        } else {

            navbar.classList.remove('navbar-scroll');

            navText.classList.remove('text-slate-800');
            navText.classList.add('text-white');

            navLinks.forEach(link => {

                link.classList.remove('text-slate-700');

                link.classList.add('text-white');

            });

        }

    });
    </script>

</body>

</html>