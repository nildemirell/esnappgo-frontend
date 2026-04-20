<?php
// Shop ID'sini al
if (!isset($shop_id) || !is_numeric($shop_id)) {
    header('Location: /shops');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="/shops" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Mağazalara Dön
            </a>
        </div>

        <!-- Shop Header -->
        <div id="shop-header" class="bg-white rounded-lg shadow-sm p-8 mb-8">
            <!-- Loading state -->
            <div id="shop-loading" class="animate-pulse">
                <div class="flex items-start space-x-6">
                    <div class="w-24 h-24 bg-gray-200 rounded-lg"></div>
                    <div class="flex-1">
                        <div class="h-6 bg-gray-200 rounded mb-2"></div>
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                    </div>
                </div>
            </div>

            <!-- Shop Content (Hidden initially) -->
            <div id="shop-content" style="display: none;">
                <div class="flex items-start space-x-6">
                    <div class="w-24 h-24 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h1 id="shop-name" class="text-3xl font-bold text-gray-900 mb-2"></h1>
                        <p id="shop-description" class="text-gray-600 mb-4"></p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">İletişim Bilgileri</h4>
                                <div class="space-y-1 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span id="shop-address"></span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        <span id="shop-phone"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Mağaza İstatistikleri</h4>
                                <div class="space-y-1 text-sm text-gray-600">
                                    <div class="flex justify-between">
                                        <span>Toplam Ürün:</span>
                                        <span id="shop-product-count">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Aktif Ürün:</span>
                                        <span id="shop-active-products">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Üye Olma:</span>
                                        <span id="shop-created-date">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Shop Products -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">Mağaza Ürünleri</h3>
                <div class="flex space-x-2">
                    <button onclick="filterShopProducts('all')" class="filter-btn active px-3 py-1 text-sm rounded-md">Tümü</button>
                    <button onclick="filterShopProducts('active')" class="filter-btn px-3 py-1 text-sm rounded-md">Aktif</button>
                    <button onclick="filterShopProducts('pending')" class="filter-btn px-3 py-1 text-sm rounded-md">Bekleyen</button>
                </div>
            </div>
            
            <div id="shop-products-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Loading skeleton -->
                <?php for ($i = 0; $i < 8; $i++): ?>
                <div class="animate-pulse">
                    <div class="bg-gray-200 h-48 rounded-lg mb-4"></div>
                    <div class="h-4 bg-gray-200 rounded mb-2"></div>
                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>

<script>
let currentShop = null;
let shopProducts = [];
let currentFilter = 'all';

document.addEventListener('DOMContentLoaded', function() {
    const shopId = <?php echo json_encode($shop_id); ?>;
    loadShop(shopId);
});

async function loadShop(shopId) {
    try {
        const response = await apiCall(`shops/${shopId}`);
        // apiCall { success, data } döndürür — data'yı çıkart
        currentShop = response.data || response;
        displayShop(currentShop);
        
    } catch (error) {
        console.error('Error loading shop:', error);
        showToast('Mağaza bulunamadı veya yüklenemedi: ' + error.message, 'error');
        setTimeout(() => { window.location.href = '/shops'; }, 2000);
    }
}

function displayShop(shop) {
    // Hide loading, show content
    document.getElementById('shop-loading').style.display = 'none';
    document.getElementById('shop-content').style.display = 'block';
    
        // Set shop info
    document.getElementById('shop-name').textContent = shop.shopName || shop.name || 'İsimsiz Mağaza';
    document.getElementById('shop-description').textContent = shop.description || 'Açıklama bulunmamaktadır.';
    document.getElementById('shop-address').textContent = shop.address || 'Adres bilgisi yok';
    document.getElementById('shop-phone').textContent = shop.phoneNumber || 'Telefon bilgisi yok';

    // Set stats
    const products = shop.products || [];
    document.getElementById('shop-product-count').textContent = products.length;
        document.getElementById('shop-active-products').textContent = products.filter(p => (p.status || '').toString().toLowerCase() === 'approved' || p.status === 'active').length;
    document.getElementById('shop-created-date').textContent = formatDate(shop.registrationDate);

    
    // Display products
    shopProducts = products;
    window._shopProducts = products; // navigateToProduct'un kullanması için
    displayShopProducts(products);
}

function displayShopProducts(products) {
    var container = document.getElementById('shop-products-container');

    if (products.length === 0) {
        container.innerHTML = '<div class="col-span-full text-center text-gray-500 py-8">Bu mağazada henüz ürün bulunmamaktadır.</div>';
        return;
    }

    container.innerHTML = products.map(function(product) {
        var displayName  = product.name  || product.title || 'İsimsiz Ürün';
        var displayPrice = product.finalPrice || product.suggestedPrice || product.price || 0;
        var imagesArr    = product.imageUrls || product.images || [];

        var imageHtml;
        if (imagesArr.length > 0) {
            var imageUrl = imagesArr[0];
            if (!imageUrl.startsWith('/') && !imageUrl.startsWith('http')) imageUrl = '/' + imageUrl;
            imageHtml = '<img src="' + imageUrl + '" alt="' + escapeHtml(displayName) +
                        '" class="w-full h-full object-contain object-center bg-white p-3 group-hover:scale-105 transition-transform duration-200"' +
                        ' onerror="this.src=\'/media/68a658361732a_1755732022.jpg\'" />';
        } else {
            imageHtml = '<div class="w-full h-full flex items-center justify-center bg-gray-200"><span class="text-4xl text-gray-400">📷</span></div>';
        }

        return '<a href="/products/' + product.id + '"' +
                   ' onclick="navigateToProduct(' + product.id + ')"' +
                   ' class="group">' +
            '<div class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-md transition-shadow">' +
                '<div class="relative h-48 bg-gray-100">' + imageHtml + '</div>' +
                '<div class="p-4">' +
                    '<h4 class="font-semibold text-gray-900 mb-2 line-clamp-1">' + escapeHtml(displayName) + '</h4>' +
                    '<p class="text-sm text-gray-600 mb-3 line-clamp-2">' + escapeHtml(product.description || '') + '</p>' +
                    '<div class="flex items-center justify-between">' +
                        '<span class="text-lg font-bold text-blue-600">₺' + parseFloat(displayPrice).toFixed(2) + '</span>' +
                        '<span class="text-xs text-gray-500">' + escapeHtml(product.categoryName || '') + '</span>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</a>';
    }).join('');
}

// Ürünü sessionStorage'a önbelleğe al — product-detail.php API'ye gitmeden okur
function navigateToProduct(productId) {
    try {
        var prod = (window._shopProducts || []).find(function(p) { return p.id == productId; });
        if (prod) sessionStorage.setItem('cached_product_' + productId, JSON.stringify(prod));
    } catch (e) { /* sessionStorage dolu veya devre dışı — sorun değil, API fallback çalışır */ }
}


function filterShopProducts(status) {
    currentFilter = status;
    
    // Update active button
    const buttons = document.querySelectorAll('.filter-btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Filter products
    let filteredProducts = shopProducts;
    if (status !== 'all') {
        filteredProducts = shopProducts.filter(product => product.status === status);
    }
    
    displayShopProducts(filteredProducts);
}

function getStatusText(status) {
    const statusTexts = {
        pending: 'Beklemede',
        active: 'Aktif',
        rejected: 'Reddedildi',
        suspended: 'Askıya Alındı'
    };
    return statusTexts[status] || status;
}

function getStatusBadgeClass(status) {
    const badgeClasses = {
        pending: 'warning',
        active: 'success',
        rejected: 'error',
        suspended: 'gray'
    };
    return badgeClasses[status] || 'gray';
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('tr-TR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>

<style>
.filter-btn {
    color: rgb(75 85 99);
    background-color: rgb(243 244 246);
    transition: all 0.2s;
}

.filter-btn:hover {
    background-color: rgb(229 231 235);
}

.filter-btn.active {
    background-color: rgb(37 99 235);
    color: white;
}
</style>
