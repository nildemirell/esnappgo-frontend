<?php
// Sadece giriş yapmış kullanıcılar görebilir
if (!$current_user) {
    header('Location: /login');
    exit;
}
?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Bildirimlerim</h1>
            <button onclick="markAllAsRead()" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                Tümünü Okundu İşaretle
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <ul id="notifications-list" class="divide-y divide-gray-100">
                <li class="p-4 animate-pulse flex space-x-4">
                    <div class="rounded-full bg-gray-200 h-10 w-10"></div>
                    <div class="flex-1 space-y-2 py-1">
                        <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                    </div>
                </li>
            </ul>
        </div>

    </div>
</div>

<script>
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text || '';
        return div.innerHTML;
    }

    function showLocalToast(message, type = 'info') {
        if (typeof showToast === 'function') {
            showToast(message, type);
        } else {
            alert(message);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadNotificationsPage();
    });

    async function loadNotificationsPage() {
        const token = localStorage.getItem('auth_token');

        // EĞER TOKEN HİÇ YOKSA DİREKT LOGİNE AT
        if (!token) {
            window.location.href = '/login';
            return;
        }

        const listContainer = document.getElementById('notifications-list');

        try {
            const res = await fetch(`${API_BASE}/api/Notifications`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            });

            // YENİ: EĞER TOKEN SÜRESİ DOLMUŞSA (401) LOGİNE AT
            if (res.status === 401) {
                localStorage.removeItem('auth_token'); // Bozuk tokenı temizle
                window.location.href = '/login';
                return;
            }

            if (!res.ok) {
                throw new Error("Bildirimler çekilemedi");
            }

            let rawNotifications = await res.json();
            
            // Backend'den gelen yeni DELETE endpointleri aktif olduğu için localStorage filtresi kaldırıldı
            const notifications = rawNotifications;

            if (!notifications || notifications.length === 0) {
                listContainer.innerHTML = `
                    <li class="p-8 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        Henüz hiç bildiriminiz yok.
                    </li>`;
                return;
            }

let htmlContent = '';
notifications.forEach(n => {
    const isReadClass = n.isRead ? '' : 'bg-blue-50/40 border-l-4 border-blue-400';
    const messageText = escapeHtml(n.message || n.content || 'Yeni Bildirim');
    const titleText  = escapeHtml(n.title || '');
    const isUnread   = !n.isRead;

    // Durum badge rengi — başlığa veya mesaja göre tahmin et
    let badgeColor = 'bg-gray-100 text-gray-600';
    let badgeText  = 'Bildirim';
    let dotColor   = 'bg-gray-400';
    const combined = (messageText + titleText).toLowerCase();
    if (combined.includes('onayland') || combined.includes('approved')) {
        badgeColor = 'bg-green-100 text-green-700'; badgeText = 'Onaylandı'; dotColor = 'bg-green-500';
    } else if (combined.includes('reddedil') || combined.includes('rejected')) {
        badgeColor = 'bg-red-100 text-red-700'; badgeText = 'Reddedildi'; dotColor = 'bg-red-500';
    } else if (combined.includes('bekliyor') || combined.includes('pending')) {
        badgeColor = 'bg-yellow-100 text-yellow-700'; badgeText = 'Beklemede'; dotColor = 'bg-yellow-500';
    } else if (combined.includes('askı') || combined.includes('suspended')) {
        badgeColor = 'bg-gray-100 text-gray-700'; badgeText = 'Askıya Alındı'; dotColor = 'bg-gray-500';
    } else if (combined.includes('sipariş') || combined.includes('order')) {
        badgeColor = 'bg-blue-100 text-blue-700'; badgeText = 'Sipariş'; dotColor = 'bg-blue-500';
    }

    // Bildirimde referenceId (productId veya orderId) varsa linke götür
    const detailLink = n.referenceId
        ? (combined.includes('sipariş') ? `/orders` : `/products/${n.referenceId}`)
        : '#';

    // Ürün görseli varsa göster, yoksa renkli avatar
    const imageHtml = n.imageUrl
        ? `<img src="${escapeHtml(n.imageUrl)}" alt="" class="w-12 h-12 rounded-xl object-cover border border-gray-100">`
        : `<div class="w-12 h-12 rounded-xl flex items-center justify-center ${badgeColor} text-xl font-bold">
               ${badgeText.charAt(0)}
           </div>`;

    let dateStr = '';
    if (n.createdAt) {
        const d = new Date(n.createdAt);
        dateStr = d.toLocaleDateString('tr-TR', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' });
    }

    htmlContent += `
    <li class="group relative">
        <a href="${detailLink}" onclick="${!n.isRead ? `markAsRead(${n.id}); return true;` : 'return true;'}"
           class="flex items-center gap-4 p-4 hover:bg-gray-50 transition-all duration-200 ${isReadClass}">
            
            <!-- Okunmadı nokta -->
            ${isUnread ? `<span class="absolute top-5 right-4 w-2 h-2 rounded-full ${dotColor}"></span>` : ''}
            
            <!-- Görsel / Avatar -->
            <div class="flex-shrink-0">${imageHtml}</div>
            
            <!-- Metin -->
            <div class="flex-1 min-w-0">
                ${titleText ? `<p class="text-sm font-semibold text-gray-900 mb-0.5">${titleText}</p>` : ''}
                <p class="text-sm text-gray-700 ${isUnread ? 'font-medium' : ''} line-clamp-2">${messageText}</p>
                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    ${dateStr}
                </p>
            </div>
            
            <!-- Badge ve Sil Butonu -->
            <div class="flex items-center gap-3">
                <span class="flex-shrink-0 text-xs font-semibold px-2.5 py-1 rounded-full ${badgeColor}">${badgeText}</span>
                <button onclick="event.preventDefault(); event.stopPropagation(); deleteNotification(${n.id});"
                        class="p-1.5 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-full transition-all focus:outline-none opacity-0 group-hover:opacity-100"
                        title="Bildirimi Sil">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        </a>
    </li>`;
});
listContainer.innerHTML = htmlContent;


        } catch (error) {
            console.error(error);
            listContainer.innerHTML = '<li class="p-4 text-center text-red-500">Bildirimler yüklenirken hata oluştu.</li>';
        }
    }

    async function markAsRead(id) {
        const token = localStorage.getItem('auth_token');

        try {
            const res = await fetch(`${API_BASE}/api/Notifications/${id}/read`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            });

            if (res.ok) {
                loadNotificationsPage();
                // FIX: Önceden fetchNotificationCount kullanılıyordu, diğer fonksiyonlar loadNotificationCount kullanıyor.
                // Tutarlılık için loadNotificationCount'a çevrildi.
                if (typeof loadNotificationCount === 'function') loadNotificationCount();
            } else if (res.status === 401) {
                window.location.href = '/login';
            } else {
                showLocalToast('İşlem başarısız', 'error');
            }
        } catch (e) {
            console.error(e);
            showLocalToast('Bir hata oluştu', 'error');
        }
    }

    async function markAllAsRead() {
        const token = localStorage.getItem('auth_token');
        if (!token) return;

        try {
            const res = await fetch(`${API_BASE}/api/Notifications/read-all`, {
                method: 'PUT',
                headers: { 'Authorization': 'Bearer ' + token }
            });

            if (res.ok || res.status === 204) {
                showLocalToast('Tüm bildirimler okundu olarak işaretlendi.', 'success');
                loadNotificationsPage();
                if (typeof loadNotificationCount === 'function') loadNotificationCount();
            } else {
                showLocalToast('İşlem başarısız oldu.', 'error');
            }
        } catch (e) {
            console.error(e);
            showLocalToast('Bir hata oluştu.', 'error');
        }
    }

    async function deleteNotification(id) {
        if (!await openCustomModal('Bu bildirimi silmek istediğinizden emin misiniz?')) return;

        try {
            const token = localStorage.getItem('auth_token');
            const res = await fetch(`${API_BASE}/api/Notifications/${id}`, {
                method: 'DELETE',
                headers: { 'Authorization': 'Bearer ' + token }
            });

            if (res.ok || res.status === 204) {
                showLocalToast('Bildirim başarıyla silindi.', 'success');
                loadNotificationsPage();
                
                if (typeof loadNotificationCount === 'function') {
                    loadNotificationCount();
                }
            } else {
                showLocalToast('Bildirim silinemedi.', 'error');
            }
        } catch (e) {
            console.error('Bildirim silme hatası:', e);
            showLocalToast('Bildirim silinirken hata oluştu.', 'error');
        }
    }

</script>