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
                <span class="text-gray-900">Ürünler</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900">Ürün Yönetimi</h1>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Aktif Ürün</p>
                        <p class="text-2xl font-bold text-gray-900" id="active-products">-</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Bekleyen</p>
                        <p class="text-2xl font-bold text-gray-900" id="pending-products">-</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Reddedilen</p>
                        <p class="text-2xl font-bold text-gray-900" id="rejected-products">-</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Toplam Satış</p>
                        <p class="text-2xl font-bold text-gray-900" id="total-sales">₺0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        Ara
                    </label>
                    <input type="text" id="search" placeholder="Ürün adı ara..." class="w-full"
                        onkeyup="filterProducts()" />
                </div>

                <div>
                    <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-2">
                        Durum
                    </label>
                    <select id="status-filter" class="w-full" onchange="filterProducts()">
                        <option value="">Tüm Durumlar</option>
                        <option value="pending">Beklemede</option>
                        <option value="active">Aktif</option>
                        <option value="rejected">Reddedildi</option>
                        <option value="suspended">Askıya Alındı</option>
                    </select>
                </div>

                <div>
                    <label for="student-filter" class="block text-sm font-medium text-gray-700 mb-2">
                        Öğrenci
                    </label>
                    <select id="student-filter" class="w-full" onchange="filterProducts()">
                        <option value="">Tüm Öğrenciler</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button onclick="exportProducts()" class="btn btn-outline w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Dışa Aktar
                    </button>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div id="products-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Loading skeleton -->
            <?php for ($i = 0; $i < 8; $i++): ?>
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
    </div>
</div>

