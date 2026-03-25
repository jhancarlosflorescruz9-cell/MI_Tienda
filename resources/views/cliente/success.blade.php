{{-- ══════════════════════════════════════
    resources/views/cliente/success.blade.php
══════════════════════════════════════ --}}
@extends('layouts.app')
@section('title','Pedido enviado — Copias & Tipeos')
@section('content')
<div style="max-width:500px;margin:30px auto;padding:0 16px 60px;">
  <div style="background:#fff;border-radius:16px;box-shadow:0 2px 0 #e5e7eb,0 4px 20px rgba(0,0,0,.07);padding:32px;text-align:center;">
    <div style="width:90px;height:90px;border-radius:50%;margin:0 auto 20px;background:var(--blue);display:flex;align-items:center;justify-content:center;font-size:42px;box-shadow:0 0 0 8px rgba(0,63,163,.15),0 0 0 16px rgba(0,63,163,.07);">✓</div>
    <h2 style="font-family:'Bebas Neue',sans-serif;font-size:36px;letter-spacing:2px;color:var(--blue);margin-bottom:8px;">¡PEDIDO ENVIADO!</h2>
    <p style="color:var(--gray);font-size:14px;font-weight:700;line-height:1.6;margin-bottom:16px;">Tu pedido fue registrado correctamente.<br>Te confirmaremos por WhatsApp en breve.</p>
    <div style="display:inline-block;background:var(--yellow);color:var(--blue2);font-family:'Bebas Neue',sans-serif;font-size:30px;letter-spacing:5px;padding:12px 28px;border-radius:10px;box-shadow:0 4px 0 var(--yellow2);margin-bottom:16px;">{{ $pedido->codigo }}</div>
    <p style="font-size:12px;color:var(--gray);font-weight:700;margin-bottom:20px;">Guarda este código para rastrear tu pedido.</p>

    {{-- Resumen rápido --}}
    <div style="background:#f9fafb;border-radius:12px;padding:14px;text-align:left;margin-bottom:20px;">
      <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #f3f4f6;font-size:12px;"><span style="color:var(--gray);font-weight:700;">Servicio</span><span style="font-weight:800;">{{ $pedido->servicio }}</span></div>
      <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #f3f4f6;font-size:12px;"><span style="color:var(--gray);font-weight:700;">Hojas</span><span style="font-weight:800;">{{ $pedido->cantidad }} × {{ $pedido->tamano }}</span></div>
      <div style="display:flex;justify-content:space-between;padding:6px 0;font-size:12px;"><span style="color:var(--gray);font-weight:700;">Total estimado</span><span style="font-weight:800;color:var(--blue);">S/. {{ number_format($pedido->total, 2) }}</span></div>
    </div>

    {{-- Botón WhatsApp --}}
    @php
      $extras = '';
      if($pedido->anillado)   $extras .= '\n✅ Con anillado (+S/.3.00)';
      if($pedido->tapa)       $extras .= '\n✅ Con tapa plástica (+S/.1.50)';
      if($pedido->doble_cara) $extras .= '\n✅ Doble cara (+S/.0.10 x hoja)';
      $msg = "🖨️ *NUEVO PEDIDO {$pedido->codigo}*\n\n📋 *Servicio:* {$pedido->servicio}\n📄 *Hojas:* {$pedido->cantidad} — Tamaño: {$pedido->tamano}\n📦 *Entrega:* {$pedido->entrega}{$extras}\n👤 *Cliente:* {$pedido->nombre}\n📞 *WhatsApp:* {$pedido->telefono}\n💬 *Notas:* ".($pedido->notas ?: 'Ninguna')."\n💰 *Total estimado:* S/. ".number_format($pedido->total,2)."\n\n⚡ Por favor confirme disponibilidad. ¡Gracias!";
    @endphp
    <a href="https://wa.me/51929286603?text={{ urlencode($msg) }}" target="_blank"
      style="display:block;background:#25d366;color:#fff;text-decoration:none;padding:14px;border-radius:10px;font-family:'Bebas Neue',sans-serif;font-size:18px;letter-spacing:1.5px;box-shadow:0 4px 0 #128c5e;margin-bottom:10px;">
      💬 CONFIRMAR POR WHATSAPP
    </a>
    <a href="{{ route('seguimiento.buscar', $pedido->codigo) }}"
      style="display:block;background:var(--blue);color:#fff;text-decoration:none;padding:12px;border-radius:10px;font-family:'Bebas Neue',sans-serif;font-size:16px;letter-spacing:1.5px;box-shadow:0 3px 0 var(--blue2);margin-bottom:10px;">
      📦 VER ESTADO DEL PEDIDO
    </a>
    <a href="{{ route('home') }}" style="display:block;text-align:center;color:var(--blue);font-size:13px;font-weight:800;margin-top:10px;">← Hacer otro pedido</a>
  </div>
</div>
@endsection
