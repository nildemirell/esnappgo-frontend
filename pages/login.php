<?php
// Eğer kullanıcı zaten giriş yapmışsa dashboard'a yönlendir
if ($current_user) {
    echo '<script>window.location.href = "/dashboard";</script>';
    exit;
}
?>

<div class="py-10 bg-gray-50 flex items-center justify-center p-4 sm:p-6 font-sans min-h-[calc(100vh-100px)] w-full">
    <div class="bg-white w-full max-w-5xl rounded-[32px] overflow-hidden flex shadow-[0_20px_50px_rgba(0,0,0,0.1)] min-h-[600px]">
        <!-- Left Section: Illustration/Branding -->
        <div class="w-5/12 bg-[#E9E9E9] hidden md:flex flex-col items-center justify-center relative p-8">
            <div class="absolute top-10 left-10">
                <h2 class="text-3xl font-bold text-black tracking-tight" style="font-family: 'Inter', sans-serif;">EsnappGO<span class="text-blue-600">.</span></h2>
            </div>
            <!-- Interactive Canvas Illustration -->
            <div class="w-full h-full flex items-center justify-center relative mt-8">
                <canvas id="dribbbleCanvas" width="450" height="450" class="max-w-full drop-shadow-xl"></canvas>
            </div>
            <!-- Interactive Canvas Illustration End -->
            <div class="absolute bottom-10 left-10 right-10 text-center">
                <p class="text-gray-500 font-medium tracking-wide">Alışverişe başlamak için hemen giriş yapın.</p>
            </div>
        </div>
        
        <!-- Right Section: Form -->
        <div class="w-full md:w-7/12 p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
            <div class="w-full max-w-sm mx-auto">
                <div class="md:hidden text-center mb-8">
                    <h2 class="text-4xl font-bold text-black tracking-tight">EsnappGO<span class="text-blue-600">.</span></h2>
                </div>
                
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight">Tekrar hoş geldin!</h1>
                <p class="text-base text-gray-500 mt-2 mb-10">Lütfen giriş bilgilerinizi girin.</p>
                
                <form id="login-form" class="space-y-6">
                    <!-- Email -->
                  <div class="pb-6 mb-2"> <div class="relative mt-2">
        <input id="email" name="email" type="email" autocomplete="email" required
               class="peer block w-full rounded-lg border border-gray-300 bg-transparent py-3 px-4 text-gray-900 focus:border-black focus:ring-0 sm:text-base font-medium transition-colors"
               style="-webkit-box-shadow: 0 0 0px 1000px white inset;"
               placeholder=" " />
         <label for="email" class="pointer-events-none absolute left-0 top-14 text-sm font-semibold text-gray-500 transition-all peer-placeholder-shown:top-14 peer-focus:top-14 peer-[&:-webkit-autofill]:top-14">
             E-posta
         </label>
    </div>
</div>

