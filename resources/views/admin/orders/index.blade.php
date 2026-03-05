@extends('layouts.admin')
@section('title', 'Commandes')
@section('page-title', 'Commandes')
@section('topbar-actions')
  <div class="topbar-date">{{ $total }} commandes</div>
@endsection

@section('content')
  @php
    $statutCounts = $counts ?? [];
    $labels = ['en_attente' => 'En attente', 'en_preparation' => 'En préparation', 'prete' => 'Prêtes', 'payee' => 'Payées'];
    $badgeCls = ['en_attente' => 'badge-wait', 'en_preparation' => 'badge-prep', 'prete' => 'badge-ready', 'payee' => 'badge-paid'];
    $dotColor = ['en_attente' => 'var(--s-wait-tx)', 'en_preparation' => 'var(--s-prep-tx)', 'prete' => 'var(--s-ready-tx)', 'payee' => 'var(--s-paid-tx)'];
  @endphp

  <!-- Chips filtre statut -->
  <div class="chip-filter">
    <a href="{{ route('admin.orders.index') }}" class="chip {{ !request('statut') ? 'active' : '' }}">
      Toutes <span style="margin-left:4px;opacity:.6;">({{ $total }})</span>
    </a>
    @foreach(['en_attente', 'en_preparation', 'prete', 'payee'] as $s)
      <a href="{{ route('admin.orders.index', ['statut' => $s] + request()->except('statut', 'page')) }}"
        class="chip {{ request('statut') === $s ? 'active' : '' }}">
        <i class="bi bi-circle-fill" style="font-size:7px;color:{{ $dotColor[$s] }};"></i>
        {{ $labels[$s] }} ({{ $statutCounts[$s] ?? 0 }})
      </a>
    @endforeach
  </div>

  <!-- Recherche + date -->
  <form method="GET" action="{{ route('admin.orders.index') }}">
    @if(request('statut'))<input type="hidden" name="statut" value="{{ request('statut') }}">@endif
    <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
      <div style="position:relative;flex:1;max-width:280px;">
        <i class="bi bi-search"
          style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--tx-tertiary);"></i>
        <input class="field" name="q" placeholder="Nom, téléphone..." style="padding-left:40px;"
          value="{{ request('q') }}">
      </div>
      <input class="field" type="date" name="date" style="max-width:180px;" value="{{ request('date') }}">
      <button type="submit" class="btn-ember" style="padding:10px 18px;"><i class="bi bi-funnel"></i></button>
    </div>
  </form>

  <div class="panel glass" style="border-radius:var(--r-xl);">
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Client</th>
          <th>Articles</th>
          <th>Montant</th>
          <th>Statut</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($commandes as $c)
          <tr>
            <td class="order-id">#{{ str_pad($c->id, 3, '0', STR_PAD_LEFT) }}</td>
            <td>
              <div class="cell-name">{{ $c->customer_name }}</div>
              <div class="cell-sub">{{ $c->customer_phone }}</div>
            </td>
            <td class="text-muted fs-sm">{{ $c->items->count() }} article{{ $c->items->count() > 1 ? 's' : '' }}</td>
            <td><span class="fw-bold">{{ number_format($c->total, 0, ',', ' ') }} F</span></td>
            <td><span class="badge {{ $badgeCls[$c->status] ?? '' }}">{{ $labels[$c->status] ?? $c->status }}</span></td>
            <td class="text-muted fs-xs">{{ $c->created_at->format('d/m · H:i') }}</td>
            <td>
              <div style="display:flex;gap:5px;">
                <a href="{{ route('admin.orders.show', $c->id) }}" class="btn-icon ember"><i class="bi bi-eye"></i></a>
                @if($c->status === 'prete')
                  <a href="{{ route('admin.pdf.generate', $c->id) }}" class="btn-icon ember" target="_blank"><i
                      class="bi bi-file-earmark-pdf"></i></a>
                @endif
                @if(!in_array($c->status, ['payee']))
                  <form method="POST" action="{{ route('admin.orders.destroy', $c->id) }}" style="margin:0;"
                    onsubmit="return confirm('Annuler cette commande ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-icon danger"><i class="bi bi-x"></i></button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" style="text-align:center;padding:40px;color:var(--tx-muted);">Aucune commande</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="table-footer">
      <span>{{ $commandes->total() }} résultat(s) — page {{ $commandes->currentPage() }} /
        {{ $commandes->lastPage() }}</span>
      <div style="display:flex;gap:4px;">
        @if($commandes->onFirstPage())
          <button class="btn-icon" disabled><i class="bi bi-chevron-left"></i></button>
        @else
          <a href="{{ $commandes->previousPageUrl() }}" class="btn-icon"><i class="bi bi-chevron-left"></i></a>
        @endif
        @foreach(range(1, $commandes->lastPage()) as $p)
          <a href="{{ $commandes->url($p) }}" class="btn-icon"
            style="{{ $p === $commandes->currentPage() ? 'background:var(--ember-soft);border-color:rgba(255,77,26,.3);color:var(--ember);' : '' }}">{{ $p }}</a>
        @endforeach
        @if($commandes->hasMorePages())
          <a href="{{ $commandes->nextPageUrl() }}" class="btn-icon"><i class="bi bi-chevron-right"></i></a>
        @else
          <button class="btn-icon" disabled><i class="bi bi-chevron-right"></i></button>
        @endif
      </div>
    </div>
  </div>
@endsection