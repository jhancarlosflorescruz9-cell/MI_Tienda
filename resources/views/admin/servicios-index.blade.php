@extends('layouts.app')
@section('title','Gestión de Servicios')
@section('nav-extra')
  <a class="nav-btn-ghost" href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
  <a class="nav-btn-ghost" href="{{ route('admin.pedidos') }}">📋 Pedidos</a>
  <form method="POST" action="{{ route('admin.logout') }}" style="margin:0;">
    @csrf <button type="submit" class="nav-btn-ghost" style="cursor:pointer;">Salir 🔓</button>
  </form>
@endsection
@section('content')
<div style="max-width:700px;margin:0 auto;padding:20px 16px 60px;">

  {{-- HEADER --}}
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
    <div>
      <h1 style="font-family:'Bebas Neue',sans-serif;font-size:28px;letter-spacing:2px;color:var(--blue);">SERVICIOS</h1>
      <p style="font-size:13px;color:var(--gray);font-weight:700;margin-top:2px;">Gestiona los servicios que ofreces a tus clientes.</p>
    </div>
    <a href="{{ route('admin.servicios.create') }}"
      style="display:inline-flex;align-items:center;gap:6px;background:var(--blue);color:#fff;text-decoration:none;padding:10px 20px;border-radius:10px;font-family:'Bebas Neue',sans-serif;font-size:16px;letter-spacing:1.5px;box-shadow:0 3px 0 var(--blue2);">
      + NUEVO SERVICIO
    </a>
  </div>

  @if(session('success'))
    <div style="background:#dcfce7;border:2px solid #86efac;border-radius:10px;padding:12px 16px;font-size:13px;font-weight:800;color:var(--green2);margin-bottom:14px;">
      ✅ {{ session('success') }}
    </div>
  @endif

  {{-- LISTA --}}
  @forelse($servicios as $s)
  <div style="background:#fff;border-radius:14px;box-shadow:0 2px 0 #e5e7eb,0 4px 16px rgba(0,0,0,.06);margin-bottom:10px;padding:14px 18px;display:flex;align-items:center;gap:14px;border-left:5px solid {{ $s->activo ? 'var(--blue)' : '#d1d5db' }};">

    {{-- ICONO --}}
    <div style="width:44px;height:44px;border-radius:12px;background:#f0f4ff;display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0;">
      {{ $s->icono }}
    </div>

    {{-- INFO --}}
    <div style="flex:1;min-width:0;">
      <div style="font-size:14px;font-weight:800;color:var(--dark);">{{ $s->nombre }}</div>
      <div style="font-size:12px;color:var(--gray);font-weight:700;margin-top:2px;">
        {{ $s->precio_texto }} · Base: S/. {{ number_format($s->precio_base, 2) }} · Orden: {{ $s->orden }}
      </div>
    </div>

    {{-- ESTADO --}}
    <div style="flex-shrink:0;">
      <span style="font-size:10px;font-weight:800;letter-spacing:1px;text-transform:uppercase;padding:4px 12px;border-radius:20px;
        {{ $s->activo ? 'background:#dcfce7;color:var(--green2);' : 'background:#f3f4f6;color:#6b7280;' }}">
        {{ $s->activo ? 'Activo' : 'Inactivo' }}
      </span>
    </div>

    {{-- ACCIONES --}}
    <div style="display:flex;gap:6px;flex-shrink:0;">
      <a href="{{ route('admin.servicios.edit', $s) }}"
        style="padding:7px 14px;border-radius:8px;border:2px solid var(--blue);color:var(--blue);font-size:11px;font-weight:800;text-decoration:none;">
        ✏️ Editar
      </a>
      <form method="POST" action="{{ route('admin.servicios.destroy', $s) }}"
        onsubmit="return confirm('¿Eliminar el servicio {{ $s->nombre }}?')">
        @csrf @method('DELETE')
        <button type="submit" style="padding:7px 14px;border-radius:8px;border:2px solid var(--red);color:var(--red);font-size:11px;font-weight:800;background:#fff;cursor:pointer;">
          🗑 Eliminar
        </button>
      </form>
    </div>
  </div>
  @empty
  <div style="text-align:center;padding:48px 20px;color:var(--gray);">
    <div style="font-size:48px;margin-bottom:12px;">📭</div>
    <p style="font-size:14px;font-weight:700;">No hay servicios. Crea el primero.</p>
  </div>
  @endforelse

</div>
@endsection
