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
                <a href="/student/wallet"
                    class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer block">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Toplam Kazanç</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-green-600 transition-colors"
                                id="stat-student-earnings">₺0.00</p>
                        </div>
                    </div>
                </a>

                <a href="/student/products"
                    class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer block">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Ürün Sayısı</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors"
                                id="stat-student-products">0</p>
                        </div>
                    </div>
                </a>

                <a href="/student/products?status=approved"
                    class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer block">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Onaylanan</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors"
                                id="stat-student-approved">0</p>
                        </div>
                    </div>
                </a>

                <a href="/student/products?status=pending"
                    class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer block">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center group-hover:bg-yellow-200 transition-colors">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Beklemede</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors"
                                id="stat-student-pending">0</p>
                        </div>
                    </div>
                </a>
            <?php endif; ?>
            <?php if ($current_user['role'] === 'merchant' || $current_user['role'] === 'esnaf'): ?>
                <a href="/merchant/orders"
                    class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer block">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Toplam Sipariş</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors"
                                id="stat-merchant-orders">0</p>
                        </div>
                    </div>
                </a>


                <a href="/merchant/products"
                    class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer block">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Toplam Ürün</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors"
                                id="stat-merchant-products">0</p>
                        </div>
                    </div>
                </a>

                <a href="/merchant/products?status=1"
                    class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer block">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Onaylanan Ürün</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-green-600 transition-colors"
                                id="stat-merchant-approved">0</p>
                        </div>
                    </div>
                </a>

                <a href="/merchant/products?status=0"
                    class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer block">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center group-hover:bg-yellow-200 transition-colors">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Bekleyen Ürün</p>
                            <p class="text-2xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors"
                                id="stat-merchant-pending">0</p>
                        </div>
                    </div>
                </a>
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
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z">
                                </path>
                            </svg>
                            <span>Gelen Siparişler</span>
                        </a>

                        <a href="/orders"
                            class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-indigo-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                    <a href="/account"
                        class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Hesap Ayarları</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    @keyframes fadeSlideIn {
        from {
            opacity: 0;
            transform: translateY(8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Activity Card Skeleton Animation */
    @keyframes pulse-soft {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    .skeleton-box {
        background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    @keyframes shimmer {
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }

    /* Activity Card Hover */
    .activity-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .activity-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -10px rgba(0, 0, 0, 0.08);
        border-color: #e0e7ff;
        /* soft indigo */
    }
</style>



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
            // 1. Backend'in yeni hazırladığı tekil ve hızlı dashboard datasını çek
            const dashboardData = await apiCall('Products/student-dashboard');

            // 2. Üstteki 4'lü İstatistik Kutusunu Güncelle
            const total = dashboardData.totalEarnings || dashboardData.TotalEarnings || 0;
            const thisMonth = dashboardData.thisMonthEarnings || dashboardData.ThisMonthEarnings || 0;

            // Eğer istersen ekranda alt metin olarak Bu Ayki kazancı da ekleyebiliriz:
            document.getElementById('stat-student-earnings').innerHTML = `
                ₺${parseFloat(total).toFixed(2)}
                <span class="block text-xs font-normal text-gray-500 mt-1">Bu Ay: ₺${parseFloat(thisMonth).toFixed(2)}</span>
            `;

            document.getElementById('stat-student-products').textContent = dashboardData.totalProducts || dashboardData.TotalProducts || 0;
            document.getElementById('stat-student-approved').textContent = dashboardData.approvedProducts || dashboardData.ApprovedProducts || 0;
            document.getElementById('stat-student-pending').textContent = dashboardData.pendingProducts || dashboardData.PendingProducts || 0;

            // 3. SON AKTİVİTELERİ DOLDUR (Backend zaten 5 aktivite gönderiyor)
            const activities = dashboardData.recentActivities || dashboardData.RecentActivities || [];

            // GÖRSEL EŞLEŞTİRME: Backend DTO'da görsel olmadığı için, öğrencinin ürünlerini getirip resimleri haritalıyoruz
            let myProducts = [];
            try {
                const prodData = await apiCall('Products/my-products');
                myProducts = Array.isArray(prodData) ? prodData : (prodData.data || []);
            } catch (err) { }

            if (activities.length > 0) {
                const mappedActivities = activities.map(a => {
                    const pId = a.id || a.Id || a.productId || a.ProductId;
                    const matchedProduct = myProducts.find(p => p.id === pId);
                    const finalImage = (matchedProduct && (matchedProduct.imageUrl || matchedProduct.ImageUrl)) 
                                        ? (matchedProduct.imageUrl || matchedProduct.ImageUrl) 
                                        : (a.imageUrl || a.ImageUrl || null);

                    return {
                        id: pId,
                        productName: a.productName || a.ProductName || 'İsimsiz Ürün',
                        imageUrl: finalImage,
                        date: a.date || a.Date || new Date().toISOString(),
                        statusMessage: a.statusMessage || a.StatusMessage || 'İşlem'
                    };
                });
                renderActivities(mappedActivities);
            } else {
                showEmptyActivities();
            }

        } catch (e) {
            console.error('Öğrenci verileri yüklenirken hata:', e);
            showEmptyActivities();
        }
    }

    async function loadCustomerStats(token) {
        try {
            // Backend GET /api/Orders zaten müşteri siparişlerini döner
            const ordersResp = await apiCall('orders');
            const orders = Array.isArray(ordersResp) ? ordersResp : (ordersResp.data || []);

            const totalOrders = orders.length;
            const totalSpent = orders.reduce((sum, o) => sum + (o.totalAmount || 0), 0);
            const supportTotal = orders.reduce((sum, o) => sum + (o.studentSupportAmount || 0), 0);

            const statOrders = document.getElementById('stat-customer-orders');
            const statSpent = document.getElementById('stat-customer-spent');
            const statSupport = document.getElementById('stat-customer-support');

            if (statOrders) statOrders.textContent = totalOrders;
            if (statSpent) statSpent.textContent = `₺${totalSpent.toFixed(2)}`;
            if (statSupport) statSupport.textContent = `₺${supportTotal.toFixed(2)}`;

            // Favoriler sayısını güncelle
            try {
                const favsResp = await apiCall('Favorites');
                const favCount = Array.isArray(favsResp) ? favsResp.length : (favsResp.data?.length || 0);
                const statFavs = document.getElementById('stat-customer-favorites');
                if (statFavs) statFavs.textContent = favCount;
            } catch (e) { /* favoriler yüklenemezse sayacı 0 bırak */ }

            // Son aktiviteleri son 5 sipariş olarak göster
            const activities = orders.slice(0, 5).map(o => ({
                id: o.id,
                description: `Sipariş #${o.orderNumber || o.id}`,
                type: 'order_' + (o.status || 'received'),
                statusMessage: o.status === 'delivered' ? 'Teslim Edildi' : (o.status === 'shipped' ? 'Kargoda' : 'Beklemede'),
                date: o.createdAt,
                imageUrl: null
            }));

            if (activities.length > 0) renderActivities(activities);
            else showEmptyActivities();

        } catch (e) {
            console.error('Customer stats hatası:', e);
            showEmptyActivities();
        }
    }


    async function loadMerchantStats(token) {
        try {
            const data = await apiCall('Merchant/dashboard');

            document.getElementById('stat-merchant-orders').textContent = data.totalOrders || 0;
            document.getElementById('stat-merchant-products').textContent = data.totalProducts || 0;
            document.getElementById('stat-merchant-approved').textContent = data.approvedProducts || 0;
            document.getElementById('stat-merchant-pending').textContent = data.pendingProducts || 0;

            const rawActivities = data.recentActivities || [];
            
            // GÖRSEL EŞLEŞTİRME: Esnafın ürünlerini çekip eşleştirme yapıyoruz
            let merchantProds = [];
            try {
                const prodData = await apiCall('Merchant/products');
                merchantProds = Array.isArray(prodData) ? prodData : (prodData.data || []);
            } catch (err) { }

            if (rawActivities.length > 0) {
                // Esnaf aktivite formatını renderActivities formatına dönüştür
                const mapped = rawActivities.map(a => {
                    const pId = a.productId || a.orderId || null;
                    const matched = merchantProds.find(p => p.id === pId);
                    const finalImage = (matched && (matched.imageUrl || matched.ImageUrl))
                                       ? (matched.imageUrl || matched.ImageUrl)
                                       : (a.imageUrl || a.ImageUrl || null);

                    return {
                        id: pId,
                        productId: a.productId || null,
                        productName: a.description || 'Aktivite',
                        statusMessage: a.type === 'product_approved' ? 'Onaylandı'
                            : a.type === 'product_rejected' ? 'Reddedildi'
                            : a.type === 'product_suspended' ? 'Askıya Alındı'
                                : a.type === 'order_received' ? 'Sipariş Geldi'
                                    : 'Beklemede',
                        type: a.type || '',
                        date: a.date || new Date().toISOString(),
                        imageUrl: finalImage
                    };
                });
                renderActivities(mapped);
            } else {
                showEmptyActivities();
            }
        } catch (e) {
            console.error('Merchant dashboard hatası:', e);
            showEmptyActivities();
        }
    }

    function showSkeletonActivities() {
        const container = document.getElementById('recent_activities_container');
        if (!container) return;
        
        // 3 adet skeleton card basıyoruz
        container.innerHTML = Array(3).fill(`
        <div class="flex items-center gap-4 p-4 mb-3 rounded-2xl border border-gray-100 bg-white shadow-sm animate-pulse">
            <!-- İkon/Görsel Skeleton -->
            <div class="flex-shrink-0 w-12 h-12 bg-gray-200 rounded-xl"></div>
            
            <!-- İçerik Skeleton -->
            <div class="flex-1 min-w-0 pr-4 space-y-2">
                <div class="h-4 bg-gray-200 rounded w-1/3"></div>
                <div class="h-3 bg-gray-100 rounded w-2/3"></div>
            </div>
            
            <!-- Badge Skeleton -->
            <div class="flex-shrink-0 w-20 h-6 bg-gray-100 rounded-full"></div>
        </div>
        `).join('');
    }

    function showEmptyActivities() {
        const container = document.getElementById('recent_activities_container');
        if (!container) return;

        container.innerHTML = `
        <div class="flex flex-col items-center justify-center p-8 text-center bg-gray-50/50 border border-dashed border-gray-200 rounded-2xl">
            <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-[15px] font-semibold text-gray-900 mb-1">Henüz Hareket Yok</h3>
            <p class="text-[13px] text-gray-500 max-w-[250px]">Sipariş veya ürün onayı gibi aktiviteleriniz burada listelenecektir.</p>
        </div>`;
    }

    function renderActivities(activities) {
        const container = document.getElementById('recent_activities_container');
        if (!container) return;
        
        // Sistemdeki aktif rol (student, merchant, admin) çekilir
        const userRole = (typeof getCookie === 'function' ? getCookie('ui_role') : null) || localStorage.getItem('user_role') || 'student';
        
        container.innerHTML = '';

        // Basit XSS koruması
        const escapeHtml = (str) => {
            if (!str) return '';
            return String(str).replace(/[&<>'"]/g, 
                tag => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    "'": '&#39;',
                    '"': '&quot;'
                }[tag] || tag)
            );
        };

        activities.forEach((activity, index) => {
            const title = escapeHtml(activity.description || activity.productName || 'Belirtilmedi');
            const rawStatus = (activity.type || activity.statusMessage || activity.status || '').toLowerCase();

            // 1. Ayarlar (Renkler, Badge, İkonlar ve Rol Bazlı Eşsiz Açıklama)
            let badgeText = 'Bilgi', badgeClass = 'bg-gray-100 text-gray-600 border-gray-200';
            let iconSvg = '';
            let roleDescription = '';

            if (rawStatus.includes('approv') || rawStatus.includes('onay')) {
                badgeText = 'Onaylandı';
                badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                iconSvg = `<svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`;
                
                // ROLE BAZLI AÇIKLAMA:
                roleDescription = userRole === 'student' ? 'Ürününüz başarıyla yayına alındı.'
                                : userRole === 'merchant' ? 'Öğrenci ürününü vitrin için onayladınız.'
                                : 'Ürün sistemde yayına alındı.';

            } else if (rawStatus.includes('reject') || rawStatus.includes('red')) {
                badgeText = 'Reddedildi';
                badgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
                iconSvg = `<svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`;
                
                roleDescription = userRole === 'student' ? 'Ürününüz belirlediğiniz esnaf tarafından reddedildi.'
                                : userRole === 'merchant' ? 'İncelenen öğrenci ürününü reddettiniz.'
                                : 'Ürün onayı sistem tarafından reddedildi.';

            } else if (rawStatus.includes('order') || rawStatus.includes('sipariş') || rawStatus.includes('received')) {
                let badgeTxt = 'Sipariş Geldi';
                // Öğrenci ürünü mü satıldı, yoksa müşteri kendi mi aldı?
                if (userRole === 'customer' || userRole === 'musteri') {
                    badgeTxt = 'Sipariş Verildi';
                    // Müşteri için siparişin alt durumu varsa daha spesifik badge göster
                    if (activity.statusMessage === 'Kargoda') badgeTxt = 'Kargoda';
                    if (activity.statusMessage === 'Teslim Edildi') badgeTxt = 'Teslim Edildi';
                } else if (userRole === 'student') {
                    badgeTxt = 'Ürününüz Satıldı!';
                }
                
                badgeText = badgeTxt;
                badgeClass = 'bg-blue-50 text-blue-700 border-blue-200';
                iconSvg = `<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>`;
                
                roleDescription = userRole === 'student' ? 'Tebrikler! Listelediğiniz ürüne yeni sipariş geldi.'
                                : userRole === 'merchant' ? 'Mağazanıza yeni bir sipariş ulaştı.'
                                : 'Sistemde yeni bir sipariş oluşturuldu.';

            } else if (rawStatus.includes('pend') || rawStatus.includes('bekle')) {
                badgeText = 'Beklemede';
                badgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                iconSvg = `<svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`;
                
                roleDescription = userRole === 'student' ? 'Ürününüz esnaf onayı için sıraya alındı.'
                                : userRole === 'merchant' ? 'İncelemeniz ve onayınız için bekleyen yeni bir ürün var.'
                                : 'Sistemde onay bekleyen işlem mevcut.';
            } else if (rawStatus.includes('suspend') || rawStatus.includes('askı')) {
                badgeText = 'Askıya Alındı';
                badgeClass = 'bg-gray-50 text-gray-600 border-gray-200';
                iconSvg = `<svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`;
                
                roleDescription = userRole === 'student' ? 'Ürününüz platform kuralları gereği incelemeye/askıya alındı.'
                                : userRole === 'merchant' ? 'Öğrencinin ürününü mağazanızdan geçici olarak kaldırdınız.'
                                : 'Ürün sistemde askıya alındı.';
            } else {
                // Default / Generic status fallback
                badgeText = 'İşlemde';
                badgeClass = 'bg-gray-50 text-gray-700 border-gray-200';
                iconSvg = `<svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>`;
                roleDescription = 'Aktivite başarıyla sisteme yansıdı.';
            }

            // 2. Medya Alanı (Görsel Varsa Resmi, Yoksa Durum İkonunu Şık Kutuyla Göster)
            let mediaBlock = '';
            if (activity.imageUrl) {
                mediaBlock = `
                    <img src="${activity.imageUrl}" alt="${title}" 
                         class="w-12 h-12 rounded-xl object-cover border border-gray-100 shadow-[0_2px_8px_rgb(0,0,0,0.04)] hidden" 
                         onload="this.classList.remove('hidden'); this.nextElementSibling.style.display='none';"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                    <div class="w-12 h-12 rounded-xl border border-gray-100 bg-gray-100 animate-pulse flex items-center justify-center"></div>`;
            } else {
                // Arkaplan rengini direkt badgeClass içinden alıyoruz
                const bgClass = badgeClass.split(' ')[0]; // bg-emerald-50 vb.
                mediaBlock = `
                    <div class="w-12 h-12 rounded-xl ${bgClass} border border-gray-100 shadow-[0_2px_8px_rgb(0,0,0,0.04)] flex items-center justify-center">
                        ${iconSvg}
                    </div>`;
            }

            // 3. Tarih
            const rawDate = activity.date || activity.createdAt;
            const dateObj = rawDate ? new Date(rawDate) : null;
            let dateString = 'Tarih bilinmiyor';
            if (dateObj && !isNaN(dateObj)) {
                // Örn: "15 Nisan, 14:30" formatında gösterip daha modern yapıyoruz
                dateString = dateObj.toLocaleDateString('tr-TR', { day: 'numeric', month: 'long', hour: '2-digit', minute: '2-digit' });
            }

            // 4. Hedef Link (Tıklanabilir Card İçin)
            let targetUrl = '#';
            if (rawStatus.includes('order') || rawStatus.includes('sipariş') || rawStatus.includes('received')) {
                targetUrl = (userRole === 'merchant' || userRole === 'esnaf') ? '/merchant/orders' : '/orders';
            } else if (activity.id || activity.productId || activity.referenceId) {
                const pId = activity.productId || activity.id || activity.referenceId;
                
                if (userRole === 'merchant' || userRole === 'esnaf') {
                    // Esnaf ürün aktivitelerine (onaylama vs.) tıklarsa ürün onayı sayfasına atsın
                    let tab = '';
                    if (rawStatus.includes('pend') || rawStatus.includes('bekle')) tab = '?status=0';
                    else if (rawStatus.includes('approv') || rawStatus.includes('onay')) tab = '?status=1';
                    else if (rawStatus.includes('reject') || rawStatus.includes('red')) tab = '?status=2';
                    
                    targetUrl = '/merchant/products' + tab;
                } else if (userRole === 'student' || userRole === 'ogrenci') {
                    // Öğrenci kendi ürün işlemlerine tıklarsa
                    let statusQuery = '';
                    if (rawStatus.includes('pend') || rawStatus.includes('bekle')) statusQuery = '?status=pending';
                    else if (rawStatus.includes('approv') || rawStatus.includes('onay')) statusQuery = '?status=approved';
                    
                    targetUrl = '/student/products' + statusQuery;
                } else {
                    targetUrl = '/products/' + pId;
                }
            }

            const delay = index * 50; // Sıralı Yükleme Efekti

            // 5. Card Render İşlemi
            container.innerHTML += `
            <a href="${targetUrl}" 
               class="group flex items-start sm:items-center p-4 mb-3 border border-gray-100 rounded-2xl bg-white 
                      hover:border-blue-200 hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-0.5 
                      transition-all duration-300 opacity-0 relative overflow-hidden"
               style="animation: fadeSlideIn 0.35s ${delay}ms ease forwards;">
                
                <!-- Sol: İkon / Görsel -->
                <div class="relative flex-shrink-0 mr-4">
                    ${mediaBlock}
                </div>

                <!-- Orta: Bilgiler -->
                <div class="flex-1 min-w-0 pr-2">
                    <div class="flex items-center justify-between mb-0.5 sm:mb-1">
                        <h4 class="text-[15px] font-bold text-gray-900 group-hover:text-blue-600 transition-colors truncate">
                            ${title}
                        </h4>
                        <!-- Mobil görünümde sağda, genişte gizli -->
                        <span class="text-[11px] font-medium text-gray-400 block sm:hidden">${dateString.split(',')[0]}</span>
                    </div>
                    
                    <p class="text-[13px] text-gray-500 mt-0.5 line-clamp-1 sm:line-clamp-2">
                        ${roleDescription}
                    </p>
                    <div class="flex items-center gap-1.5 text-[12px] text-gray-400 mt-1.5 font-medium hidden sm:flex">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>${dateString}</span>
                    </div>
                </div>

                <!-- Sağ: Badge -->
                <div class="flex-shrink-0 self-center ml-2">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[12px] font-semibold border shadow-sm ${badgeClass}">
                        ${badgeText}
                    </span>
                </div>
                
            </a>`;
        });
    }

    // Animasyon için yardımcı (escapeHtml zaten dashboard scope'unda olmayabilir)
    function escapeHtmlLocal(text) {
        const d = document.createElement('div');
        d.textContent = String(text || '');
        return d.innerHTML;
    }

</script>