<?php
// Admin kontrolü
if (!$current_user || $current_user['role'] !== 'admin') {
    header('Location: /login');
    exit;
}
?>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- 401 Token Expired Warning Banner -->
        <div id="auth-error-banner" class="hidden mb-6 bg-red-50 border border-red-200 rounded-2xl p-5 flex items-start space-x-4">
            <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-red-800 font-semibold text-lg">Oturum Süresi Doldu</h3>
                <p class="text-red-700 text-sm mt-1">JWT token süresi dolmuş veya geçersiz (401 Unauthorized). İstatistikler yüklenemiyor.</p>
                <p class="text-red-600 text-xs mt-2">Lütfen çıkış yapıp tekrar giriş yapın.</p>
            </div>
            <div class="flex-shrink-0">
                <button onclick="reLogin()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Yeniden Giriş Yap
                </button>
            </div>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
                    <p class="text-gray-600 text-lg">EsnappGO Platform Yönetim Merkezi</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Hoş geldiniz</p>
                        <p class="font-semibold text-gray-900">
                            <?php echo htmlspecialchars($current_user['full_name']); ?>
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                        <span
                            class="text-white font-bold text-lg"><?php echo strtoupper(substr($current_user['full_name'], 0, 1)); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <a href="/admin/users" class="block bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl hover:border-blue-200 transition-all cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Toplam Kullanıcı</p>
                        <p class="text-3xl font-bold text-gray-900" id="total-users">-</p>
                        <p class="text-xs text-green-600 mt-1" id="users-growth">-</p>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Total Products -->
            <a href="/admin/products" class="block bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl hover:border-green-200 transition-all cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Aktif Ürün</p>
                        <p class="text-3xl font-bold text-gray-900" id="total-products">-</p>
                        <p class="text-xs text-blue-600 mt-1" id="products-pending">Onay bekleyen: <span
                                id="pending-products">-</span></p>
                    </div>
                    <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Total Orders -->
            <a href="/admin/orders" class="block bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl hover:border-purple-200 transition-all cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Toplam Sipariş</p>
                        <p class="text-3xl font-bold text-gray-900" id="total-orders">-</p>
                        <p class="text-xs text-purple-600 mt-1" id="orders-today">Bugün: <span
                                id="today-orders">-</span></p>
                    </div>
                    <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Total Revenue -->
            <a href="/admin/reports" class="block bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl hover:border-yellow-200 transition-all cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Toplam Gelir</p>
                        <p class="text-3xl font-bold text-gray-900" id="total-revenue">₺-</p>
                        <p class="text-xs text-yellow-600 mt-1" id="revenue-month">Bu ay: <span
                                id="month-revenue">₺-</span></p>
                    </div>
                    <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                            </path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- User Type Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Students -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Öğrenciler</h3>
                            <p class="text-sm text-gray-500">Fotoğraf çeken öğrenciler</p>
                        </div>
                    </div>
                    <a href="/admin/users?role=ogrenci" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        Detay →
                    </a>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Toplam Öğrenci:</span>
                        <span class="font-semibold" id="student-count">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Aktif Öğrenci:</span>
                        <span class="font-semibold text-green-600" id="active-students">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Bu Ay Katılan:</span>
                        <span class="font-semibold text-blue-600" id="new-students">-</span>
                    </div>
                </div>
            </div>

            <!-- Merchants -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Esnaflar</h3>
                            <p class="text-sm text-gray-500">Ürün onaylayan esnaflar</p>
                        </div>
                    </div>
                    <a href="/admin/users?role=esnaf" class="text-green-600 hover:text-green-700 text-sm font-medium">
                        Detay →
                    </a>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Toplam Esnaf:</span>
                        <span class="font-semibold" id="merchant-count">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Aktif Mağaza:</span>
                        <span class="font-semibold text-green-600" id="active-shops">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Bu Ay Katılan:</span>
                        <span class="font-semibold text-green-600" id="new-merchants">-</span>
                    </div>
                </div>
            </div>

            <!-- Customers -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Müşteriler</h3>
                            <p class="text-sm text-gray-500">Alışveriş yapan müşteriler</p>
                        </div>
                    </div>
                    <a href="/admin/users?role=musteri"
                        class="text-purple-600 hover:text-purple-700 text-sm font-medium">

                        Detay →
                    </a>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Toplam Müşteri:</span>
                        <span class="font-semibold" id="customer-count">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Aktif Müşteri:</span>
                        <span class="font-semibold text-purple-600" id="active-customers">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Bu Ay Katılan:</span>
                        <span class="font-semibold text-purple-600" id="new-customers">-</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Recent Users -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-gray-900">Son Kayıt Olan Kullanıcılar</h3>
                        <a href="/admin/users" class="text-blue-600 hover:text-blue-700 font-medium">Tümünü Gör</a>
                    </div>
                </div>
                <div class="p-6">
                    <div id="recent-users" class="space-y-4">
                        <!-- Loading skeleton -->
                        <div class="animate-pulse">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gray-200 rounded-full"></div>
                                <div class="flex-1">
                                    <div class="h-4 bg-gray-200 rounded mb-2"></div>
                                    <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-gray-900">Son Siparişler</h3>
                        <a href="/admin/orders" class="text-purple-600 hover:text-purple-700 font-medium">Tümünü Gör</a>
                    </div>
                </div>
                <div class="p-6">
                    <div id="recent-orders" class="space-y-4">
                        <!-- Loading skeleton -->
                        <div class="animate-pulse">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gray-200 rounded-xl"></div>
                                <div class="flex-1">
                                    <div class="h-4 bg-gray-200 rounded mb-2"></div>
                                    <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Sections -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- User Management -->
            <a href="/admin/users"
                class="group block p-8 bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:border-blue-200 transition-all">
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-colors">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Kullanıcı Yönetimi</h4>
                    <p class="text-gray-600 mb-4">Öğrenci, esnaf ve müşteri kayıtları</p>
                    <div class="flex justify-center">
                        <span class="text-blue-600 font-medium group-hover:translate-x-1 transition-transform">Yönet
                            →</span>
                    </div>
                </div>
            </a>

            <!-- Product Management -->
            <a href="/admin/products"
                class="group block p-8 bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:border-green-200 transition-all">
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition-colors">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Ürün Yönetimi</h4>
                    <p class="text-gray-600 mb-4">Ürün onaylama ve düzenleme</p>
                    <div class="flex justify-center">
                        <span class="text-green-600 font-medium group-hover:translate-x-1 transition-transform">Yönet
                            →</span>
                    </div>
                </div>
            </a>

            <!-- Order Management -->
            <a href="/admin/orders"
                class="group block p-8 bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:border-purple-200 transition-all">
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-200 transition-colors">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Sipariş Yönetimi</h4>
                    <p class="text-gray-600 mb-4">Sipariş takibi ve yönetimi</p>
                    <div class="flex justify-center">
                        <span class="text-purple-600 font-medium group-hover:translate-x-1 transition-transform">Yönet
                            →</span>
                    </div>
                </div>
            </a>

            <!-- Reports -->
            <a href="/admin/reports"
                class="group block p-8 bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:border-yellow-200 transition-all">
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-yellow-200 transition-colors">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Raporlar</h4>
                    <p class="text-gray-600 mb-4">Satış ve gelir raporları</p>
                    <div class="flex justify-center">
                        <span
                            class="text-yellow-600 font-medium group-hover:translate-x-1 transition-transform">Görüntüle
                            →</span>
                    </div>
                </div>
            </a>

            <!-- Survey Results -->
            <a href="/admin/survey-results"
                class="group block p-8 bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:border-pink-200 transition-all">
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-pink-200 transition-colors">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Anket Sonuçları</h4>
                    <p class="text-gray-600 mb-4">Öğrenci gelir modeli anketi</p>
                    <div class="flex justify-center">
                        <span class="text-pink-600 font-medium group-hover:translate-x-1 transition-transform">İncele
                            →</span>
                    </div>
                </div>
            </a>

            <!-- Category Management -->
            <a href="/admin/categories"
                class="group block p-8 bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl hover:border-teal-200 transition-all">
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-teal-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-teal-200 transition-colors">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Kategori Yönetimi</h4>
                    <p class="text-gray-600 mb-4">Kategori ekleme ve düzenleme</p>
                    <div class="flex justify-center">
                        <span class="text-teal-600 font-medium group-hover:translate-x-1 transition-transform">Yönet
                            →</span>
                    </div>
                </div>
            </a>

            <!-- System Health -->
            <div class="group p-8 bg-white rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-all">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Sistem Durumu</h4>
                    <p class="text-gray-600 mb-4">Platform sağlığı ve performans</p>
                    <div class="flex justify-center items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-green-600 font-medium">Çevrimiçi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Timeline -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Son Aktiviteler</h3>
                <p class="text-gray-600 mt-1">Platform genelindeki son hareketler</p>
            </div>
            <div class="p-6">
                <div id="activity-timeline" class="space-y-6">
                    <!-- Loading skeleton -->
                    <div class="animate-pulse">
                        <div class="flex items-start space-x-4">
                            <div class="w-10 h-10 bg-gray-200 rounded-full"></div>
                            <div class="flex-1">
                                <div class="h-4 bg-gray-200 rounded mb-2"></div>
                                <div class="h-3 bg-gray-200 rounded w-2/3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        checkTokenAndInit();
    });

    function reLogin() {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user_name');
        localStorage.removeItem('user_email');
        localStorage.removeItem('user_role');
        // PHP session'u da temizle, yoksa /login sayfası /dashboard'a yönlendirir
        fetch('/api/auth/logout', { method: 'POST', credentials: 'include' })
            .finally(() => { window.location.href = '/login'; });
    }

    function showAuthError() {
        const banner = document.getElementById('auth-error-banner');
        if (banner) banner.classList.remove('hidden');
        // Set all stat fields to '-' to show they're not loaded
        ['total-users','total-products','total-orders','total-revenue',
         'pending-products','today-orders','month-revenue',
         'student-count','active-students','new-students',
         'merchant-count','active-shops','new-merchants',
         'customer-count','active-customers','new-customers'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = '—';
        });
        const recentUsers = document.getElementById('recent-users');
        if (recentUsers) recentUsers.innerHTML = '<p class="text-gray-400 text-center py-6 text-sm">Oturum sona erdi. Yeniden giriş gerekli.</p>';
        const recentOrders = document.getElementById('recent-orders');
        if (recentOrders) recentOrders.innerHTML = '<p class="text-gray-400 text-center py-6 text-sm">Oturum sona erdi. Yeniden giriş gerekli.</p>';
        const timeline = document.getElementById('activity-timeline');
        if (timeline) timeline.innerHTML = '<p class="text-gray-400 text-center py-6 text-sm">Oturum sona erdi. Yeniden giriş gerekli.</p>';
    }

    async function checkTokenAndInit() {
        const token = localStorage.getItem('auth_token');

        if (!token) {
            // Token yok: login'e yönlendir değil — PHP session aktifse /login → /dashboard döngüsü olur.
            // Bunun yerine auth banner'u göster ve kullanıcıdan manuel logout yapmasını iste.
            showAuthError();
            return;
        }

        // Token var — direkt dashboard'u yükle
        initDashboard();
    }

    async function initDashboard() {
        try {
            loadAdminStats();
            loadActivityTimeline();
        } catch (error) {
            console.error('İstatistikler veya aktiviteler çekilemedi', error);
        }
    }

    async function loadAdminStats() {
        const token = localStorage.getItem('auth_token');

        // 1. Admin/stats endpoint'ini raw fetch ile dene (401 ayırt etmek için)
        let stats = {};
        let usedFallback = false;

        try {
            const rawRes = await fetch(`${API_BASE}/api/Admin/stats`, {
                headers: { 'Authorization': 'Bearer ' + token, 'Content-Type': 'application/json' }
            });

            if (rawRes.status === 401) {
                showAuthError();
                return;
            }

            if (rawRes.ok) {
                const json = await rawRes.json();
                const data = json.data || json || {};
                if (data.totalUsers !== undefined) {
                    stats = data;
                } else {
                    usedFallback = true;
                }
            } else {
                usedFallback = true;
            }
        } catch (e) {
            console.warn('[Admin/stats] Erişilemez, fallback deniyor.', e.message);
            usedFallback = true;
        }

        // 2. Fallback: bireysel endpointlerden topla
        if (usedFallback) {
            stats = await getFallbackStats();
            if (stats._authError) return; // 401 → banner gösterildi
        }

        // 3. DOM'u güncelle
        renderDashboardStats(stats);

        // 4. Son kullanıcılar ve siparişler
        loadRecentUsers(stats.recentUsers || stats.RecentUsers || stats.fallbackUsers || []);
        loadRecentOrders(stats.recentOrders || stats.RecentOrders || null);
    }

    function renderDashboardStats(stats) {
        const set = (id, val, prefix = '') => {
            const el = document.getElementById(id);
            if (!el) return;
            el.textContent = (val !== undefined && val !== null) ? prefix + val : '—';
        };

        set('total-users',    stats.totalUsers !== undefined ? Number(stats.totalUsers).toLocaleString() : undefined);
        set('total-products', stats.activeProducts !== undefined ? Number(stats.activeProducts).toLocaleString() : undefined);
        set('total-orders',   stats.totalOrders !== undefined ? Number(stats.totalOrders).toLocaleString() : undefined);
        set('total-revenue',  stats.totalRevenue !== undefined ? `₺${parseFloat(stats.totalRevenue).toFixed(2)}` : undefined);

        set('pending-products', stats.pendingProducts);
        set('today-orders',     stats.todayOrders);
        set('month-revenue',    stats.thisMonthRevenue !== undefined ? `₺${parseFloat(stats.thisMonthRevenue).toFixed(2)}` : undefined);

        updateRoleStats('student',  stats.students  || { total: stats.studentCount,  active: stats.activeStudents });
        updateRoleStats('merchant', stats.merchants || { total: stats.merchantCount, active: stats.activeMerchants });
        updateRoleStats('customer', stats.customers || { total: stats.customerCount, active: stats.activeCustomers });
    }

    async function getFallbackStats() {
        const token = localStorage.getItem('auth_token');
        const fallbacks = {
            totalUsers: 0, activeProducts: 0, totalOrders: 0, totalRevenue: 0,
            fallbackUsers: [], studentCount: 0, merchantCount: 0, customerCount: 0
        };

        const [usersRes, productsRes, ordersRes] = await Promise.allSettled([
            fetch(`${API_BASE}/api/Admin/users`,    { headers: { 'Authorization': 'Bearer ' + token } }),
            fetch(`${API_BASE}/api/Admin/products`, { headers: { 'Authorization': 'Bearer ' + token } }),
            fetch(`${API_BASE}/api/Admin/orders`,   { headers: { 'Authorization': 'Bearer ' + token } })
        ]);

        // Tüm cevaplar 401 mi? → Token geçersiz
        const statuses = [usersRes, productsRes, ordersRes].map(r =>
            r.status === 'fulfilled' ? r.value.status : 0
        );
        if (statuses.every(s => s === 401)) {
            console.error('[Admin] Tüm endpointler 401. Token geçersiz, auth banner gösteriliyor.');
            showAuthError();
            return { _authError: true };
        }

        const parseRes = async (result) => {
            if (result.status !== 'fulfilled' || !result.value.ok) return [];
            try { const d = await result.value.json(); return Array.isArray(d) ? d : (d.data || []); }
            catch { return []; }
        };

        const [users, products, orders] = await Promise.all([
            parseRes(usersRes), parseRes(productsRes), parseRes(ordersRes)
        ]);

        fallbacks.totalUsers     = users.length;
        fallbacks.activeProducts = products.filter(p => p.isActive || p.status === 'approved').length || products.length;
        fallbacks.totalOrders    = orders.length;
        fallbacks.fallbackUsers  = users;
        fallbacks.studentCount   = users.filter(u => u.role === 'student'  || u.role === 'ogrenci').length;
        fallbacks.merchantCount  = users.filter(u => u.role === 'merchant' || u.role === 'esnaf').length;
        fallbacks.customerCount  = users.filter(u => u.role === 'customer' || u.role === 'musteri').length;
        fallbacks.totalRevenue   = orders.reduce((s, o) => s + parseFloat(o.totalAmount || 0), 0);

        return fallbacks;
    }

    // Rol bazlı istatistik kartlarını güncelle (RoleStatsDto: total, active, newThisMonth)
    function updateRoleStats(roleKey, dto) {
        const map = {
            student:  { count: 'student-count',   active: 'active-students', newMonth: 'new-students'   },
            merchant: { count: 'merchant-count',  active: 'active-shops',    newMonth: 'new-merchants'  },
            customer: { count: 'customer-count',  active: 'active-customers',newMonth: 'new-customers'  }
        };
        const ids = map[roleKey];
        if (!ids) return;
        if (document.getElementById(ids.count))    document.getElementById(ids.count).textContent    = dto.total        ?? '—';
        if (document.getElementById(ids.active))   document.getElementById(ids.active).textContent   = dto.active       ?? '—';
        if (document.getElementById(ids.newMonth)) document.getElementById(ids.newMonth).textContent = dto.newThisMonth  ?? '—';
    }

    // Eski fonksiyon — artık stats endpoint hallediyor
    function loadUserBreakdown() { }
    function updateUserBreakdownFromCache() { }


    function loadRecentUsers(usersData = []) {
        try {
            // Data zaten recentUsers ise sadece 5 tanesini göster
            const users = usersData.slice(0, 5);

            const container = document.getElementById('recent-users');
            if (!container) return;

            if (users.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center py-4">Henüz kullanıcı yok</p>';
                return;
            }

            container.innerHTML = users.map(user => `
            <div class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-50 transition-colors">
                <div class="w-12 h-12 bg-gradient-to-r ${getRoleGradient(user.role)} rounded-full flex items-center justify-center">
                    <span class="text-white font-bold">${(user.fullName || '?').charAt(0).toUpperCase()}</span>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-900">${escapeHtml(user.fullName || '')}</p>
                    <p class="text-sm text-gray-500">${escapeHtml(user.email || '')}</p>
                    <p class="text-xs text-gray-400">${formatDate(user.createdAt)}</p>
                </div>
                <div class="text-right">
                    <span class="badge badge-${getRoleBadgeClass(user.role)}">${getRoleName(user.role)}</span>
                    <div class="mt-1">
                        <span class="text-xs ${user.isActive ? 'text-green-600' : 'text-red-600'}">${user.isActive ? 'Aktif' : 'Pasif'}</span>
                    </div>
                </div>
            </div>
        `).join('');

        } catch (error) {
            console.error('Error loading recent users:', error);
            const container = document.getElementById('recent-users');
            if (container) container.innerHTML = '<p class="text-gray-500 text-center py-4">Kullanıcılar yüklenemedi</p>';
        }
    }

    async function loadRecentOrders(recentOrdersData = null) {
        try {
            let orders = recentOrdersData;

            // Eğer istatistiklerden gelmediyse fallback olarak ?limit=5 parametresi ile endpointten çek
            if (!orders) {
                const response = await apiCall('Admin/orders?limit=5');
                const allOrders = Array.isArray(response) ? response : (response.data || []);
                orders = allOrders.slice(0, 5);
            }

            const container = document.getElementById('recent-orders');
            if (!orders || !orders.length) {
                container.innerHTML = '<p class="text-gray-500 text-center py-4">Henüz sipariş yok</p>';
                return;
            }
            container.innerHTML = orders.map(order => `

            <div class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-50 transition-colors">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-900">${order.orderNumber || order.id}</p>
                    <p class="text-sm text-gray-500">${escapeHtml(order.customerName || '')}</p>
                    <p class="text-xs text-gray-400">${formatDate(order.createdAt)}</p>
                </div>
                <div class="text-right">
                    <p class="font-semibold text-gray-900">₺${parseFloat(order.totalAmount || 0).toFixed(2)}</p>
                    <span class="badge badge-${getStatusBadgeClass(order.status)}">${getStatusText(order.status)}</span>
                </div>
            </div>
        `).join('');

        } catch (error) {
            console.error('Error loading recent orders:', error);
            document.getElementById('recent-orders').innerHTML = '<p class="text-gray-500 text-center py-4">Siparişler yüklenemedi</p>';
        }
    }

    async function loadActivityTimeline() {
        try {
            // .NET API üzerinden verileri çekiyoruz
            const response = await apiCall('Admin/activities');
            const activities = Array.isArray(response) ? response : (response.data || []);

            const container = document.getElementById('activity-timeline');

            if (activities.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center py-4">Henüz aktivite yok</p>';
                return;
            }

            // Backend JsonStringEnumConverter ile string döndürüyor (örn: "UserRegistered")
            // Hem string hem sayısal enum değerlerini destekliyoruz
            const colorByNum  = { 0: 'blue', 1: 'green', 2: 'purple', 3: 'teal', 4: 'orange', 5: 'red', 6: 'yellow' };
            const iconByNum   = { 0: 'user-plus', 1: 'plus', 2: 'check', 3: 'shield-check', 4: 'check', 5: 'shield-check', 6: 'plus' };
            const colorByStr  = {
                'UserRegistered': 'blue', 'user_registered': 'blue',
                'ProductAdded': 'green', 'product_added': 'green',
                'ProductApproved': 'purple', 'product_approved': 'purple',
                'OrderPlaced': 'teal', 'order_placed': 'teal',
                'ProductSuspended': 'red', 'product_suspended': 'red',
                'ProductRejected': 'red', 'product_rejected': 'red'
            };
            const iconByStr   = {
                'UserRegistered': 'user-plus', 'user_registered': 'user-plus',
                'ProductAdded': 'plus', 'product_added': 'plus',
                'ProductApproved': 'check', 'product_approved': 'check',
                'OrderPlaced': 'shield-check', 'order_placed': 'shield-check',
                'ProductSuspended': 'shield-check', 'product_suspended': 'shield-check',
                'ProductRejected': 'shield-check', 'product_rejected': 'shield-check'
            };

            container.innerHTML = activities.map(activity => {
                const typeVal = activity.type ?? activity.Type;
                const color = colorByNum[typeVal] || colorByStr[typeVal] || 'blue';
                const icon  = iconByNum[typeVal]  || iconByStr[typeVal]  || 'plus';
                return `
                <div class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-${color}-100 rounded-full flex items-center justify-center flex-shrink-0">
                        ${getActivityIcon(icon, color)}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900">${escapeHtml(activity.title || activity.Title || 'Aktivite')}</p>
                        <p class="text-xs text-gray-500 mt-1">${formatDate(activity.createdAt || activity.CreatedAt)}</p>
                    </div>
                </div>`;
            }).join('');


        } catch (error) {
            console.error('Error loading activity timeline:', error);
            const container = document.getElementById('activity-timeline');
            if (container) {
                container.innerHTML = '<p class="text-gray-500 text-center py-4">Aktiviteler şu an yüklenemiyor (Backend hazır değil)</p>';
            }
        }

    }

    // Helper functions
    function getRoleGradient(role) {
        const gradients = {
            student: 'from-blue-500 to-blue-600', ogrenci: 'from-blue-500 to-blue-600',
            merchant: 'from-green-500 to-green-600', esnaf: 'from-green-500 to-green-600',
            customer: 'from-purple-500 to-purple-600', musteri: 'from-purple-500 to-purple-600',
            admin: 'from-red-500 to-red-600'
        };
        return gradients[role] || 'from-gray-500 to-gray-600';
    }

    function getRoleName(role) {
        const roleNames = {
            customer: 'Müşteri', musteri: 'Müşteri',
            student: 'Öğrenci', ogrenci: 'Öğrenci',
            merchant: 'Esnaf', esnaf: 'Esnaf',
            admin: 'Admin'
        };
        return roleNames[role] || role;
    }

    function getRoleBadgeClass(role) {
        const badgeClasses = {
            customer: 'primary', musteri: 'primary',
            student: 'success', ogrenci: 'success',
            merchant: 'warning', esnaf: 'warning',
            admin: 'error'
        };
        return badgeClasses[role] || 'gray';
    }

    function getStatusText(status) {
        const statusTexts = {
            pending: 'Beklemede',
            paid: 'Ödendi',
            shipped: 'Kargoya Verildi',
            delivered: 'Teslim Edildi',
            completed: 'Tamamlandı',
            cancelled: 'İptal Edildi'
        };
        return statusTexts[status] || status;
    }

    function getStatusBadgeClass(status) {
        const badgeClasses = {
            pending: 'warning',
            paid: 'primary',
            shipped: 'primary',
            delivered: 'success',
            completed: 'success',
            cancelled: 'error'
        };
        return badgeClasses[status] || 'gray';
    }

    function getActivityIcon(icon, color) {
        const icons = {
            'user-plus': `<svg class="w-5 h-5 text-${color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>`,
            'plus': `<svg class="w-5 h-5 text-${color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>`,
            'check': `<svg class="w-5 h-5 text-${color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`,
            'shield-check': `<svg class="w-5 h-5 text-${color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>`
        };
        return icons[icon] || `<svg class="w-5 h-5 text-${color}-600" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"></circle></svg>`;
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diff = now - date;

        if (diff < 60000) return 'Az önce';
        if (diff < 3600000) return `${Math.floor(diff / 60000)} dakika önce`;
        if (diff < 86400000) return `${Math.floor(diff / 3600000)} saat önce`;

        return date.toLocaleDateString('tr-TR', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }

    function isThisMonth(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        return date.getMonth() === now.getMonth() && date.getFullYear() === now.getFullYear();
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text || '';
        return div.innerHTML;
    }
</script>