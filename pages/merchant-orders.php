<?php
// Esnaf kontrolü
if (!$current_user || ($current_user['role'] !== 'merchant' && $current_user['role'] !== 'esnaf')) {
    header('Location: /dashboard');
    exit;
}

// MOCK DATA: Backend OrdersController henüz hazır olmadığı için UI Mock ile korunmuştur.
$orders = [
    [
        'id' => 1,
        'order_number' => 'ORD-2026-001',
        'customer_name' => 'Ahmet Yılmaz',
        'customer_phone' => '05551234567',
        'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
        'status' => 'pending',
        'total_amount' => 120.50,
        'tracking_number' => null,
        'payment_method' => 'bank_transfer',
        'items' => [
            [
                'title' => 'Calculus 1 Öğrenci Notu',
                'quantity' => 1,
                'unit_price' => 120.50,
                'images' => ['/media/mock-note.jpg']
            ]
        ]
    ]
];
?>
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Siparişler</h1>
            <p class="text-gray-600">Mağazanıza gelen siparişleri yönetin</p>
        </div>
        
        <!-- Status Filter -->
        <div class="mb-6">
            <div class="flex space-x-2">
                <button onclick="filterOrders('all')" class="status-filter-btn active px-4 py-2 text-sm rounded-md">
                    Tümü
                </button>
                <button onclick="filterOrders('pending')" class="status-filter-btn px-4 py-2 text-sm rounded-md">
                    Yeni
                </button>
                <button onclick="filterOrders('paid')" class="status-filter-btn px-4 py-2 text-sm rounded-md">
                    Ödendi
                </button>
                <button onclick="filterOrders('shipped')" class="status-filter-btn px-4 py-2 text-sm rounded-md">
                    Kargoda
                </button>
                <button onclick="filterOrders('delivered')" class="status-filter-btn px-4 py-2 text-sm rounded-md">
                    Teslim Edildi
                </button>
            </div>
        </div>
        
        <!-- Orders List -->
        <div id="merchant-orders-container" class="space-y-6">
            <?php if (empty($orders)): ?>
                <!-- Empty Orders -->
                <div class="text-center py-12 bg-white rounded-lg shadow-sm">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz sipariş yok</h3>
                    <p class="text-gray-500">Mağazanıza sipariş geldiğinde burada görünecek.</p>
                </div>
            <?php else: 
                foreach ($orders as $order): 
                    $status_classes = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'paid' => 'bg-blue-100 text-blue-800',
                        'shipped' => 'bg-indigo-100 text-indigo-800',
                        'delivered' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800'
                    ];
                    
                    $status_texts = [
                        'pending' => 'Yeni',
                        'paid' => 'Ödendi',
                        'shipped' => 'Kargoda',
                        'delivered' => 'Teslim Edildi',
                        'cancelled' => 'İptal Edildi'
                    ];
                    
                    $badge_class = $status_classes[$order['status']] ?? 'bg-gray-100 text-gray-800';
                    $status_text = $status_texts[$order['status']] ?? $order['status'];
            ?>
                <div class="bg-white rounded-lg shadow-sm p-6 order-item" data-status="<?php echo $order['status']; ?>">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Sipariş #<?php echo htmlspecialchars($order['order_number']); ?>
                            </h3>
                            <p class="text-sm text-gray-500">
                                <?php echo htmlspecialchars($order['customer_name']); ?> • 
                                <?php echo date('d M Y H:i', strtotime($order['created_at'])); ?>
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold <?php echo $badge_class; ?>">
                                <?php echo $status_text; ?>
                            </span>
                            <p class="text-lg font-bold text-gray-900 mt-1">
                                ₺<?php echo number_format($order['total_amount'], 2); ?>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Order Items -->
                    <div class="space-y-3 mb-4">
                        <?php foreach ($order['items'] as $item): 
                            $item_total = $item['quantity'] * $item['unit_price'];
                            // Resim yolunu düzelt
                            $image_url = '';
                            if (!empty($item['images']) && !empty($item['images'][0])) {
                                $img = $item['images'][0];
                                if (strpos($img, 'http') === 0) {
                                    $image_url = $img;
                                } elseif (strpos($img, '/') === 0) {
                                    $image_url = $img;
                                } else {
                                    $image_url = '/' . $img;
                                }
                            }
                        ?>
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <?php if (!empty($image_url)): ?>
                                        <img 
                                            src="<?php echo htmlspecialchars($image_url); ?>" 
                                            alt="<?php echo htmlspecialchars($item['title']); ?>"
                                            class="w-16 h-16 object-cover rounded-lg border border-gray-200"
                                            onerror="this.onerror=null;this.src='/media/68a658361732a_1755732022.jpg'"
                                        />
                                    <?php else: ?>
                                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">
                                        <?php echo htmlspecialchars($item['title']); ?>
                                    </h4>
                                    <p class="text-sm text-gray-500">
                                        <?php echo $item['quantity']; ?> adet × ₺<?php echo number_format($item['unit_price'], 2); ?>
                                    </p>
                                </div>
                                
                                <div class="text-sm font-medium text-gray-900">
                                    ₺<?php echo number_format($item_total, 2); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Customer Info -->
                    <div class="border-t border-gray-200 pt-4 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-1">Müşteri Bilgileri</h4>
                                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($order['customer_name']); ?></p>
                                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($order['customer_phone'] ?: 'Telefon belirtilmemiş'); ?></p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-1">Teslimat</h4>
                                <p class="text-sm text-gray-600">Mağazadan teslim</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Actions -->
                    <div class="flex justify-end space-x-3">
                        <?php if ($order['status'] === 'pending'): ?>
                            <button onclick="updateOrderStatus(<?php echo $order['id']; ?>, 'paid')" class="px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors">
                                Ödemeyi Onayla
                            </button>
                        <?php endif; ?>
                        
                        <?php if ($order['status'] === 'paid'): ?>
                            <button onclick="updateOrderStatus(<?php echo $order['id']; ?>, 'shipped')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                Kargoya Ver
                            </button>
                        <?php endif; ?>
                        
                        <?php if ($order['status'] === 'shipped'): ?>
                            <button onclick="updateOrderStatus(<?php echo $order['id']; ?>, 'delivered')" class="px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors">
                                Teslim Edildi
                            </button>
                        <?php endif; ?>
                        
                        <button onclick="viewOrderDetails(<?php echo $order['id']; ?>)" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                            Detaylar
                        </button>
                        
                        <?php if ($order['status'] === 'pending' || $order['status'] === 'paid'): ?>
                            <button onclick="cancelOrder(<?php echo $order['id']; ?>)" class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                İptal Et
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>

