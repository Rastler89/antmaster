/**
 * Manager para la base de datos local (IndexedDB) de AntMaster Pro
 */
const PWA_DB = (function() {
    const DB_NAME = 'antmaster_pwa_db';
    const DB_VERSION = 1;
    let db = null;

    const init = () => {
        return new Promise((resolve, reject) => {
            const request = indexedDB.open(DB_NAME, DB_VERSION);

            request.onupgradeneeded = (event) => {
                const db = event.target.result;
                
                // Almacén para colonias y sus datos relacionados
                if (!db.objectStoreNames.contains('colonies')) {
                    db.createObjectStore('colonies', { keyPath: 'id' });
                }

                // Almacén para especies (catálogo)
                if (!db.objectStoreNames.contains('species')) {
                    db.createObjectStore('species', { keyPath: 'id' });
                }

                // Almacén para stock
                if (!db.objectStoreNames.contains('stocks')) {
                    db.createObjectStore('stocks', { keyPath: 'id' });
                }

                // Cola de sincronización para acciones pendientes
                if (!db.objectStoreNames.contains('sync_queue')) {
                    db.createObjectStore('sync_queue', { keyPath: 'id', autoIncrement: true });
                }
            };

            request.onsuccess = (event) => {
                db = event.target.result;
                resolve(db);
            };

            request.onerror = (event) => {
                reject('Error abriendo IndexedDB: ' + event.target.errorCode);
            };
        });
    };

    const getStore = (storeName, mode = 'readonly') => {
        const transaction = db.transaction([storeName], mode);
        return transaction.objectStore(storeName);
    };

    return {
        init,
        
        // Operaciones de Datos
        saveData: async (data) => {
            const { colonies, species, stocks } = data;
            
            const tx = db.transaction(['colonies', 'species', 'stocks'], 'readwrite');
            
            const colStore = tx.objectStore('colonies');
            const specStore = tx.objectStore('species');
            const stockStore = tx.objectStore('stocks');

            colonies.forEach(c => colStore.put(c));
            species.forEach(s => specStore.put(s));
            stocks.forEach(s => stockStore.put(s));

            return new Promise((resolve) => {
                tx.oncomplete = () => resolve(true);
            });
        },

        getAll: async (storeName) => {
            return new Promise((resolve) => {
                const store = getStore(storeName);
                const request = store.getAll();
                request.onsuccess = () => resolve(request.result);
            });
        },

        getById: async (storeName, id) => {
            return new Promise((resolve) => {
                const store = getStore(storeName);
                const request = store.get(Number(id));
                request.onsuccess = () => resolve(request.result);
            });
        },

        // Operaciones de Cola de Sincronización
        addToSyncQueue: async (type, payload) => {
            return new Promise((resolve) => {
                const store = getStore('sync_queue', 'readwrite');
                const request = store.add({
                    type,
                    payload,
                    timestamp: Date.now()
                });
                request.onsuccess = () => resolve(request.result);
            });
        },

        getSyncQueue: async () => {
            return new Promise((resolve) => {
                const store = getStore('sync_queue');
                const request = store.getAll();
                request.onsuccess = () => resolve(request.result);
            });
        },

        removeFromSyncQueue: async (id) => {
            return new Promise((resolve) => {
                const store = getStore('sync_queue', 'readwrite');
                const request = store.delete(id);
                request.onsuccess = () => resolve(true);
            });
        },

        clearSyncQueue: async () => {
             return new Promise((resolve) => {
                const store = getStore('sync_queue', 'readwrite');
                const request = store.clear();
                request.onsuccess = () => resolve(true);
            });
        }
    };
})();
