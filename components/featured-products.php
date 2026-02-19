<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Öne Çıkan Ürünler
            </h2>
            <p class="text-lg text-gray-600">
                Öğrenciler tarafından sahadan paylaşılan en popüler ürünler
            </p>
        </div>

        <div id="featured-products-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            <!-- Loading skeleton - 5 items -->
            <div class="animate-pulse skeleton-item">
                <div class="bg-gray-200 h-48 rounded-lg mb-4"></div>
                <div class="h-4 bg-gray-200 rounded mb-2"></div>
                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
            </div>
            <div class="animate-pulse skeleton-item">
                <div class="bg-gray-200 h-48 rounded-lg mb-4"></div>
                <div class="h-4 bg-gray-200 rounded mb-2"></div>
                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
            </div>
            <div class="animate-pulse skeleton-item">
                <div class="bg-gray-200 h-48 rounded-lg mb-4"></div>
                <div class="h-4 bg-gray-200 rounded mb-2"></div>
                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
            </div>
            <div class="animate-pulse skeleton-item">
                <div class="bg-gray-200 h-48 rounded-lg mb-4"></div>
                <div class="h-4 bg-gray-200 rounded mb-2"></div>
                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
            </div>
            <div class="animate-pulse skeleton-item">
                <div class="bg-gray-200 h-48 rounded-lg mb-4"></div>
                <div class="h-4 bg-gray-200 rounded mb-2"></div>
                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="/products" class="btn btn-primary btn-lg">
                Tüm Ürünleri Gör
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadFeaturedProducts();
});

async function loadFeaturedProducts() {
    try {
        const response = await apiCall('products?limit=5');
        
        if (!response.success) {
            throw new Error(response.message || 'API error');
        }
        
        const products = response.data || [];
        
        const container = document.getElementById('featured-products-container');
        
        if (products.length === 0) {
            container.innerHTML = '<div class="col-span-full text-center text-gray-500">Henüz ürün bulunmamaktadır.</div>';
            return;
        }
        
        container.innerHTML = products.map(product => `
            <a href="/products/${product.id}" class="group">
                <div class="card hover:shadow-lg transition-shadow duration-200">
                    <div class="relative h-48 mb-4 bg-gray-100 rounded-lg overflow-hidden">
                        ${product.images && product.images.length > 0 ? `
                            <img 
                                src="${product.images[0]}" 
                                alt="${escapeHtml(product.title)}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200"
                                onerror="console.error('Image load error:', '${product.images[0]}'); this.parentElement.innerHTML='<div class=\\'w-full h-full flex items-center justify-center bg-gray-200\\'>📷 Resim Yükleniyor...</div>'"
                            />
                        ` : `
                            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                <span class="text-gray-400">📷 Resim Yükleniyor...</span>
                            </div>
                        `}
                        
                        <!-- Student Supported Badge -->
                        <div class="absolute top-2 right-2">
                            <span class="badge badge-student flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                Öğrenci Destekli
                            </span>
                        </div>
                    </div>

                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                        ${escapeHtml(product.title)}
                    </h3>
                    
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                        ${escapeHtml(product.description || '')}
                    </p>

                    <div class="flex items-center justify-between">
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

                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <span class="text-xs text-gray-500">
                            ${escapeHtml(product.shop?.name || 'Mağaza')}
                        </span>
                    </div>
                </div>
            </a>
        `).join('');
        
    } catch (error) {
        console.error('Error loading featured products:', error);
        const container = document.getElementById('featured-products-container');
        container.innerHTML = '<div class="col-span-full text-center text-red-500">Ürünler yüklenirken hata oluştu.</div>';
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
