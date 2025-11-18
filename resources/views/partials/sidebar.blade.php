<div class="h-full flex flex-col p-6">
    <!-- Header (Fixed) -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-2 text-gray-800">Diagnosis CVS</h2>

        <!-- Progress Bar -->
        <div class="bg-gray-200 rounded-full h-2 mb-1">
            <div class="bg-quiz-purple h-2 rounded-full progress-bar transition-all duration-300" style="width: 0%;"></div>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-gray-500 text-sm" id="progress-text">0%</span>
            <span class="text-gray-500 text-sm">
                <span id="correct-count" class="font-semibold">0</span>/<span id="total-count">0</span>
            </span>
        </div>
    </div>

    <!-- Navigation (Scrollable kalau banyak) -->
    <nav class="flex-1 overflow-y-auto pr-2 scrollbar-thin" id="navigation">
        @php
            $categories = [
                1 => 'Kondisi Enklusi dan Eklusi',
                2 => 'Mata Lelah',
                3 => 'Mata Kering',
                4 => 'Mata Kabur',
                5 => 'Mata Berair',
                6 => 'Mata Gatal',
                7 => 'Mata Sensitif',
            ];
        @endphp

        <div class="flex flex-col gap-2">
            @foreach ($categories as $id => $title)
                <div class="quiz-category" data-category="{{ $id }}">
                    <button
                        class="w-full flex items-center justify-between p-3 rounded-lg bg-white text-gray-800 
                               hover:bg-emerald-50 transition-all duration-200 ease-in-out focus:outline-none border border-gray-200"
                        onclick="toggleCategory({{ $id }})"
                    >
                        <span class="text-sm font-medium text-left pr-4">{{ $title }}</span>
                        <div class="w-6 h-6 bg-quiz-purple rounded-full flex items-center justify-center text-white shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </button>
                </div>
            @endforeach
        </div>
    </nav>
</div>

<style>
    /* Custom scrollbar untuk nav */
    .scrollbar-thin::-webkit-scrollbar {
        width: 5px;
    }
    
    .scrollbar-thin::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>