<script>
    let allProducts = [];
    let filteredProducts = [];

    document.addEventListener('DOMContentLoaded', function () {
        loadProducts();
        loadProductStats();
    });

    async function loadProducts() {
        try {
            const response = await apiCall('Admin/products'); // Baş harf büyük güvenli

            // .NET backend dizi döner (success sarmalayıcısı yoktur)
            if (Array.isArray(response)) {
                allProducts = response;

                filteredProducts = [...allProducts];
                displayProducts();
                loadProductStats();
            } else {
                throw new Error(response.message || 'Ürünler yüklenemedi');
            }

        } catch (error) {
            console.error('Error loading products:', error);
            showToast('Ürünler yüklenirken hata oluştu: ' + error.message, 'error');
        }
    }

    function displayProducts() {
        const container = document.getElementById('products-container');

        container.innerHTML = filteredProducts.map(product => `
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="relative h-48 bg-gray-100">
                               ${product.imageUrls && product.imageUrls.length > 0 ? (() => {
                let imageUrl = product.imageUrls[0];
                if (!imageUrl.startsWith('/') && !imageUrl.startsWith('http')) {
                    imageUrl = '/' + imageUrl;
                }
                return `
                        <img 
                            src="${imageUrl}" 
                            alt="${escapeHtml(product.name)}"

                            class="w-full h-full object-cover"
                            onerror="this.src='/media/68a658361732a_1755732022.jpg'"
                        />
                    `;
            })() : `
                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                        <span class="text-gray-400">📷</span>
                    </div>
                `}
                
                <!-- Status Badge -->
                <div class="absolute top-2 right-2">
                    <span class="badge badge-${getStatusBadgeClass(product.status)}">
                        ${getStatusText(product.status)}
                    </span>
                </div>
            </div>
            
                       <div class="p-4">
                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-1">
                    ${escapeHtml(product.name)}
                </h3>
                
                <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                    ${escapeHtml(product.categoryName || 'Kategori Yok')}
                </p>
                
                <div class="flex items-center justify-between mb-3">
                    <span class="text-lg font-bold text-blue-600">
                        ₺${parseFloat(product.finalPrice || product.suggestedPrice).toFixed(2)}
                    </span>
                    <span class="text-sm text-gray-500">
                        Satıcı: ${product.merchantName || '-'}
                    </span>
                </div>
                
                <div class="text-xs text-gray-500 mb-4">
                    Öğrenci: ${product.studentName || 'Bilinmiyor'}
                </div>

                
                <!-- Actions -->
                <div class="flex space-x-2">
                    <a href="/products/${product.id}" class="flex-1 btn btn-outline btn-sm">
                        Görüntüle
                    </a>
                    
                               ${String(product.status).toLowerCase() === 'pending' || product.status === 0 ? `
                <button onclick="approveProduct(${product.id})" class="btn btn-success btn-sm">Onayla</button>
                <button onclick="rejectProduct(${product.id})" class="btn btn-error btn-sm">Reddet</button>
            ` : String(product.status).toLowerCase() === 'approved' || String(product.status).toLowerCase() === 'active' || product.status === 1 ? `
                <button onclick="suspendProduct(${product.id})" class="btn btn-warning btn-sm">Askıya Al</button>
            ` : `
                <button onclick="activateProduct(${product.id})" class="btn btn-success btn-sm">Aktifleştir</button>
            `}

                </div>
            </div>
        </div>
    `).join('');
    }

    function loadProductStats() {
        // Calculate stats from products
        const stats = {
            active: allProducts.filter(p => p.status === 'active').length,
            pending: allProducts.filter(p => p.status === 'pending').length,
            rejected: allProducts.filter(p => p.status === 'rejected').length,
            total_sales: 15678.90 // Mock data
        };

        document.getElementById('active-products').textContent = stats.active;
        document.getElementById('pending-products').textContent = stats.pending;
        document.getElementById('rejected-products').textContent = stats.rejected;
        document.getElementById('total-sales').textContent = `₺${stats.total_sales.toLocaleString()}`;
    }

    function filterProducts() {
        const search = document.getElementById('search').value.toLowerCase();
        const statusFilter = document.getElementById('status-filter').value;

        filteredProducts = allProducts.filter(product => {
            const matchesSearch = !search ||
                product.name.toLowerCase().includes(search) ||
                product.categoryName?.toLowerCase().includes(search);


           const statusTextMap = { 0: 'pending', 1: 'active', 2: 'rejected', 3: 'suspended' };
const normalizedStatus = statusTextMap[product.status] ?? String(product.status).toLowerCase();
const matchesStatus = !statusFilter || normalizedStatus === statusFilter;


            return matchesSearch && matchesStatus;
        });

        displayProducts();
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

    async function approveProduct(productId) {
        try {
            const product = allProducts.find(p => p.id === productId);
            const finalPriceStr = prompt('Onaylanan fiyatı giriniz (örn: 150.50):', product ? product.suggestedPrice : '');
            if (finalPriceStr === null) return; // İptal edildi

            const finalPrice = parseFloat(finalPriceStr.replace(',', '.'));

            const response = await apiCall(`Admin/products/${productId}/status`, {
                method: 'PUT',
                body: JSON.stringify({
                    status: 1, // 1: Approved
                    finalPrice: isNaN(finalPrice) ? null : finalPrice
                })
            });



                await loadProducts();
                showToast('Ürün onaylandı', 'success');
        } catch (error) {
            showToast('Ürün onaylanırken hata oluştu: ' + error.message, 'error');
        }
    }

    async function rejectProduct(productId) {
        if (!(await openCustomModal('Ürünü reddetmek istediğinize emin misiniz?'))) return;

        try {
            const response = await apiCall(`Admin/products/${productId}/status`, {
                method: 'PUT',
                body: JSON.stringify({
                    status: 2, // 2: Rejected
                    finalPrice: null
                })
            });


           
                await loadProducts();
                showToast('Ürün reddedildi', 'success');
            
        } catch (error) {
            showToast('Ürün reddedilirken hata oluştu: ' + error.message, 'error');
        }
    }

    async function suspendProduct(productId) {
        if (!(await openCustomModal('Bu ürünü askıya (beklemeye) almak istediğinizden emin misiniz?'))) {
            return;
        }

        try {
            const response = await apiCall(`Admin/products/${productId}/status`, {
                method: 'PUT',
                body: JSON.stringify({
                    status: 0, // 0: Pending'e çekilir.
                    finalPrice: null
                })
            });


           
                await loadProducts();
                showToast('Ürün askıya alındı', 'success');
            
        } catch (error) {
            showToast('Ürün askıya alınırken hata oluştu: ' + error.message, 'error');
        }
    }

    async function activateProduct(productId) {
        try {
            const product = allProducts.find(p => p.id === productId);
            const response = await apiCall(`Admin/products/${productId}/status`, {
                method: 'PUT',
                body: JSON.stringify({
                    status: 1, // 1: Approved
                    finalPrice: product ? product.finalPrice : null
                })
            });


           
                await loadProducts();
                showToast('Ürün aktifleştirildi', 'success');
            
        } catch (error) {
            showToast('Ürün aktifleştirilirken hata oluştu: ' + error.message, 'error');
        }
    }

    function exportProducts() {
        const csvContent = "data:text/csv;charset=utf-8," +
            "Ürün Adı,Kategori,Fiyat,Satıcı,Durum,Öğrenci\n" +
            filteredProducts.map(product =>
                `"${product.name}","${product.categoryName || ''}","₺${parseFloat(product.finalPrice || product.suggestedPrice)}","${product.merchantName || ''}","${getStatusText(product.status)}","${product.studentName || ''}"`
            ).join("\n");


        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "urunler.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        showToast('Ürün listesi indirildi', 'success');
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>