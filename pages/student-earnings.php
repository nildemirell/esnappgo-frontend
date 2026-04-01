<?php
// Öğrenci kontrolü
if (!$current_user || ($current_user['role'] !== 'student' && $current_user['role'] !== 'ogrenci')) {

    echo '<script>window.location.href = "/dashboard";</script>';
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Kazançlarım</h1>
            <p class="text-gray-600">Ürün paylaşımlarınızdan elde ettiğiniz kazançları takip edin</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Toplam Kazanç</p>
                        <p class="text-2xl font-bold text-gray-900" id="total-earnings">₺0.00</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Bu Ay</p>
                        <p class="text-2xl font-bold text-gray-900" id="monthly-earnings">₺0.00</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Fotoğraf Sayısı</p>
                        <p class="text-2xl font-bold text-gray-900" id="photos-count">0</p>
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
                        <p class="text-sm font-medium text-gray-500">Ortalama/Fotoğraf</p>
                        <p class="text-2xl font-bold text-gray-900" id="avg-per-photo">₺0.00</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Earnings Chart -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Kazanç Grafiği</h3>
                <div class="flex space-x-2">
                    <button onclick="setPeriod('week')" class="period-btn active px-3 py-1 text-sm rounded-md">Haftalık</button>
                    <button onclick="setPeriod('month')" class="period-btn px-3 py-1 text-sm rounded-md">Aylık</button>
                    <button onclick="setPeriod('year')" class="period-btn px-3 py-1 text-sm rounded-md">Yıllık</button>
                </div>
            </div>
            
            <div id="earnings-chart" class="h-64 flex items-end justify-around bg-gray-50 rounded-lg p-4">
                <!-- Chart will be populated by JavaScript -->
                <div class="text-center text-gray-500">
                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Kazanç verisi yükleniyor...
                </div>
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Earnings -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Son Kazançlar</h3>
                <div id="recent-earnings" class="space-y-4">
                    <div class="animate-pulse">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gray-200 rounded-lg"></div>
                            <div class="flex-1">
                                <div class="h-4 bg-gray-200 rounded mb-1"></div>
                                <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Tips -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Kazanç İpuçları</h3>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Kaliteli Fotoğraflar</h4>
                            <p class="text-sm text-gray-600">Net, iyi ışıklı fotoğraflar daha çok onaylanır</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Düzenli Paylaşım</h4>
                            <p class="text-sm text-gray-600">Günlük ürün paylaşımı kazancınızı artırır</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Popüler Ürünler</h4>
                            <p class="text-sm text-gray-600">Talep gören ürünlere odaklanın</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="/student/create-product" class="block p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-medium text-gray-900">Yeni Ürün</h4>
                        <p class="text-sm text-gray-500">Ürün fotoğrafı paylaş</p>
                    </div>
                </div>
            </a>
            
            <a href="/student/products" class="block p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-medium text-gray-900">Ürünlerim</h4>
                        <p class="text-sm text-gray-500">Paylaştığım ürünler</p>
                    </div>
                </div>
            </a>
            
            <a href="/student/wallet" class="block p-6 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-medium text-gray-900">Cüzdanım</h4>
                        <p class="text-sm text-gray-500">Para çekme işlemleri</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadStudentEarnings();
    loadRecentEarnings();
    loadEarningsChart();
});


async function loadStudentEarnings() {
    try {
        const token = localStorage.getItem('auth_token');
        if (!token) return;

        const res = await fetch(`${API_BASE}/api/Products/student-dashboard`, {
            headers: { 'Authorization': `Bearer ${token}` }
        });

        if (res.ok) {
            const data = await res.json();
            document.getElementById('total-earnings').textContent = `₺${data.totalEarnings.toFixed(2)}`;
            document.getElementById('photos-count').textContent = data.totalProducts;
            
            const avg = data.totalProducts > 0 ? (data.totalEarnings / data.totalProducts) : 0;
            document.getElementById('avg-per-photo').textContent = `₺${avg.toFixed(2)}`;
        }

        // monthly_earnings → backend'de yok, mock KALSIN
        // Şimdilik değer güncellenmeyecek (HTML'deki ₺0.00 kalacak veya mock değer)
    } catch (error) {
        console.error('Error loading student earnings:', error);
    }
}


async function loadRecentEarnings() {
    try {
        // Mock data - API endpoint eklenecek
        const earnings = [
            { date: '2025-08-20', amount: 15.50, product: 'Taze Domates', type: 'sale' },
            { date: '2025-08-20', amount: 8.25, product: 'Organik Salatalık', type: 'sale' },
            { date: '2025-08-19', amount: 12.00, product: 'Köy Ekmeği', type: 'sale' },
            { date: '2025-08-19', amount: 5.00, product: 'Yeni Ürün Bonusu', type: 'bonus' }
        ];
        
        const container = document.getElementById('recent-earnings');
        container.innerHTML = earnings.map(earning => `
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-${earning.type === 'sale' ? 'green' : 'blue'}-100 rounded-lg flex items-center justify-center">
                    ${earning.type === 'sale' ? `
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    ` : `
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 114.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                    `}
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">₺${earning.amount.toFixed(2)}</p>
                    <p class="text-xs text-gray-500">${earning.product} • ${formatDate(earning.date)}</p>
                </div>
                <span class="badge badge-${earning.type === 'sale' ? 'success' : 'primary'}">
                    ${earning.type === 'sale' ? 'Satış' : 'Bonus'}
                </span>
            </div>
        `).join('');
        
    } catch (error) {
        console.error('Error loading recent earnings:', error);
    }
}

function loadEarningsChart() {
    // Mock chart data
    const chartData = [
        { day: 'Pzt', amount: 25.50 },
        { day: 'Sal', amount: 18.75 },
        { day: 'Çar', amount: 32.25 },
        { day: 'Per', amount: 15.00 },
        { day: 'Cum', amount: 28.50 },
        { day: 'Cmt', amount: 22.00 },
        { day: 'Paz', amount: 19.25 }
    ];
    
    const maxAmount = Math.max(...chartData.map(d => d.amount));
    const chartContainer = document.getElementById('earnings-chart');
    
    chartContainer.innerHTML = chartData.map(data => {
        const height = (data.amount / maxAmount) * 200; // Max height 200px
        return `
            <div class="flex flex-col items-center">
                <div class="bg-blue-500 rounded-t w-8 mb-2 relative group" style="height: ${height}px;">
                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        ₺${data.amount.toFixed(2)}
                    </div>
                </div>
                <span class="text-xs text-gray-600">${data.day}</span>
            </div>
        `;
    }).join('');
}

function setPeriod(period) {
    // Update active button
    const buttons = document.querySelectorAll('.period-btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Reload chart with new period
    loadEarningsChart();
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('tr-TR', {
        month: 'short',
        day: 'numeric'
    });
}
</script>

<style>
.period-btn {
    color: rgb(75 85 99);
    background-color: rgb(243 244 246);
    transition: all 0.2s;
}

.period-btn:hover {
    background-color: rgb(229 231 235);
}

.period-btn.active {
    background-color: rgb(37 99 235);
    color: white;
}
</style>
