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
                <span class="text-gray-900">Raporlar</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900">Satış Raporları</h1>
        </div>
        
        <!-- Date Range Filter -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="start-date" class="block text-sm font-medium text-gray-700 mb-2">
                        Başlangıç Tarihi
                    </label>
                    <input type="date" id="start-date" class="w-full" />
                </div>
                
                <div>
                    <label for="end-date" class="block text-sm font-medium text-gray-700 mb-2">
                        Bitiş Tarihi
                    </label>
                    <input type="date" id="end-date" class="w-full" />
                </div>
                
                <div>
                    <label for="report-type" class="block text-sm font-medium text-gray-700 mb-2">
                        Rapor Türü
                    </label>
                    <select id="report-type" class="w-full">
                        <option value="sales">Satış Raporu</option>
                        <option value="students">Öğrenci Kazançları</option>
                        <option value="merchants">Esnaf Kazançları</option>
                        <option value="products">Ürün Performansı</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button onclick="generateReport()" class="btn btn-primary w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Rapor Oluştur
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Toplam Satış</p>
                        <p class="text-2xl font-bold text-gray-900" id="total-sales">₺0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Toplam Sipariş</p>
                        <p class="text-2xl font-bold text-gray-900" id="total-orders">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Öğrenci Kazançları</p>
                        <p class="text-2xl font-bold text-gray-900" id="student-earnings">₺0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Esnaf Kazançları</p>
                        <p class="text-2xl font-bold text-gray-900" id="merchant-earnings">₺0</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Sales Chart -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Satış Grafiği</h3>
                <div id="sales-chart" class="h-64 flex items-end justify-around bg-gray-50 rounded-lg p-4">
                    <!-- Chart will be populated by JavaScript -->
                    <div class="text-center text-gray-500">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Rapor oluşturun
                    </div>
                </div>
            </div>
            
            <!-- Top Products -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">En Çok Satan Ürünler</h3>
                <div id="top-products" class="space-y-3">
                    <div class="animate-pulse">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gray-200 rounded"></div>
                            <div class="flex-1">
                                <div class="h-4 bg-gray-200 rounded mb-1"></div>
                                <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set default dates
    const today = new Date();
    const lastMonth = new Date();
    lastMonth.setMonth(today.getMonth() - 1);
    
    document.getElementById('start-date').value = lastMonth.toISOString().split('T')[0];
    document.getElementById('end-date').value = today.toISOString().split('T')[0];
    
    loadReportData();
});

async function generateReport() {
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;
    const reportType = document.getElementById('report-type').value;
    
    if (!startDate || !endDate) {
        showToast('Lütfen tarih aralığı seçin', 'error');
        return;
    }
    
    try {
        showToast('Rapor oluşturuluyor...', 'info');
        
        // Mock report generation
        await new Promise(resolve => setTimeout(resolve, 2000));
        
        loadReportData();
        showToast('Rapor oluşturuldu!', 'success');
        
    } catch (error) {
        showToast('Rapor oluşturulurken hata oluştu', 'error');
    }
}

function loadReportData() {
    // Mock data
    const stats = {
        total_sales: 45678.90,
        total_orders: 234,
        student_earnings: 6851.34,
        merchant_earnings: 34289.01
    };
    
    document.getElementById('total-sales').textContent = `₺${stats.total_sales.toLocaleString()}`;
    document.getElementById('total-orders').textContent = stats.total_orders.toLocaleString();
    document.getElementById('student-earnings').textContent = `₺${stats.student_earnings.toLocaleString()}`;
    document.getElementById('merchant-earnings').textContent = `₺${stats.merchant_earnings.toLocaleString()}`;
    
    // Load charts
    loadSalesChart();
    loadTopProducts();
}

function loadSalesChart() {
    // Mock chart data
    const chartData = [
        { day: 'Pzt', amount: 1250.50 },
        { day: 'Sal', amount: 1875.75 },
        { day: 'Çar', amount: 2225.25 },
        { day: 'Per', amount: 1500.00 },
        { day: 'Cum', amount: 2850.50 },
        { day: 'Cmt', amount: 2200.00 },
        { day: 'Paz', amount: 1925.25 }
    ];
    
    const maxAmount = Math.max(...chartData.map(d => d.amount));
    const chartContainer = document.getElementById('sales-chart');
    
    chartContainer.innerHTML = chartData.map(data => {
        const height = (data.amount / maxAmount) * 200; // Max height 200px
        return `
            <div class="flex flex-col items-center">
                <div class="bg-blue-500 rounded-t w-12 mb-2 relative group" style="height: ${height}px;">
                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        ₺${data.amount.toFixed(2)}
                    </div>
                </div>
                <span class="text-xs text-gray-600">${data.day}</span>
            </div>
        `;
    }).join('');
}

function loadTopProducts() {
    // Mock top products data
    const topProducts = [
        { name: 'Taze Domates', sales: 45, revenue: 382.50 },
        { name: 'Organik Salatalık', sales: 38, revenue: 228.00 },
        { name: 'Köy Ekmeği', sales: 32, revenue: 128.00 },
        { name: 'Taze Süt', sales: 28, revenue: 336.00 },
        { name: 'Yerel Bal', sales: 15, revenue: 675.00 }
    ];
    
    const container = document.getElementById('top-products');
    
    container.innerHTML = topProducts.map((product, index) => `
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                <span class="text-sm font-bold text-blue-600">${index + 1}</span>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">${product.name}</p>
                <p class="text-xs text-gray-500">${product.sales} satış</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-bold text-gray-900">₺${product.revenue.toFixed(2)}</p>
            </div>
        </div>
    `).join('');
}
</script>
