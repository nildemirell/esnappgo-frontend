<?php
// Esnaf kontrolü
if (!$current_user || ($current_user['role'] !== 'merchant' && $current_user['role'] !== 'esnaf')) {
    header('Location: /dashboard');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Ürün Yönetimi</h1>
                    <p class="text-gray-600">Öğrenciler tarafından paylaşılan ürünleri onaylayın ve fiyatlandırın</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="text-2xl font-bold text-blue-600" id="total-products-count">-</div>
                    <div class="text-sm text-gray-500">Toplam Ürün</div>
                </div>
            </div>
        </div>
        
        <!-- Status Filter -->
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow-sm p-1">
                <div class="flex space-x-1">
                    <button onclick="filterProducts('pending')" class="status-filter-btn active flex-1 px-4 py-3 text-sm font-medium rounded-md transition-all">
                        <span class="mr-2">⏳</span>
                        Onay Bekleyen
                        <span id="pending-count" class="ml-2 bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">0</span>
                    </button>
                    <button onclick="filterProducts('active')" class="status-filter-btn flex-1 px-4 py-3 text-sm font-medium rounded-md transition-all">
                        <span class="mr-2">✅</span>
                        Onaylanmış
                        <span id="active-count" class="ml-2 bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">0</span>
                    </button>
                    <button onclick="filterProducts('rejected')" class="status-filter-btn flex-1 px-4 py-3 text-sm font-medium rounded-md transition-all">
                        <span class="mr-2">❌</span>
                        Reddedilen
                        <span id="rejected-count" class="ml-2 bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">0</span>
                    </button>
                    <button onclick="filterProducts('all')" class="status-filter-btn flex-1 px-4 py-3 text-sm font-medium rounded-md transition-all">
                        <span class="mr-2">📋</span>
                        Tümü
                        <span id="all-count" class="ml-2 bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">0</span>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div id="merchant-products-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Loading skeleton -->
            <?php for ($i = 0; $i < 6; $i++): ?>
            <div class="animate-pulse">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="bg-gray-200 h-48 rounded-lg mb-4"></div>
                    <div class="h-4 bg-gray-200 rounded mb-2"></div>
                    <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                    <div class="h-8 bg-gray-200 rounded"></div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
        
        <!-- Empty Products -->
        <div id="empty-products" class="text-center py-12" style="display: none;">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz ürün yok</h3>
            <p class="text-gray-500">Öğrenciler ürün paylaştığında burada görünecek.</p>
        </div>
    </div>
</div>

<!-- Product Edit Modal -->
<div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Ürünü Düzenle</h3>
            
            <form id="edit-form">
                <input type="hidden" id="edit-product-id" />
                
                <div class="mb-4">
                    <label for="edit_price" class="block text-sm font-medium text-gray-700 mb-2">
                        Fiyat
                    </label>
                    <input
                        type="number"
                        id="edit_price"
                        name="edit_price"
                        step="0.01"
                        min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    />
                </div>
                
                <div class="mb-4">
                    <label for="edit_stock" class="block text-sm font-medium text-gray-700 mb-2">
                        Stok Miktarı
                    </label>
                    <div class="text-xs text-gray-500 mb-2">
                        Mevcut stok: <span id="current-stock-display">0</span> adet
                    </div>
                    <input
                        type="number"
                        id="edit_stock"
                        name="edit_stock"
                        min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    />
                    <div class="text-xs text-gray-500 mt-1">
                        Fiziksel satışlar için stok miktarını manuel olarak güncelleyebilirsiniz. Online satışlarda stok otomatik düşer.
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition-colors">
                        İptal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Güncelle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Product Approval Modal -->
<div id="approval-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Ürünü Onayla</h3>
            
            <form id="approval-form">
                <input type="hidden" id="modal-product-id" />
                
                <div class="mb-4">
                    <label for="final_price" class="block text-sm font-medium text-gray-700 mb-2">
                        Final Fiyat
                    </label>
                    <input
                        type="number"
                        id="final_price"
                        name="final_price"
                        step="0.01"
                        min="0"
                        class="w-full"
                        required
                    />
                </div>
                
                <div class="mb-4">
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                        Stok Miktarı
                    </label>
                    <input
                        type="number"
                        id="stock"
                        name="stock"
                        min="1"
                        class="w-full"
                        required
                    />
                </div>
                
                <div class="mb-6">
                    <label for="merchant_notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Notlar (Opsiyonel)
                    </label>
                    <textarea
                        id="merchant_notes"
                        name="merchant_notes"
                        rows="3"
                        class="w-full"
                        placeholder="Ürün hakkında ek bilgiler..."
                    ></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeApprovalModal()" class="btn btn-outline">
                        İptal
                    </button>
                    <button type="submit" class="btn btn-success">
                        Onayla
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let allProducts = [];
let currentFilter = 'pending';

document.addEventListener('DOMContentLoaded', function() {
    loadMerchantProducts();
    
    document.getElementById('approval-form').addEventListener('submit', handleProductApproval);
    
    // Edit form event listener
    document.getElementById('edit-form').addEventListener('submit', handleProductEdit);
    
    // Event delegation for dynamically created buttons
    document.addEventListener('click', function(e) {
        console.log('Click detected on:', e.target);
        
        if (e.target.closest('.edit-product-btn')) {
            const button = e.target.closest('.edit-product-btn');
            const productId = parseInt(button.dataset.productId);
            console.log('Edit button clicked for product:', productId);
            console.log('Button element:', button);
            e.preventDefault();
            e.stopPropagation();
            editProduct(productId);
        }
        
        if (e.target.closest('.suspend-product-btn')) {
            const productId = parseInt(e.target.closest('.suspend-product-btn').dataset.productId);
            console.log('Suspend button clicked for product:', productId);
            suspendProduct(productId);
        }
        
        if (e.target.closest('.approve-product-btn')) {
            const productId = parseInt(e.target.closest('.approve-product-btn').dataset.productId);
            console.log('Approve button clicked for product:', productId);
            openApprovalModal(productId);
        }
        
        if (e.target.closest('.reject-product-btn')) {
            const productId = parseInt(e.target.closest('.reject-product-btn').dataset.productId);
            console.log('Reject button clicked for product:', productId);
            rejectProduct(productId);
        }
        
        if (e.target.closest('.view-product-btn')) {
            const productId = parseInt(e.target.closest('.view-product-btn').dataset.productId);
            console.log('View button clicked for product:', productId);
            viewProduct(productId);
        }
        
        if (e.target.closest('.reactivate-product-btn')) {
            const productId = parseInt(e.target.closest('.reactivate-product-btn').dataset.productId);
            console.log('Reactivate button clicked for product:', productId);
            reactivateProduct(productId);
        }
    });
});

async function loadMerchantProducts() {
    try {
        const token = localStorage.getItem('auth_token');
        const res = await fetch(`${API_BASE}/api/Products/merchant/pending`, {
            headers: { 'Authorization': `Bearer ${token}` }
        });

        if (!res.ok) throw new Error('Ürünler yüklenemedi');
        const data = await res.json();

        // Backend → Frontend mapping (UI alanlarını koruyoruz)
        allProducts = data.map(p => ({
            id: p.id,
            title: p.name,                             // backend "name" → frontend "title"
            description: '',                            // ❌ backend'de yok
            price: p.finalPrice || p.suggestedPrice,
            suggested_price: p.suggestedPrice,
            status: (p.status || '').toLowerCase(),     // "Pending" → "pending"
            images: p.imageUrls || [],
            stock: 0,                                   // ❌ backend'de yok
            student_name: p.studentName,
            created_at: null
        }));

        updateProductCounts();
        const pendingProducts = allProducts.filter(p => p.status === 'pending');
        displayProducts(pendingProducts);
    } catch (error) {
        console.error('Error loading merchant products:', error);
    }
}

// loadProducts alias for consistency
async function loadProducts() {
    await loadMerchantProducts();
}

function displayProducts(products) {
    const container = document.getElementById('merchant-products-container');
    console.log('Displaying products:', products);
    
    // Debug images for each product
    products.forEach(product => {
        console.log(`Product ${product.id} images:`, product.images);
        console.log(`Product ${product.id} image type:`, typeof product.images);
        console.log(`Product ${product.id} is array:`, Array.isArray(product.images));
    });
    
    if (products.length === 0) {
        container.innerHTML = '';
        document.getElementById('empty-products').style.display = 'block';
        return;
    }
    
    document.getElementById('empty-products').style.display = 'none';
    
    container.innerHTML = products.map(product => `
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <div class="relative h-56 bg-gradient-to-br from-gray-100 to-gray-200">
                ${product.images && Array.isArray(product.images) && product.images.length > 0 ? `
                    <img 
                        src="/${product.images[0]}" 
                        alt="${escapeHtml(product.title)}"
                        class="w-full h-full object-cover"
                        onload="console.log('Image loaded successfully:', this.src)"
                        onerror="console.error('Image failed to load:', this.src); this.parentElement.innerHTML='<div class=\"w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200\"><div class=\"text-4xl mb-2\">📷</div><div class=\"text-gray-500 text-sm\">Görsel Yüklenemedi</div></div>'"
                    />
                ` : `
                    <div class="w-full h-full flex flex-col items-center justify-center">
                        <div class="text-4xl mb-2">📦</div>
                        <div class="text-gray-500 text-sm">Görsel Yok</div>
                    </div>
                `}
                
                <!-- Status Badge -->
                <div class="absolute top-3 right-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ${getStatusBadgeClass(product.status)}">
                        ${getStatusIcon(product.status)} ${getStatusText(product.status)}
                    </span>
                </div>
                
            </div>
            
            <div class="p-6">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-bold text-lg text-gray-900 leading-tight">
                        ${escapeHtml(product.title)}
                    </h3>
                    <div class="text-right ml-2">
                        <div class="text-2xl font-bold text-blue-600">₺${parseFloat(product.price || product.suggested_price || 0).toFixed(2)}</div>
                    </div>
                </div>
                
                <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                    ${escapeHtml(product.description)}
                </p>
                
                <!-- Price and Stock Info -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    ${product.status === 'pending' ? `
                        <div class="bg-yellow-50 rounded-lg p-3">
                            <div class="text-xs text-yellow-600 font-medium mb-1">Önerilen Fiyat</div>
                            <div class="text-lg font-bold text-yellow-800">₺${parseFloat(product.suggested_price || product.price || 0).toFixed(2)}</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="text-xs text-gray-600 font-medium mb-1">Durum</div>
                            <div class="text-sm font-medium text-gray-800">Onay Bekliyor</div>
                        </div>
                    ` : `
                        <div class="bg-green-50 rounded-lg p-3">
                            <div class="text-xs text-green-600 font-medium mb-1">Satış Fiyatı</div>
                            <div class="text-lg font-bold text-green-800">₺${parseFloat(product.price).toFixed(2)}</div>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-3">
                            <div class="text-xs text-blue-600 font-medium mb-1">Stok</div>
                            <div class="text-lg font-bold text-blue-800">${product.stock || 0} <span class="text-xs font-normal">adet</span></div>
                        </div>
                    `}
                </div>
                
                <!-- Student Info -->
                <div class="flex items-center mb-4 text-xs text-gray-500 bg-gray-50 rounded-lg p-2">
                    <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-2">
                        ${product.student_name ? product.student_name.charAt(0).toUpperCase() : 'Ö'}
                    </div>
                    <span>Paylaşan: <strong>${product.student_name || 'Bilinmeyen'}</strong></span>
                    <span class="mx-2">•</span>
                    <span>${formatDate(product.created_at)}</span>
                </div>
                
                <!-- Actions -->
                <div class="flex flex-col space-y-2">
                    ${product.status === 'pending' ? `
                        <button type="button" data-product-id="${product.id}" class="approve-product-btn w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center">
                            <span class="mr-2">✅</span> Ürünü Onayla
                        </button>
                        <button type="button" data-product-id="${product.id}" class="reject-product-btn w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                            <span class="mr-2">❌</span> Reddet
                        </button>
                    ` : product.status === 'active' ? `
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" data-product-id="${product.id}" class="edit-product-btn bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center text-sm">
                                <span class="mr-1">✏️</span> Düzenle
                            </button>
                            <button type="button" data-product-id="${product.id}" class="suspend-product-btn bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center text-sm">
                                <span class="mr-1">⏸️</span> Askıya Al
                            </button>
                        </div>
                    ` : product.status === 'rejected' ? `
                        <button type="button" data-product-id="${product.id}" class="view-product-btn w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                            <span class="mr-2">👁️</span> Görüntüle
                        </button>
                    ` : `
                        <button type="button" data-product-id="${product.id}" class="reactivate-product-btn w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                            <span class="mr-2">🔄</span> Tekrar Aktifleştir
                        </button>
                    `}
                </div>
            </div>
        </div>
    `).join('');
}

function filterProducts(status) {
    currentFilter = status;
    
    // Update active button
    const buttons = document.querySelectorAll('.status-filter-btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Filter products
    let filteredProducts = allProducts;
    if (status !== 'all') {
        filteredProducts = allProducts.filter(product => product.status === status);
    }
    
    displayProducts(filteredProducts);
}

function openApprovalModal(productId) {
    const product = allProducts.find(p => p.id === productId);
    if (!product) return;
    
    document.getElementById('modal-product-id').value = productId;
    document.getElementById('final_price').value = product.suggested_price || product.price || 0;
    document.getElementById('stock').value = 10;
    
    document.getElementById('approval-modal').style.display = 'flex';
}

function closeApprovalModal() {
    document.getElementById('approval-modal').style.display = 'none';
}

async function handleProductApproval(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const productId = formData.get('product-id') || document.getElementById('modal-product-id').value;
    
    const data = {
        final_price: parseFloat(formData.get('final_price')),
        stock: parseInt(formData.get('stock')),
        notes: formData.get('merchant_notes')
    };
    
    try {
       const token = localStorage.getItem('auth_token');
const response = await fetch(`${API_BASE}/api/Products/merchant/${productId}/status`, {
    method: 'PUT',
    headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`
    },
    body: JSON.stringify({
        status: 'Approved',
        finalPrice: parseFloat(formData.get('final_price'))
        // stock → backend DTO'da yok, gönderilemez
    })
});

if (response.ok) {
    showToast('Ürün onaylandı!', 'success');
    closeApprovalModal();
    await loadMerchantProducts();
} else {
    const err = await response.json();
    throw new Error(err.error || err.message || 'Onaylama başarısız');
}

        
        if (response.success) {
            showToast('Ürün onaylandı!', 'success');
            closeApprovalModal();
            await loadProducts(); // Ürün listesini yeniden yükle
        }
        
    } catch (error) {
        showToast(error.message, 'error');
    }
}

async function rejectProduct(productId) {
    const reason = prompt('Reddetme sebebini belirtiniz:');
    if (!reason) return;
    
    try {
        const token = localStorage.getItem('auth_token');
        
        // Yeni fetch isteği
        const response = await fetch(`${API_BASE}/api/Products/merchant/${productId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                status: 'Rejected',
                reason: reason // Backend sebebi kaydetsin diye buraya ekledik
            })
        });
        
        // Standart fetch kullandığımız için response.success yerine response.ok kullanıyoruz
        if (response.ok) {
            showToast('Ürün reddedildi', 'success');
            await loadProducts(); // Ürün listesini yeniden yükle
        } else {
            // Eğer sunucudan 200 OK dönmezse hata fırlatıyoruz
            throw new Error('İşlem başarısız oldu.');
        }
        
    } catch (error) {
        showToast('Ürün reddedilirken hata oluştu: ' + error.message, 'error');
    }
}
// Ürün düzenleme fonksiyonu
async function editProduct(productId) {
    console.log('Edit product called with ID:', productId);
    const product = allProducts.find(p => p.id === productId);
    console.log('Found product:', product);
    if (!product) {
        console.error('Product not found!');
        showToast('Ürün bulunamadı!', 'error');
        return;
    }
    
    openEditModal(productId);
}

// Ürün askıya alma fonksiyonu
async function suspendProduct(productId) {
    if (!(await openCustomModal('Bu ürünü askıya almak istediğinizden emin misiniz?'))) {
        return;
    }
    
    try {
        const response = await apiCall(`merchant/products/${productId}/suspend`, {
            method: 'PUT'
        });
        
        if (response.success) {
            showToast('Ürün askıya alındı', 'success');
            await loadProducts();
        }
    } catch (error) {
        showToast('Ürün askıya alınırken hata oluştu: ' + error.message, 'error');
    }
}

// Ürün görüntüleme fonksiyonu
function viewProduct(productId) {
    window.open(`/product-detail?id=${productId}`, '_blank');
}


// Ürünü yeniden aktifleştirme
async function reactivateProduct(productId) {
    if (!(await openCustomModal('Bu ürünü tekrar aktifleştirmek istediğinizden emin misiniz?'))) {
        return;
    }
    
    try {
        const response = await apiCall(`merchant/products/${productId}/activate`, {
            method: 'PUT'
        });
        
        if (response.success) {
            showToast('Ürün tekrar aktifleştirildi', 'success');
            await loadProducts();
        }
    } catch (error) {
        showToast('Ürün aktifleştirilirken hata oluştu: ' + error.message, 'error');
    }
}


function getStatusText(status) {
    const statusTexts = {
        pending: 'Beklemede',
        active: 'Onaylandı',
        rejected: 'Reddedildi',
        suspended: 'Askıya Alındı'
    };
    return statusTexts[status] || status;
}

function getStatusBadgeClass(status) {
    const badgeClasses = {
        pending: 'bg-yellow-100 text-yellow-800 border border-yellow-200',
        active: 'bg-green-100 text-green-800 border border-green-200',
        rejected: 'bg-red-100 text-red-800 border border-red-200',
        suspended: 'bg-gray-100 text-gray-800 border border-gray-200'
    };
    return badgeClasses[status] || 'bg-gray-100 text-gray-800 border border-gray-200';
}

function getStatusIcon(status) {
    const icons = {
        pending: '⏳',
        active: '✅',
        rejected: '❌',
        suspended: '⏸️'
    };
    return icons[status] || '❓';
}

function updateProductCounts() {
    const counts = {
        pending: allProducts.filter(p => p.status === 'pending').length,
        active: allProducts.filter(p => p.status === 'active').length,
        rejected: allProducts.filter(p => p.status === 'rejected').length,
        all: allProducts.length
    };
    
    document.getElementById('pending-count').textContent = counts.pending;
    document.getElementById('active-count').textContent = counts.active;
    document.getElementById('rejected-count').textContent = counts.rejected;
    document.getElementById('all-count').textContent = counts.all;
    document.getElementById('total-products-count').textContent = counts.all;
}

function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('tr-TR', {
        month: 'short',
        day: 'numeric'
    });
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text.toString();
    return div.innerHTML;
}

