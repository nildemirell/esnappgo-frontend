<?php
// Öğrenci kontrolü
if (!$current_user || $current_user['role'] !== 'student') {
    header('Location: /dashboard');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-4">
                <a href="/student/products" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Yeni Ürün Ekle</h1>
            </div>
            <p class="text-gray-600">Sahadan ürün fotoğrafı paylaşarak kazanç elde edin</p>
        </div>
        
        <!-- Form -->
        <div class="bg-white rounded-lg shadow-sm p-8">
            <form id="create-product-form" class="space-y-6">
                <!-- Product Images -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Ürün Fotoğrafları
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                        <input type="file" id="product-images" multiple accept="image/*" class="hidden" onchange="handleImageUpload(event)">
                        <div id="upload-area" onclick="document.getElementById('product-images').click()" class="cursor-pointer">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p class="text-gray-600 mb-2">Fotoğrafları buraya sürükleyin veya tıklayın</p>
                            <p class="text-xs text-gray-500">PNG, JPG, JPEG - Maksimum 5 fotoğraf</p>
                        </div>
                        
                        <!-- Image Previews -->
                        <div id="image-previews" class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4" style="display: none;"></div>
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Ürün Adı
                        </label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="w-full"
                            placeholder="Örn: Taze Domates"
                            required
                        />
                    </div>
                    
                    <div>
                        <label for="suggested_price" class="block text-sm font-medium text-gray-700 mb-2">
                            Önerilen Fiyat
                        </label>
                        <input
                            type="number"
                            id="suggested_price"
                            name="suggested_price"
                            step="0.01"
                            min="0"
                            class="w-full"
                            placeholder="₺0.00"
                        />
                        <p class="text-xs text-gray-500 mt-1">Esnaf final fiyatı belirleyecek</p>
                    </div>
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Ürün Açıklaması
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="w-full"
                        placeholder="Ürün hakkında detaylı bilgi verin..."
                        required
                    ></textarea>
                </div>
                
                <!-- Shop Selection -->
                <div>
                    <label for="shop_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Mağaza Seçin
                    </label>
                    <select id="shop_id" name="shop_id" class="w-full" required>
                        <option value="">Mağaza seçin...</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Ürünün satılacağı mağazayı seçin</p>
                </div>
                
                <!-- Additional Info -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h4 class="text-sm font-medium text-blue-900 mb-2">Önemli Bilgiler</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Fotoğraflar net ve iyi ışıklı olmalıdır</li>
                        <li>• Ürün bilgileri doğru ve eksiksiz olmalıdır</li>
                        <li>• Esnaf onayından sonra satışa çıkacaktır</li>
                        <li>• Her satıştan %10 kazanç elde edeceksiniz</li>
                    </ul>
                </div>
                
                <!-- Submit -->
                <div class="flex justify-end space-x-4">
                    <a href="/student/products" class="btn btn-outline">
                        İptal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Ürünü Paylaş
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let selectedImages = [];

document.addEventListener('DOMContentLoaded', function() {
    loadShops();
    
    document.getElementById('create-product-form').addEventListener('submit', handleCreateProduct);
});

async function loadShops() {
    try {
        const response = await apiCall('shops');
        
        if (response.success) {
            const shops = response.data;
            const select = document.getElementById('shop_id');
            
            select.innerHTML = '<option value="">Mağaza seçin...</option>' + 
                shops.map(shop => `
                    <option value="${shop.id}">${escapeHtml(shop.name)} - ${escapeHtml(shop.address || '')}</option>
                `).join('');
        }
        
    } catch (error) {
        console.error('Error loading shops:', error);
    }
}

function handleImageUpload(event) {
    const files = Array.from(event.target.files);
    
    if (files.length > 5) {
        showToast('Maksimum 5 fotoğraf yükleyebilirsiniz', 'error');
        return;
    }
    
    selectedImages = files;
    displayImagePreviews();
}

function displayImagePreviews() {
    const container = document.getElementById('image-previews');
    const uploadArea = document.getElementById('upload-area');
    
    if (selectedImages.length === 0) {
        container.style.display = 'none';
        return;
    }
    
    container.style.display = 'grid';
    
    container.innerHTML = selectedImages.map((file, index) => {
        const url = URL.createObjectURL(file);
        return `
            <div class="relative">
                <img src="${url}" alt="Preview ${index + 1}" class="w-full h-24 object-cover rounded-lg">
                <button 
                    type="button"
                    onclick="removeImage(${index})"
                    class="absolute -top-2 -right-2 w-6 h-6 bg-red-600 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-700"
                >
                    ×
                </button>
            </div>
        `;
    }).join('');
}

function removeImage(index) {
    selectedImages.splice(index, 1);
    displayImagePreviews();
    
    // Update file input
    const fileInput = document.getElementById('product-images');
    const dt = new DataTransfer();
    selectedImages.forEach(file => dt.items.add(file));
    fileInput.files = dt.files;
}

async function handleCreateProduct(e) {
    e.preventDefault();
    
    if (selectedImages.length === 0) {
        showToast('En az bir fotoğraf yüklemelisiniz', 'error');
        return;
    }
    
    const formData = new FormData(e.target);
    
    try {
        showToast('Fotoğraflar yükleniyor...', 'info');
        
        // Upload images
        const imageUrls = [];
        for (const image of selectedImages) {
            const uploadFormData = new FormData();
            uploadFormData.append('file', image);
            
            const uploadResponse = await fetch('/api/upload', {
                method: 'POST',
                body: uploadFormData,
                credentials: 'same-origin'
            });
            
            const uploadResult = await uploadResponse.json();
            
            if (uploadResult.success) {
                imageUrls.push(uploadResult.data.url);
            } else {
                throw new Error('Fotoğraf yüklenemedi: ' + uploadResult.message);
            }
        }
        
        showToast('Ürün oluşturuluyor...', 'info');
        
        const productData = {
            title: formData.get('title'),
            description: formData.get('description'),
            price: parseFloat(formData.get('suggested_price')) || 0,
            shop_id: parseInt(formData.get('shop_id')),
            images: imageUrls,
            metadata: {
                suggested_price: parseFloat(formData.get('suggested_price')) || 0
            }
        };
        
        const response = await apiCall('products', {
            method: 'POST',
            body: JSON.stringify(productData)
        });
        
        if (response.success) {
            showToast('Ürün başarıyla paylaşıldı! Esnaf onayını bekliyor.', 'success');
            
            setTimeout(() => {
                window.location.href = '/student/products';
            }, 2000);
        }
        
    } catch (error) {
        showToast(error.message, 'error');
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
