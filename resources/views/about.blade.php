@extends('layouts.app')

@section('content')
<section class="about-section bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <div class="row flex flex-wrap items-center">
            <div class="col-md- w-full md:w-1/2">
                {{-- <img src="https://i.pinimg.com/1200x/a2/20/cb/a220cb6423e96fe1754b09815880f421.jpg" alt="People Working" class="img-rounded rounded-lg mb-4"> --}}
           <img src="https://i.pinimg.com/1200x/a2/20/cb/a220cb6423e96fe1754b09815880f421.jpg" 
       alt="Computer Vision Syndrome" 
       style="width: 580px; height: auto; border-radius: 8px; object-fit: cover;">
            </div>
            
            <div class="col-md-6 w-full md:w-1/2">
                <h1 class="title text-4xl font-bold text-gray-900 mb-4">Understanding Computer Vision Syndrome</h1>
                <p class="description text-gray-600 mb-6">
                    Computer Vision Syndrome (CVS) arises from prolonged screen exposure, causing eyestrain, headaches, blurred vision, and discomfort. Factors like poor ergonomics and uncorrected vision worsen its impact, affecting people of all ages.
                </p>
                
                <div class="value-item flex items-center mb-6">
                    <div class="icon flex items-center justify-center w-10 h-10 bg-teal-500 text-white rounded-full mr-4">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h3 class="value-title text-xl font-bold">Dangers for Teenagers</h3>
                        <p class="value-desc text-gray-600">
                            Teens face risks like myopia, sleep disruption, and reduced focus from excessive screen use, especially with gaming and online studies.
                        </p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste laboriosam vitae quae quibusdam voluptatibus eveniet exercitationem officia facilis quaerat. Explicabo ad quo qui voluptatum, nihil, hic totam fuga blanditiis consequatur soluta provident alias quae asperiores atque perferendis ipsa at? Ab, odio neque illum iste recusandae velit, architecto, tempore eum aperiam similique eveniet facilis quo. Maiores expedita in quam ipsum nesciunt eius voluptas deleniti quisquam non aut praesentium quis ea, tenetur explicabo fugit odio delectus. Suscipit vero itaque sint quod dolores dolorem dolor ad. Ipsa laudantium voluptatum voluptates qui amet veritatis nulla, perspiciatis eius laborum, laboriosam dignissimos pariatur praesentium rem reiciendis!</p>
                    </div>
                </div>
                
                <div class="value-item flex items-center mb-6">
                    <div class="icon flex items-center justify-center w-10 h-10 bg-teal-500 text-white rounded-full mr-4">
                        <i class="fas fa-user-injured"></i>
                    </div>
                    <div>
                        <h3 class="value-title text-xl font-bold">Impacts on the Elderly</h3>
                        <p class="value-desc text-gray-600">
                            Older adults experience intensified symptoms due to age-related eye issues, such as dry eyes and fatigue, potentially worsening conditions like cataracts.
                        </p>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Architecto, tenetur esse quasi explicabo dolor, sunt ducimus labore beatae nisi pariatur repudiandae illo animi officiis aspernatur nam vero sit nobis. Iusto laudantium dolor eveniet. Et incidunt nobis magnam, explicabo commodi eos eligendi excepturi nostrum, blanditiis facilis ut ullam maiores in deleniti.</p>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</section>
@endsection