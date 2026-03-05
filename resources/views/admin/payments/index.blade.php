@extends('layouts.admin')
@section('title', 'Paiements')
@section('page-title', 'Historique des Paiements')

@section('content')
  <!-- Stats -->
  <div class="stat-grid">
    <div class="stat-card glass" style="--card-glow:rgba(255,77,26,0.1);">
      <div class="stat-icon-wrap" style="background:var(--ember-soft);"><i class="bi bi-cash-stack"
          style="color:var(--ember);font-size:18px;"></i></div>
      <div>
        <div class="stat-val">{{ number_format($dailyRevenue, 0, ',', ' ') }}</div>
        <div class="stat-lbl">Recettes du jour (F)</div>
      </div>
    </div>
    <div class="stat-card glass">
      <div class="stat-icon-wrap" style="background:var(--s-ready);"><i class="bi bi-calendar-check"
          style="color:var(--s-ready-tx);font-size:18px;"></i></div>
      <div>
        <div class="stat-val" style="color:var(--s-ready-tx);">{{ number_format($monthlyRevenue, 0, ',', ' ') }}</div>
        <div class="stat-lbl">Recettes ce mois (F)</div>
      </div>
    </div>
    <div class="stat-card glass">
      <div class="stat-icon-wrap" style="background:var(--s-prep);"><i class="bi bi-receipt"
          style="color:var(--s-prep-tx);font-size:18px;"></i></div>
      <div>
        <div class="stat-val" style="color:var(--s-prep-tx);">{{ $totalPayments }}</div>
        <div class="stat-lbl">Paiements total</div>
      </div>
    </div>
    <div class="stat-card glass">
      <div class="stat-icon-wrap" style="background:var(--s-paid);"><i class="bi bi-graph-up-arrow"
          style="color:var(--s-paid-tx);font-size:18px;"></i></div>
      <div>
        <div class="stat-val" style="color:var(--s-paid-tx);">{{ number_format($averageBasket, 0, ',', ' ') }}</div>
        <div class="stat-lbl">Panier moyen (F)</div>
      </div>
    </div>
  </div>

  <!-- Filtres -->
  <form method="GET" action="{{ route('admin.payments.index') }}">
    <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
      <input class="field" type="date" name="date_debut" style="max-width:155px;" value="{{ request('date_debut') }}">
      <input class="field" type="date" name="date_fin" style="max-width:155px;" value="{{ request('date_fin') }}">
      <div style="position:relative;flex:1;max-width:260px;">
        <i class="bi bi-search"
          style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--tx-tertiary);"></i>
        <input class="field" name="q" placeholder="Nom du client..." style="padding-left:40px;"
          value="{{ request('q') }}">
      </div>
      <button type="submit" class="btn-ember"><i class="bi bi-funnel"></i>Filtrer</button>
    </div>
  </form>

  <div class="panel glass" style="border-radius:var(--r-xl);">
    <div class="panel-header">
      <div class="panel-title"><i class="bi bi-credit-card-2-front"></i>{{ $payments->total() }} paiement(s)</div>
    </div>
    <table class="data-table">
      <thead>
        <tr>
          <th>#Pmt</th>
          <th>Commande</th>
          <th>Client</th>
          <th>Montant</th>
          <th>Mode</th>
          <th>Date</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($payments as $p)
          <tr>
            <td class="text-muted fs-xs">#{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}</td>
            <td><a href="{{ route('admin.orders.show', $p->order_id) }}"
                class="order-id">#{{ str_pad($p->order_id, 3, '0', STR_PAD_LEFT) }}</a></td>
            <td>
              <div class="cell-name">{{ $p->order?->customer_name ?? '—' }}</div>
              <div class="cell-sub">{{ $p->order?->customer_phone ?? '' }}</div>
            </td>
            <td><span
                style="font-family:'Syne',sans-serif;font-weight:700;font-size:15px;color:var(--s-ready-tx);">{{ number_format($p->amount, 0, ',', ' ') }}
                F</span></td>
            <td><span class="badge" style="background:var(--s-ready);color:var(--s-ready-tx);"><i class="bi bi-cash"
                  style="font-size:10px;"></i>Espèces</span></td>
            <td class="text-muted fs-xs">{{ $p->created_at->format('d/m H:i') }}</td>
            <td><a href="{{ route('admin.orders.show', $p->order_id) }}" class="btn-icon ember"><i
                  class="bi bi-eye"></i></a></td>
          </tr>
        @empty
          <tr>
            <td colspan="7" style="text-align:center;padding:40px;color:var(--tx-muted);">Aucun paiement</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    @if($payments->hasPages())
      <div class="table-footer">
        <span>{{ $payments->total() }} résultat(s)</span>
        <div style="display:flex;gap:4px;">
          @if(!$payments->onFirstPage())<a href="{{ $payments->previousPageUrl() }}" class="btn-icon"><i
          class="bi bi-chevron-left"></i></a>@endif
          @foreach(range(1, $payments->lastPage()) as $pg)
            <a href="{{ $payments->url($pg) }}" class="btn-icon"
              style="{{ $pg === $payments->currentPage() ? 'background:var(--ember-soft);border-color:rgba(255,77,26,.3);color:var(--ember);' : '' }}">{{ $pg }}</a>
          @endforeach
          @if($payments->hasMorePages())<a href="{{ $payments->nextPageUrl() }}" class="btn-icon"><i
          class="bi bi-chevron-right"></i></a>@endif
        </div>
      </div>
    @endif
  </div>
@endsection