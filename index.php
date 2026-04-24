<?php
require_once 'php-backend/config/config.php';
require_once 'php-backend/includes/auth.php';

// Database bağlantısı
$auth = new Auth();

// Mevcut kullanıcıyı al
$current_user = $auth->getCurrentUser();

// URL routing
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$path = trim($path, '/');
$path_parts = explode('/', $path);

// API istekleri için özel routing
if ($path_parts[0] === 'api') {
    include 'php-backend/api/index.php';
    exit;
}

// Ana sayfa için boş path
if (empty($path) || $path === 'index.php') {
    $page = 'home';
} else {
    $page = $path_parts[0];
}

// Sayfa dosyasını belirle
$page_file = '';
switch ($page) {
    case 'home':
    case '':
        $page_file = 'pages/home.php';
        break;
    case 'products':
        if (isset($path_parts[1]) && is_numeric($path_parts[1])) {
            $page_file = 'pages/product-detail.php';
            $product_id = $path_parts[1];
        } else {
            $page_file = 'pages/products.php';
        }
        break;
    case 'login':
        $page_file = 'pages/login.php';
        break;
    case 'verify-otp':
        $page_file = 'pages/verify-otp.php';
        break;
    case 'register':
        $page_file = 'pages/register.php';
        break;
    case 'cart':
        $page_file = 'pages/cart.php';
        break;
    case 'checkout':
        $page_file = 'pages/checkout.php';
        break;
    case 'orders':
        $page_file = 'pages/orders.php';
        break;
    case 'profile':
        $page_file = 'pages/account.php';
        break;
    case 'dashboard':
        $page_file = 'pages/dashboard.php';
        break;
    case 'about':
        $page_file = 'pages/about.php';
        break;
    case 'contact':
        $page_file = 'pages/contact.php';
        break;
    case 'help':
        $page_file = 'pages/help.php';
        break;
    case 'terms':
        $page_file = 'pages/terms.php';
        break;
    case 'privacy':
        $page_file = 'pages/privacy.php';
        break;
    case 'survey':
        $page_file = 'pages/survey.php';
        break;
    case 'student-intro':
        $page_file = 'pages/student-intro.php';
        break;
    case 'shops':
        if (isset($path_parts[1]) && is_numeric($path_parts[1])) {
            $page_file = 'pages/shop-detail.php';
            $shop_id = $path_parts[1];
        } else {
            $page_file = 'pages/shops.php';
        }
        break;
    case 'favorites':
        $page_file = 'pages/favorites.php';
        break;
   case 'notifications':
        $page_file = 'pages/notifications.php';
        break;
    case 'account':
        $page_file = 'pages/account.php';
        break;
    case 'admin':
        if (isset($path_parts[1])) {
            switch ($path_parts[1]) {
                case 'users':
                    $page_file = 'pages/admin-users.php';
                    break;
                case 'orders':
                    $page_file = 'pages/admin-orders.php';
                    break;
                case 'products':
                    $page_file = 'pages/admin-products.php';
                    break;
                case 'reports':
                    $page_file = 'pages/admin-reports.php';
                    break;
                case 'survey-results':
                    $page_file = 'pages/admin-survey-results.php';
                    break;
                case 'categories':
                    $page_file = 'pages/admin-categories.php';
                    break;
                default:
                    $page_file = 'pages/admin.php';
            }
        } else {
            $page_file = 'pages/admin.php';
        }
        break;
    case 'student':
        if (isset($path_parts[1])) {
            switch ($path_parts[1]) {
                case 'earnings':
                    $page_file = 'pages/student-earnings.php';
                    break;
                case 'products':
                    $page_file = 'pages/student-products.php';
                    break;
                case 'wallet':
                    $page_file = 'pages/student-wallet.php';
                    break;
                case 'create-product':
                    $page_file = 'pages/student-create-product.php';
                    break;
                default:
                    $page_file = 'pages/404.php';
            }
        } else {
            $page_file = 'pages/404.php';
        }
        break;
    case 'merchant':
        if (isset($path_parts[1])) {
            switch ($path_parts[1]) {
                case 'orders':
                    $page_file = 'pages/merchant-orders.php';
                    break;
                case 'products':
                    $page_file = 'pages/merchant-products.php';
                    break;
                case 'shop':
                    $page_file = 'pages/merchant-shop.php';
                    break;
                default:
                    $page_file = 'pages/404.php';
            }
        } else {
            $page_file = 'pages/404.php';
        }
        break;
    case 'addresses':
        $page_file = 'pages/addresses.php';
        break;
    case 'forgot-password':
        $page_file = 'pages/forgot-password.php';
        break;
    case 'reset-password':
        $page_file = 'pages/reset-password.php';
        break;
    case 'debug':
        $page_file = 'pages/debug.php';
        break;
    default:
        $page_file = 'pages/404.php';
}

