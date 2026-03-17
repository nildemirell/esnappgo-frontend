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
                                value="musteri"
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
                                value="ogrenci"
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
                                value="esnaf"
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

                <!-- Ad Soyad -->
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

                <!-- E-posta -->
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

                <!-- Telefon (Görev 1: Placeholder düzeltildi + format validasyonu) -->
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
                            placeholder="05XX XXX XX XX"
                            maxlength="14"
                        />
                    </div>
                    <p id="phone-error" class="mt-1 text-xs text-red-500 hidden">Geçerli bir telefon numarası girin (05XX XXX XX XX)</p>
                </div>

                <!-- Şifre (Görev 4: Göster/gizle + Görev 5: Güçlük göstergesi) -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Şifre
                    </label>
                    <div class="mt-1 relative">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            required
                            minlength="6"
                            class="appearance-none block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="En az 6 karakter"
                        />
                        <button type="button" class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600" data-target="password" aria-label="Şifreyi göster/gizle">
                            <svg class="eye-open h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg class="eye-closed h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m-2.411-2.411L3 3"/>
                            </svg>
                        </button>
                    </div>
                    <!-- Şifre güçlük göstergesi (Görev 5) -->
                    <div class="mt-2">
                        <div class="flex space-x-1">
                            <div id="str-1" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                            <div id="str-2" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                            <div id="str-3" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                            <div id="str-4" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                        </div>
                        <p id="strength-text" class="mt-1 text-xs text-gray-500">En az 6 karakter olmalıdır</p>
                    </div>
                </div>

                <!-- Şifre Tekrarı (Görev 4: Göster/gizle + Görev 7: Anlık eşleşme kontrolü) -->
                <div>
                    <label for="password_confirm" class="block text-sm font-medium text-gray-700">
                        Şifre tekrarı
                    </label>
                    <div class="mt-1 relative">
                        <input
                            id="password_confirm"
                            name="password_confirm"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="appearance-none block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Şifrenizi tekrar girin"
                        />
                        <button type="button" class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600" data-target="password_confirm" aria-label="Şifreyi göster/gizle">
                            <svg class="eye-open h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg class="eye-closed h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m-2.411-2.411L3 3"/>
                            </svg>
                        </button>
                    </div>
                    <p id="password-match-error" class="mt-1 text-xs text-red-500 hidden">Şifreler eşleşmiyor</p>
                </div>

                <!-- Kullanım Koşulları -->
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

                <!-- Submit Butonu -->
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
        // GÖREV 1: Telefon validasyonu (dolu ama geçersizse engelle)
        // ----------------------------------------------------------
        const phoneDigits = document.getElementById('phone').value.replace(/\D/g, '');
        if (phoneDigits.length > 0 && (phoneDigits.length !== 11 || !phoneDigits.startsWith('05'))) {
            showToast('Geçerli bir telefon numarası girin (05XX XXX XX XX)', 'error');
            document.getElementById('phone').focus();
            return;
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
            
            // Kullanıcının seçtiği Türkçe rolü, Backend'in anladığı İngilizce role çeviriyoruz
            const selectedRole = formData.get('role');
            let backendRole = "Customer"; // Varsayılan
            
            if (selectedRole === "musteri") backendRole = "Customer";
            else if (selectedRole === "ogrenci") backendRole = "Student";
            else if (selectedRole === "esnaf") backendRole = "Merchant";

            const data = {
                fullName: formData.get('full_name'),
                email: formData.get('email'),
                phoneNumber: formData.get('phone'), // Boşluklu formatıyla gidiyor (0533 616 02 18), sorun yoksa kalsın. İstersen boşlukları silebilirsin.
                password: formData.get('password'),
                role: backendRole // Düzeltilmiş İngilizce rol gidiyor
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
                        if (res.ok) {
                showToast('Hesap başarıyla oluşturuldu! Lütfen giriş yapın.', 'success');

                form.dataset.success = 'true';
                
                // Kayıt olan kullanıcıyı doğrudan Login sayfasına yönlendiriyoruz
                setTimeout(() => {
                    window.location.href = '/login';
                }, 1500);

                return;
            } else {

                showToast(response.message || 'Kayıt başarısız', 'error');
            }
            
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
        roleRadios.forEach(function(radio) {
            const card = radio.closest('label');
            if (radio.checked) {
                card.classList.remove('border-gray-300');
                card.classList.add('border-blue-500', 'bg-blue-50');
            } else {
                card.classList.remove('border-blue-500', 'bg-blue-50');
                card.classList.add('border-gray-300');
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
            this.classList.remove('border-red-500');
            this.classList.add('border-gray-300');
            return;
        }

        // Doluysa: 11 hane olmalı ve 05 ile başlamalı
        if (digits.length !== 11 || !digits.startsWith('05')) {
            phoneError.classList.remove('hidden');
            this.classList.add('border-red-500');
            this.classList.remove('border-gray-300');
        } else {
            phoneError.classList.add('hidden');
            this.classList.remove('border-red-500');
            this.classList.add('border-gray-300');
        }
    });

    // Alana odaklanıldığında kırmızıyı kaldır (tekrar deneme hissi)
    phoneInput.addEventListener('focus', function() {
        phoneError.classList.add('hidden');
        this.classList.remove('border-red-500');
        this.classList.add('border-gray-300');
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
            this.classList.add('border-red-500');
            this.classList.remove('border-gray-300');
            this.setCustomValidity('Şifreler eşleşmiyor');
        } else {
            matchError.classList.add('hidden');
            this.classList.remove('border-red-500');
            this.classList.add('border-gray-300');
            this.setCustomValidity('');
        }
    });
    // ------------------------------------------------------------------
});
</script>
