<?php
// URL'den role parametresini al
$selected_role = $_GET['role'] ?? 'customer';

// Eğer kullanıcı zaten giriş yapmışsa dashboard'a yönlendir
if ($current_user) {
    echo '<script>window.location.href = "/dashboard";</script>';
    exit;
}
?>

<style>
.register-bg {
    background-color: #f8fafc;
}
.register-bg::before {
    content: '';
    position: absolute;
    top: -10%;
    right: -5%;
    width: 50vw;
    height: 50vw;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.05) 0%, transparent 60%);
    border-radius: 50%;
    pointer-events: none;
}
.register-bg::after {
    content: '';
    position: absolute;
    bottom: -10%;
    left: -5%;
    width: 40vw;
    height: 40vw;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.04) 0%, transparent 60%);
    border-radius: 50%;
    pointer-events: none;
}
</style>

<div class="register-bg relative min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans overflow-hidden">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center relative z-10">
            <h2 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 tracking-tight pb-1">
                EsnappGO
            </h2>
            <h3 class="mt-4 text-2xl font-bold text-gray-800">
                Hesap oluşturun
            </h3>
            <p class="mt-2 text-sm text-gray-500">
                Zaten hesabınız var mı? 
                <a href="/login" class="font-semibold text-blue-600 hover:text-blue-500 transition-colors">
                    Giriş yapın
                </a>
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-xl relative z-10">
        <div class="bg-white/80 backdrop-blur-lg py-10 px-6 shadow-2xl shadow-blue-900/5 sm:rounded-2xl sm:px-12 border border-white">
            <form id="register-form" class="space-y-7">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-4">
                        Hesap türünüz nedir?
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="relative flex flex-col items-center p-4 border rounded-xl cursor-pointer transition-all duration-200 hover:shadow-md <?php echo $selected_role === 'customer' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-blue-300 bg-white'; ?>">
                            <input
                                type="radio"
                                name="role"
                                value="musteri"
                                class="sr-only"
                                <?php echo $selected_role === 'customer' ? 'checked' : ''; ?>
                            />
                            <svg class="w-8 h-8 mb-2 <?php echo $selected_role === 'customer' ? 'text-blue-500' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <div class="text-sm font-bold text-gray-900 text-center">Müşteri</div>
                            <div class="text-[10px] text-gray-500 text-center mt-1 leading-tight">Alışveriş yapmak istiyorum</div>
                        </label>
                        
                        <label class="relative flex flex-col items-center p-4 border rounded-xl cursor-pointer transition-all duration-200 hover:shadow-md <?php echo $selected_role === 'student' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-blue-300 bg-white'; ?>">
                            <input
                                type="radio"
                                name="role"
                                value="ogrenci"
                                class="sr-only"
                                <?php echo $selected_role === 'student' ? 'checked' : ''; ?>
                            />
                            <svg class="w-8 h-8 mb-2 <?php echo $selected_role === 'student' ? 'text-blue-500' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div class="text-sm font-bold text-gray-900 text-center">Öğrenci</div>
                            <div class="text-[10px] text-gray-500 text-center mt-1 leading-tight">Fotoğraf çekerek kazan</div>
                        </label>
                        
                        <label class="relative flex flex-col items-center p-4 border rounded-xl cursor-pointer transition-all duration-200 hover:shadow-md <?php echo $selected_role === 'merchant' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-blue-300 bg-white'; ?>">
                            <input
                                type="radio"
                                name="role"
                                value="esnaf"
                                class="sr-only"
                                <?php echo $selected_role === 'merchant' ? 'checked' : ''; ?>
                            />
                            <svg class="w-8 h-8 mb-2 <?php echo $selected_role === 'merchant' ? 'text-blue-500' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V10l-7-5-7 5v11m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <div class="text-sm font-bold text-gray-900 text-center">Esnaf</div>
                            <div class="text-[10px] text-gray-500 text-center mt-1 leading-tight">Ürünlerimi satmak istiyorum</div>
                        </label>
                    </div>
                </div>

                <div id="shop-name-container" style="display: none;" class="animate-fade-in-down">
                    <label for="shop_name" class="block text-sm font-medium text-gray-700">
                        Mağaza / İşletme Adı
                    </label>
                    <div class="mt-2">
                        <input
                            id="shop_name"
                            name="shop_name"
                            type="text"
                            class="appearance-none block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition-colors sm:text-sm"
                            placeholder="İşletmenizin adını girin"
                        />
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Müşterileriniz ürünlerinizi bu isimle görecektir.</p>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700">
                            Ad Soyad
                        </label>
                        <div class="mt-2">
                            <input
                                id="full_name"
                                name="full_name"
                                type="text"
                                autocomplete="name"
                                required
                                class="appearance-none block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition-colors sm:text-sm"
                                placeholder="Örn: Ahmet Yılmaz"
                            />
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            E-posta adresi
                        </label>
                        <div class="mt-2">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                class="appearance-none block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition-colors sm:text-sm"
                                placeholder="ornek@email.com"
                            />
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">
                            Telefon numarası
                        </label>
                        <div class="mt-2">
                            <input
                                id="phone"
                                name="phone"
                                type="tel"
                                autocomplete="tel"
                                required
                                class="appearance-none block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition-colors sm:text-sm"
                                placeholder="05XX XXX XX XX"
                                maxlength="14"
                            />
                        </div>
                        <p id="phone-error" class="mt-2 text-xs text-red-500 hidden font-medium">Geçerli bir telefon numarası girin (05XX XXX XX XX)</p>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Şifre
                        </label>
                        <div class="mt-2 relative">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                required
                                minlength="6"
                                class="appearance-none block w-full px-4 py-3 pr-10 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition-colors sm:text-sm"
                                placeholder="En az 6 karakter"
                            />
                            <button type="button" class="toggle-password absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-blue-500 transition-colors" data-target="password" aria-label="Şifreyi göster/gizle">
                                <svg class="eye-open h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg class="eye-closed h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m-2.411-2.411L3 3"/>
                                </svg>
                            </button>
                        </div>
                        <div class="mt-3">
                            <div class="flex space-x-1.5">
                                <div id="str-1" class="h-1.5 flex-1 rounded-full bg-gray-200 transition-colors duration-300"></div>
                                <div id="str-2" class="h-1.5 flex-1 rounded-full bg-gray-200 transition-colors duration-300"></div>
                                <div id="str-3" class="h-1.5 flex-1 rounded-full bg-gray-200 transition-colors duration-300"></div>
                                <div id="str-4" class="h-1.5 flex-1 rounded-full bg-gray-200 transition-colors duration-300"></div>
                            </div>
                            <p id="strength-text" class="mt-2 text-xs font-medium text-gray-500">En az 6 karakter olmalıdır</p>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirm" class="block text-sm font-medium text-gray-700">
                            Şifre tekrarı
                        </label>
                        <div class="mt-2 relative">
                            <input
                                id="password_confirm"
                                name="password_confirm"
                                type="password"
                                autocomplete="new-password"
                                required
                                class="appearance-none block w-full px-4 py-3 pr-10 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition-colors sm:text-sm"
                                placeholder="Şifrenizi tekrar girin"
                            />
                            <button type="button" class="toggle-password absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-blue-500 transition-colors" data-target="password_confirm" aria-label="Şifreyi göster/gizle">
                                <svg class="eye-open h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg class="eye-closed h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m-2.411-2.411L3 3"/>
                                </svg>
                            </button>
                        </div>
                        <p id="password-match-error" class="mt-2 text-xs font-medium text-red-500 hidden">Şifreler eşleşmiyor</p>
                    </div>
                </div>

                <div class="flex items-start pt-2">
                    <div class="flex items-center h-5">
                        <input
                            id="terms"
                            name="terms"
                            type="checkbox"
                            required
                            class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer"
                        />
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-medium text-gray-600 cursor-pointer">
                            <a href="/terms" class="text-blue-600 hover:text-blue-500 underline decoration-blue-200 underline-offset-2" target="_blank">Kullanım Koşulları</a> ve 
                            <a href="/privacy" class="text-blue-600 hover:text-blue-500 underline decoration-blue-200 underline-offset-2" target="_blank">Gizlilik Politikası</a>'nı kabul ediyorum
                        </label>
                    </div>
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        id="register-btn"
                        class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md shadow-blue-500/30 transform transition-all duration-200 hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none"
                    >
                        <span class="absolute left-0 inset-y-0 flex items-center pl-4">
                            <svg class="h-5 w-5 text-blue-300 group-hover:text-blue-200 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 11a1 1 0 102 0v3a1 1 0 11-2 0v-3zm2-4a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <span id="register-btn-text" class="tracking-wide">Hesap Oluştur</span>
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

        // ----------------------------------------------------------
        // GÖREV 2: Ad Soyad validasyonu
        // ----------------------------------------------------------
        const fullName = document.getElementById('full_name').value.trim();
        if (fullName.length < 3) {
            showToast('Ad Soyad en az 3 karakter olmalıdır', 'error');
            document.getElementById('full_name').focus();
            return;
        }
        // Sadece harf, boşluk ve Türkçe karakterler kabul edilir
        if (!/^[a-zA-ZçÇğĞıİöÖşŞüÜ\s]+$/.test(fullName)) {
            showToast('Ad Soyad sadece harf içermelidir', 'error');
            document.getElementById('full_name').focus();
            return;
        }

        // ----------------------------------------------------------
        // GÖREV 1: Telefon validasyonu — ZORUNLU ALAN
        // ----------------------------------------------------------
        const phoneDigits = document.getElementById('phone').value.replace(/\D/g, '');
        if (phoneDigits.length === 0) {
            showToast('Telefon numarası zorunludur', 'error');
            document.getElementById('phone').focus();
            return;
        }
        if (phoneDigits.length !== 11 || !phoneDigits.startsWith('05')) {
            showToast('Geçerli bir telefon numarası girin (05XX XXX XX XX)', 'error');
            document.getElementById('phone').focus();
            return;
        }

        // Esnaf ise Mağaza Adı kontrolü
        const selectedRole = document.querySelector('input[name="role"]:checked')?.value;
        if (selectedRole === 'esnaf' || selectedRole === 'merchant') {
            const shopNameVal = document.getElementById('shop_name')?.value?.trim();
            if (!shopNameVal || shopNameVal.length < 2) {
                showToast('Esnaf hesabı için Mağaza Adı zorunludur', 'error');
                document.getElementById('shop_name').focus();
                return;
            }
        }

        // Şifre eşleşme kontrolü
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirm').value;
        
        if (password !== passwordConfirm) {
            showToast('Şifreler eşleşmiyor', 'error');
            return;
        }
        
        // Butonu disable et
        submitBtn.disabled = true;
        submitBtnText.textContent = 'Hesap oluşturuluyor...';
    
        try {
            const formData = new FormData(form);
            
           const role = formData.get('role');
           const data = {
    fullName: formData.get('full_name'),
    email: formData.get('email'),
    phoneNumber: formData.get('phone'),
    password: formData.get('password'),
    role: role, // musteri / ogrenci / esnaf — backend küçük harfli Türkçe bekliyor
    shopName: (role === 'esnaf' || role === 'merchant') ? formData.get('shop_name') : null
};


            const res = await fetch(`${API_BASE}/api/Auth/register`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
const response = await res.json();
if (!res.ok) {
    let errorData = response;
    
    // Eğer backend Supabase hatasını string (metin) olarak yolladıysa, onu JSON'a çevirmeye çalışıyoruz.
    if (typeof response.error === 'string') {
        try { errorData = JSON.parse(response.error); } catch(e) {}
    }

    // Spesifik hata kodlarını Türkçe mesajlarla eşleştir
    const errorMessages = {
        'user_already_exists': 'Bu e-posta adresi zaten kullanılıyor. Lütfen giriş yapmayı deneyin.',
        'invalid_email': 'Geçersiz bir e-posta adresi girdiniz.',
        'weak_password': 'Şifre çok zayıf. Lütfen daha güçlü bir şifre seçin.',
        'invalid_phone': 'Geçersiz telefon numarası.',
        'over_email_send_rate_limit': 'Çok fazla deneme yaptınız. Lütfen biraz bekleyip tekrar deneyin.'
    };

    // Supabase error formatını kontrol ederek çevrilmiş mesajı bul
    const userMessage = errorMessages[errorData.error_code]
        || errorData.msg
        || errorData.message
        || (typeof response.error === 'string' ? response.error : '')
        || 'Kayıt başarısız, lütfen bilgilerinizi kontrol edin.';

    throw new Error(userMessage);
}

// Başarılı kayıt
showToast('Hesabınız oluşturuldu! E-postanıza gönderilen kodu girin.', 'success');
form.dataset.success = 'true';
setTimeout(() => {
    window.location.href = '/verify-otp?email=' + encodeURIComponent(formData.get('email'));
}, 1500);
            
        } catch (error) {
            // GÖREV 6: Network hatası ayrımı
            if (error.message.includes('Failed to fetch') || error.message.includes('fetch')) {
                showToast('Sunucuya bağlanılamadı. İnternet bağlantınızı kontrol edin.', 'error');
            } else {
                showToast(error.message || 'Kayıt yapılamadı, lütfen tekrar deneyin.', 'error');
            }
        } finally {
            // GÖREV 3: Sadece başarılı kayıt DEĞİLSE butonu aktifleştir
            if (!form.dataset.success) {
                submitBtn.disabled = false;
                submitBtnText.textContent = 'Hesap Oluştur';
            }
        }
    });
    
    // İlk input'a odaklan
    document.getElementById('full_name').focus();

    // ------------------------------------------------------------------
    // ROL KARTI HIGHLIGHT — JS-Driven
    // ------------------------------------------------------------------
    const roleRadios = document.querySelectorAll('input[name="role"]');

    function updateRoleHighlight() {
        const shopNameContainer = document.getElementById('shop-name-container');
        const shopNameInput = document.getElementById('shop_name');

        roleRadios.forEach(function(radio) {
            const card = radio.closest('label');
            if (radio.checked) {
                card.classList.remove('border-gray-300', 'bg-white', 'hover:border-blue-300');
                card.classList.add('border-blue-500', 'bg-blue-50');
                
                // İkon rengini güncelle (Yeni eklenen görsel özellik için)
                const icon = card.querySelector('svg');
                if(icon) {
                    icon.classList.remove('text-gray-400');
                    icon.classList.add('text-blue-500');
                }
                
                if (radio.value === 'esnaf' || radio.value === 'merchant') {
                    if (shopNameContainer) shopNameContainer.style.display = 'block';
                    if (shopNameInput) shopNameInput.required = true;
                } else {
                    if (shopNameContainer) shopNameContainer.style.display = 'none';
                    if (shopNameInput) {
                        shopNameInput.required = false;
                        shopNameInput.value = '';
                    }
                }
            } else {
                card.classList.remove('border-blue-500', 'bg-blue-50');
                card.classList.add('border-gray-300', 'bg-white', 'hover:border-blue-300');
                
                // İkon rengini sıfırla
                const icon = card.querySelector('svg');
                if(icon) {
                    icon.classList.remove('text-blue-500');
                    icon.classList.add('text-gray-400');
                }
            }
        });
    }

    roleRadios.forEach(function(radio) {
        radio.addEventListener('change', updateRoleHighlight);
    });

    updateRoleHighlight();
    // ------------------------------------------------------------------

    // ------------------------------------------------------------------
    // GÖREV 1: TELEFON FORMAT KONTROLÜ
    // ------------------------------------------------------------------
    const phoneInput = document.getElementById('phone');
    const phoneError = document.getElementById('phone-error');

    // Kullanıcı her tuşta: sadece rakamları al, otomatik boşluk ekle
    phoneInput.addEventListener('input', function() {
        // İmleç konumunu hatırla
        var cursorPos = this.selectionStart;
        // Değiştirmeden önceki uzunluk
        var oldLength = this.value.length;

        // Sadece rakamları al
        var digits = this.value.replace(/\D/g, '');

        // Maksimum 11 rakam
        if (digits.length > 11) {
            digits = digits.substring(0, 11);
        }

        // Otomatik format: 0533 616 02 18
        var formatted = '';
        for (var i = 0; i < digits.length; i++) {
            // 4. rakamdan sonra boşluk (0533_)
            if (i === 4) formatted += ' ';
            // 7. rakamdan sonra boşluk (0533 616_)
            if (i === 7) formatted += ' ';
            // 9. rakamdan sonra boşluk (0533 616 02_)
            if (i === 9) formatted += ' ';
            formatted += digits[i];
        }

        this.value = formatted;

        // İmleç konumunu düzelt (yeni uzunluk farkı kadar kaydır)
        var newLength = this.value.length;
        var diff = newLength - oldLength;
        this.setSelectionRange(cursorPos + diff, cursorPos + diff);
    });

    // Alandan çıkıldığında (blur) geçerlilik kontrolü
    phoneInput.addEventListener('blur', function() {
        var digits = this.value.replace(/\D/g, '');

        // Boş bırakılabilir (opsiyonel alan)
        if (digits.length === 0) {
            phoneError.classList.add('hidden');
            this.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
            this.classList.add('border-gray-200', 'focus:ring-blue-500', 'focus:border-blue-500');
            return;
        }

        // Doluysa: 11 hane olmalı ve 05 ile başlamalı
        if (digits.length !== 11 || !digits.startsWith('05')) {
            phoneError.classList.remove('hidden');
            this.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
            this.classList.remove('border-gray-200', 'focus:ring-blue-500', 'focus:border-blue-500');
        } else {
            phoneError.classList.add('hidden');
            this.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
            this.classList.add('border-gray-200', 'focus:ring-blue-500', 'focus:border-blue-500');
        }
    });

    // Alana odaklanıldığında kırmızıyı kaldır (tekrar deneme hissi)
    phoneInput.addEventListener('focus', function() {
        phoneError.classList.add('hidden');
        this.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
        this.classList.add('border-gray-200', 'focus:ring-blue-500', 'focus:border-blue-500');
    });
    // ------------------------------------------------------------------

    // ------------------------------------------------------------------
    // GÖREV 4: ŞİFRE GÖSTER / GİZLE (her iki alan için tek kod)
    // ------------------------------------------------------------------
    document.querySelectorAll('.toggle-password').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var input = document.getElementById(this.dataset.target);
            var eyeOpen = this.querySelector('.eye-open');
            var eyeClosed = this.querySelector('.eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        });
    });
    // ------------------------------------------------------------------

    // ------------------------------------------------------------------
    // GÖREV 5: ŞİFRE GÜÇLÜK GÖSTERGESİ
    // ------------------------------------------------------------------
    var passwordInput = document.getElementById('password');
    var strengthText = document.getElementById('strength-text');
    var bars = [
        document.getElementById('str-1'),
        document.getElementById('str-2'),
        document.getElementById('str-3'),
        document.getElementById('str-4')
    ];

    passwordInput.addEventListener('input', function() {
        var val = this.value;
        var score = 0;

        if (val.length >= 6) score++;           // Yeterli uzunluk
        if (val.length >= 10) score++;          // Uzun şifre
        if (/[A-Z]/.test(val)) score++;         // Büyük harf var
        if (/[0-9]/.test(val)) score++;         // Rakam var
        if (/[^a-zA-Z0-9]/.test(val)) score++;  // Özel karakter var

        // Skor 0-5 arası → 4 seviyeye eşle
        var level = 0;
        if (score >= 1) level = 1; // Zayıf
        if (score >= 3) level = 2; // Orta
        if (score >= 4) level = 3; // Güçlü
        if (score >= 5) level = 4; // Çok güçlü

        var colors = ['bg-gray-200', 'bg-red-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
        var labels = ['En az 6 karakter olmalıdır', 'Zayıf', 'Orta', 'Güçlü', 'Çok güçlü'];
        var textColors = ['text-gray-500', 'text-red-500', 'text-yellow-600', 'text-blue-600', 'text-green-600'];

        // Tüm çubukları güncelle
        bars.forEach(function(bar, i) {
            // Eski renk sınıflarını temizle
            bar.classList.remove('bg-gray-200', 'bg-red-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500');
            // Yeni renk sınıfını ekle
            if (i < level) {
                bar.classList.add(colors[level]);
            } else {
                bar.classList.add('bg-gray-200');
            }
        });

        // Metin güncelle (şifre boşsa varsayılan metin)
        var idx = val.length === 0 ? 0 : level;
        strengthText.textContent = labels[idx];
        // Eski text renk sınıflarını temizle, yenisini ekle
        strengthText.classList.remove('text-gray-500', 'text-red-500', 'text-yellow-600', 'text-blue-600', 'text-green-600');
        strengthText.classList.add(textColors[idx]);
    });
    // ------------------------------------------------------------------

    // ------------------------------------------------------------------
    // GÖREV 7: ŞİFRE TEKRARI ANLIK GÖRSEL GERİ BİLDİRİM
    // ------------------------------------------------------------------
    var passwordConfirmInput = document.getElementById('password_confirm');
    var matchError = document.getElementById('password-match-error');

    passwordConfirmInput.addEventListener('input', function() {
        var pw = document.getElementById('password').value;
        if (this.value && this.value !== pw) {
            matchError.classList.remove('hidden');
            this.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
            this.classList.remove('border-gray-200', 'focus:ring-blue-500', 'focus:border-blue-500');
            this.setCustomValidity('Şifreler eşleşmiyor');
        } else {
            matchError.classList.add('hidden');
            this.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
            this.classList.add('border-gray-200', 'focus:ring-blue-500', 'focus:border-blue-500');
            this.setCustomValidity('');
        }
    });
    // ------------------------------------------------------------------
});
</script>