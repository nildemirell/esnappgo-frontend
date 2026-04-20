<?php
// Giriş kontrolü
if (!$current_user) {
    header('Location: /login?redirect=/cart');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="/products" class="text-blue-600 hover:text-blue-700 mr-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Sepetim</h1>
            </div>
            <p class="text-gray-600">Alışveriş sepetinizdeki ürünler ve öğrenci desteği ayarları</p>
        </div>

        <div class="lg:grid lg:grid-cols-12 lg:gap-x-8 lg:items-start">
            <!-- Cart Items -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-900">Sepetinizdeki Ürünler</h2>
                        <button id="clear-cart-btn" style="display: none;" onclick="clearCart()"
                            class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center">

                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Sepeti Boşalt
                        </button>
                    </div>


                    <div id="cart-items-container" class="divide-y divide-gray-100">
                        <!-- Loading skeleton -->
                        <div id="loading-skeleton" class="animate-pulse p-6">
                            <div class="flex items-center space-x-4">
                                <div class="bg-gray-200 h-20 w-20 rounded-lg"></div>
                                <div class="flex-1">
                                    <div class="h-4 bg-gray-200 rounded mb-2"></div>
                                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty Cart -->
                <div id="empty-cart" class="text-center py-16" style="display: none;">
                    <div class="bg-white rounded-2xl shadow-sm p-12">
                        <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-3">Sepetiniz Boş</h3>
                        <p class="text-gray-500 mb-8 text-lg">Harika ürünlerle sepetinizi doldurun ve öğrencileri
                            destekleyin!</p>
                        <a href="/products"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-full hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Ürünleri İncele
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-4 mt-8 lg:mt-0">
                <div id="order-summary" class="bg-white rounded-2xl shadow-sm border border-gray-100 sticky top-8"
                    style="display: none;">
                    <!-- Summary Header -->
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-900">Sipariş Özeti</h2>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Price Breakdown -->
                        <div class="space-y-3">
                            <div class="flex justify-between text-gray-600">
                                <span>Ara Toplam</span>
                                <span id="subtotal" class="font-medium">₺0.00</span>
                            </div>

                            <div class="flex justify-between text-gray-600">
                                <span>Kargo</span>
                                <span class="text-green-600 font-medium">Ücretsiz</span>
                            </div>
                        </div>

                        <!-- Student Support Details -->
                        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-4 border border-blue-100">
                            <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                                Öğrenci Desteği Detayları
                            </h3>

                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Doğal Kazanç (%10)</span>
                                    <span id="natural-support" class="font-medium text-blue-600">₺0.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Ekstra Destek</span>
                                    <span id="extra-support" class="font-medium text-purple-600">₺0.00</span>
                                </div>
                                <div class="border-t border-blue-200 pt-2 mt-2">
                                    <div class="flex justify-between font-semibold">
                                        <span class="text-gray-900">Toplam Öğrenci Desteği</span>
                                        <span id="total-student-support" class="text-blue-600">₺0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Final Total -->
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between text-xl font-bold">
                                <span class="text-gray-900">Toplam</span>
                                <span id="final-total" class="text-blue-600">₺0.00</span>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <button onclick="proceedToCheckout()" id="checkout-btn"
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-xl font-bold text-lg hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m0 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V9a2 2 0 00-2-2H9a2 2 0 00-2 2v10m8-12V7a4 4 0 00-8 0v2m8 6V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2h8a2 2 0 002-2z">
                                </path>
                            </svg>
                            Ödemeye Geç
                        </button>

                        <div class="text-center">
                            <a href="/products" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                ← Alışverişe devam et
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let cartItems = [];
    let subtotalAmount = 0;

    document.addEventListener('DOMContentLoaded', function () {
        loadCartItems();
    });

    async function loadCartItems() {
        try {
            // Loading skeleton'ı göster
            document.getElementById('loading-skeleton').style.display = 'block';
            document.getElementById('empty-cart').style.display = 'none';
            document.getElementById('order-summary').style.display = 'none';

            const response = await apiCall('cart');
            const rawItems = response.items || [];

            // Backend artık CartItemDto içinde imageUrls döndürüyor — ayrı ürün listesi çekmeye gerek yok!

            // Backendden gelen isimleri (.NET), sizin frontend izinlerinize (PHP) otomatik çeviriyoruz
            cartItems = rawItems.map(item => ({
    ...item,
    id: item.id || item.Id,
    price: item.unitPrice || item.price || 0,
    title: item.productName || item.name || 'Ürün',
    shopName: item.MerchantShopName || item.merchantShopName || item.shopName || item.merchantName || item.shop_name || 'Bilinmeyen Mağaza',
    isProductActive: item.IsProductActive !== undefined ? item.IsProductActive : (item.isProductActive !== undefined ? item.isProductActive : true),
    images: item.imageUrls ? item.imageUrls : (item.imageUrl ? [item.imageUrl] : []),
    student_donation_percentage: Math.round((item.extraSupportRate || 0) * 100)
}));



            console.log('Cart items loaded:', cartItems);

            // Loading skeleton'ı gizle
            document.getElementById('loading-skeleton').style.display = 'none';

            if (cartItems.length === 0) {
                document.getElementById('empty-cart').style.display = 'block';
                document.getElementById('order-summary').style.display = 'none';
                document.getElementById('clear-cart-btn').style.display = 'none'; // SEPET BOŞSA GİZLE
                document.getElementById('cart-items-container').innerHTML = '';
            } else {
                document.getElementById('empty-cart').style.display = 'none';
                document.getElementById('order-summary').style.display = 'block';
                document.getElementById('clear-cart-btn').style.display = 'flex'; // SEPET DOLUYSA GÖSTER
                displayCartItems();
                updateOrderSummary();
            }


        } catch (error) {
            console.error('Error loading cart:', error);
            // Loading skeleton'ı gizle
            document.getElementById('loading-skeleton').style.display = 'none';
            // Boş sepet mesajını göster
            document.getElementById('empty-cart').style.display = 'block';
            document.getElementById('order-summary').style.display = 'none';
            document.getElementById('cart-items-container').innerHTML = '';
            showToast('Sepet yüklenirken hata oluştu', 'error');
        }
    }

    function displayCartItems() {
        const container = document.getElementById('cart-items-container');

        if (!cartItems || cartItems.length === 0) {
            container.innerHTML = '';
            document.getElementById('empty-cart').style.display = 'block';
            document.getElementById('order-summary').style.display = 'none';
            return;
        }

        container.innerHTML = cartItems.map(item => createCartItemHTML(item)).join('');
        document.getElementById('empty-cart').style.display = 'none';
        document.getElementById('order-summary').style.display = 'block';
    }

    function createCartItemHTML(item) {
        const itemTotal = item.price * item.quantity;
        const naturalSupport = itemTotal * 0.10; // %10 doğal kazanç
        const extraSupport = itemTotal * (item.student_donation_percentage || 0) / 100;
        const totalItemSupport = naturalSupport + extraSupport;

        // Resim yolunu düzelt
        let imageUrl = '';
        if (item.images && item.images.length > 0) {
            imageUrl = item.images[0];
            if (!imageUrl.startsWith('/') && !imageUrl.startsWith('http')) {
                imageUrl = '/' + imageUrl;
            }
        } else {
            imageUrl = '/media/68a658361732a_1755732022.jpg';
        }

        return `
        <div class="p-6" data-item-id="${item.id}">
            <div class="flex items-start space-x-4">
                <!-- Product Image -->
                <div class="flex-shrink-0">
                    <img 
                        src="${imageUrl}" 
                        alt="${escapeHtml(item.title)}"
                        class="w-20 h-20 object-cover rounded-lg border border-gray-200"
                        onerror="this.src='/media/68a658361732a_1755732022.jpg'"
                    />
                </div>
                
                <!-- Product Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 line-clamp-1">
                            ${escapeHtml(item.title)}
                        </h3>
                        <button 
                            onclick="removeFromCart(${item.id})"
                            class="text-red-500 hover:text-red-700 p-1 rounded-lg hover:bg-red-50 transition-colors"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <p class="text-sm text-gray-500 mb-3">
                        ${escapeHtml(item.shopName || item.merchantName || item.shop_name || 'Mağaza')}

                    </p>
                    
                    <!-- Price and Quantity -->
                    <div class="flex items-center justify-between mb-4">
                        ${!item.isProductActive ? `
                            <div class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Bu ürün artık satılmıyor veya askıya alınmış
                            </div>
                        ` : `
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button 
                                        onclick="updateQuantity(${item.id}, ${item.quantity - 1})"
                                        class="p-2 text-gray-600 hover:text-gray-800 disabled:opacity-50 rounded-l-lg hover:bg-gray-50"
                                        ${item.quantity <= 1 ? 'disabled' : ''}
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <span class="px-4 py-2 text-sm font-semibold bg-gray-50 min-w-[3rem] text-center">${item.quantity}</span>
                                    <button 
                                        onclick="updateQuantity(${item.id}, ${item.quantity + 1})"
                                        class="p-2 text-gray-600 hover:text-gray-800 disabled:opacity-50 rounded-r-lg hover:bg-gray-50"
                                        ${item.quantity >= (item.stock !== undefined && item.stock !== null ? item.stock : 99) ? 'disabled' : ''}
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        `}
                        
                        <div class="text-right">
                            <div class="text-xl font-bold text-gray-900 ${!item.isProductActive ? 'line-through text-gray-400' : ''}">₺${itemTotal.toFixed(2)}</div>
                            <div class="text-sm text-gray-500">₺${item.price} × ${item.quantity}</div>
                        </div>
                    </div>
                    
                    <!-- Student Support Section for Each Item -->
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-4 border border-purple-100">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-purple-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold text-gray-900">Öğrenci Desteği</span>
                        </div>
                        
                        <!-- Support Details -->
                        <div class="space-y-2 text-sm mb-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Doğal Kazanç (%10):</span>
                                <span class="font-medium text-blue-600">₺${naturalSupport.toFixed(2)}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ekstra Destek (${item.student_donation_percentage || 0}%):</span>
                                <span class="font-medium text-purple-600">₺${extraSupport.toFixed(2)}</span>
                            </div>
                            <div class="border-t border-purple-200 pt-2">
                                <div class="flex justify-between font-semibold">
                                    <span class="text-gray-900">Toplam Öğrenci Desteği:</span>
                                    <span class="text-purple-600">₺${totalItemSupport.toFixed(2)}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Support Slider (Always visible) -->
                        <div id="support-slider-${item.id}" class="pt-4 border-t border-purple-200">
                            <div class="mb-3">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-700">Ekstra Destek Oranı</span>
                                    <span class="text-sm font-bold text-purple-600">%<span id="percentage-${item.id}">${item.student_donation_percentage || 0}</span></span>
                                </div>
                                
                                <input
                                    type="range"
                                    id="slider-${item.id}"
                                    min="0"
                                    max="50"
                                    step="5"
                                    value="${item.student_donation_percentage || 0}"
                                    class="w-full h-3 bg-purple-200 rounded-lg appearance-none cursor-pointer slider"
                                    oninput="updateSliderDisplay(${item.id}, this.value)"
                                />
                                
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>%0</span>
                                    <span>%25</span>
                                    <span>%50</span>
                                </div>
                            </div>
                            
                            <!-- Manual Input -->
                            <div class="mb-3">
                                <label class="text-sm text-gray-700 mb-1 block">Manuel Giriş:</label>
                                <div class="flex items-center space-x-2">
                                    <input 
                                        type="number" 
                                        id="manual-${item.id}"
                                        min="0" 
                                        max="50"
                                        step="5"
                                        value="${item.student_donation_percentage || 0}"
                                        class="w-20 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-purple-500 focus:ring-0"
                                    />
                                    <span class="text-sm text-gray-600">%</span>
                                    <button 
                                        onclick="applyManualSupport(${item.id})"
                                        class="px-3 py-2 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700 transition-colors"
                                    >
                                        Uygula
                                    </button>
                                </div>
                                
                                <!-- Slider Apply Button -->
                                <div class="mt-3">
                                    <button 
                                        onclick="applySliderSupport(${item.id})"
                                        class="w-full px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition-all"
                                        id="apply-slider-${item.id}"
                                    >
                                        Slider Değerini Uygula (%<span id="slider-preview-${item.id}">0</span>)
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Quick Options -->
                            <div class="flex flex-wrap gap-2">
                                <span class="text-xs text-gray-600 self-center">Hızlı:</span>
                                <button onclick="updateItemSupport(${item.id}, 0)" class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors">%0</button>
                                <button onclick="updateItemSupport(${item.id}, 5)" class="px-2 py-1 text-xs bg-purple-100 text-purple-700 rounded hover:bg-purple-200 transition-colors">%5</button>
                                <button onclick="updateItemSupport(${item.id}, 10)" class="px-2 py-1 text-xs bg-purple-100 text-purple-700 rounded hover:bg-purple-200 transition-colors">%10</button>
                                <button onclick="updateItemSupport(${item.id}, 20)" class="px-2 py-1 text-xs bg-purple-100 text-purple-700 rounded hover:bg-purple-200 transition-colors">%20</button>
                                <button onclick="updateItemSupport(${item.id}, 30)" class="px-2 py-1 text-xs bg-purple-100 text-purple-700 rounded hover:bg-purple-200 transition-colors">%30</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    }

    // Slider artık her zaman açık, toggle fonksiyonuna gerek yok

    // Sadece slider görünümünü güncelle, uygulamaz
    function updateSliderDisplay(itemId, percentage) {
        percentage = Math.max(0, Math.min(50, parseInt(percentage) || 0));

        // Sadece preview'ı güncelle
        document.getElementById(`slider-preview-${itemId}`).textContent = percentage;

        // Manuel input'u da güncelle
        document.getElementById(`manual-${itemId}`).value = percentage;
    }

    // Slider değerini uygula
    function applySliderSupport(itemId) {
        const sliderValue = document.getElementById(`slider-${itemId}`).value;
        updateItemSupport(itemId, sliderValue);
    }

    // Manuel input'u uygula  
    function applyManualSupport(itemId) {
        const manualValue = document.getElementById(`manual-${itemId}`).value;
        updateItemSupport(itemId, manualValue);
    }

    // Gerçek güncelleme fonksiyonu
    async function updateItemSupport(itemId, percentage) {
        const item = cartItems.find(i => i.id === itemId);
        if (!item) return;

        // FIX: Önceden Math.min(100, ...) ile slider maxından (50) farklı bir değer kabul ediliyordu.
        // Şimdi: Slider ile tutarlı — maksimum %50 eşleşti.
        percentage = Math.max(0, Math.min(50, parseInt(percentage) || 0));

        try {
            // Sunucuya kaydet (.NET backend formatına tamamen uygun)
            await apiCall(`cart/items/${itemId}`, {
                method: 'PUT',

                body: JSON.stringify({
                    quantity: item.quantity,
                    extraSupportRate: (percentage / 100) // Yüzdeyi 0.25 gibi ondalığı çeviriyoruz
                })
            });


            // Yerel state'i güncelle
            item.student_donation_percentage = percentage;

            // Tüm UI elementlerini güncelle
            document.getElementById(`percentage-${itemId}`).textContent = percentage;
            document.getElementById(`slider-${itemId}`).value = Math.min(percentage, 50);
            document.getElementById(`manual-${itemId}`).value = percentage;
            document.getElementById(`slider-preview-${itemId}`).textContent = Math.min(percentage, 50);

            // Refresh display
            displayCartItems();
            updateOrderSummary();

            showToast(`Öğrenci desteği %${percentage} olarak güncellendi`, 'success');
        } catch (error) {
            console.error('Error updating support:', error);
            showToast('Öğrenci desteği güncellenirken hata oluştu', 'error');
        }
    }



    function updateOrderSummary() {
        // Calculate subtotal
        subtotalAmount = cartItems.reduce((total, item) => item.isProductActive ? total + (item.price * item.quantity) : total, 0);

        // Calculate student support
        let totalNaturalSupport = 0;
        let totalExtraSupport = 0;

        cartItems.forEach(item => {
            if (!item.isProductActive) return; // Pasif ürün destek hesaplamasina katilmaz
            const itemTotal = item.price * item.quantity;
            totalNaturalSupport += itemTotal * 0.10; // %10 doğal
            totalExtraSupport += itemTotal * (item.student_donation_percentage || 0) / 100;
        });

        const totalStudentSupport = totalNaturalSupport + totalExtraSupport;
        const finalTotal = subtotalAmount + totalStudentSupport;

        // Update UI
        document.getElementById('subtotal').textContent = `₺${subtotalAmount.toFixed(2)}`;
        document.getElementById('natural-support').textContent = `₺${totalNaturalSupport.toFixed(2)}`;
        document.getElementById('extra-support').textContent = `₺${totalExtraSupport.toFixed(2)}`;
        document.getElementById('total-student-support').textContent = `₺${totalStudentSupport.toFixed(2)}`;
        document.getElementById('final-total').textContent = `₺${finalTotal.toFixed(2)}`;

        // Ödemeye Geç butonunu kontrol et
        const checkoutBtn = document.querySelector('button[onclick="proceedToCheckout()"]');
        if (checkoutBtn) {
            const hasActiveItems = cartItems.some(item => item.isProductActive);
            checkoutBtn.disabled = !hasActiveItems;
            if (!hasActiveItems) {
                checkoutBtn.classList.remove('btn-primary');
                checkoutBtn.classList.add('bg-gray-400', 'cursor-not-allowed', 'text-white');
            } else {
                checkoutBtn.classList.add('btn-primary');
                checkoutBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            }
        }
    }

    let isQuantityUpdating = {};

    async function updateQuantity(itemId, newQuantity) {
        if (isQuantityUpdating[itemId]) return; // Devam eden bir işlem varsa blokla
        
        if (newQuantity <= 0) {
            await removeFromCart(itemId);
            return;
        }

        isQuantityUpdating[itemId] = true; // Kilitle
        
        // Optimistic UI Update (Kullanıcı beklemez)
        const itemToUpdate = cartItems.find(i => i.id === itemId);
        const oldQuantity = itemToUpdate.quantity;
        itemToUpdate.quantity = newQuantity;
        displayCartItems();
        updateOrderSummary();

        try {
            // Sunucuya kaydet (.NET backend formatına tamamen uygun)
            await apiCall(`cart/items/${itemId}`, {
                method: 'PUT',
                body: JSON.stringify({
                    quantity: newQuantity,
                    extraSupportRate: (itemToUpdate.student_donation_percentage || 0) / 100
                })
            });

            showToast('Miktar güncellendi', 'success');
            updateCartCount();

        } catch (error) {
            // Hata olursa UI'ı eski haline çevir
            itemToUpdate.quantity = oldQuantity;
            displayCartItems();
            updateOrderSummary();
            showToast('Miktar güncellenirken hata oluştu', 'error');
        } finally {
            isQuantityUpdating[itemId] = false; // Kilidi kaldır
        }
    }

    async function removeFromCart(itemId) {
        try {
            await apiCall(`cart/items/${itemId}`, { method: 'DELETE' });

            // Remove from local state

            cartItems = cartItems.filter(item => item.id !== itemId);

            if (cartItems.length === 0) {
                document.getElementById('empty-cart').style.display = 'block';
                document.getElementById('order-summary').style.display = 'none';
                document.getElementById('clear-cart-btn').style.display = 'none'; // BUTONU GİZLE
                document.getElementById('cart-items-container').innerHTML = '';
            } else {

                displayCartItems();
                updateOrderSummary();
            }

            updateCartCount();
            showToast('Ürün sepetten kaldırıldı', 'success');

        } catch (error) {
            showToast(error.message, 'error');
        }
    }
    async function clearCart() {
        if (!await openCustomModal('Sepetinizdeki tüm ürünleri silmek istediğinize emin misiniz?')) return;

        try {
            // .NET Backend'in sepeti temizleme adresine ana DELETE isteğini atıyoruz
            await apiCall('cart', { method: 'DELETE' });

            // Arayüzü başarılı bir şekilde boş gösteriyoruz
            cartItems = [];
            document.getElementById('empty-cart').style.display = 'block';
            document.getElementById('order-summary').style.display = 'none';
            document.getElementById('clear-cart-btn').style.display = 'none'; // BUTONU GİZLE
            document.getElementById('cart-items-container').innerHTML = '';


            updateCartCount(); // Üst menüdeki sayacı "0" yapar
            showToast('Sepet başarıyla boşaltıldı', 'success');
        } catch (error) {
            showToast('Sepet boşaltılırken hata oluştu', 'error');
        }
    }


    async function proceedToCheckout() {
        const activeItems = cartItems.filter(item => item.isProductActive);

        // ÖZEL KORUMA: Kullanıcının sepetindeki ürün mevcut stoktan büyükse ödemeye geçişi engelle
        const outOfStockItems = activeItems.filter(item => {
            const currentStock = (item.stock !== undefined && item.stock !== null) ? item.stock : 99;
            return item.quantity > currentStock;
        });

        if (outOfStockItems.length > 0) {
            showToast('Sepetinizdeki bazı ürünlerin stoğu yetersiz. Lütfen miktarı güncelleyin.', 'error');
            return;
        }

        if (activeItems.length === 0) {
            showToast('Sepetinizde ödemeye geçebileceğiniz aktif ürün bulunmamaktadır.', 'error');
            return;
        }

        // Redirect to checkout with support data
        const checkoutData = {
            items: activeItems.map(item => ({
                id: item.id,
                product_id: item.productId,   // backend camelCase ile geliyor
                quantity: item.quantity,
                student_donation_percentage: item.student_donation_percentage || 0
            }))
        };

        // Store checkout data in sessionStorage
        sessionStorage.setItem('checkoutData', JSON.stringify(checkoutData));

        window.location.href = '/checkout';
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text || '';
        return div.innerHTML;
    }


</script>

<style>
    /* Custom range slider styles */
    .slider::-webkit-slider-thumb {
        appearance: none;
        height: 24px;
        width: 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        cursor: pointer;
        border: 3px solid #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        transition: all 0.2s ease;
    }

    .slider::-webkit-slider-thumb:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .slider::-moz-range-thumb {
        height: 24px;
        width: 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        cursor: pointer;
        border: 3px solid #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        transition: all 0.2s ease;
    }

    .slider::-moz-range-thumb:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    /* Slider track styles */
    .slider::-webkit-slider-track {
        height: 8px;
        border-radius: 4px;
        background: linear-gradient(90deg, #e0e7ff 0%, #c7d2fe 50%, #ddd6fe 100%);
    }

    .slider::-moz-range-track {
        height: 8px;
        border-radius: 4px;
        background: linear-gradient(90deg, #e0e7ff 0%, #c7d2fe 50%, #ddd6fe 100%);
    }
</style>