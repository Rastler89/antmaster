const CACHE_NAME = 'antmaster-v1';
const ASSETS_TO_CACHE = [
  '/',
  '/offline.html',
  '/assets/img/icon-192.png',
  '/assets/img/icon-512.png',
  '/assets/img/logo.png',
  'https://cdn.tailwindcss.com',
  'https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap'
];

// Instalación: Cachear activos estáticos
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      console.log('AntMaster Pro SW: Cacheando activos estáticos...');
      return cache.addAll(ASSETS_TO_CACHE);
    })
  );
});

// Activación: Limpiar caches antiguos
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (cacheName !== CACHE_NAME) {
            console.log('AntMaster Pro SW: Limpiando cache antiguo:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

// Estrategia de Fetch
self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);

  // Ignorar peticiones de API para la estrategia de cache normal
  if (url.pathname.startsWith('/api/')) {
    event.respondWith(fetch(request));
    return;
  }

  // Estrategia: Network-First con fallback a Cache y luego Offline.html
  event.respondWith(
    fetch(request)
      .then((response) => {
        // Guardar en cache si la respuesta es válida
        if (response.ok && request.method === 'GET') {
          const responseClone = response.clone();
          caches.open(CACHE_NAME).then((cache) => {
            cache.put(request, responseClone);
          });
        }
        return response;
      })
      .catch(() => {
        return caches.match(request).then((cachedResponse) => {
          if (cachedResponse) {
            return cachedResponse;
          }
          // Si es una navegación (HTML), mostrar offline.html
          if (request.mode === 'navigate') {
            return caches.match('/offline.html');
          }
          return null;
        });
      })
  );
});

// Manejo de Notificaciones Push
self.addEventListener('push', (event) => {
    let data = { title: 'AntMaster Pro', body: 'Tienes una nueva notificación' };
    
    if (event.data) {
        try {
            data = event.data.json();
        } catch (e) {
            data.body = event.data.text();
        }
    }

    const options = {
        body: data.body,
        icon: '/assets/img/icon-192.png',
        badge: '/assets/img/icon-192.png', // Icono monocromo para Android
        vibrate: [100, 50, 100],
        data: {
            url: data.url || '/'
        }
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

// Clic en la notificación
self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    event.waitUntil(
        clients.openWindow(event.notification.data.url)
    );
});
