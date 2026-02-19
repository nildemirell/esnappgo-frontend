<div class="min-h-screen bg-white overflow-hidden">
    <!-- Hero Section with Organic Shapes -->
    <section class="relative bg-gradient-to-br from-blue-50 via-white to-purple-50 py-20 lg:py-32 overflow-hidden">
        <!-- Organic Background Shapes -->
        <div class="absolute inset-0">
            <svg class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2" width="800" height="800" viewBox="0 0 800 800" fill="none">
                <circle cx="400" cy="400" r="300" fill="rgba(59, 130, 246, 0.12)" />
                <circle cx="500" cy="300" r="200" fill="rgba(16, 185, 129, 0.08)" />
            </svg>
            <svg class="absolute bottom-0 left-0 transform -translate-x-1/3 translate-y-1/3" width="600" height="600" viewBox="0 0 600 600" fill="none">
                <circle cx="300" cy="300" r="250" fill="rgba(139, 92, 246, 0.1)" />
            </svg>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 text-blue-700 text-sm font-medium mb-8">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        Türkiye'nin ilk öğrenci destekli e-ticaret ekosistemi
                </div>
                
                <!-- Main Heading -->
                <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-8 leading-tight">
                    Alışverişinizi Öğrencilerin Geleceğine
                    <br />
                    <span class="text-blue-600">Dönüştürün</span>
                </h1>
                
                <!-- Subtitle -->
                <p class="text-xl lg:text-2xl text-gray-600 mb-12 leading-relaxed">
                    Öğrenciler ürünleri araştırır ve fotoğraflar, yerel esnaflar onaylar, siz ise güvenle alışveriş yaparken onların gelişimine katkı sağlarsınız.
                    <br />Her satın alma, bir öğrencinin hikâyesine dokunur.
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                    <a href="/register?role=customer" onclick="window.location.href='/register?role=customer'; return false;" class="bg-blue-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors shadow-sm cursor-pointer">
                        Alışverişe Başla
                    </a>
                    <a href="/student-intro" onclick="window.location.href='/student-intro'; return false;" class="border border-gray-300 text-gray-700 px-8 py-4 rounded-lg font-semibold hover:bg-gray-50 transition-colors cursor-pointer">
                        Öğrenci Ol
                    </a>
                </div>

                <!-- Trust Indicators -->
                <?php
                // Gerçek istatistikleri veritabanından çek
                $db = $database->getConnection();
                $heroStudentCount = $db->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn();
                $heroMerchantCount = $db->query("SELECT COUNT(*) FROM users WHERE role = 'merchant'")->fetchColumn();
                $heroProductCount = $db->query("SELECT COUNT(*) FROM products WHERE status = 'active'")->fetchColumn();
                $heroCustomerCount = $db->query("SELECT COUNT(*) FROM users WHERE role = 'customer'")->fetchColumn();
                
                function formatHeroCount($count) {
                    if ($count >= 10000) {
                        return number_format($count / 1000, 1, '.', '') . 'K+';
                    } elseif ($count >= 1000) {
                        return number_format($count / 1000, 1, '.', '') . 'K+';
                    } else {
                        return $count . '+';
                    }
                }
                ?>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-3xl font-bold text-gray-900 mb-2"><?php echo formatHeroCount($heroStudentCount); ?></div>
                        <div class="text-gray-600">Aktif Öğrenci</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900 mb-2"><?php echo formatHeroCount($heroMerchantCount); ?></div>
                        <div class="text-gray-600">Yerel Esnaf</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900 mb-2"><?php echo formatHeroCount($heroProductCount); ?></div>
                        <div class="text-gray-600">Ürün</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900 mb-2"><?php echo formatHeroCount($heroCustomerCount); ?></div>
                        <div class="text-gray-600">Mutlu Müşteri</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Soft Organic Transition -->
        <div class="absolute bottom-0 left-0 w-full h-40 overflow-hidden">
            <svg class="absolute bottom-0 w-full h-full" viewBox="0 0 1200 200" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="soft-gradient-1" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:rgba(240, 253, 250, 0.8);stop-opacity:1" />
                        <stop offset="25%" style="stop-color:rgba(219, 234, 254, 0.9);stop-opacity:1" />
                        <stop offset="50%" style="stop-color:rgba(238, 242, 255, 1);stop-opacity:1" />
                        <stop offset="75%" style="stop-color:rgba(224, 231, 255, 0.9);stop-opacity:1" />
                        <stop offset="100%" style="stop-color:rgba(236, 254, 255, 0.8);stop-opacity:1" />
                    </linearGradient>
                </defs>
                <path d="M0,200 C150,120 300,140 450,100 C600,60 750,80 900,120 C1050,160 1150,140 1200,100 L1200,200 Z" fill="url(#soft-gradient-1)" opacity="0.7"/>
                <path d="M0,200 C200,150 400,130 600,160 C800,190 1000,170 1200,140 L1200,200 Z" fill="rgba(20, 184, 166, 0.1)" opacity="0.8"/>
            </svg>
        </div>
    </section>

    <!-- Services Section with Organic Background -->
    <section class="relative py-20 bg-gradient-to-br from-teal-50 via-blue-50 to-indigo-100 overflow-hidden">
        <!-- Organic Background Elements -->
        <div class="absolute inset-0">
            <svg class="absolute top-1/4 left-0 transform -translate-x-1/2" width="600" height="600" viewBox="0 0 600 600" fill="none">
                <path d="M300,50 C450,50 550,150 550,300 C550,450 450,550 300,550 C150,550 50,450 50,300 C50,150 150,50 300,50 Z" fill="rgba(16, 185, 129, 0.15)" />
            </svg>
            <svg class="absolute top-1/2 right-0 transform translate-x-1/3" width="500" height="500" viewBox="0 0 500 500" fill="none">
                <ellipse cx="250" cy="250" rx="200" ry="150" fill="rgba(139, 92, 246, 0.12)" />
            </svg>
            <svg class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/4" width="400" height="400" viewBox="0 0 400 400" fill="none">
                <circle cx="200" cy="200" r="150" fill="rgba(251, 191, 36, 0.1)" />
            </svg>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="text-blue-600 font-semibold mb-2 uppercase tracking-wider text-sm">KİMLER İÇİN</div>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Uzmanlaştığımız
                    <br />Alanlar
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    EsnappGO'da herkes için bir rol var hangi rol size uygun?
                    <br />Siz hangisinde yer almak istersiniz?
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Students Card -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 rounded-2xl opacity-0 group-hover:opacity-5 transition-opacity duration-300"></div>
                    <div class="relative bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100">
                        <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-200 transition-colors">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">🎓 Öğrenciler</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Saha çalışması yaparak ürünleri fotoğraflayın, kendi programınıza göre çalışın ve gelir kazanın.
                        </p>
                        <p class="text-gray-700 font-medium mb-6 leading-relaxed">
                            Her çektiğiniz fotoğraf, hem cebinize hem CV'nize katkı sağlar. 
                            <span class="text-blue-600 font-semibold">Kariyer yolculuğunuz burada başlar.</span>
                        </p>
                        <ul class="space-y-3 text-gray-600 mb-8">
                            <li class="flex items-center">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-3"></div>
                                Esnek çalışma saatleri
                            </li>
                            <li class="flex items-center">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-3"></div>
                                Düzenli gelir fırsatı
                            </li>
                            <li class="flex items-center">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-3"></div>
                                Gerçek saha deneyimi
                            </li>
                            <li class="flex items-center">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-3"></div>
                                "Bu iş bana göre mi?" merakını uyandıran bir ekosistem
                            </li>
                        </ul>
                        <a href="/student-intro" onclick="window.location.href='/student-intro'; return false;" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors group cursor-pointer">
                            Daha fazlasını keşfet
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Merchants Card -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-green-600 rounded-2xl opacity-0 group-hover:opacity-5 transition-opacity duration-300"></div>
                    <div class="relative bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100">
                        <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-green-200 transition-colors">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">🏪 Esnaflar</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Ürünlerinizi onaylayın, fiyatlandırın ve öğrencilerle birlikte dijital dünyaya açılın.
                        </p>
                        <p class="text-gray-700 font-medium mb-6 leading-relaxed">
                            Hiçbir ek masraf olmadan daha geniş bir kitleye ulaşın. 
                            <span class="text-green-600 font-semibold">Her onayladığınız ürün, işletmenizi bir adım ileri taşır.</span>
                        </p>
                        <ul class="space-y-3 text-gray-600 mb-8">
                            <li class="flex items-center">
                                <div class="w-2 h-2 bg-green-400 rounded-full mr-3"></div>
                                Geniş müşteri ağı
                            </li>
                            <li class="flex items-center">
                                <div class="w-2 h-2 bg-green-400 rounded-full mr-3"></div>
                                Ücretsiz dijital görünürlük
                            </li>
                            <li class="flex items-center">
                                <div class="w-2 h-2 bg-green-400 rounded-full mr-3"></div>
                                Hızlı ve kolay ürün yönetimi
                            </li>
                            <li class="flex items-center">
                                <div class="w-2 h-2 bg-green-400 rounded-full mr-3"></div>
                                Öğrencilerle birlikte büyüyen iş modeli
                            </li>
                        </ul>
                        <a href="/register?role=merchant" onclick="window.location.href='/register?role=merchant'; return false;" class="inline-flex items-center text-green-600 font-semibold hover:text-green-700 transition-colors group cursor-pointer">
                            Esnaf ol
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Customers Card -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-purple-600 rounded-2xl opacity-0 group-hover:opacity-5 transition-opacity duration-300"></div>
                    <div class="relative bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100">
                        <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-200 transition-colors">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">🛍️ Müşteriler</h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Güvenle alışveriş yaparken hem öğrencilere hem yerel işletmelere destek olun.
                        </p>
                        <p class="text-gray-700 font-medium mb-6 leading-relaxed">
                            Her alışverişiniz sadece bir ürün değil; bir öğrencinin emeği, bir esnafın dönüşümüdür. 
                            <span class="text-purple-600 font-semibold">Topluma değer katmanın en pratik yolu.</span>
                        </p>
                        <ul class="space-y-3 text-gray-600 mb-8">
                            <li class="flex items-center">
                                <div class="w-2 h-2 bg-purple-400 rounded-full mr-3"></div>
                                Kalitesi doğrulanmış ürünler
                            </li>
                            <li class="flex items-center">
                                <div class="w-2 h-2 bg-purple-400 rounded-full mr-3"></div>
                                Sosyal değer yaratan alışveriş
                            </li>
                            <li class="flex items-center">
                                <div class="w-2 h-2 bg-purple-400 rounded-full mr-3"></div>
                                Şeffaf ve güvenli süreç
                            </li>
                        </ul>
                        <a href="/register?role=customer" onclick="window.location.href='/register?role=customer'; return false;" class="inline-flex items-center text-purple-600 font-semibold hover:text-purple-700 transition-colors group cursor-pointer">
                            Alışverişe başla
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Soft Organic Transition -->
        <div class="absolute bottom-0 left-0 w-full h-32 overflow-hidden">
            <svg class="absolute bottom-0 w-full h-full" viewBox="0 0 1200 160" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="soft-gradient-2" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:rgba(224, 242, 254, 0.9);stop-opacity:1" />
                        <stop offset="30%" style="stop-color:rgba(186, 230, 253, 1);stop-opacity:1" />
                        <stop offset="70%" style="stop-color:rgba(219, 234, 254, 1);stop-opacity:1" />
                        <stop offset="100%" style="stop-color:rgba(240, 249, 255, 0.9);stop-opacity:1" />
                    </linearGradient>
                </defs>
                <path d="M0,160 C300,80 450,60 600,90 C750,120 900,100 1200,60 L1200,160 Z" fill="url(#soft-gradient-2)" opacity="0.8"/>
                <path d="M0,160 C250,120 500,100 750,130 C900,150 1050,140 1200,120 L1200,160 Z" fill="rgba(59, 130, 246, 0.08)" opacity="0.6"/>
            </svg>
        </div>
    </section>

        <!-- How It Works Section with Organic Flow -->
    <section class="relative py-20 bg-gradient-to-br from-white via-cyan-50 to-blue-50 overflow-hidden">
        <!-- Floating Organic Shapes -->
        <div class="absolute inset-0">
            <svg class="absolute top-0 right-1/4 transform translate-x-1/2 -translate-y-1/2" width="400" height="400" viewBox="0 0 400 400" fill="none">
                <ellipse cx="200" cy="200" rx="150" ry="100" fill="rgba(251, 191, 36, 0.12)" />
            </svg>
            <svg class="absolute bottom-0 left-1/4 transform -translate-x-1/2 translate-y-1/2" width="350" height="350" viewBox="0 0 350 350" fill="none">
                <circle cx="175" cy="175" r="120" fill="rgba(236, 72, 153, 0.1)" />
            </svg>
            <svg class="absolute top-1/2 left-0 transform -translate-x-1/3" width="300" height="300" viewBox="0 0 300 300" fill="none">
                <path d="M150,30 C210,30 260,80 260,150 C260,220 210,270 150,270 C90,270 40,220 40,150 C40,80 90,30 150,30 Z" fill="rgba(16, 185, 129, 0.08)" />
                        </svg>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="text-blue-600 font-semibold mb-2 uppercase tracking-wider text-sm">NASIL ÇALIŞIR</div>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Nasıl
                    <br />Çalışır?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Sadece üç adımda öğrencilerin kazandığı, esnafın güçlendiği, güvenli bir e-ticaret deneyimi
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
                <!-- Connection Lines -->
                <div class="hidden md:block absolute top-1/2 left-1/3 transform -translate-y-1/2 w-1/3 h-px bg-gradient-to-r from-blue-200 to-green-200"></div>
                <div class="hidden md:block absolute top-1/2 right-1/3 transform -translate-y-1/2 w-1/3 h-px bg-gradient-to-r from-green-200 to-purple-200"></div>
                
                <div class="text-center relative">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-2xl font-bold text-blue-600">1</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Öğrenciler Ürünleri Saha Saha Keşfeder</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Üniversite öğrencileri şehirdeki mağazaları gezer, ürünleri yerinde inceler, fotoğraflar ve platforma yükler. 
                        Gerçek zamanlı, doğrudan sahadan gelen güvenilir içerikler hazırlanır. 
                        <span class="font-semibold text-blue-600">Her fotoğraf, bir öğrencinin emeği ve kazancı demektir.</span>
                    </p>
                </div>
                
                <div class="text-center relative">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-2xl font-bold text-green-600">2</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Esnaflar Onaylar ve Değer Katar</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Yerel esnaflar öğrenci tarafından eklenen ürün bilgilerini kontrol eder, doğrular ve fiyatlandırır. 
                        Bu süreç hem kaliteyi korur hem de esnafı dijital dünyaya taşır. 
                        <span class="font-semibold text-green-600">Öğrenci + esnaf işbirliği = en güvenilir ürün akışı.</span>
                    </p>
                </div>
                
                <div class="text-center relative">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-purple-200 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-2xl font-bold text-purple-600">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Müşteriler Güvenle Alışveriş Yapar, Herkes Kazanır</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Siz güvenli bir alışveriş yaparsınız; öğrenciler gelir elde eder, esnaflar büyür, şehir ekonomisi canlanır. 
                        <span class="font-semibold text-purple-600">Her satın alma, geleceğe atılmış küçük bir destek adımıdır.</span>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Soft Organic Transition -->
        <div class="absolute bottom-0 left-0 w-full h-48 overflow-hidden">
            <svg class="absolute bottom-0 w-full h-full" viewBox="0 0 1200 240" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="soft-gradient-3" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:rgba(236, 254, 255, 1);stop-opacity:1" />
                        <stop offset="20%" style="stop-color:rgba(219, 234, 254, 1);stop-opacity:1" />
                        <stop offset="40%" style="stop-color:rgba(238, 242, 255, 1);stop-opacity:1" />
                        <stop offset="60%" style="stop-color:rgba(243, 232, 255, 1);stop-opacity:1" />
                        <stop offset="80%" style="stop-color:rgba(252, 231, 243, 1);stop-opacity:1" />
                        <stop offset="100%" style="stop-color:rgba(254, 242, 242, 1);stop-opacity:1" />
                    </linearGradient>
                </defs>
                <!-- Çok katmanlı yumuşak geçişler -->
                <path d="M0,240 C200,140 400,120 600,160 C800,200 1000,180 1200,140 L1200,240 Z" fill="url(#soft-gradient-3)" opacity="0.6"/>
                <path d="M0,240 C150,180 350,160 550,190 C750,220 950,200 1200,170 L1200,240 Z" fill="rgba(139, 92, 246, 0.08)" opacity="0.7"/>
                <path d="M0,240 C100,200 300,180 500,210 C700,240 900,220 1200,190 L1200,240 Z" fill="rgba(236, 72, 153, 0.06)" opacity="0.5"/>
            </svg>
        </div>
    </section>

    <!-- Featured Products -->
    <?php include 'components/featured-products.php'; ?>

    <!-- Values Section with Organic Background -->
    <section class="relative py-20 bg-gradient-to-br from-purple-50 via-pink-50 to-orange-50 overflow-hidden">
        <!-- Large Organic Background -->
        <div class="absolute inset-0">
            <!-- Soft flowing background waves -->
            <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 1200 800" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,400 C200,320 400,280 600,340 C800,400 1000,380 1200,320 L1200,0 L0,0 Z" fill="rgba(59, 130, 246, 0.06)" opacity="0.8"/>
                <path d="M0,600 C300,520 500,480 700,540 C900,600 1100,580 1200,520 L1200,800 L0,800 Z" fill="rgba(16, 185, 129, 0.05)" opacity="0.9"/>
                <path d="M0,200 C250,140 450,120 650,160 C850,200 1050,180 1200,140 L1200,0 L0,0 Z" fill="rgba(251, 191, 36, 0.04)" opacity="0.7"/>
            </svg>
            
            <!-- Floating organic blobs -->
            <svg class="absolute top-1/4 right-1/4 transform translate-x-1/2" width="400" height="400" viewBox="0 0 400 400" fill="none">
                <path d="M200,50 C280,50 350,120 350,200 C350,280 280,350 200,350 C120,350 50,280 50,200 C50,120 120,50 200,50 Z" fill="rgba(139, 92, 246, 0.08)" opacity="0.6"/>
            </svg>
            
            <svg class="absolute bottom-1/4 left-1/4 transform -translate-x-1/2" width="350" height="350" viewBox="0 0 350 350" fill="none">
                <ellipse cx="175" cy="175" rx="120" ry="90" fill="rgba(236, 72, 153, 0.06)" opacity="0.8"/>
            </svg>
            
            <svg class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" width="300" height="300" viewBox="0 0 300 300" fill="none">
                <path d="M150,30 C210,30 270,70 270,130 C270,190 230,250 170,250 C110,250 30,210 30,150 C30,90 90,30 150,30 Z" fill="rgba(251, 191, 36, 0.05)" opacity="0.7"/>
            </svg>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="text-blue-600 font-semibold mb-2 uppercase tracking-wider text-sm">NEDEN ESNAPPGO</div>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    🌟 Neden
                    <br />EsnappGO?
                </h2>
                <p class="text-xl text-gray-700 max-w-4xl mx-auto mb-4">
                    Çünkü alışveriş sadece alışveriş olmamalı. Bir öğrencinin emeğine, bir esnafın gelişimine, bir şehrin geleceğine dokunmalı.
                </p>
                <p class="text-lg text-gray-600 max-w-4xl mx-auto mb-6">
                    EsnappGO, geleneksel e-ticareti yeniden düşünerek öğrencilerin aktif rol aldığı, esnafın güçlendiği ve toplumun kazandığı yenilikçi bir ekosistem kurmak için doğdu.
                </p>
                <div class="text-lg text-gray-700 font-medium max-w-3xl mx-auto">
                    <p class="mb-2">Amacımız basit:</p>
                    <div class="space-y-2">
                        <p>👉 Öğrenciler kazansın.</p>
                        <p>👉 Esnaflar dijitalleşsin.</p>
                        <p>👉 Müşteriler güvenle alışveriş yaparken topluma katkı sağlasın.</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="group relative">
                    <div class="absolute inset-0 bg-white rounded-2xl opacity-70 group-hover:opacity-90 transition-opacity"></div>
                    <div class="relative bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-sm hover:shadow-lg transition-all text-center border border-white/50">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">🔹 Güvenilir</h3>
                        <p class="text-gray-700 text-sm leading-relaxed mb-3 font-medium">
                            Çünkü tüm süreç şeffaf ve işbirliğine dayanır
                        </p>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Her ürün önce öğrenciler tarafından sahada incelenir, fotoğraflanır ve platforma eklenir. Ardından yerel esnaflar tarafından onaylanır, doğrulanır ve fiyatlandırılır. Gerçek ürün, gerçek insanlar, gerçek güven.
                        </p>
                    </div>
                </div>
                
                <div class="group relative">
                    <div class="absolute inset-0 bg-white rounded-2xl opacity-70 group-hover:opacity-90 transition-opacity"></div>
                    <div class="relative bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-sm hover:shadow-lg transition-all text-center border border-white/50">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">💚 Sosyal Değer</h3>
                        <p class="text-gray-700 text-sm leading-relaxed mb-3 font-medium">
                            Çünkü her alışveriş bir geleceği güçlendirir
                        </p>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            EsnappGO'da harcadığınız her kuruş, öğrencilerin gelir elde etmesine, iş deneyimi kazanmasına ve ayakta durmasına katkıdır. Aynı zamanda yerel esnafın büyümesini sağlar. Burası sadece bir platform değil; sosyal etki yaratan bir topluluk.
                        </p>
                    </div>
                </div>
                
                <div class="group relative">
                    <div class="absolute inset-0 bg-white rounded-2xl opacity-70 group-hover:opacity-90 transition-opacity"></div>
                    <div class="relative bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-sm hover:shadow-lg transition-all text-center border border-white/50">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">⚡ Yenilikçi</h3>
                        <p class="text-gray-700 text-sm leading-relaxed mb-3 font-medium">
                            Çünkü e-ticareti öğrencilerle yeniden tanımlıyoruz
                        </p>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Geleneksel pazaryerlerinden farklı olarak ürün akışını tamamen gençlerin sahadaki emeğiyle oluşturuyoruz. Bu model, hem kaliteli ürün bilgisi sağlar hem de gençlere gerçek iş tecrübesi kazandırır. E-ticaret ilk kez öğrenci merkezli bir deneyime dönüşüyor.
                        </p>
                    </div>
                </div>
                
                <div class="group relative">
                    <div class="absolute inset-0 bg-white rounded-2xl opacity-70 group-hover:opacity-90 transition-opacity"></div>
                    <div class="relative bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-sm hover:shadow-lg transition-all text-center border border-white/50">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-orange-200 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">🌍 Sürdürülebilir</h3>
                        <p class="text-gray-700 text-sm leading-relaxed mb-3 font-medium">
                            Çünkü güçlü ekonomi yerelden başlar
                        </p>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            İş modelimiz; öğrencilerin kendi kazançlarını yaratabildiği, esnafın dijital dünyaya uyum sağladığı ve şehir ekonomisinin canlandığı sürekli dönen bir değer zinciri oluşturur. Her alışveriş; sürdürülebilir şehir ekonomisinin bir tuğlası olur.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <?php include 'components/stats.php'; ?>



    <!-- Survey CTA with Organic Background -->
    <section class="relative py-16 bg-gradient-to-r from-blue-600 to-indigo-700 overflow-hidden">
        <!-- Soft Organic Overlay -->
        <div class="absolute inset-0">
            <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 1200 400" fill="none">
                <!-- Soft flowing waves -->
                <path d="M0,120 C250,80 450,140 650,100 C850,60 1050,120 1200,80 L1200,400 L0,400 Z" fill="rgba(255, 255, 255, 0.06)" opacity="0.8"/>
                <path d="M0,200 C200,160 400,180 600,150 C800,120 1000,140 1200,110 L1200,400 L0,400 Z" fill="rgba(255, 255, 255, 0.04)" opacity="0.9"/>
                <!-- Floating elements -->
                <circle cx="200" cy="150" r="60" fill="rgba(255, 255, 255, 0.03)" opacity="0.7"/>
                <ellipse cx="1000" cy="200" rx="80" ry="50" fill="rgba(255, 255, 255, 0.02)" opacity="0.8"/>
            </svg>
        </div>
        
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                ⭐ Öğrenci Gelir Modeli Anketi
            </h2>
            <p class="text-2xl font-bold text-yellow-300 mb-6">
                Geleceği Birlikte Tasarlıyoruz!
            </p>
            <p class="text-lg text-blue-100 mb-4 leading-relaxed">
                EsnappGO, öğrencilerin daha fazla kazanabildiği sürdürülebilir bir gelir modeli geliştiriyor.
            </p>
            <p class="text-lg text-blue-100 mb-4 leading-relaxed">
                Görüşlerin bizim için sadece değerli değil; <span class="font-semibold text-white">bu ekosistemin geleceğini belirleyen bir pusula.</span>
            </p>
            <p class="text-lg text-blue-100 mb-8 leading-relaxed">
                Dakikalar içinde katkı sağlayabilir, yüzlerce öğrencinin yolunu şekillendirebilirsin.
            </p>
            <a href="/survey" onclick="window.location.href='/survey'; return false;" class="inline-flex items-center bg-white text-blue-600 px-10 py-5 rounded-full font-bold text-lg hover:bg-blue-50 transition-all transform hover:scale-105 shadow-2xl cursor-pointer">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                👉 Anketimize Katıl ve Geleceği Birlikte Kuralım
            </a>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative py-20 bg-gray-900 text-white overflow-hidden">
        <!-- Soft Organic Background -->
        <div class="absolute inset-0">
            <!-- Flowing top waves -->
            <svg class="absolute top-0 left-0 w-full h-32" viewBox="0 0 1200 120" fill="none">
                <path d="M0,0 C200,40 400,20 600,60 C800,100 1000,80 1200,40 L1200,0 Z" fill="rgba(59, 130, 246, 0.08)" opacity="0.6"/>
                <path d="M0,0 C300,60 500,40 700,80 C900,120 1100,100 1200,60 L1200,0 Z" fill="rgba(139, 92, 246, 0.06)" opacity="0.8"/>
            </svg>
            
            <!-- Floating organic elements -->
            <svg class="absolute top-1/4 left-1/4 transform -translate-x-1/4" width="300" height="300" viewBox="0 0 300 300" fill="none">
                <path d="M150,40 C200,40 250,90 250,140 C250,190 200,240 150,240 C100,240 50,190 50,140 C50,90 100,40 150,40 Z" fill="rgba(255, 255, 255, 0.03)" opacity="0.7"/>
            </svg>
            
            <svg class="absolute bottom-1/4 right-1/4 transform translate-x-1/4" width="250" height="250" viewBox="0 0 250 250" fill="none">
                <ellipse cx="125" cy="125" rx="80" ry="60" fill="rgba(255, 255, 255, 0.02)" opacity="0.8"/>
            </svg>
            
            <!-- Bottom flowing waves -->
            <svg class="absolute bottom-0 left-0 w-full h-24" viewBox="0 0 1200 96" fill="none">
                <path d="M0,96 C150,60 300,80 450,50 C600,20 750,40 900,70 C1050,100 1150,80 1200,60 L1200,96 Z" fill="rgba(59, 130, 246, 0.06)" opacity="0.5"/>
            </svg>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                🔥 Geleceğin E-Ticaretine Katıl
            </h2>
            <p class="text-xl font-semibold text-blue-300 mb-6">
                E-ticareti sadece tüketmek değil, birlikte üretmek isteyenlerin platformu!
            </p>
            <div class="text-lg text-gray-300 mb-4 max-w-3xl mx-auto">
                <p class="mb-4">EsnappGO ile alışveriş;</p>
                <div class="space-y-3 text-left max-w-2xl mx-auto">
                    <p>✔ bir öğrencinin gelir kaynağı,</p>
                    <p>✔ bir esnafın büyüme fırsatı,</p>
                    <p>✔ bir müşterinin topluma bıraktığı sosyal bir iz haline geliyor.</p>
                </div>
            </div>
            <p class="text-lg text-gray-300 mb-4 max-w-3xl mx-auto leading-relaxed">
                Seçtiğin rol ne olursa olsun, bu ekosistemin bir parçası olduğunda şehir kazanır, gençler kazanır, sen de kazanırsın.
            </p>
            <p class="text-xl font-bold text-yellow-300 mb-8">
                Geleceğin ticaret modeline adım atma zamanı!
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/register" onclick="window.location.href='/register'; return false;" class="inline-flex items-center justify-center bg-blue-600 text-white px-10 py-5 rounded-full text-lg font-bold hover:bg-blue-700 transition-all transform hover:scale-105 shadow-2xl cursor-pointer">
                    🔵 Hemen Başla
                </a>
                <a href="/about" onclick="window.location.href='/about'; return false;" class="inline-flex items-center justify-center border-2 border-gray-400 text-gray-200 px-10 py-5 rounded-full text-lg font-bold hover:bg-gray-800 hover:border-white hover:text-white transition-all shadow-lg cursor-pointer">
                    ⚪ Daha Fazla Bilgi Al
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        EsnappGO
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Türkiye'nin ilk öğrenci destekli e-ticaret platformu. 
                        Alışveriş yap, değer yarat, geleceği şekillendir.
                    </p>

                </div>
                
                <div>
                    <h4 class="font-bold mb-4 text-lg text-gray-900">Platform</h4>
                    <ul class="space-y-3 text-gray-600">
                        <li><a href="/about" class="hover:text-gray-900 transition-colors">Hakkımızda</a></li>
                        <li><a href="/products" class="hover:text-gray-900 transition-colors">Ürünler</a></li>
                        <li><a href="/about" class="hover:text-gray-900 transition-colors">Nasıl Çalışır</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold mb-4 text-lg text-gray-900">Kullanıcılar</h4>
                    <ul class="space-y-3 text-gray-600">
                        <li><a href="/student-intro" class="hover:text-gray-900 transition-colors">Öğrenci Ol</a></li>
                        <li><a href="/register?role=merchant" class="hover:text-gray-900 transition-colors">Esnaf Ol</a></li>
                        <li><a href="/register?role=customer" class="hover:text-gray-900 transition-colors">Müşteri Ol</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold mb-4 text-lg text-gray-900">Destek</h4>
                    <ul class="space-y-3 text-gray-600">
                        <li><a href="/help" class="hover:text-gray-900 transition-colors">Yardım Merkezi</a></li>
                        <li><a href="/contact" class="hover:text-gray-900 transition-colors">İletişim</a></li>
                        <li><a href="/terms" class="hover:text-gray-900 transition-colors">Kullanım Koşulları</a></li>
                        <li><a href="/privacy" class="hover:text-gray-900 transition-colors">Gizlilik Politikası</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-8 mt-12 text-center">
                <p class="text-gray-500">
                    &copy; 2025 EsnappGO. Tüm hakları saklıdır.
                </p>
            </div>
        </div>
    </footer>
</div>