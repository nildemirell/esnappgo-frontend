<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <h2 class="text-3xl font-bold gradient-text">EsnappGO</h2>
            <h3 class="mt-6 text-2xl font-bold text-gray-900" id="page-title">
                Şifre Sıfırlama
            </h3>
            <p class="mt-2 text-sm text-gray-600" id="page-desc">
                E-posta adresinizi girin, size şifre sıfırlama kodu gönderelim
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form id="forgot-password-form" class="space-y-6">
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
                    <button type="submit" id="reset-btn"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="reset-btn-text">Sıfırlama Kodu Gönder</span>
                    </button>
                </div>
            </form>

            <div id="code-entry-section" style="display: none;" class="space-y-6">
                <div class="flex flex-col items-center">
                    <div class="flex gap-2 mb-6" id="otp-inputs">
                        <input type="text" maxlength="1"
                            class="w-12 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" />
                        <input type="text" maxlength="1"
                            class="w-12 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" />
                        <input type="text" maxlength="1"
                            class="w-12 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" />
                        <input type="text" maxlength="1"
                            class="w-12 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" />
                        <input type="text" maxlength="1"
                            class="w-12 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" />
                        <input type="text" maxlength="1"
                            class="w-12 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none" />
                    </div>
                </div>
                <button id="verify-btn"
                    class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                    Hesabımı Doğrula
                </button>
            </div>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm"><span
                            class="px-2 bg-white text-gray-500">Veya</span></div>
                </div>
                <div class="mt-6">
                    <a href="/login"
                        class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        <span>Giriş sayfasına dön</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('forgot-password-form');
        const submitBtn = document.getElementById('reset-btn');
        const submitBtnText = document.getElementById('reset-btn-text');
        const codeSection = document.getElementById('code-entry-section');
        const verifyBtn = document.getElementById('verify-btn');
        const otpInputs = document.querySelectorAll('#otp-inputs input');

        let savedEmail = "";

        // OTP Kutucukları Mantığı (Otomatik atlama ve silme)
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });

        // 1. ADIM: E-POSTA GÖNDERME
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            submitBtn.disabled = true;
            submitBtnText.textContent = 'Gönderiliyor...';

            try {
                const emailValue = document.getElementById('email').value;
                savedEmail = emailValue;

                const res = await fetch(`${API_BASE}/api/Auth/reset-password`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email: emailValue })
                });

                if (!res.ok) {
                    const responseData = await res.json();
                    throw new Error(responseData.error || responseData.message || 'Hata oluştu.');
                }

                if (typeof showToast === 'function') showToast('Doğrulama kodu e-postanıza gönderildi.', 'success');

                // Görsel Değişim
                form.style.display = 'none';
                codeSection.style.display = 'block';
                document.getElementById('page-title').textContent = "E-postanızı Doğrulayın";
                // Mail adresini mavi ve link gibi gösteren tasarım
                document.getElementById('page-desc').innerHTML = `<span class="text-blue-600 font-medium">${emailValue}</span> adresine gönderdiğimiz 6 haneli kodu girin.`;
                otpInputs[0].focus();

            } catch (error) {
                showToast(error.message, 'error');
                submitBtn.disabled = false;
                submitBtnText.textContent = 'Sıfırlama Kodu Gönder';
            }
        });

        verifyBtn.addEventListener('click', async function () {
            let code = "";
            otpInputs.forEach(input => code += input.value);
            if (code.length < 6) { showToast('Lütfen 6 haneli kodu tam girin.', 'error'); return; }

            verifyBtn.disabled = true;
            verifyBtn.textContent = 'Doğrulanıyor...';

            try {
                const res = await fetch(`${API_BASE}/api/Auth/verify-otp`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email: savedEmail, otpCode: code })
                });
                if (!res.ok) {
                    const errData = await res.json();
                    throw new Error(errData.error || errData.message || 'Kod hatalı veya süresi dolmuş.');
                }
                window.location.href = `/reset-password?email=${encodeURIComponent(savedEmail)}&token=${encodeURIComponent(code)}`;
            } catch (error) {
                showToast(error.message, 'error');
                verifyBtn.disabled = false;
                verifyBtn.textContent = 'Kodu Doğrula';
            }
        });

    });
</script>