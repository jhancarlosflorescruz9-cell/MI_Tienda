{{-- seguimiento/index.blade.php --}}
@extends('layouts.app')
@section('title','Rastrear Pedido')

@section('nav-extra')
  <a class="nav-btn-ghost" href="{{ route('home') }}">🏠 Inicio</a>
@endsection

@section('content')
<div style="max-width:480px;margin:24px auto;padding:0 16px 60px;">
  <div style="background:#fff;border-radius:16px;box-shadow:0 2px 0 #e5e7eb,0 4px 20px rgba(0,0,0,.07);padding:28px;text-align:center;">
    <div style="font-size:48px;margin-bottom:12px;">📦</div>
    <h2 style="font-family:'Bebas Neue',sans-serif;font-size:26px;letter-spacing:2px;color:var(--blue);margin-bottom:6px;">RASTREAR PEDIDO</h2>
    <p style="font-size:13px;color:var(--gray);font-weight:700;margin-bottom:20px;">Ingresa tu código de pedido para ver el estado.</p>
    <form method="GET" action="{{ route('seguimiento.buscar', 'x') }}" id="trackForm"
      onsubmit="event.preventDefault(); const c=document.getElementById('trackCode').value.trim().replace('#',''); window.location='/seguimiento/%23'+c;">
      <div style="display:flex;gap:8px;">
        <input id="trackCode" type="text" placeholder="#ABC123" maxlength="7"
          style="flex:1;background:#f9fafb;border:2px solid var(--border);border-radius:10px;padding:12px 14px;font-family:'Nunito',sans-serif;font-size:14px;font-weight:700;color:var(--dark);outline:none;text-transform:uppercase;">
        <button type="submit"
          style="background:var(--blue);border:none;color:#fff;padding:12px 20px;border-radius:10px;font-family:'Bebas Neue',sans-serif;font-size:18px;letter-spacing:1px;cursor:pointer;box-shadow:0 3px 0 var(--blue2);">
          BUSCAR
        </button>
      </div>
    </form>

    @if(session('error'))
      <div style="margin-top:14px;background:#fee2e2;border:2px solid #fca5a5;border-radius:8px;padding:10px;font-size:12px;font-weight:800;color:var(--red);">
        ❌ {{ session('error') }}
      </div>
    @endif

    <div style="margin-top:20px;padding-top:16px;border-top:1.5px solid #f3f4f6;">
      <a href="{{ route('home') }}"
        style="display:inline-flex;align-items:center;gap:6px;color:var(--blue);font-size:13px;font-weight:800;text-decoration:none;">
        ← Volver al inicio
      </a>
    </div>

  </div>
</div>
@endsection