<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-blue-600">EsnappGO</h2>
            <h3 class="mt-6 text-2xl font-bold text-gray-900">
                Yeni Şifre Belirleme
            </h3>
            <p class="mt-2 text-sm text-gray-600">
                Lütfen hesabınız için yeni bir şifre belirleyin.
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form id="final-reset-form" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">E-posta Adresiniz</label>
                    <div class="mt-1">
                        <input id="email" type="email" readonly 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-500 cursor-not-allowed sm:text-sm" />
                    </div>
                </div>

                <div>
                    <label for="new-password" class="block text-sm font-medium text-gray-700">Yeni Şifre</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="new-password" type="password" required 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                        <button type="button" onclick="togglePassword('new-password', 'eye-1-show', 'eye-1-hide')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                            <svg id="eye-1-show" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg id="eye-1-hide" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="confirm-password" class="block text-sm font-medium text-gray-700">Yeni Şifre (Tekrar)</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="confirm-password" type="password" required 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                        <button type="button" onclick="togglePassword('confirm-password', 'eye-2-show', 'eye-2-hide')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                            <svg id="eye-2-show" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg id="eye-2-hide" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" id="save-btn" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md text-white bg-blue-600 hover:bg-blue-700 font-medium">
                    Şifreyi Güncelle
                </button>
            </form>

            <div id="success-screen" class="hidden text-center py-4">
                <div class="text-green-600 font-bold text-xl mb-2">Şifreniz Güncellendi!</div>
                <p class="text-gray-600 mb-6">Artık yeni şifrenizle giriş yapabilirsiniz.</p>
                <a href="/login" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Giriş Yap</a>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, showId, hideId) {
    const input = document.getElementById(inputId);
    const show = document.getElementById(showId);
    const hide = document.getElementById(hideId);
    if (input.type === 'password') {
        input.type = 'text';
        show.classList.remove('hidden');
        hide.classList.add('hidden');
    } else {
        input.type = 'password';
        show.classList.add('hidden');
        hide.classList.remove('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('final-reset-form');
    const emailInput = document.getElementById('email');
    const saveBtn = document.getElementById('save-btn');
    
    // URL'den bilgileri yakala
    const urlParams = new URLSearchParams(window.location.search);
    const emailValue = urlParams.get('email');
    const tokenValue = urlParams.get('token');

    if (emailValue) emailInput.value = emailValue;

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const pass = document.getElementById('new-password').value;
        const confirm = document.getElementById('confirm-password').value;

        if (pass !== confirm) {
            showToast('Şifreler eşleşmiyor!', 'error');
            return;
        }

        saveBtn.disabled = true;
        saveBtn.textContent = 'Güncelleniyor...';

        try {
            const res = await fetch(`${API_BASE}/api/Auth/set-new-password`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    email: emailValue, 
                    token: tokenValue, 
                    newPassword: pass 
                })
            });

            if (!res.ok) {
                const data = await res.json();
                throw new Error(data.message || 'Bir hata oluştu.');
            }

            form.classList.add('hidden');
            document.getElementById('success-screen').classList.remove('hidden');
            showToast('Şifre başarıyla değiştirildi!', 'success');

        } catch (error) {
            showToast(error.message, 'error');
            saveBtn.disabled = false;
            saveBtn.textContent = 'Şifreyi Güncelle';
        }
    });
});
</script>