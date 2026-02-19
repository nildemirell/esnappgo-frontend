<?php
// URL'den role parametresini al
$selected_role = $_GET['role'] ?? 'customer';

// Eğer kullanıcı zaten giriş yapmışsa dashboard'a yönlendir
if ($current_user) {
    echo '<script>window.location.href = "/dashboard";</script>';
    exit;
}
?>

<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <h2 class="text-3xl font-bold gradient-text">EsnappGO</h2>
            <h3 class="mt-6 text-2xl font-bold text-gray-900">
                Hesap oluşturun
            </h3>
            <p class="mt-2 text-sm text-gray-600">
                Zaten hesabınız var mı? 
                <a href="/login" class="font-medium text-blue-600 hover:text-blue-500">
                    Giriş yapın
                </a>
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form id="register-form" class="space-y-6">
                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Hesap türünüz nedir?
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 <?php echo $selected_role === 'customer' ? 'border-blue-500 bg-blue-50' : 'border-gray-300'; ?>">
                            <input
                                type="radio"
                                name="role"
                                value="customer"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                <?php echo $selected_role === 'customer' ? 'checked' : ''; ?>
                            />
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Müşteri</div>
                                <div class="text-xs text-gray-500">Alışveriş yapmak istiyorum</div>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 <?php echo $selected_role === 'student' ? 'border-blue-500 bg-blue-50' : 'border-gray-300'; ?>">
                            <input
                                type="radio"
                                name="role"
                                value="student"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                <?php echo $selected_role === 'student' ? 'checked' : ''; ?>
                            />
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Öğrenci</div>
                                <div class="text-xs text-gray-500">Ürün fotoğrafları çekerek para kazanmak istiyorum</div>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 <?php echo $selected_role === 'merchant' ? 'border-blue-500 bg-blue-50' : 'border-gray-300'; ?>">
                            <input
                                type="radio"
                                name="role"
                                value="merchant"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                <?php echo $selected_role === 'merchant' ? 'checked' : ''; ?>
                            />
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Esnaf</div>
                                <div class="text-xs text-gray-500">Ürünlerimi satmak istiyorum</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700">
                        Ad Soyad
                    </label>
                    <div class="mt-1">
                        <input
                            id="full_name"
                            name="full_name"
                            type="text"
                            autocomplete="name"
                            required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Adınız ve soyadınız"
                        />
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        E-posta adresi
                    </label>
                    <div class="mt-1">
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="ornek@email.com"
                        />
                    </div>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        Telefon numarası
                    </label>
                    <div class="mt-1">
                        <input
                            id="phone"
                            name="phone"
                            type="tel"
                            autocomplete="tel"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="0533 616 02 18"
                        />
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Şifre
                    </label>
                    <div class="mt-1">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            required
                            minlength="6"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="En az 6 karakter"
                        />
                    </div>
                    <p class="mt-1 text-xs text-gray-500">En az 6 karakter olmalıdır</p>
                </div>

                <div>
                    <label for="password_confirm" class="block text-sm font-medium text-gray-700">
                        Şifre tekrarı
                    </label>
                    <div class="mt-1">
                        <input
                            id="password_confirm"
                            name="password_confirm"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Şifrenizi tekrar girin"
                        />
                    </div>
                </div>

                <div class="flex items-center">
                    <input
                        id="terms"
                        name="terms"
                        type="checkbox"
                        required
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    />
                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                        <a href="/terms" class="text-blue-600 hover:text-blue-500" target="_blank">Kullanım Koşulları</a> ve 
                        <a href="/privacy" class="text-blue-600 hover:text-blue-500" target="_blank">Gizlilik Politikası</a>'nı kabul ediyorum
                    </label>
                </div>

                <div>
                    <button
                        type="submit"
                        id="register-btn"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 11a1 1 0 102 0v3a1 1 0 11-2 0v-3zm2-4a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <span id="register-btn-text">Hesap Oluştur</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('register-form');
    const submitBtn = document.getElementById('register-btn');
    const submitBtnText = document.getElementById('register-btn-text');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Validation
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirm').value;
        
        if (password !== passwordConfirm) {
            showToast('Şifreler eşleşmiyor', 'error');
            return;
        }
        
        // Disable button
        submitBtn.disabled = true;
        submitBtnText.textContent = 'Hesap oluşturuluyor...';
        
        try {
            const formData = new FormData(form);
            const data = {
                full_name: formData.get('full_name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                password: formData.get('password'),
                role: formData.get('role')
            };
            
            const response = await apiCall('auth/register', {
                method: 'POST',
                body: JSON.stringify(data)
            });
            
            if (response.success) {
                showToast('Hesap başarıyla oluşturuldu! Giriş yapılıyor...', 'success');
                
                // Auto login after successful registration
                setTimeout(async () => {
                    try {
                        const loginResponse = await apiCall('auth/login', {
                            method: 'POST',
                            body: JSON.stringify({
                                email: data.email,
                                password: data.password
                            })
                        });
                        
                        if (loginResponse.success) {
                            window.location.href = '/dashboard';
                        } else {
                            window.location.href = '/login';
                        }
                    } catch (error) {
                        window.location.href = '/login';
                    }
                }, 1500);
            } else {
                showToast(response.message || 'Kayıt başarısız', 'error');
            }
            
        } catch (error) {
            showToast(error.message, 'error');
        } finally {
            // Re-enable button
            submitBtn.disabled = false;
            submitBtnText.textContent = 'Hesap Oluştur';
        }
    });
    
    // Auto-focus first input
    document.getElementById('full_name').focus();
    
    // Password confirmation validation
    const passwordConfirm = document.getElementById('password_confirm');
    passwordConfirm.addEventListener('blur', function() {
        const password = document.getElementById('password').value;
        if (this.value && this.value !== password) {
            this.setCustomValidity('Şifreler eşleşmiyor');
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>
