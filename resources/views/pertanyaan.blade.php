{{-- resources/views/pertanyaan.blade.php --}}
@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Background Gradient Modern --}}
<div class="min-h-screen w-full flex items-center justify-center bg-gradient-to-br from-slate-50 to-teal-50 p-4 md:p-8 overflow-hidden font-sans relative">
    
    {{-- Decorative Blobs --}}
    <div class="absolute top-0 left-0 w-96 h-96 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-cyan-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-32 left-20 w-96 h-96 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>

    {{-- MAIN CONTAINER --}}
    <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row h-[85vh] md:h-[80vh] relative z-10 border border-white/50">
        
        {{-- Loading Overlay Global --}}
        <div id="global-loading" class="absolute inset-0 z-50 bg-white flex flex-col items-center justify-center">
            <div class="relative">
                <div class="w-16 h-16 border-4 border-teal-100 border-t-teal-600 rounded-full animate-spin"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-teal-600 text-xs font-bold">CVS</div>
            </div>
            <p class="mt-4 text-gray-500 font-medium tracking-wide animate-pulse">Menyiapkan Sistem Pakar...</p>
        </div>

        {{-- LEFT PANEL --}}
        <div class="md:w-1/3 bg-teal-900 relative overflow-hidden flex flex-col justify-between p-8 text-white">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
            
            <div class="relative z-10">
                <div class="flex items-center space-x-2 mb-8 opacity-80">
                    <div class="w-2 h-2 bg-teal-400 rounded-full"></div>
                    <span class="text-xs font-bold tracking-widest uppercase">Sistem Diagnosis CVS</span>
                </div>
                
                <h1 id="category-title" class="text-3xl md:text-4xl font-bold leading-tight mb-2">Memuat...</h1>
                <p class="text-teal-200 text-sm md:text-base opacity-80">Jawablah dengan jujur sesuai kondisi mata Anda.</p>
            </div>

            <div class="relative z-10 mt-auto">
                <div class="flex justify-between text-xs font-medium mb-2 text-teal-200">
                    <span>Progress</span>
                    <span id="progress-text">0%</span>
                </div>
                <div class="w-full bg-teal-800/50 rounded-full h-2 overflow-hidden backdrop-blur-sm">
                    <div id="progress-bar" class="bg-gradient-to-r from-teal-400 to-emerald-400 h-full rounded-full transition-all duration-700 ease-out w-0"></div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-teal-800 flex items-center justify-between">
                     <div>
                        <p class="text-xs text-teal-400 uppercase tracking-wider mb-1">Pertanyaan</p>
                        <p id="question-counter-large" class="text-2xl font-bold">0<span class="text-teal-600 text-lg">/0</span></p>
                     </div>
                     <div class="w-10 h-10 rounded-full bg-teal-800 flex items-center justify-center">
                        <i class="fas fa-stethoscope text-teal-400"></i>
                     </div>
                </div>
            </div>
        </div>

        {{-- RIGHT PANEL --}}
        <div class="md:w-2/3 bg-white relative flex flex-col">
            
            <div class="md:hidden px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                <span class="text-sm font-bold text-gray-600">Pertanyaan</span>
                <span id="mobile-counter" class="text-sm font-bold text-teal-600">1 / -</span>
            </div>

            <div class="flex-1 overflow-y-auto p-6 md:p-12 custom-scrollbar flex items-center">
                <div class="w-full max-w-2xl mx-auto">
                    
                    <div id="question-container" class="transition-all duration-500">
                        <h2 id="q-text" class="text-xl md:text-2xl font-semibold text-gray-800 leading-relaxed mb-8 animate-fade-in-up"></h2>
                        <div id="options-container" class="space-y-3"></div>
                    </div>

                    <div id="question-loading" class="hidden flex-col items-center justify-center py-12">
                        <div class="w-10 h-10 border-4 border-gray-200 border-t-teal-500 rounded-full animate-spin mb-4"></div>
                        <span class="text-gray-400 text-sm">Memuat pertanyaan...</span>
                    </div>

                </div>
            </div>

            <div class="border-t border-gray-100 p-4 md:p-6 bg-white/80 backdrop-blur flex justify-between items-center">
                <button onclick="prevQuestion()" id="btn-prev" 
                    class="px-4 py-2 rounded-lg text-gray-400 hover:text-teal-600 hover:bg-teal-50 transition-colors flex items-center text-sm font-medium disabled:opacity-0">
                    <i class="fas fa-arrow-left mr-2"></i> Sebelumnya
                </button>

                <div class="flex items-center space-x-4">
                    <span id="autosave-status" class="text-xs text-gray-400 italic hidden">Tersimpan</span>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }
    
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: #94a3b8; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.4s ease-out forwards; }
</style>

