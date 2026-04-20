<?php
// Giriş kontrolü
if (!$current_user) {
    echo '<script>window.location.href = "/login?redirect=/checkout";</script>';
    exit;
}
?>
<div class="min-h-screen bg-gray-50 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8 pl-1">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-2">Güvenli Ödeme</h1>
            <p class="text-gray-500 font-medium">Siparişinizi tamamlamak için son adım</p>
        </div>

        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            <!-- Left Column: Forms -->
            <div class="lg:col-span-12 xl:col-span-8 space-y-6">
                <!-- Address Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center mb-5">
                            <div class="bg-blue-50 p-2.5 rounded-xl border border-blue-100">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h3 class="ml-4 text-xl font-bold text-gray-900">Teslimat Adresi</h3>
                        </div>
                        <div class="sm:pl-[3.25rem]">
                            <label for="shipping-address" class="block text-sm font-medium text-gray-700 mb-2">Lütfen kargonun gönderileceği tam adresi girin</label>
                            <textarea id="shipping-address" name="shipping_address" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:bg-white focus:border-transparent transition-all resize-none shadow-inner" placeholder="Mahalle, Sokak, Bina No, Daire, İlçe/İl..." required></textarea>
                            <p class="mt-3 text-sm text-gray-500 flex items-start sm:items-center">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400 mt-0.5 sm:mt-0 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Not: Fatura adresi olarak da bu adres kullanılacaktır.</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Payment Method Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center justify-between mb-5 flex-wrap gap-4">
                            <div class="flex items-center">
                                <div class="bg-green-50 p-2.5 rounded-xl border border-green-100">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <h3 class="ml-4 text-xl font-bold text-gray-900">Ödeme Yöntemi</h3>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                Havale / EFT
                            </span>
                        </div>
                        
                        <div class="sm:pl-[3.25rem]">
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 shadow-sm relative overflow-hidden">
                                <!-- decorative absolute shape -->
                                <div class="absolute -right-6 -top-6 w-24 h-24 bg-gray-100 rounded-full opacity-50 pointer-events-none"></div>

                                <h5 class="font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                                    Banka Bilgileri
                                </h5>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-5 gap-x-6 relative z-10">
                                    <div>
                                        <p class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-1">Banka</p>
                                        <p class="font-medium text-gray-900">Türkiye İş Bankası</p>
                                    </div>
                                    <div>
                                        <p class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-1">Hesap Sahibi</p>
                                        <p class="font-medium text-gray-900">EsnappGO Teknoloji A.Ş.</p>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <p class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-1">IBAN</p>
                                        <div class="flex items-center justify-between bg-white px-4 py-2.5 border border-gray-200 rounded-lg text-gray-800 font-mono text-sm sm:text-base shadow-inner">
                                            <span class="truncate pr-2">TR12 0006 4000 0011 2345 6789 01</span>
                                            <button type="button" onclick="navigator.clipboard.writeText('TR120006400000112345678901'); showToast('IBAN kopyalandı','success')" class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-1.5 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 flex-shrink-0" title="Kopyala">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <p class="text-xs uppercase tracking-wide font-semibold text-gray-500 mb-1">Açıklama <span class="bg-yellow-100 text-yellow-800 px-1.5 py-0.5 rounded text-[10px] ml-1 font-bold">ÖNEMLİ</span></p>
                                        <div class="bg-yellow-50 border border-yellow-200 px-4 py-2.5 rounded-lg shadow-inner flex items-center justify-between">
                                            <span id="payment-description" class="font-bold text-yellow-900 tracking-wide text-sm sm:text-base">Sipariş #-</span>
                                            <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('payment-description').textContent); showToast('Sipariş numarası kopyalandı','success')" class="text-yellow-700 hover:text-yellow-900 hover:bg-yellow-100 p-1.5 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-yellow-500 flex-shrink-0" title="Kopyala">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            </button>
                                        </div>
                                        <p class="text-xs text-yellow-700 mt-2 font-medium">Lütfen havale/EFT yaparken açıklama kısmına sadece bu sipariş numarasını yazınız.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Receipt Upload Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center mb-5">
                            <div class="bg-purple-50 p-2.5 rounded-xl border border-purple-100">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                            </div>
                            <h3 class="ml-4 text-xl font-bold text-gray-900">Ödeme Kanıtı</h3>
                        </div>
                        
                        <div class="sm:pl-[3.25rem]">
                            <form id="receipt-form" class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Havale/EFT Dekontu <span class="text-red-500">*</span></label>
                                    <div class="relative group border-2 border-dashed border-gray-300 rounded-xl hover:border-purple-400 hover:bg-purple-50/50 transition-all p-6 sm:p-8 text-center cursor-pointer bg-gray-50/50" onclick="document.getElementById('receipt-file').click()">
                                        <input type="file" id="receipt-file" accept="image/*,.pdf" class="hidden" onchange="handleReceiptUpload(event)">
                                        
                                        <div id="upload-placeholder">
                                            <div class="w-14 h-14 bg-white rounded-full shadow-sm flex items-center justify-center mx-auto mb-4 text-purple-500 group-hover:scale-110 group-hover:text-purple-600 transition-all duration-300">
                                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                            </div>
                                            <p class="text-base text-gray-700 font-semibold mb-1">Dekont dosyasını buraya sürükleyin veya tıklayın</p>
                                            <p class="text-sm text-gray-500">PNG, JPG, PDF - Maksimum 5MB</p>
                                        </div>

                                        <!-- Receipt Preview -->
                                        <div id="receipt-preview" class="hidden animate-fade-in-up">
                                            <div class="flex items-center justify-center bg-white p-4 rounded-xl border border-green-200 shadow-sm max-w-sm mx-auto">
                                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center flex-shrink-0 mr-4 shadow-inner">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </div>
                                                <div class="text-left overflow-hidden">
                                                    <p class="text-sm font-bold text-gray-900 truncate" id="receipt-filename">Belge.pdf</p>
                                                    <p class="text-xs font-medium text-green-600 mt-0.5">Başarıyla eklendi. Değiştirmek için tıklayın.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="transfer-note" class="block text-sm font-medium text-gray-700 mb-2">Havale Notu <span class="text-gray-400 font-normal">(Opsiyonel)</span></label>
                                    <textarea id="transfer-note" name="transfer_note" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:bg-white focus:border-transparent transition-all resize-y shadow-inner" placeholder="Siparişle veya ödemeyle ilgili eklemek istediğiniz notlar..."></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary (Sticky) -->
            <div class="lg:col-span-12 xl:col-span-4 mt-8 xl:mt-0">
                <div class="bg-white rounded-2xl shadow border border-gray-200 p-6 sm:p-8 xl:sticky xl:top-24">
                    <!-- Order Summary Header -->
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center border-b border-gray-100 pb-4">
                        <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Sipariş Özeti
                    </h3>

                    <!-- Order Summary Content (Dynamic) -->
                    <div id="order-summary" class="space-y-4">
                        <div class="animate-pulse flex flex-col space-y-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gray-200 rounded-lg"></div>
                                <div class="flex-1 space-y-2 py-1">
                                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                    <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                                </div>
                            </div>
                            <div class="h-10 bg-gray-100 rounded w-full mt-4"></div>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col space-y-3 pt-6 border-t border-gray-100">
                        <button onclick="completeOrder()" id="complete-btn" class="w-full justify-center flex items-center px-6 py-4 border border-transparent rounded-xl shadow-md text-base font-bold text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 disabled:opacity-50 disabled:cursor-not-allowed transform transition-all active:scale-[0.98]" disabled>
                            Siparişi Tamamla
                            <svg class="ml-2 -mr-1 w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                        <a href="/cart" class="w-full justify-center flex items-center px-6 py-3.5 border-2 border-gray-200 rounded-xl text-base font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all">
                            <svg class="mr-2 -ml-1 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Sepete Dön
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedReceipt = null;
    let orderData = null;

    document.addEventListener('DOMContentLoaded', function () {
        loadOrderSummary();
    });

    async function loadOrderSummary() {
        try {
            const response = await apiCall('cart');
            const rawItems = response.items || [];
            // cart.php'deki mapping mantığını burada da uygula
            const cartItems = rawItems
                // Sadece aktif ürünleri sepette tutup işlemeliyiz
                .filter(item => item.isProductActive !== false && item.IsProductActive !== false)
                .map(item => ({
                    ...item,
                    price: item.unitPrice,
                    title: item.productName,
                    images: item.imageUrls || (item.imageUrl ? [item.imageUrl] : []),
                    student_donation_percentage: Math.round((item.extraSupportRate || 0) * 100)
                }));


            if (cartItems.length === 0) {
                showToast('Sepetiniz boş', 'error');
                window.location.href = '/cart';
                return;
            }

            // Calculate totals
            let subtotal = 0;
            let naturalSupport = 0;  // %10 doğal kazanç
            let extraSupport = 0;    // Ekstra destek

            cartItems.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                naturalSupport += itemTotal * 0.10; // %10 doğal kazanç her zaman eklenir
                extraSupport += (itemTotal * (item.student_donation_percentage || 0)) / 100;
            });

            const donationTotal = naturalSupport + extraSupport;
            const total = subtotal + donationTotal;

            // FIX: Önceden 'ORD-' + Date.now() ile sahte sipariş numarası üretiliyordu.
            // Bu numara hiçbir zaman gerçek sipariş numarasıyla eşleşmiyordu (havale takibi imkansızdı).
            // Şimdi: Gerçek numara sipariş tamamlanınca completeOrder() içinde API'den alınacak.
            document.getElementById('payment-description').textContent = 'Sipariş oluşturulduğunda görünecek';

            // Display order summary
            const container = document.getElementById('order-summary');
            container.innerHTML = `
            <div class="space-y-3">
                ${cartItems.map(item => `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="${item.images?.[0] || ''}" alt="${item.title}" class="w-12 h-12 object-cover rounded-lg" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIGZpbGw9IiNjY2MiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMTIgMmM1LjUxNCAwIDEwIDQuNDg2IDEwIDEwcy00LjQ4NiAxMC0xMCAxMFMyIDEyIDIgMTJTNi40ODYgMiAxMiAyek0xMiA2YTYgNiAwIDEwMCAxMiA2IDYgMCAwMDAtMTJ6Ii8+PC9zdmc+'">
                            <div>
                               <h4 class="text-sm font-medium text-gray-900">${escapeHtml(item.title)}</h4>

                                <p class="text-sm text-gray-500">${item.quantity} adet</p>
                            </div>
                        </div>
                        <span class="font-medium">₺${(item.price * item.quantity).toFixed(2)}</span>
                    </div>
                `).join('')}
            </div>
            
            <div class="border-t border-gray-200 pt-4 mt-4 space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Ara toplam</span>
                    <span>₺${subtotal.toFixed(2)}</span>
                </div>
                
                <!-- Öğrenci Desteği Detayları -->
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-3 border border-purple-100">
                    <h4 class="font-semibold text-purple-800 mb-2 flex items-center text-sm">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                        </svg>
                        Öğrenci Desteği Detayları
                    </h4>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-between text-blue-600">
                            <span>Doğal Kazanç (%10)</span>
                            <span>₺${naturalSupport.toFixed(2)}</span>
                        </div>
                        ${extraSupport > 0 ? `
                            <div class="flex justify-between text-purple-600">
                                <span>Ekstra Destek</span>
                                <span>₺${extraSupport.toFixed(2)}</span>
                            </div>
                        ` : ''}
                        <div class="flex justify-between font-semibold text-purple-700 pt-1 border-t border-purple-200">
                            <span>Toplam Öğrenci Desteği</span>
                            <span>₺${donationTotal.toFixed(2)}</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Kargo</span>
                    <span class="text-green-600">Ücretsiz</span>
                </div>
                <div class="border-t border-gray-200 pt-2">
                    <div class="flex justify-between text-lg font-bold">
                        <span>Toplam</span>
                        <span class="text-purple-600">₺${total.toFixed(2)}</span>
                    </div>
                </div>
            </div>
        `;

            orderData = {
                items: cartItems,
                subtotal: subtotal,
                donation_total: donationTotal,
                total: total
            };

        } catch (error) {
            console.error('Error loading order summary:', error);
            showToast('Sipariş özeti yüklenirken hata oluştu', 'error');
        }
    }

    function handleReceiptUpload(event) {
        const file = event.target.files[0];

        if (!file) return;

        // File size check (5MB)
        if (file.size > 5 * 1024 * 1024) {
            showToast('Dosya boyutu 5MB\'dan büyük olamaz', 'error');
            return;
        }

        // File type check
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
        if (!allowedTypes.includes(file.type)) {
            showToast('Sadece JPG, PNG ve PDF dosyaları kabul edilir', 'error');
            return;
        }

        selectedReceipt = file;

        // FIX: Önceden style.display='block' ile Tailwind 'hidden' class'ıyla çatışıyordu (anti-pattern).
        // Şimdi: Tailwind class'ları tutarlı biçimde kullanılıyor.
        document.getElementById('upload-placeholder').classList.add('hidden');
        document.getElementById('receipt-preview').classList.remove('hidden');
        document.getElementById('receipt-filename').textContent = file.name;

        // Enable complete button
        document.getElementById('complete-btn').disabled = false;

        showToast('Dekont yüklendi', 'success');
    }

   async function completeOrder() {
        // 1. Adres kontrolü (YENİ EKLENDİ)
        const addressInput = document.getElementById('shipping-address').value.trim();
        if (!addressInput) {
            showToast('Lütfen teslimat adresinizi girin', 'error');
            document.getElementById('shipping-address').focus();
            return;
        }

        if (!selectedReceipt) {
            showToast('Lütfen dekont yükleyin', 'error');
            return;
        }

        if (!orderData) {
            showToast('Sipariş verisi bulunamadı', 'error');
            return;
        }

        try {
            showToast('Dekont yükleniyor...', 'info');
            const token = localStorage.getItem('auth_token');

            // 1. Adım: Dekontu yüklüyoruz
            const uploadFormData = new FormData();
            uploadFormData.append('file', selectedReceipt);

            const uploadResponse = await fetch(`${API_BASE}/api/Orders/upload-receipt`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                body: uploadFormData
            });

            if (!uploadResponse.ok) {
                const err = await uploadResponse.json().catch(() => ({}));
                throw new Error('Dekont yüklenemedi: ' + (err.message || 'Bilinmeyen hata'));
            }

            const uploadResult = await uploadResponse.json();
            const receiptUrl = uploadResult.url; 

            showToast('Sipariş oluşturuluyor...', 'info');

            // 2. Adım: Siparişi oluşturuyoruz (ADRES DOLU GİDECEK)
            const orderResponse = await fetch(`${API_BASE}/api/Orders/checkout`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
    paymentMethod: 'bank_transfer',
    receiptUrl: receiptUrl,
    shippingAddress: addressInput,
    billingAddress: addressInput
    // transferNote kaldırıldı — backend'de bu alan yok
})

            });

            if (orderResponse.ok) {
                const resultData = await orderResponse.json().catch(() => ({}));

                // FIX: Gerçek sipariş numarası API'den alınıyor ve ödeme açıklamasına yazılıyor.
                const realOrderNumber = resultData.orderNumber || resultData.OrderNumber || resultData.id;
                if (realOrderNumber) {
                    document.getElementById('payment-description').textContent = `Sipariş #${realOrderNumber}`;
                    showToast(`Sipariş #${realOrderNumber} başarıyla oluşturuldu!`, 'success');
                } else {
                    showToast('Sipariş başarıyla oluşturuldu!', 'success');
                }

                const orderNum = realOrderNumber || '';
                setTimeout(() => {
                    window.location.href = `/orders?success=${orderNum}`;
                }, 2000);
            } else {
                const err = await orderResponse.json().catch(() => ({}));
                throw new Error('Sipariş oluşturulamadı: ' + (err.message || 'Bilinmeyen hata'));
            }

        } catch (error) {
            console.error("Checkout Error:", error);
            
            // İşlem tamamlandığında veya hata alındığında eski bildirimleri (Dekont yükleniyor vs) ekrandan temizle
            const toastContainer = document.getElementById('toast-container');
            if (toastContainer) toastContainer.innerHTML = '';
            
            let displayMsg = error.message;
            let isStockError = displayMsg.includes('Stok yetersiz') || displayMsg.includes('Lütfen sepetinizi güncelleyin:');
            
            if (isStockError) {
                // Backend'den gelen karmaşık mesajı parçala ve daha UX dostu bir HTML listesine dönüştür
                const splitIndex = displayMsg.indexOf('Lütfen sepetinizi güncelleyin:');
                if (splitIndex !== -1) {
                    const header = displayMsg.substring(0, splitIndex + 30);
                    const productsPart = displayMsg.substring(splitIndex + 30).trim();
                    const products = productsPart.split(';');
                    
                    let htmlList = `<ul class="mt-4 text-left space-y-2 bg-red-50 p-4 rounded-xl border border-red-100">`;
                    products.forEach(p => {
                        if (p.trim()) {
                            let text = escapeHtml(p.trim());
                            // Parantez kısmını ayırıp HTML ile stillendir
                            text = text.replace('(', '<br> <span class="text-xs font-normal text-red-600 opacity-80">(');
                            if (text.includes('<span')) {
                                text += '</span>';
                            }
                            
                            htmlList += `
                            <li class="text-sm font-medium text-red-800 flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>${text}</span>
                            </li>`;
                        }
                    });
                    htmlList += `</ul>`;
                    displayMsg = `<div class="text-gray-800 font-semibold mb-2">${header}</div>${htmlList}`;
                }
                
                // Uyarıyı şık modal ile göster
                openCustomModal(displayMsg, 'alert').then(() => {
                    // Kullanıcı modalı kapattığında sepete geri yönlendir
                    window.location.href = '/cart';
                });
            } else {
                // Diğer tip hatalar için standart veya modal gösterim
                openCustomModal(`<div class="text-red-600 font-semibold mb-2">Hata Oluştu</div><p class="text-gray-600 text-sm">${escapeHtml(displayMsg)}</p>`, 'alert');
            }
        }
    }
    function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text || '';
    return div.innerHTML;
}

</script>
</div> </div>