@extends('layouts.admin')
@section('title', 'Burgers')
@section('page-title', 'Catalogue Burgers')
@section('topbar-actions')
  <a href="{{ route('admin.burgers.create') }}" class="btn-ember"><i class="bi bi-plus"></i>Nouveau burger</a>
@endsection

@section('content')
  <!-- Filtres -->
  <form method="GET" action="{{ route('admin.burgers.index') }}">
    <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;align-items:center;">
      <div style="position:relative;flex:1;max-width:320px;">
        <i class="bi bi-search"
          style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--tx-tertiary);"></i>
        <input class="field" name="q" placeholder="Rechercher un burger..." style="padding-left:40px;"
          value="{{ request('q') }}">
      </div>
      <select class="field" name="statut" style="max-width:180px;">
        <option value="">Tous les statuts</option>
        <option value="disponible" {{ request('statut') === 'disponible' ? 'selected' : '' }}>Disponible</option>
        <option value="indisponible" {{ request('statut') === 'indisponible' ? 'selected' : '' }}>Indisponible</option>
      </select>
      <button type="submit" class="btn-ember"><i class="bi bi-funnel"></i>Filtrer</button>
    </div>
  </form>

  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:14px;">
    @forelse($burgers as $burger)
      <div class="product-card glass-med">
        <div class="product-thumb">
          <div class="product-thumb-bg"></div>
          @if($burger->image)
            <img src="{{ Storage::url($burger->image) }}" alt="{{ $burger->name }}">
          @else
            <i class="bi bi-layers-half"></i>
          @endif
        </div>
        <div class="product-body">
          <div class="product-name">{{ $burger->name }}</div>
          <div class="product-desc">{{ $burger->description ?? 'Aucune description' }}</div>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
            <div class="product-price">{{ number_format($burger->price, 0, ',', ' ') }} F</div>
            @if($burger->stock <= 0)
              <span class="stock-pill stock-none"><i class="bi bi-x-circle"></i> Rupture</span>
            @elseif($burger->stock <= 5)
              <span class="stock-pill stock-low"><i class="bi bi-exclamation-circle"></i> {{ $burger->stock }} restants</span>
            @else
              <span class="stock-pill stock-ok"><i class="bi bi-check-circle"></i> {{ $burger->stock }} en stock</span>
            @endif
          </div>
          <div style="display:flex;gap:6px;">
            <a href="{{ route('admin.burgers.edit', $burger->id) }}" class="btn-ghost"
              style="flex:1;font-size:12px;padding:7px 10px;justify-content:center;border-radius:10px;"><i
                class="bi bi-pencil"></i>Modifier</a>
            <form method="POST" action="{{ route('admin.burgers.toggle', $burger->id) }}" style="margin:0;">
              @csrf @method('PATCH')
              <button type="submit" class="btn-icon" title="{{ $burger->available ? 'Désactiver' : 'Activer' }}">
                <i class="bi {{ $burger->available ? 'bi-toggle-on' : 'bi-toggle-off' }}"
                  style="color:{{ $burger->available ? 'var(--s-ready-tx)' : 'var(--tx-muted)' }};"></i>
              </button>
            </form>
            <form method="POST" action="{{ route('admin.burgers.destroy', $burger->id) }}" style="margin:0;"
              onsubmit="return confirm('Supprimer ce burger ?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-icon danger"><i class="bi bi-trash3"></i></button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div style="grid-column:1/-1;text-align:center;padding:60px 20px;color:var(--tx-muted);">
        <i class="bi bi-box-seam" style="font-size:40px;display:block;margin-bottom:12px;"></i>
        Aucun burger trouvé
      </div>
    @endforelse
  </div>

  @if($burgers->hasPages())
    <div style="display:flex;justify-content:center;margin-top:24px;gap:4px;">
      {{ $burgers->appends(request()->query())->links('pagination::simple-default') }}
    </div>
  @endif
@endsection