<script>
// ==================== CONFIGURATION ====================
// ==================== CONFIGURATION ====================
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Check storage availability
const STORAGE_AVAILABLE = (() => {
    try {
        sessionStorage.setItem('test', '1');
        sessionStorage.removeItem('test');
        return true;
    } catch (e) {
        console.warn('⚠️ SessionStorage not available, using memory only');
        return false;
    }
})();

let quizData = {};
let currentCategory = 1;
let currentQuestions = []; 
let currentQIndex = 0;     
let userAnswers = {};      
let idPemeriksaan = null;
let pendingAnswers = [];
let saveTimeout = null;
let isFinishing = false;

const categoryTitles = {
    1: 'Screening Inklusi & Eksklusi',
    2: 'Analisis Mata Lelah',
    3: 'Analisis Mata Kering',
    4: 'Analisis Mata Kabur',
    5: 'Analisis Mata Gatal',
    6: 'Analisis Mata Berair',
    7: 'Analisis Mata Sensitif'
};

// ==================== STORAGE HELPERS ====================

function saveToStorage(key, data) {
    if (STORAGE_AVAILABLE) {
        try {
            sessionStorage.setItem(key, JSON.stringify(data));
        } catch (e) {
            console.warn('Storage save failed:', e);
        }
    }
}

function loadFromStorage(key) {
    if (STORAGE_AVAILABLE) {
        try {
            const data = sessionStorage.getItem(key);
            return data ? JSON.parse(data) : null;
        } catch (e) {
            console.warn('Storage load failed:', e);
        }
    }
    return null;
}

function clearSessionData() {
    console.log('🧹 Clearing session...');
    if (STORAGE_AVAILABLE) {
        for (let i = 1; i <= 7; i++) {
            sessionStorage.removeItem(`cat_${i}_answers`);
        }
    }
    userAnswers = {};
    pendingAnswers = [];
}

// ==================== UI HELPERS ====================

function showContentLoading(show) {
    const container = document.getElementById('question-container');
    const loader = document.getElementById('question-loading');
    if (container && loader) {
        if (show) {
            container.style.display = 'none';
            loader.style.display = 'flex';
        } else {
            container.style.display = 'block';
            loader.style.display = 'none';
        }
    }
}

function showAutoSaveStatus() {
    const el = document.getElementById('autosave-status');
    if (el) {
        el.classList.remove('hidden');
        el.innerText = 'Menyimpan...';
        setTimeout(() => el.innerText = 'Tersimpan', 1000);
        setTimeout(() => el.classList.add('hidden'), 3000);
    }
}

// ==================== INIT ====================

document.addEventListener('DOMContentLoaded', async () => {
    const created = await createPemeriksaan();
    if (created) {
        setTimeout(() => {
            const loading = document.getElementById('global-loading');
            if (loading) {
                loading.style.opacity = '0';
                setTimeout(() => loading.style.display = 'none', 500);
            }
            loadCategory(1);
        }, 1000);
    } else {
        alert('Gagal inisialisasi sistem. Silakan refresh.');
    }
});

// ==================== CORE FUNCTIONS ====================