<div class="pb-6 mb-2"> <div class="relative">
        <input id="password" name="password" type="password" autocomplete="current-password" required
               class="peer block w-full rounded-lg border border-gray-300 bg-transparent py-3 px-4 text-gray-900 focus:border-black focus:ring-0 sm:text-base font-medium transition-colors pr-12"
               style="-webkit-box-shadow: 0 0 0px 1000px white inset;"
               placeholder=" " />
         <label for="password" class="pointer-events-none absolute left-0 top-14 text-sm font-semibold text-gray-500 transition-all peer-placeholder-shown:top-14 peer-focus:top-14 peer-[&:-webkit-autofill]:top-14">
             Şifre
         </label>
        
        <button type="button" id="toggle-password"
                class="absolute top-3 right-3 flex items-center px-2 text-gray-400 hover:text-black focus:outline-none bg-transparent"
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
                    <!-- Form Actions row -->
                    <div class="flex items-center justify-between pt-2">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                   class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded cursor-pointer">
                            <label for="remember-me" class="ml-2 block text-sm font-medium text-gray-600 cursor-pointer">
                                30 gün hatırla
                            </label>
                        </div>
                        <div class="text-sm">
                            <a href="/forgot-password" class="font-semibold text-gray-900 hover:underline">
                                Şifremi unuttum?
                            </a>
                        </div>
                    </div>
                    
                    <!-- Login Button -->
                    <div class="pt-6">
                        <button type="submit" id="login-btn"
                                class="group relative w-full flex justify-center py-3.5 px-4 border-[3px] border-black text-base font-bold rounded-full text-white bg-black hover:bg-white hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            <span id="login-btn-text">Log In</span>
                        </button>
                    </div>
                    
                    <!-- Google Button Removal (Keep empty or remove this block) -->
                    
                </form>
                
                <div class="mt-10 text-center font-medium text-sm text-gray-500">
                    Hesabınız yok mu? 
                    <a href="/register" class="font-bold text-black hover:underline">
                        Kayıt olun
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

            submitBtn.disabled = true;
            submitBtnText.textContent = 'Giriş yapılıyor...';

            try {
                const formData = new FormData(form);
                const data = {
     email: formData.get('email'),
    password: formData.get('password')
};


                const res = await fetch(`${API_BASE}/api/Auth/login`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                const response = await res.json();
                
                if (!res.ok) {
                    let errorData = response;
                    if (typeof response.error === 'string') {
                        try { errorData = JSON.parse(response.error); } catch(e) {}
                    }

                    const errorMessages = {
                        'invalid_credentials': 'E-posta adresi veya şifre hatalı.',
                        'user_not_found': 'Bu e-posta adresiyle kayıtlı bir hesap bulunamadı.',
                        'account_disabled': 'Hesabınız askıya alınmış. Destek ile iletişime geçin.',
                        'too_many_requests': 'Çok fazla deneme yaptınız. Lütfen biraz bekleyin.'
                    };
                    const userMessage = errorMessages[errorData.error_code]
                        || errorData.msg
                        || errorData.message
                        || (typeof response.error === 'string' ? response.error : '')
                        || 'Giriş başarısız';

                                    // Doğrulanmamış hesap: OTP sayfasına yönlendir
if (
    res.status === 403 ||
    errorData.error_code === 'not_verified' ||
    errorData.error_code === 'email_not_verified' ||
    userMessage.includes('Email not confirmed')
) {
    showToast('Hesabınız henüz doğrulanmamış. OTP sayfasına yönlendiriliyorsunuz...', 'warning');
    const emailVal = document.getElementById('email') ? document.getElementById('email').value : '';
    setTimeout(() => {
        window.location.href = '/verify-otp?email=' + encodeURIComponent(emailVal);
    }, 1500);
    return;
}

                    if(window.triggerSadFaces) { window.triggerSadFaces(); }
                    throw new Error(userMessage);
                }
                
                if (response.token) {
    localStorage.setItem('auth_token', response.token);
    localStorage.setItem('user_name', response.fullName);
    localStorage.setItem('user_email', response.email);
    localStorage.setItem('user_role', response.role);
    if (response.phoneNumber) {
        localStorage.setItem('user_phone', response.phoneNumber);
    }


                    await fetch('/api/auth/bridge', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        credentials: 'include',
                        body: JSON.stringify({
                            email: response.email,
                            fullName: response.fullName,
                            role: response.role
                        })
                    });

                    showToast('Giriş başarılı! Yönlendiriliyorsunuz...', 'success');
                    setTimeout(() => {
                        const urlParams = new URLSearchParams(window.location.search);
                        const redirect = urlParams.get('redirect') || '/dashboard';
                        window.location.href = redirect;
                    }, 1500);
                } else {
                    showToast(response.message || 'Giriş başarısız', 'error');
                }

            } catch (error) {
                if(window.triggerSadFaces) { window.triggerSadFaces(); }
                
                if (error.message.includes('Failed to fetch') || error.message.includes('fetch')) {
                    showToast('Sunucuya bağlanılamadı. İnternet bağlantınızı kontrol edin.', 'error');
                } else {
                    showToast(error.message || 'Giriş yapılamadı, lütfen tekrar deneyin.', 'error');
                }
            }
            finally {
                submitBtn.disabled = false;
                submitBtnText.textContent = 'Log In';
            }
        });

        document.getElementById('toggle-password').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
                if(window.toggleCanvasPasswordView) window.toggleCanvasPasswordView(true);
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
                if(window.toggleCanvasPasswordView) window.toggleCanvasPasswordView(false);
            }
        });

        // --- MODERN E-TİCARET ANİMASYONU ---
        const canvas = document.getElementById("dribbbleCanvas");
        if(canvas) {
            const ctx = canvas.getContext("2d");
            const lerp = (start, end, amt) => (1 - amt) * start + amt * end;

            let targetMouseX = canvas.width / 2;
            let targetMouseY = canvas.height / 2;
            let currentMouseX = canvas.width / 2;
            let currentMouseY = canvas.height / 2;

            let isEmailFocus = false;
            let isPasswordFocus = false;
            let isPasswordVisible = false; 
            let isSad = false;
            let blinkState = 0; 
            let sadTimeout;

            let targetFaceOffsetX = 0;
            let currentFaceOffsetX = 0;

            setInterval(() => {
                if(!isEmailFocus && !isPasswordFocus && !isSad && !isPasswordVisible) {
                    blinkState = 1;
                    setTimeout(() => { blinkState = 0; }, 150);
                }
            }, 4000);

            document.addEventListener("mousemove", (e) => {
                const rect = canvas.getBoundingClientRect();
                targetMouseX = e.clientX - rect.left;
                targetMouseY = e.clientY - rect.top;
            });

            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            emailInput.addEventListener('focus', () => { isEmailFocus = true; isSad = false; });
            emailInput.addEventListener('blur', () => { isEmailFocus = false; });
            
            passwordInput.addEventListener('focus', () => { isPasswordFocus = true; isSad = false; });
            passwordInput.addEventListener('blur', () => { isPasswordFocus = false; });

            function drawModernFace(cx, cy) {
                const isTyping = isEmailFocus || isPasswordFocus;
                const mouseDX = currentMouseX - (cx + canvas.width/2);
                const mouseDY = currentMouseY - (cy + canvas.height/2);

                if (isPasswordVisible || isSad) {
                    ctx.fillStyle = isSad ? "rgba(96, 165, 250, 0.3)" : "rgba(244, 63, 94, 0.4)";
                    ctx.beginPath(); ctx.arc(cx - 22, cy + 5, 8, 0, Math.PI*2); ctx.fill();
                    ctx.beginPath(); ctx.arc(cx + 22, cy + 5, 8, 0, Math.PI*2); ctx.fill();
                }

                ctx.strokeStyle = "#1E293B"; 
                ctx.lineWidth = 3.5;
                ctx.lineCap = "round";
                ctx.lineJoin = "round";

                if (isPasswordVisible) {
                    ctx.beginPath();
                    ctx.moveTo(cx - 24, cy - 3); ctx.lineTo(cx - 16, cy + 2); ctx.lineTo(cx - 24, cy + 7);
                    ctx.moveTo(cx + 24, cy - 3); ctx.lineTo(cx + 16, cy + 2); ctx.lineTo(cx + 24, cy + 7);
                    ctx.stroke();
                    ctx.beginPath(); ctx.arc(cx, cy + 12, 4, 0, Math.PI*2); ctx.fillStyle = "#1E293B"; ctx.fill();
                    return;
                }

                if (isSad) {
                    ctx.beginPath();
                    ctx.arc(cx - 16, cy + 4, 7, Math.PI, Math.PI * 2);
                    ctx.arc(cx + 16, cy + 4, 7, Math.PI, Math.PI * 2);
                    ctx.stroke();
                    ctx.fillStyle = "#60A5FA";
                    ctx.beginPath(); ctx.arc(cx - 16, cy + 12, 3, 0, Math.PI*2); ctx.fill();
                    ctx.beginPath(); ctx.arc(cx, cy + 18, 7, Math.PI, Math.PI * 2); ctx.stroke();
                    return;
                }

                if (isTyping || blinkState === 1) {
                    ctx.beginPath();
                    ctx.moveTo(cx - 22, cy); ctx.lineTo(cx - 10, cy);
                    ctx.moveTo(cx + 10, cy); ctx.lineTo(cx + 22, cy);
                    ctx.stroke();
                    ctx.beginPath(); ctx.moveTo(cx - 5, cy + 10); ctx.lineTo(cx + 5, cy + 10); ctx.stroke();
                    return;
                }

                ctx.fillStyle = "#ffffff";
                ctx.beginPath(); ctx.arc(cx - 16, cy, 10, 0, Math.PI*2); ctx.fill();
                ctx.beginPath(); ctx.arc(cx + 16, cy, 10, 0, Math.PI*2); ctx.fill();

                const angle = Math.atan2(mouseDY, mouseDX);
                const dist = Math.min(4, Math.hypot(mouseDX, mouseDY) / 30);
                const px1 = (cx - 16) + Math.cos(angle) * dist;
                const py1 = cy + Math.sin(angle) * dist;
                const px2 = (cx + 16) + Math.cos(angle) * dist;
                const py2 = cy + Math.sin(angle) * dist;

                ctx.fillStyle = "#1E293B";
                ctx.beginPath(); ctx.arc(px1, py1, 5, 0, Math.PI*2); ctx.fill();
                ctx.beginPath(); ctx.arc(px2, py2, 5, 0, Math.PI*2); ctx.fill();

                ctx.beginPath(); ctx.arc(cx, cy + 8, 7, 0, Math.PI); ctx.stroke();
            }

            function animate() {
                currentMouseX = lerp(currentMouseX, targetMouseX, 0.08);
                currentMouseY = lerp(currentMouseY, targetMouseY, 0.08);
                currentFaceOffsetX = lerp(currentFaceOffsetX, targetFaceOffsetX, 0.1);

                ctx.clearRect(0, 0, canvas.width, canvas.height);

                const globalTiltX = (currentMouseX - canvas.width/2) * 0.04;
                const globalTiltY = (currentMouseY - canvas.height/2) * 0.04;

                const setShadow = () => { ctx.shadowColor = "rgba(0,0,0,0.15)"; ctx.shadowBlur = 25; ctx.shadowOffsetY = 15; };
                const resetShadow = () => { ctx.shadowColor = "transparent"; };

                // 1. KAĞIT PARA (En Arka Sağ)
                ctx.save();
                ctx.translate(270 + globalTiltX * 0.8, 170 + globalTiltY * 0.8);
                ctx.rotate((-10 + globalTiltX * 0.2) * Math.PI / 180);
                const pathCash = () => { ctx.beginPath(); ctx.roundRect(-70, -35, 140, 70, 8); };

                setShadow(); pathCash(); ctx.fillStyle = "#10B981"; ctx.fill(); resetShadow(); 
                ctx.beginPath(); ctx.roundRect(-62, -27, 124, 54, 4);
                ctx.strokeStyle = "rgba(255,255,255,0.25)"; ctx.lineWidth = 2; ctx.stroke(); 
                
                ctx.save(); pathCash(); ctx.clip();
                drawModernFace(currentFaceOffsetX, 0);
                ctx.restore();
                ctx.restore();

                // 2. CÜZDAN (Orta Sol - Paranın üstüne biniyor)
                ctx.save();
                ctx.translate(160 + globalTiltX * 1.0, 180 + globalTiltY * 1.0);
                ctx.rotate((8 + globalTiltX * 0.3) * Math.PI / 180);
                const pathWallet = () => { ctx.beginPath(); ctx.roundRect(-60, -40, 120, 80, 12); };
                
                ctx.fillStyle = "#3B82F6"; 
                ctx.beginPath(); ctx.roundRect(-40, -60, 55, 40, 6); ctx.fill();
                
                setShadow(); pathWallet(); ctx.fillStyle = "#F97316"; ctx.fill(); resetShadow(); 
                ctx.beginPath(); ctx.roundRect(-60, -40, 120, 30, {tl:12, tr:12, bl:0, br:0});
                ctx.fillStyle = "#EA580C"; ctx.fill(); 
                
                ctx.save(); pathWallet(); ctx.clip();
                drawModernFace(currentFaceOffsetX * (isPasswordVisible ? -1 : 1), 5);
                ctx.restore();
                ctx.restore();

                // 3. ALIŞVERİŞ SEPETİ (Ön Sol - Cüzdanın alt kısmını kapatıyor)
                ctx.save();
                ctx.translate(180 + globalTiltX * 1.3, 270 + globalTiltY * 1.3);
                ctx.rotate((-4 + globalTiltX * 0.5) * Math.PI / 180);
                const pathBasket = () => { ctx.beginPath(); ctx.roundRect(-65, -30, 130, 80, [10, 10, 25, 25]); };

                ctx.strokeStyle = "#A78BFA"; ctx.lineWidth = 8; ctx.lineCap = "round"; ctx.lineJoin = "round";
                ctx.beginPath(); ctx.moveTo(-45, -20); ctx.lineTo(-55, -60); ctx.lineTo(55, -60); ctx.lineTo(45, -20); ctx.stroke();
                
                setShadow(); pathBasket(); ctx.fillStyle = "#8B5CF6"; ctx.fill(); resetShadow(); 
                
                ctx.save(); pathBasket(); ctx.clip();
                drawModernFace(currentFaceOffsetX * (isPasswordVisible ? -1 : 1), 10);
                ctx.restore();
                ctx.restore();

                // 4. ALTIN BOZUK PARALAR (En Ön Sağ - Sepetle kağıt paranın arasını dolduruyor)
                ctx.save();
                ctx.translate(280 + globalTiltX * 1.5, 250 + globalTiltY * 1.5);
                ctx.rotate((6 + globalTiltX * 0.6) * Math.PI / 180);
                const pathCoinFront = () => { ctx.beginPath(); ctx.arc(12, -12, 38, 0, Math.PI*2); };

                ctx.fillStyle = "#F59E0B"; ctx.beginPath(); ctx.arc(-15, 15, 38, 0, Math.PI*2); ctx.fill();
                ctx.strokeStyle = "#B45309"; ctx.lineWidth = 4; ctx.beginPath(); ctx.arc(-15, 15, 28, 0, Math.PI*2); ctx.stroke();
                
                setShadow(); pathCoinFront(); ctx.fillStyle = "#FCD34D"; ctx.fill(); resetShadow();
                ctx.strokeStyle = "#F59E0B"; ctx.lineWidth = 4; ctx.beginPath(); ctx.arc(12, -12, 28, 0, Math.PI*2); ctx.stroke();

                ctx.save(); pathCoinFront(); ctx.clip();
                drawModernFace(12 + currentFaceOffsetX, -12);
                ctx.restore();
                ctx.restore();

                requestAnimationFrame(animate);
            }

            animate();

            window.triggerSadFaces = function() {
                isSad = true;
                clearTimeout(sadTimeout);
                sadTimeout = setTimeout(() => {
                    isSad = false;
                }, 3000); 
            };

            window.toggleCanvasPasswordView = function(isVisible) {
                isPasswordVisible = isVisible;
                if(isVisible) {
                    targetFaceOffsetX = 70; 
                } else {
                    targetFaceOffsetX = 0;
                }
            };
        }
    });
</script>