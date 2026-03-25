<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Copias & Tipeos — Pedidos Online')</title>
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#003fa3">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">
<style>
:root{
  --red:#e8001c;--red2:#c0001a;
  --blue:#003fa3;--blue2:#002d78;
  --yellow:#ffd000;--yellow2:#e6b800;
  --green:#16a34a;--green2:#14532d;
  --dark:#0a0d1a;--gray:#6b7280;
  --border:#e5e7eb;--bg:#f4f6ff;
}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--bg);font-family:'Nunito',sans-serif;min-height:100vh;}

/* NAV */
nav{background:var(--blue);padding:0 20px;display:flex;align-items:center;justify-content:space-between;height:58px;position:sticky;top:0;z-index:200;box-shadow:0 3px 0 var(--yellow);}
.nav-logo{font-family:'Bebas Neue',sans-serif;font-size:22px;letter-spacing:2px;color:#fff;text-decoration:none;display:flex;align-items:center;gap:6px;}
.nav-logo span{color:var(--yellow);}
.nav-right{display:flex;align-items:center;gap:8px;}
.nav-btn{display:flex;align-items:center;gap:5px;background:var(--yellow);color:var(--blue2);font-weight:900;font-size:12px;padding:6px 12px;border-radius:6px;text-decoration:none;box-shadow:0 3px 0 var(--yellow2);}
.nav-btn-ghost{background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.3);color:#fff;font-size:11px;font-weight:800;padding:6px 12px;border-radius:6px;cursor:pointer;text-decoration:none;}
.nav-btn-ghost:hover{background:rgba(255,255,255,.25);}

/* FLASH MESSAGES */
.flash{padding:12px 20px;font-size:13px;font-weight:800;text-align:center;}
.flash.success{background:#dcfce7;color:var(--green2);}
.flash.error{background:#fee2e2;color:var(--red2);}

@yield('styles')
</style>
@stack('styles')
</head>
<body>

<nav>
  <a class="nav-logo" href="{{ route('home') }}">🖨 COPIAS & <span>TIPEOS</span></a>
  <div class="nav-right">
    <a class="nav-btn" href="https://wa.me/51929286603" target="_blank">💬 WhatsApp</a>
    <a class="nav-btn-ghost" href="{{ route('seguimiento.index') }}">📦 Mi pedido</a>
    @yield('nav-extra')
  </div>
</nav>

@if(session('success'))
  <div class="flash success">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="flash error">❌ {{ session('error') }}</div>
@endif

@yield('content')

@stack('scripts')
<script>
// Registrar Service Worker (PWA)
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js').catch(() => {});
}
</script>
</body>
</html>
