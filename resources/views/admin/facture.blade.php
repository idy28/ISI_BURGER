<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Facture #{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }} — ISI BURGER</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800;900&family=Instrument+Sans:wght@300;400;500;600&display=swap');

    :root {
      --ember: #FF4D1A;
      --ember-light: #FF7A52;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Instrument Sans', sans-serif;
      background: #0A0A0C;
      color: rgba(255, 255, 255, 0.92);
      padding: 40px 20px;
      min-height: 100vh;
      display: flex;
      align-items: flex-start;
      justify-content: center;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .invoice-card {
      width: 100%;
      max-width: 720px;
      border-radius: 30px;
      overflow: hidden;
      background: rgba(255, 255, 255, 0.10);
      border: 1px solid rgba(255, 255, 255, 0.20);
    }

    .invoice-top {
      background: linear-gradient(135deg, rgba(255, 77, 26, 0.18), rgba(255, 122, 82, 0.06));
      padding: 30px 32px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.12);
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }

    .inv-brand {
      font-family: 'Syne', sans-serif;
      font-size: 22px;
      font-weight: 900;
      letter-spacing: .04em;
    }

    .inv-brand span {
      color: var(--ember);
    }

    .inv-number {
      font-family: 'Syne', sans-serif;
      font-size: 28px;
      font-weight: 900;
      color: var(--ember);
      text-align: right;
    }

    .invoice-body {
      padding: 28px 32px;
    }

    .inv-info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
      margin-bottom: 24px;
    }

    .inv-info-box {
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 16px;
      padding: 14px 16px;
    }

    .inv-info-label {
      font-size: 10px;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      color: rgba(255, 255, 255, 0.25);
      margin-bottom: 8px;
    }

    .inv-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .inv-table thead th {
      background: rgba(255, 77, 26, 0.12);
      padding: 10px 14px;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: .06em;
      text-transform: uppercase;
      color: var(--ember);
      text-align: left;
    }

    .inv-table thead th:first-child {
      border-radius: 6px 0 0 6px;
    }

    .inv-table thead th:last-child {
      border-radius: 0 6px 6px 0;
      text-align: right;
    }

    .inv-table tbody td {
      padding: 11px 14px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.06);
      font-size: 13.5px;
    }

    .inv-table tbody td:last-child {
      text-align: right;
      font-weight: 600;
    }

    .inv-table tbody tr:last-child td {
      border-bottom: none;
    }

    .inv-totals {
      margin-left: auto;
      width: 280px;
    }

    .inv-row {
      display: flex;
      justify-content: space-between;
      font-size: 13px;
      color: rgba(255, 255, 255, 0.5);
      padding: 4px 0;
    }

    .inv-total-final {
      display: flex;
      justify-content: space-between;
      background: rgba(255, 77, 26, 0.12);
      border: 1px solid rgba(255, 77, 26, 0.2);
      border-radius: 12px;
      padding: 12px 16px;
      margin-top: 10px;
      font-family: 'Syne', sans-serif;
      font-size: 18px;
      font-weight: 900;
      color: var(--ember);
    }

    .invoice-footer {
      padding: 18px 32px;
      border-top: 1px solid rgba(255, 255, 255, 0.10);
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
    }

    .badge-ready {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 4px 10px;
      border-radius: 50px;
      font-size: 11px;
      font-weight: 600;
      background: rgba(0, 230, 130, 0.15);
      color: #00E682;
    }

    .badge-ready::before {
      content: '';
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: currentColor;
    }

    .btn-print {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: linear-gradient(135deg, var(--ember), var(--ember-light));
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 8px 16px;
      font-family: 'Instrument Sans', sans-serif;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 4px 16px rgba(255, 77, 26, 0.35);
    }

    @media print {
      body {
        background: #fff;
        color: #000;
        padding: 0;
      }

      .invoice-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 0;
      }

      .invoice-top {
        background: rgba(255, 77, 26, 0.08);
      }

      .inv-info-box {
        background: rgba(0, 0, 0, 0.03);
        border: 1px solid #ddd;
      }

      .inv-table thead th {
        background: rgba(255, 77, 26, 0.1);
      }

      .inv-table tbody td {
        border-bottom: 1px solid #eee;
      }

      .inv-total-final {
        background: rgba(255, 77, 26, 0.08);
      }

      .invoice-footer {
        border-top: 1px solid #ddd;
      }

      .btn-print {
        display: none;
      }

      .badge-ready {
        color: green;
        background: rgba(0, 200, 80, 0.1);
      }
    }
  </style>