// Stok güncelleme modalı fonksiyonları
function openEditModal(productId) {
    console.log('Opening edit modal for product ID:', productId);
    const product = allProducts.find(p => p.id === productId);
    console.log('Product for edit modal:', product);
    
    if (!product) {
        console.error('Product not found for edit modal!');
        showToast('Ürün bulunamadı!', 'error');
        return;
    }
    
    document.getElementById('edit-product-id').value = productId;
    document.getElementById('edit-price').value = product.price || 0;
    document.getElementById('edit-stock').value = product.stock || 0;
    document.getElementById('current-stock-display').textContent = product.stock || 0;
    
    console.log('Edit modal elements set, showing modal...');
    document.getElementById('edit-modal').style.display = 'flex';
}

function closeEditModal() {
    console.log('Closing edit modal');
    document.getElementById('edit-modal').style.display = 'none';
}

async function handleProductEdit(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const productId = document.getElementById('edit-product-id').value;
    
    const data = {
        price: parseFloat(formData.get('edit_price')),
        stock: parseInt(formData.get('edit_stock'))
    };
    
    try {
        const response = await apiCall(`merchant/products/${productId}/update`, {
            method: 'PUT',
            body: JSON.stringify(data)
        });
        
        if (response.success) {
            showToast('Ürün güncellendi!', 'success');
            closeEditModal();
            await loadProducts();
        }
        
    } catch (error) {
        showToast(error.message, 'error');
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const approvalModal = document.getElementById('approval-modal');
    const editModal = document.getElementById('edit-modal');
    
    if (e.target === approvalModal) {
        closeApprovalModal();
    }
    
    if (e.target === editModal) {
        closeEditModal();
    }
});
</script>

