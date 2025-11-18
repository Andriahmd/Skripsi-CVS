{{-- resources/views/pertanyaan.blade.php --}}
@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="min-h-screen flex flex-col" style="background-color: #D7E7E5;">
        <div class="flex flex-1 overflow-hidden">
            <!-- Sidebar -->
            <div class="w-80 bg-white shadow-md p-6 overflow-y-auto shrink-0 rounded-r-2xl">
                @include('partials.sidebar')
            </div>

            <!-- Quiz Content -->
            <div class="flex-1 p-8 overflow-y-auto" id="quiz-scroll-container">
                <div class="space-y-8" id="quiz-container">
                    <div id="loading" class="text-center py-8">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-teal-600"></div>
                        <p class="mt-4 text-gray-600">Memuat pertanyaan...</p>
                    </div>
                </div>

                {{-- Buttons Container --}}
                <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200 bg-[#D7E7E5]/40 p-4 rounded-lg">
                    {{-- Tombol Reset (HANYA muncul di kategori 7) --}}
                    <button id="btn-reset" 
                        class="px-6 py-2 bg-red-600 text-white font-medium rounded-lg 
                               hover:bg-red-700 transition-all shadow-sm hover:shadow-md active:scale-95 hidden"
                        onclick="resetAllQuiz()">
                        <i class="fas fa-redo-alt mr-2"></i>
                        Ulangi Semua
                    </button>

                    {{-- Spacer --}}
                    <div id="btn-spacer"></div>

                    {{-- Tombol Next/Lihat Hasil --}}
                    <button id="btn-next" 
                        class="px-6 py-2 bg-teal-600 text-white font-medium rounded-lg 
                               hover:bg-teal-700 transition-all shadow-sm hover:shadow-md active:scale-95"
                        onclick="nextCategory()">
                        Selanjutnya
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

<script>
// ==================== CONFIGURATION ====================
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

let quizData = {};
let currentCategory = 1;
let userAnswers = {}; 
let completedQuizzes = []; 
let idPemeriksaan = null;
let pendingAnswers = [];
let saveTimeout = null;

// Judul kategori
const categoryTitles = {
    1: 'Kondisi Inklusi dan Eksklusi',
    2: 'Mata Lelah',
    3: 'Mata Kering',
    4: 'Mata Kabur',
    5: 'Mata Gatal',
    6: 'Mata Berair',
    7: 'Mata Sensitif'
};

// ==================== HELPER FUNCTIONS ====================
function showLoading() {
    const loading = document.getElementById('loading');
    if (loading) loading.style.display = 'block';
}

function hideLoading() {
    const loading = document.getElementById('loading');
    if (loading) loading.style.display = 'none';
}

function showLoadingModal(message = 'Loading...') {
    const oldModal = document.getElementById('loading-modal');
    if (oldModal) oldModal.remove();

    const modal = document.createElement('div');
    modal.id = 'loading-modal';
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-8 shadow-2xl">
            <div class="flex flex-col items-center">
                <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-teal-600 mb-4"></div>
                <p class="text-gray-700 font-medium text-lg">${message}</p>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

function hideLoadingModal() {
    const modal = document.getElementById('loading-modal');
    if (modal) modal.remove();
}

// ✅ FUNGSI BARU: Hapus data session agar user berikutnya bersih
function clearSessionData() {
    console.log('🧹 Cleaning up session data...');
    for (let i = 1; i <= 7; i++) {
        sessionStorage.removeItem(`cat_${i}_answers`);
    }
    userAnswers = {};
    completedQuizzes = [];
    pendingAnswers = [];
}

// ==================== API FUNCTIONS ====================
async function createPemeriksaan() {
    try {
        const response = await fetch('/api/pemeriksaan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({})
        });

        const result = await response.json();
        
        if (result.success) {
            idPemeriksaan = result.id_pemeriksaan;
            console.log('✓ Pemeriksaan created:', idPemeriksaan);
            return true;
        } else {
            console.error('Gagal create pemeriksaan:', result);
            return false;
        }
    } catch (error) {
        console.error('Error creating pemeriksaan:', error);
        return false;
    }
}

async function fetchPertanyaan(kategori) {
    try {
        isLoading = true;
        const response = await fetch(`/pertanyaan-api?kategori=${kategori}`);
        const result = await response.json();

        if (result.success) {
            quizData[kategori] = {
                title: categoryTitles[kategori] || 'Kategori',
                questions: result.data.map(item => ({
                    id: item.id,
                    type: item.type,
                    kode: item.kode || null,
                    question: item.question,
                    options: item.options,
                    nilai: item.type === 'gejala' && item.options 
                        ? item.options.reduce((acc, opt) => { acc[opt.text] = opt.nilai; return acc; }, {})
                        : null
                }))
            };
            isLoading = false;
            return true;
        }
    } catch (error) {
        console.error('Error fetching:', error);
        isLoading = false;
        return false;
    }
}

async function batchSaveJawaban() {
    if (pendingAnswers.length === 0 || !idPemeriksaan) return;

    const answersToSave = [...pendingAnswers];
    pendingAnswers = [];

    try {
        const screeningAnswers = answersToSave.filter(a => a.type === 'inklusi' || a.type === 'eksklusi');
        const gejalaAnswers = answersToSave.filter(a => a.type === 'gejala');

        // Simpan Screening
        if (screeningAnswers.length > 0 && currentCategory === 1) {
            const screeningData = {};
            screeningAnswers.forEach(a => { screeningData[a.id] = a.answer; });

            const resp = await fetch('/api/screening', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ id_pemeriksaan: idPemeriksaan, jawaban: screeningData })
            });
            
            const result = await resp.json();
            // Jika Gagal Screening
            if (result.lolos === false) {
                clearSessionData(); // ✅ Reset jika gagal screening
                alert(result.message || 'Mohon maaf, Anda tidak memenuhi kriteria.');
                window.location.href = '/'; 
                return;
            }
        }

        // Simpan Gejala
        if (gejalaAnswers.length > 0) {
            await fetch('/api/jawaban', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ id_pemeriksaan: idPemeriksaan, jawaban: gejalaAnswers })
            });
        }
    } catch (error) {
        console.error('❌ Error saving:', error);
        pendingAnswers = [...answersToSave, ...pendingAnswers]; // Kembalikan ke antrian jika gagal
    }
}