</head>

<body>
  <div class="invoice-card">
    <div class="invoice-top">
      <div>
        <div class="inv-brand">ISI<span>BURGER</span></div>
        <div style="font-size:11px;color:rgba(255,255,255,0.3);margin-top:3px;">Restaurant — Dakar, Sénégal</div>
      </div>
      <div style="text-align:right;">
        <div
          style="font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,0.3);margin-bottom:4px;">
          Facture</div>
        <div class="inv-number">#{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}</div>
        <div style="font-size:12px;color:rgba(255,255,255,0.4);margin-top:4px;">Émise le
          {{ now()->format('d/m/Y · H:i') }}
        </div>
        <span class="badge-ready" style="margin-top:6px;display:inline-flex;">Prête</span>
      </div>
    </div>

    <div class="invoice-body">
      <div class="inv-info-grid">
        <div class="inv-info-box">
          <div class="inv-info-label">Client</div>
          <div style="font-weight:700;font-size:15px;margin-bottom:4px;">{{ $commande->nom_client }}</div>
          <div style="font-size:12.5px;color:rgba(255,255,255,0.4);display:flex;align-items:center;gap:5px;">📞
            {{ $commande->telephone_client }}
          </div>
        </div>
        <div class="inv-info-box">
          <div class="inv-info-label">Commande</div>
          <div
            style="font-family:'Syne',sans-serif;font-weight:800;font-size:16px;color:var(--ember);margin-bottom:4px;">
            #{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}</div>
          <div style="font-size:12.5px;color:rgba(255,255,255,0.4);">{{ $commande->created_at->format('d/m/Y · H:i') }}
          </div>
          <div style="font-size:12.5px;color:rgba(255,255,255,0.4);margin-top:3px;">💵 Espèces</div>
        </div>
      </div>

      <table class="inv-table">
        <thead>
          <tr>
            <th>Produit</th>
            <th>Prix unitaire</th>
            <th>Quantité</th>
            <th>Sous-total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($commande->items as $item)
            <tr>
              <td><span style="font-weight:600;">{{ $item->burger_nom }}</span></td>
              <td style="color:rgba(255,255,255,0.5);">{{ number_format($item->prix_unitaire, 0, ',', ' ') }} F</td>
              <td style="color:rgba(255,255,255,0.5);">× {{ $item->quantite }}</td>
              <td>{{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} F</td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="inv-totals">
        <div class="inv-row"><span>Sous-total</span><span>{{ number_format($commande->total, 0, ',', ' ') }} F</span>
        </div>
        <div class="inv-row"><span>Taxes</span><span>Incluses</span></div>
        <div class="inv-total-final"><span>TOTAL</span><span>{{ number_format($commande->total, 0, ',', ' ') }} F</span>
        </div>
      </div>
    </div>

    <div class="invoice-footer">
      <div>
        <div style="font-size:12px;color:rgba(255,255,255,0.25);line-height:1.7;max-width:300px;">
          Merci pour votre confiance chez ISI BURGER.<br>
          Ce document est votre facture officielle.<br>
          Règlement exclusivement en espèces.
        </div>
      </div>
      <div style="text-align:right;">
        <div style="font-family:'Syne',sans-serif;font-size:14px;font-weight:900;color:var(--ember);">ISI BURGER</div>
        <div style="font-size:11px;color:rgba(255,255,255,0.25);margin-top:2px;">Généré automatiquement</div>
        <div style="font-size:11px;color:rgba(255,255,255,0.25);">{{ now()->format('d/m/Y · H:i:s') }}</div>
        <button class="btn-print" onclick="window.print()" style="margin-top:10px;">🖨️ Imprimer</button>
      </div>
    </div>
  </div>
</body>

</html>