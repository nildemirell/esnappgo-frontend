<?php
// Giriş kontrolü
if (!$current_user) {
    header('Location: /login?redirect=/dashboard');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                Hoş geldiniz, <?php echo htmlspecialchars(explode(' ', $current_user['full_name'])[0]); ?>!
            </h1>
            <p class="text-gray-600">
                <?php
                switch ($current_user['role']) {
                    case 'student':
                    case 'ogrenci':
                        echo 'Öğrenci dashboard\'unuzdan kazançlarınızı ve ürünlerinizi takip edebilirsiniz.';
                        break;
                    case 'merchant':
                    case 'esnaf':
                        echo 'Esnaf dashboard\'unuzdan mağazanızı ve siparişlerinizi yönetebilirsiniz.';
                        break;
                    default:
                        echo 'Dashboard\'unuzdan siparişlerinizi ve hesap bilgilerinizi yönetebilirsiniz.';
                }
                ?>
            </p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <?php if ($current_user['role'] === 'customer' || $current_user['role'] === 'musteri'): ?>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Toplam Sipariş</p>
                            <p class="text-2xl font-bold text-gray-900" id="stat-customer-orders">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Toplam Harcama</p>
                            <p class="text-2xl font-bold text-gray-900" id="stat-customer-spent">₺0.00</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Favoriler</p>
                            <p class="text-2xl font-bold text-gray-900" id="stat-customer-favorites">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Öğrenci Desteği</p>
                            <p class="text-2xl font-bold text-gray-900" id="stat-customer-support">₺0.00</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($current_user['role'] === 'student' || $current_user['role'] === 'ogrenci'): ?>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Toplam Kazanç</p>
                            <p class="text-2xl font-bold text-gray-900" id="stat-student-earnings">₺0.00</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Ürün Sayısı</p>
                            <p class="text-2xl font-bold text-gray-900" id="stat-student-products">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Onaylanan</p>
                            <p class="text-2xl font-bold text-gray-900" id="stat-student-approved">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Beklemede</p>
                            <p class="text-2xl font-bold text-gray-900" id="stat-student-pending">0</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($current_user['role'] === 'merchant' || $current_user['role'] === 'esnaf'): ?>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Toplam Sipariş</p>
                            <p class="text-2xl font-bold text-gray-900" id="stat-merchant-orders">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Toplam Ürün</p>
                            <p class="text-2xl font-bold text-gray-900" id="stat-merchant-products">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Onaylanan Ürün</p>
                            <p class="text-2xl font-bold text-gray-900" id="stat-merchant-approved">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Bekleyen Ürün</p>
                            <p class="text-2xl font-bold text-gray-900" id="stat-merchant-pending">0</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Son Aktiviteler</h3>
                <div class="space-y-4" id="recent_activities_container">
                    <div class="text-center py-8 text-gray-500" id="activities_loading">
                        <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-blue-500 mx-auto mb-3"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <p>Yükleniyor...</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Hızlı İşlemler</h3>
                <div class="space-y-3">
                    <?php if ($current_user['role'] === 'customer' || $current_user['role'] === 'musteri'): ?>
                        <a href="/products"
                            class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span>Ürünleri İncele</span>
                        </a>

                        <a href="/cart"
                            class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5 6m0 0h9m-9 0V19a2 2 0 002 2h6a2 2 0 002-2v-4">
                                </path>
                            </svg>
                            <span>Sepetim</span>
                        </a>

                        <a href="/orders"
                            class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            <span>Siparişlerim</span>
                        </a>

                        <a href="/favorites"
                            class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-pink-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                            <span>Favorilerim</span>
                        </a>
                    <?php endif; ?>

                    <?php if ($current_user['role'] === 'merchant' || $current_user['role'] === 'esnaf'): ?>
                        <a href="/merchant/orders"
                            class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            <span>Siparişlerim</span>
                        </a>

                        <a href="/merchant/products"
                            class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>Ürün Onayları</span>
                        </a>

                        <a href="/merchant/shop"
                            class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            <span>Mağaza Ayarları</span>
                        </a>
                    <?php endif; ?>

                    <?php if ($current_user['role'] === 'student' || $current_user['role'] === 'ogrenci'): ?>
                        <a href="/student/create-product"
                            class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            <span>Yeni Ürün Ekle</span>
                        </a>

                        <a href="/student/earnings"
                            class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                            <span>Kazançlarım</span>
                        </a>

                        <a href="/student/products"
                            class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            <span>Ürünlerim</span>
                        </a>

                        <a href="/student/wallet"
                            class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            <span>Cüzdanım</span>
                        </a>
                    <?php endif; ?>

                    <a href="/profile"
                        class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Profil Ayarları</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        loadDashboardData();
    });

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
    }

    async function loadDashboardData() {
        const role = getCookie('ui_role') || localStorage.getItem('user_role');
        const token = localStorage.getItem('auth_token');

        if (!token) {
            console.error("No auth token found. Cannot load dashboard data.");
            showEmptyActivities();
            return;
        }

        if (role === 'student' || role === 'ogrenci') {
            await loadStudentStats(token);
        } else if (role === 'merchant' || role === 'esnaf') {
            await loadMerchantStats(token);
        } else {
            await loadCustomerStats(token);
        }
    }
   async function loadStudentStats(token) {
        try {
            // 1. Cüzdan ve Ürün bilgilerini kendi apiCall fonksiyonunla güvenlice çekiyoruz
           const [wallet, productsData] = await Promise.all([
                apiCall('Wallet/my-wallet').catch(e => ({ totalEarnings: 0 })),
                apiCall('Products/my-products').catch(e => ([])) // <-- SADECE KENDİ ÜRÜNLERİ
            ]);

            // Ürünler dizisi backend'den bazen direkt dizi, bazen data/products objesi içinde gelebilir
            const productList = Array.isArray(productsData) ? productsData : (productsData.products || productsData.data || []);

            // 2. Üstteki 4'lü İstatistik Kutusunu Güncelle
            document.getElementById('stat-student-earnings').textContent = '₺' + (wallet.totalEarnings || 0).toFixed(2);
            document.getElementById('stat-student-products').textContent = productList.length;
            
            document.getElementById('stat-student-approved').textContent = productList.filter(p => 
                (p.status || '').toLowerCase() === 'approved' || (p.status || '').toLowerCase() === 'active'
            ).length;
            
            document.getElementById('stat-student-pending').textContent = productList.filter(p => 
                (p.status || '').toLowerCase() === 'pending'
            ).length;

            // 3. SON AKTİVİTELERİ DOLDUR (En yeni 5 ürünü listeye çeviriyoruz)
            if (productList.length > 0) {
                // Ürünleri eklenme tarihine göre (en yeni en üstte) sırala
                const sortedProducts = productList.sort((a, b) => new Date(b.createdAt || 0) - new Date(a.createdAt || 0));
                
                // En yeni 5 ürünü "Aktivite" formatına map'le (çevir)
                const recentActivities = sortedProducts.slice(0, 5).map(p => {
                    // İngilizce status'ü Türkçe'ye çevir
                    let trStatus = 'Beklemede';
                    const st = (p.status || '').toLowerCase();
                    if (st === 'approved' || st === 'active') trStatus = 'Onaylandı';
                    else if (st === 'rejected') trStatus = 'Reddedildi';

                    // Resim url'sini bul
                    const images = p.imageUrls || p.images || [];

                    return {
                        productName: p.name || p.title || 'İsimsiz Ürün',
                        imageUrl: images.length > 0 ? images[0] : null,
                        date: p.createdAt || new Date().toISOString(),
                        statusMessage: trStatus
                    };
                });

                // Aktiviteleri ekrana bas
                renderActivities(recentActivities);
            } else {
                // Eğer hiç ürünü yoksa boş ekran göster
                showEmptyActivities();
            }
            
        } catch (e) {
            console.error('Öğrenci verileri yüklenirken hata:', e);
            showEmptyActivities();
        }
    }
    async function loadCustomerStats(token) {
        // Müşteri için şimdilik Mock, backendcinin GET /api/User/dashboard/customer endpoint'i yazması gerekiyor.
        console.log('Fetching customer stats...');
        setTimeout(() => showEmptyActivities(), 500);
    }

    async function loadMerchantStats(token) {
        try {
            const response = await fetch(API_BASE + '/api/Merchant/dashboard', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();

                // Backend'den gelen verileri UI'a (HTML'e) bağlıyoruz
                document.getElementById('stat-merchant-orders').textContent = data.totalOrders || 0;
                document.getElementById('stat-merchant-products').textContent = data.totalProducts || 0;
                document.getElementById('stat-merchant-approved').textContent = data.approvedProducts || 0;
                document.getElementById('stat-merchant-pending').textContent = data.pendingProducts || 0;

                // Son Aktiviteleri yüklüyoruz
                if (data.recentActivities && data.recentActivities.length > 0) {
                    renderActivities(data.recentActivities);
                } else {
                    showEmptyActivities();
                }
            } else {
                showEmptyActivities();
            }
        } catch (e) {
            console.error('API Baglanti Hatasi:', e);
            showEmptyActivities();
        }
    }

    function showEmptyActivities() {
        const container = document.getElementById('recent_activities_container');
        if (!container) return;
        container.innerHTML = `
        <div class="text-center py-8 text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p>Henüz yeni aktivite bulunmuyor</p>
        </div>
    `;
    }

    function renderActivities(activities) {
        const container = document.getElementById('recent_activities_container');
        if (!container) return;

        container.innerHTML = '';

        activities.forEach(activity => {
            // Backend'den ImageUrl gelmiyorsa UI Avatars ile güzel bir harf avatarı oluşturuyoruz
            // Backendciye Not: RecentActivityDto'ya string ImageUrl ekleyip yollarsa otomatik bu resim çıkar.
            const defaultImage = `https://ui-avatars.com/api/?name=${encodeURIComponent(activity.productName || 'Urun')}&background=f3f4f6&color=374151&bold=true&rounded=true`;
            const imageUrl = activity.imageUrl || defaultImage;

            const activityDateStr = activity.date || activity.createdAt;
            const activityDate = new Date(activityDateStr);
            const formattedDate = isNaN(activityDate) ? 'Tarih Bilinmiyor' : activityDate.toLocaleDateString('tr-TR', { day: 'numeric', month: 'long', year: 'numeric' });

            // Duruma göre rozet (Badge) rengi seçimi
            let badgeColor = "bg-gray-100 text-gray-700 border-gray-200";
            let iconHtml = `<svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;

            const status = (activity.statusMessage || "").toLowerCase();
            if (status.includes("onayland")) {
                badgeColor = "bg-green-50 text-green-700 border-green-200";
                iconHtml = `<svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
            } else if (status.includes("reddedil")) {
                badgeColor = "bg-red-50 text-red-700 border-red-200";
                iconHtml = `<svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
            } else if (status.includes("beklemede") || status.includes("inceleniyor")) {
                badgeColor = "bg-yellow-50 text-yellow-700 border-yellow-200";
                iconHtml = `<svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
            }

            container.innerHTML += `
            <a href="/student/products" class="flex items-center justify-between p-4 mb-3 bg-white rounded-xl border border-gray-100 hover:border-blue-200 hover:shadow-md transition-all group">
                <div class="flex items-center space-x-4">
                    <!-- Ürün Fotoğrafı / Avatar -->
                    <div class="relative h-12 w-12 rounded-lg overflow-hidden bg-gray-50 border border-gray-100 shrink-0">
                        <img src="${imageUrl}" alt="${activity.productName}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    
                    <!-- Ürün Bilgisi -->
                    <div class="flex flex-col">
                        <h4 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">${activity.productName}</h4>
                        <div class="flex items-center text-xs text-gray-500 mt-1 font-medium">
                            <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            ${formattedDate}
                        </div>
                    </div>
                </div>

                <!-- Durum Rozeti -->
                <div class="flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border ${badgeColor}">
                    ${iconHtml}
                    ${activity.statusMessage}
                </div>
            </a>
        `;
        });
    }
</script>