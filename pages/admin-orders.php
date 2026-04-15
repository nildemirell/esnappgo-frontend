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
                       <option value="Pending">Beklemede</option>
                       <option value="Processing">İşleniyor</option>
                       <option value="Shipped">Kargoya Verildi</option>
                       <option value="Delivered">Teslim Edildi</option>
                       <option value="Cancelled">İptal Edildi</option>

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
        const statusFilter = document.getElementById('status-filter')?.value || '';
        const dateFilter   = document.getElementById('date-filter')?.value || '';
        const search       = document.getElementById('search')?.value || '';

        // Filtreler server-side'a gönderiliyor — backend destekliyor
        let url = 'Admin/orders';
        const params = [];
        if (search)       params.push(`search=${encodeURIComponent(search)}`);
        if (statusFilter) params.push(`status=${statusFilter}`);
        if (dateFilter)   params.push(`dateRange=${dateFilter}`);
        if (params.length) url += '?' + params.join('&');

        const response = await apiCall(url);
        // Backend { success: true, data: [...] } döndürüyor
        allOrders = Array.isArray(response) ? response : (response.data || []);
        filteredOrders = [...allOrders];
        displayOrders();

    } catch (error) {
        console.error('Siparişler yüklenemedi:', error);
        showToast('Siparişler yüklenirken hata oluştu.', 'error');
        document.getElementById('orders-table-body').innerHTML =
            '<tr><td colspan="6" class="text-center py-8 text-gray-500">Siparişler yüklenemedi.</td></tr>';
    }
}

function displayOrders() {
    const tbody = document.getElementById('orders-table-body');
    
    if (!filteredOrders.length) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center py-8 text-gray-500">Sipariş bulunamadı.</td></tr>';
        return;
    }

    // Backend AdminOrderSummaryDto: id, orderNumber, customerName, customerEmail,
    //                               itemCount, totalAmount, status, createdAt
    tbody.innerHTML = filteredOrders.map(order => `
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
                <div>
                    <div class="text-sm font-medium text-gray-900">#${escapeHtml(order.orderNumber || String(order.id))}</div>
                    <div class="text-sm text-gray-500">${order.itemCount ?? 0} ürün</div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div>
                    <div class="text-sm font-medium text-gray-900">${escapeHtml(order.customerName || '')}</div>
                    <div class="text-sm text-gray-500">${escapeHtml(order.customerEmail || '')}</div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">₺${parseFloat(order.totalAmount || 0).toFixed(2)}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="badge badge-${getStatusBadgeClass(order.status)}">
                    ${getStatusText(order.status)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${formatDate(order.createdAt)}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
    <div class="flex space-x-2">
        <button onclick="viewOrderDetails('${order.id}')" class="text-blue-600 hover:text-blue-900">
            Detaylar
        </button>
        ${order.status?.toLowerCase() !== 'cancelled' && order.status?.toLowerCase() !== 'delivered' ? `
            <select onchange="if(this.value) updateOrderStatus('${order.id}', this.value); this.value='';" 
                    class="text-xs border rounded px-1 py-0.5">
                <option value="">Durum Değiştir</option>
                <option value="Processing">İşleniyor</option>
                <option value="Shipped">Kargoya Verildi</option>
                <option value="Delivered">Teslim Edildi</option>
            </select>
        ` : ''}
        ${(order.status?.toLowerCase() === 'pending' || order.status?.toLowerCase() === 'processing') ? `
            <button onclick="cancelOrder('${order.id}')" class="text-red-600 hover:text-red-900">
                İptal Et
            </button>
        ` : ''}
    </div>
</td>

        </tr>
    `).join('');
}

function filterOrders() {
    // Filtreler backend'e gönderildiği için loadOrders'ı yeniden çağırıyoruz
    loadOrders();
}

