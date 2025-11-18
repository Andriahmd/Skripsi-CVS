@extends('layouts.app')

@section('content')
{{-- UBAH DISINI: Ganti bg-gray-100 menjadi style background-color: #D7E7E5 --}}
<section class="about-section py-12" style="background-color: #D7E7E5;">
    <div class="container mx-auto px-4">
        <div class="row flex flex-wrap items-center">
            
            {{-- Kolom Gambar --}}
            <div class="col-md-6 w-full md:w-1/2 mb-8 md:mb-0">
                <img src="https://i.pinimg.com/1200x/a2/20/cb/a220cb6423e96fe1754b09815880f421.jpg" 
                     alt="Computer Vision Syndrome" 
                     class="shadow-lg"
                     style="width: 580px; max-width: 100%; height: auto; border-radius: 12px; object-fit: cover;">
            </div>
            
            {{-- Kolom Teks --}}
            <div class="col-md-6 w-full md:w-1/2 md:pl-10">
                <h1 class="title text-4xl font-bold text-teal-900 mb-4">Understanding Computer Vision Syndrome</h1>
                <p class="description text-gray-700 mb-8 text-lg leading-relaxed">
                    Computer Vision Syndrome (CVS) arises from prolonged screen exposure, causing eyestrain, headaches, blurred vision, and discomfort. Factors like poor ergonomics and uncorrected vision worsen its impact, affecting people of all ages.
                </p>
                
                {{-- Item 1 --}}
                <div class="value-item flex items-start mb-8 bg-white/50 p-4 rounded-xl border border-teal-100 hover:shadow-md transition-all">
                    {{-- <div class="icon flex flex-shrink-0 items-center justify-center w-12 h-12 bg-teal-600 text-white rounded-full mr-5 shadow-md">
                        <i class="fas fa-exclamation-triangle text-lg"></i>
                    </div> --}}
                    <div>
                        <h3 class="value-title text-xl font-bold text-teal-800 mb-2">Dangers for Teenagers</h3>
                        <p class="value-desc text-gray-700 mb-2">
                            Teens face risks like myopia, sleep disruption, and reduced focus from excessive screen use, especially with gaming and online studies.
                        </p>
                        <p class="text-sm text-gray-600 italic">
                            "Early prevention in teenagers significantly reduces the risk of long-term vision damage."
                        </p>
                    </div>
                </div>
                
                {{-- Item 2 --}}
                <div class="value-item flex items-start bg-white/50 p-4 rounded-xl border border-teal-100 hover:shadow-md transition-all">
                    {{-- <div class="icon flex flex-shrink-0 items-center justify-center w-12 h-12 bg-teal-600 text-white rounded-full mr-5 shadow-md">
                        <i class="fas fa-user-injured text-lg"></i>
                    </div> --}}
                    <div>
                        <h3 class="value-title text-xl font-bold text-teal-800 mb-2">Impacts on the Elderly</h3>
                        <p class="value-desc text-gray-700 mb-2">
                            Older adults experience intensified symptoms due to age-related eye issues, such as dry eyes and fatigue, potentially worsening conditions like cataracts.
                        </p>
                        <p class="text-sm text-gray-600 italic">
                            "Proper ergonomics and lighting are crucial for elderly users to maintain eye comfort."
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection