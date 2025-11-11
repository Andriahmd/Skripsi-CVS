@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col" style="background-color: #D7E7E5;">

        <!-- Main Content -->
        <div class="flex flex-1 overflow-hidden">
            <!-- Sidebar -->
            <div class="w-80 bg-white shadow-md p-6 overflow-y-auto shrink-0 rounded-r-2xl">
                @include('partials.sidebar')
            </div>

            <!-- Quiz Content -->
            <div class="flex-1 p-8 overflow-y-auto" id="quiz-scroll-container">
                <div class="space-y-8" id="quiz-container"></div>

                <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200 bg-[#D7E7E5]/40 p-4 rounded-lg">
                    <!-- Tombol Ulangi Kuis -->
                    <button class="px-6 py-2 bg-white text-gray-800 font-medium rounded-lg border border-gray-300 
                       hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-200 
                       transition-all duration-300 shadow-sm hover:shadow-md active:scale-95" 
                       onclick="resetQuiz()">
                        <i class="fas fa-redo-alt mr-2"></i>
                        Ulangi Kuis
                    </button>

                    <!-- Tombol Selanjutnya - WARNA HIJAU TEAL JADE -->
                    <button class="px-6 py-2 bg-teal-600 text-white font-medium rounded-lg border border-transparent 
                       hover:bg-teal-700 focus:bg-teal-700 active:bg-teal-800 
                       transition-all duration-300 shadow-sm hover:shadow-md active:scale-95" 
                       onclick="nextCategory()">
                        Selanjutnya
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Data kuis lengkap
        const quizData = {
            1: {
                title: "Pengecekan Kondisi Inklusi dan Eksklusi Pasien",
                questions: [
                    {
                        question: "CVS biasanya didiagnosis jika gejala muncul setelah paparan layar lebih dari 2 jam per hari.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Ya, inclusion criteria untuk CVS termasuk gejala setelah penggunaan layar digital yang berkepanjangan."
                    },
                    {
                        question: "Kondisi seperti infeksi mata harus dieksklusi sebelum diagnosis CVS.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Benar, exclusion criteria termasuk kondisi medis lain seperti infeksi atau alergi yang bisa meniru gejala CVS."
                    },
                    {
                        question: "Riwayat penggunaan layar digital tidak diperlukan untuk diagnosis CVS.",
                        options: ["Benar", "Salah"],
                        correct: 1,
                        explanation: "Salah, riwayat exposure screen adalah kunci inclusion criteria untuk CVS."
                    },
                    {
                        question: "Anak-anak dengan gejala CVS mungkin menunjukkan iritabilitas dan perhatian rendah.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Benar, gejala pada anak termasuk reduced attention span dan irritability sebagai inclusion."
                    }
                ]
            },
            2: {
                title: "Mata Lelah",
                questions: [
                    {
                        question: "Mata lelah adalah gejala utama CVS yang disebabkan oleh fokus berkepanjangan pada layar.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Ya, eye strain atau mata lelah adalah salah satu gejala visual utama CVS."
                    },
                    {
                        question: "Mata lelah dalam CVS sering disertai sakit kepala.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Benar, headache sering terkait dengan eye strain di CVS."
                    },
                    {
                        question: "Mata lelah hanya terjadi pada orang dengan masalah penglihatan preexisting.",
                        options: ["Benar", "Salah"],
                        correct: 1,
                        explanation: "Salah, siapa pun bisa mengalami mata lelah dari penggunaan layar berlebih."
                    },
                    {
                        question: "Aturan 20-20-20 dapat membantu mengurangi mata lelah.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Benar, istirahat setiap 20 menit dengan melihat 20 feet selama 20 detik direkomendasikan."
                    }
                ]
            },
            3: {
                title: "Mata Kering",
                questions: [
                    {
                        question: "Mata kering di CVS disebabkan oleh berkurangnya frekuensi kedipan saat melihat layar.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Ya, reduced blink rate menyebabkan dry eyes sebagai gejala ocular CVS."
                    },
                    {
                        question: "Gejala mata kering termasuk sensasi terbakar atau iritasi.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Benar, burning eyes dan redness adalah bagian dari dry eyes di CVS."
                    },
                    {
                        question: "Mata kering tidak bisa dieksklusi dari CVS jika ada faktor lingkungan seperti AC.",
                        options: ["Benar", "Salah"],
                        correct: 1,
                        explanation: "Salah, faktor lingkungan bisa berkontribusi, tapi CVS fokus pada screen-related."
                    },
                    {
                        question: "Obat tetes mata dapat membantu mengatasi mata kering di CVS.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Benar, artificial tears adalah intervensi umum untuk dry eyes."
                    }
                ]
            },
            4: {
                title: "Mata Kabur",
                questions: [
                    {
                        question: "Blurred vision adalah gejala visual utama CVS karena akomodasi mata yang konstan.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Ya, constant focusing on screens menyebabkan blurred vision."
                    },
                    {
                        question: "Mata kabur di CVS bisa menjadi double vision.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Benar, double vision adalah variasi dari blurred vision di CVS."
                    },
                    {
                        question: "Mata kabur selalu menandakan masalah refraksi seperti astigmatism.",
                        options: ["Benar", "Salah"],
                        correct: 1,
                        explanation: "Salah, di CVS, itu sering sementara karena fatigue, bukan permanen."
                    },
                    {
                        question: "Penyesuaian jarak layar dapat mengurangi mata kabur.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Benar, jarak arm's length direkomendasikan untuk mengurangi strain."
                    }
                ]
            },
            5: {
                title: "Mata Berair",
                questions: [
                    {
                        question: "Mata berair bisa menjadi gejala CVS karena overcompensation dari mata kering.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Ya, excessive tearing adalah respons terhadap dry eyes di CVS."
                    },
                    {
                        question: "Mata berair di CVS sering disertai red eyes.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Benar, redness and irritation bisa memicu tearing."
                    },
                    {
                        question: "Mata berair selalu menandakan alergi, bukan CVS.",
                        options: ["Benar", "Salah"],
                        correct: 1,
                        explanation: "Salah, di CVS, itu bisa dari screen exposure tanpa alergi."
                    },
                    {
                        question: "Humidifier dapat membantu mengurangi mata berair di CVS.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Benar, meningkatkan kelembapan udara membantu gejala ocular."
                    }
                ]
            },
            6: {
                title: "Mata Gatal",
                questions: [
                    {
                        question: "Mata gatal di CVS disebabkan oleh iritasi dari reduced blink rate.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Ya, itchy eyes adalah gejala ocular di CVS."
                    },
                    {
                        question: "Mata gatal bisa disertai foreign body sensation.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Benar, sensasi benda asing sering terkait."
                    },
                    {
                        question: "Mata gatal selalu exclusion dari CVS karena mirip alergi.",
                        options: ["Benar", "Salah"],
                        correct: 1,
                        explanation: "Salah, bisa inclusion jika terkait screen use."
                    },
                    {
                        question: "Cold compress dapat meredakan mata gatal.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Benar, kompres dingin adalah intervensi sederhana."
                    }
                ]
            },
            7: {
                title: "Mata Sensitif",
                questions: [
                    {
                        question: "Mata sensitif terhadap cahaya (photophobia) adalah gejala CVS.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Ya, sensitivity to light sering terjadi di CVS."
                    },
                    {
                        question: "Mata sensitif di CVS bisa disebabkan oleh glare dari layar.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Benar, glare exacerbates symptoms."
                    },
                    {
                        question: "Mata sensitif selalu menandakan migrain, bukan CVS.",
                        options: ["Benar", "Salah"],
                        correct: 1,
                        explanation: "Salah, di CVS, itu bisa independen."
                    },
                    {
                        question: "Filter anti-glare pada layar dapat membantu.",
                        options: ["Benar", "Salah"],
                        correct: 0,
                        explanation: "Benar, mengurangi glare mengurangi sensitivitas."
                    }
                ]
            }
        };

        let currentCategory = 1;
        let userAnswers = {};
        let correctAnswers = 0;
        let completedQuizzes = [];
        let hasModalShown = false; // Flag untuk cek modal udah muncul

        // 🚀 LANGSUNG LOAD KATEGORI 1 SAAT HALAMAN DIBUKA
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('userModal');
            
            // Cek apakah ada modal
            if (modal) {
                modal.style.display = 'flex';
                hasModalShown = true;
            } else {
                // Kalau ga ada modal, langsung load kategori 1
                loadCategory(1);
            }
        });

        // Handle submit form modal
        const userForm = document.getElementById('userForm');
        if (userForm) {
            userForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const name = document.getElementById('userName').value.trim();
                const age = document.getElementById('userAge').value;

                if (name && age) {
                    const modal = document.getElementById('userModal');
                    if (modal) {
                        modal.style.display = 'none';
                    }
                    
                    // 🚀 LANGSUNG LOAD KATEGORI 1 SETELAH SUBMIT MODAL
                    loadCategory(1);
                }
            });
        }

        function toggleCategory(categoryId) {
            loadCategory(categoryId);
        }

        function loadCategory(categoryId) {
            currentCategory = categoryId;
            completedQuizzes = [];
            correctAnswers = 0;
            userAnswers = {};

            // Update active state di sidebar
            document.querySelectorAll('.quiz-category').forEach(cat => {
                cat.classList.remove('active');
            });
            const activeEl = document.querySelector(`[data-category="${categoryId}"]`);
            if (activeEl) activeEl.classList.add('active');

            // Update style button sidebar
            document.querySelectorAll('.quiz-category button').forEach(btn => {
                const catId = btn.closest('.quiz-category')?.dataset.category;
                if (!catId) return;
                
                const isActive = parseInt(catId) === categoryId;
                const icon = btn.querySelector('svg.w-4.h-4');
                const iconDiv = icon?.closest('div');
                
                if (isActive) {
                    btn.classList.add('bg-teal-100', 'border-teal-300');
                    btn.classList.remove('bg-white', 'border-gray-200');
                    btn.querySelector('span')?.classList.add('font-semibold', 'text-teal-800');
                    if (iconDiv) {
                        iconDiv.className = 'w-6 h-6 bg-teal-600 rounded-full flex items-center justify-center';
                    }
                    if (icon) {
                        icon.innerHTML = '<svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
                    }
                } else {
                    btn.classList.remove('bg-teal-100', 'border-teal-300');
                    btn.classList.add('bg-white', 'border-gray-200');
                    btn.querySelector('span')?.classList.remove('font-semibold', 'text-teal-800');
                    if (iconDiv) {
                        iconDiv.className = 'w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center text-white shrink-0';
                    }
                    if (icon) {
                        icon.innerHTML = `<span class="text-xs font-bold">${catId}</span>`;
                    }
                }
            });

            loadQuizContent();
            
            // Scroll to top
            const scrollContainer = document.getElementById('quiz-scroll-container');
            if (scrollContainer) {
                scrollContainer.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        function loadQuizContent() {
            const category = quizData[currentCategory];
            const quizContainer = document.getElementById('quiz-container');
            quizContainer.innerHTML = '';

            // Tampilkan judul kategori
            const titleDiv = document.createElement('div');
            titleDiv.className = 'bg-gradient-to-r from-teal-500 to-teal-600 text-white p-6 rounded-xl shadow-lg mb-6';
            titleDiv.innerHTML = `
                <h2 class="text-2xl font-bold mb-2">${category.title}</h2>
                <p class="text-teal-50">Kategori ${currentCategory} dari 7</p>
            `;
            quizContainer.appendChild(titleDiv);

            category.questions.forEach((question, index) => {
                const isCompleted = completedQuizzes.includes(index + 1);
                const userAnswer = userAnswers[`${currentCategory}-${index}`];

                const questionDiv = document.createElement('div');
                questionDiv.className = `${isCompleted ? 'bg-green-50 border-green-200' : 'bg-white border-gray-200'} border rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow`;
                questionDiv.setAttribute('data-question-index', index);

                questionDiv.innerHTML = `
                    <div class="flex items-start mb-4">
                        <div class="w-8 h-8 ${isCompleted ? 'bg-green-500' : 'bg-gray-400'} rounded-full flex items-center justify-center mr-3 shrink-0">
                            ${isCompleted ?
                        '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>' :
                        `<span class="text-white text-sm font-bold">${index + 1}</span>`
                    }
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-3">Pertanyaan ${index + 1}</h3>
                            <p class="text-gray-700 mb-4 leading-relaxed">${question.question}</p>
                            <div class="space-y-2">
                                ${question.options.map((option, optIndex) => {
                        const isCorrect = optIndex === question.correct;
                        const isSelected = userAnswer === optIndex;
                        const showResult = isCompleted;
                        let className = 'flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all';
                        
                        if (showResult && isSelected && isCorrect) {
                            className += ' bg-green-100 border-green-400';
                        } else if (showResult && isSelected && !isCorrect) {
                            className += ' bg-red-100 border-red-400';
                        } else if (showResult && isCorrect) {
                            className += ' bg-green-100 border-green-400';
                        } else {
                            className += ' bg-white border-gray-300 hover:border-teal-500 hover:bg-teal-50';
                        }

                        return `
                                    <label class="${className}">
                                        <input type="radio" name="quiz${currentCategory}-${index}" value="${optIndex}" 
                                            ${isSelected ? 'checked' : ''} ${showResult ? 'disabled' : ''}
                                            onchange="handleAnswerChange(${currentCategory}, ${index}, ${optIndex})" 
                                            class="mr-3 w-4 h-4 accent-teal-600">
                                        <span class="${showResult && (isSelected || isCorrect) ? 'text-gray-900 font-medium' : 'text-gray-700'}">${option}</span>
                                    </label>
                                `;
                    }).join('')}
                            </div>
                            ${isCompleted ? `
                                <div class="mt-4 p-4 ${userAnswer === question.correct ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200'} border rounded-lg">
                                    <p class="${userAnswer === question.correct ? 'text-green-700' : 'text-red-700'} font-semibold mb-2">
                                        ${userAnswer === question.correct ? '✓ Jawaban Benar!' : '✗ Jawaban Salah'}
                                    </p>
                                    ${question.explanation ? `
                                        <p class="text-sm text-gray-700 leading-relaxed"><strong>Penjelasan:</strong> ${question.explanation}</p>
                                    ` : ''}
                                </div>
                            ` : ''}
                        </div>
                    </div>
                `;
                quizContainer.appendChild(questionDiv);
            });

            updateProgress();
        }

        function handleAnswerChange(categoryId, questionIndex, answerIndex) {
            userAnswers[`${categoryId}-${questionIndex}`] = answerIndex;
            setTimeout(() => submitAnswer(categoryId, questionIndex, answerIndex), 300);
        }

        function submitAnswer(categoryId, questionIndex, answerIndex) {
            const question = quizData[categoryId].questions[questionIndex];
            const isCorrect = answerIndex === question.correct;
            if (isCorrect && !completedQuizzes.includes(questionIndex + 1)) {
                correctAnswers++;
            }
            if (!completedQuizzes.includes(questionIndex + 1)) {
                completedQuizzes.push(questionIndex + 1);
            }
            
            setTimeout(() => {
                loadQuizContent();
                
                setTimeout(() => {
                    const scrollContainer = document.getElementById('quiz-scroll-container');
                    const nextQuestionIndex = questionIndex + 1;
                    const nextQuestion = document.querySelector(`[data-question-index="${nextQuestionIndex}"]`);
                    
                    if (nextQuestion && scrollContainer) {
                        const questionTop = nextQuestion.offsetTop;
                        const offset = 150;
                        
                        scrollContainer.scrollTo({ 
                            top: questionTop - offset, 
                            behavior: 'smooth' 
                        });
                    }
                }, 150);
            }, 300);
        }

        function updateProgress() {
            const totalCount = quizData[currentCategory].questions.length;
            const correctCountEl = document.getElementById('correct-count');
            const totalCountEl = document.getElementById('total-count');
            const progressText = document.getElementById('progress-text');
            const progressBar = document.querySelector('.progress-bar');
            
            if (correctCountEl) correctCountEl.textContent = correctAnswers;
            if (totalCountEl) totalCountEl.textContent = totalCount;
            
            const progressPercent = totalCount ? (correctAnswers / totalCount) * 100 : 0;
            
            if (progressBar) progressBar.style.width = `${Math.min(progressPercent, 100)}%`;
            if (progressText) progressText.textContent = `${Math.round(progressPercent)}%`;
        }

        function resetQuiz() {
            userAnswers = {};
            correctAnswers = 0;
            completedQuizzes = [];
            loadQuizContent();
            
            const scrollContainer = document.getElementById('quiz-scroll-container');
            if (scrollContainer) {
                scrollContainer.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        function nextCategory() {
            const nextCat = currentCategory + 1;
            if (nextCat <= 7) {
                loadCategory(nextCat);
            } else {
                // Alert lebih menarik
                const totalQuestions = Object.keys(quizData).length * 4; // 7 kategori x 4 pertanyaan
                alert(`🎉 Selamat!\n\nAnda telah menyelesaikan semua ${totalQuestions} pertanyaan dalam 7 kategori!\n\nTerima kasih telah mengikuti diagnosis CVS.`);
            }
        }
    </script>
@endsection