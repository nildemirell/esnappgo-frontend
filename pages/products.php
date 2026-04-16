<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Ürünler</h1>
            <p class="text-gray-600">Öğrenciler tarafından sahadan paylaşılan tüm ürünler</p>
        </div>

        <div style="display: flex; flex-direction: row; gap: 2rem;">
            <!-- Filters Sidebar -->
            <div style="width: 320px; flex-shrink: 0;">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                    <!-- Filter Header -->
                    <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                </path>
                            </svg>
                            Filtreler
                        </h3>
                        <button onclick="clearAllFilters()"
                            class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                            Temizle
                        </button>
                    </div>

                    <!-- Search -->
                    <div class="p-4 border-b border-gray-100">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Arama</label>
                        <div class="relative">
                            <input type="text" id="search-input" placeholder="Ürün ara..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                style="padding-left: 2.5rem;" />
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="p-4 border-b border-gray-100">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Kategoriler</label>
                        <div id="categories-container" class="space-y-2 max-h-64 overflow-y-auto">
                            <!-- Kategoriler buraya yüklenecek -->
                            <div class="animate-pulse space-y-2">
                                <div class="h-6 bg-gray-200 rounded"></div>
                                <div class="h-6 bg-gray-200 rounded w-3/4"></div>
                                <div class="h-6 bg-gray-200 rounded w-5/6"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="p-4 border-b border-gray-100">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Fiyat Aralığı</label>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-2">
                                <div class="flex-1">
                                    <input type="number" id="min-price" placeholder="Min" min="0"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" />
                                </div>
                                <span class="text-gray-400">-</span>
                                <div class="flex-1">
                                    <input type="number" id="max-price" placeholder="Max" min="0"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" />
                                </div>
                            </div>

                            <!-- Price Range Slider -->
                            <div class="relative pt-1">
                                <input type="range" id="price-slider" min="0" max="1000" value="1000"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600" />
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>₺0</span>
                                    <span id="price-slider-value">₺1000</span>
                                </div>
                            </div>

                            <!-- Quick Price Buttons -->
                            <div class="flex flex-wrap gap-2">
                                <button onclick="setQuickPrice(0, 25)"
                                    class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition">₺0-25</button>
                                <button onclick="setQuickPrice(25, 50)"
                                    class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition">₺25-50</button>
                                <button onclick="setQuickPrice(50, 100)"
                                    class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition">₺50-100</button>
                                <button onclick="setQuickPrice(100, null)"
                                    class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition">₺100+</button>
                            </div>
                        </div>
                    </div>

                    <!-- Sort -->
                    <div class="p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sıralama</label>
                        <select id="sort-select"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="newest">En Yeni</option>
                            <option value="oldest">En Eski</option>
                            <option value="price_asc">Fiyat: Düşükten Yükseğe</option>
                            <option value="price_desc">Fiyat: Yüksekten Düşüğe</option>
                            <option value="name_asc">İsim: A-Z</option>
                            <option value="name_desc">İsim: Z-A</option>
                            <option value="popular">Popüler</option>
                        </select>
                    </div>

                    <!-- Apply Filters Button (Mobile) -->
                    <div class="p-4 lg:hidden">
                        <button onclick="applyFilters()" class="w-full btn btn-primary">
                            Filtreleri Uygula
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div style="flex: 1; min-width: 0;">
                <!-- Active Filters & Results Info -->
                <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span id="results-count" class="text-sm text-gray-600">Yükleniyor...</span>

                        <!-- Active Filter Tags -->
                        <div id="active-filters" class="flex flex-wrap gap-2">
                            <!-- Aktif filtre tag'ları buraya eklenecek -->
                        </div>
                    </div>

                    <!-- Mobile Filter Toggle -->
                    <button onclick="toggleMobileFilters()"
                        class="lg:hidden flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        Filtreler
                    </button>
                </div>

                <!-- Products Grid -->
                <div id="products-container" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Loading skeleton -->
                    <?php for ($i = 0; $i < 6; $i++): ?>
                        <div class="animate-pulse skeleton-item">
                            <div class="bg-gray-200 h-48 rounded-lg mb-4"></div>
                            <div class="h-4 bg-gray-200 rounded mb-2"></div>
                            <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                        </div>
                    <?php endfor; ?>
                </div>

                <!-- Load More Button -->
                <div class="text-center mt-12">
                    <button id="load-more-btn" onclick="loadMoreProducts()"
                        class="px-8 py-3 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors"
                        style="display: none;">
                        <span id="load-more-text">Daha Fazla Yükle</span>
                        <svg id="load-more-spinner" class="hidden animate-spin ml-2 h-4 w-4 text-gray-700 inline"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- No Results -->
                <div id="no-results" class="text-center py-16" style="display: none;">
                    <div class="bg-white rounded-2xl shadow-sm p-12 border border-gray-100">
                        <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Ürün bulunamadı</h3>
                        <p class="text-gray-500 mb-6">Arama kriterlerinize uygun ürün bulunmamaktadır.</p>
                        <button onclick="clearAllFilters()" class="btn btn-primary">
                            Filtreleri Temizle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Filters Overlay -->
<div id="mobile-filters-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 lg:hidden" style="display: none;"
    onclick="toggleMobileFilters()">
    <div class="absolute right-0 top-0 h-full w-80 max-w-full bg-white shadow-xl" onclick="event.stopPropagation()">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-900">Filtreler</h3>
            <button onclick="toggleMobileFilters()" class="p-2 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <!-- Mobile filter content will be cloned here -->
    </div>
</div>

<script>
    // State
    let currentPage = 0;
    let isLoading = false;
    let hasMoreProducts = true;
    let currentFilters = {
        search: '',
        category: [], // Burası artık bir dizi (çoklu seçim için)
        minPrice: '',
        maxPrice: '',
        sort: 'newest'
    };
    let categories = [];
    let priceRange = { min: 0, max: 1000 };
    let debounceTimer = null;
    let globalFavorites = [];

    // Initialize
    document.addEventListener('DOMContentLoaded', async function () {
        // URL'den filtreleri al
        parseUrlParams();

        // Kategorileri yükle
        loadCategories();

        // Favori state'i önce çek, sonra ürünleri render et (race condition önleme)
        const isLoggedIn = <?php echo json_encode($current_user ? true : false); ?>;
        if (isLoggedIn) {
            try {
                const favResp = await apiCall('Favorites');
                // FavoriteProductDto alanı "productId" — "id" DEĞİL
                const favData = Array.isArray(favResp) ? favResp : (favResp.items || favResp.data || []);
                globalFavorites = favData.map(f => Number(f.productId || f.ProductId || f.id || 0));
                console.log('Favoriler yüklendi:', globalFavorites);
            } catch (e) {
                console.warn('Favoriler yüklenemedi, liste boş başlıyor:', e);
            }
        }

        // Ürünleri yükle (favoriler hazır olduktan sonra)
        loadProducts(true);

        // Event listeners
        setupEventListeners();
    });


    function parseUrlParams() {
        const urlParams = new URLSearchParams(window.location.search);

        if (urlParams.has('search')) {
            currentFilters.search = urlParams.get('search');
            document.getElementById('search-input').value = currentFilters.search;
        }
        if (urlParams.has('category')) {
            currentFilters.category = urlParams.get('category').split(',').filter(Boolean);
        }
        if (urlParams.has('min_price')) {
            currentFilters.minPrice = urlParams.get('min_price');
            document.getElementById('min-price').value = currentFilters.minPrice;
        }
        if (urlParams.has('max_price')) {
            currentFilters.maxPrice = urlParams.get('max_price');
            document.getElementById('max-price').value = currentFilters.maxPrice;
        }
        if (urlParams.has('sort')) {
            currentFilters.sort = urlParams.get('sort');
            document.getElementById('sort-select').value = currentFilters.sort;
        }
    }

    function setupEventListeners() {
        // Search input with debounce
        document.getElementById('search-input').addEventListener('input', function (e) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                currentFilters.search = e.target.value;
                applyFilters();
            }, 500);
        });

        // Sort select
        document.getElementById('sort-select').addEventListener('change', function (e) {
            currentFilters.sort = e.target.value;
            applyFilters();
        });

        // Price inputs with debounce
        document.getElementById('min-price').addEventListener('input', function (e) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                currentFilters.minPrice = e.target.value;
                applyFilters();
            }, 500);
        });

        document.getElementById('max-price').addEventListener('input', function (e) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                currentFilters.maxPrice = e.target.value;
                applyFilters();
            }, 500);
        });

        // Price slider
        document.getElementById('price-slider').addEventListener('input', function (e) {
            document.getElementById('price-slider-value').textContent = '₺' + e.target.value;
            currentFilters.maxPrice = e.target.value;
        });

        document.getElementById('price-slider').addEventListener('change', function (e) {
            applyFilters();
        });

        // Enter key for search
        document.getElementById('search-input').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                currentFilters.search = e.target.value;
                applyFilters();
            }
        });
    }

   async function loadCategories() {
        try {
            // BURASI DÜZELTİLDİ: Artık hiyerarşik (tree) yapıyı getirecek
            const response = await apiCall('Categories/tree'); 

            // .NET backend direkt array döner
            if (Array.isArray(response)) {
                categories = response;
            } else {
                console.error("Beklenmeyen format geldi:", response);
                return;
            }

            renderCategories();
        } catch (error) {
            console.error('Kategoriler çekilirken hata oluştu:', error);
        }
    }


    function renderCategories() {
        const container = document.getElementById('categories-container');

        if (!categories || categories.length === 0) {
            container.innerHTML = '<p class="text-sm text-gray-500">Kategori bulunamadı</p>';
            return;
        }

        const isAllSelected = currentFilters.category.length === 0;

        let html = `
        <label class="flex items-center p-2 rounded-lg cursor-pointer hover:bg-gray-50 transition ${isAllSelected ? 'bg-blue-50 text-blue-700' : ''}">
            <input type="checkbox" value="" ${isAllSelected ? 'checked' : ''} class="mr-3 text-blue-600 rounded" onchange="toggleCategory('')">
            <span class="text-sm flex-1">Tüm Kategoriler</span>
        </label>
    `;

        categories.forEach(category => {
            const catId = category.id ?? category.categoryId;
            const catName = category.name ?? category.categoryName ?? 'Kategori';
            const isSelected = currentFilters.category.includes(String(catId));
            html += `
            <div class="category-group">
                <label class="flex items-center p-2 rounded-lg cursor-pointer hover:bg-gray-50 transition ${isSelected ? 'bg-blue-50 text-blue-700' : ''}">
                    <input type="checkbox" value="${catId}" ${isSelected ? 'checked' : ''} class="mr-3 text-blue-600 rounded" onchange="toggleCategory('${catId}')">
                    <span class="text-sm flex-1">
                        ${category.icon ? category.icon + ' ' : ''}${escapeHtml(catName)}
                    </span>
                    <span class="text-xs text-gray-400 ml-2">${category.productCount ?? category.product_count ?? 0}</span>
                </label>
        `;
            // Alt kategoriler
            if (category.children && category.children.length > 0) {
                html += '<div class="ml-6 mt-1 space-y-1">';
                category.children.forEach(child => {
                    const isChildSelected = currentFilters.category.includes(String(child.id));
                    html += `
                    <label class="flex items-center p-1.5 rounded cursor-pointer hover:bg-gray-50 transition text-sm ${isChildSelected ? 'bg-blue-50 text-blue-700' : 'text-gray-600'}">
                        <input type="checkbox" value="${child.id}" ${isChildSelected ? 'checked' : ''} class="mr-2 text-blue-600 h-3 w-3 rounded" onchange="toggleCategory('${child.id}')">
                        <span class="flex-1">${child.icon ? child.icon + ' ' : ''}${escapeHtml(child.name)}</span>
                      <span class="text-xs text-gray-400">${child.productCount ?? child.product_count ?? 0}</span>

                    </label>
                `;
                });
                html += '</div>';
            }

            html += '</div>';
        });

        container.innerHTML = html;
    }

    function toggleCategory(categoryId) {
        if (categoryId === '') {
            currentFilters.category = []; // "Tüm Kategoriler" seçilirse diziyi boşalt
        } else {
            categoryId = String(categoryId);
            
            // 1. Tıklanan kategoriyi bul
            const category = findCategoryById(categoryId);
            
            // 2. Bu kategorinin ve varsa TÜM alt kategorilerinin ID'lerini bu dizide toplayacağız
            let idsToToggle = [categoryId];
            
            // Alt kategorileri bulan yardımcı (recursive) fonksiyon
            function collectChildIds(cat) {
                const children = cat.children || cat.subCategories || [];
                children.forEach(child => {
                    idsToToggle.push(String(child.id));
                    collectChildIds(child); // Altın da altı varsa diye kendini tekrar çağır
                });
            }
            
            // Eğer kategori bulunduysa alt kategorilerini topla
            if (category) {
                collectChildIds(category);
            }

            // 3. Tıkladığımız ana kategori şu an dizide var mı? (Seçili mi?)
            const isCurrentlySelected = currentFilters.category.includes(categoryId);

            if (isCurrentlySelected) {
                // SEÇİMİ KALDIR: Hem ana kategoriyi hem de altındaki tüm çocukları diziden çıkar
                currentFilters.category = currentFilters.category.filter(id => !idsToToggle.includes(id));
            } else {
                // SEÇ: Hem ana kategoriyi hem de tüm çocukları diziye ekle (Mükerrer eklememek için kontrol et)
                idsToToggle.forEach(id => {
                    if (!currentFilters.category.includes(id)) {
                        currentFilters.category.push(id);
                    }
                });
            }
        }

        renderCategories();
        applyFilters();
    }

    function setQuickPrice(min, max) {
        document.getElementById('min-price').value = min;
        document.getElementById('max-price').value = max || '';
        currentFilters.minPrice = min;
        currentFilters.maxPrice = max || '';

        if (max) {
            document.getElementById('price-slider').value = max;
            document.getElementById('price-slider-value').textContent = '₺' + max;
        }

        applyFilters();
    }

    function applyFilters() {
        currentPage = 0;
        hasMoreProducts = true;
        loadProducts(true);
        updateUrl();
        updateActiveFilterTags();
    }

    function updateUrl() {
        const params = new URLSearchParams();

        if (currentFilters.search) params.set('search', currentFilters.search);
        if (currentFilters.category && currentFilters.category.length > 0) params.set('category', currentFilters.category.join(','));
        if (currentFilters.minPrice) params.set('min_price', currentFilters.minPrice);
        if (currentFilters.maxPrice) params.set('max_price', currentFilters.maxPrice);
        if (currentFilters.sort && currentFilters.sort !== 'newest') params.set('sort', currentFilters.sort);

        const newUrl = params.toString() ? `?${params.toString()}` : window.location.pathname;
        window.history.replaceState({}, '', newUrl);
    }

    function updateActiveFilterTags() {
        const container = document.getElementById('active-filters');
        let html = '';

        if (currentFilters.search) {
            html += createFilterTag('search', `"${currentFilters.search}"`);
        }

        if (currentFilters.category && currentFilters.category.length > 0) {
            currentFilters.category.forEach(catId => {
                const cat = findCategoryById(catId);
                if (cat) {
                    html += createFilterTag('category_' + catId, cat.name);
                }
            });
        }

        if (currentFilters.minPrice || currentFilters.maxPrice) {
            let priceText = '';
            if (currentFilters.minPrice && currentFilters.maxPrice) {
                priceText = `₺${currentFilters.minPrice} - ₺${currentFilters.maxPrice}`;
            } else if (currentFilters.minPrice) {
                priceText = `₺${currentFilters.minPrice}+`;
            } else {
                priceText = `₺0 - ₺${currentFilters.maxPrice}`;
            }
            html += createFilterTag('price', priceText);
        }

        container.innerHTML = html;
    }

    function createFilterTag(type, label) {
        return `
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
            ${escapeHtml(label)}
            <button onclick="removeFilter('${type}')" class="ml-2 text-blue-600 hover:text-blue-800">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </span>
    `;
    }

    function removeFilter(type) {
        if (type.startsWith('category_')) {
            const catId = type.split('_')[1];
            currentFilters.category = currentFilters.category.filter(id => id !== catId);
            renderCategories();
            applyFilters();
            return;
        }
        switch (type) {
            case 'search':
                currentFilters.search = '';
                document.getElementById('search-input').value = '';
                break;
            case 'category':
                currentFilters.category = [];
                renderCategories();
                break;

            case 'price':
                currentFilters.minPrice = '';
                currentFilters.maxPrice = '';
                document.getElementById('min-price').value = '';
                document.getElementById('max-price').value = '';
                document.getElementById('price-slider').value = priceRange.max;
                document.getElementById('price-slider-value').textContent = '₺' + priceRange.max;
                break;
        }
        applyFilters();
    }

    function clearAllFilters() {
        currentFilters = {
            search: '',
            category: [],
            minPrice: '',
            maxPrice: '',
            sort: 'newest'
        };

        document.getElementById('search-input').value = '';
        document.getElementById('min-price').value = '';
        document.getElementById('max-price').value = '';
        document.getElementById('sort-select').value = 'newest';
        document.getElementById('price-slider').value = priceRange.max;
        document.getElementById('price-slider-value').textContent = '₺' + priceRange.max;

        renderCategories();
        applyFilters();
    }

    function findCategoryById(id) {
        for (const cat of categories) {
            if (cat.id == id) return cat;
            if (cat.children) {
                for (const child of cat.children) {
                    if (child.id == id) return child;
                }
            }
        }
        return null;
    }

    async function loadProducts(reset = false) {
        if (isLoading) return;

        if (reset) {
            currentPage = 0;
            hasMoreProducts = true;
        }

        if (!hasMoreProducts) return;

        isLoading = true;

        // Show loading state for load more button
        const loadMoreBtn = document.getElementById('load-more-btn');
        const loadMoreText = document.getElementById('load-more-text');
        const loadMoreSpinner = document.getElementById('load-more-spinner');

        if (!reset && loadMoreBtn) {
            loadMoreText.textContent = 'Yükleniyor...';
            loadMoreSpinner.classList.remove('hidden');
        }

        try {
            const limit = 9;
            const offset = currentPage * limit;
            // Backend parametre isimleri: minPrice, maxPrice, search, categoryId, limit, offset, sort
            let params = new URLSearchParams();
            
            params.set('limit', limit);
            params.set('offset', offset);

            if (currentFilters.search) {
                params.set('search', currentFilters.search);
            }
            if (currentFilters.category && currentFilters.category.length > 0) {
                params.set('categoryId', currentFilters.category[0]);
            }
            if (currentFilters.minPrice !== '' && currentFilters.minPrice !== null && currentFilters.minPrice !== undefined) {
                params.set('minPrice', Number(currentFilters.minPrice));
            }
            if (currentFilters.maxPrice !== '' && currentFilters.maxPrice !== null && currentFilters.maxPrice !== undefined) {
                params.set('maxPrice', Number(currentFilters.maxPrice));
            }
            if (currentFilters.sort && currentFilters.sort !== 'newest') {
                params.set('sort', currentFilters.sort);
            }

            const queryString = params.toString();
            let endpoint = `products?${queryString}`;

            const response = await apiCall(endpoint);
            // .NET backend `products` array ve `totalCount` dönüyor
            const products = Array.isArray(response) ? response : (response.products || response.data || []);
            const totalCount = response.totalCount ?? response.TotalCount ?? null;
            
            // Pagination hesabı
            const meta = { 
                has_more: totalCount !== null ? (offset + limit < totalCount) : products.length >= limit,
                total: totalCount ?? products.length
            };

            const container = document.getElementById('products-container');

            // Update price range from API
            if (meta.price_range) {
                priceRange = meta.price_range;
                const slider = document.getElementById('price-slider');
                slider.max = Math.ceil(priceRange.max);
                if (!currentFilters.maxPrice) {
                    slider.value = Math.ceil(priceRange.max);
                    document.getElementById('price-slider-value').textContent = '₺' + Math.ceil(priceRange.max);
                }
            }

            // Update results count
            const totalText = meta.total ? `${meta.total} ürün bulundu` : `${products.length} ürün`;
            document.getElementById('results-count').textContent = totalText;

            if (reset) {
                container.innerHTML = '';
            }

            if (products.length === 0) {
                if (reset) {
                    document.getElementById('no-results').style.display = 'block';
                    loadMoreBtn.style.display = 'none';
                } else {
                    hasMoreProducts = false;
                    loadMoreBtn.style.display = 'none';
                }
            } else {
                document.getElementById('no-results').style.display = 'none';

                // Add products
                const productsHTML = products.map(product => createProductCardHTML(product)).join('');
                container.innerHTML += productsHTML;

                // Check if there are more products
                hasMoreProducts = meta.has_more !== undefined ? meta.has_more : products.length >= limit;
                loadMoreBtn.style.display = hasMoreProducts ? 'inline-flex' : 'none';

                currentPage++;
            }

        } catch (error) {
            console.error('Error loading products:', error);
            showToast('Ürünler yüklenirken hata oluştu', 'error');
        } finally {
            isLoading = false;

            // Reset load more button
            if (loadMoreBtn) {
                loadMoreText.textContent = 'Daha Fazla Yükle';
                loadMoreSpinner.classList.add('hidden');
            }
        }
    }
    function createProductCardHTML(product) {
        let imageUrl = '';

        // YENİ EKLENEN KISIM: Backend dizisi imageUrls olarak geliyor, yoksa eski images'i kullan (fallback)
        const imagesArray = product.imageUrls || product.images || [];

        if (imagesArray.length > 0) {
            imageUrl = imagesArray[0];
            if (!imageUrl.startsWith('/') && !imageUrl.startsWith('http')) {
                imageUrl = '/' + imageUrl;
            }
        }

        // YENİ EKLENEN KISIM: Backend name dönüyor, fallback olarak title
        const displayName = product.name || product.title || 'İsimsiz Ürün';

        // YENİ EKLENEN KISIM: Backend finalPrice dönüyor, fallback olarak price
        const displayPrice = product.finalPrice || product.suggestedPrice || product.price || 0;

        const isFavorited = globalFavorites.includes(Number(product.id));

        const imageHtml = imageUrl ?
            `<img 
            src="${imageUrl}" 
            alt="${escapeHtml(displayName)}"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            onerror="this.src='/media/68a658361732a_1755732022.jpg'"
        />` :
            `<div class="w-full h-full flex items-center justify-center bg-gray-100">
            <span class="text-gray-400 text-4xl">📷</span>
        </div>`;

        const categoryBadge = (product.categoryName || (product.category && product.category.name)) ?
            `<span class="absolute top-2 left-2 px-2 py-1 bg-white/90 backdrop-blur-sm text-xs font-medium text-gray-700 rounded-full">
            ${escapeHtml(product.categoryName || product.category?.name)}
        </span>` : '';

        return `
        <a href="/products/${product.id}" class="group block">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:border-gray-200 transition-all duration-300">
                <div class="relative h-48 bg-gray-100 overflow-hidden">
                    ${imageHtml}
                    ${categoryBadge}
                    
                    <div class="absolute top-2 right-2">
                        <span class="inline-flex items-center px-2 py-1 bg-gradient-to-r from-blue-500/90 to-purple-500/90 backdrop-blur-sm text-white text-xs font-medium rounded-full">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            Öğrenci
                        </span>
                    </div>
                </div>

                <div class="p-4">
                    <div class="flex items-start justify-between mb-1 gap-2">
                        <h3 class="font-semibold text-gray-900 line-clamp-1 group-hover:text-blue-600 transition-colors flex-1" title="${escapeHtml(displayName)}">
                            ${escapeHtml(displayName)}
                        </h3>
                        
                        <button 
                            onclick="event.preventDefault(); event.stopPropagation(); toggleFavorite(${product.id}, this);" 
                            class="text-gray-300 hover:text-red-500 hover:bg-red-50 p-1.5 -m-1.5 rounded-full transition-all focus:outline-none flex-shrink-0 ${isFavorited ? 'text-red-500 bg-red-50' : ''}"
                            title="Favorilere Ekle"
                        >
                            <svg class="heart-empty w-5 h-5 pointer-events-none ${isFavorited ? 'hidden' : ''}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <svg class="heart-full w-5 h-5 pointer-events-none text-red-500 ${isFavorited ? '' : 'hidden'}" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <p class="text-sm text-gray-500 mb-3 line-clamp-2 h-10">
                        ${escapeHtml(product.description || '')}
                    </p>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xl font-bold text-blue-600">
                            ₺${parseFloat(displayPrice).toFixed(2)}
                        </span>
                        
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            4.8
                        </div>
                    </div>

                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-gray-500 truncate max-w-[120px]">
                            ${escapeHtml(product.merchantName || product.shop?.name || 'Esnaf')}
                        </span>
                        
                        <button 
                            onclick="event.preventDefault(); event.stopPropagation(); addToCart(${product.id}); return false;" 
                            class="flex items-center justify-center px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                            <?php echo !$current_user ? 'disabled title="Giriş yapmalısınız"' : ''; ?>
                        >
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Sepete
                        </button>
                    </div>
                </div>
            </div>
        </a>
    `;
    }

    function loadMoreProducts() {
        loadProducts(false);
    }

    function toggleMobileFilters() {
        const overlay = document.getElementById('mobile-filters-overlay');
        overlay.style.display = overlay.style.display === 'none' ? 'block' : 'none';
        document.body.style.overflow = overlay.style.display === 'none' ? '' : 'hidden';
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text || '';
        return div.innerHTML;
    }
    async function toggleFavorite(productId, btnElement) {
        const emptyHeart = btnElement.querySelector('.heart-empty');
        const fullHeart = btnElement.querySelector('.heart-full');

        // Kalp şu an boş mu dolu mu kontrol et
        const isFavorited = !fullHeart.classList.contains('hidden');

        if (isFavorited) {
            // Zaten favoriyse: Çıkar
            fullHeart.classList.add('hidden');
            emptyHeart.classList.remove('hidden');
            btnElement.classList.remove('text-red-500'); // hover rengini geri al

            globalFavorites = globalFavorites.filter(id => id !== productId);
            showToast('Ürün favorilerden çıkarıldı', 'info');
        } else {
            // Favori değilse: Ekle
            emptyHeart.classList.add('hidden');
            fullHeart.classList.remove('hidden');
            btnElement.classList.add('text-red-500'); // Kırmızı kalmasını sağla

            // Zıplama efekti
            btnElement.classList.add('scale-125');
            setTimeout(() => btnElement.classList.remove('scale-125'), 200);

            if (!globalFavorites.includes(productId)) {
                globalFavorites.push(productId);
            }
            showToast('Ürün favorilere eklendi!', 'success');
        }

        try {
            // Backend'e toggle isteği atıyoruz
            await apiCall(`Favorites/toggle/${productId}`, { method: 'POST' });
        } catch (error) {
            console.error('Error toggling favorite:', error);
            showToast('Favori işlemi sırasında hata oluştu', 'error');
            
            // Eğer hata olursa optimistik güncellemeyi geri al (isteğe bağlı)
            // loadProducts(false) falan diyebiliriz veya tekrar kalbi eskiye çevirebiliriz.
        }
    }

    // Ekstra: Sayfa yüklenince eğer ürün daha önceden favorilere eklenmişse kalbi dolu göster
    // createProductCardHTML fonksiyonunun başlangıcında productId'yi kontrol edip
    // globalFavorites üzerinden kalbi dolu yapıyoruz. Artık çalışıyor.


</script>

<style>
    /* Custom scrollbar for categories */
    #categories-container::-webkit-scrollbar {
        width: 4px;
    }

    #categories-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    #categories-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }

    #categories-container::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }

    /* Range slider styling */
    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #2563eb;
        cursor: pointer;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    input[type="range"]::-moz-range-thumb {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #2563eb;
        cursor: pointer;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
</style>