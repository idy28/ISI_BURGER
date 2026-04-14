@extends('layouts.admin')
@section('title', 'Commande #' . str_pad($order->id, 3, '0', STR_PAD_LEFT))
  @section('page-title')Commande <span
style="color:var(--ember)">#{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</span>@endsection
@section('back-btn')
  <a href="{{ route('admin.orders.index') }}" class="btn-icon"><i class="bi bi-arrow-left"></i></a>
@endsection
@section('topbar-actions')
  @php $badges = ['En attente' => 'badge-wait', 'En preparation' => 'badge-prep', 'Prete' => 'badge-ready', 'Payee' => 'badge-paid'];
  $lbls = ['En attente' => 'En attente', 'En preparation' => 'En preparation', 'Prete' => 'Prete', 'Payee' => 'Payee']; @endphp
  <span class="badge {{ $badges[$order->status] ?? '' }}">{{ $lbls[$order->status] ?? '' }}</span>
  @if($order->status === 'Prete')
    <a href="{{ route('admin.pdf.generate', $order->id) }}" class="btn-ember" target="_blank"><i
        class="bi bi-file-earmark-pdf"></i>Facture PDF</a>
  @endif
@endsection

@section('content')
  <!-- Breadcrumb -->
  <div style="display:flex;align-items:center;gap:6px;margin-bottom:20px;font-size:12.5px;color:var(--tx-tertiary);">
    <i class="bi bi-receipt-cutoff"></i>
    <a href="{{ route('admin.orders.index') }}" style="color:var(--tx-tertiary);text-decoration:none;">Commandes</a>
    <i class="bi bi-chevron-right" style="font-size:10px;"></i>
    <span style="color:var(--ember);">#{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</span>
  </div>

  <div class="two-col">
    <!-- COLONNE GAUCHE -->
    <div>
      <!-- Meta -->
      <div class="panel glass-med" style="border-radius:var(--r-xl);margin-bottom:16px;">
        <div class="panel-body">
          <div style="font-family:'Syne',sans-serif;font-size:22px;font-weight:900;">
            Commande <span style="color:var(--ember)">#{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</span>
          </div>
          <div style="font-size:12.5px;color:var(--tx-tertiary);display:flex;align-items:center;gap:5px;margin-top:3px;">
            <i class="bi bi-clock"></i>{{ $order->created_at->format('d M Y — H:i') }}
          </div>
          @if($order->notes)
            <div
              style="margin-top:10px;padding:10px 14px;background:var(--glass-bg);border:1px solid var(--glass-border);border-radius:var(--r-md);font-size:13px;color:var(--tx-secondary);">
              <i class="bi bi-chat-text" style="color:var(--ember);margin-right:6px;"></i>{{ $order->notes }}
            </div>
          @endif
        </div>
      </div>

      <!-- Articles -->
      <div class="panel glass" style="border-radius:var(--r-xl);margin-bottom:16px;">
        <div class="panel-header">
          <div class="panel-title"><i class="bi bi-bag-check"></i>Articles</div>
        </div>
        <div class="panel-body" style="padding-top:12px;">
          @foreach($order->items as $item)
            <div
              style="display:flex;align-items:center;gap:14px;padding:10px 0;{{ !$loop->last ? 'border-bottom:1px solid var(--glass-border);' : '' }}">
              <div
                style="width:50px;height:50px;border-radius:var(--r-md);background:rgba(255,77,26,0.15);border:1px solid rgba(255,77,26,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
                @if($item->burger?->image)
                  <img src="{{ Storage::url($item->burger->image) }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                  <i class="bi bi-layers-half" style="font-size:22px;color:rgba(255,77,26,0.5);"></i>
                @endif
              </div>
              <div style="flex:1;">
                <div style="font-weight:600;font-size:14px;">{{ $item->burger_name }}</div>
                <div style="font-size:12px;color:var(--tx-tertiary);">{{ number_format($item->unit_price, 0, ',', ' ') }} F
                  × {{ $item->quantity }}</div>
              </div>
              <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:15px;">
                {{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }} F</div>
            </div>
          @endforeach
          <div
            style="padding-top:12px;border-top:1px dashed var(--glass-border);display:flex;justify-content:space-between;font-family:'Syne',sans-serif;font-size:18px;font-weight:900;">
            <span>Total</span><span style="color:var(--ember);">{{ number_format($order->total, 0, ',', ' ') }} F</span>
          </div>
        </div>
      </div>

      <!-- Statut -->
      @if(!in_array($order->status, ['Payee']))
        <div class="panel glass" style="border-radius:var(--r-xl);">
          <div class="panel-header">
            <div class="panel-title"><i class="bi bi-arrow-left-right"></i>Modifier le statut</div>
          </div>
          <div class="panel-body">
            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
              @csrf @method('PATCH')
              <div class="status-select-grid">
                @php $statuts = ['En attente' => ['icon' => 'bi-hourglass-split', 'cls' => 'sel-wait'], 'En preparation' => ['icon' => 'bi-fire', 'cls' => 'sel-prep'], 'Prete' => ['icon' => 'bi-check-circle-fill', 'cls' => 'sel-ready'], 'Payee' => ['icon' => 'bi-cash-coin', 'cls' => 'sel-paid']]; @endphp
                @foreach($statuts as $val => $s)
                  @php $actif = $order->status === $val; @endphp
                  <button type="submit" name="status" value="{{ $val }}" class="status-btn {{ $actif ? $s['cls'] : '' }}">
                    <i class="bi {{ $s['icon'] }}"></i>
                    <span>{{ $lbls[$val] }}</span>
                  </button>
                @endforeach
              </div>
            </form>
          </div>
        </div>
      @endif
    </div>

    <!-- COLONNE DROITE -->
    <div>
      <!-- Client -->
      <div class="panel glass-med" style="border-radius:var(--r-xl);margin-bottom:16px;">
        <div class="panel-header">
          <div class="panel-title"><i class="bi bi-person-circle"></i>Client</div>
        </div>
        <div class="panel-body">
          <div style="display:flex;align-items:center;gap:12px;">
            <div
              style="width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,rgba(255,77,26,0.25),rgba(255,122,82,0.1));border:1px solid rgba(255,77,26,0.2);display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-size:18px;font-weight:900;color:var(--ember);flex-shrink:0;">
              {{ mb_strtoupper(mb_substr($order->customer_name, 0, 1)) }}
            </div>
            <div>
              <div style="font-weight:600;font-size:15px;">{{ $order->customer_name }}</div>
              <div
                style="font-size:12.5px;color:var(--tx-tertiary);display:flex;align-items:center;gap:4px;margin-top:2px;">
                <i class="bi bi-telephone"></i>{{ $order->customer_phone }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Paiement -->
      @if(!$order->payment)
        @if($order->status === 'Prete')
          <div class="panel glass" style="border-radius:var(--r-xl);margin-bottom:16px;">
            <div class="panel-header">
              <div class="panel-title"><i class="bi bi-wallet2"></i>Enregistrer paiement</div>
            </div>
            <div class="panel-body">
              <form method="POST" action="{{ route('admin.payments.store') }}">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <div class="field-group">
                  <label class="field-label">Montant reçu (FCFA)</label>
                  <input class="field" type="number" name="amount_paid" value="{{ $order->total }}" required min="0">
                </div>
                <div class="field-group">
                  <label class="field-label">Notes (optionnel)</label>
                  <input class="field" name="notes" placeholder="Observations...">
                </div>
                <button type="submit" class="btn-ember w-full"
                  style="justify-content:center;padding:12px;border-radius:var(--r-md);"><i
                    class="bi bi-check-circle"></i>Confirmer le paiement</button>
              </form>
            </div>
          </div>
        @endif
      @else
        <div class="panel glass" style="border-radius:var(--r-xl);margin-bottom:16px;">
          <div class="panel-header">
            <div class="panel-title"><i class="bi bi-wallet2"></i>Paiement</div>
          </div>
          <div class="panel-body">
            <div
              style="background:var(--s-paid);border:1px solid rgba(140,100,255,0.2);border-radius:var(--r-lg);padding:14px 16px;">
              <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;"><i class="bi bi-check-circle-fill"
                  style="color:var(--s-paid-tx);"></i><span style="font-weight:700;color:var(--s-paid-tx);">Payée</span>
              </div>
              <div style="font-size:12.5px;color:var(--tx-tertiary);">
                {{ number_format($order->payment->amount, 0, ',', ' ') }} F —
                {{ $order->payment->created_at->format('d/m/Y H:i') }}</div>
            </div>
          </div>
        </div>
      @endif

      <!-- Zone danger -->
      @if(!in_array($order->status, ['Payee']))
        <div class="danger-zone panel">
          <div class="panel-header">
            <div class="panel-title"><i class="bi bi-shield-exclamation"></i>Zone dangereuse</div>
          </div>
          <div class="panel-body">
            <form method="POST" action="{{ route('admin.orders.destroy', $order->id) }}"
              onsubmit="return confirm('Annuler cette commande ? Le stock sera restauré.')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-danger"><i class="bi bi-x-circle"></i>Annuler la commande</button>
            </form>
          </div>
        </div>
      @endif
    </div>
  </div>
 @if(session('justSetToPrete'))
  <script>
  document.addEventListener('DOMContentLoaded', function () {
      fetch("{{ route('admin.pdf.generate', $order->id) }}")
      .then(res => res.blob())  // on récupère le PDF en blob
      .then(blob => {
          // créer un lien temporaire pour télécharger le PDF
          const url = window.URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.href = url;
          a.download = "facture_{{ $order->id }}.pdf";
          document.body.appendChild(a);
          a.click();
          a.remove();
      })
      .catch(err => console.error(err));
  });
  </script>
@endif
@endsection