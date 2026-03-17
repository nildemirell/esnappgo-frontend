<?php
// URL'den gelen e-posta adresini alıyoruz (Güvenlik için htmlspecialchars kullanıyoruz)
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';


?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hesap Doğrulama | EsnappGO</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            E-postanızı Doğrulayın
        </h2>
               <p class="mt-2 text-center text-sm text-gray-600">
            <?php if (!empty($email)): ?>
                <span class="font-medium text-blue-600"><?php echo $email; ?></span> adresine gönderdiğimiz 6 haneli kodu girin.
            <?php else: ?>
                Lütfen e-posta adresinizi ve mailinize gelen 6 haneli kodu girin.
            <?php endif; ?>
        </p>

    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            
            <form id="otp-form" class="space-y-6">
                                <?php if (!empty($email)): ?>
                    <input type="hidden" id="email" value="<?php echo $email; ?>">
                <?php else: ?>
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700">E-posta adresiniz</label>
                        <input type="email" id="email" required class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="ornek@email.com">
                    </div>
                <?php endif; ?>

                <div class="flex justify-between gap-2">
                    <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-semibold text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-semibold text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-semibold text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-semibold text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-semibold text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-semibold text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>

                <div id="error-message" class="text-red-500 text-sm text-center hidden"></div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Hesabımı Doğrula
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.otp-input');
            const form = document.getElementById('otp-form');
            const errorMessage = document.getElementById('error-message');

            // Kutucuklar arası otomatik geçiş mantığı
            inputs.forEach((input, index) => {
                input.addEventListener('input', function() {
                    // Sadece rakam girilmesini sağla
                    this.value = this.value.replace(/[^0-9]/g, '');
                    
                    if (this.value !== '') {
                        // Eğer son kutuda değilsek bir sonrakine geç
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                    }
                });

                // Silme tuşuna (Backspace) basınca bir öncekine dön
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value === '') {
                        if (index > 0) {
                            inputs[index - 1].focus();
                        }
                    }
                });
            });

            // Form Gönderildiğinde
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Sayfanın yenilenmesini engelle
                
                // Tüm kutulardaki değerleri birleştir
                let otpCode = '';
                inputs.forEach(input => {
                    otpCode += input.value;
                });

                const email = document.getElementById('email').value;

                if (otpCode.length !== 6) {
                    errorMessage.textContent = 'Lütfen 6 haneli kodu eksiksiz girin.';
                    errorMessage.classList.remove('hidden');
                    return;
                }

                // Hata mesajını gizle ve işlemlere başla
                errorMessage.classList.add('hidden');
                console.log("Gönderilecek Veri:", { email: email, code: otpCode });
                
                               // Backend'in beklediği adrese POST isteği atıyoruz
                fetch(`${API_BASE}/api/Auth/verify-otp`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email: email.trim(), otpCode: otpCode.trim() })
                })
                .then(async res => {
                    const responseData = await res.json();
                    if (!res.ok) {
                        // Eğer backend özel bir mesaj gönderiyorsa (örn: Kullanıcı bulunamadı, Kod hatalı) onu fırlat
                        let backendMessage = responseData.message || responseData.msg || (responseData.error && responseData.error.message) || "Girdiğiniz kod hatalı veya süresi dolmuş.";
                        throw new Error(backendMessage);
                    }
                    return responseData;
                })
                .then(data => {
                    // API'den "success" gibi bir dönüş bekliyorsanız kontrol edebilirsiniz, yoksa direkt başarılı farz ediyoruz.
                    showToast("Hesabınız başarıyla doğrulandı!", "success");
                    setTimeout(() => { window.location.href = '/login'; }, 1500);
                })
                .catch(error => {
                    errorMessage.textContent = error.message;
                    errorMessage.classList.remove('hidden');
                });
            });
        });
    </script>
</body>
</html>
