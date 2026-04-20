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
                    <span class="text-gray-900">Kullanıcılar</span>
                </nav>
                <h1 class="text-3xl font-bold text-gray-900">Kullanıcı Yönetimi</h1>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        Ara
                    </label>
                    <input type="text" id="search" placeholder="Ad, email ara..." class="w-full"
                        onkeyup="debounceFilter()" />
                </div>

                <div>
                    <label for="role-filter" class="block text-sm font-medium text-gray-700 mb-2">
                        Rol
                    </label>
                    <select id="role-filter" class="w-full" onchange="filterUsers()">
                        <option value="">Tüm Roller</option>
                        <option value="musteri">Müşteri</option>
                        <option value="ogrenci">Öğrenci</option>
                        <option value="esnaf">Esnaf</option>
                        <option value="admin">Admin</option>
                    </select>

                </div>

                <div>
                    <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-2">
                        Durum
                    </label>
                    <select id="status-filter" class="w-full" onchange="filterUsers()">
                        <option value="">Tüm Durumlar</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Pasif</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button onclick="exportUsers()" class="btn btn-outline w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Dışa Aktar
                    </button>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kullanıcı
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rol
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Durum
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kayıt Tarihi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                İşlemler
                            </th>
                        </tr>
                    </thead>
                    <tbody id="users-table-body" class="bg-white divide-y divide-gray-200">
                        <!-- Loading rows -->
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <tr class="animate-pulse">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                                        <div class="ml-4">
                                            <div class="h-4 bg-gray-200 rounded mb-1"></div>
                                            <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="h-4 bg-gray-200 rounded w-16"></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="h-4 bg-gray-200 rounded w-16"></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="h-4 bg-gray-200 rounded w-20"></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="h-4 bg-gray-200 rounded w-16"></div>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Role Edit Modal -->
<div id="roleEditModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeRoleModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Kullanıcı Rolünü Düzenle</h3>
                        <div class="mt-4">
                            <input type="hidden" id="editUserId">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Yeni Rol</label>
                            <select id="editUserRole" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="musteri">Müşteri</option>
                                <option value="ogrenci">Öğrenci</option>
                                <option value="esnaf">Esnaf</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="saveUserRole()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Kaydet</button>
                <button type="button" onclick="closeRoleModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">İptal</button>
            </div>
        </div>
    </div>
</div>

