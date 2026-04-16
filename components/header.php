<?php
// Role helper
$role = $current_user['role'] ?? '';
$is_merchant = in_array($role, ['merchant', 'esnaf']);
$is_student = in_array($role, ['student', 'ogrenci']);
$is_admin = $role === 'admin';
$is_customer = in_array($role, ['customer', 'musteri']);
$is_logged_in = !empty($current_user);

$role_label = $is_merchant ? 'Esnaf' : ($is_student ? 'Öğrenci' : ($is_admin ? 'Admin' : 'Müşteri'));
$role_color = $is_merchant ? '#f59e0b' : ($is_student ? '#10b981' : ($is_admin ? '#ef4444' : '#6366f1'));
$first_letter = $is_logged_in ? mb_strtoupper(mb_substr($current_user['full_name'], 0, 1, 'UTF-8'), 'UTF-8') : '';
?>

<style>
    /* ===== HEADER PREMIUM STYLES ===== */
    .esnap-header {
        font-family: 'Inter', -apple-system, sans-serif;
    }

    /* Top bar */
    .esnap-topbar {
        background: linear-gradient(90deg, #0f172a 0%, #1e293b 100%);
    }

    /* Nav link active/hover */
    .nav-link {
        position: relative;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 500;
        color: #475569;
        transition: all .18s ease;
        white-space: nowrap;
    }

    .nav-link:hover {
        background: #eff6ff;
        color: #2563eb;
    }

    .nav-link.active {
        background: #dbeafe;
        color: #1d4ed8;
        font-weight: 600;
    }

    .nav-link svg {
        flex-shrink: 0;
    }

    /* User avatar */
    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        color: #fff;
        background: linear-gradient(135deg, #2563eb, #7c3aed);
        flex-shrink: 0;
    }

    /* Dropdown */
    .user-dropdown {
        position: absolute;
        right: 0;
        top: calc(100% + 10px);
        width: 300px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .12), 0 4px 16px rgba(0, 0, 0, .06);
        z-index: 999;
        opacity: 0;
        transform: translateY(-8px) scale(.97);
        pointer-events: none;
        transition: all .2s cubic-bezier(.34, 1.56, .64, 1);
    }

    .user-dropdown.open {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: all;
    }

    /* Dropdown header gradient */
    .dropdown-header {
        background: linear-gradient(135deg, #1e40af 0%, #7c3aed 100%);
        border-radius: 16px 16px 0 0;
        padding: 20px;
    }

    /* Quick action grid */
    .quick-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        padding: 12px;
    }

    .quick-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        padding: 12px 8px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        transition: all .15s ease;
        text-decoration: none;
        cursor: pointer;
    }

    .quick-item:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, .1);
    }

    .quick-item svg {
        width: 22px;
        height: 22px;
    }

    /* Dropdown links */
    .dd-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        font-size: 14px;
        color: #374151;
        transition: all .12s ease;
        text-decoration: none;
        border-radius: 0;
    }

    .dd-link:hover {
        background: #f8fafc;
        color: #1d4ed8;
    }

    .dd-link svg {
        width: 18px;
        height: 18px;
        color: #94a3b8;
        flex-shrink: 0;
    }

    .dd-link:hover svg {
        color: #2563eb;
    }

    .dd-link.danger {
        color: #dc2626;
    }

    .dd-link.danger:hover {
        background: #fff1f2;
    }

    .dd-link.danger svg {
        color: #fca5a5;
    }

    .dd-link.danger:hover svg {
        color: #dc2626;
    }

    /* Role badge */
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .4px;
        background: rgba(255, 255, 255, .2);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, .3);
    }

    /* Notification dot */
    .notif-dot {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 18px;
        height: 18px;
        background: #ef4444;
        border-radius: 99px;
        font-size: 10px;
        font-weight: 700;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
    }

    /* Mobile drawer */
    .mobile-drawer {
        background: #fff;
        border-top: 1px solid #e2e8f0;
    }

    .mobile-nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 500;
        color: #374151;
        transition: all .15s;
        text-decoration: none;
    }

    .mobile-nav-link:hover,
    .mobile-nav-link.active {
        background: #eff6ff;
        color: #2563eb;
    }

    .mobile-nav-link svg {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
    }

    /* Separator */
    .dd-sep {
        height: 1px;
        background: #f1f5f9;
        margin: 4px 12px;
    }

    /* Smooth scroll shadow */
    .esnap-main-nav {
        box-shadow: 0 1px 0 #e2e8f0;
    }
</style>