// Sayfa dosyası var mı kontrol et
if (!file_exists($page_file)) {
    $page_file = 'pages/404.php';
}

// Meta bilgileri
$page_title = 'EsnappGO - Öğrenci Destekli E-ticaret';
$page_description = 'Üniversite öğrencilerinin desteklediği e-ticaret platformu';

switch ($page) {
    case 'products':
        $page_title = 'Ürünler - EsnappGO';
        $page_description = 'Öğrenciler tarafından sahadan paylaşılan ürünler';
        break;
    case 'login':
        $page_title = 'Giriş Yap - EsnappGO';
        break;
    case 'register':
        $page_title = 'Kayıt Ol - EsnappGO';
        break;
    case 'cart':
        $page_title = 'Sepetim - EsnappGO';
        break;
    case 'about':
        $page_title = 'Hakkımızda - EsnappGO';
        break;
    case 'student-intro':
        $page_title = 'Öğrenciler İçin - EsnappGO';
        $page_description = 'Fotoğraf çekerek para kazan! Öğrenciler için özel gelir modeli';
        break;
}
?>
<!DOCTYPE html>
<html lang="tr" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="keywords" content="e-ticaret, öğrenci, esnaf, alışveriş">
    <meta name="author" content="EsnappGO Team">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Heroicons removed to prevent CORS and 404 errors (SVGs used inline) -->



    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Custom base styles */
        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: rgb(249 250 251);
            color: rgb(17 24 39);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Form styles */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="tel"],
        textarea,
        select {
            display: block;
            width: 100%;
            border-radius: 0.375rem;
            border: 1px solid rgb(209 213 219);
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            outline: none;
            transition: all 0.2s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        input[type="tel"]:focus,
        textarea:focus,
        select:focus {
            border-color: rgb(59 130 246);
            box-shadow: 0 0 0 1px rgb(59 130 246);
        }

        input::placeholder,
        textarea::placeholder {
            color: rgb(156 163 175);
        }

        /* Button base styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            border: 1px solid transparent;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            transition: all 0.2s;
            outline: none;
            cursor: pointer;
        }

        .btn:focus {
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }

        .btn:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }

        .btn-primary {
            background-color: rgb(37 99 235);
            color: white;
        }

        .btn-primary:hover {
            background-color: rgb(29 78 216);
        }

        .btn-secondary {
            background-color: rgb(75 85 99);
            color: white;
        }

        .btn-secondary:hover {
            background-color: rgb(55 65 81);
        }

        .btn-success {
            background-color: rgb(34 197 94);
            color: white;
        }

        .btn-success:hover {
            background-color: rgb(22 163 74);
        }

        .btn-warning {
            background-color: rgb(234 179 8);
            color: white;
        }

        .btn-warning:hover {
            background-color: rgb(202 138 4);
        }

        .btn-error {
            background-color: rgb(239 68 68);
            color: white;
        }

        .btn-error:hover {
            background-color: rgb(220 38 38);
        }

        .btn-outline {
            border-color: rgb(209 213 219);
            background-color: white;
            color: rgb(55 65 81);
        }

        .btn-outline:hover {
            background-color: rgb(249 250 251);
        }

        .btn-outline-white {
            border-color: white;
            background-color: transparent;
            color: white;
        }

        .btn-outline-white:hover {
            background-color: white;
            color: rgb(37 99 235);
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }

        /* Custom components */
        .card {
            border-radius: 0.5rem;
            background-color: white;
            padding: 1.5rem;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            border: 1px solid rgb(229 231 235);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            padding: 0.125rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-primary {
            background-color: rgb(219 234 254);
            color: rgb(30 64 175);
        }

        .badge-success {
            background-color: rgb(220 252 231);
            color: rgb(22 101 52);
        }

        .badge-warning {
            background-color: rgb(254 249 195);
            color: rgb(133 77 14);
        }

        .badge-error {
            background-color: rgb(254 226 226);
            color: rgb(153 27 27);
        }

        .badge-gray {
            background-color: rgb(243 244 246);
            color: rgb(31 41 55);
        }

        /* Student badge */
        .badge-student {
            background: linear-gradient(to right, rgb(219 234 254), rgb(224 231 255));
            color: rgb(30 64 175);
            border: 1px solid rgb(191 219 254);
        }

        /* Loading animation */
        .loading-spinner {
            animation: spin 1s linear infinite;
            border-radius: 9999px;
            border: 2px solid rgb(209 213 219);
            border-top-color: rgb(37 99 235);
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Utilities */
        .gradient-text {
            background: linear-gradient(to right, rgb(37 99 235), rgb(67 56 202));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Line clamp utilities */
        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 1;
            line-clamp: 1;
        }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            line-clamp: 2;
        }

        .line-clamp-3 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            line-clamp: 3;
        }

        /* Custom Modal CSS */
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(17, 24, 39, 0.6);
            backdrop-filter: blur(5px);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .custom-modal-box {
            background: #ffffff;
            width: 90%;
            max-width: 400px;
            border-radius: 16px;
            padding: 28px 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            text-align: center;
            transform: scale(0.95) translateY(10px);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .custom-modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .custom-modal-overlay.show .custom-modal-box {
            transform: scale(1) translateY(0);
        }

        .custom-modal-icon {
            width: 50px;
            height: 50px;
            background-color: #EFF6FF;
            color: #3B82F6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px auto;
        }

        .custom-modal-icon svg {
            width: 26px;
            height: 26px;
        }

        .custom-modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin: 0 0 12px 0;
        }

        .custom-modal-message {
            font-size: 0.95rem;
            color: #4B5563;
            margin: 0 0 24px 0;
            line-height: 1.6;
        }

        .custom-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .custom-modal-actions button {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            font-size: 0.95rem;
            font-weight: 500;
            border-radius: 10px;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-cancel {
            background-color: #F3F4F6;
            color: #374151;
        }

        .btn-cancel:hover {
            background-color: #E5E7EB;
        }

        .btn-confirm {
            background-color: #3B82F6;
            color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.4);
        }

        .btn-confirm:hover {
            background-color: #2563EB;
            box-shadow: 0 6px 10px -1px rgba(59, 130, 246, 0.5);
            transform: translateY(-1px);
        }
    </style>

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>

<body class="h-full">
    <!-- Header -->
    <?php
    // Current page info for header
    $current_page = $page;
    include 'components/header.php';
    ?>

    <!-- Main Content -->
    <main>
        <?php include $page_file; ?>
    </main>

    <!-- Modern Custom Modal -->
    <div id="customModal" class="custom-modal-overlay">
        <div class="custom-modal-box">
            <div class="custom-modal-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 id="customModalTitle" class="custom-modal-title">Uyarı</h3>
            <p id="customModalMessage" class="custom-modal-message">İşlemi onaylıyor musunuz?</p>
            <div class="custom-modal-actions">
                <button id="customModalCancel" class="btn-cancel">İptal</button>
                <button id="customModalConfirm" class="btn-confirm">Onayla</button>
            </div>
        </div>
    </div>

    <!-- Toast notifications container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- JavaScript -->
    <script>
        function openCustomModal(message, type = 'confirm') {
            return new Promise((resolve) => {
                const overlay = document.getElementById('customModal');
                if (!overlay) return resolve(false);
                // 'alert' tipinde HTML render et (sipariş detayları gibi); 'confirm' tipi için textContent (güvenli)
                if (type === 'alert') {
                    document.getElementById('customModalMessage').innerHTML = message;
                } else {
                    document.getElementById('customModalMessage').textContent = message;
                }
                const titleEl = document.getElementById('customModalTitle');
                const confirmBtn = document.getElementById('customModalConfirm');
                const cancelBtn = document.getElementById('customModalCancel');

                if (type === 'alert') {
                    titleEl.textContent = 'Bilgilendirme';
                    cancelBtn.style.display = 'none';
                    confirmBtn.textContent = 'Tamam';
                } else {
                    titleEl.textContent = 'Emin misiniz?';
                    cancelBtn.style.display = 'inline-flex';
                    confirmBtn.textContent = 'Onayla';
                    cancelBtn.textContent = 'İptal';
                }

                overlay.classList.add('show');
                const newConfirmBtn = confirmBtn.cloneNode(true);
                const newCancelBtn = cancelBtn.cloneNode(true);
                confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
                cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);

                const closeModal = (result) => {
                    overlay.classList.remove('show');
                    setTimeout(() => resolve(result), 300);
                };
                newConfirmBtn.addEventListener('click', () => closeModal(true));
                newCancelBtn.addEventListener('click', () => closeModal(false));
            });
        }


        // -------- API CONFIG --------
        const API_BASE = window.location.hostname === 'localhost'
            ? 'http://localhost:5086'
            : 'https://SENIN-PRODUCTION-DOMAININ.com';

        // Toast notification function
        function showToast(message, type = 'info') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');

            let bgColor = 'bg-gray-800';
            if (type === 'success') bgColor = 'bg-green-600';
            if (type === 'error') bgColor = 'bg-red-600';
            if (type === 'warning') bgColor = 'bg-yellow-600';

            toast.className = `${bgColor} text-white px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full opacity-0`;
            toast.textContent = message;

            container.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
            }, 100);

            // Auto remove after 4 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    container.removeChild(toast);
                }, 300);
            }, 4000);
        }

        // API helper functions
        async function apiCall(endpoint, options = {}) {
            // silent: true → 401 durumunda token silinmez ve login'e yönlendirilmez
            const silent = options.silent === true;
            const fetchOptions = { ...options };
            delete fetchOptions.silent;

            const defaultOptions = {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                }
                // credentials: 'include' satırını tamamen SİLDİK.
                // .NET JWT sisteminde header yeterlidir, CORS'u bozmasına gerek yok.
            };

            const token = localStorage.getItem('auth_token');
            if (token) {
                defaultOptions.headers['Authorization'] = 'Bearer ' + token;
            }

            const response = await fetch(`${API_BASE}/api/${endpoint}`, {
                ...defaultOptions,
                ...fetchOptions,
                headers: {
                    ...defaultOptions.headers,
                    ...fetchOptions.headers,
                }
            });

            // .NET 204 NoContent (Boş İçerik) döndüğünde sistemin çökmemesi için hazırlık yapıldı
            let data = {};
            if (response.status !== 204) {
                const text = await response.text();
                // Eğer dönecek bir metin/veri varsa json'a çevir, yoksa boşluk bekle
                data = text ? JSON.parse(text) : {};
            }

            if (!response.ok) {
                if (response.status === 401) {
                    if (!silent) {
                        // Sadece kritik çağrılarda token'ı sil ve login'e yönlendir
                        localStorage.removeItem('auth_token');
                        window.location.href = '/login?session_expired=1';
                    }
                    throw new Error('Oturumunuzun süresi doldu. Lütfen tekrar giriş yapın.');
                }

                // .NET ProblemDetails formatını destekle
                const errorMessage =
                    data.message ||
                    data.error ||
                    data.title ||
                    (data.errors ? Object.values(data.errors).flat().join(', ') : null) ||
                    'Bir hata oluştu';
                throw new Error(errorMessage);
            }

            return data;
        }

        // Cart functionality
        async function addToCart(productId, quantity = 1) {
            try {
                console.log('Adding to cart:', { product_id: productId, quantity: quantity });

                const response = await apiCall('cart/items', {
                    method: 'POST',
                    body: JSON.stringify({
                        productId: productId, // Alt tireli yerine camelCase yazdık
                        quantity: quantity
                    })
                });


                console.log('Cart response:', response);

                showToast('Ürün sepete eklendi!', 'success');
                updateCartCount();
            } catch (error) {
                console.error('Cart error:', error);
                showToast(error.message, 'error');
            }
        }

        async function removeFromCart(itemId) {
            try {
                await apiCall(`cart/items/${itemId}`, {
                    method: 'DELETE'
                });


                showToast('Ürün sepetten kaldırıldı!', 'success');
                updateCartCount();
                // Refresh cart page if we're on it
                if (window.location.pathname === '/cart') {
                    location.reload();
                }
            } catch (error) {
                showToast(error.message, 'error');
            }
        }
        async function updateCartCount() {
            const token = localStorage.getItem('auth_token');
            if (!token) return;

            try {
                const response = await apiCall('cart', { silent: true });
                const cartCount = response.items ? response.items.length : 0;

                const cartButton = document.getElementById('cart-count');
                if (cartButton) {
                    cartButton.textContent = cartCount;
                    cartButton.style.display = cartCount > 0 ? 'flex' : 'none';
                }
            } catch (error) {
                console.error('Cart count update failed:', error);
            }
        }

        // Bildirimleri Çek — silent:true ile 401 gelirse token silinmez, sayfa yönlendirilmez
        async function loadNotificationCount() {
            const token = localStorage.getItem('auth_token');
            if (!token) return;

            try {
                const notifications = await apiCall('Notifications', { silent: true });
                const unread = Array.isArray(notifications) ? notifications.filter(n => !n.isRead).length : 0;

                const badge = document.getElementById('notification-badge');
                if (badge) {
                    if (unread > 0) {
                        badge.textContent = unread;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            } catch (error) {
                // Bildirim yüklenemedi (örn. izin hatası) — sessizce geç, oturumu sonlandırma
                console.warn('Bildirimler yüklenemedi:', error.message);
            }
        }

        // Initialize cart AND notifications on page load
        document.addEventListener('DOMContentLoaded', function () {
            <?php if ($current_user): ?>
                updateCartCount();
                loadNotificationCount(); // Bildirim fonksiyonunu tetikle
                
                // Dinamik olarak isim güncelleme (kullanıcı çıkış yapmadan yeni ismini görebilsin)
                const storedName = localStorage.getItem('user_name');
                if (storedName) {
                    const initial = storedName.charAt(0).toUpperCase();
                    const firstName = storedName.split(' ')[0];
                    
                    const btnInner = document.querySelector('button[onclick="toggleUserMenu()"]');
                    if (btnInner) {
                       const avatar = btnInner.querySelector('div.bg-blue-600');
                       if(avatar) avatar.textContent = initial;
                       const firstNameEl = btnInner.querySelector('.text-slate-800');
                       if(firstNameEl) firstNameEl.textContent = firstName;
                    }

                    const userMenu = document.getElementById('user-menu');
                    if (userMenu) {
                       const avatar2 = userMenu.querySelector('div.bg-blue-600');
                       if(avatar2) avatar2.textContent = initial;
                       const fullNameEl = userMenu.querySelector('.text-slate-800.font-semibold');
                       if(fullNameEl) fullNameEl.textContent = storedName;
                    }
                }
            <?php endif; ?>
        });
    
        // Form submission helpers
        function handleFormSubmit(formId, endpoint, successCallback) {
            const form = document.getElementById(formId);
            if (!form) return;

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());

                try {
                    const response = await apiCall(endpoint, {
                        method: 'POST',
                        body: JSON.stringify(data)
                    });

                    if (response.success) {
                        showToast('İşlem başarılı!', 'success');
                        if (successCallback) successCallback(response);
                    } else {
                        showToast(response.message || 'Bir hata oluştu', 'error');
                    }
                } catch (error) {
                    showToast(error.message, 'error');
                }
            });
        }
    </script>
</body>

</html>