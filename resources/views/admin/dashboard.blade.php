@extends('layouts.app')
@section('title','Dashboard Admin')

@section('nav-extra')
  <a class="nav-btn-ghost" href="{{ route('admin.pedidos') }}">📋 Pedidos</a>
  <a class="nav-btn-ghost" href="{{ route('admin.exportar.csv') }}">📥 CSV</a>
  <form method="POST" action="{{ route('admin.logout') }}" style="margin:0;">
    @csrf
    <button type="submit" class="nav-btn-ghost" style="cursor:pointer;">Salir 🔓</button>
  </form>
@endsection

@push('styles')
<style>
.admin-wrap{max-width:900px;margin:0 auto;padding:16px 16px 40px;}

/* BIENVENIDA */
.welcome-bar{
  background:var(--blue);border-radius:16px;
  padding:20px 24px;margin-bottom:16px;
  display:flex;align-items:center;justify-content:space-between;
  position:relative;overflow:hidden;
}
.welcome-bar::before{
  content:'';position:absolute;inset:0;
  background:repeating-conic-gradient(rgba(255,208,0,.05) 0deg 10deg,transparent 10deg 20deg);
  animation:spin 40s linear infinite;transform-origin:center;
}
@keyframes spin{to{transform:rotate(360deg)}}
.welcome-txt{position:relative;z-index:1;}
.welcome-txt h2{font-family:'Bebas Neue',sans-serif;font-size:24px;letter-spacing:2px;color:#fff;margin-bottom:4px;}
.welcome-txt p{font-size:12px;color:rgba(255,255,255,.7);font-weight:700;}
.welcome-badge{
  position:relative;z-index:1;
  background:var(--yellow);color:var(--blue2);
  font-family:'Bebas Neue',sans-serif;font-size:14px;letter-spacing:1px;
  padding:8px 16px;border-radius:8px;box-shadow:0 3px 0 var(--yellow2);
  text-decoration:none;
}

/* STATS GRID */
.stats-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:16px;}
@media(min-width:600px){.stats-grid{grid-template-columns:repeat(4,1fr);}}
.stat-card{
  background:#fff;border-radius:14px;padding:16px;
  box-shadow:0 2px 0 var(--border),0 4px 16px rgba(0,0,0,.06);
  border-top:4px solid;
  position:relative;overflow:hidden;
}
.stat-card::after{
  content:'';position:absolute;right:-10px;bottom:-10px;
  width:60px;height:60px;border-radius:50%;
  background:currentColor;opacity:.05;
}
.stat-val{font-family:'Bebas Neue',sans-serif;font-size:36px;line-height:1;margin-bottom:4px;}
.stat-lbl{font-size:10px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:var(--gray);}
.stat-sub{font-size:11px;font-weight:700;color:var(--gray);margin-top:4px;}
.stat-icon{position:absolute;top:12px;right:14px;font-size:22px;opacity:.3;}

