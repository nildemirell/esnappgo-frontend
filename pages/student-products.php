<?php
// Öğrenci kontrolü
if (!$current_user || ($current_user['role'] !== 'student' && $current_user['role'] !== 'ogrenci')) {

    header('Location: /dashboard');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Ürünlerim</h1>
                <p class="text-gray-600">Paylaştığınız ürünleri yönetin</p>
            </div>
            <a href="/student/create-product" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Yeni Ürün Ekle
            </a>
        </div>

        <!-- Status Filter -->
        <div class="mb-6">
            <div class="flex space-x-2">
                <button onclick="filterProducts('all')" class="status-filter-btn active px-4 py-2 text-sm rounded-md">
                    Tümü
                </button>
                <button onclick="filterProducts('pending')" class="status-filter-btn px-4 py-2 text-sm rounded-md">
                    Beklemede
                </button>
                <button onclick="filterProducts('active')" class="status-filter-btn px-4 py-2 text-sm rounded-md">
                    Onaylandı
                </button>
                <button onclick="filterProducts('rejected')" class="status-filter-btn px-4 py-2 text-sm rounded-md">
                    Reddedildi
                </button>
            </div>
        </div>

        <!-- Products Grid -->
        <div id="student-products-container"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Loading skeleton -->
            <?php for ($i = 0; $i < 8; $i++): ?>
                <div class="animate-pulse">
                    <div class="bg-gray-200 h-48 rounded-lg mb-4"></div>
                    <div class="h-4 bg-gray-200 rounded mb-2"></div>
                    <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                    <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Empty State -->
        <div id="empty-products" class="text-center py-12" style="display: none;">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz ürün paylaşmadınız</h3>
            <p class="text-gray-500 mb-6">İlk ürün fotoğrafınızı paylaşarak kazanmaya başlayın!</p>
            <a href="/student/create-product" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                İlk Ürünümü Paylaş
            </a>
        </div>
    </div>
</div>

<script>
    let allProducts = [];
    let currentFilter = 'all';

    document.addEventListener('DOMContentLoaded', function () {
        loadStudentProducts();
    });

    async function loadStudentProducts() {
        try {
            const token = localStorage.getItem('auth_token');
            if (!token) return;

            const res = await fetch(`${API_BASE}/api/Products/my-products`, {
                headers: { 'Authorization': `Bearer ${token}` }
            });

            if (!res.ok) throw new Error('Ürünler yüklenemedi');
            const data = await res.json();

            // Backend → Frontend mapping (UI'daki alanları koruyoruz)
            allProducts = data.map(p => ({
                id: p.id,
                title: p.name,                           // backend "name" → frontend "title"
                description: '',                          // ❌ backend'de yok → boş string
                price: p.finalPrice || p.suggestedPrice,
                status: normalizeStatus(p.status),        // Frontend ile uyumlu standart durum
                images: p.imageUrls || [],
                created_at: null,
                sales_count: 0,                           // ❌ backend'de yok → 0
                total_earned: 0                           // ❌ backend'de yok → 0
            }));

            displayProducts(allProducts);
        } catch (error) {
            console.error('Error loading student products:', error);
            const container = document.getElementById('student-products-container');
            container.innerHTML = '<div class="col-span-full text-center text-red-500 py-8">Ürünler yüklenirken hata oluştu.</div>';
        }
    }

    function displayProducts(products) {
        const container = document.getElementById('student-products-container');

        if (products.length === 0) {
            container.innerHTML = '';
            document.getElementById('empty-products').style.display = 'block';
            return;
        }

        document.getElementById('empty-products').style.display = 'none';

        container.innerHTML = products.map(product => `
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="relative h-48 bg-gray-100">
                ${product.images && product.images.length > 0 ? `
                    <img 
                        src="${product.images[0]}" 
                        alt="${escapeHtml(product.title)}"
                        class="w-full h-full object-cover"
                    />
                ` : `
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
                    ${escapeHtml(product.title)}
                </h3>
                
                <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                    ${escapeHtml(product.description || '')}
                </p>
                
                <div class="flex items-center justify-between mb-3">
                    <span class="text-lg font-bold text-blue-600">
                        ₺${parseFloat(product.price).toFixed(2)}
                    </span>
                    <span class="text-sm text-gray-500">
                        ${product.sales_count} satış
                    </span>
                </div>
                
                <!-- Earnings Info -->
                <div class="bg-green-50 p-3 rounded-lg mb-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-green-700">Toplam Kazanç</span>
                        <span class="font-semibold text-green-700">₺${product.total_earned.toFixed(2)}</span>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex space-x-2">
                    ${product.status === 'pending' ? `
                        <button onclick="editProduct(${product.id})" class="flex-1 btn btn-outline btn-sm">
                            Düzenle
                        </button>
                        <button onclick="deleteProduct(${product.id})" class="btn btn-error btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    ` : `
                        <a href="/products/${product.id}" class="flex-1 btn btn-outline btn-sm">
                            Görüntüle
                        </a>
                        <button onclick="viewEarnings(${product.id})" class="btn btn-primary btn-sm">
                            Kazançlar
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

    function normalizeStatus(status) {
        const map = { 0: 'pending', 1: 'active', 2: 'rejected', 3: 'suspended' };
        const raw = map[status] ?? String(status || '').toLowerCase();
        return raw === 'approved' ? 'active' : raw;
    }

    function getStatusText(status) {
        const statusTexts = {
            pending: 'Beklemede',
            active: 'Onaylandı',
            rejected: 'Reddedildi',
            suspended: 'Askıya Alındı'
        };
        return statusTexts[normalizeStatus(status)] || status;
    }

    function getStatusBadgeClass(status) {
        const badgeClasses = {
            pending: 'warning',
            active: 'success',
            rejected: 'error',
            suspended: 'gray'
        };
        return badgeClasses[normalizeStatus(status)] || 'gray';
    }


    async function editProduct(productId) {
        window.location.href = `/student/products/${productId}/edit`;
    }

    async function deleteProduct(id) {
    if (!await openCustomModal('Bu ürünü silmek istediğinizden emin misiniz?')) return;
    try {
        await apiCall(`Products/my-products/${id}`, { method: 'DELETE' });
        showToast('Ürün silindi', 'success');
        allProducts = allProducts.filter(p => p.id !== id); // ← id kullan, productId değil
        filterProducts(currentFilter);
    } catch (error) {
        showToast('Ürün silinirken hata oluştu', 'error');
    }
}

    function viewEarnings(productId) {
        const product = allProducts.find(p => p.id === productId);
        if (product) {
            showToast(`${product.title} için toplam kazanç: ₺${product.total_earned.toFixed(2)}`, 'info');
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
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