<style>
.status-filter-btn {
    color: rgb(75 85 99);
    background-color: rgb(249 250 251);
    border: 1px solid rgb(229 231 235);
    transition: all 0.3s ease;
}

.status-filter-btn:hover {
    background-color: rgb(243 244 246);
    border-color: rgb(209 213 219);
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.status-filter-btn.active {
    background-color: rgb(37 99 235);
    color: white;
    border-color: rgb(37 99 235);
    box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3);
}

/* Button styles */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.375rem;
    border: 1px solid transparent;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.15s ease-in-out;
    cursor: pointer;
    text-decoration: none;
}

.btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.btn-sm {
    padding: 0.25rem 0.75rem;
    font-size: 0.75rem;
}

.btn-success {
    background-color: rgb(34 197 94);
    color: white;
}

.btn-success:hover {
    background-color: rgb(22 163 74);
}

.btn-error {
    background-color: rgb(239 68 68);
    color: white;
}

.btn-error:hover {
    background-color: rgb(220 38 38);
}

.btn-warning {
    background-color: rgb(245 158 11);
    color: white;
}

.btn-warning:hover {
    background-color: rgb(217 119 6);
}

.btn-outline {
    background-color: transparent;
    border-color: rgb(209 213 219);
    color: rgb(75 85 99);
}

.btn-outline:hover {
    background-color: rgb(249 250 251);
    border-color: rgb(156 163 175);
}

/* Badge styles */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-success {
    background-color: rgb(220 252 231);
    color: rgb(22 101 52);
}

.badge-warning {
    background-color: rgb(254 243 199);
    color: rgb(146 64 14);
}

.badge-error {
    background-color: rgb(254 226 226);
    color: rgb(153 27 27);
}

.badge-gray {
    background-color: rgb(243 244 246);
    color: rgb(75 85 99);
}
</style>