/* CHARTS */
.charts-grid{display:grid;grid-template-columns:1fr;gap:14px;margin-bottom:16px;}
@media(min-width:600px){.charts-grid{grid-template-columns:1fr 1fr;}}
.chart-card{background:#fff;border-radius:14px;padding:18px;box-shadow:0 2px 0 var(--border),0 4px 16px rgba(0,0,0,.06);}
.chart-title{font-family:'Bebas Neue',sans-serif;font-size:16px;letter-spacing:2px;color:var(--blue);margin-bottom:14px;display:flex;align-items:center;gap:8px;}
.chart-title::before{content:'';width:4px;height:18px;border-radius:2px;background:linear-gradient(var(--red),var(--yellow));display:block;}

/* BARRAS */
.bar-row{display:flex;align-items:center;gap:8px;margin-bottom:10px;}
.bar-lbl{font-size:11px;font-weight:800;color:var(--dark);width:120px;flex-shrink:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.bar-track{flex:1;height:14px;background:#f3f4f6;border-radius:7px;overflow:hidden;}
.bar-fill{height:100%;border-radius:7px;transition:width .8s cubic-bezier(.34,1.4,.64,1);}
.bar-val{font-size:11px;font-weight:800;color:var(--gray);width:36px;text-align:right;flex-shrink:0;}

/* ESTADO DONUTS */
.estado-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:8px;}
.estado-item{
  display:flex;align-items:center;gap:8px;
  background:#f9fafb;border-radius:10px;padding:10px 12px;
}
.estado-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;}
.estado-name{font-size:12px;font-weight:800;color:var(--dark);flex:1;}
.estado-count{font-family:'Bebas Neue',sans-serif;font-size:20px;line-height:1;}

/* ÚLTIMOS PEDIDOS */
.pedidos-recientes{background:#fff;border-radius:14px;padding:18px;box-shadow:0 2px 0 var(--border),0 4px 16px rgba(0,0,0,.06);margin-bottom:16px;}
.pr-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;}
.pr-title{font-family:'Bebas Neue',sans-serif;font-size:16px;letter-spacing:2px;color:var(--blue);display:flex;align-items:center;gap:8px;}
.pr-title::before{content:'';width:4px;height:18px;border-radius:2px;background:linear-gradient(var(--red),var(--yellow));display:block;}
.pr-ver-todos{font-size:12px;font-weight:800;color:var(--blue);text-decoration:none;}
.pedido-row{
  display:flex;align-items:center;justify-content:space-between;
  padding:10px 0;border-bottom:1px solid #f3f4f6;gap:10px;
}
.pedido-row:last-child{border:none;}
.pr-left{flex:1;min-width:0;}
.pr-codigo{font-family:'Bebas Neue',sans-serif;font-size:14px;letter-spacing:2px;color:var(--blue);}
.pr-nombre{font-size:12px;font-weight:800;color:var(--dark);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.pr-meta{font-size:10px;color:var(--gray);font-weight:700;margin-top:2px;}
.pr-right{text-align:right;flex-shrink:0;}
.pr-total{font-family:'Bebas Neue',sans-serif;font-size:18px;color:var(--blue);}
.status-badge{font-size:9px;font-weight:800;letter-spacing:1px;text-transform:uppercase;padding:2px 8px;border-radius:20px;}
.status-badge.pendiente{background:#fef9c3;color:#854d0e;}
.status-badge.proceso{background:#dbeafe;color:#1e40af;}
.status-badge.listo{background:#dcfce7;color:var(--green2);}
.status-badge.entregado{background:#f3f4f6;color:#374151;}
.status-badge.cancelado{background:#fee2e2;color:var(--red2);}

/* ACCIONES RÁPIDAS */
.acciones{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:16px;}
@media(min-width:500px){.acciones{grid-template-columns:repeat(4,1fr);}}
.accion-btn{
  display:flex;flex-direction:column;align-items:center;gap:6px;
  background:#fff;border-radius:12px;padding:16px 10px;
  text-decoration:none;border:1.5px solid var(--border);
  transition:all .2s;cursor:pointer;
}
.accion-btn:hover{border-color:var(--blue);transform:translateY(-2px);box-shadow:0 4px 14px rgba(0,63,163,.1);}
.accion-ico{font-size:24px;}
.accion-lbl{font-size:11px;font-weight:800;color:var(--dark);text-align:center;letter-spacing:.5px;}

/* INGRESOS POR DÍA */
.dias-chart{display:flex;align-items:flex-end;gap:6px;height:80px;margin-top:8px;}
.dia-bar{flex:1;border-radius:4px 4px 0 0;min-width:0;transition:height .6s cubic-bezier(.34,1.4,.64,1);cursor:default;position:relative;}
.dia-bar:hover::after{content:attr(data-tip);position:absolute;bottom:calc(100% + 4px);left:50%;transform:translateX(-50%);background:var(--dark);color:#fff;font-size:10px;font-weight:800;padding:3px 8px;border-radius:4px;white-space:nowrap;z-index:10;}
.dia-lbl{font-size:9px;font-weight:800;color:var(--gray);text-align:center;margin-top:4px;}
</style>
@endpush

@section('content')
<div class="admin-wrap">

  {{-- BIENVENIDA --}}
  <div class="welcome-bar">
    <div class="welcome-txt">
      <h2>👋 Panel de Administración</h2>
      <p>{{ now()->format('l, d \d\e F \d\e Y') }} · Copias & Tipeos</p>
    </div>
    <a href="{{ route('admin.pedidos') }}" class="welcome-badge">Ver pedidos →</a>
  </div>

  {{-- ESTADÍSTICAS --}}
  <div class="stats-grid">
    @php
      $statItems = [
        ['val'=>$stats['total'],      'lbl'=>'Total pedidos',    'sub'=>'Hoy: '.$stats['hoy'],                    'color'=>'var(--blue)',  'icon'=>'📋'],
        ['val'=>$stats['pendientes'], 'lbl'=>'Pendientes',       'sub'=>'Requieren atención',                      'color'=>'#f59e0b',      'icon'=>'⏳'],
        ['val'=>'S/.'.number_format($stats['ingresos'],0),   'lbl'=>'Ingresos totales', 'sub'=>'Mes: S/.'.number_format($stats['ingresos_mes'],0), 'color'=>'var(--green)', 'icon'=>'💰'],
        ['val'=>$stats['entregados'], 'lbl'=>'Completados',      'sub'=>($stats['total']>0?round($stats['entregados']/$stats['total']*100).'%':'-').' de éxito', 'color'=>'var(--red)', 'icon'=>'✅'],
      ];
    @endphp
    @foreach($statItems as $s)
    <div class="stat-card" style="border-top-color:{{ $s['color'] }};">
      <div class="stat-icon">{{ $s['icon'] }}</div>
      <div class="stat-val" style="color:{{ $s['color'] }};">{{ $s['val'] }}</div>
      <div class="stat-lbl">{{ $s['lbl'] }}</div>
      <div class="stat-sub">{{ $s['sub'] }}</div>
    </div>
    @endforeach
  </div>

  {{-- ACCIONES RÁPIDAS --}}
  <div class="acciones">
    <a href="{{ route('admin.pedidos', ['estado'=>'pendiente']) }}" class="accion-btn">
      <span class="accion-ico">🟡</span>
      <span class="accion-lbl">Ver pendientes ({{ $stats['pendientes'] }})</span>
    </a>
    <a href="{{ route('admin.exportar.csv') }}" class="accion-btn">
      <span class="accion-ico">📥</span>
      <span class="accion-lbl">Exportar CSV</span>
    </a>
    <a href="{{ route('admin.servicios.index') }}" class="accion-btn">
      <span class="accion-ico">⚙️</span>
      <span class="accion-lbl">Gestionar servicios</span>
    </a>
    <a href="{{ route('home') }}" target="_blank" class="accion-btn">
      <span class="accion-ico">👁</span>
      <span class="accion-lbl">Ver web del cliente</span>
    </a>
  </div>

  {{-- GRÁFICAS --}}
  <div class="charts-grid">

    {{-- Servicios más pedidos --}}
    <div class="chart-card">
      <div class="chart-title">Servicios más pedidos</div>
      @php $maxSvc = $porServicio->max('total') ?: 1; $colores = ['var(--blue)','var(--red)','var(--yellow)','var(--green)','#9333ea','#0891b2']; @endphp
      @forelse($porServicio as $i => $svc)
      <div class="bar-row">
        <div class="bar-lbl" title="{{ $svc->servicio }}">{{ $svc->servicio }}</div>
        <div class="bar-track">
          <div class="bar-fill" style="width:{{ round($svc->total/$maxSvc*100) }}%;background:{{ $colores[$i % count($colores)] }}"></div>
        </div>
        <div class="bar-val">{{ $svc->total }}</div>
      </div>
      @empty
      <p style="font-size:13px;color:var(--gray);font-weight:700;">Sin datos aún.</p>
      @endforelse
    </div>

    {{-- Estado de pedidos --}}
    <div class="chart-card">
      <div class="chart-title">Estado de pedidos</div>
      <div class="estado-grid">
        @php
          $estados = [
            ['key'=>'pendiente', 'lbl'=>'Pendientes', 'color'=>'#f59e0b', 'bg'=>'#fef9c3'],
            ['key'=>'proceso',   'lbl'=>'En proceso',  'color'=>'var(--blue)', 'bg'=>'#dbeafe'],
            ['key'=>'listo',     'lbl'=>'Listos',       'color'=>'var(--green)', 'bg'=>'#dcfce7'],
            ['key'=>'entregado', 'lbl'=>'Entregados',   'color'=>'#374151', 'bg'=>'#f3f4f6'],
            ['key'=>'cancelado', 'lbl'=>'Cancelados',   'color'=>'var(--red)', 'bg'=>'#fee2e2'],
          ];
        @endphp
        @foreach($estados as $e)
        @php $cnt = \App\Models\Pedido::where('estado',$e['key'])->count(); @endphp
        <div class="estado-item" style="background:{{ $e['bg'] }};">
          <div class="estado-dot" style="background:{{ $e['color'] }};"></div>
          <div class="estado-name">{{ $e['lbl'] }}</div>
          <div class="estado-count" style="color:{{ $e['color'] }};">{{ $cnt }}</div>
        </div>
        @endforeach
      </div>
    </div>

  </div>

  {{-- INGRESOS POR DÍA --}}
  <div class="chart-card" style="margin-bottom:16px;">
    <div class="chart-title">Ingresos últimos 7 días</div>
    @php
      $dias = [];
      for($i=6;$i>=0;$i--){
        $fecha = now()->subDays($i);
        $ingreso = \App\Models\Pedido::whereDate('created_at',$fecha)->sum('total');
        $dias[] = ['lbl'=>$fecha->format('D'),'val'=>$ingreso];
      }
      $maxDia = max(array_column($dias,'val')) ?: 1;
    @endphp
    <div style="display:flex;align-items:flex-end;gap:6px;height:90px;">
      @foreach($dias as $dia)
      @php $h = max(4, round($dia['val']/$maxDia*80)); @endphp
      <div style="flex:1;display:flex;flex-direction:column;align-items:center;">
        <div style="width:100%;height:{{ $h }}px;background:var(--blue);border-radius:4px 4px 0 0;position:relative;cursor:default;"
          title="S/. {{ number_format($dia['val'],2) }}">
          @if($dia['val'] > 0)
          <span style="position:absolute;bottom:calc(100% + 2px);left:50%;transform:translateX(-50%);font-size:9px;font-weight:800;color:var(--blue);white-space:nowrap;">
            S/.{{ number_format($dia['val'],0) }}
          </span>
          @endif
        </div>
        <div style="font-size:9px;font-weight:800;color:var(--gray);margin-top:4px;text-transform:uppercase;">{{ $dia['lbl'] }}</div>
      </div>
      @endforeach
    </div>
  </div>

  {{-- ÚLTIMOS PEDIDOS --}}
  <div class="pedidos-recientes">
    <div class="pr-header">
      <div class="pr-title">Últimos pedidos</div>
      <a href="{{ route('admin.pedidos') }}" class="pr-ver-todos">Ver todos →</a>
    </div>
    @forelse($recientes as $p)
    <div class="pedido-row">
      <div class="pr-left">
        <div style="display:flex;align-items:center;gap:6px;margin-bottom:2px;">
          <span class="pr-codigo">{{ $p->codigo }}</span>
          <span class="status-badge {{ $p->estado }}">{{ $p->estado }}</span>
        </div>
        <div class="pr-nombre">{{ $p->nombre }}</div>
        <div class="pr-meta">{{ $p->created_at->diffForHumans() }} · {{ $p->servicio }}</div>
      </div>
      <div class="pr-right">
        <div class="pr-total">S/.{{ number_format($p->total,2) }}</div>
        <a href="https://wa.me/51{{ preg_replace('/\D/','',$p->telefono) }}" target="_blank"
          style="font-size:10px;color:#25d366;font-weight:800;text-decoration:none;">💬 {{ $p->telefono }}</a>
      </div>
    </div>
    @empty
    <p style="font-size:13px;color:var(--gray);font-weight:700;text-align:center;padding:20px 0;">Sin pedidos aún.</p>
    @endforelse
  </div>

</div>
@endsection