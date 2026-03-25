@extends('layouts.app')
@section('title', $servicio->id ? 'Editar Servicio' : 'Nuevo Servicio')
@section('nav-extra')
  <a class="nav-btn-ghost" href="{{ route('admin.servicios.index') }}">← Servicios</a>
  <form method="POST" action="{{ route('admin.logout') }}" style="margin:0;">
    @csrf <button type="submit" class="nav-btn-ghost" style="cursor:pointer;">Salir 🔓</button>
  </form>
@endsection
@section('content')
<div style="max-width:520px;margin:24px auto;padding:0 16px 60px;">

  <h1 style="font-family:'Bebas Neue',sans-serif;font-size:26px;letter-spacing:2px;color:var(--blue);margin-bottom:4px;">
    {{ $servicio->id ? 'EDITAR SERVICIO' : 'NUEVO SERVICIO' }}
  </h1>
  <p style="font-size:13px;color:var(--gray);font-weight:700;margin-bottom:20px;">
    {{ $servicio->id ? 'Modifica los datos del servicio.' : 'Agrega un nuevo servicio para tus clientes.' }}
  </p>

  <div style="background:#fff;border-radius:16px;box-shadow:0 2px 0 #e5e7eb,0 4px 20px rgba(0,0,0,.07);padding:24px;">

    <form method="POST"
      action="{{ $servicio->id ? route('admin.servicios.update', $servicio) : route('admin.servicios.store') }}">
      @csrf
      @if($servicio->id) @method('PUT') @endif

      {{-- PREVIEW EN TIEMPO REAL --}}
      <div style="background:#f7f9ff;border:2px solid #e8f0ff;border-radius:12px;padding:14px;margin-bottom:20px;display:flex;align-items:center;gap:12px;">
        <div id="previewIco" style="width:44px;height:44px;border-radius:12px;background:#e8f0ff;display:flex;align-items:center;justify-content:center;font-size:26px;flex-shrink:0;">
          {{ $servicio->icono ?: '📄' }}
        </div>
        <div>
          <div id="previewNombre" style="font-size:13px;font-weight:800;color:var(--dark);">{{ $servicio->nombre ?: 'Nombre del servicio' }}</div>
          <div id="previewPrecio" style="font-size:11px;color:var(--red);font-weight:700;margin-top:2px;">{{ $servicio->precio_texto ?: 'Precio' }}</div>
        </div>
      </div>

      {{-- NOMBRE --}}
      <div style="margin-bottom:14px;">
        <label style="display:block;font-size:10px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:var(--gray);margin-bottom:6px;">Nombre del servicio *</label>
        <input type="text" name="nombre" value="{{ old('nombre', $servicio->nombre) }}"
          placeholder="Ej: Copias en blanco y negro"
          oninput="document.getElementById('previewNombre').textContent=this.value||'Nombre del servicio'"
          style="width:100%;background:#f9fafb;border:2px solid #e5e7eb;border-radius:10px;padding:11px 14px;font-family:'Nunito',sans-serif;font-size:13px;font-weight:700;color:var(--dark);outline:none;">
        @error('nombre')<p style="color:var(--red);font-size:11px;font-weight:700;margin-top:4px;">{{ $message }}</p>@enderror
      </div>

      {{-- ICONO --}}
      <div style="margin-bottom:14px;">
        <label style="display:block;font-size:10px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:var(--gray);margin-bottom:6px;">Ícono (emoji) *</label>
        <input type="text" name="icono" value="{{ old('icono', $servicio->icono) }}"
          placeholder="Ej: 🖤 🌈 📄 ⌨️ 🎓 ✨"
          maxlength="10"
          oninput="document.getElementById('previewIco').textContent=this.value||'📄'"
          style="width:100%;background:#f9fafb;border:2px solid #e5e7eb;border-radius:10px;padding:11px 14px;font-family:'Nunito',sans-serif;font-size:20px;outline:none;">
        <p style="font-size:11px;color:var(--gray);font-weight:700;margin-top:4px;">Pega un emoji directamente. Ej: 🖨 📋 🖊</p>
        @error('icono')<p style="color:var(--red);font-size:11px;font-weight:700;margin-top:4px;">{{ $message }}</p>@enderror
      </div>

      {{-- PRECIOS --}}
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
        <div>
          <label style="display:block;font-size:10px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:var(--gray);margin-bottom:6px;">Precio base (S/.) *</label>
          <input type="number" name="precio_base" value="{{ old('precio_base', $servicio->precio_base) }}"
            placeholder="0.20" step="0.01" min="0"
            style="width:100%;background:#f9fafb;border:2px solid #e5e7eb;border-radius:10px;padding:11px 14px;font-family:'Nunito',sans-serif;font-size:13px;font-weight:700;color:var(--dark);outline:none;">
          <p style="font-size:11px;color:var(--gray);font-weight:700;margin-top:4px;">Precio por hoja/unidad</p>
          @error('precio_base')<p style="color:var(--red);font-size:11px;font-weight:700;margin-top:4px;">{{ $message }}</p>@enderror
        </div>
        <div>
          <label style="display:block;font-size:10px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:var(--gray);margin-bottom:6px;">Texto de precio *</label>
          <input type="text" name="precio_texto" value="{{ old('precio_texto', $servicio->precio_texto) }}"
            placeholder="Desde S/. 0.20 c/u"
            oninput="document.getElementById('previewPrecio').textContent=this.value||'Precio'"
            style="width:100%;background:#f9fafb;border:2px solid #e5e7eb;border-radius:10px;padding:11px 14px;font-family:'Nunito',sans-serif;font-size:13px;font-weight:700;color:var(--dark);outline:none;">
          <p style="font-size:11px;color:var(--gray);font-weight:700;margin-top:4px;">Texto visible para el cliente</p>
          @error('precio_texto')<p style="color:var(--red);font-size:11px;font-weight:700;margin-top:4px;">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- ORDEN --}}
      <div style="margin-bottom:14px;">
        <label style="display:block;font-size:10px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:var(--gray);margin-bottom:6px;">Orden de aparición</label>
        <input type="number" name="orden" value="{{ old('orden', $servicio->orden ?? 0) }}"
          min="0" placeholder="1"
          style="width:100%;background:#f9fafb;border:2px solid #e5e7eb;border-radius:10px;padding:11px 14px;font-family:'Nunito',sans-serif;font-size:13px;font-weight:700;color:var(--dark);outline:none;">
        <p style="font-size:11px;color:var(--gray);font-weight:700;margin-top:4px;">Número menor = aparece primero</p>
      </div>

      {{-- ACTIVO --}}
      <div style="display:flex;align-items:center;justify-content:space-between;background:#f9fafb;border-radius:10px;padding:12px 14px;margin-bottom:20px;">
        <div>
          <div style="font-size:13px;font-weight:800;color:var(--dark);">Servicio activo</div>
          <div style="font-size:11px;color:var(--gray);font-weight:700;margin-top:2px;">Si está inactivo no aparecerá en el formulario de pedidos</div>
        </div>
        <label style="position:relative;width:44px;height:26px;flex-shrink:0;">
          <input type="checkbox" name="activo" value="1" {{ old('activo', $servicio->activo ?? true) ? 'checked' : '' }}
            style="opacity:0;width:0;height:0;">
          <span id="togSpan" style="position:absolute;inset:0;background:#d1d5db;border-radius:13px;cursor:pointer;transition:.3s;"
            onclick="this.style.background=this.previousElementSibling.checked?'#d1d5db':'var(--blue)';this.previousElementSibling.checked=!this.previousElementSibling.checked;">
            <span style="position:absolute;width:20px;height:20px;border-radius:50%;background:#fff;top:3px;left:3px;transition:.3s;box-shadow:0 1px 4px rgba(0,0,0,.2);"></span>
          </span>
        </label>
      </div>

      {{-- BOTONES --}}
      <div style="display:flex;gap:10px;">
        <a href="{{ route('admin.servicios.index') }}"
          style="flex:1;display:block;text-align:center;background:#f3f4f6;color:var(--gray);text-decoration:none;padding:13px;border-radius:10px;font-family:'Bebas Neue',sans-serif;font-size:18px;letter-spacing:1px;">
          CANCELAR
        </a>
        <button type="submit"
          style="flex:2;background:var(--blue);border:none;color:#fff;padding:13px;border-radius:10px;font-family:'Bebas Neue',sans-serif;font-size:18px;letter-spacing:2px;cursor:pointer;box-shadow:0 4px 0 var(--blue2);">
          {{ $servicio->id ? 'GUARDAR CAMBIOS' : 'CREAR SERVICIO' }}
        </button>
      </div>

    </form>
  </div>
</div>
@endsection
