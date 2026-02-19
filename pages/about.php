<div class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white py-24 overflow-hidden">
        <div class="pointer-events-none absolute -top-24 -left-24 w-[500px] h-[500px] rounded-full bg-blue-500 opacity-20 blur-3xl animate-pulse"></div>
        <div class="pointer-events-none absolute -bottom-32 -right-20 w-[600px] h-[600px] rounded-full bg-purple-500 opacity-20 blur-3xl" style="animation: pulse 4s ease-in-out infinite;"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center px-6 py-3 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-blue-200 font-semibold mb-8">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>TÜRKİYE'NİN İLK ÖĞRENCİ DESTEKLİ E-TİCARET PLATFORMU</span>
            </div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-8 leading-tight">
                <span class="bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">
                    EsnappGO
                </span>
                <br />
                <span class="bg-gradient-to-r from-blue-200 to-purple-200 bg-clip-text text-transparent">
                    Hakkında
                </span>
            </h1>
            
            <p class="text-xl md:text-2xl mb-12 text-blue-100 max-w-4xl mx-auto leading-relaxed">
                Alışverişi <span class="font-bold text-white">sosyal değer yaratmanın</span> bir aracı haline getiren 
                <br />
                <span class="font-semibold text-yellow-300">devrimsel e-ticaret platformu</span>
            </p>
            
            <!-- Key Stats -->
            <?php
            // Gerçek istatistikleri veritabanından çek
            $db = $database->getConnection();
            $aboutStudentCount = $db->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn();
            $aboutMerchantCount = $db->query("SELECT COUNT(*) FROM users WHERE role = 'merchant'")->fetchColumn();
            $aboutProductCount = $db->query("SELECT COUNT(*) FROM products WHERE status = 'active'")->fetchColumn();
            $aboutCustomerCount = $db->query("SELECT COUNT(*) FROM users WHERE role = 'customer'")->fetchColumn();
            
            function formatAboutCount($count) {
                if ($count >= 10000) {
                    return number_format($count / 1000, 1, '.', '') . 'K+';
                } elseif ($count >= 1000) {
                    return number_format($count / 1000, 1, '.', '') . 'K+';
                } else {
                    return $count . '+';
                }
            }
            ?>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl font-bold text-yellow-300 mb-2"><?php echo formatAboutCount($aboutStudentCount); ?></div>
                    <div class="text-sm text-blue-200">Aktif Öğrenci</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl font-bold text-yellow-300 mb-2"><?php echo formatAboutCount($aboutMerchantCount); ?></div>
                    <div class="text-sm text-blue-200">Yerel Esnaf</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl font-bold text-yellow-300 mb-2"><?php echo formatAboutCount($aboutProductCount); ?></div>
                    <div class="text-sm text-blue-200">Ürün</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl font-bold text-yellow-300 mb-2"><?php echo formatAboutCount($aboutCustomerCount); ?></div>
                    <div class="text-sm text-blue-200">Mutlu Müşteri</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="relative py-24 bg-gradient-to-br from-teal-50 via-blue-50 to-indigo-100 overflow-hidden">
        <!-- Soft Organic Background -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <svg class="absolute top-1/4 left-0 transform -translate-x-1/2" width="600" height="600" viewBox="0 0 600 600" fill="none">
                <path d="M300,50 C450,50 550,150 550,300 C550,450 450,550 300,550 C150,550 50,450 50,300 C50,150 150,50 300,50 Z" fill="rgba(16, 185, 129, 0.04)" opacity="0.3"/>
            </svg>
            <svg class="absolute top-1/2 right-0 transform translate-x-1/3" width="500" height="500" viewBox="0 0 500 500" fill="none">
                <ellipse cx="250" cy="250" rx="200" ry="150" fill="rgba(139, 92, 246, 0.03)" opacity="0.4"/>
            </svg>
            <svg class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/4" width="400" height="400" viewBox="0 0 400 400" fill="none">
                <circle cx="200" cy="200" r="150" fill="rgba(251, 191, 36, 0.03)" opacity="0.3"/>
            </svg>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Mission -->
                <div class="bg-white rounded-3xl shadow-xl p-10">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-8">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">🌟 Misyonumuz</h2>
                    <p class="text-lg text-gray-700 font-semibold mb-6 leading-relaxed">
                        E-ticareti sadece bir alışveriş alanı olmaktan çıkarıp, gençlerin geleceğini güçlendiren ve yerel ekonomiyi canlandıran bir değer ekosistemine dönüştürmek.
                    </p>
                    <p class="text-base text-gray-600 mb-6 leading-relaxed">
                        EsnappGO olarak amacımız, üniversite öğrencilerinin sahada ürettikleri gerçek içerikleri; yerel esnafların güvenle doğruladığı ürünlerle buluşturmak ve bu işbirliğini topluma fayda sağlayan kalıcı bir modele dönüştürmektir.
                    </p>
                    
                    <div class="space-y-6 mb-6">
                        <div class="bg-blue-50 p-5 rounded-xl">
                            <h4 class="font-semibold text-blue-900 mb-3">Bu ekosistemde her öğrenci;</h4>
                            <ul class="space-y-2 text-blue-800">
                                <li class="flex items-start">
                                    <span class="text-blue-600 mr-2">✓</span>
                                    <span>gelir elde eder,</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-blue-600 mr-2">✓</span>
                                    <span>iş tecrübesi kazanır,</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-blue-600 mr-2">✓</span>
                                    <span>kendi potansiyelini keşfeder.</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="bg-green-50 p-5 rounded-xl">
                            <h4 class="font-semibold text-green-900 mb-3">Her esnaf;</h4>
                            <ul class="space-y-2 text-green-800">
                                <li class="flex items-start">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span>dijitalleşir,</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span>yeni müşterilere ulaşır,</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span>ekonomik olarak güç kazanır.</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="bg-purple-50 p-5 rounded-xl">
                            <h4 class="font-semibold text-purple-900 mb-3">Her müşteri;</h4>
                            <ul class="space-y-2 text-purple-800">
                                <li class="flex items-start">
                                    <span class="text-purple-600 mr-2">✓</span>
                                    <span>güvenle alışveriş yaparken,</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-purple-600 mr-2">✓</span>
                                    <span>şehrin geleceğine katkıda bulunur.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <p class="text-base text-gray-700 font-medium leading-relaxed">
                        Biz, ekonomik döngüleri gençlerin enerjisiyle yeniden tasarlıyor ve <span class="text-blue-600 font-semibold">"her alışveriş topluma değer katmalı"</span> fikrini merkezimize alıyoruz.
                    </p>
                </div>

                <!-- Vision -->
                <div class="bg-white rounded-3xl shadow-xl p-10">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-8">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">🚀 Vizyonumuz</h2>
                    <p class="text-lg text-gray-700 font-semibold mb-6 leading-relaxed">
                        Türkiye'de ve dünyada sosyal değer odaklı e-ticaretin öncüsü olmak; gençleri üretimin merkezine koyan, yerel ekonomileri güçlendiren ve sürdürülebilir bir gelecek inşa eden küresel bir model yaratmak.
                    </p>
                    <p class="text-base text-gray-600 mb-6 leading-relaxed">
                        Geleceğin ticaret dünyasında gençlerin yalnızca tüketici değil, <span class="font-semibold text-purple-600">üretici, araştırmacı ve değişim taşıyıcıları</span> olduğuna inanıyoruz.
                    </p>
                    <p class="text-base text-gray-600 mb-6 leading-relaxed">
                        Bu nedenle vizyonumuz, öğrencilerin sahadaki enerjisini; teknolojinin gücü ve esnafların deneyimiyle birleştirerek toplumsal fayda yaratan bir ekonomik sistem kurmaktır.
                    </p>
                    
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-2xl border border-purple-100">
                        <h4 class="font-semibold text-purple-900 mb-4">Önümüzdeki yıllarda:</h4>
                        <ul class="space-y-3 text-purple-800 text-sm leading-relaxed">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-3 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                <span>Türkiye'nin her şehrinde öğrenci ve esnaf işbirliğiyle büyüyen sürdürülebilir bir dijital pazar ağı oluşturmak,</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-3 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Bu modeli uluslararası düzeye taşıyarak dünyanın farklı ülkelerinde sosyal etki odaklı e-ticaret ekosistemleri geliştirmek,</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-3 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span>Gençlerin ekonomik özgüvenini artıran, şehir ekonomilerini güçlendiren ve toplumsal dayanışmayı büyüten yeni sosyal değer alanları yaratmak,</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-3 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                                <span>E-ticaret sektörüne, <span class="font-semibold">"karar verici olan tüketici değil; değer yaratan gençtir"</span> fikrini yerleştirmek istiyoruz.</span>
                            </li>
                        </ul>
                    </div>
                    
                    <p class="text-base text-gray-700 font-medium mt-6 leading-relaxed">
                        Vizyonumuz, sadece bir platform kurmak değil; <span class="text-purple-600 font-semibold">geleceğin ekonomik kültürünü dönüştürmektir.</span>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Soft Organic Transition -->
        <div class="absolute bottom-0 left-0 w-full h-40 overflow-hidden">
            <svg class="absolute bottom-0 w-full h-full" viewBox="0 0 1200 200" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="about-gradient-1" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:rgba(240, 253, 250, 0.9);stop-opacity:1" />
                        <stop offset="33%" style="stop-color:rgba(219, 234, 254, 1);stop-opacity:1" />
                        <stop offset="66%" style="stop-color:rgba(238, 242, 255, 1);stop-opacity:1" />
                        <stop offset="100%" style="stop-color:rgba(255, 255, 255, 1);stop-opacity:1" />
                    </linearGradient>
                </defs>
                <path d="M0,200 C200,120 400,140 600,100 C800,60 1000,80 1200,120 L1200,200 Z" fill="url(#about-gradient-1)" opacity="0.8"/>
                <path d="M0,200 C150,160 350,150 550,180 C750,210 950,190 1200,160 L1200,200 Z" fill="rgba(16, 185, 129, 0.06)" opacity="0.7"/>
            </svg>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="relative py-24 bg-white overflow-hidden">
        <!-- Floating Organic Shapes -->
        <div class="absolute inset-0">
            <svg class="absolute top-0 right-1/4 transform translate-x-1/2 -translate-y-1/2" width="400" height="400" viewBox="0 0 400 400" fill="none">
                <ellipse cx="200" cy="200" rx="150" ry="100" fill="rgba(251, 191, 36, 0.06)" opacity="0.7"/>
            </svg>
            <svg class="absolute bottom-0 left-1/4 transform -translate-x-1/2 translate-y-1/2" width="350" height="350" viewBox="0 0 350 350" fill="none">
                <circle cx="175" cy="175" r="120" fill="rgba(236, 72, 153, 0.05)" opacity="0.8"/>
            </svg>
            <svg class="absolute top-1/2 left-0 transform -translate-x-1/3" width="300" height="300" viewBox="0 0 300 300" fill="none">
                <path d="M150,30 C210,30 260,80 260,150 C260,220 210,270 150,270 C90,270 40,220 40,150 C40,80 90,30 150,30 Z" fill="rgba(16, 185, 129, 0.04)" opacity="0.6"/>
            </svg>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <div class="text-blue-600 font-semibold mb-2 uppercase tracking-wider text-sm">NASIL ÇALIŞIR</div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Nasıl
                    <br />
                    <span class="text-blue-600">Çalışır</span>?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Üç basit adımda devrimsel e-ticaret deneyimi
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="relative group text-center">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl p-8 hover:shadow-xl transition-all transform hover:-translate-y-2">
                        <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform shadow-lg">
                            <span class="text-3xl font-bold text-white">1</span>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                    </div>
                        <h3 class="text-2xl font-bold mb-4 text-gray-900">Öğrenci Fotoğraflar</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Üniversite öğrencileri sahada ürünleri fotoğraflayıp platformda paylaşır. 
                            <span class="font-semibold text-blue-600">Gerçek zamanlı ürün bilgisi</span> sağlanır.
                        </p>
                    </div>
                    <!-- Connection Line -->
                    <div class="hidden md:block absolute top-1/2 -right-6 transform -translate-y-1/2 z-10">
                        <svg class="w-12 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="relative group text-center">
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl p-8 hover:shadow-xl transition-all transform hover:-translate-y-2">
                        <div class="w-24 h-24 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform shadow-lg">
                            <span class="text-3xl font-bold text-white">2</span>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-gray-900">Esnaf Onaylar</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Yerel esnaflar ürün bilgilerini kontrol edip onaylar, fiyat belirler. 
                            <span class="font-semibold text-green-600">Kalite garantisi</span> sağlanır.
                        </p>
                    </div>
                    <!-- Connection Line -->
                    <div class="hidden md:block absolute top-1/2 -right-6 transform -translate-y-1/2 z-10">
                        <svg class="w-12 h-8 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="group text-center">
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 hover:shadow-xl transition-all transform hover:-translate-y-2">
                        <div class="w-24 h-24 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform shadow-lg">
                            <span class="text-3xl font-bold text-white">3</span>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-gray-900">Güvenle Alışveriş</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Müşteriler güvenle alışveriş yapar, öğrenci ve esnafı destekler. 
                            <span class="font-semibold text-purple-600">Topluma değer</span> katılır.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Soft Organic Transition -->
        <div class="absolute bottom-0 left-0 w-full h-32 overflow-hidden">
            <svg class="absolute bottom-0 w-full h-full" viewBox="0 0 1200 160" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="about-gradient-2" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:rgba(255, 255, 255, 1);stop-opacity:1" />
                        <stop offset="25%" style="stop-color:rgba(236, 254, 255, 0.9);stop-opacity:1" />
                        <stop offset="50%" style="stop-color:rgba(219, 234, 254, 1);stop-opacity:1" />
                        <stop offset="75%" style="stop-color:rgba(238, 242, 255, 0.9);stop-opacity:1" />
                        <stop offset="100%" style="stop-color:rgba(243, 232, 255, 0.8);stop-opacity:1" />
                    </linearGradient>
                </defs>
                <path d="M0,160 C300,100 500,80 700,120 C900,160 1100,140 1200,100 L1200,160 Z" fill="url(#about-gradient-2)" opacity="0.7"/>
            </svg>
        </div>
    </section>

    <!-- Values Section -->
    <section class="relative py-24 bg-gradient-to-br from-purple-50 via-pink-50 to-orange-50 overflow-hidden">
        <!-- Large Organic Background -->
        <div class="absolute inset-0">
            <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 1200 800" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,400 C200,320 400,280 600,340 C800,400 1000,380 1200,320 L1200,0 L0,0 Z" fill="rgba(59, 130, 246, 0.05)" opacity="0.8"/>
                <path d="M0,600 C300,520 500,480 700,540 C900,600 1100,580 1200,520 L1200,800 L0,800 Z" fill="rgba(16, 185, 129, 0.04)" opacity="0.9"/>
                <path d="M0,200 C250,140 450,120 650,160 C850,200 1050,180 1200,140 L1200,0 L0,0 Z" fill="rgba(251, 191, 36, 0.03)" opacity="0.7"/>
            </svg>
            
            <!-- Floating organic blobs -->
            <svg class="absolute top-1/4 right-1/4 transform translate-x-1/2" width="300" height="300" viewBox="0 0 300 300" fill="none">
                <circle cx="150" cy="150" r="100" fill="rgba(139, 92, 246, 0.06)" opacity="0.6"/>
            </svg>
            
            <svg class="absolute bottom-1/4 left-1/4 transform -translate-x-1/2" width="250" height="250" viewBox="0 0 250 250" fill="none">
                <ellipse cx="125" cy="125" rx="80" ry="60" fill="rgba(236, 72, 153, 0.05)" opacity="0.8"/>
            </svg>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <div class="text-blue-600 font-semibold mb-2 uppercase tracking-wider text-sm">DEĞERLER</div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    <span class="text-blue-600">Değerlerimiz</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    EsnappGO'yu özel kılan temel değerler ve ilkeler
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-900 text-center">Güven</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Her ürün esnaf tarafından onaylanır, kalite garantisi verilir.
                        Şeffaflık ve güvenilirlik önceliğimizdir.
                    </p>
                </div>
                
                <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-900 text-center">Toplumsal Değer</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Her alışveriş öğrencileri destekler ve yerel ekonomiye katkı sağlar.
                        Sosyal sorumluluk odaklı yaklaşım.
                    </p>
                </div>
                
                <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-900 text-center">İnovasyon</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Geleneksel e-ticareti yeniden tanımlayan yenilikçi yaklaşım.
                        Teknoloji ile sosyal değeri birleştiriyoruz.
                    </p>
                </div>
                
                <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-gray-900 text-center">Sürdürülebilirlik</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Çevreye duyarlı, yerel ekonomiyi destekleyen sürdürülebilir model.
                        Gelecek nesilleri düşünüyoruz.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Soft Organic Transition -->
        <div class="absolute bottom-0 left-0 w-full h-36 overflow-hidden">
            <svg class="absolute bottom-0 w-full h-full" viewBox="0 0 1200 180" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="about-gradient-3" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:rgba(243, 232, 255, 0.8);stop-opacity:1" />
                        <stop offset="30%" style="stop-color:rgba(252, 231, 243, 0.9);stop-opacity:1" />
                        <stop offset="70%" style="stop-color:rgba(254, 242, 242, 1);stop-opacity:1" />
                        <stop offset="100%" style="stop-color:rgba(255, 255, 255, 1);stop-opacity:1" />
                    </linearGradient>
                </defs>
                <path d="M0,180 C250,120 450,100 650,140 C850,180 1050,160 1200,120 L1200,180 Z" fill="url(#about-gradient-3)" opacity="0.8"/>
                <path d="M0,180 C200,140 400,130 600,160 C800,190 1000,170 1200,140 L1200,180 Z" fill="rgba(139, 92, 246, 0.04)" opacity="0.6"/>
            </svg>
        </div>
    </section>

    <!-- Impact Section -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <div class="text-blue-600 font-semibold mb-2 uppercase tracking-wider text-sm">SOSYAL ETKİ</div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Sosyal
                    <br />
                    <span class="text-blue-600">Etkimiz</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    EsnappGO ile yaratılan pozitif değişimler
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl p-8 mb-8">
                        <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Öğrenci Desteği</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Binlerce üniversite öğrencisine ek gelir imkanı sağlayarak, 
                        eğitim hayatlarını destekliyoruz. Gençlerin girişimci ruhunu geliştiriyoruz.
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl p-8 mb-8">
                        <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Yerel Ekonomi</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Küçük esnaf ve yerel işletmeleri dijital dünyaya taşıyarak, 
                        daha geniş müşteri kitlesine ulaşmalarını sağlıyoruz.
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 mb-8">
                        <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Sürdürülebilirlik</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Yerel üretimi destekleyerek çevreye duyarlı, 
                        sürdürülebilir bir ticaret modeli oluşturuyoruz.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Soft Organic Transition -->
        <div class="absolute bottom-0 left-0 w-full h-32 overflow-hidden">
            <svg class="absolute bottom-0 w-full h-full" viewBox="0 0 1200 160" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="about-gradient-4" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:rgba(255, 255, 255, 1);stop-opacity:1" />
                        <stop offset="25%" style="stop-color:rgba(240, 253, 250, 0.9);stop-opacity:1" />
                        <stop offset="50%" style="stop-color:rgba(219, 234, 254, 1);stop-opacity:1" />
                        <stop offset="75%" style="stop-color:rgba(238, 242, 255, 0.9);stop-opacity:1" />
                        <stop offset="100%" style="stop-color:rgba(243, 232, 255, 0.8);stop-opacity:1" />
                    </linearGradient>
                </defs>
                <path d="M0,160 C300,100 500,120 700,80 C900,40 1100,60 1200,100 L1200,160 Z" fill="url(#about-gradient-4)" opacity="0.7"/>
            </svg>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-24 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <div class="text-blue-600 font-semibold mb-2 uppercase tracking-wider text-sm">EKİBİMİZ</div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    <span class="text-blue-600">Ekibimiz</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    EsnappGO'yu hayata geçiren tutkulu ve deneyimli ekip
                </p>
            </div>
            
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-3xl shadow-xl p-12 text-center">
                    <div class="w-32 h-32 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-8 shadow-xl">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-6">EsnappGO Ekibi</h3>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">
                        Teknoloji, e-ticaret ve sosyal girişimcilik alanlarında deneyimli, 
                        toplumsal değer yaratmaya odaklanmış multidisipliner bir ekip. 
                        Vizyonumuz doğrultusunda sürekli öğrenen ve gelişen bir yapıdayız.
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2">İnovasyon</h4>
                            <p class="text-sm text-gray-600">Sürekli yenilik ve gelişim odaklı</p>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2">Tutku</h4>
                            <p class="text-sm text-gray-600">Sosyal değer yaratma tutkusu</p>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2">Deneyim</h4>
                            <p class="text-sm text-gray-600">Çeşitli alanlarda uzman kadro</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-800 text-white py-24 overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(255,255,255,0.1),transparent_50%),radial-gradient(circle_at_70%_80%,rgba(255,255,255,0.08),transparent_50%)]"></div>
        <div class="pointer-events-none absolute -top-24 -left-24 w-[400px] h-[400px] rounded-full bg-blue-400 opacity-20 blur-3xl animate-pulse"></div>
        <div class="pointer-events-none absolute -bottom-32 -right-20 w-[500px] h-[500px] rounded-full bg-purple-400 opacity-20 blur-3xl" style="animation: pulse 5s ease-in-out infinite;"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-8">
                Geleceğin E-Ticaretine
                <br />
                <span class="text-blue-200">Katılın!</span>
            </h2>
            <p class="text-xl md:text-2xl text-blue-100 mb-12 max-w-3xl mx-auto leading-relaxed">
                EsnappGO ailesi olarak, alışverişi sosyal değer yaratmanın bir aracı haline getiriyoruz.
                <br />
                <span class="font-bold text-white">Siz de bu değişimin parçası olun!</span>
            </p>
            
            <div class="flex flex-col lg:flex-row gap-6 justify-center mb-12">
                <a href="/register?role=customer" class="group bg-white text-blue-900 px-12 py-5 rounded-full font-bold text-lg hover:bg-blue-50 transition-all transform hover:scale-105 shadow-2xl">
                    <svg class="w-6 h-6 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Alışverişe Başla
                    <svg class="w-5 h-5 inline ml-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
                
                <a href="/register?role=student" class="group border-3 border-white text-white px-12 py-5 rounded-full font-bold text-lg hover:bg-white hover:text-blue-900 transition-all transform hover:scale-105">
                    <svg class="w-6 h-6 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Öğrenci Ol
                </a>
                
                <a href="/register?role=merchant" class="group border-3 border-white text-white px-12 py-5 rounded-full font-bold text-lg hover:bg-white hover:text-blue-900 transition-all transform hover:scale-105">
                    <svg class="w-6 h-6 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Esnaf Ol
                </a>
            </div>
            
            <!-- Trust Indicators -->
            <div class="flex flex-wrap justify-center items-center gap-8 text-blue-200 text-lg">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Ücretsiz Kayıt</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Güvenli Alışveriş</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Toplumsal Değer</span>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    document.querySelectorAll('.group').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});
</script>