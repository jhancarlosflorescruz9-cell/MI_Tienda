@extends('layouts.app')
@section('title','Copias & Tipeos — Haz tu pedido')

@section('styles')
<style>
:root{
  --red:#e8001c;--red2:#c0001a;
  --blue:#003fa3;--blue2:#002d78;
  --yellow:#ffd000;--yellow2:#e6b800;
  --green:#16a34a;--green2:#14532d;
  --dark:#0a0d1a;--gray:#6b7280;
  --border:#e5e7eb;--bg:#f4f6ff;
}
*{box-sizing:border-box;margin:0;padding:0;}
.hero{position:relative;overflow:hidden;height:420px;display:flex;align-items:center;}
@media(max-width:600px){.hero{height:300px;}}
.hero-bg{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?w=1200&q=80') center/cover no-repeat;z-index:0;}
.hero-overlay{position:absolute;inset:0;background:linear-gradient(90deg,rgba(0,20,80,.88) 0%,rgba(0,20,80,.55) 55%,rgba(0,20,80,.2) 100%);z-index:1;}
.hero-inner{position:relative;z-index:2;padding:0 28px;max-width:520px;}
.hero-badge{display:inline-flex;align-items:center;gap:6px;background:var(--red);color:#fff;font-family:'Bebas Neue',sans-serif;font-size:12px;letter-spacing:3px;padding:6px 16px;border-radius:4px;margin-bottom:14px;box-shadow:0 4px 0 var(--red2);}
.hero h1{font-family:'Bebas Neue',sans-serif;font-size:64px;line-height:.92;letter-spacing:1px;color:#fff;margin-bottom:12px;text-shadow:3px 3px 0 rgba(0,0,0,.3);}
@media(max-width:600px){.hero h1{font-size:44px;}}
.hero h1 .yl{color:var(--yellow);}
.hero-sub{color:rgba(255,255,255,.8);font-size:13px;font-weight:800;letter-spacing:3px;margin-bottom:22px;}
.hero-btns{display:flex;gap:10px;flex-wrap:wrap;}
.hbtn-primary{display:inline-flex;align-items:center;gap:7px;background:var(--yellow);color:var(--blue2);font-family:'Bebas Neue',sans-serif;font-size:17px;letter-spacing:1.5px;padding:12px 22px;border-radius:8px;text-decoration:none;box-shadow:0 4px 0 var(--yellow2);border:none;cursor:pointer;}
.hbtn-secondary{display:inline-flex;align-items:center;gap:7px;background:rgba(255,255,255,.15);border:2px solid rgba(255,255,255,.5);color:#fff;font-family:'Bebas Neue',sans-serif;font-size:17px;letter-spacing:1.5px;padding:12px 22px;border-radius:8px;text-decoration:none;cursor:pointer;}
.form-section{background:#fff;border-top:5px solid var(--yellow);position:relative;z-index:10;box-shadow:0 -4px 20px rgba(0,0,0,.08);}
.horario-banner{padding:10px 20px;display:flex;align-items:center;gap:10px;font-size:12px;font-weight:800;border-bottom:1.5px solid var(--border);}
.horario-banner.open{background:#dcfce7;color:var(--green2);}
.horario-banner.closed{background:#fee2e2;color:var(--red2);}
.steps-wrap{display:flex;align-items:center;justify-content:center;padding:18px 16px 10px;max-width:560px;margin:0 auto;}
.step-item{display:flex;flex-direction:column;align-items:center;gap:4px;flex:1;}
.step-circle{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Bebas Neue',sans-serif;font-size:17px;border:2.5px solid var(--border);color:#9ca3af;background:#fff;transition:all .3s;}
.step-item.active .step-circle{border-color:var(--blue);color:var(--blue);background:#e8eeff;}
.step-item.done .step-circle{border-color:var(--blue);background:var(--blue);color:#fff;}
.step-label{font-size:10px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#9ca3af;}
.step-item.active .step-label,.step-item.done .step-label{color:var(--blue);}
.step-line{flex:1;height:3px;background:var(--border);margin-bottom:20px;transition:background .3s;}
.step-line.done{background:var(--blue);}
.main{max-width:560px;margin:0 auto;padding:0 16px 110px;}
.card{background:#fff;border-radius:16px;border:1.5px solid var(--border);box-shadow:0 2px 12px rgba(0,0,0,.06);padding:20px;margin-bottom:14px;}
.card-title{font-family:'Bebas Neue',sans-serif;font-size:20px;letter-spacing:2px;color:var(--blue);margin-bottom:18px;display:flex;align-items:center;gap:8px;}
.card-title::before{content:'';display:block;width:5px;height:22px;border-radius:3px;background:linear-gradient(to bottom,var(--red),var(--yellow));}
.svc-selected-banner{display:none;align-items:center;gap:12px;background:var(--blue);border-radius:12px;padding:12px 16px;margin-bottom:16px;}
.svc-selected-banner.show{display:flex;}
.ssb-ico{font-size:28px;}
.ssb-name{font-family:'Bebas Neue',sans-serif;font-size:18px;letter-spacing:1.5px;color:#fff;}
.ssb-price{font-size:12px;color:var(--yellow);font-weight:800;}
.ssb-change{margin-left:auto;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.3);color:#fff;font-size:11px;font-weight:800;padding:5px 12px;border-radius:6px;cursor:pointer;}
.svc-grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;}
@media(max-width:400px){.svc-grid3{grid-template-columns:repeat(2,1fr);}}
.svc-btn3{border:2.5px solid transparent;border-radius:14px;padding:16px 8px;text-align:center;cursor:pointer;transition:all .2s;position:relative;width:100%;}
.svc-btn3:hover{transform:translateY(-3px);filter:brightness(.95);}
.svc-btn3.active{border-color:var(--blue2);box-shadow:0 0 0 3px rgba(0,63,163,.2);}
.svc-check{position:absolute;top:6px;right:6px;width:18px;height:18px;border-radius:50%;background:var(--blue2);color:#fff;font-size:11px;display:none;align-items:center;justify-content:center;}
.svc-btn3.active .svc-check{display:flex;}
.svc3-ico{font-size:28px;margin-bottom:8px;}
.svc3-name{font-size:11px;font-weight:800;line-height:1.4;}
.svc3-price{font-size:10px;margin-top:5px;font-weight:700;opacity:.85;}
.field{margin-bottom:14px;}
.field label{display:block;font-size:10px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:var(--gray);margin-bottom:7px;}
.field input,.field select,.field textarea{width:100%;background:#f9fafb;border:2px solid var(--border);border-radius:10px;padding:12px 14px;font-family:'Nunito',sans-serif;font-size:14px;font-weight:700;color:var(--dark);outline:none;transition:border-color .2s;}
.field input:focus,.field select:focus,.field textarea:focus{border-color:var(--blue);}
.field input.is-invalid{border-color:var(--red);}
.field .error-msg{font-size:11px;color:var(--red);font-weight:700;margin-top:4px;}
.field textarea{resize:vertical;min-height:70px;}
.row2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
@media(max-width:400px){.row2{grid-template-columns:1fr;}}
.seccion-dinamica{border-top:2px dashed var(--border);padding-top:14px;margin-top:4px;display:none;animation:fadeIn .3s ease;}
.seccion-dinamica.visible{display:block;}
@keyframes fadeIn{from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:translateY(0)}}
.seccion-label{font-size:10px;font-weight:800;letter-spacing:2px;text-transform:uppercase;color:var(--blue);margin-bottom:12px;display:flex;align-items:center;gap:6px;}
.seccion-label::before{content:'';width:3px;height:12px;border-radius:2px;background:var(--blue);display:block;}
.drop-zone{border:3px dashed var(--border);border-radius:12px;padding:24px;text-align:center;cursor:pointer;transition:all .2s;background:#fafafa;position:relative;}
.drop-zone:hover{border-color:var(--blue);background:#f0f4ff;}
.drop-zone input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
.extras-grid{display:flex;flex-direction:column;gap:8px;margin-top:4px;}
.extra-item{display:flex;align-items:center;gap:12px;padding:12px 14px;border:2px solid var(--border);border-radius:10px;cursor:pointer;background:#fafafa;transition:all .2s;}
.extra-item:hover{border-color:var(--blue);}
.extra-item input[type=checkbox]{width:18px;height:18px;accent-color:var(--blue);cursor:pointer;flex-shrink:0;}
.extra-item.checked{border-color:var(--blue);background:#e8eeff;}
.extra-name{font-size:13px;font-weight:800;color:var(--dark);}
.extra-price{font-size:11px;font-weight:700;color:var(--red);margin-top:2px;}
.sum-row{display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-bottom:1.5px solid #f3f4f6;}
.sum-row:last-of-type{border:none;}
.sum-k{font-size:12px;color:var(--gray);font-weight:700;}
.sum-v{font-size:13px;font-weight:800;color:var(--dark);text-align:right;max-width:60%;}
.total-box{background:var(--blue);border-radius:12px;padding:18px 20px;display:flex;align-items:center;justify-content:space-between;margin-top:14px;}
.total-lbl{font-family:'Bebas Neue',sans-serif;font-size:18px;letter-spacing:2px;color:rgba(255,255,255,.7);}
.total-val{font-family:'Bebas Neue',sans-serif;font-size:40px;letter-spacing:1px;color:var(--yellow);}
.bottom-bar{position:fixed;bottom:0;left:0;right:0;background:rgba(255,255,255,.97);backdrop-filter:blur(16px);border-top:4px solid var(--yellow);padding:12px 16px;display:flex;gap:10px;z-index:150;}
.btn-back{background:#f3f4f6;border:2px solid var(--border);color:var(--gray);padding:13px 18px;border-radius:10px;font-family:'Nunito',sans-serif;font-size:13px;font-weight:800;cursor:pointer;white-space:nowrap;}
.btn-next{flex:1;background:var(--blue);border:none;color:#fff;padding:13px;border-radius:10px;font-family:'Bebas Neue',sans-serif;font-size:22px;letter-spacing:2px;cursor:pointer;box-shadow:0 4px 0 var(--blue2);}
.btn-enviar{flex:1;background:var(--red);border:none;color:#fff;padding:13px;border-radius:10px;font-family:'Bebas Neue',sans-serif;font-size:20px;letter-spacing:1.5px;cursor:pointer;box-shadow:0 4px 0 var(--red2);}
.screen{display:none;}
.screen.active{display:block;}
.aviso-banner{background:var(--yellow);border-radius:12px;padding:14px 16px;display:flex;align-items:center;gap:10px;margin-bottom:14px;}
.aviso-banner p{font-size:12px;font-weight:800;color:var(--blue2);line-height:1.5;}
</style>
@endsection

@section('content')
<div class="hero">
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>
  <div class="hero-inner">
    <div class="hero-badge">🖨 COPIAS & TIPEOS</div>
    <h1>¿CÓMO QUIERES<br>TU <span class="yl">PEDIDO</span><br>HOY?</h1>
    <p class="hero-sub">RÁPIDO · ECONÓMICO · CALIDAD</p>
    <div class="hero-btns">
      <a href="#formulario" class="hbtn-primary">📋 Hacer pedido</a>
      <a href="https://wa.me/51929286603" target="_blank" class="hbtn-secondary">💬 WhatsApp</a>
    </div>
  </div>
</div>

<div id="formulario" class="form-section">
  <div class="horario-banner {{ $abierto ? 'open' : 'closed' }}">
    @if($abierto) 🟢 Abierto ahora · Atendemos hasta las 8:00pm
    @else 🔴 Cerrado · Atendemos de 8:00am a 8:00pm @endif
  </div>

  <div class="steps-wrap" id="stepsBar">
    <div class="step-item active" id="si1"><div class="step-circle">1</div><div class="step-label">Servicio</div></div>
    <div class="step-line" id="sl1"></div>
    <div class="step-item" id="si2"><div class="step-circle">2</div><div class="step-label">Detalles</div></div>
    <div class="step-line" id="sl2"></div>
    <div class="step-item" id="si3"><div class="step-circle">3</div><div class="step-label">Confirmar</div></div>
  </div>

  <form method="POST" action="{{ route('pedidos.store') }}" id="pedidoForm" enctype="multipart/form-data">
  @csrf
  <div class="main">

    {{-- PASO 1 --}}
    <div class="screen active" id="screen1">
      <div class="card">
        <div class="card-title">¿Qué necesitas?</div>
        @error('servicio')<div style="color:var(--red);font-size:12px;font-weight:800;margin-bottom:10px;">❌ {{ $message }}</div>@enderror
        @php
          $colores=[
            0=>['bg'=>'#dbeafe','text'=>'#1e3a5f','price'=>'#1e40af'],
            1=>['bg'=>'#fce7f3','text'=>'#6b1039','price'=>'#9d174d'],
            2=>['bg'=>'#dcfce7','text'=>'#14532d','price'=>'#166534'],
            3=>['bg'=>'#fef9c3','text'=>'#713f12','price'=>'#854d0e'],
            4=>['bg'=>'#ede9fe','text'=>'#3b0764','price'=>'#5b21b6'],
            5=>['bg'=>'#ffedd5','text'=>'#7c2d12','price'=>'#9a3412'],
          ];
        @endphp
        <div class="svc-grid3">
          @foreach($servicios as $i => $svc)
          @php $c=$colores[$i%6]; @endphp
          <button type="button" class="svc-btn3 {{ old('servicio')===$svc['nombre']?'active':'' }}"
            style="background:{{ $c['bg'] }};"
            onclick="selectSvc(this,'{{ addslashes(htmlspecialchars_decode($svc['nombre'])) }}',{{ $svc['precio_base'] }},'{{ $svc['icono'] }}','{{ $svc['precio'] }}')">
            <div class="svc-check">✓</div>
            <div class="svc3-ico">{{ $svc['icono'] }}</div>
            <div class="svc3-name" style="color:{{ $c['text'] }}">{{ $svc['nombre'] }}</div>
            <div class="svc3-price" style="color:{{ $c['price'] }}">{{ $svc['precio'] }}</div>
          </button>
          @endforeach
        </div>
        <input type="hidden" name="servicio" id="servicioInput" value="{{ old('servicio') }}">
      </div>
    </div>

    {{-- PASO 2 --}}
    <div class="screen" id="screen2">
      <div class="svc-selected-banner" id="svcBanner">
        <div class="ssb-ico" id="svcBannerIco">📄</div>
        <div>
          <div class="ssb-name" id="svcBannerName">Servicio</div>
          <div class="ssb-price" id="svcBannerPrice">—</div>
        </div>
        <button type="button" class="ssb-change" onclick="prevStep()">← Cambiar</button>
      </div>

      <div class="card">
        <div class="card-title">Detalles del pedido</div>

        {{-- Campos comunes --}}
        <div class="field">
          <label>Tu nombre completo</label>
          <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Juan Pérez"
            class="{{ $errors->has('nombre')?'is-invalid':'' }}">
          @error('nombre')<div class="error-msg">{{ $message }}</div>@enderror
        </div>
        <div class="field">
          <label>Tu número de WhatsApp</label>
          <input type="tel" name="telefono" value="{{ old('telefono') }}" placeholder="Ej: 987654321"
            maxlength="9" class="{{ $errors->has('telefono')?'is-invalid':'' }}">
          @error('telefono')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        {{-- SECCIÓN: Copias e Impresiones --}}
        <div class="seccion-dinamica" id="sec-copias">
          <div class="seccion-label">Detalles de impresión</div>
          <div class="row2">
            <div class="field">
              <label>Cantidad de hojas</label>
              <input type="number" name="cantidad" id="cantidad" min="1" max="500" value="{{ old('cantidad',1) }}" oninput="calcTotal()">
            </div>
            <div class="field">
              <label>Tamaño papel</label>
              <select name="tamano">
                @foreach(['A4','A3','Carta','Oficio'] as $t)
                  <option value="{{ $t }}" {{ old('tamano','A4')===$t?'selected':'' }}>{{ $t }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row2">
            <div class="field">
              <label>Copias por página</label>
              <select name="copias_por_pagina">
                <option value="1">1 copia por hoja</option>
                <option value="2">2 copias por hoja</option>
                <option value="4">4 copias por hoja</option>
              </select>
            </div>
            <div class="field">
              <label>Orientación</label>
              <select name="orientacion">
                <option value="vertical">Vertical (portrait)</option>
                <option value="horizontal">Horizontal (landscape)</option>
              </select>
            </div>
          </div>
          <div class="field">
            <label>Rango de páginas (opcional)</label>
            <input type="text" name="rango_paginas" placeholder="Ej: 1-5, 3, 7-10 · Vacío = todas las páginas">
          </div>

          {{-- Solo para copias a color --}}
          <div id="campos-color" style="display:none;">
            <div class="field">
              <label>Páginas a color (opcional)</label>
              <input type="text" name="paginas_color" placeholder="Ej: 1,3,5 · Vacío = todas a color">
            </div>
            <div class="row2">
              <div class="field">
                <label>Calidad de impresión</label>
                <select name="calidad">
                  <option value="normal">Normal</option>
                  <option value="alta">Alta calidad</option>
                </select>
              </div>
              <div class="field">
                <label>Tipo de papel</label>
                <select name="tipo_papel">
                  <option value="normal">Normal</option>
                  <option value="fotografico">Fotográfico</option>
                  <option value="couche">Couché</option>
                </select>
              </div>
            </div>
          </div>

          <div class="field">
            <label>¿Cómo entregas el archivo?</label>
            <select name="entrega">
              @foreach(['Lo traigo en USB','Lo envío por WhatsApp','Lo envío por correo electrónico','Traigo el documento físico'] as $e)
                <option {{ old('entrega')===$e?'selected':'' }}>{{ $e }}</option>
              @endforeach
            </select>
          </div>
          <div class="field">
            <label>Adjuntar archivo (opcional)</label>
            <div class="drop-zone">
              <input type="file" name="archivo" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" onchange="mostrarArchivo(this)">
              <div class="dz-content">
                <div style="font-size:28px;margin-bottom:6px;">📂</div>
                <div style="font-size:13px;font-weight:800;color:var(--dark);">Arrastra o haz clic</div>
                <div style="font-size:11px;color:var(--gray);font-weight:700;margin-top:4px;">PDF, Word, imagen · Máx 10MB</div>
              </div>
            </div>
          </div>
          <div class="field">
            <label>Extras</label>
            <div class="extras-grid">
              <label class="extra-item" onclick="this.classList.toggle('checked')">
                <input type="checkbox" name="tapa" value="1" onchange="calcTotal()">
                <div><div class="extra-name">📎 Tapa plástica</div><div class="extra-price">+ S/. 1.50</div></div>
              </label>
              <label class="extra-item" onclick="this.classList.toggle('checked')">
                <input type="checkbox" name="doble_cara" value="1" onchange="calcTotal()">
                <div><div class="extra-name">🔄 Doble cara</div><div class="extra-price">+ S/. 0.10 por hoja</div></div>
              </label>
            </div>
          </div>
          <div class="field">
            <label>Indicaciones adicionales</label>
            <textarea name="notas" placeholder="Ej: Solo páginas impares, con membrete...">{{ old('notas') }}</textarea>
          </div>
        </div>

        {{-- SECCIÓN: Tipeo --}}
        <div class="seccion-dinamica" id="sec-tipeo">
          <div class="seccion-label">Detalles del tipeo</div>
          <div class="field">
            <label>¿Qué necesitas tipear?</label>
            <select name="tipo_tipeo">
              <option>Documento general</option>
              <option>Tarea / trabajo escolar</option>
              <option>Informe / monografía</option>
              <option>CV / hoja de vida</option>
              <option>Carta / solicitud</option>
              <option>Otro</option>
            </select>
          </div>
          <div class="row2">
            <div class="field">
              <label>Páginas aproximadas</label>
              <input type="number" name="cantidad" id="cantidad-tipeo" min="1" max="200" value="{{ old('cantidad',1) }}" oninput="calcTotal()">
            </div>
            <div class="field">
              <label>Tamaño / formato</label>
              <select name="tamano">
                <option value="A4">A4</option>
                <option value="Carta">Carta</option>
                <option value="Oficio">Oficio</option>
              </select>
            </div>
          </div>
          <div class="field">
            <label>¿Cómo entregas el contenido?</label>
            <select name="entrega">
              <option>Traigo el documento físico</option>
              <option>Lo envío por WhatsApp (foto)</option>
              <option>Lo envío por correo electrónico</option>
              <option>Lo traigo en USB</option>
            </select>
          </div>
          <div class="field">
            <label>Indicaciones especiales</label>
            <textarea name="notas" placeholder="Ej: Tipo de letra Arial 12, márgenes 2.5cm, interlineado 1.5...">{{ old('notas') }}</textarea>
          </div>
        </div>

        {{-- SECCIÓN: Trabajo escolar --}}
        <div class="seccion-dinamica" id="sec-trabajo">
          <div class="seccion-label">Detalles del trabajo</div>
          <div class="field">
            <label>Tipo de trabajo</label>
            <select name="tipo_trabajo">
              <option>Monografía</option>
              <option>Informe</option>
              <option>Tesis / tesina</option>
              <option>Resumen / análisis</option>
              <option>Presentación PowerPoint</option>
              <option>Otro</option>
            </select>
          </div>
          <div class="row2">
            <div class="field">
              <label>Número de páginas</label>
              <input type="number" name="cantidad" id="cantidad-trabajo" min="1" max="500" value="{{ old('cantidad',5) }}" oninput="calcTotal()">
            </div>
            <div class="field">
              <label>Nivel educativo</label>
              <select name="nivel_educativo">
                <option>Primaria</option>
                <option>Secundaria</option>
                <option>Instituto</option>
                <option>Universidad</option>
              </select>
            </div>
          </div>
          <div class="field">
            <label>Tema del trabajo</label>
            <input type="text" name="tema_trabajo" placeholder="Ej: Historia del Perú, Cálculo diferencial...">
          </div>
          <div class="field">
            <label>Fecha límite de entrega</label>
            <input type="date" name="fecha_entrega" min="{{ date('Y-m-d') }}">
          </div>
          <div class="field">
            <label>¿Cómo entregas la información?</label>
            <select name="entrega">
              <option>Lo envío por WhatsApp</option>
              <option>Lo envío por correo electrónico</option>
              <option>Lo traigo en USB</option>
              <option>Traigo el documento físico</option>
            </select>
          </div>
          <div class="field">
            <label>Indicaciones especiales</label>
            <textarea name="notas" placeholder="Ej: Normas APA, mínimo 10 fuentes, con carátula...">{{ old('notas') }}</textarea>
          </div>
          <div class="field">
            <label>Extras de presentación</label>
            <div class="extras-grid">
              <label class="extra-item" onclick="this.classList.toggle('checked')">
                <input type="checkbox" name="tapa" value="1" onchange="calcTotal()">
                <div><div class="extra-name">📎 Tapa plástica</div><div class="extra-price">+ S/. 1.50</div></div>
              </label>
              <label class="extra-item" onclick="this.classList.toggle('checked')">
                <input type="checkbox" name="doble_cara" value="1" onchange="calcTotal()">
                <div><div class="extra-name">🔄 Doble cara</div><div class="extra-price">+ S/. 0.10/hoja</div></div>
              </label>
            </div>
          </div>
        </div>

        {{-- SECCIÓN: Impresión especial --}}
        <div class="seccion-dinamica" id="sec-especial">
          <div class="seccion-label">Detalles de impresión especial</div>
          <div class="field">
            <label>Tipo de impresión</label>
            <select name="tipo_especial">
              <option>Foto en papel fotográfico</option>
              <option>Banner / afiche</option>
              <option>Tarjetas de presentación</option>
              <option>Etiquetas</option>
              <option>Otro</option>
            </select>
          </div>
          <div class="row2">
            <div class="field">
              <label>Cantidad</label>
              <input type="number" name="cantidad" id="cantidad-especial" min="1" value="{{ old('cantidad',1) }}" oninput="calcTotal()">
            </div>
            <div class="field">
              <label>Tamaño</label>
              <select name="tamano">
                <option value="A4">A4</option>
                <option value="A3">A3</option>
                <option value="10x15">10×15 cm</option>
                <option value="Personalizado">Personalizado</option>
              </select>
            </div>
          </div>
          <div class="field">
            <label>¿Cómo entregas el archivo?</label>
            <select name="entrega">
              <option>Lo traigo en USB</option>
              <option>Lo envío por WhatsApp</option>
              <option>Lo envío por correo electrónico</option>
            </select>
          </div>
          <div class="field">
            <label>Adjuntar diseño (opcional)</label>
            <div class="drop-zone">
              <input type="file" name="archivo" accept=".pdf,.jpg,.jpeg,.png" onchange="mostrarArchivo(this)">
              <div class="dz-content">
                <div style="font-size:28px;margin-bottom:6px;">🖼️</div>
                <div style="font-size:13px;font-weight:800;color:var(--dark);">Sube tu diseño aquí</div>
                <div style="font-size:11px;color:var(--gray);font-weight:700;margin-top:4px;">JPG, PNG, PDF · Máx 10MB</div>
              </div>
            </div>
          </div>
          <div class="field">
            <label>Indicaciones especiales</label>
            <textarea name="notas" placeholder="Ej: Sin bordes, con sangrado, tamaño exacto...">{{ old('notas') }}</textarea>
          </div>
        </div>

      </div>
    </div>

    {{-- PASO 3 --}}
    <div class="screen" id="screen3">
      <div class="aviso-banner">
        <span style="font-size:24px">⚡</span>
        <p>Revisa tu pedido y confirma.<br>Te escribiremos por WhatsApp al instante.</p>
      </div>
      <div class="card">
        <div class="card-title">Resumen del pedido</div>
        <div class="sum-row"><span class="sum-k">Servicio</span><span class="sum-v" id="r-svc">—</span></div>
        <div class="sum-row"><span class="sum-k">Cantidad</span><span class="sum-v" id="r-qty">—</span></div>
        <div class="sum-row"><span class="sum-k">Entrega</span><span class="sum-v" id="r-ent">—</span></div>
        <div class="sum-row"><span class="sum-k">Cliente</span><span class="sum-v" id="r-nom">—</span></div>
        <div class="sum-row"><span class="sum-k">WhatsApp</span><span class="sum-v" id="r-tel">—</span></div>
        <div class="sum-row" id="row-tapa" style="display:none"><span class="sum-k">Tapa plástica</span><span class="sum-v" style="color:var(--red)">+ S/. 1.50</span></div>
        <div class="sum-row" id="row-doble" style="display:none"><span class="sum-k">Doble cara</span><span class="sum-v" style="color:var(--red)" id="r-doble">—</span></div>
        <div class="sum-row"><span class="sum-k">Notas</span><span class="sum-v" id="r-notas" style="font-size:12px">—</span></div>
        <div class="total-box">
          <div><div class="total-lbl">TOTAL ESTIMADO</div><div style="font-size:11px;color:rgba(255,255,255,.45);font-weight:700;">*precio referencial</div></div>
          <div class="total-val" id="r-total">S/. 0.00</div>
        </div>
      </div>
    </div>

  </div>

  <div class="bottom-bar" id="bottomBar">
    <button type="button" class="btn-back" id="btnBack" onclick="prevStep()" style="display:none">← Atrás</button>
    <button type="button" class="btn-next" id="btnNext" onclick="nextStep()">SIGUIENTE →</button>
  </div>

  </form>
</div>
@endsection

@push('scripts')
<script>
let step=1,selSvc='{{ old('servicio','') }}',selPrecio=0,selIco='',selPrecioTxt='';
const precios = {
  @foreach($servicios as $s)
  {!! json_encode($s['nombre']) !!}: {{ $s['precio_base'] }},
  @endforeach
};
const seccionMap={
  'Copias B\u0026N':'copias',
  'Copias a color':'copias',
  'Impresión de documento':'copias',
  'Tipeo':'tipeo',
  'Trabajo escolar/universitario':'trabajo',
  'Impresión especial':'especial',
};
if(selSvc){selPrecio=precios[selSvc]||0;}

function selectSvc(btn,nombre,precio,ico,precioTxt){
  document.querySelectorAll('.svc-btn3').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  selSvc=nombre;selPrecio=precio;selIco=ico;selPrecioTxt=precioTxt;
  document.getElementById('servicioInput').value=nombre;
}

function mostrarSeccion(nombre) {
  document.querySelectorAll('.seccion-dinamica').forEach(s => s.classList.remove('visible'));
  const sec = seccionMap[nombre];
  if (sec) {
    const el = document.getElementById('sec-' + sec);
    if (el) el.classList.add('visible');
  }
  const camposColor = document.getElementById('campos-color');
  if (camposColor) {
    camposColor.style.display = nombre === 'Copias a color' ? 'block' : 'none';
  }

  const banner = document.getElementById('svcBanner');
  banner.classList.add('show');
  document.getElementById('svcBannerIco').textContent = selIco || '📄';
  document.getElementById('svcBannerName').textContent = nombre;
  document.getElementById('svcBannerPrice').textContent = selPrecioTxt;
}

function getCantidad(){
  const sec=seccionMap[selSvc];
  const ids={copias:'cantidad',tipeo:'cantidad-tipeo',trabajo:'cantidad-trabajo',especial:'cantidad-especial'};
  const id=ids[sec]||'cantidad';
  const el=document.getElementById(id);
  return parseInt(el?.value)||1;
}

function calcTotal(){
  const qty=getCantidad();
  let t=selPrecio*qty;
  document.querySelectorAll('[name=tapa]:checked').forEach(()=>t+=1.5);
  document.querySelectorAll('[name=doble_cara]:checked').forEach(()=>t+=0.1*qty);
  return t;
}

function updateSteps(n){
  for(let i=1;i<=3;i++){
    document.getElementById('si'+i).className='step-item'+(i<n?' done':i===n?' active':'');
    const l=document.getElementById('sl'+i);
    if(l)l.className='step-line'+(i<n?' done':'');
  }
}

function setStep(n){
  document.querySelectorAll('.screen').forEach((s,i)=>s.classList.toggle('active',i===n-1));
  document.getElementById('btnBack').style.display=n>1?'block':'none';
  const btn=document.getElementById('btnNext');
  if(n===3){btn.textContent='✅ CONFIRMAR PEDIDO';btn.className='btn-enviar';}
  else{btn.textContent='SIGUIENTE →';btn.className='btn-next';}
  updateSteps(n);step=n;
  if(n===3)fillResumen();
  if(n===2)mostrarSeccion(selSvc);
  const top=document.getElementById('formulario').offsetTop-60;
  window.scrollTo({top,behavior:'smooth'});
}

function nextStep(){
  if(step===1){
    if(!selSvc){alert('Selecciona un servicio');return;}
    setStep(2);
  }else if(step===2){
    const nombre=document.querySelector('[name=nombre]').value.trim();
    const tel=document.querySelector('[name=telefono]').value.replace(/\D/g,'');
    if(!nombre){alert('Ingresa tu nombre completo');return;}
    if(tel.length!==9||!tel.startsWith('9')){alert('Número inválido: 9 dígitos comenzando con 9');return;}
    setStep(3);
  }else if(step===3){
    document.getElementById('pedidoForm').submit();
  }
}

function prevStep(){if(step>1)setStep(step-1);}

function fillResumen(){
  const qty=getCantidad();
  const tapa=document.querySelector('[name=tapa]:checked');
  const doble=document.querySelector('[name=doble_cara]:checked');
  const notas=document.querySelector('[name=notas]')?.value||'Ninguna';
  const entrega=document.querySelector('[name=entrega]')?.value||'—';
  const tamano=document.querySelector('[name=tamano]')?.value||'';
  document.getElementById('r-svc').textContent=selSvc||'—';
  document.getElementById('r-qty').textContent=qty+(tamano?' × '+tamano:'');
  document.getElementById('r-ent').textContent=entrega;
  document.getElementById('r-nom').textContent=document.querySelector('[name=nombre]').value||'—';
  document.getElementById('r-tel').textContent=document.querySelector('[name=telefono]').value||'—';
  document.getElementById('r-notas').textContent=notas;
  document.getElementById('row-tapa').style.display=tapa?'flex':'none';
  document.getElementById('row-doble').style.display=doble?'flex':'none';
  if(doble)document.getElementById('r-doble').textContent='+ S/. '+(0.10*qty).toFixed(2);
  document.getElementById('r-total').textContent='S/. '+calcTotal().toFixed(2);
}

function mostrarArchivo(input){
  const file=input.files[0];if(!file)return;
  const dz=input.closest('.drop-zone');
  const content=dz.querySelector('.dz-content');
  if(content)content.innerHTML=`<div style="font-size:26px;margin-bottom:6px;">✅</div><div style="font-size:13px;font-weight:800;color:var(--green);">${file.name}</div><div style="font-size:11px;color:var(--gray);font-weight:700;margin-top:4px;">${(file.size/1024).toFixed(0)} KB</div>`;
}

@if($errors->any())
@if($errors->has('servicio'))setStep(1);@else setStep(2);@endif
@endif
</script>
@endpush