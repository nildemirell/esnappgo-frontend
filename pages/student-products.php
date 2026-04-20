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

<!-- Edit Product Modal -->
<div id="edit-product-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg overflow-hidden transform transition-all scale-95 opacity-0" id="edit-modal-content">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900">Ürünü Düzenle</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="edit-product-form" onsubmit="submitEditProduct(event)" class="p-6 space-y-4">
            <input type="hidden" id="edit-product-id">
            
            <div>
                <label for="edit-title" class="block text-sm font-medium text-gray-700 mb-1">Ürün Adı</label>
                <input type="text" id="edit-title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="edit-price" class="block text-sm font-medium text-gray-700 mb-1">Önerilen Fiyat (₺)</label>
                <input type="number" id="edit-price" step="0.01" min="0" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="edit-category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select id="edit-category" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Kategori Yükleniyor...</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Ürününüzün ait olduğu yeni kategori</p>
            </div>

            <div>
                <label for="edit-description" class="block text-sm font-medium text-gray-700 mb-1">Açıklama</label>
                <textarea id="edit-description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <div class="bg-blue-50 p-3 rounded-lg flex items-start space-x-2">
                <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-xs text-blue-700">Ürünü düzenlediğinizde onay durumu sıfırlanır ve esnafa yeniden onay talebi gider.</p>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end space-x-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">İptal</button>
                <button type="submit" id="edit-submit-btn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center">
                    Kaydet
                </button>
            </div>
        </form>
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
                title: p.name,                           
                description: p.description || '',      // Backend'den gelen açıklamayı al   
                price: p.finalPrice || p.suggestedPrice || 0, // Fiyat garantileme
                categoryId: p.categoryId,              // Edit modalı için categoryId eklendi
                status: normalizeStatus(p.status),        
                images: p.imageUrls || [],
                created_at: null,
                sales_count: p.sales_count || 0,       // Eğer backend gönderirse kullan, yoksa 0 (bildirildi)
                total_earned: p.total_earned || 0      // Eğer backend gönderirse kullan, yoksa 0 (bildirildi)
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
                        class="w-full h-full object-contain object-center bg-white p-3"
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


    // Kategori listesi cache
    let categoryCache = null;

    async function editProduct(productId) {
        const product = allProducts.find(p => p.id === productId);
        if (!product) return;

        // Modalı doldur
        document.getElementById('edit-product-id').value = product.id;
        document.getElementById('edit-title').value = product.title;
        document.getElementById('edit-price').value = product.price;
        document.getElementById('edit-description').value = product.description || '';

        // Modalı aç
        const modal = document.getElementById('edit-product-modal');
        const modalContent = document.getElementById('edit-modal-content');
        modal.classList.remove('hidden');
        
        // Animasyon için frame bekle
        requestAnimationFrame(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        });

        // Kategorileri yükle (sadece 1 kere)
        const select = document.getElementById('edit-category');
        if (!categoryCache) {
            try {
                const categories = await apiCall('Categories/tree');
                categoryCache = Array.isArray(categories) ? categories : (categories.data || []);
            } catch (e) {
                console.error("Kategoriler yüklenemedi:", e);
                select.innerHTML = '<option value="">Kategori yüklenemedi</option>';
                return;
            }
        }
        
        // Kategorileri select içine bas
        let html = '<option value="">Kategori seçin...</option>';
        categoryCache.forEach(parent => {
            if (parent.children && parent.children.length > 0) {
                html += `<optgroup label="${escapeHtml(parent.name)}">`;
                parent.children.forEach(child => {
                    html += `<option value="${child.id}">${escapeHtml(child.name)}</option>`;
                });
                html += '</optgroup>';
            } else {
                html += `<option value="${parent.id}">${escapeHtml(parent.name)}</option>`;
            }
        });
        select.innerHTML = html;
        select.value = product.categoryId || '';
    }

    function closeEditModal() {
        const modal = document.getElementById('edit-product-modal');
        const modalContent = document.getElementById('edit-modal-content');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200); // 200ms Tailwind transition süresi
    }

    async function submitEditProduct(e) {
        e.preventDefault();
        const btn = document.getElementById('edit-submit-btn');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = 'Kaydediliyor...';

        const id = document.getElementById('edit-product-id').value;
        const payload = {
            name: document.getElementById('edit-title').value,
            description: document.getElementById('edit-description').value,
            suggestedPrice: parseFloat(document.getElementById('edit-price').value),
            categoryId: parseInt(document.getElementById('edit-category').value) || null
        };

        try {
            await apiCall(`Products/my-products/${id}`, {
                method: 'PUT',
                body: JSON.stringify(payload)
            });
            showToast('Ürün başarıyla güncellendi!', 'success');
            closeEditModal();
            loadStudentProducts(); // Listeyi yenile
        } catch (error) {
            console.error('Update error:', error);
            showToast('Ürün güncellenirken hata oluştu', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
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