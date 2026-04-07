<?php
// Giriş kontrolü
if (!$current_user) {
    header('Location: /login?redirect=/account');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Hesap Ayarları</h1>
            <p class="text-gray-600">Hesap bilgilerinizi ve güvenlik ayarlarınızı yönetin</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <nav class="bg-white rounded-lg shadow-sm p-4 space-y-1">
                    <a href="#personal-info" onclick="showSection('personal-info')"
                        class="account-nav-link active flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Kişisel Bilgiler
                    </a>
                    <a href="#addresses" onclick="showSection('addresses')"
                        class="account-nav-link flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Adreslerim
                    </a>

                    <a href="#payment-methods" onclick="showSection('payment-methods')"
                        class="account-nav-link flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                        Ödeme Yöntemlerim
                    </a>
                    <a href="#security" onclick="showSection('security')"
                        class="account-nav-link flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        Güvenlik
                    </a>

                    <a href="#notifications" onclick="showSection('notifications')"
                        class="account-nav-link flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-5 5v-5zM7 7h10a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z">
                            </path>
                        </svg>
                        Bildirimler
                    </a>

                    <a href="#privacy" onclick="showSection('privacy')"
                        class="account-nav-link flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        Gizlilik
                    </a>

                    <a href="#delete-account" onclick="showSection('delete-account')"
                        class="account-nav-link flex items-center px-3 py-2 text-sm font-medium rounded-md text-red-600">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Hesabı Sil
                    </a>
                </nav>
            </div>

            <div class="lg:col-span-2">
                <div id="personal-info" class="account-section">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Kişisel Bilgiler</h3>

                        <form id="personal-info-form" class="space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Ad
                                        Soyad</label>
                                    <input type="text" id="full_name" name="full_name"
                                        value="<?php echo htmlspecialchars($current_user['full_name']); ?>"
                                        class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border"
                                        required />
                                </div>

                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 mb-2">E-posta</label>
                                    <input type="email" id="email" name="email"
                                        value="<?php echo htmlspecialchars($current_user['email']); ?>"
                                        class="w-full rounded-md border-gray-300 bg-gray-100 py-2 px-3 border"
                                        disabled />
                                    <p class="text-xs text-gray-500 mt-1">E-posta adresi değiştirilemez</p>
                                </div>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telefon</label>
                                <div class="relative rounded-md shadow-sm">
                                    <input type="tel" id="phone" name="phone"
                                        value="<?php echo htmlspecialchars($current_user['phoneNumber'] ?? $current_user['phone'] ?? ''); ?>"
                                        class="block w-full rounded-md border-gray-300 bg-gray-50 pr-20 focus:border-blue-500 focus:ring-blue-500 py-2 px-3 sm:text-sm transition-colors"
                                        placeholder="05XX XXX XX XX" readonly />
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <button type="button" id="edit-phone-btn"
                                            class="text-sm font-medium text-blue-600 hover:text-blue-500 focus:outline-none bg-transparent">Güncelle</button>
                                    </div>
                                </div>
                                <p id="phone-hint" class="text-xs text-blue-600 mt-1 hidden">Yeni numaranızı girip
                                    aşağıdaki 'Değişiklikleri Kaydet' butonuna basın.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                                <div>
                                    <label for="gender"
                                        class="block text-sm font-medium text-gray-700 mb-2">Cinsiyet</label>
                                    <select id="gender" name="gender"
                                        class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border">
                                        <option value="">Seçiniz</option>
                                        <option value="male" <?php echo (isset($current_user['gender']) && $current_user['gender'] == 'male') ? 'selected' : ''; ?>>Erkek</option>
                                        <option value="female" <?php echo (isset($current_user['gender']) && $current_user['gender'] == 'female') ? 'selected' : ''; ?>>Kadın</option>
                                        <option value="other" <?php echo (isset($current_user['gender']) && $current_user['gender'] == 'other') ? 'selected' : ''; ?>>Belirtmek
                                            İstemiyorum</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Doğum
                                        Tarihi</label>
                                    <input type="date" id="birth_date" name="birth_date"
                                        value="<?php echo htmlspecialchars($current_user['birth_date'] ?? ''); ?>"
                                        class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border" />
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-medium">Değişiklikleri
                                    Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="addresses" class="account-section" style="display: none;">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Kayıtlı Adreslerim</h3>
                            <button id="add-address-btn"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-medium text-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Yeni Adres Ekle
                            </button>
                        </div>

                        <div id="address-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div
                                class="border border-gray-200 rounded-lg p-5 relative hover:border-blue-500 transition-colors group">
                                <div
                                    class="absolute top-4 right-4 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button type="button" onclick="editMockAddress(this)"
                                        class="text-gray-400 hover:text-blue-600" title="Düzenle">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button type="button" onclick="deleteMockAddress(this)"
                                        class="text-gray-400 hover:text-red-600" title="Sil">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                                <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                                    Ev Adresim
                                    <span
                                        class="ml-3 px-2 py-0.5 bg-green-100 text-green-800 text-xs font-medium rounded">Varsayılan
                                        Teslimat</span>
                                </h4>
                                <div class="text-sm text-gray-600 mb-3 space-y-1">
                                    <p><strong><?php echo htmlspecialchars($current_user['full_name']); ?></strong> -
                                        <?php echo htmlspecialchars($current_user['phoneNumber'] ?? 'Telefon Yok'); ?>
                                    </p>
                                    <p>Reşatbey Mah. Cumhuriyet Cad. No:12 Kat:4 Daire:8</p>
                                    <p>Seyhan / Adana</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="payment-methods" class="account-section" style="display: none;">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Kayıtlı Kartlarım</h3>
                            <button id="add-card-btn"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-medium text-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Yeni Kart Ekle
                            </button>
                        </div>

                        <div id="payment-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div
                                class="border border-gray-200 rounded-lg p-5 bg-gradient-to-br from-slate-700 to-slate-900 text-white relative shadow-md">
                                <div class="absolute top-4 right-4">
                                    <button class="text-gray-300 hover:text-white transition-colors" title="Kartı Sil">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="mb-6 opacity-80">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m14-6h2m-2 6h2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-xl font-mono tracking-widest mb-3">**** **** **** 4281</p>
                                <div class="flex justify-between text-sm opacity-90 uppercase tracking-wider">
                                    <span><?php echo htmlspecialchars($current_user['full_name']); ?></span>
                                    <span>12/28</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="security" class="account-section" style="display: none;">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Güvenlik Ayarları</h3>

                        <div class="mb-8">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Şifre Değiştir</h4>
                            <form id="password-form" class="space-y-4">
                                <div>
                                    <label for="current_password"
                                        class="block text-sm font-medium text-gray-700 mb-2">Mevcut Şifre</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <input type="password" id="current_password" name="current_password"
                                            class="w-full pr-10 rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border"
                                            required />
                                        <button type="button"
                                            onclick="togglePasswordVisibility('current_password', 'eye-curr-show', 'eye-curr-hide')"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                            <svg id="eye-curr-show" class="h-5 w-5 hidden" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg id="eye-curr-hide" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Yeni
                                        Şifre</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <input type="password" id="new_password" name="new_password"
                                            class="w-full pr-10 rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border"
                                            minlength="6" required />
                                        <button type="button"
                                            onclick="togglePasswordVisibility('new_password', 'eye-new-show', 'eye-new-hide')"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                            <svg id="eye-new-show" class="h-5 w-5 hidden" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg id="eye-new-hide" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label for="confirm_password"
                                        class="block text-sm font-medium text-gray-700 mb-2">Yeni Şifre Tekrar</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <input type="password" id="confirm_password" name="confirm_password"
                                            class="w-full pr-10 rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-2 px-3 border"
                                            required />
                                        <button type="button"
                                            onclick="togglePasswordVisibility('confirm_password', 'eye-conf-show', 'eye-conf-hide')"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                            <svg id="eye-conf-show" class="h-5 w-5 hidden" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg id="eye-conf-hide" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-medium">Şifreyi
                                        Değiştir</button>
                                </div>
                            </form>
                        </div>

                        <div class="border-t border-gray-200 pt-8">
                            <h4 class="text-md font-medium text-gray-900 mb-4">İki Faktörlü Doğrulama</h4>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">Yakında Gelecek</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>İki faktörlü doğrulama özelliği yakında eklenecek.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="notifications" class="account-section" style="display: none;">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Bildirim Ayarları</h3>

                        <form id="notifications-form" class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">E-posta Bildirimleri</h4>
                                    <p class="text-sm text-gray-500">Sipariş durumu ve önemli güncellemeler</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="email_notif" class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">SMS Bildirimleri</h4>
                                    <p class="text-sm text-gray-500">Kritik güncellemeler için SMS</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="sms_notif" class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Pazarlama E-postaları</h4>
                                    <p class="text-sm text-gray-500">Kampanyalar ve özel teklifler</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="marketing_notif" class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                </label>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit" id="save-notif-btn"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-medium">Ayarları
                                    Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="privacy" class="account-section" style="display: none;">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Gizlilik Ayarları</h3>

                        <form id="privacy-form" class="space-y-6">

                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Profil Görünürlüğü</h4>
                                    <p class="text-sm text-gray-500">Profilinizin diğer kullanıcılara görünürlüğü</p>
                                </div>
                                <select id="privacy_visibility" name="privacy_visibility"
                                    class="text-sm border border-gray-300 rounded-md px-3 py-1">
                                    <option value="public">Herkese Açık</option>
                                    <option value="friends">Sadece Arkadaşlar</option>
                                    <option value="private">Gizli</option>
                                </select>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Veri Toplama</h4>
                                    <p class="text-sm text-gray-500">Analitik ve iyileştirme amaçlı veri toplama</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="privacy_analytics" name="privacy_analytics"
                                        class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                </label>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="submit" id="save-privacy-btn"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-medium">Ayarları
                                    Kaydet</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

            <div id="delete-account" class="account-section" style="display: none;">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-medium text-red-900 mb-6">Hesabı Sil</h3>

                    <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Dikkat!</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>Hesabınızı silerseniz:</p>
                                    <ul class="list-disc list-inside mt-2">
                                        <li>Tüm verileriniz kalıcı olarak silinir</li>
                                        <li>Sipariş geçmişiniz kaybolur</li>
                                        <li>Bu işlem geri alınamaz</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="delete-account-form">
                        <div class="mb-4">
                            <label for="delete_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Hesabınızı silmek istediğinizi onaylamak için "HESABI SİL" yazın:
                            </label>
                            <input type="text" id="delete_confirmation" name="delete_confirmation"
                                class="w-full rounded-md border-gray-300 focus:border-red-500 focus:ring-red-500 py-2 px-3 border"
                                placeholder="HESABI SİL" required />
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 font-medium">Hesabı
                                Kalıcı Olarak Sil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div id="address-modal"
    class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center transition-opacity">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-xl p-6 m-4">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Yeni Adres Ekle</h3>
        <form id="mock-address-form" class="space-y-4">
            <input type="text" id="mock_addr_title" placeholder="Adres Başlığı (Örn: İş Yeri)" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <select id="mock_addr_city" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="">Şehirler Yükleniyor...</option>
                    </select>
                </div>
                <div>
                    <select id="mock_addr_district" required disabled
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100 disabled:text-gray-500 bg-white">
                        <option value="">Önce İl Seçiniz</option>
                    </select>
                </div>
            </div>

            <textarea id="mock_addr_detail" placeholder="Açık Adres (Mahalle, Sokak, No...)" required rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white"></textarea>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeModal('address-modal')"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 font-medium">İptal</button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">Kaydet</button>
            </div>
        </form>
    </div>
</div>

<div id="card-modal"
    class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center transition-opacity">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 m-4">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Yeni Kart Ekle</h3>
        <form id="mock-card-form" class="space-y-4">
            <input type="text" id="mock_card_name" placeholder="Kart Üzerindeki İsim" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            <input type="text" id="mock_card_number" placeholder="Kart Numarası (16 Hane)" maxlength="19" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            <div class="grid grid-cols-2 gap-4">
                <input type="text" id="mock_card_expiry" placeholder="AA/YY" maxlength="5" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <input type="text" id="mock_card_cvc" placeholder="CVC" maxlength="3" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeModal('card-modal')"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 font-medium">İptal</button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">Ekle</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async function () {
        // 1. Form Submit Dinleyicileri
        const personalInfoForm = document.getElementById('personal-info-form');
        const passwordForm = document.getElementById('password-form');
        const deleteAccountForm = document.getElementById('delete-account-form');
        const notificationsForm = document.getElementById('notifications-form');

        if (personalInfoForm) personalInfoForm.addEventListener('submit', handlePersonalInfoSubmit);
        if (passwordForm) passwordForm.addEventListener('submit', handlePasswordSubmit);
        if (deleteAccountForm) deleteAccountForm.addEventListener('submit', handleDeleteAccountSubmit);
        if (notificationsForm) notificationsForm.addEventListener('submit', handleNotificationsSubmit);

        const privacyForm = document.getElementById('privacy-form');
        if (privacyForm) privacyForm.addEventListener('submit', handlePrivacySubmit);

        loadNotificationSettings();
        loadUserProfile();
        loadPrivacySettings();


        // 3. Telefon Input Formatlama ve Kilit İşlemleri
        const phoneInput = document.getElementById('phone');
        const editPhoneBtn = document.getElementById('edit-phone-btn');
        const phoneHint = document.getElementById('phone-hint');

        if (editPhoneBtn && phoneInput) {
            editPhoneBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (phoneInput.hasAttribute('readonly')) {
                    phoneInput.removeAttribute('readonly');
                    phoneInput.classList.remove('bg-gray-50');
                    phoneInput.focus();

                    const val = phoneInput.value;
                    phoneInput.value = '';
                    phoneInput.value = val;

                    editPhoneBtn.textContent = 'İptal';
                    editPhoneBtn.classList.replace('text-blue-600', 'text-gray-500');
                    editPhoneBtn.classList.replace('hover:text-blue-500', 'hover:text-gray-700');
                    if (phoneHint) phoneHint.classList.remove('hidden');
                } else {
                    phoneInput.setAttribute('readonly', 'readonly');
                    phoneInput.classList.add('bg-gray-50');

                    editPhoneBtn.textContent = 'Güncelle';
                    editPhoneBtn.classList.replace('text-gray-500', 'text-blue-600');
                    editPhoneBtn.classList.replace('hover:text-gray-700', 'hover:text-blue-500');
                    if (phoneHint) phoneHint.classList.add('hidden');
                }
            });
        }

        if (phoneInput) {
            phoneInput.addEventListener('input', function () {
                var cursorPos = this.selectionStart;
                var oldLength = this.value.length;
                var digits = this.value.replace(/\D/g, '');

                if (digits.length > 11) digits = digits.substring(0, 11);

                var formatted = '';
                for (var i = 0; i < digits.length; i++) {
                    if (i === 4 || i === 7 || i === 9) formatted += ' ';
                    formatted += digits[i];
                }

                this.value = formatted;
                var diff = this.value.length - oldLength;
                this.setSelectionRange(cursorPos + diff, cursorPos + diff);
            });
        }
        // --- KART BİLGİLERİ PROFESYONEL FORMATLAMA ---

        // 1. Kart Üzerindeki İsim (Sadece harf ve boşluk)
        const cardName = document.getElementById('mock_card_name');
        if (cardName) {
            cardName.addEventListener('input', function () {
                // Rakamları ve özel karakterleri anında siler
                this.value = this.value.replace(/[^a-zA-ZçÇğĞıİöÖşŞüÜ\s]/g, '');
            });
        }

        // 2. Kart Numarası (Sadece rakam ve 4 hanede bir boşluk)
        const cardNumber = document.getElementById('mock_card_number');
        if (cardNumber) {
            cardNumber.addEventListener('input', function () {
                // Önce sadece rakamları al
                let value = this.value.replace(/\D/g, '');
                if (value.length > 16) value = value.substring(0, 16); // Maksimum 16 rakam

                // Rakamları 4'erli gruplara ayırarak araya boşluk koy
                let formattedValue = '';
                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) formattedValue += ' ';
                    formattedValue += value[i];
                }
                this.value = formattedValue;
            });
        }

        // 3. Son Kullanma Tarihi (AA/YY Formatı ve Sadece Rakam)
        const cardExpiry = document.getElementById('mock_card_expiry');
        if (cardExpiry) {
            cardExpiry.addEventListener('input', function (e) {
                // Silme tuşuna basılıyorsa formata karışma (rahat silebilsin diye)
                if (e.inputType === 'deleteContentBackward') return;

                // Sadece rakamları al
                let value = this.value.replace(/\D/g, '');
                if (value.length > 4) value = value.substring(0, 4); // Maksimum 4 rakam (AAYY)

                if (value.length >= 2) {
                    // Ay kısmının 01 ile 12 arasında olmasını sağla
                    let month = parseInt(value.substring(0, 2));
                    if (month > 12) value = '12' + value.substring(2);
                    if (month === 0) value = '01' + value.substring(2);

                    // Araya '/' koy
                    this.value = value.substring(0, 2) + '/' + value.substring(2);
                } else {
                    this.value = value;
                }
            });
        }

        // 4. CVC (Sadece 3 Rakam)
        const cardCvc = document.getElementById('mock_card_cvc');
        if (cardCvc) {
            cardCvc.addEventListener('input', function () {
                // Sadece rakamları al ve maksimum 3 haneye izin ver
                let value = this.value.replace(/\D/g, '');
                if (value.length > 3) value = value.substring(0, 3);
                this.value = value;
            });
        }

        // 4. Modal Açma/Kapama Bağlantıları
        const addAddressBtn = document.getElementById('add-address-btn');
        const addCardBtn = document.getElementById('add-card-btn');
        if (addAddressBtn) addAddressBtn.addEventListener('click', () => openModal('address-modal'));
        if (addCardBtn) addCardBtn.addEventListener('click', () => openModal('card-modal'));

        // 5. Şehir ve İlçe API İşlemleri
        const citySelect = document.getElementById('mock_addr_city');
        const districtSelect = document.getElementById('mock_addr_district');

        if (citySelect && districtSelect) {
            try {
                const response = await fetch('https://turkiyeapi.dev/api/v1/provinces');
                const result = await response.json();

                citySelect.innerHTML = '<option value="">İl Seçiniz</option>';
                const sehirler = result.data.sort((a, b) => a.name.localeCompare(b.name, 'tr-TR'));

                sehirler.forEach(sehir => {
                    const option = document.createElement('option');
                    option.value = sehir.name;
                    option.textContent = sehir.name;
                    option.dataset.ilceler = JSON.stringify(sehir.districts.map(d => d.name));
                    citySelect.appendChild(option);
                });

                citySelect.addEventListener('change', function () {
                    districtSelect.innerHTML = '<option value="">İlçe Seçiniz</option>';
                    const selectedOption = this.options[this.selectedIndex];

                    if (selectedOption.value) {
                        districtSelect.disabled = false;
                        const ilceler = JSON.parse(selectedOption.dataset.ilceler);
                        ilceler.sort((a, b) => a.localeCompare(b, 'tr-TR')).forEach(ilce => {
                            const option = document.createElement('option');
                            option.value = ilce;
                            option.textContent = ilce;
                            districtSelect.appendChild(option);
                        });
                    } else {
                        districtSelect.disabled = true;
                        districtSelect.innerHTML = '<option value="">Önce İl Seçiniz</option>';
                    }
                });

            } catch (error) {
                console.error("Şehir verileri çekilemedi:", error);
                citySelect.innerHTML = '<option value="">Sunucu Hatası</option>';
            }
        }
    });

    // --- YARDIMCI FONKSİYONLAR ---
    function showSection(sectionId) {
        const sections = document.querySelectorAll('.account-section');
        sections.forEach(section => section.style.display = 'none');
        document.getElementById(sectionId).style.display = 'block';

        const navLinks = document.querySelectorAll('.account-nav-link');
        navLinks.forEach(link => link.classList.remove('active'));
        event.target.classList.add('active');
    }

    function togglePasswordVisibility(inputId, showIconId, hideIconId) {
        const input = document.getElementById(inputId);
        const showIcon = document.getElementById(showIconId);
        const hideIcon = document.getElementById(hideIconId);

        if (input.type === 'password') {
            input.type = 'text';
            showIcon.classList.remove('hidden');
            hideIcon.classList.add('hidden');
        } else {
            input.type = 'password';
            showIcon.classList.add('hidden');
            hideIcon.classList.remove('hidden');
        }
    }

    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // --- BACKEND API İSTEKLERİ ---

    async function loadUserProfile() {
        try {
            const token = localStorage.getItem('auth_token');
            if (!token) return;

            const response = await fetch(`${API_BASE}/api/User/profile`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });

            if (response.ok) {
                const data = await response.json();

                // Ad Soyad — backend verisi PHP session'ın üzerine yazar
                const fullNameInput = document.getElementById('full_name');
                if (fullNameInput && data.fullName) {
                    fullNameInput.value = data.fullName;
                }

                // Cinsiyet
                const genderSelect = document.getElementById('gender');
                if (genderSelect && data.gender) {
                    genderSelect.value = data.gender; // "male", "female", "other"
                }

                // Doğum Tarihi (backend ISO formatında döner: "2000-05-15T00:00:00")
                const birthInput = document.getElementById('birth_date');
                if (birthInput && data.birthDate) {
                    birthInput.value = data.birthDate.split('T')[0]; // "2000-05-15" formatına çevir
                }

                // Telefon
                const phoneInput = document.getElementById('phone');
                if (phoneInput && data.phoneNumber && data.phoneNumber.trim() !== '') {
                    let digits = data.phoneNumber.replace(/\D/g, '');
                    if (digits.length > 11) digits = digits.substring(0, 11);
                    let formatted = '';
                    for (var i = 0; i < digits.length; i++) {
                        if (i === 4 || i === 7 || i === 9) formatted += ' ';
                        formatted += digits[i];
                    }
                    phoneInput.value = formatted;
                }
            }
        } catch (error) {
            console.error("Profil bilgileri yüklenemedi:", error);
        }
    }


    async function handlePersonalInfoSubmit(e) {
        e.preventDefault();
        const submitBtn = e.target.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Kaydediliyor...';

        const formData = new FormData(e.target);
        let rawPhone = formData.get('phone') || '';
        let cleanPhone = rawPhone.replace(/\s/g, '');

        const data = {
            FullName: formData.get('full_name'),
            PhoneNumber: cleanPhone,
            Gender: formData.get('gender') || null,
            BirthDate: formData.get('birth_date') || null
        };



        try {
            const token = localStorage.getItem('auth_token');
            const response = await fetch(`${API_BASE}/api/User/profile`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                if (typeof showToast === 'function') showToast('Kişisel bilgiler başarıyla güncellendi', 'success');
                else await openCustomModal('Kişisel bilgiler güncellendi', 'alert');

                const phoneInput = document.getElementById('phone');
                const editBtn = document.getElementById('edit-phone-btn');
                if (phoneInput && editBtn) {
                    phoneInput.setAttribute('readonly', 'readonly');
                    phoneInput.classList.add('bg-gray-50');
                    editBtn.textContent = 'Güncelle';
                    editBtn.classList.replace('text-gray-500', 'text-blue-600');
                    editBtn.classList.replace('hover:text-gray-700', 'hover:text-blue-500');
                    document.getElementById('phone-hint').classList.add('hidden');
                }
            } else {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Güncelleme başarısız oldu.');
            }
        } catch (error) {
            if (typeof showToast === 'function') showToast(error.message, 'error');
            else await openCustomModal(error.message, 'alert');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Değişiklikleri Kaydet';
        }
    }

    async function handlePasswordSubmit(e) {
        e.preventDefault();
        const submitBtn = e.target.querySelector('button[type="submit"]');
        const formData = new FormData(e.target);
        const currentPassword = formData.get('current_password');
        const newPassword = formData.get('new_password');
        const confirmPassword = formData.get('confirm_password');
        const userEmail = document.getElementById('email').value;

        if (newPassword !== confirmPassword) {
            if (typeof showToast === 'function') showToast('Yeni şifreler eşleşmiyor', 'error');
            else await openCustomModal('Yeni şifreler eşleşmiyor', 'alert');
            return;
        }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Değiştiriliyor...';

        try {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                if (typeof showToast === 'function') showToast('Oturum süresi dolmuş. Lütfen tekrar giriş yapın.', 'error');
                setTimeout(() => { window.location.href = '/login'; }, 1500);
                return;
            }
            const response = await fetch(`${API_BASE}/api/Auth/change-password`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    Email: userEmail,
                    CurrentPassword: currentPassword,
                    NewPassword: newPassword
                })


            });


            let data = {};
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.includes("application/json")) data = await response.json();

            if (response.status === 403 || response.status === 401) {


                showToast('Hesabınız onaylanmamış! Sistemden çıkarılıyorsunuz...', 'error');
                setTimeout(() => window.location.href = '/verify-otp', 1500);
                return;
            }

            if (!response.ok) throw new Error(data.message || data.error || 'Mevcut şifreniz yanlış veya bir hata oluştu.');

            if (typeof showToast === 'function') showToast('Şifreniz başarıyla değiştirildi!', 'success');
            else await openCustomModal('Şifreniz başarıyla değiştirildi!', 'alert');
            e.target.reset();

        } catch (error) {
            if (typeof showToast === 'function') showToast(error.message, 'error');
            else await openCustomModal(error.message, 'alert');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Şifreyi Değiştir';
        }
    }

    async function handleDeleteAccountSubmit(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        if (formData.get('delete_confirmation') !== 'HESABI SİL') {
            if (typeof showToast === 'function') showToast('Onay metni hatalı', 'error');
            else await openCustomModal('Onay metni hatalı', 'alert');
            return;
        }
        if (!(await openCustomModal('Hesabınızı kalıcı olarak silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!'))) return;

        if (typeof showToast === 'function') showToast('Hesap silme işlemi yakında eklenecek', 'info');
        else await openCustomModal('Hesap silme işlemi yakında eklenecek', 'alert');
    }

    async function loadNotificationSettings() {
        try {
            const token = localStorage.getItem('auth_token');
            if (!token) return; // ← token yoksa çalışma

            const response = await fetch(`${API_BASE}/api/Notifications/settings`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });

            // 401 = süresi dolmuş token → login'e yönlendir
            if (response.status === 401) {
                localStorage.removeItem('auth_token');
                window.location.href = '/login?redirect=/account';
                return;
            }

            // 403 = hesap doğrulanmamış → kullanıcıyı bilgilendir
            if (response.status === 403) {
                showToast('Hesabınız henüz doğrulanmamış. Bildirim ayarlarına erişilemedi.', 'warning');
                return;
            }

            if (response.ok) {
                const data = await response.json();
                document.getElementById('email_notif').checked = data.emailNotificationsEnabled || false;
                document.getElementById('sms_notif').checked = data.smsNotificationsEnabled || false;
                document.getElementById('marketing_notif').checked = data.marketingEmailsEnabled || false;
            }
        } catch (error) {
            console.error("Bildirim ayarları yüklenemedi:", error);
        }
    }


    async function handleNotificationsSubmit(e) {
        e.preventDefault();
        const btn = document.getElementById('save-notif-btn');
        btn.disabled = true;
        btn.textContent = 'Kaydediliyor...';

        const data = {
            emailNotificationsEnabled: document.getElementById('email_notif').checked,
            smsNotificationsEnabled: document.getElementById('sms_notif').checked,
            marketingEmailsEnabled: document.getElementById('marketing_notif').checked
        };

        try {
            const token = localStorage.getItem('auth_token');
            const response = await fetch(`${API_BASE}/api/Notifications/settings`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(data)
            });
            if (!response.ok) throw new Error('Ayarlar kaydedilirken bir hata oluştu.');
            if (typeof showToast === 'function') showToast('Bildirim ayarları güncellendi', 'success');
            else await openCustomModal('Bildirim ayarları güncellendi', 'alert');
        } catch (error) {
            if (typeof showToast === 'function') showToast(error.message, 'error');
            else await openCustomModal(error.message, 'alert');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Ayarları Kaydet';
        }
    }
    async function loadPrivacySettings() {
        try {
            const token = localStorage.getItem('auth_token');
            if (!token) return;
            const response = await fetch(`${API_BASE}/api/PrivacySettings`, {
                method: 'GET',
                headers: { 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` }
            });
            if (response.ok) {
                const data = await response.json();
                const visSelect = document.getElementById('privacy_visibility');
                const analyticsCheck = document.getElementById('privacy_analytics');
                if (visSelect && data.visibilityStatus) visSelect.value = data.visibilityStatus;
                if (analyticsCheck) analyticsCheck.checked = data.allowAnalytics || false;
            }
        } catch (error) {
            console.error('Gizlilik ayarları yüklenemedi:', error);
        }
    }

    async function handlePrivacySubmit(e) {
        e.preventDefault();
        const btn = document.getElementById('save-privacy-btn');
        btn.disabled = true;
        btn.textContent = 'Kaydediliyor...';
        try {
            const token = localStorage.getItem('auth_token');
            if (!token) { if (typeof showToast === 'function') showToast('Oturum süresi dolmuş.', 'error'); return; }
            const data = {
                visibilityStatus: document.getElementById('privacy_visibility').value,
                allowAnalytics: document.getElementById('privacy_analytics').checked
            };
            const response = await fetch(`${API_BASE}/api/PrivacySettings`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` },
                body: JSON.stringify(data)
            });
            if (!response.ok) throw new Error('Gizlilik ayarları kaydedilemedi.');
            if (typeof showToast === 'function') showToast('Gizlilik ayarları güncellendi', 'success');
        } catch (error) {
            if (typeof showToast === 'function') showToast(error.message, 'error');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Ayarları Kaydet';
        }
    }

    // --- MOCK ADRES VE KART EKLEME (FRONTEND UI GÖSTERİMİ İÇİN) ---

    document.getElementById('mock-address-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const title = document.getElementById('mock_addr_title').value;
        const city = document.getElementById('mock_addr_city').value;
        const district = document.getElementById('mock_addr_district').value;
        const detail = document.getElementById('mock_addr_detail').value;

        const newAddressHTML = `
        <div class="border border-gray-200 rounded-lg p-5 relative hover:border-blue-500 transition-colors group">
            <div class="absolute top-4 right-4 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <button type="button" onclick="editMockAddress(this)" class="text-gray-400 hover:text-blue-600" title="Düzenle">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
</button>
<button type="button" onclick="deleteMockAddress(this)" class="text-gray-400 hover:text-red-600" title="Sil">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
</button>
            </div>
            <h4 class="font-semibold text-gray-900 mb-2 flex items-center">${title}</h4>
            <div class="text-sm text-gray-600 mb-3 space-y-1">
                <p>${detail}</p>
                <p>${district} / ${city}</p>
            </div>
        </div>
    `;

        document.getElementById('address-container').insertAdjacentHTML('beforeend', newAddressHTML);
        this.reset();
        document.getElementById('mock_addr_district').innerHTML = '<option value="">Önce İl Seçiniz</option>';
        document.getElementById('mock_addr_district').disabled = true;
        closeModal('address-modal');
        if (typeof showToast === 'function') showToast('Yeni adres eklendi (Önizleme)', 'success');
    });

    document.getElementById('mock-card-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const name = document.getElementById('mock_card_name').value;
        const number = document.getElementById('mock_card_number').value;
        const expiry = document.getElementById('mock_card_expiry').value;
        const last4 = number.length >= 4 ? number.slice(-4) : "0000";

        const newCardHTML = `
        <div class="border border-gray-200 rounded-lg p-5 bg-gradient-to-br from-slate-700 to-slate-900 text-white relative shadow-md">
            <div class="absolute top-4 right-4">
                <button class="text-gray-300 hover:text-white transition-colors" title="Kartı Sil">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
            <div class="mb-6 opacity-80">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m14-6h2m-2 6h2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
            </div>
            <p class="text-xl font-mono tracking-widest mb-3">**** **** **** ${last4}</p>
            <div class="flex justify-between text-sm opacity-90 uppercase tracking-wider">
                <span>${name}</span>
                <span>${expiry}</span>
            </div>
        </div>
    `;

        document.getElementById('payment-container').insertAdjacentHTML('beforeend', newCardHTML);
        this.reset();
        closeModal('card-modal');
        if (typeof showToast === 'function') showToast('Yeni kart eklendi (Önizleme)', 'success');
    });
    async function deleteMockAddress(btn) {
        if (await openCustomModal('Bu adresi silmek istediğinize emin misiniz?')) {
            // Butonun bulunduğu en dıştaki adresi bul ve sil
            const addressCard = btn.closest('.group');
            if (addressCard) {
                addressCard.remove();
                if (typeof showToast === 'function') showToast('Adres başarıyla silindi', 'success');
            }
        }
    }

    async function editMockAddress(btn) {
        if (typeof showToast === 'function') showToast('Düzenleme özelliği backend bağlanınca aktif olacak', 'info');
        else await openCustomModal('Düzenleme özelliği backend bağlanınca aktif olacak', 'alert');
    }
</script>

<style>
    .account-nav-link {
        color: rgb(75 85 99);
        transition: all 0.2s;
    }

    .account-nav-link:hover {
        color: rgb(17 24 39);
        background-color: rgb(249 250 251);
    }

    .account-nav-link.active {
        color: rgb(37 99 235);
        background-color: rgb(239 246 255);
    }
</style>