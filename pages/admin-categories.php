<?php
// Admin kontrolü
if (!$current_user || $current_user['role'] !== 'admin') {
    header('Location: /login');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                    <a href="/admin" class="hover:text-gray-700">Admin</a>
                    <span>/</span>
                    <span class="text-gray-900">Kategoriler</span>
                </nav>
                <h1 class="text-3xl font-bold text-gray-900">Kategori Yönetimi</h1>
            </div>
            <button onclick="openCategoryModal()" class="btn btn-primary shadow-lg hover:shadow-xl transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Yeni Kategori Ekle
            </button>
        </div>

        <!-- Categories Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                İkon Bilgisi
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                İşlemler
                            </th>
                        </tr>
                    </thead>
                    <tbody id="categories-table-body" class="bg-white divide-y divide-gray-100">
                        <!-- Yükleniyor skeleton animasyonu -->
                        <tr id="loading-state" class="animate-pulse">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-200 rounded-lg"></div>
                                    <div class="ml-4 h-4 bg-gray-200 rounded w-24"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-16"></div></td>
                            <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-20"></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="category-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm shadow-2xl" aria-hidden="true" onclick="closeCategoryModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <form id="category-form" onsubmit="handleCategorySubmit(event)">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-teal-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-xl leading-6 font-semibold text-gray-900" id="modal-title">
                                Kategori Ekle
                            </h3>
                            <div class="mt-4 space-y-4">
                                <input type="hidden" id="category-id" name="id" value="" />
                                
                                <div>
                                    <label for="category-name" class="block text-sm font-medium text-gray-700 mb-1">Kategori Adı</label>
                                    <input type="text" id="category-name" name="name" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition-colors" placeholder="Örn: Elektronik">
                                </div>

                                <div>
                                    <label for="category-parent-id" class="block text-sm font-medium text-gray-700 mb-1">Üst Kategori (Opsiyonel)</label>
                                    <select id="category-parent-id" name="parentId" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition-colors">
                                        <option value="">-- Ana Kategori (Üst Kategori Yok) --</option>
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Alt kategori eklemek istiyorsanız bir üst kategori seçin.</p>
                                </div>
                                
                                <div>
                                    <label for="category-icon" class="block text-sm font-medium text-gray-700 mb-1">İkon Sınıfı veya URL (Opsiyonel)</label>
                                    <input type="text" id="category-icon" name="icon"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition-colors"
                                        placeholder="Örn: fa-solid fa-laptop">
                                    <p class="mt-1 text-xs text-gray-500">İkon için class ismi veya emoji kullanabilirsiniz.</p>
                                </div>
                                
                                <div id="status-container" class="hidden">
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="checkbox" id="category-is-active" name="isActive" class="form-checkbox h-5 w-5 text-teal-600 rounded transition duration-150 ease-in-out border-gray-300">
                                        <span class="text-gray-900 font-medium">Kategori Aktif (Soft Delete Geri Alma)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Kaydet
                    </button>
                    <button type="button" onclick="closeCategoryModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        İptal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let allCategories = [];

    document.addEventListener('DOMContentLoaded', () => {
        loadCategories();
    });

    async function loadCategories() {
        showLoadingState();
        try {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                window.location.href = '/login';
                return;
            }

            const data = await apiCall('Categories/tree');
            allCategories = data;
            displayCategories();
        } catch (error) {
            console.error('Kategori hatası:', error);
            showToast('Kategoriler çekilirken hata oluştu.', 'error');
            document.getElementById('categories-table-body').innerHTML = `
                <tr><td colspan="3" class="text-center py-8 text-gray-500 font-medium">Kategori bulunamadı veya ağ hatası.</td></tr>
            `;
        }
    }

    function showLoadingState() {
        document.getElementById('categories-table-body').innerHTML = `
            <tr class="animate-pulse">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-200 rounded-lg"></div>
                        <div class="ml-4 h-4 bg-gray-200 rounded w-32"></div>
                    </div>
                </td>
                <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-20"></div></td>
                <td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded w-24"></div></td>
            </tr>
        `;
    }

    function displayCategories() {
        const tbody = document.getElementById('categories-table-body');
        
        if (!allCategories || allCategories.length === 0) {
            tbody.innerHTML = `<tr><td colspan="3" class="text-center py-8 text-gray-500 bg-gray-50 rounded-b-xl">Henüz eklenmiş kategori bulunmuyor.</td></tr>`;
            return;
        }
        
        tbody.innerHTML = renderCategoryTree(allCategories);
    }

    function renderCategoryTree(categories, depth = 0) {
        let html = '';
        categories.forEach(cat => {
            const paddingStr = depth > 0 ? `style="padding-left: ${depth * 28}px"` : '';
            const treeIcon = depth > 0 ? `<span class="text-gray-300 mr-2">└─</span>` : '';
            const bgColor = depth > 0 ? (depth === 1 ? 'bg-gray-50/50' : 'bg-gray-100/50') : 'bg-white';
            const iconSize = depth > 0 ? 'w-8 h-8 text-sm' : 'w-10 h-10 text-lg';
            const nameSize = depth > 0 ? 'text-sm font-semibold' : 'text-sm font-bold';

            html += `
                <tr class="${bgColor} hover:bg-teal-50/30 transition-colors group border-b border-gray-100">
                    <td class="px-6 py-3 whitespace-nowrap">
                        <div class="flex items-center" ${paddingStr}>
                            ${treeIcon}
                            <div class="${iconSize} bg-gradient-to-br from-teal-400 to-teal-600 rounded-lg flex items-center justify-center shadow-sm transform group-hover:scale-105 transition-transform duration-200">
                                <span class="text-white font-bold">${cat.icon && cat.icon.trim() !== '' ? parseIcon(cat.icon) : cat.name.charAt(0)}</span>
                            </div>
                            <div class="ml-4">
                                <div class="${nameSize} text-gray-900">${escapeHtml(cat.name)}</div>
                                <div class="text-xs text-gray-400">ID: #${cat.id}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3 whitespace-nowrap">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                            ${cat.icon ? escapeHtml(cat.icon) : 'Yok'}
                        </span>
                    </td>
                    <td class="px-6 py-3 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <button onclick='editCategory(${JSON.stringify(cat).replace(/'/g, "&#39;")})' class="text-teal-600 hover:text-teal-900 bg-teal-50 px-2 py-1 rounded transition-colors border border-teal-100 hover:bg-teal-100 text-xs">
                                Düzenle
                            </button>
                            <button onclick="deleteCategory(${cat.id})" class="text-red-600 hover:text-red-900 bg-red-50 px-2 py-1 rounded transition-colors border border-red-100 hover:bg-red-100 text-xs">
                                Sil
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            if (cat.subCategories && cat.subCategories.length > 0) {
                html += renderCategoryTree(cat.subCategories, depth + 1);
            } else if (cat.children && cat.children.length > 0) {
                html += renderCategoryTree(cat.children, depth + 1);
            }
        });
        return html;
    }

    function parseIcon(iconStr) {
        if (!iconStr) return '';
        if (iconStr.includes('fa-') || iconStr.includes('i ')) {
            return `<i class="${escapeHtml(iconStr)}"></i>`;
        }
        return escapeHtml(iconStr);
    }

    function getFlatCategories(categories, flatList = [], prefix = '') {
        categories.forEach(cat => {
            flatList.push({ id: cat.id, name: prefix + cat.name });
            let children = cat.subCategories || cat.children || [];
            if (children.length > 0) {
                getFlatCategories(children, flatList, prefix + '-- ');
            }
        });
        return flatList;
    }

    function populateParentSelect(excludeId = null) {
        const select = document.getElementById('category-parent-id');
        select.innerHTML = '<option value="">-- Ana Kategori (Üst Kategori Yok) --</option>';
        
        const flatCats = getFlatCategories(allCategories);
        flatCats.forEach(cat => {
            if (cat.id !== excludeId) { 
                select.innerHTML += `<option value="${cat.id}">${escapeHtml(cat.name)}</option>`;
            }
        });
    }

    function openCategoryModal() {
        document.getElementById('modal-title').textContent = 'Yeni Kategori Ekle';
        document.getElementById('category-id').value = '';
        document.getElementById('category-name').value = '';
        document.getElementById('category-icon').value = '';
        document.getElementById('status-container').classList.add('hidden');
        document.getElementById('category-is-active').checked = true;
        
        populateParentSelect(); 
        document.getElementById('category-parent-id').value = ''; 
        
        const modal = document.getElementById('category-modal');
        modal.classList.remove('hidden');
    }

    function closeCategoryModal() {
        document.getElementById('category-modal').classList.add('hidden');
    }

    function editCategory(cat) {
        document.getElementById('modal-title').textContent = 'Kategoriyi Düzenle';
        document.getElementById('category-id').value = cat.id;
        document.getElementById('category-name').value = cat.name;
        document.getElementById('category-icon').value = cat.icon || '';
        
        populateParentSelect(cat.id); 
        document.getElementById('category-parent-id').value = cat.parentId || ''; 
        
        document.getElementById('status-container').classList.remove('hidden');
        document.getElementById('category-is-active').checked = true; 

        document.getElementById('category-modal').classList.remove('hidden');
    }

    async function handleCategorySubmit(e) {
        e.preventDefault();
        
        const id = document.getElementById('category-id').value;
        const name = document.getElementById('category-name').value;
        const iconInput = document.getElementById('category-icon').value;
        const icon = iconInput.trim() === '' ? null : iconInput;
        const isActive = document.getElementById('category-is-active').checked;
        
        const parentIdVal = document.getElementById('category-parent-id').value;
        const parentId = parentIdVal === '' ? null : parseInt(parentIdVal);
        
        const isEditing = id && id !== '';
        const method = isEditing ? 'PUT' : 'POST';
        
        // PAYLOAD: ParentId eklendi!
        const payload = isEditing 
            ? { Name: name, Icon: icon, ParentId: parentId, IsActive: isActive } 
            : { Name: name, Icon: icon, ParentId: parentId };

        try {
            await apiCall(isEditing ? `Categories/${id}` : 'Categories', {
                method: method,
                body: JSON.stringify(payload)
            });

            showToast(isEditing ? 'Kategori güncellendi!' : 'Kategori başarıyla eklendi!', 'success');
            closeCategoryModal();
            loadCategories();
        } catch (error) {
            showToast(error.message, 'error');
        }
    }

    async function deleteCategory(id) {
        if (!(await openCustomModal('Bu kategoriyi silmek istediğinizden emin misiniz? (Soft Delete)'))) return;

        try {
            await apiCall(`Categories/${id}`, { method: 'DELETE' });
            showToast('Kategori silindi.', 'success');
            loadCategories();
        } catch (error) {
            showToast(error.message, 'error');
        }
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>