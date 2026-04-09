/**
 * Lógica principal de la PWA sincronizable de AntMaster Pro
 */
const PWA_MANAGER = (function() {
    let isOffline = !navigator.onLine;

    const init = async () => {
        console.log('AntMaster Pro PWA: Inicializando...');
        
        try {
            await PWA_DB.init();
            
            // Si estamos en línea, sincronizar datos del servidor
            if (!isOffline) {
                await syncDataFromServer();
                await processSyncQueue();
            }

            // Registrar listeners de conectividad
            window.addEventListener('online', handleOnline);
            window.addEventListener('offline', handleOffline);

            // Hijack de formularios (si el DOM ya cargó)
            setupInterceptors();
            
            // Actualizar UI de estado
            updateStatusUI();

            // Hidratar UI si estamos en una página de colonia
            if (window.location.pathname.includes('/colonias/ver/')) {
                await hydrateColonyView();
            }

            console.log('AntMaster Pro PWA: Inicializado correctamente.');
            
            // Intentar suscripción Push
            if (!isOffline) {
                await setupPushNotifications();
            }
        } catch (error) {
            console.error('Error inicializando PWA:', error);
        }
    };

    const setupPushNotifications = async () => {
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            console.warn('Push no soportado en este navegador.');
            return;
        }

        try {
            const registration = await navigator.serviceWorker.ready;
            
            // Comprobar si ya existe suscripción
            let subscription = await registration.pushManager.getSubscription();
            
            if (!subscription) {
                // Solicitar permiso si no tenemos suscripción
                const permission = await Notification.requestPermission();
                if (permission !== 'granted') return;

                // Generar nueva suscripción
                // Necesitamos la VAPID_PUBLIC_KEY inyectada globalmente o en el DOM
                const vapidPublicKey = window.VAPID_PUBLIC_KEY;
                if (!vapidPublicKey) {
                    console.error('VAPID_PUBLIC_KEY no encontrada en el entorno.');
                    return;
                }

                const convertedVapidKey = urlBase64ToUint8Array(vapidPublicKey);
                subscription = await registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: convertedVapidKey
                });

                // Enviar al servidor
                await fetch('/api/push/subscribe', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(subscription)
                });
                
                console.log('AntMaster Pro PWA: Suscripción Push registrada.');
            }
        } catch (error) {
            console.error('Error configurando Push:', error);
        }
    };

    const urlBase64ToUint8Array = (base64String) => {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    };

    const handleOnline = async () => {
        isOffline = false;
        updateStatusUI();
        console.log('AntMaster Pro PWA: Volviendo a estar en línea.');
        await processSyncQueue();
        await syncDataFromServer();
    };

    const handleOffline = () => {
        isOffline = true;
        updateStatusUI();
        console.warn('AntMaster Pro PWA: Modo fuera de línea activado.');
    };

    const syncDataFromServer = async () => {
        if (isOffline) return;
        
        try {
            const response = await fetch('/api/data');
            if (response.ok) {
                const data = await response.json();
                await PWA_DB.saveData(data);
                console.log('AntMaster Pro PWA: Sincronización entrante completada.');
            }
        } catch (error) {
            console.error('Error sincronizando desde servidor:', error);
        }
    };

    const processSyncQueue = async () => {
        if (isOffline) return;

        const queue = await PWA_DB.getSyncQueue();
        if (queue.length === 0) return;

        console.log(`AntMaster Pro PWA: Sincronizando ${queue.length} acciones pendientes...`);
        updateStatusUI('syncing');

        try {
            const response = await fetch('/api/sync', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ actions: queue })
            });

            if (response.ok) {
                const result = await response.json();
                // Limpiar la cola (por ahora borramos todo si el server respondió ok)
                await PWA_DB.clearSyncQueue();
                console.log('AntMaster Pro PWA: Sincronización saliente completada.');
            }
        } catch (error) {
            console.error('Error procesando cola de sincronización:', error);
        } finally {
            updateStatusUI();
        }
    };

    const setupInterceptors = () => {
        // Interceptar formularios de Diario
        document.body.addEventListener('submit', async (e) => {
            const form = e.target;
            
            // Diario
            if (form.getAttribute('id') === 'pwa-diary-form' || form.action.includes('/colonias/diario/')) {
                if (isOffline) {
                    e.preventDefault();
                    await handleOfflineDiary(form);
                }
            }

            // Población
            if (form.getAttribute('id') === 'pwa-pop-form' || form.action.includes('/colonias/poblacion/')) {
                 if (isOffline) {
                    e.preventDefault();
                    await handleOfflinePop(form);
                }
            }
        });
    };

    const handleOfflineDiary = async (form) => {
        const formData = new FormData(form);
        const colonyId = form.action.split('/').pop();
        
        const payload = {
            colony_id: colonyId,
            tipo_evento: formData.get('tipo_evento'),
            entrada: formData.get('entrada'),
            fecha_entrada: formData.get('fecha_entrada'),
            stock_id: formData.get('stock_id'),
            cantidad_usada: formData.get('cantidad_usada')
        };

        await PWA_DB.addToSyncQueue('ADD_DIARY', payload);
        
        // Notificar al usuario (Feedback visual)
        showNotification('Entrada guardada offline. Se sincronizará al volver a estar en línea.', 'success');
        
        // Limpiar y cerrar form si existe la función global
        if (window.toggleDiaryForm) window.toggleDiaryForm();
        form.reset();
    };

    const handleOfflinePop = async (form) => {
        const formData = new FormData(form);
        const colonyId = form.action.split('/').pop();
        
        // Ver si hay castas o total
        let castas = {};
        let total = 0;
        formData.forEach((value, key) => {
            if (key.startsWith('casta[')) {
                const castaName = key.match(/\[(.*?)\]/)[1];
                castas[castaName] = parseInt(value);
                total += parseInt(value);
            }
        });

        const payload = {
            colony_id: colonyId,
            poblacion: total > 0 ? total : parseInt(formData.get('poblacion')),
            detalles_json: Object.keys(castas).length > 0 ? JSON.stringify(castas) : null
        };

        await PWA_DB.addToSyncQueue('UPDATE_POPULATION', payload);
        
        showNotification('Recuento guardado offline.', 'success');
        
        if (window.togglePopForm) window.togglePopForm();
        form.reset();
    };

    const updateStatusUI = (forcedState = null) => {
        const indicator = document.getElementById('pwa-status-indicator');
        if (!indicator) return;

        const state = forcedState || (isOffline ? 'offline' : 'online');
        
        const states = {
            online: { text: 'En línea', color: 'text-emerald-500', bg: 'bg-emerald-500/10' },
            offline: { text: 'Modo Offline', color: 'text-orange-500', bg: 'bg-orange-500/10' },
            syncing: { text: 'Sincronizando...', color: 'text-blue-500', bg: 'bg-blue-500/10' }
        };

        const config = states[state];
        indicator.innerHTML = `<span class="flex items-center gap-1.5 px-2 py-0.5 rounded border border-current ${config.bg} ${config.color} text-[10px] font-black uppercase tracking-widest">
            <span class="w-1.5 h-1.5 rounded-full ${state === 'syncing' ? 'animate-pulse' : ''} bg-current"></span>
            ${config.text}
        </span>`;
    };

    const hydrateColonyView = async () => {
        const pathParts = window.location.pathname.split('/');
        const id = pathParts[pathParts.length - 1];
        if (!id || isNaN(id)) return;

        const colony = await PWA_DB.getById('colonies', id);
        if (!colony) return;

        console.log('AntMaster Pro PWA: Hidratando vista de colonia desde base de datos local...');

        // Actualizar población principal
        const popEl = document.querySelector('.text-4xl.font-black.text-white');
        if (popEl && colony.poblacion_actual !== undefined) {
             popEl.innerText = Number(colony.poblacion_actual).toLocaleString();
        }

        // Actualizar diario si el contenedor existe
        const diaryContainer = document.querySelector('.space-y-6');
        if (diaryContainer && colony.diary) {
            // Solo hidratamos si estamos offline o si queremos asegurar consistencia
            // Para simplificar, solo logueamos aquí, la hidratación completa de listas es costosa en SSR
            // Pero podríamos inyectar las entradas pendientes de sincronización
            const queue = await PWA_DB.getSyncQueue();
            const pendingDiary = queue.filter(a => a.type === 'ADD_DIARY' && a.payload.colony_id == id);
            
            if (pendingDiary.length > 0) {
                 pendingDiary.forEach(action => {
                     // Inyectar visualmente las entradas pendientes (estilo simplificado)
                     const item = document.createElement('div');
                     item.className = 'glass-card p-6 border-blue-500/50 opacity-70 relative';
                     item.innerHTML = `
                        <div class="absolute top-4 right-4 text-[8px] font-black uppercase text-blue-400">Pendiente de Sincronización</div>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center text-lg">📝</div>
                            <div>
                                <h4 class="text-white font-bold">${action.payload.tipo_evento}</h4>
                                <time class="text-[10px] text-zinc-500 font-bold uppercase tracking-widest">${action.payload.fecha_entrada}</time>
                            </div>
                        </div>
                        <p class="text-zinc-300 italic">${action.payload.entrada}</p>
                     `;
                     diaryContainer.prepend(item);
                 });
            }
        }
    };

    const showNotification = (message, type = 'info') => {
        // Simple alert o toast
        const toast = document.createElement('div');
        toast.className = `fixed bottom-24 left-1/2 -translate-x-1/2 z-[200] px-6 py-4 rounded-2xl shadow-2xl backdrop-blur-xl border border-white/10 text-white text-sm font-medium animate-fade-in ${type === 'success' ? 'bg-emerald-500/90' : 'bg-blue-500/90'}`;
        toast.innerText = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    };

    return { init };
})();

// Iniciar al cargar el DOM
document.addEventListener('DOMContentLoaded', PWA_MANAGER.init);