function scheduleSave() {
    clearTimeout(saveTimeout);
    saveTimeout = setTimeout(() => batchSaveJawaban(), 1000);
}

// ==================== UI & LOGIC ====================
function updateNextButton() {
    const btnNext = document.getElementById('btn-next');
    const btnReset = document.getElementById('btn-reset');
    
    if (!btnNext) return;

    if (currentCategory === 7) {
        if (btnReset) btnReset.classList.remove('hidden');
        btnNext.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Lihat Hasil Diagnosis';
        btnNext.classList.replace('bg-teal-600', 'bg-green-600');
        btnNext.classList.replace('hover:bg-teal-700', 'hover:bg-green-700');
    } else {
        if (btnReset) btnReset.classList.add('hidden');
        btnNext.innerHTML = 'Selanjutnya <i class="fas fa-arrow-right ml-2"></i>';
        btnNext.classList.replace('bg-green-600', 'bg-teal-600');
        btnNext.classList.replace('hover:bg-green-700', 'hover:bg-teal-700');
    }
}

function createQuestionElement(question, index, isCompleted, userAnswer) {
    const isActive = isCompleted || userAnswer;
    const questionDiv = document.createElement('div');
    questionDiv.className = `${isActive ? 'bg-green-50 border-green-200' : 'bg-white border-gray-200'} border-2 rounded-xl p-6 shadow-sm transition-all`;
    questionDiv.setAttribute('data-question-index', index);

    const optionsHTML = question.options.map((option) => {
        const optionText = typeof option === 'string' ? option : option.text;
        const isSelected = userAnswer === optionText;
        let className = isSelected 
            ? 'flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all bg-teal-100 border-teal-500 ring-2 ring-teal-200'
            : 'flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all bg-white border-gray-300 hover:border-teal-500 hover:bg-teal-50';

        return `
            <label class="${className}">
                <input type="radio" name="q${currentCategory}-${index}" value="${optionText}" 
                    ${isSelected ? 'checked' : ''} 
                    onchange="handleAnswerChange(${currentCategory}, ${index}, '${optionText}')" 
                    class="mr-3 w-4 h-4 accent-teal-600">
                <span class="text-gray-700">${optionText}</span>
            </label>
        `;
    }).join('');

    questionDiv.innerHTML = `
        <div class="flex items-start mb-4">
            <div class="w-8 h-8 ${isActive ? 'bg-green-500' : 'bg-gray-400'} rounded-full flex items-center justify-center mr-3 shrink-0 text-white font-bold text-sm">
                ${isActive ? '✓' : index + 1}
            </div>
            <div class="flex-1">
                <p class="text-gray-700 mb-4 font-medium">${question.question}</p>
                <div class="space-y-2">${optionsHTML}</div>
            </div>
        </div>
    `;
    return questionDiv;
}

function loadQuizContent() {
    const category = quizData[currentCategory];
    if (!category) return;

    const container = document.getElementById('quiz-container');
    container.innerHTML = ''; // Clear container

    const titleDiv = document.createElement('div');
    titleDiv.className = 'bg-gradient-to-r from-teal-500 to-teal-600 text-white p-6 rounded-xl shadow-lg mb-6';
    titleDiv.innerHTML = `<h2 class="text-2xl font-bold">${category.title}</h2><p class="text-teal-50">Kategori ${currentCategory} dari 7</p>`;
    container.appendChild(titleDiv);

    category.questions.forEach((q, i) => {
        const ans = userAnswers[`${currentCategory}-${i}`];
        container.appendChild(createQuestionElement(q, i, !!ans, ans));
    });
    
    updateProgress();
}

