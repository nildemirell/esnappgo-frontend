<?php
// Giriş kontrolü
if (!$current_user) {
    header('Location: /login?redirect=/favorites');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Favorilerim</h1>
            <p class="text-gray-600">Beğendiğiniz ürünler</p>
        </div>

        <!-- Favorites Grid -->
        <div id="favorites-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
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

        <!-- Empty Favorites -->
        <div id="empty-favorites" class="text-center py-12" style="display: none;">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                </path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz favori ürününüz yok</h3>
            <p class="text-gray-500 mb-6">Beğendiğiniz ürünleri favorilere ekleyerek buradan kolayca erişebilirsiniz.</p>
            <a href="/products" class="btn btn-primary">
                Ürünleri İncele
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        loadFavorites();
    });

    async function loadFavorites() {
        try {
            const container = document.getElementById('favorites-container');
            const emptyState = document.getElementById('empty-favorites');

            // 1. ADIM: Favori listesini çek → sadece productId'leri alıyoruz
            const favResp = await apiCall('Favorites');
            const favList = Array.isArray(favResp) ? favResp : (favResp.items || favResp.data || []);

            // Favori ID'leri topla
            const favoriteIds = favList.map(f => Number(f.productId || f.ProductId || f.id || 0)).filter(id => id > 0);

            if (favoriteIds.length === 0) {
                container.innerHTML = '';
                emptyState.style.display = 'block';
                return;
            }

            // 2. ADIM: Ürünler endpoint'inden TAM veriyi çek (description, merchantName, images vs hepsi burada)
            const prodResp = await apiCall('products?limit=1000');
            const allProducts = Array.isArray(prodResp) ? prodResp : (prodResp.products || prodResp.data || []);

            // Sadece favorilerdeki ürünleri filtrele ve sıralamayı koru (en son eklenen önce)
            const favoriteProducts = favoriteIds
                .map(id => allProducts.find(p => Number(p.id || p.Id) === id))
                .filter(Boolean); // bulunamayanları at

            if (favoriteProducts.length === 0) {
                container.innerHTML = '';
                emptyState.style.display = 'block';
                return;
            }

            emptyState.style.display = 'none';

            // 3. ADIM: Products endpoint'inden gelen TAM veriyle kartları render et
            container.innerHTML = favoriteProducts.map(product => {
                const productId    = product.id || product.Id || 0;
                const displayName  = product.name  || product.title || 'İsimsiz Ürün';
                const displayPrice = product.finalPrice || product.suggestedPrice || product.price || 0;
                const description  = product.description || '';
                const merchantName = product.merchantName || product.shop?.name || '';
                const categoryName = product.categoryName || product.category?.name || '';

                // imageUrls dizi olarak geliyor (products endpoint'i böyle döner)
                const imagesArray = product.imageUrls || product.images || [];
                let imageUrl = imagesArray.length > 0 ? imagesArray[0] : '';
                if (imageUrl && !imageUrl.startsWith('/') && !imageUrl.startsWith('http')) {
                    imageUrl = '/' + imageUrl;
                }

                const imageHtml = imageUrl
                    ? `<img src="${imageUrl}" alt="${escapeHtml(displayName)}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" onerror="this.src='/media/68a658361732a_1755732022.jpg'" />`
                    : `<div class="w-full h-full flex items-center justify-center bg-gray-200"><span class="text-gray-400 text-4xl">📷</span></div>`;

                const categoryBadge = categoryName
                    ? `<span class="absolute top-2 left-2 px-2 py-1 bg-white/90 backdrop-blur-sm text-xs font-medium text-gray-700 rounded-full">${escapeHtml(categoryName)}</span>`
                    : '';

                return `
                <div class="group relative cursor-pointer" onclick="window.location.href='/products/${productId}'">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:border-gray-200 transition-all duration-300 hover:-translate-y-1">
                        <div class="relative h-48 bg-gray-100 overflow-hidden">
                            ${imageHtml}
                            ${categoryBadge}
                            <button onclick="event.stopPropagation(); removeFromFavorites(${productId})" class="absolute top-2 right-2 p-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors shadow-lg z-10" title="Favorilerden kaldır">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 line-clamp-1 group-hover:text-blue-600 transition-colors mb-1" title="${escapeHtml(displayName)}">${escapeHtml(displayName)}</h3>

                            <p class="text-sm text-gray-500 mb-3 line-clamp-2 h-10">${escapeHtml(description)}</p>

                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xl font-bold text-blue-600">₺${parseFloat(displayPrice).toFixed(2)}</span>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    4.8
                                </div>
                            </div>

                            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-xs text-gray-500 truncate max-w-[120px]">${escapeHtml(merchantName || 'Esnaf')}</span>
                                <a href="/products/${productId}" onclick="event.stopPropagation()" class="flex items-center justify-center px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    Detayı Gör
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            }).join('');

        } catch (error) {
            console.error('Favoriler yüklenirken hata:', error);
            document.getElementById('favorites-container').innerHTML =
                '<div class="col-span-full text-center text-red-500 py-8">Favoriler yüklenirken hata oluştu.</div>';
        }
    }

    async function removeFromFavorites(productId) {
        if (!await openCustomModal('Bu ürünü favorilerden kaldırmak istediğinizden emin misiniz?')) return;

        try {
            await apiCall(`Favorites/toggle/${productId}`, { method: 'POST' });
            showToast('Ürün favorilerden kaldırıldı', 'info');
            loadFavorites();
        } catch (error) {
            console.error('Favoriden kaldırma hatası:', error);
            showToast('Ürün favorilerden kaldırılırken bir hata oluştu', 'error');
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text || '';
        return div.innerHTML;
    }
</script>