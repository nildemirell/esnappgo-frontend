<?php
// Esnaf kontrolü
if (!$current_user || ($current_user['role'] !== 'merchant' && $current_user['role'] !== 'esnaf')) {

    header('Location: /dashboard');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mağaza Yönetimi</h1>
            <p class="text-gray-600">Mağaza bilgilerinizi güncelleyin</p>
        </div>

        <!-- Shop Form -->
        <div class="bg-white rounded-lg shadow-sm p-8">
            <form id="shop-form" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="shop_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Mağaza Adı
                        </label>
                        <input type="text" id="shop_name" name="name" class="w-full" placeholder="Mağaza adınız"
                            required />
                    </div>

                    <div>
                        <label for="shop_phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Telefon
                        </label>
                        <input type="tel" id="shop_phone" name="phone" class="w-full" placeholder="0533 616 02 18" />
                    </div>
                </div>

                <div>
                    <label for="shop_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Mağaza Açıklaması
                    </label>
                    <textarea id="shop_description" name="description" rows="4" class="w-full"
                        placeholder="Mağazanız hakkında bilgi verin..."></textarea>
                </div>

                <div>
                    <label for="shop_address" class="block text-sm font-medium text-gray-700 mb-2">
                        Adres
                    </label>
                    <textarea id="shop_address" name="address" rows="3" class="w-full" placeholder="Mağaza adresiniz..."
                        required></textarea>
                </div>

                <!-- Business Hours -->
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Çalışma Saatleri</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="opening_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Açılış Saati
                            </label>
                            <input type="time" id="opening_time" name="opening_time" class="w-full" value="09:00" />
                        </div>

                        <div>
                            <label for="closing_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Kapanış Saati
                            </label>
                            <input type="time" id="closing_time" name="closing_time" class="w-full" value="18:00" />
                        </div>
                    </div>
                </div>

                <!-- Working Days -->
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Çalışma Günleri</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="working_days[]" value="monday" class="mr-2" checked>
                            <span class="text-sm">Pazartesi</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="working_days[]" value="tuesday" class="mr-2" checked>
                            <span class="text-sm">Salı</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="working_days[]" value="wednesday" class="mr-2" checked>
                            <span class="text-sm">Çarşamba</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="working_days[]" value="thursday" class="mr-2" checked>
                            <span class="text-sm">Perşembe</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="working_days[]" value="friday" class="mr-2" checked>
                            <span class="text-sm">Cuma</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="working_days[]" value="saturday" class="mr-2" checked>
                            <span class="text-sm">Cumartesi</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="working_days[]" value="sunday" class="mr-2">
                            <span class="text-sm">Pazar</span>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="/dashboard" class="btn btn-outline">
                        İptal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Değişiklikleri Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        loadShopData();

        document.getElementById('shop-form').addEventListener('submit', handleShopSubmit);
    });

    async function loadShopData() {
        try {
            const token = localStorage.getItem('auth_token');
            const response = await fetch(`${API_BASE}/api/Merchant/shop`, {
                method: 'GET',
                headers: { 'Authorization': `Bearer ${token}` }
            });

            if (response.ok) {
                const shop = await response.json();

                // Backend DTO'sundan (veritabanından) gelen isimlerle formu dolduruyoruz
                document.getElementById('shop_name').value = shop.shopName || shop.name || shop.ShopName || '';
                document.getElementById('shop_description').value = shop.shopDescription || shop.description || '';
                document.getElementById('shop_address').value = shop.address || shop.shopAddress || '';
                document.getElementById('shop_phone').value = shop.phoneNumber || shop.phone || '';
                document.getElementById('opening_time').value = (shop.openingTime || '09:00').substring(0, 5);
                document.getElementById('closing_time').value = (shop.closingTime || '18:00').substring(0, 5);


                // Tüm checkboxları önce temizleyelim
                document.querySelectorAll('input[name="working_days[]"]').forEach(cb => cb.checked = false);

                // Backend'den gelen aktif günleri işaretleyelim
                if (shop.workingDays && Array.isArray(shop.workingDays)) {
                    shop.workingDays.forEach(day => {
                        const checkbox = document.querySelector(`input[value="${day}"]`);
                        if (checkbox) checkbox.checked = true;
                    });
                }
            } else if (response.status !== 404) {
                // Eğer 404 dönüyorsa esnaf henüz profil oluşturmamış demektir, form boş kalır. Başka hataysa yazdırırız.
                console.error('Mağaza verileri çekilemedi.');
            }
        } catch (error) {
            console.error('Error loading shop data:', error);
        }
    }

    async function handleShopSubmit(e) {
        e.preventDefault();

        const formData = new FormData(e.target);
        const workingDays = Array.from(document.querySelectorAll('input[name="working_days[]"]:checked')).map(cb => cb.value);

        // .NET positional record'ları constructor parametresi bazında json bekler (örn: shopName, phoneNumber)
        // O yüzden kesinlikle camelCase olmak zorundadır.
        const data = {
            shopName: formData.get('name'),
            shopDescription: formData.get('description'),
            address: formData.get('address'),
            phoneNumber: formData.get('phone'),
            openingTime: formData.get('opening_time'),
            closingTime: formData.get('closing_time'),
            workingDays: workingDays
        };

        try {
            const token = localStorage.getItem('auth_token');
            const response = await fetch(`${API_BASE}/api/Merchant/shop`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                showToast('Mağaza bilgileri başarıyla güncellendi!', 'success');
                setTimeout(() => {
                    window.location.href = '/dashboard'; // Başarılıysa dashboarda geri dön
                }, 1500);
            } else {
                const err = await response.json();
                throw new Error(err.message || err.error || 'Güncelleme başarısız oldu.');
            }
        } catch (error) {
            showToast(error.message, 'error');
        }
    }
</script>