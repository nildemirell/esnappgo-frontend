<div class="min-h-screen bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Öğrenci Gelir Modeli Anketi</h1>
            <p class="text-gray-600">
                Öğrencilerin platform üzerinden gelir elde etme konusundaki görüşlerini öğrenmek istiyoruz
            </p>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-8">
            <?php if (!$current_user): ?>
                <!-- Not Logged In -->
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Giriş Yapmalısınız</h3>
                    <p class="text-gray-500 mb-6">Ankete katılmak için lütfen giriş yapın veya hesap oluşturun.</p>
                    <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
                        <a href="/login" class="btn btn-primary">Giriş Yap</a>
                        <a href="/register" class="btn btn-outline">Hesap Oluştur</a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Survey Form -->
                <form id="survey-form">
                    <!-- Question 1: Are you a student? -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            1. Şu anda üniversite öğrencisi misiniz?
                        </h3>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input
                                    type="radio"
                                    name="is_student"
                                    value="true"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                    required
                                    onchange="toggleStudentQuestions(true)"
                                />
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Evet, üniversite öğrencisiyim</div>
                                    <div class="text-xs text-gray-500">Aktif olarak üniversite eğitimi alıyorum</div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input
                                    type="radio"
                                    name="is_student"
                                    value="false"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                    required
                                    onchange="toggleStudentQuestions(false)"
                                />
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Hayır, öğrenci değilim</div>
                                    <div class="text-xs text-gray-500">Mezun oldum veya hiç üniversite okumadım</div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Question 2: Interest in earning (only for students) -->
                    <div id="student-questions" class="mb-8" style="display: none;">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            2. EsnappGO platformu üzerinden ürün fotoğrafları çekerek gelir elde etmek ister misiniz?
                        </h3>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input
                                    type="radio"
                                    name="is_interested"
                                    value="true"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                />
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Evet, çok ilgimi çekiyor</div>
                                    <div class="text-xs text-gray-500">Ürün fotoğrafları çekerek para kazanmak istiyorum</div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input
                                    type="radio"
                                    name="is_interested"
                                    value="false"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                />
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Hayır, ilgimi çekmiyor</div>
                                    <div class="text-xs text-gray-500">Bu tür bir gelir modeliyle ilgilenmiyorum</div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Information Box -->
                    <div class="bg-blue-50 p-6 rounded-lg mb-8">
                        <h4 class="text-lg font-medium text-blue-900 mb-3">EsnappGO Nasıl Çalışır?</h4>
                        <ul class="space-y-2 text-sm text-blue-800">
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Öğrenciler sahada ürün fotoğrafları çeker
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Yerel esnaflar ürünleri onaylar ve fiyatlandırır
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Müşteriler güvenle alışveriş yapar
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Öğrenciler her satıştan %10 pay alır
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="text-center">
                        <button
                            type="submit"
                            id="submit-btn"
                            class="btn btn-primary btn-lg px-8"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            <span id="submit-text">Anketi Gönder</span>
                        </button>
                    </div>
                </form>
                
                <!-- Thank You Message -->
                <div id="thank-you-message" class="text-center py-12" style="display: none;">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Teşekkürler!</h3>
                    <p class="text-gray-600 mb-6">
                        Anket cevabınız başarıyla kaydedildi. Görüşleriniz bizim için çok değerli.
                    </p>
                    <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
                        <a href="/products" class="btn btn-primary">Ürünleri İncele</a>
                        <a href="/" class="btn btn-outline">Ana Sayfaya Dön</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Survey Results Widget -->
        <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Anket Sonuçları</h3>
            <div id="survey-results" class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Toplam katılımcı</span>
                    <span class="font-medium" id="total-responses">-</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Öğrenci katılımcı</span>
                    <span class="font-medium" id="student-responses">-</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">İlgilenen öğrenci</span>
                    <span class="font-medium text-green-600" id="interested-students">-</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadSurveyResults();
    
    const form = document.getElementById('survey-form');
    if (form) {
        form.addEventListener('submit', handleSurveySubmit);
    }
});

function toggleStudentQuestions(isStudent) {
    const studentQuestions = document.getElementById('student-questions');
    if (isStudent) {
        studentQuestions.style.display = 'block';
        // Make the interest question required
        const interestInputs = document.querySelectorAll('input[name="is_interested"]');
        interestInputs.forEach(input => input.required = true);
    } else {
        studentQuestions.style.display = 'none';
        // Remove required attribute and clear selection
        const interestInputs = document.querySelectorAll('input[name="is_interested"]');
        interestInputs.forEach(input => {
            input.required = false;
            input.checked = false;
        });
    }
}

async function handleSurveySubmit(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submit-btn');
    const submitText = document.getElementById('submit-text');
    
    // Disable button
    submitBtn.disabled = true;
    submitText.textContent = 'Gönderiliyor...';
    
    try {
        const formData = new FormData(e.target);
        const isStudent = formData.get('is_student') === 'true';
        const isInterested = formData.get('is_interested') === 'true' || null;
        
        const data = {
            survey_id: 1,
            is_student: isStudent,
            is_interested: isStudent ? isInterested : null
        };
        
        const response = await apiCall('survey', {
            method: 'POST',
            body: JSON.stringify(data)
        });
        
        if (response.success) {
            // Hide form and show thank you message
            document.getElementById('survey-form').style.display = 'none';
            document.getElementById('thank-you-message').style.display = 'block';
            
            // Reload survey results
            setTimeout(() => {
                loadSurveyResults();
            }, 1000);
        }
        
    } catch (error) {
        showToast(error.message, 'error');
        
        // Re-enable button
        submitBtn.disabled = false;
        submitText.textContent = 'Anketi Gönder';
    }
}

async function loadSurveyResults() {
    try {
        // Mock data for now - in a real implementation, this would come from an API
        const mockResults = {
            total_responses: 247,
            student_responses: 189,
            interested_students: 156
        };
        
        document.getElementById('total-responses').textContent = mockResults.total_responses;
        document.getElementById('student-responses').textContent = mockResults.student_responses;
        document.getElementById('interested-students').textContent = mockResults.interested_students;
        
    } catch (error) {
        console.error('Error loading survey results:', error);
    }
}
</script>
