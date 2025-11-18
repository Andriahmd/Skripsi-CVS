@extends('layouts.app')

@section('content')

    <main>
        <div class="h-[90px] md:h-[80px]"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-5xl font-extrabold text-gray-900 mb-4 leading-tight">
                    Quick Test for Detecting CVS Symptoms, <br class="hidden sm:block">
                    <span class="text-teal-600">Website</span>
                </h1>
                <p class="text-gray-600 mb-8 max-w-lg">
                    Deteksi gejala Computer Vision Syndrome (CVS) secara cepat dan akurat. Jaga kesehatan mata Anda dari
                    kelelahan akibat layar gadget dan komputer.
                </p>
                <a href="/pertanyaan"
                    class="bg-teal-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-teal-700 transition duration-300 shadow-lg shadow-teal-500/50">
                    Cek Sekarang
                </a>
            </div>
            <div class="relative">
                <img src="https://i.pinimg.com/736x/1a/d1/96/1ad19650f28ef335609605a56f6dd08d.jpg" alt="CVS Illustration"
                    class="w-4/4 h-auto mx-auto rounded-lg shadow-2xl" />
            </div>
        </div>

        <div class="py-8"></div>

        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Understanding Eye Health</h2>
                    <p class="text-gray-500 mt-2">Kenali gejala dan cara pencegahan Computer Vision Syndrome sedini mungkin.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    <div
                        class="bg-teal-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 text-center border border-teal-100">
                        <div class="text-4xl text-teal-600 mb-4">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Common Symptoms</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Mata kering, penglihatan kabur, sakit kepala, hingga nyeri leher adalah tanda umum Anda terlalu
                            lama menatap layar.
                        </p>
                    </div>

                    <div
                        class="bg-teal-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 text-center border border-teal-100">
                        <div class="text-4xl text-teal-600 mb-4">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">The 20-20-20 Rule</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Setiap 20 menit, alihkan pandangan sejauh 20 kaki (6 meter) selama 20 detik untuk
                            mengistirahatkan otot mata.
                        </p>
                    </div>

                    <div
                        class="bg-teal-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 text-center border border-teal-100">
                        <div class="text-4xl text-teal-600 mb-4">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Workspace Setup</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Pastikan jarak layar 50-60 cm dari mata dan atur pencahayaan ruangan agar tidak terlalu silau
                            atau gelap.
                        </p>
                    </div>

                </div>

                <div class="text-center mt-10">
                    <a href="#"
                        class="text-teal-600 font-semibold hover:text-teal-700 transition duration-300 flex items-center justify-center group">
                        Pelajari Lebih Lanjut <i
                            class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-12 max-w-3xl mx-auto">
                    <span class="text-teal-600 font-bold tracking-wide uppercase text-sm">Edukasi Kesehatan Mata</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-2 mb-6">
                        Bahaya Tersembunyi di Balik Layar Digital
                    </h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Di era modern, mata kita dipaksa bekerja lebih keras dari sebelumnya. Paparan sinar biru dan fokus
                        jarak dekat yang terus-menerus bukan hanya membuat mata lelah, tetapi dapat memicu gangguan
                        kesehatan jangka panjang yang serius.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    <div
                        class="bg-gray-50 rounded-xl p-8 border border-gray-100 hover:border-teal-200 transition duration-300">
                        <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center text-teal-600 mb-6">
                            <i class="fas fa-lightbulb text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Paparan Sinar Biru (Blue Light)</h3>
                        <p class="text-gray-600 leading-relaxed">


                            [Image of blue light spectrum effect on eye]

                            Layar digital memancarkan <em>High-Energy Visible (HEV) light</em> yang dapat menembus hingga ke
                            retina. Paparan jangka panjang berisiko merusak sel-sel peka cahaya dan mempercepat degenerasi
                            makula.
                        </p>
                    </div>

                    <div
                        class="bg-gray-50 rounded-xl p-8 border border-gray-100 hover:border-teal-200 transition duration-300">
                        <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center text-teal-600 mb-6">
                            <i class="fas fa-eye-slash text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Penurunan Frekuensi Kedip</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Normalnya manusia berkedip 15-20 kali per menit. Saat menatap layar, frekuensi ini turun drastis
                            menjadi 5-7 kali saja, menyebabkan permukaan mata kering, iritasi, dan pandangan kabur.
                        </p>
                    </div>

                    <div
                        class="bg-gray-50 rounded-xl p-8 border border-gray-100 hover:border-teal-200 transition duration-300">
                        <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center text-teal-600 mb-6">
                            <i class="fas fa-moon text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Disrupsi Ritme Sirkadian</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Penggunaan gadget di malam hari menekan produksi hormon melatonin. Hal ini tidak hanya membuat
                            sulit tidur (insomnia), tetapi juga menurunkan kualitas tidur yang berdampak pada pemulihan
                            mata.
                        </p>
                    </div>

                </div>

                <div class="mt-12 text-center bg-teal-50 rounded-2xl p-8 border border-teal-100">
                    <p class="text-gray-700 font-medium text-lg mb-4">
                        Apakah Anda merasakan salah satu gejala di atas? Jangan abaikan sinyal tubuh Anda.
                    </p>
                    <a href="{{ route('pertanyaan') }}"
                        class="inline-flex items-center text-teal-700 font-bold hover:text-teal-900 hover:underline transition">
                        Lakukan Diagnosis Sekarang <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

            </div>
        </div>
    </main>
@endsection