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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
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
document.addEventListener('DOMContentLoaded', function() {
    loadFavorites();
});

async function loadFavorites() {
    try {
        const response = await apiCall('favorites');
        const favorites = response.success ? response.data : [];
        
        const container = document.getElementById('favorites-container');
        
        if (favorites.length === 0) {
            container.innerHTML = '';
            document.getElementById('empty-favorites').style.display = 'block';
            return;
        }
        
        container.innerHTML = favorites.map(product => `
            <div class="group">
                <div class="card hover:shadow-lg transition-shadow duration-200">
                    <div class="relative h-48 mb-4 bg-gray-100 rounded-lg overflow-hidden">
                        ${product.images && product.images.length > 0 ? `
                            <img 
                                src="${product.images[0]}" 
                                alt="${escapeHtml(product.title)}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200"
                            />
                        ` : `
                            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                <span class="text-gray-400">📷</span>
                            </div>
                        `}
                        
                        <!-- Remove from favorites button -->
                        <button 
                            onclick="removeFromFavorites(${product.product_id})"
                            class="absolute top-2 right-2 p-2 bg-red-600 text-white rounded-full hover:bg-red-700 transition-colors shadow-lg"
                            title="Favorilerden kaldır"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                        ${escapeHtml(product.title)}
                    </h3>
                    
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                        ${escapeHtml(product.description || '')}
                    </p>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-lg font-bold text-blue-600">
                            ₺${parseFloat(product.price).toFixed(2)}
                        </span>
                        
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-sm text-gray-500">4.8</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500">
                            ${escapeHtml(product.shop?.name || 'Mağaza')}
                        </span>
                        
                        <div class="flex space-x-2">
                            <a href="/products/${product.product_id}" class="btn btn-outline btn-sm">
                                Görüntüle
                            </a>
                            <button 
                                onclick="addToCart(${product.product_id})" 
                                class="btn btn-primary btn-sm"
                            >
                                Sepete Ekle
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
        
    } catch (error) {
        console.error('Error loading favorites:', error);
        const container = document.getElementById('favorites-container');
        container.innerHTML = '<div class="col-span-full text-center text-red-500 py-8">Favoriler yüklenirken hata oluştu.</div>';
    }
}

async function removeFromFavorites(productId) {
    if (!confirm('Bu ürünü favorilerden kaldırmak istediğinizden emin misiniz?')) {
        return;
    }
    
    try {
        console.log('Removing from favorites, product ID:', productId);
        
        const response = await fetch(`/api/favorites/${productId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            credentials: 'include'
        });
        
        const result = await response.json();
        
        console.log('Remove response:', result);
        
        if (result.success) {
            showToast('Ürün favorilerden kaldırıldı!', 'success');
            
            // Favorileri yeniden yükle
            setTimeout(() => {
                loadFavorites();
            }, 500);
        } else {
            showToast(result.message || 'Favorilerden kaldırılırken hata oluştu', 'error');
        }
        
    } catch (error) {
        console.error('Remove from favorites error:', error);
        showToast('Favorilerden kaldırılırken hata oluştu', 'error');
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
