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
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="ornek@email.com" />
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Şifre
                    </label>
                    <div class="mt-1 relative">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="appearance-none block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="••••••••" />
                        <button type="button" id="toggle-password"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                            aria-label="Şifreyi göster/gizle">
                            <svg id="eye-open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-closed" class="h-5 w-5 hidden" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m-2.411-2.411L3 3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                            Beni hatırla
                        </label>
                    </div>
                    <!-- Şifremi unuttum linki -->
                    <div class="text-sm">
                        <a href="/forgot-password" class="font-medium text-blue-600 hover:text-blue-500">
                            Şifrenizi mi unuttunuz?
                        </a>
                    </div>
                </div>


                <div>
                    <button type="submit" id="login-btn"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <span id="login-btn-text">Giriş Yap</span>
                    </button>
                </div>
            </form>

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
                    <a href="/register"
                        class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span>Yeni hesap oluştur</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('login-form');
        const submitBtn = document.getElementById('login-btn');
        const submitBtnText = document.getElementById('login-btn-text');

        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            // Disable button
            submitBtn.disabled = true;
            submitBtnText.textContent = 'Giriş yapılıyor...';

            try {
                const formData = new FormData(form);
                const data = {
                    email: formData.get('email'),
                    password: formData.get('password'),
                    // Beni hatırla verisini de ekledik
                    remember_me: formData.get('remember-me') === 'on'
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
                // error.message 'Failed to fetch' içeriyorsa → ağ/sunucu sorunu
                // İçermiyorsa → kimlik doğrulama hatası (yanlış şifre vb.)
                if (error.message.includes('Failed to fetch') || error.message.includes('fetch')) {
                    showToast('Sunucuya bağlanılamadı. İnternet bağlantınızı kontrol edin.', 'error');
                } else {
                    // Backend'den gelen hata mesajını olduğu gibi göster
                    // Örn: "E-posta veya şifre hatalı", "Hesap askıya alındı" vb.
                    showToast(error.message || 'Giriş yapılamadı, lütfen tekrar deneyin.', 'error');
                }
            }
            finally {
                // Re-enable button
                submitBtn.disabled = false;
                submitBtnText.textContent = 'Giriş Yap';
            }



        });

        // Auto-focus first input
        document.getElementById('email').focus();

        // Göz butonu: tıklama olayını dinle 
        document.getElementById('toggle-password').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                // Şifreyi görünür yap
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');    // Açık gözü gizle
                eyeClosed.classList.remove('hidden'); // Kapalı gözü göster
            } else {
                // Şifreyi tekrar gizle
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden'); // Açık gözü göster
                eyeClosed.classList.add('hidden');  // Kapalı gözü gizle
            }
        });
    });
</script>