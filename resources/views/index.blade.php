@extends('layouts.app')

@section('content')

    <main>
        <!-- ✅ Tambahan padding top agar tidak tertimpa header -->
        <div class="h-[100px] md:h-[150px]"></div><br>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-5xl font-extrabold text-gray-900 mb-4 leading-tight">
                    Quick Test for Detecting CVS Symptoms, <br class="hidden sm:block">
                    <span class="text-teal-600">Website</span>
                </h1>
                <p class="text-gray-600 mb-8 max-w-lg">
                    Deteksi gejala Computer Vision Syndrome (CVS) secara cepat dan akurat. Jaga kesehatan mata Anda dari
                    kelelahan akibat layar.
                </p>
                <a href="#"
                    class="bg-teal-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-teal-700 transition duration-300 shadow-lg shadow-teal-500/50">
                    Cek Sekarang
                </a>
            </div>
            <div class="relative">
                <img src="https://i.pinimg.com/736x/1a/d1/96/1ad19650f28ef335609605a56f6dd08d.jpg" alt="CVSfoto"
                    class="w-3/4 h-auto mx-auto rounded-lg shadow-2xl" />
            </div>
        </div><br>
        </div>

        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Comprehensive Medical Services</h2>
                    <p class="text-gray-500 mt-2">We offer a wide range of specialized medical services tailored to your
                        needs.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-teal-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 text-center">
                        <div class="text-4xl text-teal-600 mb-4"><i class="fas fa-hand-holding-heart"></i></div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Benefits of Hydration</h3>
                        <p class="text-gray-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
                <div class="text-center mt-10">
                    <a href="#"
                        class="text-teal-600 font-semibold hover:text-teal-700 transition duration-300 flex items-center justify-center">
                        View All Services <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="py-16 bg-muted">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Meet Our Dedicated Specialists</h2>
                    <p class="text-gray-500 mt-2">Our expert team is here to provide personalized and high-quality care.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Specialist divs remain unchanged -->
                </div>
                <div class="text-center mt-10">
                    <a href="#"
                        class="bg-gray-900 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300 shadow-md">
                        View All Doctors
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection