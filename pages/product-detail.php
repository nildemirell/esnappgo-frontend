<?php
// Ürün ID'sini al
if (!isset($product_id) || !is_numeric($product_id)) {
    header('Location: /products');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="/products" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Ürünlere Dön
            </a>
        </div>

        <!-- Product Detail Container -->
        <div id="product-detail-container" class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Loading State -->
            <div id="loading-state" class="animate-pulse">
                <div class="lg:grid lg:grid-cols-2 lg:gap-8">
                    <div class="aspect-w-1 aspect-h-1 bg-gray-200 lg:aspect-w-3 lg:aspect-h-4">
                        <div class="w-full h-96 bg-gray-200"></div>
                    </div>
                    <div class="p-6">
                        <div class="h-8 bg-gray-200 rounded mb-4"></div>
                        <div class="h-4 bg-gray-200 rounded mb-2"></div>
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                        <div class="h-6 bg-gray-200 rounded w-1/3 mb-4"></div>
                        <div class="h-12 bg-gray-200 rounded"></div>
                    </div>
                </div>
            </div>

            <!-- Product Content (Hidden initially) -->
            <div id="product-content" style="display: none;">
                <div class="lg:grid lg:grid-cols-2 lg:gap-8">
                    <!-- Product Images -->
                    <div class="relative">
                        <div class="aspect-w-1 aspect-h-1 bg-gray-100 lg:aspect-w-3 lg:aspect-h-4">
                            <img id="main-image" src="" alt="" class="w-full h-full object-cover" />

                            <!-- Image Navigation -->
                            <button id="prev-image"
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-all"
                                style="display: none;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button id="next-image"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-all"
                                style="display: none;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Image Thumbnails -->
                        <div id="image-thumbnails" class="mt-4 flex space-x-2 overflow-x-auto"></div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-6">
                        <!-- Student Badge -->
                        <div class="mb-4">
                            <span class="badge badge-student inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Öğrenci Destekli
                            </span>
                        </div>

                        <!-- Product Title -->
                        <h1 id="product-title" class="text-3xl font-bold text-gray-900 mb-4"></h1>

                        <!-- Product Description -->
                        <p id="product-description" class="text-gray-600 mb-6 leading-relaxed"></p>

                        <!-- Price -->
                        <div class="mb-6">
                            <span id="product-price" class="text-4xl font-bold text-blue-600"></span>
                        </div>

                        <!-- Stock Info -->
                        <div class="mb-6">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span id="stock-info">Stok: </span>
                            </div>
                        </div>

                        <!-- Quantity Selector & Add to Cart -->
                        <?php if ($current_user): ?>
                            <div class="mb-6">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center border border-gray-300 rounded-md">
                                        <button onclick="changeQuantity(-1)"
                                            class="p-2 text-gray-600 hover:text-gray-800 disabled:opacity-50"
                                            id="decrease-qty">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <input type="number" id="quantity" value="1" min="1"
                                            class="w-16 text-center border-0 focus:ring-0 focus:outline-none" readonly />
                                        <button onclick="changeQuantity(1)"
                                            class="p-2 text-gray-600 hover:text-gray-800 disabled:opacity-50"
                                            id="increase-qty">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <button onclick="addToCartFromDetail()" class="flex-1 btn btn-primary btn-lg">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5 6m0 0h9m-9 0V19a2 2 0 002 2h6a2 2 0 002-2v-4">
                                            </path>
                                        </svg>
                                        Sepete Ekle
                                    </button>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="mb-6">
                                <a href="/login" class="block w-full btn btn-primary btn-lg text-center">
                                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Sepete Eklemek İçin Giriş Yapın
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- Shop Info -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Mağaza Bilgileri</h3>
                            <div class="flex items-start space-x-3">
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 id="shop-name" class="font-medium text-gray-900"></h4>
                                    <p id="shop-address" class="text-sm text-gray-500"></p>
                                    <a id="shop-link" href="#"
                                        class="text-sm text-blue-600 hover:text-blue-500">Mağazayı Görüntüle</a>
                                </div>
                            </div>
                        </div>

                        <!-- Favorilere Ekle -->
                        <?php if ($current_user): ?>
                            <div class="mb-6">
                                <button onclick="toggleDetailFavorite()" id="favorite-btn"
                                    class="flex items-center space-x-2 text-gray-600 hover:text-red-500 transition-colors focus:outline-none">
                                    <!-- Boş Kalp -->
                                    <svg id="heart-empty" class="w-5 h-5 pointer-events-none" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                    <!-- Dolu Kalp (Başlangıçta gizli) -->
                                    <svg id="heart-full" class="w-5 h-5 hidden pointer-events-none text-red-500"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z">
                                        </path>
                                    </svg>
                                    <span id="favorite-text">Favorilere Ekle</span>
                                </button>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentProduct = null;
    let currentImageIndex = 0;
    let quantity = 1;

    document.addEventListener('DOMContentLoaded', function () {
        const productId = <?php echo json_encode($product_id); ?>;
        loadProduct(productId);
    });

    // Ham ürün datasını (API veya cache) tutarlı bir yapıya dönüştürür
    function normalizeProduct(raw) {
        return {
            ...raw,
            id:          raw.id          || raw.Id,
            title:       raw.name        || raw.title   || raw.Name,
            price:       raw.finalPrice  || raw.suggestedPrice || raw.SuggestedPrice,
            images:      raw.imageUrls   || raw.ImageUrls || [],
            description: raw.description || 'Bu ürünün detaylı açıklaması bulunmamaktadır.',
            shop_name:   raw.merchantName || raw.MerchantName || 'Kampüs Esnafı',
            merchantId:  raw.merchantId   || raw.MerchantId   || null,
        };
    }

    async function loadProduct(productId) {
        console.log('Fetching real product data for ID:', productId);

        // ─── ADIM 0: Mağaza sayfasından tıklandıysa ürün zaten cache'de ───
        try {
            const cacheKey = 'cached_product_' + productId;
            const cached = sessionStorage.getItem(cacheKey);
            if (cached) {
                sessionStorage.removeItem(cacheKey); // Tek kullanımlık
                const cachedProduct = JSON.parse(cached);
                console.log('Product loaded from sessionStorage cache (no API call needed)');
                currentProduct = normalizeProduct(cachedProduct);
                setTimeout(() => displayProduct(currentProduct), 100);
                return; // API'ye gitme
            }
        } catch (e) { /* sessionStorage okunamazsa API'ye düş */ }

        try {
            // Backend'den çekiyoruz, limit = 1000 koyarak bulma olasılığını yükseltiyoruz
            const response = await apiCall('products?limit=1000');
            const allProducts = Array.isArray(response) ? response : (response.products || response.data || []);
            let foundProduct = allProducts.find(p => p.id == productId || p.Id == productId);

            // Eğer ürün onaylanmamış/reddedilmiş ise public listede çıkmaz. 
            // Kullanıcının rolüne göre kendi ürünleri listesinde tekrar ara!
            if (!foundProduct) {
                // PHP Session'ına (%100 güvenemeyiz) alternatif olarak JWT'den okuyalım.
                let userRole = <?php echo json_encode($current_user ? $current_user['role'] : null); ?>;
                const token = localStorage.getItem('auth_token');
                if (token) {
                    try {
                        const payload = JSON.parse(atob(token.split('.')[1]));
                        const jwtRole = payload['http://schemas.microsoft.com/ws/2008/06/identity/claims/role'] || payload.role;
                        if (jwtRole) userRole = jwtRole.toLowerCase();
                    } catch (e) { }
                }

                if (userRole) {
                    try {
                        console.log('Searching in private list for role:', userRole);
                        let privateResponse = null;
                        if (userRole === 'esnaf' || userRole === 'merchant') {
                            privateResponse = await apiCall('Merchant/products');
                        } else if (userRole === 'ogrenci' || userRole === 'student') {
                            privateResponse = await apiCall('Products/my-products');
                        } else if (userRole === 'admin') {
                            privateResponse = await apiCall('Admin/products');
                        }

                        if (privateResponse) {
                            console.log('Private response:', privateResponse);
                            const privateProducts = Array.isArray(privateResponse)
                                ? privateResponse
                                : (privateResponse.products || privateResponse.data || privateResponse.items || Object.values(privateResponse).find(v => Array.isArray(v)) || []);

                            console.log('Parsed private products list:', privateProducts);
                            foundProduct = privateProducts.find(p => p.id == productId || p.Id == productId);
                        }
                    } catch (e) {
                        console.log('Kullanıcıya özel listede ürün aranırken hata oluştu:', e);
                    }
                }
            }

            if (!foundProduct) {
                showToast('Ürün bulunamadı veya onaylanmamış.', 'error');
                return;
            }

            currentProduct = normalizeProduct(foundProduct);

            setTimeout(() => {
                displayProduct(currentProduct);
            }, 300);

        } catch (error) {
            console.error('Error loading product:', error);
            showToast('Ürün yüklenirken hata oluştu: ' + error.message, 'error');
        }
    }

    function displayProduct(product) {
        // Hide loading, show content
        document.getElementById('loading-state').style.display = 'none';
        document.getElementById('product-content').style.display = 'block';

        // Set product info (.NET DTO isimlendirmeleri eklendi)
        document.getElementById('product-title').textContent = product.name || product.title || 'İsimsiz Ürün';
        document.getElementById('product-description').textContent = product.description || '';

        const displayPrice = product.finalPrice || product.suggestedPrice || product.price || 0;
        document.getElementById('product-price').textContent = `₺${parseFloat(displayPrice).toFixed(2)}`;

        product.stock = product.stock || product.stockQuantity || 10;
        document.getElementById('stock-info').textContent = `Stok: ${product.stock} adet`;


        // Set shop info
        if (product.shop_name) {
            document.getElementById('shop-name').textContent = product.shop_name;
            // Address backendden gelmediği taktirde gizle veya varsayılan göster
            document.getElementById('shop-address').textContent = product.shop_address || 'Kampüs İçi';

            const shopLinkBtn = document.getElementById('shop-link');
            if (product.merchantId) {
                shopLinkBtn.href = `/shops/${product.merchantId}`;
                shopLinkBtn.onclick = null; // Eski toast engellemesini kaldır
            } else {
                shopLinkBtn.href = "#";
                shopLinkBtn.onclick = function (e) {
                    e.preventDefault();
                    showToast('Mağaza profili bulunamadı.', 'info');
                };
            }
        } else if (product.shop) {

            document.getElementById('shop-name').textContent = product.shop.name;
            document.getElementById('shop-address').textContent = product.shop.address || '';
            document.getElementById('shop-link').href = `/shops/${product.shop.id}`;
        }

        // Set images
        console.log('Product full data:', product);
        console.log('Product images raw:', product.images);
        console.log('Product images type:', typeof product.images);
        console.log('Product images length:', product.images?.length);

        // Images array'ini düzgün parse et (.NET imageUrls dönüyor fallback olarak images)
        let images = [];
        const sourceImages = product.imageUrls || product.images;

        if (sourceImages) {
            if (typeof sourceImages === 'string') {
                try {
                    images = JSON.parse(sourceImages);
                } catch (e) {
                    console.error('JSON parse error for images:', e);
                    images = [sourceImages]; // String olarak kullan
                }
            } else if (Array.isArray(sourceImages)) {
                images = sourceImages;
            }
        }


        console.log('Parsed images:', images);

        if (images && images.length > 0) {
            setupImages(images);
        } else {
            // Fallback resim
            const fallbackImage = '/media/68a658361732a_1755732022.jpg';
            document.getElementById('main-image').src = fallbackImage;
            document.getElementById('main-image').alt = product.title || 'Ürün resmi';
            console.log('Using fallback image:', fallbackImage);
        }

        // Update quantity controls
        updateQuantityControls();
        checkFavoriteStatus(currentProduct.id);

    }

    function setupImages(images) {
        const mainImage = document.getElementById('main-image');
        const thumbnailsContainer = document.getElementById('image-thumbnails');
        const prevBtn = document.getElementById('prev-image');
        const nextBtn = document.getElementById('next-image');

        console.log('Setting up images:', images);

        // Resim yolunu düzelt (Gelen link "http" ile başlıyorsa başa / KOYMA!)
        let imagePath = images[0];
        if (!imagePath.startsWith('/') && !imagePath.startsWith('http')) {
            imagePath = '/' + imagePath;
        }

        // Set main image
        mainImage.src = imagePath;
        mainImage.alt = currentProduct.title;

        console.log('Main image set to:', imagePath);

        // Show navigation if multiple images
        if (images.length > 1) {
            prevBtn.style.display = 'block';
            nextBtn.style.display = 'block';

            // Create thumbnails
            thumbnailsContainer.innerHTML = images.map((img, index) => {
                let thumbPath = img;
                if (!thumbPath.startsWith('/') && !thumbPath.startsWith('http')) {
                    thumbPath = '/' + thumbPath;
                }
                return `

                <button 
                    onclick="setCurrentImage(${index})" 
                    class="w-16 h-16 rounded-lg overflow-hidden border-2 ${index === 0 ? 'border-blue-500' : 'border-gray-200'} hover:border-blue-300 transition-colors"
                >
                    <img src="${thumbPath}" alt="Thumbnail ${index + 1}" class="w-full h-full object-cover" />
                </button>
            `;
            }).join('');
        }

        // Navigation handlers
        prevBtn.onclick = () => {
            currentImageIndex = currentImageIndex === 0 ? images.length - 1 : currentImageIndex - 1;
            setCurrentImage(currentImageIndex);
        };

        nextBtn.onclick = () => {
            currentImageIndex = currentImageIndex === images.length - 1 ? 0 : currentImageIndex + 1;
            setCurrentImage(currentImageIndex);
        };
    }

    function setCurrentImage(index) {
        if (!currentProduct) return;
        const imagesArray = currentProduct.images || currentProduct.imageUrls || [];
        if (!imagesArray || imagesArray.length === 0) return;

        currentImageIndex = index;
        const mainImage = document.getElementById('main-image');

        // Resim yolunu düzelt
        let imagePath = imagesArray[index];
        if (imagePath && !imagePath.startsWith('/') && !imagePath.startsWith('http')) {
            imagePath = '/' + imagePath;
        }

        mainImage.src = imagePath || '/media/68a658361732a_1755732022.jpg';

        console.log('Image changed to:', imagePath);

        // Update thumbnail borders
        const thumbnails = document.querySelectorAll('#image-thumbnails button');
        thumbnails.forEach((thumb, i) => {
            thumb.className = thumb.className.replace('border-blue-500', 'border-gray-200');
            if (i === index) {
                thumb.className = thumb.className.replace('border-gray-200', 'border-blue-500');
            }
        });
    }

    function changeQuantity(delta) {
        const maxStock = currentProduct.stock || 10;
        const newQuantity = quantity + delta;
        if (newQuantity >= 1 && newQuantity <= maxStock) {
            quantity = newQuantity;
            document.getElementById('quantity').value = quantity;
            updateQuantityControls();
        }
    }

    function updateQuantityControls() {
        const decreaseBtn = document.getElementById('decrease-qty');
        const increaseBtn = document.getElementById('increase-qty');
        const maxStock = currentProduct ? (currentProduct.stock || 10) : 10;

        decreaseBtn.disabled = quantity <= 1;
        increaseBtn.disabled = quantity >= maxStock;
    }

    async function checkFavoriteStatus(productId) {
        const emptyHeart  = document.getElementById('heart-empty');
        const fullHeart   = document.getElementById('heart-full');
        const favoriteBtn = document.getElementById('favorite-btn');
        const favoriteText = document.getElementById('favorite-text');

        const token = localStorage.getItem('auth_token');
        if (!token) return; // Giriş yapmamış — buton zaten görünmez (PHP korumalı)

        try {
            const favsResp = await apiCall('Favorites');
            const favList  = Array.isArray(favsResp) ? favsResp : (favsResp.items || favsResp.data || []);
            const isFav    = favList.some(f => (f.productId || f.ProductId || f.id || f.Id) == productId);

            if (isFav) {
                emptyHeart.classList.add('hidden');
                fullHeart.classList.remove('hidden');
                favoriteBtn.classList.add('text-red-500', 'bg-red-50');
                favoriteBtn.classList.remove('text-gray-600');
                favoriteText.textContent = 'Favorilerden Çıkar';
            } else {
                emptyHeart.classList.remove('hidden');
                fullHeart.classList.add('hidden');
                favoriteBtn.classList.remove('text-red-500', 'bg-red-50');
                favoriteBtn.classList.add('text-gray-600');
                favoriteText.textContent = 'Favorilere Ekle';
            }
        } catch (e) {
            // Favoriler yüklenemezse buton sessizce boş kalır
            console.warn('Favori durumu kontrol edilemedi:', e);
        }
    }

    async function toggleDetailFavorite() {
        if (!currentProduct) return;
        const productId = currentProduct.id;

        try {
            await apiCall(`Favorites/toggle/${productId}`, { method: 'POST' });

            // Zıplama efekti
            const btn = document.getElementById('favorite-btn');
            btn.classList.add('scale-110');
            setTimeout(() => btn.classList.remove('scale-110'), 200);

            // Güncel durumu backend'den öğren ve arayüzü güncelle
            await checkFavoriteStatus(productId);

            const isFavNow = document.getElementById('heart-full') &&
                             !document.getElementById('heart-full').classList.contains('hidden');
            showToast(isFavNow ? 'Ürün favorilere eklendi!' : 'Ürün favorilerden çıkarıldı', isFavNow ? 'success' : 'info');

        } catch (error) {
            console.error('Favori toggle hatası:', error);
            showToast(error.message || 'Bir hata oluştu', 'error');
        }
    }

    async function addToCartFromDetail() {
        console.log('addToCartFromDetail called');

        // URL'den product ID'yi al
        const urlProductId = <?php echo json_encode($product_id); ?>;
        const productId = parseInt(urlProductId);

        console.log('Using URL Product ID:', productId);

        if (!productId || isNaN(productId)) {
            console.error('Invalid product ID from URL:', urlProductId);
            showToast('Ürün ID hatası', 'error');
            return;
        }

        // Quantity'yi al
        const quantityInput = document.getElementById('quantity');
        const qty = parseInt(quantityInput.value) || 1;

        console.log('Adding to cart:', { product_id: productId, quantity: qty });

        try {
            // Sistemin kendi güvenli API çağrısını kullanıyoruz
            const data = await apiCall('cart/items', {
                method: 'POST',
                body: JSON.stringify({
                    productId: productId,
                    quantity: qty
                })
            });

            console.log('Cart API response:', data);

            // API çağrısı başarılıysa buraya düşer
            showToast('Ürün sepete eklendi!', 'success');
            updateCartCount();

        }
        catch (error) {
            console.error('Cart error:', error);
            showToast(error.message || 'Sepete eklenirken hata oluştu', 'error');
        }
    }


</script>