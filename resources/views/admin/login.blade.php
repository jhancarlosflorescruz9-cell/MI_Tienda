{{-- admin/login.blade.php --}}
@extends('layouts.app')
@section('title','Admin — Iniciar sesión')
@section('content')
<div style="max-width:380px;margin:60px auto;padding:0 20px;">
  <div style="background:#fff;border-radius:16px;box-shadow:0 4px 30px rgba(0,0,0,.1);padding:32px 28px;text-align:center;">
    <div style="font-size:48px;margin-bottom:12px;">🔐</div>
    <h2 style="font-family:'Bebas Neue',sans-serif;font-size:28px;letter-spacing:2px;color:var(--blue);margin-bottom:6px;">PANEL ADMIN</h2>
    <p style="font-size:13px;color:var(--gray);font-weight:700;margin-bottom:24px;">Acceso exclusivo para el administrador</p>

    @if($errors->has('credenciales'))
      <div style="background:#fee2e2;border:2px solid #fca5a5;border-radius:8px;padding:10px;font-size:12px;font-weight:800;color:var(--red);margin-bottom:14px;">❌ {{ $errors->first('credenciales') }}</div>
    @endif
    @if($errors->has('sesion'))
      <div style="background:#fef9c3;border:2px solid #fde68a;border-radius:8px;padding:10px;font-size:12px;font-weight:800;color:#854d0e;margin-bottom:14px;">⚠️ {{ $errors->first('sesion') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
      @csrf
      <div style="text-align:left;margin-bottom:12px;">
        <label style="display:block;font-size:10px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:var(--gray);margin-bottom:5px;">Usuario</label>
        <input type="text" name="usuario" value="{{ old('usuario') }}" autocomplete="username" placeholder="admin"
          style="width:100%;background:#f9fafb;border:2px solid var(--border);border-radius:10px;padding:12px 14px;font-family:'Nunito',sans-serif;font-size:14px;font-weight:700;color:var(--dark);outline:none;">
      </div>
      <div style="text-align:left;margin-bottom:6px;">
        <label style="display:block;font-size:10px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:var(--gray);margin-bottom:5px;">Contraseña</label>
        <input type="password" name="password" autocomplete="current-password" placeholder="••••••••"
          style="width:100%;background:#f9fafb;border:2px solid var(--border);border-radius:10px;padding:12px 14px;font-family:'Nunito',sans-serif;font-size:14px;font-weight:700;color:var(--dark);outline:none;">
      </div>
      <button type="submit" style="width:100%;background:var(--blue);border:none;color:#fff;padding:14px;border-radius:10px;font-family:'Bebas Neue',sans-serif;font-size:20px;letter-spacing:2px;cursor:pointer;box-shadow:0 4px 0 var(--blue2);margin-top:14px;">
        INGRESAR →
      </button>
    </form>
  </div>
</div>
@endsection
