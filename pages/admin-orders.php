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
                        onkeyup="debounceOrders()"
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

// Debounce: kullanıcı yazmayı bırakınca 400ms bekle
let _orderFilterTimer = null;
function debounceOrders() {
    clearTimeout(_orderFilterTimer);
    _orderFilterTimer = setTimeout(() => loadOrders(), 400);
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
        const items = order.orderItems || order.items || order.OrderItems || [];

        // ── Durum konfigürasyonu ──────────────────────────────────────────────
        const STATUS_CONFIG = {
            pending:    { label: 'Beklemede',       color: '#D97706', bg: '#FEF3C7', dot: '#F59E0B' },
            processing: { label: 'İşleniyor',       color: '#2563EB', bg: '#DBEAFE', dot: '#3B82F6' },
            shipped:    { label: 'Kargoya Verildi', color: '#7C3AED', bg: '#EDE9FE', dot: '#8B5CF6' },
            delivered:  { label: 'Teslim Edildi',   color: '#059669', bg: '#D1FAE5', dot: '#10B981' },
            cancelled:  { label: 'İptal Edildi',    color: '#DC2626', bg: '#FEE2E2', dot: '#EF4444' },
        };
        const s     = (order.status || '').toLowerCase();
        const cfg   = STATUS_CONFIG[s] || { label: order.status, color: '#6B7280', bg: '#F3F4F6', dot: '#9CA3AF' };

        // ── Durum adımları (progress tracker) ────────────────────────────────
        const progressSteps = ['Beklemede', 'İşleniyor', 'Kargoya Verildi', 'Teslim Edildi'];
        const stepKeys      = ['pending', 'processing', 'shipped', 'delivered'];
        const currentStep   = stepKeys.indexOf(s);   // -1 = cancelled
        const isCancelled   = s === 'cancelled';

        const progressHtml = isCancelled
            ? `<div style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:#FEF2F2;border-radius:10px;border:1px solid #FECACA">
                   <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                   <span style="font-size:13px;font-weight:600;color:#DC2626">Sipariş İptal Edildi</span>
               </div>`
            : progressSteps.map((step, i) => {
                const done    = i < currentStep;
                const active  = i === currentStep;
                const dotC    = done || active ? '#2563EB' : '#D1D5DB';
                const lineC   = done ? '#2563EB' : '#E5E7EB';
                const labelC  = active ? '#111827' : done ? '#374151' : '#9CA3AF';
                const weight  = active ? '600' : done ? '500' : '400';
                const line    = i < progressSteps.length - 1
                    ? `<div style="flex:1;height:2px;background:${lineC};margin:0 4px"></div>` : '';
                return `
                    <div style="display:flex;align-items:center;flex:1">
                        <div style="display:flex;flex-direction:column;align-items:center;gap:4px">
                            <div style="width:28px;height:28px;border-radius:50%;background:${done || active ? '#EFF6FF' : '#F9FAFB'};border:2px solid ${dotC};display:flex;align-items:center;justify-content:center">
                                ${done
                                    ? `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`
                                    : `<div style="width:8px;height:8px;border-radius:50%;background:${dotC}"></div>`
                                }
                            </div>
                            <span style="font-size:10px;font-weight:${weight};color:${labelC};white-space:nowrap">${step}</span>
                        </div>
                        ${line}
                    </div>`;
            }).join('');

        // ── Ürün satırları ────────────────────────────────────────────────────
        const itemsHtml = items.length > 0 ? items.map(item => {
            const imgUrl = item.productImageUrl || item.ProductImageUrl || '';
            const imgEl  = imgUrl
                ? `<img src="${imgUrl}" alt="" style="width:56px;height:56px;border-radius:10px;object-fit:cover;border:1px solid #F3F4F6;flex-shrink:0">`
                : `<div style="width:56px;height:56px;border-radius:10px;background:#F9FAFB;border:1px solid #F3F4F6;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                       <svg width="22" height="22" fill="none" stroke="#D1D5DB" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                   </div>`;
            const name  = escapeHtml(item.productName || item.ProductName || 'Ürün');
            const qty   = item.quantity || 1;
            const price = parseFloat(item.unitPrice || 0);
            const total = parseFloat(item.totalPrice || price * qty);
            return `
                <div style="display:flex;align-items:center;gap:14px;padding:14px 0;border-bottom:1px solid #F9FAFB">
                    ${imgEl}
                    <div style="flex:1;min-width:0">
                        <p style="font-size:14px;font-weight:600;color:#111827;margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${name}</p>
                        <p style="font-size:12px;color:#9CA3AF;margin:4px 0 0">${qty} adet × ₺${price.toFixed(2)}</p>
                    </div>
                    <span style="font-size:14px;font-weight:700;color:#111827;flex-shrink:0">₺${total.toFixed(2)}</span>
                </div>`;
        }).join('') : `<p style="text-align:center;color:#9CA3AF;padding:24px 0;font-size:14px">Ürün bilgisi bulunamadı.</p>`;

        // ── Fiyat özeti ────────────────────────────────────────────────────────
        const subtotal = parseFloat(order.subtotal || order.totalAmount || 0);
        const shipping = parseFloat(order.shippingCost || 0);
        const support  = parseFloat(order.studentSupportAmount || 0);
        const total    = parseFloat(order.totalAmount || 0);

        const priceHtml = `
            <div style="padding-top:14px;border-top:1px dashed #E5E7EB;margin-top:6px">
                <div style="display:flex;justify-content:space-between;font-size:13px;color:#6B7280;margin-bottom:8px">
                    <span>Ara Toplam</span><span>₺${subtotal.toFixed(2)}</span>
                </div>
                ${shipping > 0 ? `<div style="display:flex;justify-content:space-between;font-size:13px;color:#6B7280;margin-bottom:8px"><span>Kargo Ücreti</span><span>₺${shipping.toFixed(2)}</span></div>` : ''}
                ${support > 0 ? `<div style="display:flex;justify-content:space-between;font-size:13px;color:#059669;margin-bottom:8px"><span>📚 Öğrenci Desteği</span><span>+₺${support.toFixed(2)}</span></div>` : ''}
                <div style="display:flex;justify-content:space-between;font-size:15px;font-weight:700;color:#111827;padding-top:10px;border-top:2px solid #F3F4F6;margin-top:4px">
                    <span>Genel Toplam</span><span>₺${total.toFixed(2)}</span>
                </div>
            </div>`;

        // ── Zaman çizelgesi (sağ kolon) ──────────────────────────────────────
        const timelineData = [
            { key: 'createdAt',          label: 'Sipariş Oluşturuldu', icon: '🛒' },
            { key: 'paymentConfirmedAt', label: 'Ödeme Onaylandı',     icon: '💳' },
            { key: 'shippedAt',          label: 'Kargoya Verildi',     icon: '📦' },
            { key: 'deliveredAt',        label: 'Teslim Edildi',       icon: '✅' },
        ];
        const timelineHtml = timelineData.map(step => {
            const date = order[step.key];
            return `
                <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:12px">
                    <div style="width:32px;height:32px;border-radius:50%;background:${date ? '#EFF6FF' : '#F9FAFB'};border:1.5px solid ${date ? '#BFDBFE' : '#E5E7EB'};display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0">${step.icon}</div>
                    <div>
                        <p style="font-size:13px;font-weight:${date ? '600' : '400'};color:${date ? '#111827' : '#9CA3AF'};margin:0">${step.label}</p>
                        <p style="font-size:11px;color:#9CA3AF;margin:2px 0 0">${date ? formatDate(date) : 'Henüz gerçekleşmedi'}</p>
                    </div>
                </div>`;
        }).join('');

        // ── Dialog oluştur ────────────────────────────────────────────────────
        const existing = document.getElementById('order-detail-dialog');
        if (existing) existing.remove();

        const dialog = document.createElement('div');
        dialog.id = 'order-detail-dialog';
        dialog.innerHTML = `
            <!-- Backdrop -->
            <div id="od-backdrop" style="position:fixed;inset:0;background:rgba(15,23,42,0.55);backdrop-filter:blur(4px);z-index:9998;opacity:0;transition:opacity 0.25s"></div>

            <!-- Dialog -->
            <div id="od-box" style="position:fixed;top:50%;left:50%;transform:translate(-50%,-48%) scale(0.97);z-index:9999;width:92%;max-width:880px;max-height:90vh;background:#fff;border-radius:20px;box-shadow:0 25px 60px rgba(0,0,0,0.2);display:flex;flex-direction:column;overflow:hidden;opacity:0;transition:transform 0.25s ease,opacity 0.25s ease">

                <!-- ── HEADER ── -->
                <div style="display:flex;align-items:center;justify-content:space-between;padding:20px 28px;border-bottom:1px solid #F3F4F6;flex-shrink:0">
                    <div style="display:flex;align-items:center;gap:14px">
                        <div>
                            <h2 style="font-size:18px;font-weight:700;color:#111827;margin:0">Sipariş Detayı</h2>
                            <p style="font-size:12px;color:#9CA3AF;margin:3px 0 0">
                                #${escapeHtml(order.orderNumber || String(order.id))} &nbsp;·&nbsp; ${formatDate(order.createdAt)}
                            </p>
                        </div>
                        <span style="display:inline-flex;align-items:center;padding:4px 12px;border-radius:999px;font-size:12px;font-weight:600;background:${cfg.bg};color:${cfg.color}">${cfg.label}</span>
                    </div>
                    <button id="od-close" style="width:36px;height:36px;border-radius:10px;border:1px solid #E5E7EB;background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background 0.15s" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='#fff'">
                        <svg width="18" height="18" fill="none" stroke="#6B7280" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- ── PROGRESS TRACKER ── -->
                <div style="padding:16px 28px;border-bottom:1px solid #F9FAFB;background:#FAFAFA;flex-shrink:0">
                    <div style="display:flex;align-items:center;gap:0">
                        ${progressHtml}
                    </div>
                </div>

                <!-- ── BODY (2 KOLON) ── -->
                <div style="display:grid;grid-template-columns:1fr 340px;gap:0;flex:1;overflow:hidden;min-height:0">

                    <!-- Sol: Ürünler + Fiyat özeti -->
                    <div style="overflow-y:auto;padding:24px 28px;border-right:1px solid #F3F4F6">
                        <h3 style="font-size:13px;font-weight:600;color:#374151;text-transform:uppercase;letter-spacing:.05em;margin:0 0 4px">
                            Ürünler · ${items.length} kalem
                        </h3>
                        <div>
                            ${itemsHtml}
                        </div>
                        ${priceHtml}
                    </div>

                    <!-- Sağ: Sipariş bilgisi + Adres + Zaman çizelgesi -->
                    <div style="overflow-y:auto;padding:24px 24px;background:#FAFAFA">

                        <!-- Bilgi kartları -->
                        <h3 style="font-size:13px;font-weight:600;color:#374151;text-transform:uppercase;letter-spacing:.05em;margin:0 0 12px">Sipariş Bilgisi</h3>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:20px">
                            <div style="background:#fff;border:1px solid #E5E7EB;border-radius:12px;padding:12px">
                                <p style="font-size:11px;color:#9CA3AF;margin:0 0 4px">Ödeme Yöntemi</p>
                                <p style="font-size:13px;font-weight:600;color:#111827;margin:0">${escapeHtml(order.paymentMethod || 'Belirtilmemiş')}</p>
                            </div>
                            <div style="background:#fff;border:1px solid #E5E7EB;border-radius:12px;padding:12px">
                                <p style="font-size:11px;color:#9CA3AF;margin:0 0 4px">Toplam Tutar</p>
                                <p style="font-size:13px;font-weight:700;color:#111827;margin:0">₺${total.toFixed(2)}</p>
                            </div>
                        </div>

                        <!-- Teslimat Adresi -->
                        ${order.shippingAddress ? `
                        <h3 style="font-size:13px;font-weight:600;color:#374151;text-transform:uppercase;letter-spacing:.05em;margin:0 0 10px">Teslimat Adresi</h3>
                        <div style="background:#fff;border:1px solid #E5E7EB;border-radius:12px;padding:14px;margin-bottom:20px;display:flex;gap:10px;align-items:flex-start">
                            <svg width="16" height="16" fill="none" stroke="#9CA3AF" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <p style="font-size:13px;color:#374151;margin:0;line-height:1.5">${escapeHtml(order.shippingAddress)}</p>
                        </div>` : ''}

                        <!-- Zaman çizelgesi -->
                        <h3 style="font-size:13px;font-weight:600;color:#374151;text-transform:uppercase;letter-spacing:.05em;margin:0 0 14px">Süreç Takibi</h3>
                        ${timelineHtml}
                    </div>

                </div><!-- /body -->

                <!-- ── FOOTER ── -->
                <div style="padding:16px 28px;border-top:1px solid #F3F4F6;display:flex;justify-content:flex-end;gap:10px;flex-shrink:0;background:#fff">
                    <button id="od-close2" style="padding:9px 20px;border-radius:10px;border:1px solid #E5E7EB;background:#fff;font-size:13px;font-weight:500;color:#374151;cursor:pointer">Kapat</button>
                    ${(order.status?.toLowerCase() === 'pending' || order.status?.toLowerCase() === 'processing') ? `
                    <button onclick="cancelOrder('${order.id}'); document.getElementById('od-backdrop').click()" style="padding:9px 20px;border-radius:10px;border:none;background:#FEE2E2;font-size:13px;font-weight:600;color:#DC2626;cursor:pointer">Siparişi İptal Et</button>` : ''}
                </div>

            </div><!-- /od-box -->
        `;
        document.body.appendChild(dialog);

        // Animasyonla aç
        requestAnimationFrame(() => {
            document.getElementById('od-backdrop').style.opacity = '1';
            const box = document.getElementById('od-box');
            box.style.opacity = '1';
            box.style.transform = 'translate(-50%,-50%) scale(1)';
        });

        function closeDialog() {
            document.getElementById('od-backdrop').style.opacity = '0';
            const box = document.getElementById('od-box');
            box.style.opacity = '0';
            box.style.transform = 'translate(-50%,-48%) scale(0.97)';
            setTimeout(() => { dialog.remove(); }, 250);
        }
        document.getElementById('od-close').addEventListener('click', closeDialog);
        document.getElementById('od-close2').addEventListener('click', closeDialog);
        document.getElementById('od-backdrop').addEventListener('click', closeDialog);

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
