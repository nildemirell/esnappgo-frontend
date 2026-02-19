<?php
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
                Hesabınıza giriş yapın
            </h3>
            <p class="mt-2 text-sm text-gray-600">
                Hesabınız yok mu? 
                <a href="/register" class="font-medium text-blue-600 hover:text-blue-500">
                    Kayıt olun
                </a>
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form id="login-form" class="space-y-6">
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
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Şifre
                    </label>
                    <div class="mt-1">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="••••••••"
                        />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember-me"
                            name="remember-me"
                            type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        />
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                            Beni hatırla
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="/forgot-password" class="font-medium text-blue-600 hover:text-blue-500">
                            Şifrenizi mi unuttunuz?
                        </a>
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        id="login-btn"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <span id="login-btn-text">Giriş Yap</span>
                    </button>
                </div>
            </form>

            <!-- Social Login (Optional) -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Veya</span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="/register" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span>Yeni hesap oluştur</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('login-form');
    const submitBtn = document.getElementById('login-btn');
    const submitBtnText = document.getElementById('login-btn-text');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Disable button
        submitBtn.disabled = true;
        submitBtnText.textContent = 'Giriş yapılıyor...';
        
        try {
            const formData = new FormData(form);
            const data = {
                email: formData.get('email'),
                password: formData.get('password')
            };
            
            const response = await apiCall('auth/login', {
                method: 'POST',
                body: JSON.stringify(data)
            });
            
            if (response.success) {
                showToast('Giriş başarılı! Yönlendiriliyorsunuz...', 'success');
                
                // Redirect after success
                setTimeout(() => {
                    const urlParams = new URLSearchParams(window.location.search);
                    const redirect = urlParams.get('redirect') || '/dashboard';
                    window.location.href = redirect;
                }, 1500);
            } else {
                showToast(response.message || 'Giriş başarısız', 'error');
            }
            
        } catch (error) {
            showToast(error.message, 'error');
        } finally {
            // Re-enable button
            submitBtn.disabled = false;
            submitBtnText.textContent = 'Giriş Yap';
        }
    });
    
    // Auto-focus first input
    document.getElementById('email').focus();
});
</script>