async function loadCategory(catId) {
    showContentLoading(true);
    currentCategory = catId;
    
    // Restore jawaban dari storage
    const stored = loadFromStorage(`cat_${catId}_answers`);
    if (stored) {
        Object.assign(userAnswers, stored);
    }

    if (!quizData[catId]) await fetchPertanyaan(catId);

    const category = quizData[catId];
    
    const titleEl = document.getElementById('category-title');
    if (titleEl) {
        titleEl.style.opacity = 0;
        setTimeout(() => {
            titleEl.innerText = category.title;
            titleEl.style.opacity = 1;
        }, 300);
    }

    currentQuestions = category.questions;
    currentQIndex = 0;
    
    showContentLoading(false);
    renderCurrentQuestion();
}

function renderCurrentQuestion() {
    const q = currentQuestions[currentQIndex];
    const total = currentQuestions.length;
    
    const counterLarge = document.getElementById('question-counter-large');
    const mobileCounter = document.getElementById('mobile-counter');
    
    if (counterLarge) {
        counterLarge.innerHTML = `${currentQIndex + 1}<span class="text-teal-600 text-lg">/${total}</span>`;
    }
    if (mobileCounter) {
        mobileCounter.innerText = `${currentQIndex + 1} / ${total}`;
    }
    
    const progress = Math.round(((currentQIndex + 1) / total) * 100);
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    
    if (progressBar) progressBar.style.width = `${progress}%`;
    if (progressText) progressText.innerText = `${progress}%`;

    const qText = document.getElementById('q-text');
    if (qText) {
        qText.classList.remove('animate-fade-in-up');
        void qText.offsetWidth;
        qText.innerText = q.question;
        qText.classList.add('animate-fade-in-up');
    }

    const container = document.getElementById('options-container');
    if (!container) return;
    
    container.innerHTML = '';
    
    const savedAnswer = userAnswers[`${currentCategory}-${currentQIndex}`];

    q.options.forEach((opt, idx) => {
        const text = typeof opt === 'string' ? opt : opt.text;
        const isSelected = savedAnswer === text;

        const btn = document.createElement('button');
        btn.className = `
            w-full group relative p-4 md:p-5 rounded-2xl text-left border transition-all duration-300 ease-out
            flex items-center justify-between shadow-sm hover:shadow-md transform hover:-translate-y-1
            ${isSelected 
                ? 'bg-teal-50 border-teal-500 ring-1 ring-teal-500 z-10' 
                : 'bg-white border-gray-200 hover:border-teal-300 hover:bg-gray-50'}
        `;
        
        btn.style.animation = `fadeInUp 0.5s ease-out forwards ${idx * 100}ms`;
        btn.style.opacity = '0';

        btn.innerHTML = `
            <div class="flex items-center space-x-4">
                <div class="w-8 h-8 rounded-full flex items-center justify-center border transition-colors duration-300
                    ${isSelected ? 'bg-teal-600 border-teal-600 text-white' : 'bg-gray-100 border-gray-300 text-gray-400 group-hover:border-teal-400 group-hover:text-teal-500'}">
                    ${isSelected ? '<i class="fas fa-check text-xs"></i>' : '<span class="text-xs font-bold">' + String.fromCharCode(65 + idx) + '</span>'}
                </div>
                <span class="text-base md:text-lg font-medium ${isSelected ? 'text-teal-900' : 'text-gray-600 group-hover:text-gray-900'}">${text}</span>
            </div>
            ${isSelected ? '<span class="text-teal-600 text-sm font-semibold animate-pulse">Dipilih</span>' : ''}
        `;

        btn.onclick = () => selectOption(text);
        container.appendChild(btn);
    });

    const btnPrev = document.getElementById('btn-prev');
    if (btnPrev) {
        btnPrev.disabled = (currentQIndex === 0 && currentCategory === 1);
        btnPrev.style.opacity = btnPrev.disabled ? '0' : '1';
    }
}