<!-- Order Detail Modal -->
<div id="merchant-order-modal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeOrderModal()"></div>
        
        <!-- Modal Content -->
        <div class="inline-block w-full max-w-3xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-2xl shadow-xl">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-white" id="merchant-modal-order-number">Sipariş Detayı</h3>
                        <p class="text-blue-200 text-sm" id="merchant-modal-order-date"></p>
                    </div>
                    <button onclick="closeOrderModal()" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div id="merchant-modal-body" class="p-6 max-h-[70vh] overflow-y-auto">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
// Sipariş verilerini PHP'den JavaScript'e aktar
const ordersData = <?php echo json_encode($orders); ?>;

let currentFilter = 'all';

function filterOrders(status) {
    currentFilter = status;
    
    // Update active button
    const buttons = document.querySelectorAll('.status-filter-btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Filter orders with CSS
    const orderItems = document.querySelectorAll('.order-item');
    orderItems.forEach(item => {
        if (status === 'all' || item.dataset.status === status) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
    
    // Check if any visible
    const visibleOrders = Array.from(orderItems).filter(item => item.style.display !== 'none');
    const emptyMessage = document.getElementById('empty-orders-filtered');
    
    if (visibleOrders.length === 0 && orderItems.length > 0) {
        if (!emptyMessage) {
            const container = document.getElementById('merchant-orders-container');
            const msg = document.createElement('div');
            msg.id = 'empty-orders-filtered';
            msg.className = 'text-center py-12 bg-white rounded-lg shadow-sm';
            msg.innerHTML = `
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p class="text-gray-500">Bu durumda sipariş bulunmuyor.</p>
            `;
            container.appendChild(msg);
        } else {
            emptyMessage.style.display = 'block';
        }
    } else if (emptyMessage) {
        emptyMessage.style.display = 'none';
    }
}

async function updateOrderStatus(orderId, newStatus) {
    try {
        const token = localStorage.getItem('auth_token');
        const response = await fetch(`${API_BASE}/api/Orders/update-status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            credentials: 'include',
            body: JSON.stringify({
                order_id: orderId,
                status: newStatus
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            showToast('Sipariş durumu başarıyla güncellendi!', 'success');
            
            // Sayfayı yenile
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showToast(result.message || 'Durum güncellenirken hata oluştu', 'error');
        }
        
    } catch (error) {
        console.error('Update error:', error);
        showToast('Durum güncellenirken hata oluştu', 'error');
    }
}

function viewOrderDetails(orderId) {
    // Sipariş verisini bul
    const order = ordersData.find(o => o.id == orderId);
    if (!order) {
        showToast('Sipariş bulunamadı', 'error');
        return;
    }
    
    // Modal başlık bilgileri
    document.getElementById('merchant-modal-order-number').textContent = `Sipariş #${order.order_number}`;
    document.getElementById('merchant-modal-order-date').textContent = formatDate(order.created_at);
    
    // Status badge ve text
    const statusClasses = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'paid': 'bg-blue-100 text-blue-800',
        'shipped': 'bg-indigo-100 text-indigo-800',
        'delivered': 'bg-green-100 text-green-800',
        'cancelled': 'bg-red-100 text-red-800'
    };
    const statusTexts = {
        'pending': 'Yeni Sipariş',
        'paid': 'Ödeme Onaylandı',
        'shipped': 'Kargoya Verildi',
        'delivered': 'Teslim Edildi',
        'cancelled': 'İptal Edildi'
    };
    const badgeClass = statusClasses[order.status] || 'bg-gray-100 text-gray-800';
    const statusText = statusTexts[order.status] || order.status;
    
    // Sipariş ürünlerinin toplamını hesapla
    let itemsTotal = 0;
    order.items.forEach(item => {
        itemsTotal += item.quantity * item.unit_price;
    });
    
    // Öğrenci desteği hesapla (toplam - ara toplam)
    const studentSupport = parseFloat(order.total_amount) - itemsTotal;
    
    // Modal içeriği
    const modalBody = document.getElementById('merchant-modal-body');
    modalBody.innerHTML = `
        <!-- Status Badge -->
        <div class="flex items-center justify-between mb-6">
            <span class="inline-flex px-4 py-2 rounded-full text-sm font-semibold ${badgeClass}">
                ${statusText}
            </span>
            ${order.tracking_number ? `<span class="text-sm text-gray-500">Takip No: ${order.tracking_number}</span>` : ''}
        </div>
        
        <!-- Müşteri Bilgileri -->
        <div class="bg-blue-50 rounded-xl p-5 mb-6">
            <h4 class="text-lg font-semibold text-blue-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Müşteri Bilgileri
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-blue-600">Ad Soyad:</span>
                    <span class="font-medium text-blue-900 ml-2">${escapeHtml(order.customer_name)}</span>
                </div>
                <div>
                    <span class="text-blue-600">Telefon:</span>
                    <span class="font-medium text-blue-900 ml-2">${order.customer_phone || 'Belirtilmemiş'}</span>
                </div>
            </div>
        </div>
        
        <!-- Sipariş Ürünleri -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Sipariş Edilen Ürünler
            </h4>
            <div class="space-y-3">
                ${order.items.map(item => {
                    let imgUrl = '';
                    if (item.images && item.images.length > 0) {
                        imgUrl = item.images[0];
                        if (!imgUrl.startsWith('/') && !imgUrl.startsWith('http')) {
                            imgUrl = '/' + imgUrl;
                        }
                    }
                    return `
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                ${imgUrl ? `
                                    <img src="${imgUrl}" alt="${escapeHtml(item.title)}" 
                                         class="w-16 h-16 object-cover rounded-lg border border-gray-200"
                                         onerror="this.onerror=null;this.src='/media/68a658361732a_1755732022.jpg'">
                                ` : `
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                `}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h5 class="font-medium text-gray-900">${escapeHtml(item.title)}</h5>
                                <p class="text-sm text-gray-500 mt-1">
                                    ${item.quantity} adet x ₺${parseFloat(item.unit_price).toFixed(2)}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="font-semibold text-gray-900">₺${(item.quantity * item.unit_price).toFixed(2)}</span>
                            </div>
                        </div>
                    `;
                }).join('')}
            </div>
        </div>
        
        ${studentSupport > 0.01 ? `
        <!-- Öğrenci Desteği -->
        <div class="mb-6 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-5 border border-purple-200">
            <h4 class="text-lg font-semibold text-purple-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                Öğrenci Desteği
            </h4>
            <p class="text-sm text-purple-600 mb-2">Bu siparişte müşteri öğrencilere destek oldu!</p>
            <div class="flex justify-between items-center text-purple-700 font-semibold">
                <span>Toplam Öğrenci Desteği</span>
                <span class="text-xl">₺${studentSupport.toFixed(2)}</span>
            </div>
        </div>
        ` : ''}
        
        <!-- Sipariş Özeti -->
        <div class="bg-gray-50 rounded-xl p-5 mb-6">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Sipariş Özeti
            </h4>
            <div class="space-y-3">
                <div class="flex justify-between text-gray-600">
                    <span>Ürünler Toplamı</span>
                    <span>₺${itemsTotal.toFixed(2)}</span>
                </div>
                ${studentSupport > 0.01 ? `
                    <div class="flex justify-between text-purple-600">
                        <span>Öğrenci Desteği</span>
                        <span>+₺${studentSupport.toFixed(2)}</span>
                    </div>
                ` : ''}
                <div class="flex justify-between text-gray-600">
                    <span>Kargo</span>
                    <span class="text-green-600">Ücretsiz</span>
                </div>
                <div class="pt-3 border-t border-gray-200 flex justify-between">
                    <span class="text-lg font-bold text-gray-900">Toplam</span>
                    <span class="text-lg font-bold text-blue-600">₺${parseFloat(order.total_amount).toFixed(2)}</span>
                </div>
            </div>
        </div>
        
        <!-- Ödeme Bilgileri -->
        <div class="bg-green-50 rounded-xl p-5 mb-6">
            <h4 class="text-lg font-semibold text-green-800 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                Ödeme Bilgileri
            </h4>
            <div class="text-sm">
                <div class="flex justify-between mb-2">
                    <span class="text-green-600">Ödeme Yöntemi</span>
                    <span class="font-medium text-green-800">${order.payment_method === 'bank_transfer' ? 'Havale/EFT' : (order.payment_method || 'Havale/EFT')}</span>
                </div>
                ${order.payment_id ? `
                    <div class="flex justify-between">
                        <span class="text-green-600">Dekont</span>
                        <a href="${order.payment_id}" target="_blank" class="font-medium text-green-800 hover:underline">Görüntüle</a>
                    </div>
                ` : ''}
            </div>
        </div>
        
        <!-- Sipariş Tarihleri -->
        <div class="border-t border-gray-200 pt-4">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Sipariş Geçmişi</h4>
            <div class="space-y-2 text-sm">
                <div class="flex items-center text-gray-600">
                    <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Sipariş Oluşturuldu: ${formatDate(order.created_at)}</span>
                </div>
                ${order.shipped_at ? `
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Kargoya Verildi: ${formatDate(order.shipped_at)}</span>
                    </div>
                ` : ''}
                ${order.delivered_at ? `
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Teslim Edildi: ${formatDate(order.delivered_at)}</span>
                    </div>
                ` : ''}
            </div>
        </div>
    `;
    
    // Modal'ı aç
    document.getElementById('merchant-order-modal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeOrderModal() {
    document.getElementById('merchant-order-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('tr-TR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ESC tuşu ile modal'ı kapat
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeOrderModal();
    }
});

async function cancelOrder(orderId) {
    if (!(await openCustomModal('Bu siparişi iptal etmek istediğinizden emin misiniz?<br><br>İptal edilen siparişler geri alınamaz.'))) {
        return;
    }
    
    try {
       const response = await fetch(`${API_BASE}/api/Orders/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            credentials: 'include',
            body: JSON.stringify({
                order_id: orderId
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            showToast('Sipariş başarıyla iptal edildi!', 'success');
            
            // Sayfayı yenile
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showToast(result.message || 'Sipariş iptal edilirken hata oluştu', 'error');
        }
        
    } catch (error) {
        console.error('Cancel error:', error);
        showToast('Sipariş iptal edilirken hata oluştu', 'error');
    }
}

// Gereksiz fonksiyonlar kaldırıldı - PHP'de render ediliyor
</script>

<style>
.status-filter-btn {
    color: rgb(75 85 99);
    background-color: rgb(243 244 246);
    transition: all 0.2s;
}

.status-filter-btn:hover {
    background-color: rgb(229 231 235);
}

.status-filter-btn.active {
    background-color: rgb(37 99 235);
    color: white;
}
</style>
