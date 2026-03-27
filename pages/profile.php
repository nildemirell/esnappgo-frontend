<?php
// Giriş kontrolü
if (!$current_user) {
    header('Location: /login?redirect=/profile');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Profil Ayarları</h1>
            <p class="text-gray-600">Hesap bilgilerinizi ve tercihlerinizi yönetin</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Navigation -->
            <div class="lg:col-span-1">
                <nav class="bg-white rounded-lg shadow-sm p-4 space-y-1">
                    <a href="#profile-info" onclick="showSection('profile-info')"
                        class="profile-nav-link active flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Kişisel Bilgiler
                    </a>

                    <a href="#password" onclick="showSection('password')"
                        class="profile-nav-link flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        Şifre Değiştir
                    </a>

                    <?php if ($current_user['role'] === 'student' || $current_user['role'] === 'ogrenci'): ?>
                        <a href="#wallet" onclick="showSection('wallet')"
                            class="profile-nav-link flex items-center px-3 py-2 text-sm font-medium rounded-md">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                            Cüzdan Bilgileri
                        </a>
                    <?php endif; ?>

                    <a href="#addresses" onclick="showSection('addresses')"
                        class="profile-nav-link flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Adreslerim
                    </a>

                    <a href="#notifications" onclick="showSection('notifications')"
                        class="profile-nav-link flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-5 5v-5zM7 7h10a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z">
                            </path>
                        </svg>
                        Bildirimler
                    </a>
                </nav>
            </div>

            <!-- Profile Content -->
            <div class="lg:col-span-2">
                <!-- Personal Information -->
                <div id="profile-info" class="profile-section">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Kişisel Bilgiler</h3>

                        <form id="profile-form" class="space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Ad Soyad
                                    </label>
                                    <input type="text" id="full_name" name="full_name"
                                        value="<?php echo htmlspecialchars($current_user['full_name']); ?>"
                                        class="w-full" required />
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        E-posta
                                    </label>
                                    <input type="email" id="email" name="email"
                                        value="<?php echo htmlspecialchars($current_user['email']); ?>"
                                        class="w-full bg-gray-100" disabled />
                                    <p class="text-xs text-gray-500 mt-1">E-posta adresi değiştirilemez</p>
                                </div>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Telefon
                                </label>
                                <input type="tel" id="phone" name="phone"
                                    value="<?php echo htmlspecialchars($current_user['phoneNumber'] ?? $current_user['phone'] ?? ''); ?>"
                                    class="w-full" placeholder="0533 616 02 18" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Hesap Türü
                                </label>
                                <div class="flex items-center p-3 bg-gray-50 rounded-md">
                                    <div class="flex-shrink-0">
                                        <?php
                                        $roleIcons = [
                                            'customer' => '<svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>',
                                            'musteri' => '<svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>',
                                            'student' => '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>',
                                            'ogrenci' => '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>',
                                            'merchant' => '<svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>',
                                            'esnaf' => '<svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>',
                                            'admin' => '<svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>'
                                        ];
                                        echo $roleIcons[$current_user['role']] ?? '';
                                        ?>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?php
                                            $roleNames = [
                                                'customer' => 'Müşteri',
                                                'musteri' => 'Müşteri',
                                                'student' => 'Öğrenci',
                                                'ogrenci' => 'Öğrenci',
                                                'merchant' => 'Esnaf',
                                                'esnaf' => 'Esnaf',
                                                'admin' => 'Yönetici'
                                            ];
                                            echo $roleNames[$current_user['role']] ?? 'Bilinmiyor';
                                            ?>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            Hesap türü değiştirilemez
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="btn btn-primary">
                                    Değişiklikleri Kaydet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Password Change -->
                <div id="password" class="profile-section" style="display: none;">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Şifre Değiştir</h3>

                        <form id="password-form" class="space-y-6">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Mevcut Şifre
                                </label>
                                <input type="password" id="current_password" name="current_password" class="w-full"
                                    required />
                            </div>

                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Yeni Şifre
                                </label>
                                <input type="password" id="new_password" name="new_password" class="w-full"
                                    minlength="6" required />
                                <p class="text-xs text-gray-500 mt-1">En az 6 karakter olmalıdır</p>
                            </div>

                            <div>
                                <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Yeni Şifre Tekrar
                                </label>
                                <input type="password" id="confirm_password" name="confirm_password" class="w-full"
                                    required />
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="btn btn-primary">
                                    Şifreyi Değiştir
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Other sections (placeholder) -->
                <div id="wallet" class="profile-section" style="display: none;">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Cüzdan Bilgileri</h3>
                        <p class="text-gray-500">Bu özellik yakında eklenecek.</p>
                    </div>
                </div>

                <div id="addresses" class="profile-section" style="display: none;">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Adreslerim</h3>
                        <p class="text-gray-500">Bu özellik yakında eklenecek.</p>
                    </div>
                </div>

                <div id="notifications" class="profile-section" style="display: none;">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Bildirim Ayarları</h3>
                        <p class="text-gray-500">Bu özellik yakında eklenecek.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Profile form submit
        document.getElementById('profile-form').addEventListener('submit', handleProfileSubmit);

        // Password form submit
        document.getElementById('password-form').addEventListener('submit', handlePasswordSubmit);

        // Password confirmation validation
        const confirmPassword = document.getElementById('confirm_password');
        confirmPassword.addEventListener('blur', function () {
            const newPassword = document.getElementById('new_password').value;
            if (this.value && this.value !== newPassword) {
                this.setCustomValidity('Şifreler eşleşmiyor');
            } else {
                this.setCustomValidity('');
            }
        });
    });

    function showSection(sectionId) {
        // Hide all sections
        const sections = document.querySelectorAll('.profile-section');
        sections.forEach(section => section.style.display = 'none');

        // Show selected section
        document.getElementById(sectionId).style.display = 'block';

        // Update navigation
        const navLinks = document.querySelectorAll('.profile-nav-link');
        navLinks.forEach(link => link.classList.remove('active'));
        event.target.classList.add('active');
    }

    // ✅ YENİ — .NET Backend API'ye bağlı
    async function handleProfileSubmit(e) {
        e.preventDefault();

        const formData = new FormData(e.target);
        const data = {
            FullName: formData.get('full_name'),
            PhoneNumber: formData.get('phone')
        };

        try {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                showToast('Oturum süresi dolmuş. Lütfen tekrar giriş yapın.', 'error');
                setTimeout(() => { window.location.href = '/login'; }, 1500);
                return;
            }

            const res = await fetch(`${API_BASE}/api/User/profile`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(data)
            });

            const response = await res.json();

            if (!res.ok) {
                // 401 = Token süresi dolmuş
                if (res.status === 401) {
                    showToast('Oturum süresi dolmuş. Lütfen tekrar giriş yapın.', 'error');
                    localStorage.removeItem('auth_token');
                    setTimeout(() => { window.location.href = '/login'; }, 1500);
                    return;
                }
                throw new Error(response.error || response.message || 'Profil güncellenemedi.');
            }

            // localStorage'daki kullanıcı adını da güncelle (header'da görünsün diye)
            localStorage.setItem('user_name', data.FullName);
            showToast('Profil bilgileri başarıyla güncellendi!', 'success');

        } catch (error) {
            if (error.message.includes('Failed to fetch')) {
                showToast('Sunucuya bağlanılamadı.', 'error');
            } else {
                showToast(error.message, 'error');
            }
        }
    }
    // ✅ YENİ — .NET Backend API'ye bağlı
    async function handlePasswordSubmit(e) {
        e.preventDefault();

        const formData = new FormData(e.target);
        const newPassword = formData.get('new_password');
        const confirmPassword = formData.get('confirm_password');

        if (newPassword !== confirmPassword) {
            showToast('Yeni şifreler eşleşmiyor.', 'error');
            return;
        }

        // Backend ChangePasswordDto: Email, CurrentPassword, NewPassword
        const data = {
            Email: localStorage.getItem('user_email'),
            CurrentPassword: formData.get('current_password'),
            NewPassword: newPassword
        };

        try {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                showToast('Oturum süresi dolmuş. Lütfen tekrar giriş yapın.', 'error');
                setTimeout(() => { window.location.href = '/login'; }, 1500);
                return;
            }

            const res = await fetch(`${API_BASE}/api/Auth/change-password`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(data)
            });

            const response = await res.json();

            if (!res.ok) {
                if (res.status === 401) {
                    showToast('Oturum süresi dolmuş. Lütfen tekrar giriş yapın.', 'error');
                    localStorage.removeItem('auth_token');
                    setTimeout(() => { window.location.href = '/login'; }, 1500);
                    return;
                }
                if (res.status === 403) {
                    showToast('Hesabınız henüz doğrulanmamış. Lütfen e-posta doğrulamasını tamamlayın.', 'error');
                    return;
                }
                throw new Error(response.error || response.message || 'Şifre değiştirilemedi.');
            }


            showToast('Şifreniz başarıyla değiştirildi!', 'success');
            e.target.reset();

        } catch (error) {
            if (error.message.includes('Failed to fetch')) {
                showToast('Sunucuya bağlanılamadı.', 'error');
            } else {
                showToast(error.message, 'error');
            }
        }
    }

</script>

<style>
    .profile-nav-link {
        color: rgb(75 85 99);
        transition: all 0.2s;
    }

    .profile-nav-link:hover {
        color: rgb(17 24 39);
        background-color: rgb(249 250 251);
    }

    .profile-nav-link.active {
        color: rgb(37 99 235);
        background-color: rgb(239 246 255);
    }
</style>