function selectOption(val) {
    const key = `${currentCategory}-${currentQIndex}`;
    userAnswers[key] = val;
    
    // Simpan ke storage
    const catKey = `cat_${currentCategory}_answers`;
    const currentSessionData = loadFromStorage(catKey) || {};
    currentSessionData[key] = val;
    saveToStorage(catKey, currentSessionData);

    const q = currentQuestions[currentQIndex];
    let cf = (q.type === 'gejala' && q.nilai_map) ? q.nilai_map[val] : null;
    
    const payload = { type: q.type, id: q.id, answer: val, nilai: cf };
    
    const existingIdx = pendingAnswers.findIndex(p => p.id === q.id);
    if (existingIdx > -1) pendingAnswers[existingIdx] = payload;
    else pendingAnswers.push(payload);

    if (currentCategory === 1) {
        showAutoSaveStatus();
        scheduleSave();
    }

    renderCurrentQuestion();
    
    setTimeout(() => {
        nextQuestion();
    }, 400);
}

function nextQuestion() {
    if (!userAnswers[`${currentCategory}-${currentQIndex}`]) return;

    if (currentQIndex < currentQuestions.length - 1) {
        currentQIndex++;
        renderCurrentQuestion();
    } else {
        nextCategory();
    }
}

function prevQuestion() {
    if (currentQIndex > 0) {
        currentQIndex--;
        renderCurrentQuestion();
    } else if (currentCategory > 1) {
        loadCategory(currentCategory - 1);
    }
}

async function nextCategory() {
    if (isFinishing) return;

    if (currentCategory === 1) {
        await batchSaveJawaban(); 
    }
    
    if (currentCategory < 7) {
        loadCategory(currentCategory + 1);
    } else {
        finishExam();
    }
}

// ==================== API HANDLERS ====================

async function createPemeriksaan() {
    try {
        const res = await fetch('/api/pemeriksaan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({})
        });
        const data = await res.json();
        if (data.success) {
            idPemeriksaan = data.id_pemeriksaan;
            console.log('✅ Created:', idPemeriksaan);
            return true;
        }
    } catch (e) {
        console.error('❌ Create error:', e);
    }
    return false;
}

async function fetchPertanyaan(catId) {
    try {
        const res = await fetch(`/pertanyaan-api?kategori=${catId}`);
        const data = await res.json();
        if (data.success) {
            quizData[catId] = {
                title: categoryTitles[catId],
                questions: data.data.map(item => ({
                    id: item.id,
                    type: item.type,
                    question: item.question,
                    options: item.options,
                    nilai_map: (item.type === 'gejala' && item.options) 
                        ? item.options.reduce((acc, opt) => { 
                            acc[opt.text] = opt.nilai; 
                            return acc; 
                        }, {}) 
                        : null
                }))
            };
            console.log(`✅ Loaded cat ${catId}`);
        }
    } catch (e) {
        console.error('❌ Fetch error:', e);
    }
}

function scheduleSave() {
    clearTimeout(saveTimeout);
    saveTimeout = setTimeout(() => batchSaveJawaban(), 2000);
}

async function batchSaveJawaban() {
    const screening = pendingAnswers.filter(a => a.type === 'inklusi' || a.type === 'eksklusi');
    
    if (screening.length === 0 || !idPemeriksaan) return;

    try {
        const mapS = {};
        screening.forEach(a => { mapS[a.id] = a.answer; });
        
        pendingAnswers = pendingAnswers.filter(a => a.type !== 'inklusi' && a.type !== 'eksklusi');

        const res = await fetch('/api/screening', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({
                id_pemeriksaan: idPemeriksaan,
                jawaban: mapS
            })
        });
        
        const r = await res.json();
        
        if (r.lolos === false && currentCategory === 1) {
            console.log('❌ Screening failed');
            clearSessionData();
            alert(r.message || 'Maaf, Anda tidak lolos screening.');
            window.location.href = '/';
            return;
        }
        
        console.log('✅ Screening Saved');
    } catch (e) {
        console.error('❌ Save error:', e);
    }
}

// ==================== FINISH EXAM (FIXED) ====================

