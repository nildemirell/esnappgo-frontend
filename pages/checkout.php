<?php
// Giriş kontrolü
if (!$current_user) {
    echo '<script>window.location.href = "/login?redirect=/checkout";</script>';
    exit;
}
?>
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Ödeme</h1>
            <p class="text-gray-600">Siparişinizi tamamlayın</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Teslimat Adresi</h3>
            <div>
                <label for="shipping-address" class="block text-sm font-medium text-gray-700 mb-2">
                    Lütfen kargonun gönderileceği tam adresi girin
                </label>
                <textarea id="shipping-address" name="shipping_address" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Mahalle, Sokak, Bina No, Daire, İlçe/İl..." required></textarea>
                <p class="mt-2 text-xs text-gray-500">Not: Fatura adresi olarak da bu adres kullanılacaktır.</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Ödeme Yöntemi</h3>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0"></div>
                        <svg class="w-6 h-6 text-blue-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-medium text-blue-900 mb-3">Havale/EFT ile Ödeme</h4>
                        <p class="text-sm text-blue-700 mb-4">
                            Şu anda sadece havale/EFT ile ödeme kabul ediyoruz. Diğer ödeme yöntemleri yakında
                            eklenecektir.
                        </p>

                        <div class="bg-white rounded-lg p-4 border border-blue-200">
                            <h5 class="font-medium text-gray-900 mb-3">Banka Bilgileri</h5>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Banka:</span>
                                    <span class="font-medium">Türkiye İş Bankası</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Hesap Sahibi:</span>
                                    <span class="font-medium">EsnappGO Teknoloji A.Ş.</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">IBAN:</span>
                                    <span class="font-medium font-mono">TR12 0006 4000 0011 2345 6789 01</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Açıklama:</span>
                                    <span class="font-medium" id="payment-description">Sipariş #-</span>
                                </div>
                            </div>

                            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                                <p class="text-sm text-yellow-800">
                                    <strong>Önemli:</strong> Havale/EFT yaparken açıklama kısmına mutlaka sipariş
                                    numaranızı yazın.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Receipt -->
        <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Dekont Yükleme</h3>

            <form id="receipt-form" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Havale/EFT Dekontu
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                        <input type="file" id="receipt-file" accept="image/*,.pdf" class="hidden"
                            onchange="handleReceiptUpload(event)">
                        <div id="upload-area" onclick="document.getElementById('receipt-file').click()"
                            class="cursor-pointer">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                            <p class="text-gray-600 mb-2">Dekont dosyasını buraya sürükleyin veya tıklayın</p>
                            <p class="text-xs text-gray-500">PNG, JPG, JPEG, PDF - Maksimum 5MB</p>
                        </div>

                        <!-- Receipt Preview -->
                        <div id="receipt-preview" class="mt-4" style="display: none;">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm text-green-700" id="receipt-filename">Dekont yüklendi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="transfer-note" class="block text-sm font-medium text-gray-700 mb-2">
                        Havale Notu (Opsiyonel)
                    </label>
                    <textarea id="transfer-note" name="transfer_note" rows="3" class="w-full"
                        placeholder="Havale ile ilgili ek bilgiler..."></textarea>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-sm p-8">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Sipariş Özeti</h3>

            <div id="order-summary" class="space-y-4">
                <!-- Loading -->
                <div class="animate-pulse">
                    <div class="h-4 bg-gray-200 rounded mb-2"></div>
                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                </div>
            </div>

            <div class="mt-8 flex justify-between">
                <a href="/cart" class="btn btn-outline">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Sepete Dön
                </a>

                <button onclick="completeOrder()" id="complete-btn" class="btn btn-primary" disabled>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Siparişi Tamamla
                </button>
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
            const cartItems = rawItems.map(item => ({
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

            // Generate order number
            const orderNumber = 'ORD-' + Date.now();
            document.getElementById('payment-description').textContent = `Sipariş #${orderNumber}`;

            // Display order summary
            const container = document.getElementById('order-summary');
            container.innerHTML = `
            <div class="space-y-3">
                ${cartItems.map(item => `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="${item.images?.[0] || ''}" alt="${item.title}" class="w-12 h-12 object-cover rounded-lg" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDgiIGhlaWdodD0iNDgiIGZpbGw9IiNjY2MiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMTIgMmM1LjUxNCAwIDEwIDQuNDg2IDEwIDEwcy00LjQ4NiAxMC0xMCAxMFMyIDEyIDIgMTJTNi40ODYgMiAxMiAyek0xMiA2YTYgNiAwIDEwMCAxMiA2IDYgMCAwMDAtMTJ6Ii8+PC9zdmc+'">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">${Ödeme YöntemHtml(item.title)}</h4>
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
                total: total,
                order_number: orderNumber
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

        // Show preview
        document.getElementById('receipt-preview').style.display = 'block';
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
                    shippingAddress: addressInput, // Formdan aldığımız adresi koyduk
                    billingAddress: addressInput,  // Faturayı da şimdilik aynı yolluyoruz
                    transferNote: document.getElementById('transfer-note').value
                })
            });

            if (orderResponse.ok) {
                const resultData = await orderResponse.json().catch(() => ({}));
                showToast('Sipariş başarıyla oluşturuldu!', 'success');

                const orderNum = resultData.orderNumber || resultData.id || '';
                setTimeout(() => {
                    window.location.href = `/orders?success=${orderNum}`;
                }, 2000);
            } else {
                const err = await orderResponse.json().catch(() => ({}));
                throw new Error('Sipariş oluşturulamadı: ' + (err.message || 'Bilinmeyen hata'));
            }

        } catch (error) {
            console.error("Checkout Error:", error);
            showToast(error.message, 'error');
        }
    }
</script>
</div> </div>