<header class="sticky top-0 z-50 esnap-header">

    <!-- Top Bar -->
    <div class="esnap-topbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-10 text-sm">
            <div class="hidden sm:flex items-center gap-5 text-slate-400">
                <a href="tel:05336160218" class="flex items-center gap-1.5 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    0533 616 02 18
                </a>
                <a href="mailto:info@esnappgo.com"
                    class="flex items-center gap-1.5 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    info@esnappgo.com
                </a>
            </div>
            <div class="flex items-center gap-1.5 text-emerald-400 font-semibold ml-auto sm:ml-0 tracking-wide">
                <span class="text-base">🎓</span>
                <span>Türkiye'nin İlk Öğrenci Destekli E-Ticaret Platformu</span>
            </div>
        </div>
    </div>
</div>

    <!-- Main Header -->
    <div class="bg-white esnap-main-nav shadow-sm relative z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-[90px] gap-4">

                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 flex-shrink-0 group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md transition-transform group-hover:scale-105"
                        style="background:linear-gradient(135deg,#2563eb,#7c3aed)">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="hidden sm:block">
                        <div class="text-[28px] font-bold text-slate-800 leading-none">Esnapp<span
                                style="color:#2563eb">GO</span></div>

                        <div class="text-[13px] text-slate-400 font-medium mt-0.5">Öğrenci Destekli E-Ticaret</div>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center gap-1 flex-1 justify-center">

                    <!-- Ürünler — always visible -->
                    <a href="/products" class="nav-link <?php echo ($current_page === 'products') ? 'active' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Ürünler
                    </a>

                    <!-- Mağazalar — always visible -->
                    <a href="/shops" class="nav-link <?php echo ($current_page === 'shops') ? 'active' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Mağazalar
                    </a>

                    <?php if ($is_logged_in): ?>

                        <!-- Dashboard — all logged-in users -->
                        <a href="/dashboard"
                            class="nav-link <?php echo ($current_page === 'dashboard') ? 'active' : ''; ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Dashboard
                        </a>

                        <!-- Siparişlerim — Sadece Müşteri -->
                        <?php if ($is_customer): ?>
                            <a href="/orders"
                                class="nav-link <?php echo ($current_page === 'orders') ? 'active' : ''; ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Siparişlerim
                            </a>
                        <?php endif; ?>

                        <!-- Esnafın Aldığı Müşteri Siparişleri (Satıcı) -->
                        <?php if ($is_merchant): ?>
                            <a href="/merchant/orders"
                                class="nav-link <?php echo ($current_page === 'merchant-orders') ? 'active' : ''; ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Gelen Siparişler
                            </a>
                        <?php endif; ?>

                        <!-- Merchant-only links -->
                        <?php if ($is_merchant): ?>
                            <a href="/merchant/products"
                                class="nav-link <?php echo ($current_page === 'merchant-products') ? 'active' : ''; ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Ürünlerim
                            </a>
                        <?php endif; ?>

                        <!-- Student-only links -->
                        <?php if ($is_student): ?>
                            <a href="/student/products"
                                class="nav-link <?php echo ($current_page === 'student-products') ? 'active' : ''; ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Ürünlerim
                            </a>
                            <a href="/student/create-product"
                                class="nav-link <?php echo ($current_page === 'student-create-product') ? 'active' : ''; ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Ürün Ekle
                            </a>
                        <?php endif; ?>

                        <!-- Admin-only link -->
                        <?php if ($is_admin): ?>
                            <a href="/admin" class="nav-link <?php echo ($current_page === 'admin') ? 'active' : ''; ?>">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Admin
                            </a>
                        <?php endif; ?>

                    <?php else: ?>
                        <!-- Guest: Öğrenci Ol -->
                        <a href="/student-intro"
                            class="nav-link <?php echo ($current_page === 'student-intro') ? 'active' : ''; ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Öğrenci Ol
                        </a>
                    <a href="/about" class="nav-link <?php echo ($current_page === 'about') ? 'active' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Hakkımızda
                    </a>

                    <a href="/contact" class="nav-link <?php echo ($current_page === 'contact') ? 'active' : ''; ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        İletişim
                    </a>
                    <?php endif; ?>
                </nav>

                <!-- Right Actions -->
                <div class="flex items-center gap-1.5 flex-shrink-0">

                    <?php if ($is_logged_in): ?>

                        <!-- Notifications -->
                        <a href="/notifications"
                            class="relative p-2 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                            title="Bildirimler">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span id="notification-badge" class="notif-dot" style="display:none">0</span>
                        </a>

                        <!-- Cart -->
                        <a href="/cart"
                            class="relative p-2 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                            title="Sepetim">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span id="cart-count" class="notif-dot" style="display:none">0</span>
                        </a>

                        <!-- Favorites -->
                        <a href="/favorites"
                            class="hidden sm:flex p-2 text-slate-500 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                            title="Favorilerim">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </a>

                        <div class="w-px h-7 bg-slate-200 mx-1 hidden sm:block"></div>

                        <!-- User Dropdown Toggle -->
                        <div class="relative" id="user-menu-wrapper">
                            <button id="user-menu-btn" onclick="toggleUserMenu()"
                                class="flex items-center gap-2 py-1.5 px-2.5 rounded-xl hover:bg-slate-100 transition-colors">
                                <div class="user-avatar"><?php echo $first_letter; ?></div>
                                <div class="hidden md:block text-left">
                                    <div class="text-[15px] font-semibold text-slate-800 leading-tight">
                                        <?php echo htmlspecialchars(explode(' ', $current_user['full_name'])[0]); ?>
                                    </div>
                                    <div class="text-[12px] font-medium mt-0.5" style="color:<?php echo $role_color; ?>">
                                        <?php echo $role_label; ?>
                                    </div>

                                </div>
                                <svg class="w-4 h-4 text-slate-400 hidden md:block transition-transform" id="user-chevron"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- DROPDOWN MENU -->
                            <div id="user-menu" class="user-dropdown">

                                <!-- Header Gradient -->
                                <div class="dropdown-header">
                                    <div class="flex items-center gap-3">
                                        <div class="user-avatar"
                                            style="width:48px;height:48px;font-size:20px;border-radius:14px;">
                                            <?php echo $first_letter; ?>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-bold text-white text-[15px] truncate">
                                                <?php echo htmlspecialchars($current_user['full_name']); ?>
                                            </div>
                                            <div class="text-blue-200 text-[12px] truncate">
                                                <?php echo htmlspecialchars($current_user['email']); ?>
                                            </div>
                                            <div class="mt-1.5">
                                                <span class="role-badge">
                                                    <?php if ($is_admin): ?>⚙️<?php elseif ($is_merchant): ?>🏪<?php elseif ($is_student): ?>🎓<?php else: ?>👤<?php endif; ?>
                                                    <?php echo $role_label; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Actions Grid -->
                                <div class="quick-grid">
                                    <a href="/dashboard" class="quick-item">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                        </svg>
                                        Dashboard
                                    </a>
                                    <?php if (!$is_admin): ?>
                                        <a href="/orders" class="quick-item">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            Siparişlerim
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($is_merchant): ?>
                                        <a href="/merchant/orders" class="quick-item">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            Gelen Siparişler
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($is_merchant): ?>
                                        <a href="/merchant/products" class="quick-item">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                            Ürünlerim
                                        </a>
                                        <a href="/merchant/shop" class="quick-item">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            Mağazam
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($is_student): ?>
                                        <a href="/student/products" class="quick-item">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            Ürünlerim
                                        </a>
                                        <a href="/student/create-product" class="quick-item">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Ürün Ekle
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($is_customer): ?>
                                        <a href="/favorites" class="quick-item">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            Favorilerim
                                        </a>
                                        <a href="/cart" class="quick-item">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            Sepetim
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($is_admin): ?>
                                        <a href="/admin" class="quick-item">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Admin Panel
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <div class="dd-sep"></div>

                                <!-- Secondary Links -->
                                <div style="padding: 4px 0;">
                                    <a href="/about" class="dd-link">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Hakkımızda
                                    </a>
                                    <a href="/contact" class="dd-link">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        İletişim
                                    </a>
                                    <a href="/notifications" class="dd-link">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                        Bildirimler
                                    </a>
                                    <a href="/account" class="dd-link">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Hesap Ayarları
                                    </a>
                                </div>

                                <div class="dd-sep"></div>

                                <!-- Logout -->
                                <div style="padding: 4px 0 8px;">
                                    <a href="#" onclick="logout(); return false;" class="dd-link danger">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Çıkış Yap
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
    <a href="/login"
        class="hidden sm:flex items-center px-5 py-2 text-sm font-semibold text-slate-700 border-2 border-slate-200 rounded-xl hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 transition-all">Giriş Yap</a>
    <a href="/register"
        class="px-5 py-2 text-sm font-semibold text-white rounded-xl transition-all hover:opacity-90 hover:scale-105 shadow-sm"
        style="background:linear-gradient(135deg,#2563eb,#7c3aed)">Kayıt Ol</a>
