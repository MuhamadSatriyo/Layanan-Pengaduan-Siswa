<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor! Pengaduan Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-blue-100 to-white">

    <!-- NAVBAR -->
    <nav class="flex justify-between items-center px-10 py-5 bg-white shadow">
        <div class="flex items-center gap-3">
            <img src="https://cdn-icons-png.flaticon.com/512/2920/2920222.png" class="w-10">
            <h1 class="text-2xl font-bold text-blue-600">LAPOR! <span class="text-gray-800">Pengaduan Siswa</span></h1>
        </div>

        <div class="flex items-center gap-6">
            <a href="{{ route('login') }}"
                class="border border-blue-500 text-blue-500 px-4 py-2 rounded-lg hover:bg-blue-500 hover:text-white transition">
                Login
            </a>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="flex flex-col md:flex-row items-center justify-between px-10 lg:px-20 py-16">

        <!-- TEXT -->
        <div class="max-w-xl">
            <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                Sampaikan Aspirasimu, <br>
                Bangun Sekolah Bersama
            </h1>

            <p class="mt-5 text-gray-600 leading-relaxed text-lg">
                Platform pengaduan online untuk siswa, cepat, aman, dan transparan.
            </p>
        </div>

        

    </section>

    <!-- CONTENT BOX -->
    <div class="bg-white shadow-xl rounded-2xl mx-10 lg:mx-20 -mt-10 p-10">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

            <!-- ALUR PENGADUAN -->
            <div>
                <h2 class="text-xl font-bold mb-4">Alur Pengaduan</h2>

                <div class="flex items-center gap-5">
                    <div
                        class="bg-blue-100 text-blue-600 font-bold w-12 h-12 flex items-center justify-center rounded-full text-xl">
                        1</div>
                    <span class="text-gray-600">Kirim Pengaduan</span>
                </div>

                <div class="flex items-center gap-5 mt-4">
                    <div
                        class="bg-blue-100 text-blue-600 font-bold w-12 h-12 flex items-center justify-center rounded-full text-xl">
                        2</div>
                    <span class="text-gray-600">Verifikasi & Tindak Lanjut</span>
                </div>

                <div class="flex items-center gap-5 mt-4">
                    <div
                        class="bg-blue-100 text-blue-600 font-bold w-12 h-12 flex items-center justify-center rounded-full text-xl">
                        3</div>
                    <span class="text-gray-600">Selesai</span>
                </div>
            </div>

            <!-- KATEGORI -->
            <div>
                <h2 class="text-xl font-bold mb-4">Kategori Pengaduan Terpopuler</h2>

                <div class="grid grid-cols-2 gap-4">
                    <button class="border rounded-lg px-4 py-3 hover:bg-blue-500 hover:text-white transition">Fasilitas
                        Sekolah</button>
                    <button class="border rounded-lg px-4 py-3 hover:bg-blue-500 hover:text-white transition">Kualitas
                        Mengajar</button>
                    <button class="border rounded-lg px-4 py-3 hover:bg-blue-500 hover:text-white transition">Lingkungan
                        Belajar</button>
                    <button
                        class="border rounded-lg px-4 py-3 hover:bg-blue-500 hover:text-white transition">Lainnya</button>
                </div>

                <a href="{{ route('login') }}"
                    class="mt-6 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition inline-block">
                    LAPOR SEKARANG
                </a>

            </div>

        </div>
    </div>

    <footer class="text-center text-gray-600 py-6">
        © 2025 Lapor! Pengaduan Siswa
    </footer>

</body>

</html>
