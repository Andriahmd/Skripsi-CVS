@extends('layouts.app') 

@section('content')


    <main>
        <div class="bg-gray-50 pt-10 pb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl font-extrabold text-gray-900 mb-4 leading-tight">
                        Quick Test for Detecting CVS Symptoms, <br class="hidden sm:block">
                        <span class="text-teal-600">Website</span>
                    </h1>
                    <p class="text-gray-600 mb-8 max-w-lg">
                        Providing compassionate and advance healthcare for a healthier tomorrow. We are dedicated to your wellbeing.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-teal-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-teal-700 transition duration-300 shadow-lg shadow-teal-500/50">
                            Explore More
                        </a>
                        <a href="#" class="text-teal-600 px-8 py-3 rounded-full font-semibold border border-teal-600 hover:bg-teal-50 transition duration-300 flex items-center">
                            <i class="far fa-play-circle mr-2"></i> Learn The Care
                        </a>
                    </div>

                    
                </div>
                
                <div class="relative">
                    <img
                        src="https://i.pinimg.com/736x/1a/d1/96/1ad19650f28ef335609605a56f6dd08d.jpg"
                        alt="CVSfoto"
                        class="w-full h-auto rounded-lg shadow-2xl"
                    />
                </div>
            </div>
        </div>

    <div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Comprehensive Medical Services</h2>
            <p class="text-gray-500 mt-2">We offer a wide range of specialized medical services tailored to your needs.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-teal-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 text-center">
                <div class="text-4xl text-teal-600 mb-4"><i class="fas fa-hand-holding-heart"></i></div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Benefits of Hydration</h3>
                <p class="text-gray-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-teal-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 text-center">
                <div class="text-4xl text-teal-600 mb-4"><i class="fas fa-comment-alt"></i></div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">All Eye Routines</h3>
                <p class="text-gray-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-teal-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 text-center">
                <div class="text-4xl text-teal-600 mb-4"><i class="fas fa-eye"></i></div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Correct Tooth Brushing</h3>
                <p class="text-gray-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-teal-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 text-center">
                <div class="text-4xl text-teal-600 mb-4"><i class="fas fa-camera"></i></div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Proper Use of Teeth</h3>
                <p class="text-gray-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-teal-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 text-center">
                <div class="text-4xl text-teal-600 mb-4"><i class="fas fa-seedling"></i></div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Eye Nutrition</h3>
                <p class="text-gray-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div class="bg-teal-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 text-center">
                <div class="text-4xl text-teal-600 mb-4"><i class="fas fa-utensils"></i></div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Food Advertising</h3>
                <p class="text-gray-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
        </div>

        <div class="text-center mt-10">
            <a href="#" class="text-teal-600 font-semibold hover:text-teal-700 transition duration-300 flex items-center justify-center">
                View All Services <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>
        
        </div>
</div>
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Meet Our Dedicated Specialists</h2>
                    <p class="text-gray-500 mt-2">Our expert team is here to provide personalized and high-quality care.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-xl shadow-lg text-center border-t-4 border-teal-600">
                        {{-- <img src="{{ asset('images/doctor-female-1.jpg') }}" alt="Specialist Dr. Maya" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover border-4 border-white shadow-md">
                        <h3 class="text-xl font-semibold text-gray-900">Dr. Maya Chen</h3> --}}
                        <p class="text-teal-600 font-medium mb-3">Primary Care Specialist</p>
                        <p class="text-gray-500 text-sm">Expert in chronic disease management and preventive medicine.</p>
                        <a href="#" class="mt-4 inline-block text-teal-600 hover:text-teal-700 text-sm font-medium">View Profile</a>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg text-center border-t-4 border-teal-600">
                        <img src="{{ asset('images/doctor-male-1.jpg') }}" alt="Specialist Dr. Ben" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover border-4 border-white shadow-md">
                        <h3 class="text-xl font-semibold text-gray-900">Dr. Ben Carlos</h3>
                        <p class="text-teal-600 font-medium mb-3">Cardiology</p>
                        <p class="text-gray-500 text-sm">Award-winning cardiologist focusing on heart health and surgery.</p>
                        <a href="#" class="mt-4 inline-block text-teal-600 hover:text-teal-700 text-sm font-medium">View Profile</a>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg text-center border-t-4 border-teal-600">
                        <img src="{{ asset('images/doctor-female-2.jpg') }}" alt="Specialist Dr. Sarah" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover border-4 border-white shadow-md">
                        <h3 class="text-xl font-semibold text-gray-900">Dr. Sarah Lee</h3>
                        <p class="text-teal-600 font-medium mb-3">Pediatrics</p>
                        <p class="text-gray-500 text-sm">Focuses on newborn care, childhood illnesses, and vaccination.</p>
                        <a href="#" class="mt-4 inline-block text-teal-600 hover:text-teal-700 text-sm font-medium">View Profile</a>
                    </div>
                </div>

                <div class="text-center mt-10">
                    <a href="#" class="bg-gray-900 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300 shadow-md">
                        View All Doctors
                    </a>
                </div>
            </div>
        </div>

    </main>
    

@endsection