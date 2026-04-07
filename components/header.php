<header class="sticky top-0 z-50">
    <!-- Top Bar -->
    <div class="bg-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-10 text-sm">
                <div class="hidden sm:flex items-center space-x-6 text-slate-400">
                    <a href="tel:05336160218" class="flex items-center hover:text-white transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        0533 616 02 18
                    </a>
                    <a href="mailto:info@esnappgo.com" class="flex items-center hover:text-white transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        info@esnappgo.com
                    </a>
                </div>
                <div
                    class="flex items-center justify-center sm:justify-end w-full sm:w-auto text-emerald-400 font-medium">
                    <span class="mr-2">🎓</span>
                    <span>Türkiye'nin İlk Öğrenci Destekli E-Ticaret Platformu</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Logo -->
                <a href="/" class="flex items-center group">
                    <div
                        class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:bg-blue-700 transition-colors">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h1 class="text-2xl font-bold text-slate-800">
                            Esnapp<span class="text-blue-600">GO</span>
                        </h1>
                        <p class="text-xs text-slate-500 font-medium">Öğrenci Destekli E-Ticaret</p>
                    </div>
                </a>

                <!-- Main Navigation - Desktop -->
                <nav class="hidden lg:flex items-center space-x-1">
                    <a href="/products"
                        class="flex items-center px-5 py-2.5 text-base font-medium rounded-lg transition-colors <?php echo ($current_page === 'products') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'; ?>">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Ürünler
                    </a>
                    <?php if ($current_user && $current_user['role'] !== 'customer' && $current_user['role'] !== 'musteri'): ?>
                        <a href="/dashboard"
                            class="flex items-center px-5 py-2.5 text-base font-medium rounded-lg transition-colors <?php echo ($current_page === 'dashboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'; ?>">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                </path>
                            </svg>
                            Dashboard
                        </a>
                    <?php endif; ?>

                    <?php if (!$current_user || $current_user['role'] === 'customer' || $current_user['role'] === 'musteri'): ?>
                        <a href="/student-intro"
                            class="flex items-center px-5 py-2.5 text-base font-medium rounded-lg transition-colors <?php echo ($current_page === 'student-intro') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'; ?>">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                            Öğrenci Ol
                        </a>
                    <?php endif; ?>


                    <a href="/about"
                        class="flex items-center px-5 py-2.5 text-base font-medium rounded-lg transition-colors <?php echo ($current_page === 'about') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'; ?>">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Hakkımızda
                    </a>

                    <a href="/contact"
                        class="flex items-center px-5 py-2.5 text-base font-medium rounded-lg transition-colors <?php echo ($current_page === 'contact') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'; ?>">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        İletişim
                    </a>
                </nav>

                <!-- Right Side Actions -->
                <div class="flex items-center space-x-3">
                    <!-- Search Button -->
                    <button
                        class="p-2.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                        title="Ara">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>

                    <?php if ($current_user): ?>
                        <!-- Cart Button -->
                        <a href="/cart"
                            class="relative p-2.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                            title="Sepetim">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span id="cart-count"
                                class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-xs font-bold rounded-full min-w-[20px] h-[20px] flex items-center justify-center"
                                style="display: none;">0</span>
                        </a>

                        <!-- Favorites Button -->
                        <a href="/favorites"
                            class="hidden sm:flex p-2.5 text-slate-500 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                            title="Favorilerim">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </a>

                        <!-- Divider -->
                        <div class="hidden sm:block w-px h-8 bg-slate-200 mx-1"></div>

                        <!-- User Profile Menu -->
                        <div class="relative">
                            <button onclick="toggleUserMenu()"
                                class="flex items-center space-x-2 py-2 px-3 text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">
                                <div
                                    class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white font-semibold text-base">
                                    <?php echo mb_strtoupper(mb_substr($current_user['full_name'], 0, 1, 'UTF-8'), 'UTF-8'); ?>
                                </div>
                                <div class="hidden md:block text-left">
                                    <div class="text-base font-medium text-slate-800">
                                        <?php echo htmlspecialchars(explode(' ', $current_user['full_name'])[0]); ?>
                                    </div>
                                    <div class="text-sm text-slate-500">
                                        <?php echo htmlspecialchars($current_user['role'] === 'esnaf' || $current_user['role'] === 'merchant' ? 'Esnaf' : ($current_user['role'] === 'ogrenci' || $current_user['role'] === 'student' ? 'Öğrenci' : ($current_user['role'] === 'admin' ? 'Admin' : 'Müşteri'))); ?>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-slate-400 hidden md:block" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- User Dropdown Menu -->
                            <div id="user-menu"
                                class="absolute right-0 top-full mt-2 w-72 bg-white border border-slate-200 rounded-xl shadow-lg py-2 z-50 hidden">
                                <!-- User Info Header -->
                                <div class="px-4 py-3 border-b border-slate-100">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                                            <?php echo mb_strtoupper(mb_substr($current_user['full_name'], 0, 1, 'UTF-8'), 'UTF-8'); ?>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-base text-slate-800">
                                                <?php echo htmlspecialchars($current_user['full_name']); ?>
                                            </div>
                                            <div class="text-sm text-slate-500">
                                                <?php echo htmlspecialchars($current_user['email']); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Menu Items -->
                                <div class="py-1">
                                    <a href="/dashboard"
                                        class="flex items-center px-4 py-2.5 text-base text-slate-700 hover:bg-slate-50">
                                        <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                            </path>
                                        </svg>
                                        Dashboard
                                    </a>

                                    <?php if ($current_user['role'] === 'admin'): ?>
                                        <a href="/admin"
                                            class="flex items-center px-4 py-2.5 text-base text-slate-700 hover:bg-slate-50">
                                            <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            Admin Paneli
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($current_user['role'] === 'merchant' || $current_user['role'] === 'esnaf'): ?>
                                        <a href="/merchant/orders"
                                            class="flex items-center px-4 py-2.5 text-base text-slate-700 hover:bg-slate-50">
                                            <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                                </path>
                                            </svg>
                                            Mağaza Siparişleri
                                        </a>
                                        <a href="/merchant/products"
                                            class="flex items-center px-4 py-2.5 text-base text-slate-700 hover:bg-slate-50">
                                            <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            Ürünlerim
                                        </a>
                                    <?php endif; ?>

                                    <a href="/orders"
                                        class="flex items-center px-4 py-2.5 text-base text-slate-700 hover:bg-slate-50">
                                        <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        Siparişlerim
                                    </a>

                                    <a href="/favorites"
                                        class="flex items-center px-4 py-2.5 text-base text-slate-700 hover:bg-slate-50">
                                        <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                        Favorilerim
                                    </a>

                                    <a href="/account"
                                        class="flex items-center px-4 py-2.5 text-base text-slate-700 hover:bg-slate-50">
                                        <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        Hesap Ayarları
                                    </a>
                                </div>

                                <!-- Logout -->
                                <div class="border-t border-slate-100 pt-1">
                                    <a href="#" onclick="logout()"
                                        class="flex items-center px-4 py-2.5 text-base text-red-600 hover:bg-red-50">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Çıkış Yap
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Login/Register Buttons -->
                        <div class="flex items-center space-x-3">
                            <a href="/login"
                                class="hidden sm:flex px-5 py-2.5 text-base font-medium text-slate-700 hover:text-blue-600 transition-colors">
                                Giriş Yap
                            </a>
                            <a href="/register"
                                class="px-5 py-2.5 bg-blue-600 text-white text-base font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Kayıt Ol
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Mobile Menu Button -->
                    <button
                        class="lg:hidden p-2.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                        onclick="toggleMobileMenu()">
                        <svg id="menu-open-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="menu-close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="lg:hidden hidden bg-white border-t border-slate-200">
            <div class="px-4 py-4 space-y-1">
                <a href="/products"
                    class="flex items-center px-4 py-3 text-base font-medium rounded-lg <?php echo ($current_page === 'products') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50'; ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Ürünler
                </a>
                <?php if (!$current_user || $current_user['role'] === 'customer' || $current_user['role'] === 'musteri'): ?>
                    <a href="/student-intro"
                        class="flex items-center px-4 py-3 text-base font-medium rounded-lg <?php echo ($current_page === 'student-intro') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50'; ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Öğrenci Ol
                    </a>
                <?php endif; ?>

                <a href="/about"
                    class="flex items-center px-4 py-3 text-base font-medium rounded-lg <?php echo ($current_page === 'about') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50'; ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Hakkımızda
                </a>
                <a href="/contact"
                    class="flex items-center px-4 py-3 text-base font-medium rounded-lg <?php echo ($current_page === 'contact') ? 'bg-blue-50 text-blue-600' : 'text-slate-700 hover:bg-slate-50'; ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                    İletişim
                </a>

                <?php if (!$current_user): ?>
                    <div class="pt-4 border-t border-slate-200 space-y-2 mt-4">
                        <a href="/login"
                            class="block w-full px-4 py-3 text-center text-base font-medium text-slate-700 border border-slate-300 rounded-lg hover:bg-slate-50">
                            Giriş Yap
                        </a>
                        <a href="/register"
                            class="block w-full px-4 py-3 text-center text-base font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Kayıt Ol
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleUserMenu() {
        const menu = document.getElementById('user-menu');
        menu.classList.toggle('hidden');
    }

    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const openIcon = document.getElementById('menu-open-icon');
        const closeIcon = document.getElementById('menu-close-icon');

        menu.classList.toggle('hidden');
        openIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    }

    // Close menus when clicking outside
    document.addEventListener('click', function (event) {
        const userMenu = document.getElementById('user-menu');
        const userMenuButton = event.target.closest('[onclick="toggleUserMenu()"]');

        if (!userMenuButton && userMenu && !userMenu.contains(event.target)) {
            userMenu.classList.add('hidden');
        }
    });

    async function logout() {
        // 1. Tarayıcı tarafındaki korumaları sil (Frontend)
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user_name');
        localStorage.removeItem('user_email');
        localStorage.removeItem('user_role');
        localStorage.removeItem('user_phone');

        // 2. PHP Arka planındaki oturumu da öldür (Backend Session Kill)
        try {
            await fetch('/api/auth/logout', { method: 'POST' });
        } catch (e) {
            console.error('Oturum kapatma hatası:', e);
        }

        showToast('Çıkış yapıldı', 'success');
        setTimeout(() => { window.location.href = '/'; }, 1000);
    }


</script>