async function finishExam() {
    if (isFinishing) return;
    isFinishing = true;

    console.log('=== FINISH EXAM STARTED ===');
    console.log('ID Pemeriksaan:', idPemeriksaan);

    const container = document.getElementById('question-container');
    const optionsContainer = document.getElementById('options-container');
    
    if (!container) {
        console.error('Container not found!');
        isFinishing = false;
        return;
    }

    container.innerHTML = `
        <div class="flex flex-col items-center justify-center h-full py-20 animate-fade-in-up">
            <div class="w-24 h-24 bg-teal-50 rounded-full flex items-center justify-center mb-6 relative">
                <div class="absolute inset-0 rounded-full border-4 border-teal-100 border-t-teal-600 animate-spin"></div>
                <i class="fas fa-microchip text-teal-600 text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Sedang Menganalisis...</h2>
            <p class="text-gray-500 text-center max-w-md">Sistem Pakar sedang menghitung tingkat risiko CVS Anda.</p>
        </div>
    `;
    
    if (optionsContainer) {
        optionsContainer.innerHTML = '';
    }

    if (!idPemeriksaan) {
        alert('Error: ID Pemeriksaan tidak ditemukan');
        isFinishing = false;
        window.location.href = '/';
        return;
    }

    console.log('=== COLLECTING ALL ANSWERS ===');
    
    const allGejalaAnswers = [];
    
    for (let cat = 2; cat <= 7; cat++) {
        const storedKey = `cat_${cat}_answers`;
        const storedData = loadFromStorage(storedKey);
        
        if (storedData) {
            console.log(`✅ Category ${cat} from session:`, Object.keys(storedData).length, 'answers');
            Object.assign(userAnswers, storedData);
        }
        
        if (!quizData[cat]) {
            console.log(`⏳ Loading category ${cat}...`);
            await fetchPertanyaan(cat);
        }
        
        const category = quizData[cat];
        if (!category || !category.questions) {
            console.warn(`⚠️ Category ${cat} empty`);
            continue;
        }

        const questions = category.questions;
        
        for (let qIdx = 0; qIdx < questions.length; qIdx++) {
            const key = `${cat}-${qIdx}`;
            const answer = userAnswers[key];
            
            if (!answer) continue;

            const question = questions[qIdx];
            
            let nilaiCF = 0;
            if (question.nilai_map && question.nilai_map[answer]) {
                nilaiCF = question.nilai_map[answer];
            }

            console.log(`📊 ${key}: ID=${question.id}, Answer="${answer}", CF=${nilaiCF}`);

            allGejalaAnswers.push({
                type: 'gejala',
                id: question.id,
                answer: answer,
                nilai: nilaiCF
            });
        }
    }

    console.log('=== SUMMARY ===');
    console.log('📝 Total Answers:', allGejalaAnswers.length);

    if (allGejalaAnswers.length === 0) {
        alert('❌ Tidak ada jawaban yang tersimpan.\n\nSilakan ulangi pemeriksaan dari awal.');
        isFinishing = false;
        clearSessionData();
        window.location.href = '/pertanyaan';
        return;
    }

    try {
        console.log('🚀 SENDING TO BACKEND...');
        
        const response = await fetch('/api/pemeriksaan/submit-total', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                id_pemeriksaan: idPemeriksaan,
                jawaban: allGejalaAnswers
            })
        });

        console.log('📡 Response Status:', response.status);
        
        if (!response.ok) {
            const errorText = await response.text();
            console.error('❌ Server Error:', errorText);
            throw new Error(`Server error: ${response.status}`);
        }
        
        const result = await response.json();
        console.log('✅ Response Data:', result);

        if (result.success) {
            console.log('🎉 SUCCESS!');
            console.log('📊 Debug:', result.debug);
            
            clearSessionData();
            
            setTimeout(() => {
                window.location.href = result.redirect_url;
            }, 500);
            
        } else {
            throw new Error(result.message || 'Gagal memproses hasil');
        }

    } catch (error) {
        console.error('❌ CRITICAL ERROR:', error);
        isFinishing = false;
        
        container.innerHTML = `
            <div class="flex flex-col items-center justify-center h-full py-20 text-center">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Terjadi Kesalahan</h2>
                <p class="text-gray-600 mb-6 max-w-md">${error.message}</p>
                <button onclick="location.reload()" class="px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                    🔄 Coba Lagi
                </button>
            </div>
        `;
    }
}

// Panggil saat debugging (opsional)
// window.debugCurrentState = debugCurrentState;
</script>
@endsection