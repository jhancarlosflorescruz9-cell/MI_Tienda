@extends('layouts.app')
@section('title','Gestión de Pedidos')

@section('nav-extra')
  <a class="nav-btn-ghost" href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
  <a class="nav-btn-ghost" href="{{ route('admin.exportar.csv') }}">📥 CSV</a>
  <form method="POST" action="{{ route('admin.logout') }}" style="margin:0;">
    @csrf <button type="submit" class="nav-btn-ghost" style="cursor:pointer;">Salir 🔓</button>
  </form>
@endsection

@push('styles')
<style>
.admin-wrap{max-width:900px;margin:0 auto;padding:16px 16px 40px;}

/* BÚSQUEDA MEJORADA */
.search-section{background:#fff;border-radius:14px;padding:16px;box-shadow:0 2px 0 var(--border),0 4px 16px rgba(0,0,0,.06);margin-bottom:14px;}
.search-top{display:flex;gap:10px;align-items:center;margin-bottom:12px;flex-wrap:wrap;}
.search-input-wrap{flex:1;min-width:200px;position:relative;}
.search-input-wrap input{
  width:100%;padding:11px 14px 11px 40px;
  background:#f9fafb;border:2px solid var(--border);border-radius:10px;
  font-family:'Nunito',sans-serif;font-size:14px;font-weight:700;
  color:var(--dark);outline:none;transition:border-color .2s;
}
.search-input-wrap input:focus{border-color:var(--blue);}
.search-input-wrap .search-ico{position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:16px;}
.btn-search{background:var(--blue);border:none;color:#fff;padding:11px 20px;border-radius:10px;font-family:'Bebas Neue',sans-serif;font-size:18px;letter-spacing:1px;cursor:pointer;box-shadow:0 3px 0 var(--blue2);white-space:nowrap;}
.btn-clear{background:#f3f4f6;border:2px solid var(--border);color:var(--gray);padding:11px 16px;border-radius:10px;font-size:12px;font-weight:800;cursor:pointer;white-space:nowrap;text-decoration:none;display:inline-flex;align-items:center;}

/* FILTROS */
.filtros-wrap{display:flex;gap:6px;flex-wrap:wrap;}
.filter-btn{
  padding:6px 14px;border-radius:20px;border:2px solid var(--border);
  background:#fff;font-size:11px;font-weight:800;color:var(--gray);
  cursor:pointer;transition:all .2s;white-space:nowrap;text-decoration:none;
  display:inline-flex;align-items:center;gap:4px;
}
.filter-btn.active{background:var(--blue);border-color:var(--blue);color:#fff;}
.filter-btn:hover:not(.active){border-color:var(--blue);color:var(--blue);}
.filter-count{font-size:10px;opacity:.8;}

/* RESULTADO BÚSQUEDA */
.search-result-bar{
  background:#e8eeff;border-radius:8px;padding:8px 14px;
  font-size:12px;font-weight:800;color:var(--blue);
  margin-bottom:10px;display:flex;align-items:center;gap:8px;
}

/* PEDIDOS */
.pedido-card{
  background:#fff;border-radius:14px;
  box-shadow:0 2px 0 var(--border),0 4px 16px rgba(0,0,0,.05);
  margin-bottom:10px;overflow:hidden;border-left:5px solid;
  transition:box-shadow .2s;
}
.pedido-card:hover{box-shadow:0 4px 0 var(--border),0 8px 24px rgba(0,0,0,.1);}
.pedido-card.pendiente{border-left-color:#f59e0b;}
.pedido-card.proceso{border-left-color:var(--blue);}
.pedido-card.listo{border-left-color:var(--green);}
.pedido-card.entregado{border-left-color:#9ca3af;}
.pedido-card.cancelado{border-left-color:var(--red);}

.pedido-head{
  display:flex;align-items:center;justify-content:space-between;
  padding:12px 16px;cursor:pointer;gap:10px;
}
.pedido-head:hover{background:#f9fafb;}
.ph-left{flex:1;min-width:0;}
.ph-top{display:flex;align-items:center;gap:6px;flex-wrap:wrap;margin-bottom:3px;}
.pedido-code{font-family:'Bebas Neue',sans-serif;font-size:16px;letter-spacing:2px;color:var(--blue);}
.status-pill{font-size:9px;font-weight:800;letter-spacing:1px;text-transform:uppercase;padding:3px 9px;border-radius:20px;}
.status-pill.pendiente{background:#fef9c3;color:#854d0e;}
.status-pill.proceso{background:#dbeafe;color:#1e40af;}
.status-pill.listo{background:#dcfce7;color:var(--green2);}
.status-pill.entregado{background:#f3f4f6;color:#374151;}
.status-pill.cancelado{background:#fee2e2;color:var(--red2);}
.nuevo-badge{background:#fee2e2;color:var(--red);font-size:9px;font-weight:800;padding:2px 8px;border-radius:20px;}
.pedido-nombre{font-size:13px;font-weight:800;color:var(--dark);}
.pedido-meta{font-size:11px;color:var(--gray);font-weight:700;margin-top:2px;}
.ph-right{text-align:right;flex-shrink:0;}
.pedido-total{font-family:'Bebas Neue',sans-serif;font-size:22px;color:var(--blue);}
.pedido-svc{font-size:10px;color:var(--gray);font-weight:700;}
.ph-arrow{font-size:14px;color:var(--gray);margin-left:6px;transition:transform .2s;flex-shrink:0;}
.ph-arrow.open{transform:rotate(180deg);}

.pedido-body{display:none;padding:0 16px 16px;border-top:1.5px solid #f3f4f6;}
.pedido-body.open{display:block;animation:fadeIn .2s ease;}
@keyframes fadeIn{from{opacity:0;transform:translateY(-4px)}to{opacity:1;transform:translateY(0)}}

.detail-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:8px;margin:12px 0;}
@media(min-width:500px){.detail-grid{grid-template-columns:repeat(3,1fr);}}
.d-item{background:#f9fafb;border-radius:8px;padding:8px 10px;}
.d-k{font-size:9px;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;color:var(--gray);}
.d-v{font-size:12px;font-weight:800;color:var(--dark);margin-top:2px;}
.notas-box{background:#fff3cd;border:1.5px solid #fde68a;border-radius:8px;padding:10px;font-size:12px;font-weight:700;color:#7a5000;margin-bottom:12px;}

.actions-row{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:8px;}
.btn-estado{padding:7px 12px;border-radius:8px;border:2px solid;font-size:11px;font-weight:800;cursor:pointer;background:#fff;transition:all .2s;white-space:nowrap;}
.btn-estado:hover{opacity:.8;transform:translateY(-1px);}
.btn-estado.current{opacity:.35;pointer-events:none;}
.s-pendiente{border-color:#f59e0b;color:#854d0e;}
.s-proceso{border-color:var(--blue);color:var(--blue);}
.s-listo{border-color:var(--green);color:var(--green);}
.s-entregado{border-color:#9ca3af;color:#374151;}
.s-cancelado{border-color:var(--red);color:var(--red);}

.btn-wa-notif{
  padding:7px 12px;border-radius:8px;border:2px solid #25d366;
  color:#25d366;font-size:11px;font-weight:800;cursor:pointer;background:#fff;
  text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:all .2s;
}
.btn-wa-notif:hover{background:#25d366;color:#fff;}
.btn-eliminar{
  padding:7px 12px;border-radius:8px;border:2px solid var(--red);
  color:var(--red);font-size:11px;font-weight:800;cursor:pointer;background:#fff;transition:all .2s;
}
.btn-eliminar:hover{background:var(--red);color:#fff;}

.empty-state{text-align:center;padding:48px 20px;}
.empty-icon{font-size:52px;margin-bottom:12px;}

/* PAGINACIÓN */
.pagination-wrap{margin-top:16px;}
</style>
@endpush

@section('content')
<div class="admin-wrap">

  {{-- BÚSQUEDA --}}
  <div class="search-section">
    <form method="GET" action="{{ route('admin.pedidos') }}" id="searchForm">
      @if(request('estado'))<input type="hidden" name="estado" value="{{ request('estado') }}">@endif

      <div class="search-top">
        <div class="search-input-wrap">
          <span class="search-ico">🔍</span>
          <input type="text" name="q" id="searchInput" value="{{ request('q') }}"
            placeholder="Buscar por nombre, código, teléfono o servicio..."
            autocomplete="off">
        </div>
        <button type="submit" class="btn-search">BUSCAR</button>
        @if(request('q'))
          <a href="{{ route('admin.pedidos', request()->except('q','page')) }}" class="btn-clear">✕ Limpiar</a>
        @endif
      </div>

      {{-- FILTROS POR ESTADO --}}
      <div class="filtros-wrap">
        @php
          $estados = [
            'todos'     => ['lbl'=>'Todos',       'ico'=>'📋'],
            'pendiente' => ['lbl'=>'Pendientes',  'ico'=>'🟡'],
            'proceso'   => ['lbl'=>'En proceso',  'ico'=>'🔵'],
            'listo'     => ['lbl'=>'Listos',       'ico'=>'🟢'],
            'entregado' => ['lbl'=>'Entregados',   'ico'=>'⚪'],
            'cancelado' => ['lbl'=>'Cancelados',   'ico'=>'🔴'],
          ];
          $estadoActual = request('estado','todos');
        @endphp
        @foreach($estados as $key => $info)
          <a href="{{ route('admin.pedidos', array_merge(request()->except('page'), ['estado'=>$key])) }}"
            class="filter-btn {{ $estadoActual===$key?'active':'' }}">
            {{ $info['ico'] }} {{ $info['lbl'] }}
            <span class="filter-count">({{ $conteos[$key] }})</span>
          </a>
        @endforeach
      </div>
    </form>
  </div>

  {{-- RESULTADO BÚSQUEDA --}}
  @if(request('q'))
  <div class="search-result-bar">
    🔍 {{ $pedidos->total() }} resultado(s) para "<strong>{{ request('q') }}</strong>"
  </div>
  @endif

  {{-- LISTA DE PEDIDOS --}}
  @forelse($pedidos as $p)
  <div class="pedido-card {{ $p->estado }}" id="card-{{ $p->id }}">

    <div class="pedido-head" onclick="toggleCard({{ $p->id }})">
      <div class="ph-left">
        <div class="ph-top">
          <span class="pedido-code">{{ $p->codigo }}</span>
          <span class="status-pill {{ $p->estado }}">{{ $p->estado }}</span>
          @if($p->created_at->diffInMinutes(now()) < 10)
            <span class="nuevo-badge">🆕 NUEVO</span>
          @endif
        </div>
        <div class="pedido-nombre">{{ $p->nombre }}</div>
        <div class="pedido-meta">
          📅 {{ $p->created_at->format('d/m/Y H:i') }} ·
          📞 {{ $p->telefono }} ·
          {{ $p->created_at->diffForHumans() }}
        </div>
      </div>
      <div class="ph-right">
        <div class="pedido-total">S/.{{ number_format($p->total,2) }}</div>
        <div class="pedido-svc">{{ Str::limit($p->servicio, 20) }}</div>
      </div>
      <div class="ph-arrow" id="arr-{{ $p->id }}">▾</div>
    </div>

    <div class="pedido-body" id="body-{{ $p->id }}">
      <div class="detail-grid">
        <div class="d-item"><div class="d-k">Servicio</div><div class="d-v">{{ $p->servicio }}</div></div>
        <div class="d-item"><div class="d-k">Hojas</div><div class="d-v">{{ $p->cantidad }} × {{ $p->tamano }}</div></div>
        <div class="d-item"><div class="d-k">Entrega</div><div class="d-v">{{ $p->entrega }}</div></div>
        <div class="d-item"><div class="d-k">WhatsApp</div><div class="d-v">{{ $p->telefono }}</div></div>
        <div class="d-item"><div class="d-k">Extras</div><div class="d-v">{{ $p->extrasTexto() }}</div></div>
        <div class="d-item"><div class="d-k">Total</div><div class="d-v" style="color:var(--blue)">S/. {{ number_format($p->total,2) }}</div></div>
      </div>

      @if($p->notas)
      <div class="notas-box">📝 {{ $p->notas }}</div>
      @endif
      @if($p->archivo_nombre)
      <div style="background:#e8f0ff;border-radius:8px;padding:8px 12px;font-size:12px;font-weight:700;color:var(--blue);margin-bottom:10px;">
        📎 Archivo: {{ $p->archivo_nombre }}
      </div>
      @endif

      {{-- CAMBIAR ESTADO --}}
      <div class="actions-row">
        @foreach(['pendiente'=>'🟡','proceso'=>'🔵','listo'=>'🟢','entregado'=>'⚪','cancelado'=>'🔴'] as $est => $emoji)
        <form method="POST" action="{{ route('admin.pedidos.estado', $p->id) }}" style="margin:0;">
          @csrf @method('PATCH')
          <input type="hidden" name="estado" value="{{ $est }}">
          <button type="submit" class="btn-estado s-{{ $est }} {{ $p->estado===$est?'current':'' }}"
            onclick="return confirm('¿Cambiar a {{ $est }}?')">
            {{ $emoji }} {{ ucfirst($est) }}
          </button>
        </form>
        @endforeach
      </div>

      {{-- NOTIFICAR + ELIMINAR --}}
      <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
        @php
          $msgs = [
            'pendiente' => 'Hola '.$p->nombre.'! Tu pedido '.$p->codigo.' fue recibido. En breve lo procesamos. — Copias & Tipeos',
            'proceso'   => 'Hola '.$p->nombre.'! Tu pedido '.$p->codigo.' está EN PROCESO. 🖨️ Te avisamos cuando esté listo. — Copias & Tipeos',
            'listo'     => 'Hola '.$p->nombre.'! 🎉 Tu pedido '.$p->codigo.' está LISTO para recoger. ✅ — Copias & Tipeos',
            'entregado' => 'Hola '.$p->nombre.'! Tu pedido '.$p->codigo.' fue ENTREGADO. Gracias! 🙏 — Copias & Tipeos',
            'cancelado' => 'Hola '.$p->nombre.'! Tu pedido '.$p->codigo.' fue CANCELADO. Contáctanos para más info. — Copias & Tipeos',
          ];
          $msgActual = $msgs[$p->estado] ?? 'Tu pedido '.$p->codigo.' fue actualizado.';
        @endphp
        <a class="btn-wa-notif"
          href="https://wa.me/51{{ preg_replace('/\D/','',$p->telefono) }}?text={{ urlencode($msgActual) }}"
          target="_blank">
          💬 Notificar cliente
        </a>
        <form method="POST" action="{{ route('admin.pedidos.eliminar', $p->id) }}" style="margin:0;"
          onsubmit="return confirm('¿Eliminar pedido {{ $p->codigo }}? No se puede deshacer.')">
          @csrf @method('DELETE')
          <button type="submit" class="btn-eliminar">🗑 Eliminar</button>
        </form>
      </div>
    </div>
  </div>
  @empty
  <div class="empty-state">
    <div class="empty-icon">📭</div>
    <p style="font-size:14px;font-weight:700;color:var(--gray);">
      @if(request('q'))
        No se encontraron pedidos para "{{ request('q') }}"
      @else
        No hay pedidos en esta categoría.
      @endif
    </p>
    @if(request('q'))
      <a href="{{ route('admin.pedidos') }}" style="display:inline-block;margin-top:12px;color:var(--blue);font-weight:800;font-size:13px;text-decoration:none;">← Ver todos los pedidos</a>
    @endif
  </div>
  @endforelse

  {{-- PAGINACIÓN --}}
  <div class="pagination-wrap">{{ $pedidos->links() }}</div>

</div>
@endsection

@push('scripts')
<script>
function toggleCard(id) {
  const body = document.getElementById('body-' + id);
  const arr  = document.getElementById('arr-'  + id);
  body.classList.toggle('open');
  arr.classList.toggle('open');
}

// Búsqueda en tiempo real con debounce
let searchTimer;
document.getElementById('searchInput').addEventListener('input', function() {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => {
    document.getElementById('searchForm').submit();
  }, 600);
});
</script>
@endpush