<?php endif; ?>

                    <!-- Mobile Menu Button -->
                    <button
                        class="lg:hidden p-2 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors ml-1"
                        onclick="toggleMobileMenu()">
                        <svg id="menu-open-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg id="menu-close-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="lg:hidden hidden mobile-drawer">
            <div class="px-4 py-3 space-y-1 max-h-[80vh] overflow-y-auto">

                <?php if ($is_logged_in): ?>
                    <!-- Mobile user info pill -->
                    <div class="flex items-center gap-3 p-3 rounded-xl mb-3"
                        style="background:linear-gradient(135deg,#1e40af,#7c3aed)">
                        <div class="user-avatar" style="width:40px;height:40px;"><?php echo $first_letter; ?></div>
                        <div>
                            <div class="font-semibold text-white text-sm">
                                <?php echo htmlspecialchars($current_user['full_name']); ?>
                            </div>
                            <div class="text-blue-200 text-xs"><?php echo $role_label; ?></div>
                        </div>
                    </div>
                <?php endif; ?>

                <a href="/products"
                    class="mobile-nav-link <?php echo ($current_page === 'products') ? 'active' : ''; ?>">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Ürünler
                </a>
                <a href="/shops" class="mobile-nav-link <?php echo ($current_page === 'shops') ? 'active' : ''; ?>">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Mağazalar
                </a>

                <?php if ($is_logged_in): ?>
                    <a href="/dashboard"
                        class="mobile-nav-link <?php echo ($current_page === 'dashboard') ? 'active' : ''; ?>">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </a>
                    <?php if ($is_customer): ?>
                        <a href="/orders" class="mobile-nav-link <?php echo ($current_page === 'orders') ? 'active' : ''; ?>">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Siparişlerim
                        </a>
                    <?php endif; ?>
                    <?php if ($is_merchant): ?>
                        <a href="/merchant/products" class="mobile-nav-link">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Ürünlerim
                        </a>
                        <a href="/merchant/shop" class="mobile-nav-link">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Mağaza Ayarları
                        </a>
                    <?php endif; ?>
                    <?php if ($is_student): ?>
                        <a href="/student/create-product" class="mobile-nav-link">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Ürün Ekle
                        </a>

                    <?php endif; ?>
                    <?php if ($is_admin): ?>
                        <a href="/admin" class="mobile-nav-link">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Admin Panel
                        </a>
                    <?php endif; ?>

                    <div style="height:1px;background:#f1f5f9;margin:8px 4px;"></div>
                    <a href="/about" class="mobile-nav-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Hakkımızda
                    </a>
                    <a href="/contact" class="mobile-nav-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        İletişim
                    </a>
                    <a href="/account" class="mobile-nav-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Hesap Ayarları
                    </a>
                    <a href="#" onclick="logout(); return false;" class="mobile-nav-link" style="color:#dc2626;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Çıkış Yap
                    </a>

                <?php else: ?>
                    <a href="/student-intro" class="mobile-nav-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Öğrenci Ol
                    </a>
                    <a href="/about" class="mobile-nav-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Hakkımızda
                    </a>
                    <a href="/contact" class="mobile-nav-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        İletişim
                    </a>
                    <div style="height:1px;background:#f1f5f9;margin:8px 4px;"></div>
                    <div class="flex gap-2 pt-1 pb-2">
                        <a href="/login"
                            class="flex-1 text-center py-2.5 text-sm font-medium text-slate-700 border border-slate-300 rounded-xl hover:bg-slate-50">Giriş
                            Yap</a>
                        <a href="/register" class="flex-1 text-center py-2.5 text-sm font-semibold text-white rounded-xl"
                            style="background:linear-gradient(135deg,#2563eb,#7c3aed)">Kayıt Ol</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<script>
    var _userMenuOpen = false;

    function toggleUserMenu() {
        var menu = document.getElementById('user-menu');
        var chevron = document.getElementById('user-chevron');
        _userMenuOpen = !_userMenuOpen;
        if (_userMenuOpen) {
            menu.classList.add('open');
            if (chevron) chevron.style.transform = 'rotate(180deg)';
        } else {
            menu.classList.remove('open');
            if (chevron) chevron.style.transform = '';
        }
    }

    function toggleMobileMenu() {
        var menu = document.getElementById('mobile-menu');
        var openIco = document.getElementById('menu-open-icon');
        var closeIco = document.getElementById('menu-close-icon');
        menu.classList.toggle('hidden');
        openIco.classList.toggle('hidden');
        closeIco.classList.toggle('hidden');
    }

    // Close user-dropdown when clicking outside
    document.addEventListener('click', function (e) {
        var wrapper = document.getElementById('user-menu-wrapper');
        if (wrapper && !wrapper.contains(e.target) && _userMenuOpen) {
            toggleUserMenu();
        }
    });

    async function logout() {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user_name');
        localStorage.removeItem('user_email');
        localStorage.removeItem('user_role');
        localStorage.removeItem('user_phone');
        try { await fetch('/api/auth/logout', { method: 'POST' }); } catch (e) { }
        if (typeof showToast === 'function') showToast('Çıkış yapıldı', 'success');
        setTimeout(function () { window.location.href = '/'; }, 900);
    }
</script>