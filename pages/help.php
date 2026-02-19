<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Yardım Merkezi</h1>
            <p class="text-lg text-gray-600">
                EsnappGO kullanımı hakkında sıkça sorulan sorular
            </p>
        </div>
        
        <!-- Search -->
        <div class="mb-8">
            <div class="relative">
                <input
                    type="text"
                    id="help-search"
                    placeholder="Yardım konusu ara..."
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Help Categories -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Hesap İşlemleri</h3>
                <p class="text-sm text-gray-600 mb-4">Kayıt, giriş ve hesap yönetimi</p>
                <button onclick="filterHelp('account')" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                    Konuları Gör
                </button>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Alışveriş</h3>
                <p class="text-sm text-gray-600 mb-4">Ürün arama, sepet ve sipariş</p>
                <button onclick="filterHelp('shopping')" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                    Konuları Gör
                </button>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Öğrenci Kazançları</h3>
                <p class="text-sm text-gray-600 mb-4">Ürün paylaşımı ve kazanç</p>
                <button onclick="filterHelp('earnings')" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                    Konuları Gör
                </button>
            </div>
        </div>
        
        <!-- FAQ Content -->
        <div class="bg-white rounded-lg shadow-sm p-8">
            <h3 class="text-xl font-semibold text-gray-900 mb-6">Sık Sorulan Sorular</h3>
            
            <div id="faq-content" class="space-y-4">
                <!-- Account Questions -->
                <div class="faq-item" data-category="account">
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer text-sm font-medium text-gray-900 p-4 bg-gray-50 rounded-lg">
                            <span>Nasıl hesap oluştururum?</span>
                            <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <div class="mt-3 text-sm text-gray-600 px-4">
                            "Kayıt Ol" butonuna tıklayarak hesap türünüzü seçin (Müşteri, Öğrenci, Esnaf) ve bilgilerinizi doldurun.
                        </div>
                    </details>
                </div>
                
                <div class="faq-item" data-category="account">
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer text-sm font-medium text-gray-900 p-4 bg-gray-50 rounded-lg">
                            <span>Şifremi unuttum, ne yapmalıyım?</span>
                            <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <div class="mt-3 text-sm text-gray-600 px-4">
                            Giriş sayfasında "Şifrenizi mi unuttunuz?" linkine tıklayarak şifre sıfırlama talebinde bulunabilirsiniz.
                        </div>
                    </details>
                </div>
                
                <!-- Shopping Questions -->
                <div class="faq-item" data-category="shopping">
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer text-sm font-medium text-gray-900 p-4 bg-gray-50 rounded-lg">
                            <span>Nasıl ürün satın alırım?</span>
                            <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <div class="mt-3 text-sm text-gray-600 px-4">
                            Ürünler sayfasından istediğiniz ürünü seçin, sepete ekleyin ve "Siparişi Tamamla" butonuna tıklayın.
                        </div>
                    </details>
                </div>
                
                <div class="faq-item" data-category="shopping">
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer text-sm font-medium text-gray-900 p-4 bg-gray-50 rounded-lg">
                            <span>Kargo ücreti var mı?</span>
                            <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <div class="mt-3 text-sm text-gray-600 px-4">
                            Şu anda tüm siparişlerde kargo ücretsizdir. Yerel teslimat sistemi kullanıyoruz.
                        </div>
                    </details>
                </div>
                
                <!-- Earnings Questions -->
                <div class="faq-item" data-category="earnings">
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer text-sm font-medium text-gray-900 p-4 bg-gray-50 rounded-lg">
                            <span>Öğrenci olarak ne kadar kazanabilirim?</span>
                            <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <div class="mt-3 text-sm text-gray-600 px-4">
                            Her satıştan %10 pay alırsınız. Aylık kazancınız paylaştığınız ürün sayısına ve satışlara bağlıdır.
                        </div>
                    </details>
                </div>
                
                <div class="faq-item" data-category="earnings">
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer text-sm font-medium text-gray-900 p-4 bg-gray-50 rounded-lg">
                            <span>Kazancımı nasıl çekerim?</span>
                            <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <div class="mt-3 text-sm text-gray-600 px-4">
                            Cüzdan sayfanızdan IBAN bilgilerinizi ekleyerek para çekme talebinde bulunabilirsiniz.
                        </div>
                    </details>
                </div>
            </div>
        </div>
        
        <!-- Still Need Help -->
        <div class="mt-12 bg-blue-50 rounded-lg p-8 text-center">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Hala yardıma mı ihtiyacınız var?</h3>
            <p class="text-gray-600 mb-6">
                Sorunuzun cevabını bulamadıysanız, bizimle doğrudan iletişime geçin.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/contact" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Bize Yazın
                </a>
                <a href="tel:+905336160218" class="btn btn-outline">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Bizi Arayın
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('help-search');
    searchInput.addEventListener('input', handleSearch);
});

function filterHelp(category) {
    const items = document.querySelectorAll('.faq-item');
    items.forEach(item => {
        if (category === 'all' || item.dataset.category === category) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
    
    // Scroll to FAQ content
    document.getElementById('faq-content').scrollIntoView({ behavior: 'smooth' });
}

function handleSearch(e) {
    const searchTerm = e.target.value.toLowerCase();
    const items = document.querySelectorAll('.faq-item');
    
    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>
