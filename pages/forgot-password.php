<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <h2 class="text-3xl font-bold gradient-text">EsnappGO</h2>
            <h3 class="mt-6 text-2xl font-bold text-gray-900">
                Şifre Sıfırlama
            </h3>
            <p class="mt-2 text-sm text-gray-600">
                E-posta adresinizi girin, size şifre sıfırlama bağlantısı gönderelim
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
                    <button
                        type="submit"
                        id="reset-btn"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                        </span>
                        <span id="reset-btn-text">Sıfırlama Bağlantısı Gönder</span>
                    </button>
                </div>
            </form>

            <!-- Success Message -->
            <div id="success-message" class="mt-6" style="display: none;">
                <div class="bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">
                                E-posta gönderildi!
                            </h3>
                            <div class="mt-2 text-sm text-green-700">
                                <p>Şifre sıfırlama bağlantısı e-posta adresinize gönderildi. E-postanızı kontrol edin.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back to Login -->
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
                    <a href="/login" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span>Giriş sayfasına dön</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('forgot-password-form');
    const submitBtn = document.getElementById('reset-btn');
    const submitBtnText = document.getElementById('reset-btn-text');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Disable button
        submitBtn.disabled = true;
        submitBtnText.textContent = 'Gönderiliyor...';
        
        try {
            const formData = new FormData(form);
            const email = formData.get('email');
            
            // API endpoint eklenecek
            // Şimdilik mock response
            await new Promise(resolve => setTimeout(resolve, 2000)); // Simulate API call
            
            // Hide form and show success message
            form.style.display = 'none';
            document.getElementById('success-message').style.display = 'block';
            
        } catch (error) {
            showToast(error.message, 'error');
        } finally {
            // Re-enable button
            submitBtn.disabled = false;
            submitBtnText.textContent = 'Sıfırlama Bağlantısı Gönder';
        }
    });
    
    // Auto-focus email input
    document.getElementById('email').focus();
});
</script>
