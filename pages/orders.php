<?php
// Giriş kontrolü
if (!$current_user) {
    header('Location: /login?redirect=/orders');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Siparişlerim</h1>
            <p class="text-gray-600">Verdiğiniz siparişlerin durumunu takip edin</p>
        </div>

        <!-- Orders List -->
        <div id="orders-container" class="space-y-6">
            <!-- Loading skeleton -->
            <div class="animate-pulse">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-4 bg-gray-200 rounded w-32"></div>
                        <div class="h-6 bg-gray-200 rounded w-20"></div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-4">
                            <div class="bg-gray-200 h-16 w-16 rounded-lg"></div>
                            <div class="flex-1">
                                <div class="h-4 bg-gray-200 rounded mb-2"></div>
                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty Orders -->
        <div id="empty-orders" class="text-center py-12" style="display: none;">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                </path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz siparişiniz yok</h3>
            <p class="text-gray-500 mb-6">İlk siparişinizi vermek için ürünleri incelemeye başlayın.</p>
            <a href="/products" class="btn btn-primary">
                Ürünleri İncele
            </a>
        </div>
    </div>
</div>

<!-- Order Detail Modal -->
<div id="order-detail-modal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeOrderModal()"></div>

        <!-- Modal Content -->
        <div
            class="inline-block w-full max-w-3xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-2xl shadow-xl">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-white" id="modal-order-number">Sipariş Detayı</h3>
                        <p class="text-purple-200 text-sm" id="modal-order-date"></p>
                    </div>
                    <button onclick="closeOrderModal()" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div id="modal-body" class="p-6 max-h-[70vh] overflow-y-auto">
                <!-- Loading -->
                <div id="modal-loading" class="text-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600 mx-auto"></div>
                    <p class="mt-4 text-gray-500">Yükleniyor...</p>
                </div>

                <!-- Content -->
                <div id="modal-content" style="display: none;">
                    <!-- Status Badge -->
                    <div class="flex items-center justify-between mb-6">
                        <span id="modal-status-badge" class="badge"></span>
                        <span id="modal-tracking" class="text-sm text-gray-500"></span>
                    </div>

                    <!-- Order Items -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Sipariş Edilen Ürünler
                        </h4>
                        <div id="modal-items" class="space-y-4"></div>
                    </div>

                    <!-- Student Support Section -->
                    <div id="modal-student-support"
                        class="mb-6 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-5 border border-purple-200"
                        style="display: none;">
                        <h4 class="text-lg font-semibold text-purple-800 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                            Öğrenci Desteği
                        </h4>
                        <p class="text-sm text-purple-600 mb-3">Bu siparişle öğrencilere destek oldunuz!</p>
                        <div id="modal-donation-details" class="space-y-2"></div>
                        <div class="mt-4 pt-4 border-t border-purple-200 flex justify-between items-center">
                            <span class="font-medium text-purple-800">Toplam Destek</span>
                            <span id="modal-total-donation" class="text-xl font-bold text-purple-600"></span>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-gray-50 rounded-xl p-5 mb-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                            Sipariş Özeti
                        </h4>
                        <div class="space-y-3">
                            <div class="flex justify-between text-gray-600">
                                <span>Ara Toplam</span>
                                <span id="modal-subtotal"></span>
                            </div>
                            <div id="modal-support-row" class="flex justify-between text-purple-600"
                                style="display: none;">
                                <span>Öğrenci Desteği</span>
                                <span id="modal-support-amount"></span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Kargo</span>
                                <span class="text-green-600">Ücretsiz</span>
                            </div>
                            <div class="pt-3 border-t border-gray-200 flex justify-between">
                                <span class="text-lg font-bold text-gray-900">Toplam</span>
                                <span id="modal-total" class="text-lg font-bold text-gray-900"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="bg-blue-50 rounded-xl p-5">
                        <h4 class="text-lg font-semibold text-blue-800 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                            Ödeme Bilgileri
                        </h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-blue-600">Ödeme Yöntemi</span>
                                <span id="modal-payment-method" class="font-medium text-blue-800"></span>
                            </div>
                            <div id="modal-payment-proof-row" class="flex justify-between" style="display: none;">
                                <span class="text-blue-600">Dekont</span>
                                <a id="modal-payment-proof" href="#" target="_blank"
                                    class="font-medium text-blue-800 hover:underline">Görüntüle</a>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div id="modal-timeline" class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Sipariş Durumu
                        </h4>
                        <div id="modal-timeline-content" class="space-y-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        loadOrders();
    });

    async function loadOrders() {
        try {
           const response = await apiCall('orders');
            let rawOrders = Array.isArray(response) ? response : (response.data || []);
            
            // YENİ EKLEME: Tüm sipariş durumlarını zorla küçük harfe çevir (.NET Enum uyumu)
            const orders = rawOrders.map(o => ({
                ...o,
                status: (o.status || '').toLowerCase() 
            }));
            // YENİ EKLEME: Sipariş resimlerini Ana Ürün listesiyle (products) eşleştiriyoruz
            try {
                const allProductsResp = await apiCall('products');
                // Sayfalanmış DTO'dan products dizisini çıkarıyoruz
                const allProductsList = Array.isArray(allProductsResp) ? allProductsResp : (allProductsResp.products || allProductsResp.data || []);

                orders.forEach(order => {
                    if (order.orderItems) {
                        order.orderItems.forEach(item => {
                            const matchedProduct = allProductsList.find(p => p.id == item.productId || p.Id == item.productId);
                            if (matchedProduct) {
                                // Bulunan orijinal ürünün ilk resmini item içerisine yedekle
                                const images = matchedProduct.imageUrls || matchedProduct.ImageUrls || [];
                                item.imageUrl = images.length > 0 ? images[0] : null;
                            }
                        });
                    }
                });
            } catch (e) {
                console.error("Resim eşleşmesi başarısız", e);
            }

            const container = document.getElementById('orders-container');

            if (orders.length === 0) {
                container.innerHTML = '';
                document.getElementById('empty-orders').style.display = 'block';
                return;
            }

            container.innerHTML = orders.map(order => `
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-shadow">
                <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Sipariş #${order.orderNumber || order.id}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                ${formatDate(order.createdAt)}
                            </p>
                        </div>
                        <div class="flex items-center space-x-3">
                            ${order.studentSupportAmount > 0 ? `
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                    </svg>
                                    Öğrenci Destekli
                                </span>
                            ` : ''}
                            <span class="badge ${getStatusBadgeClass(order.status)}">
                                ${getStatusText(order.status)}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        ${(order.orderItems || []).map(item => `
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    ${item.imageUrl ? `
                                        <img 
                                            src="${item.imageUrl}" 
                                            alt="${escapeHtml(item.productName)}"
                                            class="w-16 h-16 object-cover rounded-lg border border-gray-200"
                                            onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNjY2MiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMTIgMmM1LjUxNCAwIDEwIDQuNDg2IDEwIDEwcy00LjQ4NiAxMC0xMCAxMFMyIDEyIDIgMTJTNi40ODYgMiAxMiAyek0xMiA2YTYgNiAwIDEwMCAxMiA2IDYgMCAwMDAtMTJ6Ii8+PC9zdmc+'"
                                        />
                                    ` : `
                                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    `}
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900 line-clamp-1">
                                        ${escapeHtml(item.productName)}
                                    </h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        ${item.quantity} adet x ₺${parseFloat(item.unitPrice).toFixed(2)}
                                    </p>
                                </div>
                                
                                <div class="text-sm font-semibold text-gray-900">
                                    ₺${parseFloat(item.quantity * item.unitPrice).toFixed(2)}
                                </div>
                            </div>
                        `).join('')}
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        ${order.studentSupportAmount > 0 ? `
                            <div class="flex justify-between items-center mb-2 text-sm">
                                <span class="text-gray-500">Ara Toplam</span>
                                <span class="text-gray-700">₺${parseFloat(order.totalAmount - order.studentSupportAmount).toFixed(2)}</span>
                            </div>
                            <div class="flex justify-between items-center mb-3 text-sm">
                                <span class="text-purple-600 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                    </svg>
                                    Öğrenci Desteği
                                </span>
                                <span class="text-purple-600 font-medium">+₺${parseFloat(order.studentSupportAmount).toFixed(2)}</span>
                            </div>
                        ` : ''}
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-900">Toplam</span>
                            <span class="text-xl font-bold text-gray-900">
                                ₺${parseFloat(order.totalAmount).toFixed(2)}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                    ${order.status === 'pending' ? `
                        <button 
                            onclick="cancelOrder('${order.id}')"
                            class="btn btn-outline text-red-600 border-red-300 hover:bg-red-50"
                        >
                            İptal Et
                        </button>
                    ` : ''}

                    <button
                        onclick="viewOrderDetails('${order.id}')"
                        class="btn btn-primary"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Detaylar
                    </button>

                    ${order.status === 'delivered' ? `
                        <button 
                            onclick="reorderItems('${order.id}')"
                            class="btn btn-outline"
                        >
                            Tekrar Sipariş Ver
                        </button>
                    ` : ''}
                </div>
            </div>
        `).join('');

        } catch (error) {
            console.error('Error loading orders:', error);
            const container = document.getElementById('orders-container');
            container.innerHTML = '<div class="text-center text-red-500 py-8">Siparişler yüklenirken hata oluştu.</div>';
        }
    }

    function getStatusBadgeClass(status) {
        switch (status) {
            case 'pending':
                return 'badge-warning';
            case 'paid':
                return 'badge-primary';
            case 'shipped':
                return 'badge-primary';
            case 'delivered':
                return 'badge-success';
            case 'cancelled':
            case 'refunded':
                return 'badge-error';
            default:
                return 'badge-gray';
        }
    }

    function getStatusText(status) {
        switch (status) {
            case 'pending':
                return 'Beklemede';
            case 'paid':
                return 'Ödendi';
            case 'shipped':
                return 'Kargoya Verildi';
            case 'delivered':
                return 'Teslim Edildi';
            case 'cancelled':
                return 'İptal Edildi';
            case 'refunded':
                return 'İade Edildi';
            default:
                return 'Bilinmiyor';
        }
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('tr-TR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function formatShortDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleDateString('tr-TR', {
            day: 'numeric',
            month: 'short',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    async function cancelOrder(orderId) {
        if (!await openCustomModal('Bu siparişi iptal etmek istediğinizden emin misiniz?')) {
            return;
        }

        try {
            await apiCall(`orders/${orderId}/cancel`, { method: 'PUT' });
            showToast('Sipariş iptal edildi', 'success');
            loadOrders(); // Refresh the list
        } catch (error) {
            showToast(error.message, 'error');
        }
    }

    async function viewOrderDetails(orderId) {
        // Modal'ı aç
        const modal = document.getElementById('order-detail-modal');
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';

        // Loading göster
        document.getElementById('modal-loading').style.display = 'block';
        document.getElementById('modal-content').style.display = 'none';

        try {
          const response = await apiCall(`orders/${orderId}`);
            let rawOrder = response.data ? response.data : response;
            // Durumu küçük harfe zorla
            const order = { ...rawOrder, status: (rawOrder.status || '').toLowerCase() };
            // YENİ EKLEME: Detay Modal'ı içindeki resim eşleştirmesi
            try {
                const allProductsResp = await apiCall('products');
                const allProductsList = Array.isArray(allProductsResp) ? allProductsResp : (allProductsResp.products || allProductsResp.data || []);

                if (order.orderItems) {
                    order.orderItems.forEach(item => {
                        const matchedProduct = allProductsList.find(p => p.id == item.productId || p.Id == item.productId);
                        if (matchedProduct) {
                            const images = matchedProduct.imageUrls || matchedProduct.ImageUrls || [];
                            item.imageUrl = images.length > 0 ? images[0] : null;
                        }
                    });
                }
            } catch (e) {
                console.error("Modal resim eşleşmesi başarısız", e);
            }

            // Header bilgileri
            document.getElementById('modal-order-number').textContent = `Sipariş #${order.orderNumber || order.id}`;
            document.getElementById('modal-order-date').textContent = formatDate(order.createdAt);

            // Status badge
            const statusBadge = document.getElementById('modal-status-badge');
            statusBadge.className = `badge ${getStatusBadgeClass(order.status)}`;
            statusBadge.textContent = getStatusText(order.status);

            // Tracking number (Eğer backend dönüyorsa, dönmüyorsa boş kalır)
            const trackingEl = document.getElementById('modal-tracking');
            if (order.trackingNumber) {
                trackingEl.innerHTML = `<span class="font-medium">Takip No:</span> ${order.trackingNumber}`;
            } else {
                trackingEl.textContent = '';
            }

            // Order items
            const itemsContainer = document.getElementById('modal-items');
            itemsContainer.innerHTML = (order.orderItems || []).map(item => `
            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                <div class="flex-shrink-0">
                    ${item.imageUrl ? `
                        <img 
                            src="${item.imageUrl}" 
                            alt="${escapeHtml(item.productName)}"
                            class="w-16 h-16 object-cover rounded-lg border border-gray-200"
                            onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNjY2MiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMTIgMmM1LjUxNCAwIDEwIDQuNDg2IDEwIDEwcy00LjQ4NiAxMC0xMCAxMFMyIDEyIDIgMTJTNi40ODYgMiAxMiAyek0xMiA2YTYgNiAwIDEwMCAxMiA2IDYgMCAwMDAtMTJ6Ii8+PC9zdmc+'"
                        />
                    ` : `
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    `}
                </div>
                <div class="flex-1 min-w-0">
                    <h5 class="font-medium text-gray-900">${escapeHtml(item.productName)}</h5>
                    <p class="text-sm text-gray-500 mt-1">
                        ${item.quantity} adet x ₺${parseFloat(item.unitPrice).toFixed(2)}
                    </p>
                </div>
                <div class="text-right">
                    <span class="font-semibold text-gray-900">₺${parseFloat(item.quantity * item.unitPrice).toFixed(2)}</span>
                </div>
            </div>
        `).join('');

            // Student Support Section
            const studentSupportSection = document.getElementById('modal-student-support');
            const donationDetails = document.getElementById('modal-donation-details');

            if (order.studentSupportAmount > 0) {
                studentSupportSection.style.display = 'block';

                // Basitleştirilmiş destek gösterimi (.NET backend detaylı donation listesi dönmüyor, sadece total dönüyor)
                donationDetails.innerHTML = `
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-purple-600">
                        <span>Siparişe Eklenen Toplam Destek</span>
                        <span>₺${parseFloat(order.studentSupportAmount).toFixed(2)}</span>
                    </div>
                </div>
                `;

                document.getElementById('modal-total-donation').textContent = `₺${parseFloat(order.studentSupportAmount).toFixed(2)}`;

                // Support row in summary
                document.getElementById('modal-support-row').style.display = 'flex';
                document.getElementById('modal-support-amount').textContent = `+₺${parseFloat(order.studentSupportAmount).toFixed(2)}`;
            } else {
                studentSupportSection.style.display = 'none';
                document.getElementById('modal-support-row').style.display = 'none';
            }

            // Order Summary
            const subtotal = order.totalAmount - (order.studentSupportAmount || 0);
            document.getElementById('modal-subtotal').textContent = `₺${parseFloat(subtotal).toFixed(2)}`;
            document.getElementById('modal-total').textContent = `₺${parseFloat(order.totalAmount).toFixed(2)}`;

            // Payment Info
            const paymentMethods = {
                'bank_transfer': 'Havale/EFT',
                'credit_card': 'Kredi Kartı',
                'cash': 'Kapıda Ödeme'
            };
            document.getElementById('modal-payment-method').textContent = paymentMethods[order.paymentMethod] || order.paymentMethod || 'Havale/EFT';

            // Payment proof
            const proofRow = document.getElementById('modal-payment-proof-row');
            if (order.receiptUrl) {
                proofRow.style.display = 'flex';
                document.getElementById('modal-payment-proof').href = order.receiptUrl;
            } else {
                proofRow.style.display = 'none';
            }

            // Timeline
            const timelineContent = document.getElementById('modal-timeline-content');
            const timelineSteps = [
                { status: 'pending', label: 'Sipariş Alındı', date: order.createdAt, icon: 'clipboard-list' },
                { status: 'paid', label: 'Ödeme Onaylandı', date: order.paymentConfirmedAt || (order.status !== 'pending' && order.status !== 'cancelled' ? order.createdAt : null), icon: 'check-circle' },
                { status: 'shipped', label: 'Kargoya Verildi', date: order.shippedAt, icon: 'truck' },
                { status: 'delivered', label: 'Teslim Edildi', date: order.deliveredAt, icon: 'home' }
            ];

            const statusOrder = ['pending', 'paid', 'shipped', 'delivered'];
            const currentStatusIndex = statusOrder.indexOf(order.status);

            timelineContent.innerHTML = timelineSteps.map((step, index) => {
                const isCompleted = index <= currentStatusIndex && order.status !== 'cancelled';
                return `
                <div class="flex items-center space-x-3 ${isCompleted ? 'text-green-600' : 'text-gray-400'}">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center ${isCompleted ? 'bg-green-100' : 'bg-gray-100'}">
                        ${isCompleted ? `
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        ` : `
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        `}
                    </div>
                    <div class="flex-1">
                        <p class="font-medium ${isCompleted ? 'text-green-700' : 'text-gray-500'}">${step.label}</p>
                        ${step.date ? `<p class="text-xs text-gray-400">${formatShortDate(step.date)}</p>` : ''}
                    </div>
                </div>
            `;
            }).join('');

            // İptal durumu
            if (order.status === 'cancelled') {
                timelineContent.innerHTML += `
                <div class="flex items-center space-x-3 text-red-600 mt-3 pt-3 border-t border-gray-100">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center bg-red-100">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-red-700">Sipariş İptal Edildi</p>
                    </div>
                </div>
            `;
            }

            // Loading gizle, content göster
            document.getElementById('modal-loading').style.display = 'none';
            document.getElementById('modal-content').style.display = 'block';

        } catch (error) {
            console.error('Error loading order details:', error);
            showToast('Sipariş detayları yüklenirken hata oluştu', 'error');
            closeOrderModal();
        }
    }

    function closeOrderModal() {
        const modal = document.getElementById('order-detail-modal');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    // ESC tuşu ile modal'ı kapat
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeOrderModal();
        }
    });

    async function reorderItems(orderId) {
        try {
            showToast('Ürünler sepete ekleniyor...', 'info');

            // Sipariş detaylarını al
            const response = await apiCall(`orders/${orderId}`);
            const order = response.data ? response.data : response;

            // Her ürünü sepete ekle (Yeni .NET DTO formatına göre)
            for (const item of (order.orderItems || [])) {
                await apiCall('cart', {
                    method: 'POST',
                    body: JSON.stringify({
                        productId: item.productId, // .NET tarafı muhtemelen productId bekler
                        quantity: item.quantity
                    })
                });
            }

            showToast('Ürünler sepete eklendi!', 'success');
            setTimeout(() => {
                window.location.href = '/cart';
            }, 1000);

        } catch (error) {
            showToast(error.message || 'Bir hata oluştu', 'error');
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>