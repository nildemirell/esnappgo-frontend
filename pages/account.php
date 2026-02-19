<?php
// Giriş kontrolü
if (!$current_user) {
    header('Location: /login?redirect=/account');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Hesap Ayarları</h1>
            <p class="text-gray-600">Hesap bilgilerinizi ve güvenlik ayarlarınızı yönetin</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Account Navigation -->
            <div class="lg:col-span-1">
                <nav class="bg-white rounded-lg shadow-sm p-4 space-y-1">
                    <a href="#personal-info" onclick="showSection('personal-info')" class="account-nav-link active flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Kişisel Bilgiler
                    </a>
                    
                    <a href="#security" onclick="showSection('security')" class="account-nav-link flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Güvenlik
                    </a>
                    
                    <a href="#notifications" onclick="showSection('notifications')" class="account-nav-link flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM7 7h10a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"></path>
                        </svg>
                        Bildirimler
                    </a>
                    
                    <a href="#privacy" onclick="showSection('privacy')" class="account-nav-link flex items-center px-3 py-2 text-sm font-medium rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Gizlilik
                    </a>
                    
                    <a href="#delete-account" onclick="showSection('delete-account')" class="account-nav-link flex items-center px-3 py-2 text-sm font-medium rounded-md text-red-600">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hesabı Sil
                    </a>
                </nav>
            </div>
            
            <!-- Account Content -->
            <div class="lg:col-span-2">
                <!-- Personal Information -->
                <div id="personal-info" class="account-section">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Kişisel Bilgiler</h3>
                        
                        <form id="personal-info-form" class="space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Ad Soyad
                                    </label>
                                    <input
                                        type="text"
                                        id="full_name"
                                        name="full_name"
                                        value="<?php echo htmlspecialchars($current_user['full_name']); ?>"
                                        class="w-full"
                                        required
                                    />
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        E-posta
                                    </label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="<?php echo htmlspecialchars($current_user['email']); ?>"
                                        class="w-full bg-gray-100"
                                        disabled
                                    />
                                    <p class="text-xs text-gray-500 mt-1">E-posta adresi değiştirilemez</p>
                                </div>
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Telefon
                                </label>
                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    value="<?php echo htmlspecialchars($current_user['phone'] ?? ''); ?>"
                                    class="w-full"
                                    placeholder="0533 616 02 18"
                                />
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="btn btn-primary">
                                    Değişiklikleri Kaydet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Security -->
                <div id="security" class="account-section" style="display: none;">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Güvenlik Ayarları</h3>
                        
                        <!-- Password Change -->
                        <div class="mb-8">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Şifre Değiştir</h4>
                            <form id="password-form" class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Mevcut Şifre
                                    </label>
                                    <input
                                        type="password"
                                        id="current_password"
                                        name="current_password"
                                        class="w-full"
                                        required
                                    />
                                </div>
                                
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Yeni Şifre
                                    </label>
                                    <input
                                        type="password"
                                        id="new_password"
                                        name="new_password"
                                        class="w-full"
                                        minlength="6"
                                        required
                                    />
                                </div>
                                
                                <div>
                                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Yeni Şifre Tekrar
                                    </label>
                                    <input
                                        type="password"
                                        id="confirm_password"
                                        name="confirm_password"
                                        class="w-full"
                                        required
                                    />
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" class="btn btn-primary">
                                        Şifreyi Değiştir
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Two Factor Authentication -->
                        <div class="border-t border-gray-200 pt-8">
                            <h4 class="text-md font-medium text-gray-900 mb-4">İki Faktörlü Doğrulama</h4>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">
                                            Yakında Gelecek
                                        </h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>İki faktörlü doğrulama özelliği yakında eklenecek.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Notifications -->
                <div id="notifications" class="account-section" style="display: none;">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Bildirim Ayarları</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">E-posta Bildirimleri</h4>
                                    <p class="text-sm text-gray-500">Sipariş durumu ve önemli güncellemeler</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">SMS Bildirimleri</h4>
                                    <p class="text-sm text-gray-500">Kritik güncellemeler için SMS</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Pazarlama E-postaları</h4>
                                    <p class="text-sm text-gray-500">Kampanyalar ve özel teklifler</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button class="btn btn-primary">
                                Ayarları Kaydet
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Privacy -->
                <div id="privacy" class="account-section" style="display: none;">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Gizlilik Ayarları</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Profil Görünürlüğü</h4>
                                    <p class="text-sm text-gray-500">Profilinizin diğer kullanıcılara görünürlüğü</p>
                                </div>
                                <select class="text-sm border border-gray-300 rounded-md px-3 py-1">
                                    <option>Herkese Açık</option>
                                    <option>Sadece Arkadaşlar</option>
                                    <option>Gizli</option>
                                </select>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Veri Toplama</h4>
                                    <p class="text-sm text-gray-500">Analitik ve iyileştirme amaçlı veri toplama</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button class="btn btn-primary">
                                Ayarları Kaydet
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Delete Account -->
                <div id="delete-account" class="account-section" style="display: none;">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-red-900 mb-6">Hesabı Sil</h3>
                        
                        <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        Dikkat!
                                    </h3>
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
                                <input
                                    type="text"
                                    id="delete_confirmation"
                                    name="delete_confirmation"
                                    class="w-full"
                                    placeholder="HESABI SİL"
                                    required
                                />
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="btn btn-error">
                                    Hesabı Kalıcı Olarak Sil
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form handlers
    document.getElementById('personal-info-form').addEventListener('submit', handlePersonalInfoSubmit);
    document.getElementById('password-form').addEventListener('submit', handlePasswordSubmit);
    document.getElementById('delete-account-form').addEventListener('submit', handleDeleteAccountSubmit);
});

function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('.account-section');
    sections.forEach(section => section.style.display = 'none');
    
    // Show selected section
    document.getElementById(sectionId).style.display = 'block';
    
    // Update navigation
    const navLinks = document.querySelectorAll('.account-nav-link');
    navLinks.forEach(link => link.classList.remove('active'));
    event.target.classList.add('active');
}

async function handlePersonalInfoSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const data = {
        full_name: formData.get('full_name'),
        phone: formData.get('phone')
    };
    
    try {
        const response = await apiCall('users/profile', {
            method: 'PUT',
            body: JSON.stringify(data)
        });
        
        if (response.success) {
            showToast('Bilgiler güncellendi', 'success');
        }
        
    } catch (error) {
        showToast(error.message, 'error');
    }
}

async function handlePasswordSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const newPassword = formData.get('new_password');
    const confirmPassword = formData.get('confirm_password');
    
    if (newPassword !== confirmPassword) {
        showToast('Yeni şifreler eşleşmiyor', 'error');
        return;
    }
    
    const data = {
        current_password: formData.get('current_password'),
        new_password: newPassword
    };
    
    try {
        const response = await apiCall('users/password', {
            method: 'PUT',
            body: JSON.stringify(data)
        });
        
        if (response.success) {
            showToast('Şifre başarıyla değiştirildi', 'success');
            e.target.reset();
        }
        
    } catch (error) {
        showToast(error.message, 'error');
    }
}

async function handleDeleteAccountSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const confirmation = formData.get('delete_confirmation');
    
    if (confirmation !== 'HESABI SİL') {
        showToast('Onay metni hatalı', 'error');
        return;
    }
    
    if (!confirm('Hesabınızı kalıcı olarak silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!')) {
        return;
    }
    
    try {
        // API endpoint eklenecek
        showToast('Hesap silme işlemi yakında eklenecek', 'info');
        
    } catch (error) {
        showToast(error.message, 'error');
    }
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