function getStatusText(status) {
    const statusTexts = {
    Pending: 'Beklemede',   pending: 'Beklemede',
    Processing: 'İşleniyor', processing: 'İşleniyor',
    Shipped: 'Kargoya Verildi', shipped: 'Kargoya Verildi',
    Delivered: 'Teslim Edildi', delivered: 'Teslim Edildi',
    Cancelled: 'İptal Edildi', cancelled: 'İptal Edildi'
    // 'Paid' ve 'Refunded' backend'de YOK — kaldırıldı
};
    return statusTexts[status] || status;
}

function getStatusBadgeClass(status) {
    const s = String(status).toLowerCase();
    const badgeClasses = {
        pending: 'warning',
        processing: 'primary',
        shipped: 'primary',
        delivered: 'success',
        cancelled: 'error'
    };
    return badgeClasses[s] || 'gray';
}


function formatDate(dateString) {
    if (!dateString) return '—';
    const date = new Date(dateString);
    return date.toLocaleDateString('tr-TR', {
        year: 'numeric', month: 'short', day: 'numeric',
        hour: '2-digit', minute: '2-digit'
    });
}

async function viewOrderDetails(orderId) {
    try {
        const response = await apiCall(`Admin/orders/${orderId}`);
        const order = response.data || response;
        
        // Modal ile detay göster
        let itemsHtml = '';
        if (order.items && order.items.length > 0) {
            itemsHtml = order.items.map(item => `
                <div class="flex justify-between py-2 border-b">
                    <span>${escapeHtml(item.productName)} x${item.quantity}</span>
                    <span>₺${parseFloat(item.price || 0).toFixed(2)}</span>
                </div>
            `).join('');
        }
        
        const detailHtml = `
            <div class="text-left">
                <p><strong>Sipariş No:</strong> #${escapeHtml(order.orderNumber || String(order.id))}</p>
                <p><strong>Müşteri:</strong> ${escapeHtml(order.customerName || '')}</p>
                <p><strong>Email:</strong> ${escapeHtml(order.customerEmail || '')}</p>
                <p><strong>Toplam:</strong> ₺${parseFloat(order.totalAmount || 0).toFixed(2)}</p>
                <p><strong>Durum:</strong> ${getStatusText(order.status)}</p>
                <p><strong>Tarih:</strong> ${formatDate(order.createdAt)}</p>
                ${itemsHtml ? '<hr class="my-2"><h4 class="font-bold">Ürünler:</h4>' + itemsHtml : ''}
            </div>
        `;
        
        await openCustomModal(detailHtml, 'alert');
    } catch (error) {
        showToast('Sipariş detayları yüklenemedi: ' + error.message, 'error');
    }
}


async function cancelOrder(orderId) {
    if (!(await openCustomModal('Bu siparişi iptal etmek istediğinizden emin misiniz?'))) return;
    try {
        await apiCall(`Admin/orders/${orderId}/cancel`, { method: 'PUT' });
        await loadOrders();
        showToast('Sipariş iptal edildi.', 'success');
    } catch (error) {
        showToast('İptal işlemi başarısız: ' + error.message, 'error');
    }
}

async function updateOrderStatus(orderId, newStatus) {
    if (!(await openCustomModal('Sipariş durumunu değiştirmek istediğinizden emin misiniz?'))) return;
    try {
        await apiCall(`Admin/orders/${orderId}/status`, {
            method: 'PUT',
            body: JSON.stringify({ status: newStatus })
        });
        await loadOrders();
        showToast('Sipariş durumu güncellendi.', 'success');
    } catch (error) {
        showToast('Güncelleme başarısız: ' + error.message, 'error');
    }
}

function exportOrders() {
    const csvContent = "data:text/csv;charset=utf-8," + 
        "Sipariş No,Müşteri,Email,Tutar,Durum,Tarih\n" +
        filteredOrders.map(order => 
            `"${order.orderNumber || order.id}","${order.customerName || ''}","${order.customerEmail || ''}","₺${order.totalAmount || 0}","${getStatusText(order.status)}","${order.createdAt}"`
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
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = String(text);
    return div.innerHTML;
}
</script>
