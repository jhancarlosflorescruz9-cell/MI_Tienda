const CACHE_NAME = 'copias-tipeos-v1';
const ARCHIVOS_CACHE = [
    '/',
    '/manifest.json',
];

// Instalar y cachear archivos esenciales
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(ARCHIVOS_CACHE))
            .then(() => self.skipWaiting())
    );
});

// Activar y limpiar caches viejos
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k))
            )
        ).then(() => self.clients.claim())
    );
});

// Estrategia: Network first, Cache fallback
self.addEventListener('fetch', event => {
    // Solo cachear GET
    if (event.request.method !== 'GET') return;

    // No cachear rutas del admin ni POST
    const url = new URL(event.request.url);
    if (url.pathname.startsWith('/admin')) return;

    event.respondWith(
        fetch(event.request)
            .then(response => {
                // Guardar copia en cache si es exitosa
                if (response.status === 200) {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(event.request, clone));
                }
                return response;
            })
            .catch(() => caches.match(event.request))
    );
});
