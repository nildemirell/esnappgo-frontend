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
                <span class="text-gray-900">Siparişler</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900">Sipariş Yönetimi</h1>
        </div>
        
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        Ara
                    </label>
                    <input
                        type="text"
                        id="search"
                        placeholder="Sipariş no, müşteri ara..."
                        class="w-full"
                        onkeyup="filterOrders()"
                    />
                </div>
                
                <div>
                    <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-2">
                        Durum
                    </label>
                    <select id="status-filter" class="w-full" onchange="filterOrders()">
                        <option value="">Tüm Durumlar</option>
                        <option value="pending">Beklemede</option>
                        <option value="paid">Ödendi</option>
                        <option value="shipped">Kargoya Verildi</option>
                        <option value="delivered">Teslim Edildi</option>
                        <option value="cancelled">İptal Edildi</option>
                    </select>
                </div>
                
                <div>
                    <label for="date-filter" class="block text-sm font-medium text-gray-700 mb-2">
                        Tarih
                    </label>
                    <select id="date-filter" class="w-full" onchange="filterOrders()">
                        <option value="">Tüm Tarihler</option>
                        <option value="today">Bugün</option>
                        <option value="week">Bu Hafta</option>
                        <option value="month">Bu Ay</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button onclick="exportOrders()" class="btn btn-outline w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Dışa Aktar
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Orders Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sipariş
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Müşteri
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tutar
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Durum
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tarih
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                İşlemler
                            </th>
                        </tr>
                    </thead>
                    <tbody id="orders-table-body" class="bg-white divide-y divide-gray-200">
                        <!-- Loading rows -->
                        <?php for ($i = 0; $i < 5; $i++): ?>
                        <tr class="animate-pulse">
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-24"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-32"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-16"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-20"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-24"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-16"></div></td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
let allOrders = [];
let filteredOrders = [];

document.addEventListener('DOMContentLoaded', function() {
    loadOrders();
});

async function loadOrders() {
    try {
        // Mock data - API endpoint eklenecek
        allOrders = [
            { 
                id: 1, 
                order_number: 'ORD-001', 
                customer_name: 'Test Müşteri', 
                customer_email: 'musteri@test.com',
                total_amount: 125.50, 
                status: 'pending', 
                created_at: '2025-08-20 21:58:00',
                items_count: 3
            },
            { 
                id: 2, 
                order_number: 'ORD-002', 
                customer_name: 'Ahmet Yılmaz', 
                customer_email: 'ahmet@example.com',
                total_amount: 89.90, 
                status: 'shipped', 
                created_at: '2025-08-20 15:30:00',
                items_count: 2
            },
            { 
                id: 3, 
                order_number: 'ORD-003', 
                customer_name: 'Ayşe Kaya', 
                customer_email: 'ayse@example.com',
                total_amount: 67.25, 
                status: 'delivered', 
                created_at: '2025-08-19 10:15:00',
                items_count: 1
            }
        ];
        
        filteredOrders = [...allOrders];
        displayOrders();
        
    } catch (error) {
        console.error('Error loading orders:', error);
    }
}

function displayOrders() {
    const tbody = document.getElementById('orders-table-body');
    
    tbody.innerHTML = filteredOrders.map(order => `
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
                <div>
                    <div class="text-sm font-medium text-gray-900">#${order.order_number}</div>
                    <div class="text-sm text-gray-500">${order.items_count} ürün</div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div>
                    <div class="text-sm font-medium text-gray-900">${escapeHtml(order.customer_name)}</div>
                    <div class="text-sm text-gray-500">${escapeHtml(order.customer_email)}</div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">₺${parseFloat(order.total_amount).toFixed(2)}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="badge badge-${getStatusBadgeClass(order.status)}">
                    ${getStatusText(order.status)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${formatDate(order.created_at)}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex space-x-2">
                    <button onclick="viewOrderDetails('${order.id}')" class="text-blue-600 hover:text-blue-900">
                        Detaylar
                    </button>
                    ${order.status === 'pending' ? `
                        <button onclick="updateOrderStatus('${order.id}', 'cancelled')" class="text-red-600 hover:text-red-900">
                            İptal Et
                        </button>
                    ` : ''}
                </div>
            </td>
        </tr>
    `).join('');
}

function filterOrders() {
    const search = document.getElementById('search').value.toLowerCase();
    const statusFilter = document.getElementById('status-filter').value;
    const dateFilter = document.getElementById('date-filter').value;
    
    filteredOrders = allOrders.filter(order => {
        const matchesSearch = !search || 
            order.order_number.toLowerCase().includes(search) || 
            order.customer_name.toLowerCase().includes(search) ||
            order.customer_email.toLowerCase().includes(search);
        
        const matchesStatus = !statusFilter || order.status === statusFilter;
        
        // Date filtering logic would go here
        const matchesDate = true; // Simplified for now
        
        return matchesSearch && matchesStatus && matchesDate;
    });
    
    displayOrders();
}

function getStatusText(status) {
    const statusTexts = {
        pending: 'Beklemede',
        paid: 'Ödendi',
        shipped: 'Kargoya Verildi',
        delivered: 'Teslim Edildi',
        cancelled: 'İptal Edildi',
        refunded: 'İade Edildi'
    };
    return statusTexts[status] || status;
}

function getStatusBadgeClass(status) {
    const badgeClasses = {
        pending: 'warning',
        paid: 'primary',
        shipped: 'primary',
        delivered: 'success',
        cancelled: 'error',
        refunded: 'gray'
    };
    return badgeClasses[status] || 'gray';
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('tr-TR', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function viewOrderDetails(orderId) {
    showToast('Sipariş detayları özelliği yakında eklenecek', 'info');
}

async function updateOrderStatus(orderId, newStatus) {
    if (!confirm('Sipariş durumunu değiştirmek istediğinizden emin misiniz?')) {
        return;
    }
    
    try {
        // API endpoint eklenecek
        const order = allOrders.find(o => o.id == orderId);
        if (order) {
            order.status = newStatus;
            filterOrders();
            showToast('Sipariş durumu güncellendi', 'success');
        }
        
    } catch (error) {
        showToast('Durum güncellenirken hata oluştu', 'error');
    }
}

function exportOrders() {
    const csvContent = "data:text/csv;charset=utf-8," + 
        "Sipariş No,Müşteri,Email,Tutar,Durum,Tarih\n" +
        filteredOrders.map(order => 
            `"${order.order_number}","${order.customer_name}","${order.customer_email}","₺${order.total_amount}","${getStatusText(order.status)}","${order.created_at}"`
        ).join("\n");
    
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "siparisler.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showToast('Sipariş listesi indirildi', 'success');
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