function updateQuestionUI(idx) {
    const div = document.querySelector(`[data-question-index="${idx}"]`);
    if (!div) return;

    div.classList.replace('bg-white', 'bg-green-50');
    div.classList.replace('border-gray-200', 'border-green-200');
    
    // Update Icon
    const icon = div.querySelector('.w-8.h-8');
    icon.className = 'w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3 shrink-0 text-white font-bold text-sm';
    icon.innerHTML = '✓';

    // Update Radio Styles
    div.querySelectorAll('label').forEach(lbl => {
        const inp = lbl.querySelector('input');
        if(inp.checked) {
            lbl.className = 'flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all bg-teal-100 border-teal-500 ring-2 ring-teal-200';
        } else {
            lbl.className = 'flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all bg-white border-gray-300 hover:border-teal-500 hover:bg-teal-50';
        }
    });
}

function updateProgress() {
    const total = quizData[currentCategory]?.questions.length || 0;
    const answered = Object.keys(userAnswers).filter(k => k.startsWith(`${currentCategory}-`)).length;
    const pct = total ? (answered / total) * 100 : 0;
    
    const bar = document.querySelector('.progress-bar');
    if (bar) bar.style.width = `${pct}%`;
    
    const txt = document.getElementById('progress-text');
    if (txt) txt.textContent = `${Math.round(pct)}%`;
}

function handleAnswerChange(catId, qIdx, val) {
    userAnswers[`${catId}-${qIdx}`] = val;
    sessionStorage.setItem(`cat_${catId}_answers`, JSON.stringify(userAnswers));
    
    const q = quizData[catId].questions[qIdx];
    let cf = (q.type === 'gejala' && q.nilai) ? q.nilai[val] : null;
    
    // Queue answer
    const exists = pendingAnswers.findIndex(a => a.id === q.id);
    if (exists > -1) pendingAnswers[exists] = { type: q.type, id: q.id, answer: val, nilai: cf };
    else pendingAnswers.push({ type: q.type, id: q.id, answer: val, nilai: cf });
    
    scheduleSave();
    updateQuestionUI(qIdx);
    updateProgress();
}

async function loadCategory(catId) {
    await batchSaveJawaban();
    currentCategory = catId;
    
    // Load from storage
    const stored = sessionStorage.getItem(`cat_${catId}_answers`);
    userAnswers = stored ? JSON.parse(stored) : {};
    
    if (!quizData[catId]) {
        showLoading();
        await fetchPertanyaan(catId);
        hideLoading();
    }
    
    loadQuizContent();
    updateNextButton();
    
    // Scroll to top
    document.getElementById('quiz-scroll-container')?.scrollTo({ top: 0, behavior: 'smooth' });
}

async function nextCategory() {
    const total = quizData[currentCategory]?.questions.length || 0;
    const answered = Object.keys(userAnswers).filter(k => k.startsWith(`${currentCategory}-`)).length;

    if (answered < total) {
        alert('Harap jawab semua pertanyaan sebelum melanjutkan.');
        return;
    }

    await batchSaveJawaban();

    if (currentCategory < 7) {
        await loadCategory(currentCategory + 1);
    } else {
        await hitungDanRedirect();
    }
}

// ✅ FUNGSI VITAL: Hitung dan Redirect
async function hitungDanRedirect() {
    if (!idPemeriksaan) {
        alert('Error: ID Pemeriksaan hilang. Silakan refresh.');
        return;
    }

    try {
        showLoadingModal('Menghitung Diagnosis...');
        
        // 1. Pastikan semua tersimpan
        await batchSaveJawaban();

        // 2. Panggil API
        const response = await fetch('/api/diagnosis', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ id_pemeriksaan: idPemeriksaan })
        });

        // 3. Cek Response
        // NOTE: Jika server return halaman HTML (error/redirect), response.json() akan fail
        const text = await response.text();
        let result;
        
        try {
            result = JSON.parse(text);
        } catch (e) {
            console.error('Server response not JSON:', text);
            throw new Error('Server error (Cek Console)');
        }

        if (result.success) {
            console.log('✅ Diagnosis selesai. Redirecting...');
            
            // ✅ RESET DATA SEBELUM PINDAH HALAMAN
            clearSessionData();

            // ✅ REDIRECT KE HALAMAN HASIL
            window.location.href = `/hasil/${idPemeriksaan}`;
        } else {
            throw new Error(result.message || 'Gagal menghitung.');
        }

    } catch (error) {
        hideLoadingModal();
        console.error('CRITICAL ERROR:', error);
        alert('Terjadi kesalahan: ' + error.message);
    }
}

function resetAllQuiz() {
    if(confirm('Ulangi dari awal?')) {
        clearSessionData();
        loadCategory(1);
    }
}

// Init
document.addEventListener('DOMContentLoaded', async () => {
    clearSessionData(); // Start fresh
    showLoading();
    const ok = await createPemeriksaan();
    hideLoading();
    if (ok) loadCategory(1);
    else window.location.href = '/';
});
</script>
@endsection