{{-- seguimiento/resultado.blade.php --}}
@extends('layouts.app')
@section('title','Estado del pedido {{ $pedido->codigo }}')
@section('content')
<div style="max-width:480px;margin:24px auto;padding:0 16px 60px;">
  <div style="background:#fff;border-radius:16px;box-shadow:0 2px 0 #e5e7eb,0 4px 20px rgba(0,0,0,.07);padding:24px;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
      <div>
        <div style="font-family:'Bebas Neue',sans-serif;font-size:22px;letter-spacing:3px;color:var(--blue);">{{ $pedido->codigo }}</div>
        <div style="font-size:13px;font-weight:800;color:var(--dark);">{{ $pedido->nombre }} · {{ $pedido->servicio }}</div>
        <div style="font-size:11px;color:var(--gray);font-weight:700;margin-top:2px;">{{ $pedido->created_at->format('d/m/Y H:i') }}</div>
      </div>
      <div style="font-size:10px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;padding:5px 12px;border-radius:20px;background:{{ $pedido->estadoBg() }};color:{{ $pedido->estadoColor() }};">
        {{ $pedido->estado }}
      </div>
    </div>

    {{-- Timeline --}}
    <div style="margin-top:16px;">
      @foreach($pasos as $i => $paso)
        @php
          $done    = $i < $indice;
          $current = $i === $indice;
        @endphp
        <div style="display:flex;align-items:flex-start;gap:12px;">
          <div style="display:flex;flex-direction:column;align-items:center;">
            <div style="width:18px;height:18px;border-radius:50%;border:2.5px solid {{ $done ? 'var(--blue)' : ($current ? 'var(--yellow)' : 'var(--border)') }};background:{{ $done ? 'var(--blue)' : ($current ? 'var(--yellow)' : '#fff') }};flex-shrink:0;"></div>
            @if($i < count($pasos) - 1)
              <div style="width:2px;height:28px;background:{{ $done ? 'var(--blue)' : 'var(--border)' }};"></div>
            @endif
          </div>
          <div style="padding-bottom:20px;">
            <div style="font-size:13px;font-weight:800;color:{{ ($done || $current) ? 'var(--dark)' : 'var(--gray)' }};">{{ $paso['icono'] }} {{ $paso['label'] }}</div>
            @if($current)
              <div style="font-size:11px;color:var(--gray);font-weight:700;margin-top:2px;">{{ $paso['desc'] }}</div>
            @endif
          </div>
        </div>
      @endforeach
    </div>

    <div style="border-top:2px solid #f3f4f6;padding-top:14px;margin-top:4px;display:flex;gap:10px;">
      <a href="{{ route('seguimiento.index') }}" style="flex:1;display:block;text-align:center;background:#f3f4f6;color:var(--gray);text-decoration:none;padding:11px;border-radius:10px;font-family:'Bebas Neue',sans-serif;font-size:16px;letter-spacing:1px;">← BUSCAR OTRO</a>
      <a href="{{ route('home') }}" style="flex:1;display:block;text-align:center;background:var(--blue);color:#fff;text-decoration:none;padding:11px;border-radius:10px;font-family:'Bebas Neue',sans-serif;font-size:16px;letter-spacing:1px;">NUEVO PEDIDO</a>
    </div>
  </div>
</div>
@endsection
