<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Commande confirmée — ISI BURGER</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800;900&family=Instrument+Sans:wght@300;400;500;600&display=swap"
    rel="stylesheet">
  <style>
    :root {
      --ember: #FF4D1A;
      --ember-light: #FF7A52;
      --ember-glow: rgba(255, 77, 26, 0.35);
      --ember-soft: rgba(255, 77, 26, 0.12);
      --glass-bg: rgba(255, 255, 255, 0.065);
      --glass-bg-med: rgba(255, 255, 255, 0.10);
      --glass-bg-high: rgba(255, 255, 255, 0.16);
      --glass-border: rgba(255, 255, 255, 0.18);
      --glass-border-hi: rgba(255, 255, 255, 0.32);
      --glass-shadow-lg: 0 24px 64px rgba(0, 0, 0, 0.40), 0 1px 0 rgba(255, 255, 255, 0.12) inset;
      --s-wait: rgba(255, 196, 0, 0.15);
      --s-wait-tx: #FFD93D;
      --s-ready: rgba(0, 230, 130, 0.15);
      --s-ready-tx: #00E682;
      --tx-primary: rgba(255, 255, 255, 0.95);
      --tx-secondary: rgba(255, 255, 255, 0.60);
      --tx-tertiary: rgba(255, 255, 255, 0.35);
      --tx-muted: rgba(255, 255, 255, 0.20);
      --r-md: 16px;
      --r-lg: 22px;
      --r-xl: 30px;
      --r-2xl: 40px;
      --ease: cubic-bezier(0.23, 1, 0.32, 1);
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Instrument Sans', sans-serif;
      background: #0A0A0C;
      color: var(--tx-primary);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
      -webkit-font-smoothing: antialiased;
    }

    .ambient {
      position: fixed;
      inset: 0;
      z-index: 0;
      pointer-events: none;
    }

    .ambient::before {
      content: '';
      position: absolute;
      top: -30%;
      left: -10%;
      width: 60vw;
      height: 60vw;
      background: radial-gradient(ellipse, rgba(255, 77, 26, 0.18) 0%, transparent 65%);
      animation: driftA 20s ease-in-out infinite alternate;
    }

    @keyframes driftA {
      from {
        transform: translate(0, 0)scale(1)
      }

      to {
        transform: translate(5vw, 5vh)scale(1.15)
      }
    }

    .confirm-card {
      width: 100%;
      max-width: 480px;
      border-radius: var(--r-2xl);
      overflow: hidden;
      position: relative;
      z-index: 1;
      background: var(--glass-bg-high);
      backdrop-filter: blur(32px) saturate(200%);
      -webkit-backdrop-filter: blur(32px) saturate(200%);
      border: 1px solid var(--glass-border-hi);
      box-shadow: var(--glass-shadow-lg);
    }

    .confirm-top {
      padding: 36px 28px;
      background: linear-gradient(135deg, rgba(255, 77, 26, 0.15), rgba(255, 122, 82, 0.08));
      border-bottom: 1px solid var(--glass-border);
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .confirm-top::before {
      content: '';
      position: absolute;
      top: -50%;
      left: 50%;
      transform: translateX(-50%);
      width: 200px;
      height: 200px;
      background: radial-gradient(ellipse, rgba(255, 77, 26, 0.25), transparent 60%);
      pointer-events: none;
    }

    .confirm-icon {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background: var(--ember-soft);
      border: 1px solid rgba(255, 77, 26, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 16px;
      position: relative;
    }

    .confirm-icon i {
      font-size: 28px;
      color: var(--ember);
    }

    .confirm-icon-ring {
      position: absolute;
      inset: -8px;
      border-radius: 50%;
      border: 1px solid rgba(255, 77, 26, 0.2);
      animation: pulseRing 2s ease-out infinite;
    }

    @keyframes pulseRing {

      0%,
      100% {
        transform: scale(1);
        opacity: .6
      }

      50% {
        transform: scale(1.08);
        opacity: .2
      }
    }

    .confirm-num {
      font-family: 'Syne', sans-serif;
      font-size: 36px;
      font-weight: 900;
      color: var(--ember);
    }

    .confirm-body {
      padding: 24px;
    }

    .info-tile {
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      border-radius: var(--r-lg);
      padding: 14px 16px;
      margin-bottom: 12px;
    }

    .info-tile-row {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 4px 0;
      font-size: 13.5px;
    }

    .info-tile-row i {
      font-size: 14px;
      color: var(--ember);
      width: 16px;
      text-align: center;
    }

    .btn-ghost {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      padding: 12px;
      background: var(--glass-bg-med);
      color: var(--tx-secondary);
      border: 1px solid var(--glass-border);
      border-radius: var(--r-md);
      font-family: 'Instrument Sans', sans-serif;
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      transition: all .2s var(--ease);
      text-decoration: none;
    }

    .btn-ghost:hover {
      background: var(--glass-bg-high);
      color: var(--tx-primary);
    }
  </style>
</head>

<body>
  <div class="ambient"></div>
  <div class="confirm-card">
    <div class="confirm-top">
      <div class="confirm-icon">
        <i class="bi bi-check-lg"></i>
        <div class="confirm-icon-ring"></div>
      </div>
      <div style="font-family:'Syne',sans-serif;font-size:22px;font-weight:900;margin-bottom:5px;">Commande confirmée
      </div>
      <div style="font-size:13px;color:var(--tx-secondary);">Votre commande a bien été enregistrée</div>
      <div style="margin-top:20px;">
        <div
          style="font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,0.4);margin-bottom:4px;">
          Numéro de commande</div>
        <div class="confirm-num">#{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}</div>
      </div>
    </div>
    <div class="confirm-body">
      <div class="info-tile">
        <div class="info-tile-row"><i class="bi bi-person-fill"></i><span
            style="font-weight:600;">{{ $commande->customer_name }}</span></div>
        <div class="info-tile-row"><i class="bi bi-telephone-fill"></i><span
            style="color:var(--tx-secondary);">{{ $commande->customer_phone }}</span></div>
        <div class="info-tile-row"><i class="bi bi-clock-fill"></i><span
            style="color:var(--tx-secondary);">{{ $commande->created_at->format('d/m/Y · H:i') }}</span></div>
      </div>

      <div
        style="display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:var(--r-lg);background:var(--s-wait);border:1px solid rgba(255,196,0,0.2);margin-bottom:14px;">
        <i class="bi bi-hourglass-split" style="font-size:20px;color:var(--s-wait-tx);"></i>
        <div>
          <div style="font-weight:700;font-size:13px;color:var(--s-wait-tx);">En attente</div>
          <div style="font-size:12px;color:rgba(255,196,0,0.6);">Votre commande va être préparée</div>
        </div>
      </div>

      <div style="margin-bottom:14px;">
        <div
          style="font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--tx-muted);margin-bottom:8px;">
          Récapitulatif</div>
        @foreach($commande->items as $item)
          <div
            style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid var(--glass-border);font-size:13.5px;">
            <span style="color:var(--tx-secondary);">{{ $item->burger_name }} × {{ $item->quantity }}</span>
            <span style="font-weight:600;">{{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }}
              F</span>
          </div>
        @endforeach
        <div
          style="display:flex;justify-content:space-between;padding:12px 0 0;border-top:1px dashed var(--glass-border);font-family:'Syne',sans-serif;font-size:18px;font-weight:900;">
          <span>Total à payer</span><span
            style="color:var(--ember);">{{ number_format($commande->total_amount, 0, ',', ' ') }}
            F</span>
        </div>
      </div>

      <div
        style="background:var(--s-ready);border:1px solid rgba(0,230,130,0.15);border-radius:var(--r-md);padding:12px 14px;display:flex;align-items:center;gap:10px;margin-bottom:16px;font-size:13px;">
        <i class="bi bi-info-circle-fill" style="color:var(--s-ready-tx);font-size:16px;"></i>
        <span style="color:var(--s-ready-tx);">Paiement en espèces au comptoir lors de la livraison</span>
      </div>

      <a href="{{ route('catalogue') }}" class="btn-ghost"><i class="bi bi-arrow-left"></i>Commander à nouveau</a>
    </div>
  </div>
</body>

</html>