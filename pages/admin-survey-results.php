<?php
// Admin kontrolü
if (!$current_user || $current_user['role'] !== 'admin') {
    header('Location: /login');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                <a href="/admin" class="hover:text-gray-700">Admin</a>
                <span>/</span>
                <span class="text-gray-900">Anket Sonuçları</span>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Anket Sonuçları</h1>
                    <p class="text-gray-600">Öğrenci gelir modeli anketi analizi</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="auto-refresh" class="mr-2" onchange="toggleAutoRefresh()">
                        <label for="auto-refresh" class="text-sm text-gray-600">Otomatik yenile (30s)</label>
                    </div>
                    <button onclick="refreshData()" class="btn btn-outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Yenile
                    </button>
                </div>
            </div>
            <div id="last-updated" class="text-xs text-gray-500 mt-2"></div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Toplam Katılımcı</p>
                        <p class="text-2xl font-bold text-gray-900" id="total-responses">-</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Öğrenci Katılımcı</p>
                        <p class="text-2xl font-bold text-gray-900" id="student-responses">-</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">İlgilenen Öğrenci</p>
                        <p class="text-2xl font-bold text-gray-900" id="interested-students">-</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Dönüşüm Oranı</p>
                        <p class="text-2xl font-bold text-gray-900" id="conversion-rate">-%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Response Distribution -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Katılımcı Dağılımı</h3>
                <div id="response-chart" class="h-64 flex items-center justify-center">
                    <div class="text-center text-gray-500">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Veriler yükleniyor...
                    </div>
                </div>
            </div>

            <!-- Interest Distribution -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Öğrenci İlgi Dağılımı</h3>
                <div id="interest-chart" class="h-64 flex items-center justify-center">
                    <div class="text-center text-gray-500">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        Veriler yükleniyor...
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Results -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Detaylı Sonuçlar</h3>
                <div class="flex space-x-2">
                    <button onclick="setActiveTab('summary')" class="tab-btn active px-4 py-2 text-sm rounded-md">
                        Özet
                    </button>
                    <button onclick="setActiveTab('responses')" class="tab-btn px-4 py-2 text-sm rounded-md">
                        Yanıtlar
                    </button>
                    <button onclick="setActiveTab('export')" class="tab-btn px-4 py-2 text-sm rounded-md">
                        Dışa Aktar
                    </button>
                </div>
            </div>

            <!-- Summary Tab -->
            <div id="summary-tab" class="tab-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Key Insights -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Temel Bulgular</h4>
                        <div class="space-y-4">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <h5 class="font-medium text-blue-900">Katılım Oranı</h5>
                                        <p class="text-sm text-blue-700" id="participation-insight">-</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <h5 class="font-medium text-green-900">İlgi Düzeyi</h5>
                                        <p class="text-sm text-green-700" id="interest-insight">-</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    <div>
                                        <h5 class="font-medium text-purple-900">Potansiyel</h5>
                                        <p class="text-sm text-purple-700" id="potential-insight">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Demographics -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Demografik Dağılım</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">Öğrenci Katılımcılar</span>
                                <div class="flex items-center">
                                    <div class="w-20 bg-gray-200 rounded-full h-2 mr-3">
                                        <div id="student-bar" class="bg-green-500 h-2 rounded-full" style="width: 0%"></div>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900" id="student-percentage">0%</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">İlgilenen Öğrenciler</span>
                                <div class="flex items-center">
                                    <div class="w-20 bg-gray-200 rounded-full h-2 mr-3">
                                        <div id="interested-bar" class="bg-purple-500 h-2 rounded-full" style="width: 0%"></div>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900" id="interested-percentage">0%</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">İlgilenmeyen Öğrenciler</span>
                                <div class="flex items-center">
                                    <div class="w-20 bg-gray-200 rounded-full h-2 mr-3">
                                        <div id="not-interested-bar" class="bg-red-500 h-2 rounded-full" style="width: 0%"></div>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900" id="not-interested-percentage">0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Responses Tab -->
            <div id="responses-tab" class="tab-content" style="display: none;">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kullanıcı
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Öğrenci mi?
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    İlgili mi?
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tarih
                                </th>
                            </tr>
                        </thead>
                        <tbody id="responses-table-body" class="bg-white divide-y divide-gray-200">
                            <!-- Loading rows -->
                            <?php for ($i = 0; $i < 5; $i++): ?>
                            <tr class="animate-pulse">
                                <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-32"></div></td>
                                <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-16"></div></td>
                                <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-16"></div></td>
                                <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-24"></div></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Export Tab -->
            <div id="export-tab" class="tab-content" style="display: none;">
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Veri Dışa Aktarma</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <button onclick="exportCSV()" class="btn btn-outline">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                CSV Olarak İndir
                            </button>
                            

                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h5 class="font-medium text-blue-900 mb-2">CSV İçeriği</h5>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Tüm kullanıcı yanıtları (Excel uyumlu)</li>
                            <li>• Kullanıcı adı, email, öğrenci durumu</li>
                            <li>• İlgi durumu ve katılım tarihi</li>
                            <li>• Türkçe karakter desteği</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let surveyData = {
    total_responses: 0,
    student_responses: 0,
    non_student_responses: 0,
    interested_students: 0,
    not_interested_students: 0,
    conversion_rate: 0
};

let responses = [];
let autoRefreshInterval = null;
let activeTab = 'summary';

document.addEventListener('DOMContentLoaded', function() {
    loadSurveyData();
});

async function loadSurveyData() {
    try {
        // Gerçek API'den veri çek
        const [statsResponse, responsesResponse] = await Promise.all([
            apiCall('survey/stats'),
            apiCall('survey/responses')
        ]);

        if (statsResponse.success) {
            surveyData = statsResponse.data;
        } else {
            console.log('Stats API failed, using fallback');
            surveyData = {
                total_responses: 0,
                student_responses: 0,
                non_student_responses: 0,
                interested_students: 0,
                not_interested_students: 0,
                conversion_rate: 0
            };
        }

        if (responsesResponse.success) {
            responses = responsesResponse.data;
        } else {
            console.log('Responses API failed, using empty array');
            responses = [];
        }
        
        displayStats();
        displayCharts();
        displayResponses();
        
        document.getElementById('last-updated').textContent = `Son güncelleme: ${new Date().toLocaleString('tr-TR')}`;
        
    } catch (error) {
        console.error('Error loading survey data:', error);
        showToast('Anket verileri yüklenirken hata oluştu: ' + error.message, 'error');
        
        // Fallback data
        surveyData = {
            total_responses: 0,
            student_responses: 0,
            non_student_responses: 0,
            interested_students: 0,
            not_interested_students: 0,
            conversion_rate: 0
        };
        responses = [];
        
        displayStats();
        displayCharts();
        displayResponses();
    }
}

function displayStats() {
    const safePercentage = (numerator, denominator) => {
        if (!denominator || denominator === 0) return 0;
        return ((numerator || 0) / denominator * 100).toFixed(1);
    };
    
    // Ana istatistikleri güvenli şekilde göster
    document.getElementById('total-responses').textContent = safeValue(surveyData.total_responses).toLocaleString();
    document.getElementById('student-responses').textContent = safeValue(surveyData.student_responses).toLocaleString();
    document.getElementById('interested-students').textContent = safeValue(surveyData.interested_students).toLocaleString();
    document.getElementById('conversion-rate').textContent = `${safeValue(surveyData.conversion_rate).toFixed(1)}%`;

    // Update insights
    const studentPercentage = safePercentage(surveyData.student_responses, surveyData.total_responses);
    const interestPercentage = safePercentage(surveyData.interested_students, surveyData.student_responses);
    
    document.getElementById('participation-insight').textContent = `Katılımcıların %${studentPercentage}'i öğrenci`;
    document.getElementById('interest-insight').textContent = `Öğrencilerin %${interestPercentage}'i ilgili`;
    document.getElementById('potential-insight').textContent = `${safeValue(surveyData.interested_students)} potansiyel öğrenci partneri`;

    // Update progress bars
    document.getElementById('student-bar').style.width = `${studentPercentage}%`;
    document.getElementById('student-percentage').textContent = `${studentPercentage}%`;
    
    const interestedPercentage = safePercentage(surveyData.interested_students, surveyData.student_responses);
    document.getElementById('interested-bar').style.width = `${interestedPercentage}%`;
    document.getElementById('interested-percentage').textContent = `${interestedPercentage}%`;
    
    const notInterestedPercentage = safePercentage(surveyData.not_interested_students, surveyData.student_responses);
    document.getElementById('not-interested-bar').style.width = `${notInterestedPercentage}%`;
    document.getElementById('not-interested-percentage').textContent = `${notInterestedPercentage}%`;
}

function displayCharts() {
    const safeHeight = (numerator, denominator, maxHeight = 200) => {
        if (!denominator || denominator === 0) return 10; // Minimum görünürlük için
        return Math.max(10, (safeValue(numerator) / denominator) * maxHeight);
    };
    
    // Simple bar chart for response distribution
    const responseChart = document.getElementById('response-chart');
    const totalResponses = safeValue(surveyData.total_responses);
    const studentResponses = safeValue(surveyData.student_responses);
    const nonStudentResponses = safeValue(surveyData.non_student_responses);
    
    responseChart.innerHTML = `
        <div class="w-full h-full flex items-end justify-around p-4">
            <div class="flex flex-col items-center">
                <div class="bg-blue-500 rounded-t w-16 mb-2" style="height: ${safeHeight(studentResponses, totalResponses)}px;"></div>
                <span class="text-xs text-gray-600">Öğrenci</span>
                <span class="text-xs font-bold">${studentResponses}</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="bg-gray-500 rounded-t w-16 mb-2" style="height: ${safeHeight(nonStudentResponses, totalResponses)}px;"></div>
                <span class="text-xs text-gray-600">Diğer</span>
                <span class="text-xs font-bold">${nonStudentResponses}</span>
            </div>
        </div>
    `;

    // Interest chart
    const interestChart = document.getElementById('interest-chart');
    const interestedStudents = safeValue(surveyData.interested_students);
    const notInterestedStudents = safeValue(surveyData.not_interested_students);
    
    interestChart.innerHTML = `
        <div class="w-full h-full flex items-end justify-around p-4">
            <div class="flex flex-col items-center">
                <div class="bg-green-500 rounded-t w-16 mb-2" style="height: ${safeHeight(interestedStudents, studentResponses)}px;"></div>
                <span class="text-xs text-gray-600">İlgili</span>
                <span class="text-xs font-bold">${interestedStudents}</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="bg-red-500 rounded-t w-16 mb-2" style="height: ${safeHeight(notInterestedStudents, studentResponses)}px;"></div>
                <span class="text-xs text-gray-600">İlgisiz</span>
                <span class="text-xs font-bold">${notInterestedStudents}</span>
            </div>
        </div>
    `;
}

function displayResponses() {
    const tbody = document.getElementById('responses-table-body');
    
    if (!responses || responses.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-lg font-medium">Henüz anket yanıtı yok</p>
                        <p class="text-sm">Kullanıcılar anket doldurdukça burada görünecek</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = responses.map(response => `
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
                <div>
                    <div class="text-sm font-medium text-gray-900">${escapeHtml(response.user_name || 'Bilinmeyen')}</div>
                    <div class="text-sm text-gray-500">${escapeHtml(response.user_email || 'Email yok')}</div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="badge badge-${response.is_student ? 'success' : 'gray'}">
                    ${response.is_student ? 'Evet' : 'Hayır'}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                ${response.is_student ? `
                    <span class="badge badge-${response.is_interested ? 'success' : 'error'}">
                        ${response.is_interested ? 'İlgili' : 'İlgisiz'}
                    </span>
                ` : `
                    <span class="text-gray-400">-</span>
                `}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${formatDate(response.created_at)}
            </td>
        </tr>
    `).join('');
}

function setActiveTab(tab) {
    activeTab = tab;
    
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(content => {
        content.style.display = 'none';
    });
    
    // Show selected tab
    document.getElementById(`${tab}-tab`).style.display = 'block';
    
    // Update tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
}

function toggleAutoRefresh() {
    const checkbox = document.getElementById('auto-refresh');
    
    if (checkbox.checked) {
        autoRefreshInterval = setInterval(loadSurveyData, 30000);
        showToast('Otomatik yenileme açıldı (30 saniye)', 'info');
    } else {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
            autoRefreshInterval = null;
        }
        showToast('Otomatik yenileme kapatıldı', 'info');
    }
}

function refreshData() {
    loadSurveyData();
    showToast('Veriler yenilendi', 'success');
}

function exportCSV() {
    // UTF-8 BOM ekliyoruz Türkçe karakterler için
    const BOM = '\uFEFF';
    
    // CSV header
    const headers = ['Kullanıcı', 'Email', 'Öğrenci', 'İlgili', 'Tarih'];
    
    // CSV rows
    const rows = responses.map(response => [
        response.user_name || 'Bilinmeyen',
        response.user_email || 'Email yok',
        response.is_student ? 'Evet' : 'Hayır',
        response.is_student ? (response.is_interested ? 'İlgili' : 'İlgisiz') : '-',
        formatDate(response.created_at)
    ]);
    
    // CSV içeriği oluştur
    const csvContent = [
        headers.join(','),
        ...rows.map(row => row.map(field => `"${field.toString().replace(/"/g, '""')}"`).join(','))
    ].join('\n');
    
    // Blob oluştur ve indir
    const blob = new Blob([BOM + csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement("a");
    
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", `anket_sonuclari_${new Date().toISOString().slice(0,10)}.csv`);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    }
    
    showToast('Anket sonuçları CSV olarak indirildi', 'success');
}

// Güvenli değer alma fonksiyonu
function safeValue(value) {
    return value || 0;
}

function formatDate(dateString) {
    if (!dateString) return 'Tarih yok';
    
    try {
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return 'Geçersiz tarih';
        
        return date.toLocaleDateString('tr-TR', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    } catch (error) {
        console.error('Date formatting error:', error);
        return 'Tarih hatası';
    }
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text.toString();
    return div.innerHTML;
}
</script>

<style>
.tab-btn {
    color: rgb(75 85 99);
    background-color: rgb(243 244 246);
    transition: all 0.2s;
}

.tab-btn:hover {
    background-color: rgb(229 231 235);
}

.tab-btn.active {
    background-color: rgb(37 99 235);
    color: white;
}
</style>
