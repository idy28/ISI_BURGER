@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@push('styles')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush

@section('content')
  <!-- STAT CARDS -->
  <div class="stat-grid">
    <div class="stat-card glass" style="--card-glow:rgba(255,77,26,0.12);">
      <div class="stat-icon-wrap" style="background:rgba(255,77,26,0.15);"><i class="bi bi-hourglass-split"
          style="color:var(--ember);font-size:20px;"></i></div>
      <div>
        <div class="stat-val">{{ $ordersInProgress }}</div>
        <div class="stat-lbl">Commandes en cours</div>
      </div>
    </div>
    <div class="stat-card glass" style="--card-glow:rgba(0,230,130,0.1);">
      <div class="stat-icon-wrap" style="background:var(--s-ready);"><i class="bi bi-patch-check"
          style="color:var(--s-ready-tx);font-size:20px;"></i></div>
      <div>
        <div class="stat-val" style="color:var(--s-ready-tx);">{{ $ordersCompletedToday }}</div>
        <div class="stat-lbl">Commandes validées dans la journée</div>
      </div>
    </div>
    <div class="stat-card glass" style="--card-glow:rgba(56,198,255,0.1);">
      <div class="stat-icon-wrap" style="background:var(--s-prep);"><i class="bi bi-cash-stack"
          style="color:var(--s-prep-tx);font-size:20px;"></i></div>
      <div>
        <div class="stat-val" style="color:var(--s-prep-tx);">{{ number_format($dailyRevenue, 0, ',', ' ') }}</div>
        <div class="stat-lbl">Recettes de la journée F</div>
      </div>
    </div>
    <div class="stat-card glass" style="--card-glow:rgba(176,142,255,0.1);">
      <div class="stat-icon-wrap" style="background:var(--s-paid);"><i class="bi bi-box-seam"
          style="color:var(--s-paid-tx);font-size:20px;"></i></div>
      <div>
        <div class="stat-val" style="color:var(--s-paid-tx);">{{ $totalBurgers }}</div>
        <div class="stat-lbl">Burgers au catalogue</div>
      </div>
    </div>
  </div>

  <!-- CHARTS -->
  <div class="row mb-2" style="margin-bottom:16px;">
    <div class="panel glass-med" style="border-radius:var(--r-xl);">
      <div class="panel-header">
        <div class="panel-title"><i class="bi bi-bar-chart-line-fill"></i>Commandes par mois</div>
        <span style="font-size:11px;color:var(--tx-muted);">{{ now()->year }}</span>
      </div>
      <div class="chart-wrap"><canvas id="chartBar" height="180"></canvas></div>
    </div>
    <div class="panel glass-med" style="max-width:280px;border-radius:var(--r-xl);">
      <div class="panel-header">
        <div class="panel-title"><i class="bi bi-pie-chart-fill"></i>Top ventes</div>
        <span style="font-size:11px;color:var(--tx-muted);">Ce mois</span>
      </div>
      <div class="chart-wrap"><canvas id="chartDonut" height="200"></canvas></div>
    </div>
  </div>

  <!-- RECENT ORDERS -->
  <div class="panel glass" style="border-radius:var(--r-xl);">
    <div class="panel-header">
      <div class="panel-title"><i class="bi bi-receipt-cutoff"></i>Dernières commandes</div>
        <a href="{{ route('admin.orders.index') }}" class="btn-ghost" style="font-size:12px;padding:6px 14px;"><i
          class="bi bi-arrow-right"></i>Voir tout</a>
    </div>
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Client</th>
          <th>Montant</th>
          <th>Statut</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($latestOrders as $c)
          <tr>
            <td class="order-id">#{{ str_pad($c->id, 3, '0', STR_PAD_LEFT) }}</td>
            <td>
              <div class="cell-name">{{ $c->nom_client }}</div>
              <div class="cell-sub">{{ $c->telephone_client }}</div>
            </td>
            <td class="fw-bold">{{ number_format($c->total, 0, ',', ' ') }} F</td>
            <td>
              @php $badges = ['En attente' => 'badge-wait', 'En preparation' => 'badge-prep', 'Prete' => 'badge-ready', 'Payee' => 'badge-paid'];
              $labels = ['En attente' => 'En attente', 'En preparation' => 'En préparation', 'Prete' => 'Prête', 'Payee' => 'Payée']; @endphp
              <span class="badge {{ $badges[$c->status] ?? '' }}">{{ $labels[$c->status] ?? $c->status }}</span>
            </td>
            <td class="text-muted fs-xs">{{ $c->created_at->format('d/m H:i') }}</td>
            <td>
              <div style="display:flex;gap:4px;">
                <a href="{{ route('admin.orders.show', $c->id) }}" class="btn-icon ember"><i class="bi bi-eye"></i></a>
                @if($c->status === 'Prete' || $c->status === 'Payee')
                  <a href="{{ route('admin.pdf.generate', $c->id) }}" class="btn-icon ember" target="_blank"><i
                      class="bi bi-file-earmark-pdf"></i></a>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="text-align:center;padding:32px;color:var(--tx-muted);">Aucune commande</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection

@push('scripts')
  <script>
    const barData = @json($ordersPerMonth);
    console.log('Bar Data:', barData);
    const donutData = @json($topProducts);

    new Chart(document.getElementById('chartBar'), {
      type: 'bar',
      data: {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
        datasets: [{
          data: barData,
          backgroundColor: ctx => { const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 200); g.addColorStop(0, 'rgba(255,77,26,0.85)'); g.addColorStop(1, 'rgba(255,77,26,0.15)'); return g; },
          borderRadius: 8, borderSkipped: false,
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false }, tooltip: { backgroundColor: 'rgba(15,15,18,0.95)', titleFont: { family: 'Syne', weight: 700 }, bodyFont: { family: 'Instrument Sans' }, borderColor: 'rgba(255,255,255,0.1)', borderWidth: 1 } },
        scales: {
          y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: 'rgba(255,255,255,0.35)', font: { family: 'Instrument Sans', size: 11 } } },
          x: { grid: { display: false }, ticks: { color: 'rgba(255,255,255,0.35)', font: { family: 'Instrument Sans', size: 11 } } }
        }
      }
    });

    new Chart(document.getElementById('chartDonut'), {
      type: 'doughnut',
      data: {
        labels: donutData.map(d => d.nom),
        datasets: [{ data: donutData.map(d => d.total), backgroundColor: ['#FF4D1A', 'rgba(184, 44, 156, 0.6)', 'rgba(0,174,255,0.7)', 'rgba(140,100,255,0.7)', 'rgba(0,230,130,0.7)'], borderWidth: 0, hoverOffset: 10 }]
      },
      options: {
        responsive: true, cutout: '68%',
        plugins: {
          legend: { position: 'bottom', labels: { color: 'rgba(255,255,255,0.45)', font: { family: 'Instrument Sans', size: 11 }, padding: 12, boxWidth: 10, boxHeight: 10 } },
          tooltip: { backgroundColor: 'rgba(15,15,18,0.95)', bodyFont: { family: 'Instrument Sans' }, borderColor: 'rgba(255,255,255,0.1)', borderWidth: 1 }
        }
      }
    });
  </script>
@endpush