<script>
    let allUsers = [];

    // Debounce: Kullanıcı yazmayı bırakınca 400ms sonra arama yap
    let _filterTimer = null;
    function debounceFilter() {
        clearTimeout(_filterTimer);
        _filterTimer = setTimeout(() => filterUsers(), 400);
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Linkteki (URL) parametreyi yakala (?role=ogrenci vb.)
        const urlParams = new URLSearchParams(window.location.search);
        let roleParam = urlParams.get('role');

        if (roleParam) {
            // Eğer eski "student/merchant" gibi linkler hala varsa hatasız çevir
            const roleMap = { 'student': 'ogrenci', 'merchant': 'esnaf', 'customer': 'musteri' };
            roleParam = roleMap[roleParam] || roleParam;

            // Seçim kutusunu (Dropdown) gelen parametreye ayarla
            document.getElementById('role-filter').value = roleParam;
        }

        loadUsers();
    });


    async function loadUsers() {
        try {
            const token = localStorage.getItem('auth_token');
            if (!token) {
                window.location.href = '/login';
                return;
            }

            // Server-side filtreleme: Backend GET /api/Admin/users?search=&role=&status= destekliyor
            const search       = document.getElementById('search')?.value || '';
            const roleFilter   = document.getElementById('role-filter')?.value || '';
            const statusFilter = document.getElementById('status-filter')?.value || '';

            let url = 'Admin/users';
            const params = [];
            if (search)       params.push(`search=${encodeURIComponent(search)}`);
            if (roleFilter)   params.push(`role=${encodeURIComponent(roleFilter)}`);
            if (statusFilter) params.push(`status=${encodeURIComponent(statusFilter)}`);
            if (params.length) url += '?' + params.join('&');

            const response = await apiCall(url);

            // Backend { success: true, data: [...] } sarıcısını aç
            allUsers = Array.isArray(response) ? response : (response.data || []);
            displayUsers();

        } catch (error) {
            console.error('Error loading users:', error);
            showToast('Kullanıcılar yüklenirken hata oluştu: ' + error.message, 'error');

            allUsers = [];
            document.getElementById('users-table-body').innerHTML = '<tr><td colspan="5" class="text-center py-8 text-gray-500">Kullanıcı bulunamadı</td></tr>';
        }
    }

    function displayUsers() {
        const tbody = document.getElementById('users-table-body');

        if (!allUsers.length) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center py-8 text-gray-500">Kullanıcı bulunamadı</td></tr>';
            return;
        }

        tbody.innerHTML = allUsers.map(user => `
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                       <span class="text-sm font-medium text-blue-600">${(user.fullName || '?').charAt(0)}</span>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">${escapeHtml(user.fullName)}</div>
                        <div class="text-sm text-gray-500">${escapeHtml(user.email)}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="badge badge-${getRoleBadgeClass(user.role)}">
                    ${getRoleName(user.role)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="badge badge-${user.isActive ? 'success' : 'error'}">
                    ${user.isActive ? 'Aktif' : 'Pasif'}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${formatDate(user.createdAt)}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex space-x-2">
                    <button onclick="editUser(${user.id})" class="text-blue-600 hover:text-blue-900 border border-blue-600 px-2 py-1 rounded">
                        Düzenle
                    </button>
                    <button onclick="toggleUserStatus(${user.id})" class="text-${user.isActive ? 'yellow' : 'green'}-600 hover:text-${user.isActive ? 'yellow' : 'green'}-900 border border-${user.isActive ? 'yellow' : 'green'}-600 px-2 py-1 rounded">
                        ${user.isActive ? 'Pasifleştir' : 'Aktifleştir'}
                    </button>
                    <button onclick="deleteUser(${user.id})" class="text-red-600 hover:text-red-900 border border-red-600 px-2 py-1 rounded">
                        Sil
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
    }

    // Filtreler backend'e gönderiliyor — loadUsers() yeniden çağrılıyor
    function filterUsers() {
        loadUsers();
    }

    async function toggleUserStatus(userId) {
        const user = allUsers.find(u => u.id === userId);
        if (!user) return;

        const action = user.isActive ? 'pasifleştirmek' : 'aktifleştirmek';
        if (!(await openCustomModal(`${user.fullName} kullanıcısını ${action} istediğinizden emin misiniz?`))) return;

        try {
            await apiCall(`Admin/users/${userId}/toggle-status`, { method: 'PUT' });

            // Listeyi sunucudan yeniden çek (server-side filtrelemeyle tutarlılık)
            await loadUsers();
            showToast(user.isActive ? 'Kullanıcı pasifleştirildi.' : 'Kullanıcı aktifleştirildi.', 'success');
        } catch (error) {
            showToast('İşlem başarısız: ' + error.message, 'error');
        }
    }
    // ← BURADA FAZLADAN catch OLMAMALI

    function editUser(userId) {
        const user = allUsers.find(u => u.id === userId);
        if (!user) return;
        
        document.getElementById('editUserId').value = userId;
        // Fix for legacy enum values in UI just in case
        const mappedRole = ['student', 'merchant', 'customer'].includes(user.role) 
            ? { student: 'ogrenci', merchant: 'esnaf', customer: 'musteri' }[user.role] 
            : user.role;
        document.getElementById('editUserRole').value = mappedRole;
        
        document.getElementById('roleEditModal').classList.remove('hidden');
    }
    
    function closeRoleModal() {
        document.getElementById('roleEditModal').classList.add('hidden');
    }

    async function saveUserRole() {
        const userId = document.getElementById('editUserId').value;
        const newRole = document.getElementById('editUserRole').value;
        const user = allUsers.find(u => Number(u.id) === Number(userId));
        
        if (!user || user.role === newRole) {
            closeRoleModal();
            return;
        }

        try {
            await apiCall(`Admin/users/${userId}/role`, {
                method: 'PUT',
                body: JSON.stringify({ newRole: newRole })
            });
            showToast('Kullanıcı rolü güncellendi.', 'success');
            closeRoleModal();
            await loadUsers();
        } catch (error) {
            showToast('Hata: ' + error.message, 'error');
        }
    }

    async function deleteUser(userId) {
        const user = allUsers.find(u => u.id === userId);
        // Admin kullanıcısı silinemez
        if (user?.role === 'admin') {
            showToast('Admin kullanıcısı silinemez.', 'error');
            return;
        }
        if (!(await openCustomModal(`Bu kullanıcıyı kalıcı olarak silmek istediğinize emin misiniz? Bu işlem geri alınamaz.`))) return;
        
        try {
            await apiCall(`Admin/users/${userId}`, { method: 'DELETE' });
            showToast('Kullanıcı silindi.', 'success');
            await loadUsers();
        } catch (error) {
            showToast('Silme işlemi başarısız: ' + error.message, 'error');
        }
    }
    function exportUsers() {
        // Simple CSV export
        const csvContent = "data:text/csv;charset=utf-8," +
            "Ad Soyad,Email,Rol,Durum,Kayıt Tarihi\n" +
            allUsers.map(user =>
                `"${user.fullName}","${user.email}","${getRoleName(user.role)}","${user.isActive ? 'Aktif' : 'Pasif'}","${user.createdAt}"`
            ).join("\n");

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "kullanicilar.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        showToast('Kullanıcı listesi indirildi', 'success');
    }

    function getRoleName(role) {
        const roleNames = {
            musteri: 'Müşteri',
            ogrenci: 'Öğrenci',
            esnaf: 'Esnaf',
            admin: 'Admin'
        };
        return roleNames[role] || role;
    }


    function getRoleBadgeClass(role) {
        const badgeClasses = {
            musteri: 'primary',
            ogrenci: 'success',
            esnaf: 'warning',
            admin: 'error'
        };
        return badgeClasses[role] || 'gray';
    }


    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('tr-TR', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>