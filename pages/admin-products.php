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
                        onkeyup="debounceProducts()" />
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

<!-- Fiyat Onay Modali -->
<div id="priceApproveModal" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closePriceModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
            <div class="bg-white px-6 pt-5 pb-4">
                <input type="hidden" id="approvePriceProductId">
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Ürünü Onayla</h3>
                <p class="text-sm text-gray-500 mb-4">Onaylanan satış fiyatını girin. Boş bırakırsanız önerilen fiyat kullanılır.</p>
                <label class="block text-sm font-medium text-gray-700 mb-1">Satış Fiyatı (₺)</label>
                <input type="number" id="approvePrice" min="0.01" step="0.01"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                    placeholder="Örn: 150.00" />
            </div>
            <div class="bg-gray-50 px-6 py-3 flex flex-row-reverse gap-3">
                <button type="button" onclick="confirmApproveProduct()"
                    class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-sm font-medium text-white hover:bg-green-700">
                    Onayla
                </button>
                <button type="button" onclick="closePriceModal()"
                    class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    İptal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let allProducts = [];
    let filteredProducts = [];
    let _productFilterTimer = null;

    document.addEventListener('DOMContentLoaded', function () {
        loadProducts();
    });

    async function loadProducts() {
        try {
            // Server-side filtreleme — backend ?search=&status= destekliyor
            const search       = document.getElementById('search')?.value || '';
            const statusFilter = document.getElementById('status-filter')?.value || '';

            let url = 'Admin/products';
            const params = [];
            if (search)       params.push(`search=${encodeURIComponent(search)}`);
            if (statusFilter) params.push(`status=${encodeURIComponent(statusFilter)}`);
            if (params.length) url += '?' + params.join('&');

            const response = await apiCall(url);

            // Backend { success: true, data: [...] } sarıcısını açıyoruz
            const products = Array.isArray(response) ? response : (response.data || []);
            allProducts = products;
            filteredProducts = [...allProducts];
            
            populateStudentFilter(products);
            displayProducts();
            loadProductStats();

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

                            class="w-full h-full object-contain object-center bg-white p-3"
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
                    <span class="badge badge-${getStatusBadgeClass(product.status, product.isActive)}">
                        ${getStatusText(product.status, product.isActive)}
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
                <div class="flex space-x-2 flex-wrap gap-1">
                    <a href="/products/${product.id}" class="flex-1 btn btn-outline btn-sm">
                        Görüntüle
                    </a>
                    
                              ${normalizeStatus(product.status, product.isActive) === 'pending' ? `
                        <button onclick="approveProduct(${product.id})" class="btn btn-success btn-sm">Onayla</button>
                        <button onclick="rejectProduct(${product.id})" class="btn btn-error btn-sm">Reddet</button>
                    ` : normalizeStatus(product.status, product.isActive) === 'active' ? `
                        <button onclick="suspendProduct(${product.id})" class="btn btn-warning btn-sm">Askıya Al</button>
                    ` : normalizeStatus(product.status, product.isActive) === 'rejected' ? `
                        <button onclick="approveProduct(${product.id})" class="btn btn-success btn-sm">Onayla</button>
                    ` : normalizeStatus(product.status, product.isActive) === 'suspended' ? `
                        <button onclick="activateProduct(${product.id})" class="btn btn-success btn-sm">Aktifleştir</button>
                    ` : ''}
                    <button onclick="deleteProduct(${product.id})" class="btn btn-error btn-sm" title="Sil">🗑️</button>
                </div>
            </div>
        </div>
    `).join('');
    }

    async function loadProductStats() {
        try {
            const statsResponse = await apiCall('Admin/products/stats');
            const stats = statsResponse.data || statsResponse || {};
            // AdminProductStatsDto: activeProducts, pendingProducts, rejectedProducts, totalSales
            document.getElementById('active-products').textContent = stats.activeProducts ?? '—';
            document.getElementById('pending-products').textContent = stats.pendingProducts ?? '—';
            document.getElementById('rejected-products').textContent = stats.rejectedProducts ?? '—';
            document.getElementById('total-sales').textContent = stats.totalSales !== undefined
                ? `₺${parseFloat(stats.totalSales).toFixed(2)}`
                : '₺—';
        } catch (e) {
            console.error('Product stats yüklenemedi:', e);
            // Fallback: client-side 'dan hesapla
            const statusTextMap = { 0: 'pending', 1: 'active', 2: 'rejected', 3: 'suspended' };
            const normalize = (s) => statusTextMap[s] ?? String(s).toLowerCase();
            document.getElementById('active-products').textContent = allProducts.filter(p => normalize(p.status) === 'active').length;
            document.getElementById('pending-products').textContent = allProducts.filter(p => normalize(p.status) === 'pending').length;
            document.getElementById('rejected-products').textContent = allProducts.filter(p => normalize(p.status) === 'rejected').length;
            document.getElementById('total-sales').textContent = '₺—';
        }
    }


    function populateStudentFilter(products) {
        const select = document.getElementById('student-filter');
        select.innerHTML = '<option value="">Tüm Öğrenciler</option>';
        const seen = new Set();
        products.forEach(p => {
            if (p.studentName && !seen.has(p.studentName)) {
                seen.add(p.studentName);
                const opt = document.createElement('option');
                opt.value = p.studentName;
                opt.textContent = p.studentName;
                select.appendChild(opt);
            }
        });
    }

    // Debounce: kullanıcı yazmayı bırakınca 400ms sonra arama yap
    function debounceProducts() {
        clearTimeout(_productFilterTimer);
        _productFilterTimer = setTimeout(() => filterProducts(), 400);
    }

    function filterProducts() {
        const studentFilter = document.getElementById('student-filter').value;

        // Status ve search filtreleri server-side'a gidiyor
        // Sadece student filtresi client-side (student ID backend parametresi farklı — studentName vs studentId)
        if (!studentFilter) {
            // Tüm filtreler server-side
            loadProducts();
            return;
        }

        // Student filtresi uygulandığında önce server'dan çek, sonra client-side filtrele
        loadProducts().then(() => {
            filteredProducts = allProducts.filter(product =>
                product.studentName === studentFilter
            );
            displayProducts();
        });
    }

    function normalizeStatus(status, isActive = true) {
        // Backend'de suspended (3) yok. 
        // Eğer ürün daha önce onaylanmışsa (status 1 veya 'approved') ANCAK IsActive == false konumundaysa bu ürün askıdadır.
        const map = { 0: 'pending', 1: 'active', 2: 'rejected' };
        let raw = map[status] ?? String(status).toLowerCase();
        
        if (raw === 'approved') raw = 'active';

        // Eğer onaylı bir ürün ama veritabanında "IsActive=false" ise, sistemde askıda (suspended) olarak gösterilecek
        if (raw === 'active' && isActive === false) {
            return 'suspended';
        }

        return raw;
    }


    function getStatusText(status, isActive = true) {
        const statusTexts = {
            pending: 'Beklemede',
            active: 'Aktif',
            rejected: 'Reddedildi',
            suspended: 'Askıya Alındı'
        };
        return statusTexts[normalizeStatus(status, isActive)] || String(status);
    }

    function getStatusBadgeClass(status, isActive = true) {
        const badgeClasses = {
            pending: 'warning',
            active: 'success',
            rejected: 'error',
            suspended: 'gray'
        };
        return badgeClasses[normalizeStatus(status, isActive)] || 'gray';
    }

    // Fiyat Onay Modal fonksiyonları
    function openPriceModal(productId) {
        const product = allProducts.find(p => p.id === productId);
        document.getElementById('approvePriceProductId').value = productId;
        document.getElementById('approvePrice').value = product?.suggestedPrice || '';
        document.getElementById('priceApproveModal').classList.remove('hidden');
        // Fiyat inputuna otomatik odaklan
        setTimeout(() => document.getElementById('approvePrice').focus(), 100);
    }

    function closePriceModal() {
        document.getElementById('priceApproveModal').classList.add('hidden');
    }

    async function confirmApproveProduct() {
        const productId  = parseInt(document.getElementById('approvePriceProductId').value);
        const priceInput = document.getElementById('approvePrice').value;
        const finalPrice = priceInput ? parseFloat(String(priceInput).replace(',', '.')) : null;

        if (priceInput && (isNaN(finalPrice) || finalPrice <= 0)) {
            showToast('Lütfen geçerli bir fiyat girin.', 'error');
            return;
        }

        closePriceModal();
        try {
            await apiCall(`Admin/products/${productId}/status`, {
                method: 'PUT',
                body: JSON.stringify({
                    status: 1, // 1: Approved
                    finalPrice: finalPrice
                })
            });
            await loadProducts();
            showToast('Ürün onaylandı', 'success');
        } catch (error) {
            showToast('Ürün onaylanırken hata oluştu: ' + error.message, 'error');
        }
    }

    async function approveProduct(productId) {
        openPriceModal(productId);
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
        if (!(await openCustomModal('Bu ürünü askıya almak istediğinizden emin misiniz?'))) {
            return;
        }

        try {
            const response = await apiCall(`Admin/products/${productId}/toggle-active`, {
                method: 'PUT'
            });

            // Optimistic Update: Listeyi baştan çekmek yerine bellek üzerinde state'i güncelleştirip ekranı tekrar çizeriz.
            const product = allProducts.find(p => p.id === productId);
            if(product) product.isActive = response.isActive;
            
            filterProducts();
            showToast(response.message || 'Ürün askıya alındı', 'success');

        } catch (error) {
            showToast('Ürün askıya alınırken hata oluştu: ' + error.message, 'error');
        }
    }

    async function activateProduct(productId) {
        try {
            const response = await apiCall(`Admin/products/${productId}/toggle-active`, {
                method: 'PUT'
            });

            // Optimistic Update
            const product = allProducts.find(p => p.id === productId);
            if(product) product.isActive = response.isActive;

            filterProducts();
            showToast(response.message || 'Ürün aktifleştirildi', 'success');

        } catch (error) {
            showToast('Ürün aktifleştirilirken hata oluştu: ' + error.message, 'error');
        }
    }

    async function deleteProduct(productId) {
        if (!(await openCustomModal('Bu ürünü kalıcı olarak silmek istediğinizden emin misiniz?'))) return;
        try {
            await apiCall(`Admin/products/${productId}`, { method: 'DELETE' });
            await loadProducts();
            showToast('Ürün silindi.', 'success');
        } catch (error) {
            showToast('Ürün silinemedi: ' + error.message, 'error');
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