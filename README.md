# 🖨️ Copias & Tipeos — Sistema de Pedidos en Laravel

Sistema completo de pedidos online para tu negocio de copias e impresiones.

---

## 📋 REQUISITOS

- PHP >= 8.1
- Composer
- MySQL o SQLite
- Laravel 10+

---

## 🚀 INSTALACIÓN PASO A PASO

### 1. Crear proyecto Laravel

```bash
composer create-project laravel/laravel copias-tipeos
cd copias-tipeos
```

### 2. Copiar los archivos de este proyecto

Copia cada carpeta en su lugar correspondiente dentro del proyecto Laravel:

```
app/Http/Controllers/    ← ClienteController.php, AdminController.php,
                           PedidoController.php, SeguimientoController.php
app/Http/Middleware/     ← AdminAuth.php
app/Models/              ← Pedido.php
config/                  ← admin.php
database/migrations/     ← 2024_01_01_000001_create_pedidos_table.php
resources/views/
  layouts/               ← app.blade.php
  cliente/               ← index.blade.php, success.blade.php
  admin/                 ← login.blade.php, dashboard.blade.php, pedidos.blade.php
  seguimiento/           ← index.blade.php, resultado.blade.php
routes/                  ← web.php
public/                  ← manifest.json, sw.js
```

### 3. Configurar el archivo .env

```bash
cp .env.example .env
php artisan key:generate
```

Edita `.env` con tus datos:

```env
APP_NAME="Copias & Tipeos"
APP_URL=http://localhost

# Base de datos (elige una opción)

# OPCIÓN A — SQLite (más fácil para empezar):
DB_CONNECTION=sqlite
# Crea el archivo: touch database/database.sqlite

# OPCIÓN B — MySQL:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=copias_tipeos
DB_USERNAME=root
DB_PASSWORD=tu_password

# WhatsApp (tu número con código de país)
WA_NUMBER=51929286603

# Credenciales del panel admin
ADMIN_USUARIO=admin
ADMIN_PASSWORD=tu_password_seguro
```

### 4. Registrar el Middleware en bootstrap/app.php (Laravel 11)

```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin.auth' => \App\Http\Middleware\AdminAuth::class,
    ]);
})
```

**O si usas Laravel 10**, en `app/Http/Kernel.php`:

```php
protected $middlewareAliases = [
    // ...
    'admin.auth' => \App\Http\Middleware\AdminAuth::class,
];
```

### 5. Registrar la ruta de éxito en routes/web.php

Agrega esta línea en `routes/web.php`:

```php
Route::get('/pedidos/{codigo}/success', [ClienteController::class, 'success'])->name('pedidos.success');
```

### 6. Ejecutar migraciones

```bash
# SQLite:
touch database/database.sqlite

# Correr migraciones:
php artisan migrate

# (Opcional) Datos de prueba:
php artisan db:seed
```

### 7. Crear enlace de almacenamiento

```bash
php artisan storage:link
```

### 8. Iniciar el servidor

```bash
php artisan serve
```

Abre: **http://localhost:8000**

---

## 🔗 RUTAS DE LA APLICACIÓN

| URL | Descripción |
|-----|-------------|
| `/` | Formulario de pedidos (clientes) |
| `/seguimiento` | Rastrear pedido por código |
| `/admin` | Dashboard del administrador |
| `/admin/login` | Login del administrador |
| `/admin/pedidos` | Lista y gestión de pedidos |
| `/admin/exportar/csv` | Descargar todos los pedidos en CSV |

---

## 🔐 CREDENCIALES ADMIN

Por defecto (cámbialo en `.env`):
- **Usuario:** `admin`
- **Contraseña:** `admin123`

---

## ⚙️ PERSONALIZACIÓN

### Cambiar el número de WhatsApp
En `resources/views/layouts/app.blade.php` y en `resources/views/cliente/success.blade.php`:
```
51929286603  →  51TU_NUMERO
```

### Cambiar horario de atención
En `app/Http/Controllers/PedidoController.php`:
```php
$hora = now()->hour;
if ($hora < 8 || $hora >= 20) { // Cambia 8 y 20
```

### Cambiar precios de servicios
En `app/Models/Pedido.php`, función `calcularTotal()`:
```php
$precios = [
    'Copias B&N'   => 0.20,  // ← Cambia aquí
    'Copias a color' => 0.80, // ← Cambia aquí
    // ...
];
```

### Agregar zona horaria de Perú
En `config/app.php`:
```php
'timezone' => 'America/Lima',
```

---

## 📦 ESTRUCTURA FINAL DEL PROYECTO

```
copias-tipeos/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ClienteController.php
│   │   │   ├── AdminController.php
│   │   │   ├── PedidoController.php
│   │   │   └── SeguimientoController.php
│   │   └── Middleware/
│   │       └── AdminAuth.php
│   └── Models/
│       └── Pedido.php
├── config/
│   └── admin.php
├── database/
│   └── migrations/
│       └── 2024_01_01_000001_create_pedidos_table.php
├── public/
│   ├── manifest.json
│   └── sw.js
├── resources/
│   └── views/
│       ├── layouts/app.blade.php
│       ├── cliente/
│       │   ├── index.blade.php
│       │   └── success.blade.php
│       ├── admin/
│       │   ├── login.blade.php
│       │   ├── dashboard.blade.php
│       │   └── pedidos.blade.php
│       └── seguimiento/
│           ├── index.blade.php
│           └── resultado.blade.php
└── routes/
    └── web.php
```

---

## 🌐 SUBIR A HOSTING (cPanel / Hostinger / etc.)

1. Sube todos los archivos al servidor
2. Apunta el **document root** a la carpeta `/public`
3. Configura el `.env` con los datos de producción
4. Ejecuta: `php artisan migrate --force`
5. Ejecuta: `php artisan storage:link`
6. Ejecuta: `php artisan config:cache`

---

## 📱 PWA (Instalar como App)

Los archivos `public/manifest.json` y `public/sw.js` ya están incluidos.
Una vez en HTTPS, Chrome mostrará automáticamente el banner "Instalar app".

---

## ✅ FUNCIONALIDADES INCLUIDAS

- [x] Formulario de pedidos en 3 pasos
- [x] Subida de archivos (PDF, Word, imagen)
- [x] Validación completa de formularios
- [x] Control de horario de atención
- [x] Envío automático por WhatsApp
- [x] Base de datos MySQL/SQLite
- [x] Panel de administración con login seguro
- [x] Gestión de estados de pedidos
- [x] Notificación al cliente por WhatsApp
- [x] Exportación a CSV
- [x] Dashboard con estadísticas y gráficas
- [x] Seguimiento de pedido para el cliente
- [x] PWA (instalable en celular)
