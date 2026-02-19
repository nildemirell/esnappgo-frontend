<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mağazalar</h1>
            <p class="text-gray-600">Platformumuzdaki yerel esnafları keşfedin</p>
        </div>
        
        <!-- Search -->
        <div class="mb-8 bg-white rounded-lg shadow-sm p-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input 
                        type="text" 
                        id="search-input"
                        placeholder="Mağaza ara..." 
                        class="w-full"
                    />
                </div>
                <button onclick="searchShops()" class="btn btn-primary px-8">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Ara
                </button>
            </div>
        </div>
        
        <!-- Shops Grid -->
        <div id="shops-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Loading skeleton -->
            <?php for ($i = 0; $i < 6; $i++): ?>
            <div class="animate-pulse">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="h-6 bg-gray-200 rounded mb-4"></div>
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
document.addEventListener('DOMContentLoaded', function() {
    loadShops();
    
    document.getElementById('search-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchShops();
        }
    });
});

async function loadShops() {
    try {
        const response = await apiCall('shops');
        const shops = response.success ? response.data : [];
        
        const container = document.getElementById('shops-container');
        
        if (shops.length === 0) {
            container.innerHTML = '<div class="col-span-full text-center text-gray-500 py-8">Henüz mağaza bulunmamaktadır.</div>';
            return;
        }
        
        container.innerHTML = shops.map(shop => `
            <a href="/shops/${shop.id}" class="block">
                <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                ${escapeHtml(shop.name)}
                            </h3>
                            <p class="text-sm text-gray-600 mb-2 line-clamp-2">
                                ${escapeHtml(shop.description || '')}
                            </p>
                            <p class="text-xs text-gray-500">
                                ${escapeHtml(shop.address || '')}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>${shop.product_count || 0} ürün</span>
                        </div>
                        
                        <span class="badge badge-success">Aktif</span>
                    </div>
                </div>
            </a>
        `).join('');
        
    } catch (error) {
        console.error('Error loading shops:', error);
        const container = document.getElementById('shops-container');
        container.innerHTML = '<div class="col-span-full text-center text-red-500 py-8">Mağazalar yüklenirken hata oluştu.</div>';
    }
}

function searchShops() {
    const searchInput = document.getElementById('search-input');
    const search = searchInput.value.trim();
    // Implement search functionality
    loadShops();
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
