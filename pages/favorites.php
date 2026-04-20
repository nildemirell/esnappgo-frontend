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

            // FIX: Backend FavoriteProductDto zaten tüm ürün bilgisini taşıyor.
            // Önceden: favori ID'leri alınıp ardından 1000 ürün çekilip filtreyleniyordu (2 API çağrısı).
            // Şimdi: Tek API çağrısı — FavoriteProductDto doğrudan render ediliyor.
            const favResp = await apiCall('Favorites');
            const rawFavList = Array.isArray(favResp) ? favResp : (favResp.items || []);

            // Backend DTO eksiklerini tamamlamak için paralel sorgu (Description & Stock)
            const favList = await Promise.all(rawFavList.map(async fav => {
                const prodId = fav.ProductId || fav.productId || 0;
                let description = '';
                let stock = 0;
                try {
                    const detail = await apiCall(`products/${prodId}`);
                    const prodData = detail.data || detail;
                    description = prodData.description || prodData.Description || '';
                    const rawStock = prodData.stock !== undefined ? prodData.stock : (prodData.Stock !== undefined ? prodData.Stock : prodData.stockQuantity);
                    stock = (rawStock !== null && rawStock !== undefined) ? rawStock : 99; 
                } catch(e) {}
                
                return { ...fav, CustomDesc: description, CustomStock: stock };
            }));

            if (favList.length === 0) {
                container.innerHTML = '';
                emptyState.style.display = 'block';
                return;
            }

            emptyState.style.display = 'none';

            // FavoriteProductDto alanları: ProductId, ProductName, Price, ImageUrl, AddedAt
            // (.NET PascalCase öncelikli, camelCase fallback)
            container.innerHTML = favList.map(fav => {
                const productId   = fav.ProductId   || fav.productId   || 0;
                const displayName = fav.ProductName || fav.productName || 'İsimsiz Ürün';
                const price       = fav.Price       || fav.price       || 0;
                const merchantName= fav.MerchantShopName || fav.merchantShopName || fav.MerchantName|| fav.merchantName|| 'Bilinmeyen Mağaza';
                let imageUrl      = fav.ImageUrl    || fav.imageUrl    || '';
                
                const description = fav.CustomDesc || '';
                const stock       = fav.CustomStock || 0;

                if (imageUrl && !imageUrl.startsWith('/') && !imageUrl.startsWith('http')) {
                    imageUrl = '/' + imageUrl;
                }

                const imageHtml = imageUrl
                    ? `<img src="${imageUrl}" alt="${escapeHtml(displayName)}" class="w-full h-full object-contain object-center bg-white p-3 group-hover:scale-105 transition-transform duration-200" onerror="this.src='/media/68a658361732a_1755732022.jpg'" />`
                    : `<div class="w-full h-full flex items-center justify-center bg-gray-200"><span class="text-gray-400 text-4xl">📷</span></div>`;

                const actionHtml = stock > 0 
                  ? `<button onclick="event.stopPropagation(); addToCart(${productId})" class="w-full flex items-center justify-center px-3 py-1.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors mt-2">Sepete Ekle</button>`
                  : `<div class="w-full text-center text-xs text-red-500 font-medium py-1.5 mt-2 bg-red-50 rounded-lg border border-red-100">Stokta Yok</div>`;

                return `
                <div class="group relative cursor-pointer" onclick="window.location.href='/products/${productId}'">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:border-gray-200 transition-all duration-300 hover:-translate-y-1">
                        <div class="relative h-48 bg-gray-100 overflow-hidden">
                            ${imageHtml}
                            <button onclick="event.stopPropagation(); removeFromFavorites(${productId})" class="absolute top-2 right-2 p-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors shadow-lg z-10" title="Favorilerden kaldır">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="p-4">
                            <div class="flex items-start justify-between mb-1 gap-2">
                                <h3 class="font-semibold text-gray-900 line-clamp-1 group-hover:text-blue-600 transition-colors flex-1" title="${escapeHtml(displayName)}">
                                    ${escapeHtml(displayName)}
                                </h3>
                            </div>
                            
                            <p class="text-sm text-gray-500 mb-3 line-clamp-2 h-10">
                                ${escapeHtml(description)}
                            </p>

                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xl font-bold text-blue-600">
                                    ₺${parseFloat(price).toFixed(2)}
                                </span>
                            </div>

                            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-xs text-gray-500 truncate max-w-[120px]">
                                    ${escapeHtml(merchantName)}
                                </span>
                                
                                ${stock > 0 ? `
                                <button 
                                    onclick="event.preventDefault(); event.stopPropagation(); addToCart(${productId}); return false;" 
                                    class="flex items-center justify-center px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                >
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Sepete
                                </button>
                                ` : `
                                <span class="text-xs text-red-500 font-medium py-1.5 pl-2">Stokta Yok</span>
                                `}
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

    async function addToCart(productId) {
        if (!productId) return;
        try {
            await apiCall('cart/items', {
                method: 'POST',
                body: JSON.stringify({ productId: productId, quantity: 1 })
            });
            showToast('Ürün sepete eklendi!', 'success');
            if(typeof updateCartCount === 'function') updateCartCount();
        } catch (error) {
            console.error('Cart error:', error);
            showToast(error.message || 'Sepete eklenirken hata oluştu', 'error');
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