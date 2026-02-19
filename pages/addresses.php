<?php
// Giriş kontrolü
if (!$current_user) {
    header('Location: /login?redirect=/addresses');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Adreslerim</h1>
                <p class="text-gray-600">Teslimat adreslerinizi yönetin</p>
            </div>
            <button onclick="openAddressModal()" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Yeni Adres Ekle
            </button>
        </div>
        
        <!-- Addresses List -->
        <div id="addresses-container" class="space-y-4">
            <!-- Loading skeleton -->
            <div class="animate-pulse">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="h-4 bg-gray-200 rounded mb-2"></div>
                    <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                    <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                </div>
            </div>
        </div>
        
        <!-- Empty Addresses -->
        <div id="empty-addresses" class="text-center py-12" style="display: none;">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz adres eklenmedi</h3>
            <p class="text-gray-500 mb-6">İlk teslimat adresinizi ekleyin.</p>
            <button onclick="openAddressModal()" class="btn btn-primary">
                İlk Adresimi Ekle
            </button>
        </div>
    </div>
</div>

<!-- Address Modal -->
<div id="address-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-screen overflow-y-auto">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6" id="modal-title">Yeni Adres Ekle</h3>
            
            <form id="address-form" class="space-y-4">
                <input type="hidden" id="address-id" />
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="address_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Adres Başlığı
                        </label>
                        <input
                            type="text"
                            id="address_title"
                            name="title"
                            class="w-full"
                            placeholder="Ev, İş, vs."
                            required
                        />
                    </div>
                    
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Ad Soyad
                        </label>
                        <input
                            type="text"
                            id="full_name"
                            name="full_name"
                            value="<?php echo htmlspecialchars($current_user['full_name']); ?>"
                            class="w-full"
                            required
                        />
                    </div>
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Telefon
                    </label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="<?php echo htmlspecialchars($current_user['phone'] ?? ''); ?>"
                        class="w-full"
                        required
                    />
                </div>
                
                <div>
                    <label for="address_line1" class="block text-sm font-medium text-gray-700 mb-2">
                        Adres Satırı 1
                    </label>
                    <input
                        type="text"
                        id="address_line1"
                        name="address_line1"
                        class="w-full"
                        placeholder="Mahalle, sokak, bina no"
                        required
                    />
                </div>
                
                <div>
                    <label for="address_line2" class="block text-sm font-medium text-gray-700 mb-2">
                        Adres Satırı 2 (Opsiyonel)
                    </label>
                    <input
                        type="text"
                        id="address_line2"
                        name="address_line2"
                        class="w-full"
                        placeholder="Daire no, kat, vs."
                    />
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                            İl
                        </label>
                        <select id="city" name="city" class="w-full" required>
                            <option value="">İl seçin</option>
                            <option value="İstanbul">İstanbul</option>
                            <option value="Ankara">Ankara</option>
                            <option value="İzmir">İzmir</option>
                            <option value="Bursa">Bursa</option>
                            <option value="Antalya">Antalya</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-2">
                            İlçe
                        </label>
                        <input
                            type="text"
                            id="district"
                            name="district"
                            class="w-full"
                            placeholder="İlçe"
                            required
                        />
                    </div>
                    
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                            Posta Kodu
                        </label>
                        <input
                            type="text"
                            id="postal_code"
                            name="postal_code"
                            class="w-full"
                            placeholder="34000"
                        />
                    </div>
                </div>
                
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        id="is_default"
                        name="is_default"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    />
                    <label for="is_default" class="ml-2 block text-sm text-gray-900">
                        Varsayılan adres olarak ayarla
                    </label>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeAddressModal()" class="btn btn-outline">
                        İptal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Adresi Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let addresses = [];

document.addEventListener('DOMContentLoaded', function() {
    loadAddresses();
    
    document.getElementById('address-form').addEventListener('submit', handleAddressSubmit);
});

async function loadAddresses() {
    try {
        // Mock data - API endpoint eklenecek
        addresses = [
            {
                id: 1,
                title: 'Ev',
                full_name: 'Test Müşteri',
                phone: '0533 616 02 18',
                address_line1: 'Test Mahallesi, Test Sokak No:5',
                address_line2: 'Daire 3',
                city: 'İstanbul',
                district: 'Kadıköy',
                postal_code: '34710',
                is_default: true
            }
        ];
        
        displayAddresses();
        
    } catch (error) {
        console.error('Error loading addresses:', error);
    }
}

function displayAddresses() {
    const container = document.getElementById('addresses-container');
    
    if (addresses.length === 0) {
        container.innerHTML = '';
        document.getElementById('empty-addresses').style.display = 'block';
        return;
    }
    
    document.getElementById('empty-addresses').style.display = 'none';
    
    container.innerHTML = addresses.map(address => `
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-2">
                        <h3 class="text-lg font-medium text-gray-900">${escapeHtml(address.title)}</h3>
                        ${address.is_default ? `
                            <span class="badge badge-primary">Varsayılan</span>
                        ` : ''}
                    </div>
                    
                    <div class="text-sm text-gray-600 space-y-1">
                        <p><strong>${escapeHtml(address.full_name)}</strong></p>
                        <p>${escapeHtml(address.phone)}</p>
                        <p>${escapeHtml(address.address_line1)}</p>
                        ${address.address_line2 ? `<p>${escapeHtml(address.address_line2)}</p>` : ''}
                        <p>${escapeHtml(address.district)}, ${escapeHtml(address.city)} ${escapeHtml(address.postal_code || '')}</p>
                    </div>
                </div>
                
                <div class="flex space-x-2">
                    <button onclick="editAddress(${address.id})" class="btn btn-outline btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    
                    ${!address.is_default ? `
                        <button onclick="deleteAddress(${address.id})" class="btn btn-error btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    ` : ''}
                    
                    ${!address.is_default ? `
                        <button onclick="setDefaultAddress(${address.id})" class="btn btn-success btn-sm">
                            Varsayılan Yap
                        </button>
                    ` : ''}
                </div>
            </div>
        </div>
    `).join('');
}

function openAddressModal(addressId = null) {
    const modal = document.getElementById('address-modal');
    const form = document.getElementById('address-form');
    
    if (addressId) {
        // Edit mode
        const address = addresses.find(a => a.id === addressId);
        if (address) {
            document.getElementById('modal-title').textContent = 'Adresi Düzenle';
            document.getElementById('address-id').value = addressId;
            
            // Fill form
            Object.keys(address).forEach(key => {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) {
                    if (input.type === 'checkbox') {
                        input.checked = address[key];
                    } else {
                        input.value = address[key];
                    }
                }
            });
        }
    } else {
        // Add mode
        document.getElementById('modal-title').textContent = 'Yeni Adres Ekle';
        form.reset();
        document.getElementById('address-id').value = '';
    }
    
    modal.style.display = 'flex';
}

function closeAddressModal() {
    document.getElementById('address-modal').style.display = 'none';
}

async function handleAddressSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const addressId = formData.get('address-id') || document.getElementById('address-id').value;
    
    const data = {
        title: formData.get('title'),
        full_name: formData.get('full_name'),
        phone: formData.get('phone'),
        address_line1: formData.get('address_line1'),
        address_line2: formData.get('address_line2'),
        city: formData.get('city'),
        district: formData.get('district'),
        postal_code: formData.get('postal_code'),
        is_default: formData.get('is_default') === 'on'
    };
    
    try {
        if (addressId) {
            // Update existing address
            const address = addresses.find(a => a.id == addressId);
            if (address) {
                Object.assign(address, data);
                showToast('Adres güncellendi', 'success');
            }
        } else {
            // Add new address
            const newAddress = { ...data, id: Date.now() };
            addresses.push(newAddress);
            showToast('Yeni adres eklendi', 'success');
        }
        
        // If set as default, update others
        if (data.is_default) {
            addresses.forEach(addr => {
                if (addr.id != addressId) {
                    addr.is_default = false;
                }
            });
        }
        
        closeAddressModal();
        displayAddresses();
        
    } catch (error) {
        showToast(error.message, 'error');
    }
}

async function deleteAddress(addressId) {
    if (!confirm('Bu adresi silmek istediğinizden emin misiniz?')) {
        return;
    }
    
    try {
        // API endpoint eklenecek
        addresses = addresses.filter(a => a.id !== addressId);
        displayAddresses();
        showToast('Adres silindi', 'success');
        
    } catch (error) {
        showToast('Adres silinirken hata oluştu', 'error');
    }
}

async function setDefaultAddress(addressId) {
    try {
        // API endpoint eklenecek
        addresses.forEach(addr => {
            addr.is_default = addr.id === addressId;
        });
        
        displayAddresses();
        showToast('Varsayılan adres güncellendi', 'success');
        
    } catch (error) {
        showToast('Varsayılan adres güncellenirken hata oluştu', 'error');
    }
}

function editAddress(addressId) {
    openAddressModal(addressId);
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('address-modal');
    if (e.target === modal) {
        closeAddressModal();
    }
});
</script>
