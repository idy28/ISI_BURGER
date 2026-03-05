<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin') — ISI BURGER</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Instrument+Sans:wght@300;400;500;600&display=swap"
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
      --glass-bg-solid: rgba(255, 255, 255, 0.22);
      --glass-border: rgba(255, 255, 255, 0.18);
      --glass-border-hi: rgba(255, 255, 255, 0.32);
      --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.28), 0 1px 0 rgba(255, 255, 255, 0.1) inset;
      --glass-shadow-lg: 0 24px 64px rgba(0, 0, 0, 0.40), 0 1px 0 rgba(255, 255, 255, 0.12) inset;
      --bg-void: #0A0A0C;
      --bg-deep: #0F0F12;
      --bg-surface: #141418;
      --tx-primary: rgba(255, 255, 255, 0.95);
      --tx-secondary: rgba(255, 255, 255, 0.60);
      --tx-tertiary: rgba(255, 255, 255, 0.35);
      --tx-muted: rgba(255, 255, 255, 0.20);
      --s-wait: rgba(255, 196, 0, 0.15);
      --s-wait-tx: #FFD93D;
      --s-prep: rgba(0, 174, 255, 0.15);
      --s-prep-tx: #38C6FF;
      --s-ready: rgba(0, 230, 130, 0.15);
      --s-ready-tx: #00E682;
      --s-paid: rgba(140, 100, 255, 0.15);
      --s-paid-tx: #B08EFF;
      --r-xs: 6px;
      --r-sm: 10px;
      --r-md: 16px;
      --r-lg: 22px;
      --r-xl: 30px;
      --r-2xl: 40px;
      --sidebar-w: 240px;
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
      background: var(--bg-void);
      color: var(--tx-primary);
      min-height: 100vh;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
      display: flex;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: 'Syne', sans-serif;
    }

    ::-webkit-scrollbar {
      width: 4px;
      height: 4px;
    }

    ::-webkit-scrollbar-track {
      background: transparent;
    }

    ::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.12);
      border-radius: 4px;
    }

    /* Ambient */
    .ambient {
      position: fixed;
      inset: 0;
      z-index: 0;
      pointer-events: none;
      overflow: hidden;
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

    .ambient::after {
      content: '';
      position: absolute;
      bottom: -20%;
      right: -10%;
      width: 50vw;
      height: 50vw;
      background: radial-gradient(ellipse, rgba(255, 77, 26, 0.10) 0%, transparent 65%);
      animation: driftB 25s ease-in-out infinite alternate;
    }

    .ambient-mid {
      position: absolute;
      top: 40%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 40vw;
      height: 40vw;
      background: radial-gradient(ellipse, rgba(60, 20, 200, 0.06) 0%, transparent 65%);
      animation: driftC 18s ease-in-out infinite alternate;
    }

    @keyframes driftA {
      from {
        transform: translate(0, 0)scale(1)
      }

      to {
        transform: translate(5vw, 5vh)scale(1.15)
      }
    }

    @keyframes driftB {
      from {
        transform: translate(0, 0)scale(1)
      }

      to {
        transform: translate(-6vw, -4vh)scale(1.1)
      }
    }

    @keyframes driftC {
      from {
        transform: translate(-50%, -50%)scale(1)
      }

      to {
        transform: translate(-50%, -50%)scale(1.2)
      }
    }

    /* Glass */
    .glass {
      background: var(--glass-bg);
      backdrop-filter: blur(20px) saturate(160%);
      -webkit-backdrop-filter: blur(20px) saturate(160%);
      border: 1px solid var(--glass-border);
      box-shadow: var(--glass-shadow);
    }

    .glass-med {
      background: var(--glass-bg-med);
      backdrop-filter: blur(24px) saturate(180%);
      -webkit-backdrop-filter: blur(24px) saturate(180%);
      border: 1px solid var(--glass-border);
      box-shadow: var(--glass-shadow);
    }

    .glass-high {
      background: var(--glass-bg-high);
      backdrop-filter: blur(32px) saturate(200%);
      -webkit-backdrop-filter: blur(32px) saturate(200%);
      border: 1px solid var(--glass-border-hi);
      box-shadow: var(--glass-shadow-lg);
    }

    /* Buttons */
    .btn-ember {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(135deg, var(--ember), var(--ember-light));
      color: #fff;
      border: none;
      border-radius: var(--r-md);
      padding: 10px 20px;
      font-family: 'Instrument Sans', sans-serif;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all .25s var(--ease);
      box-shadow: 0 4px 20px var(--ember-glow);
      text-decoration: none;
    }

    .btn-ember:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 32px var(--ember-glow);
      color: #fff;
    }

    .btn-ghost {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: var(--glass-bg-med);
      color: var(--tx-secondary);
      border: 1px solid var(--glass-border);
      border-radius: var(--r-md);
      padding: 9px 18px;
      font-family: 'Instrument Sans', sans-serif;
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      transition: all .2s var(--ease);
      text-decoration: none;
      backdrop-filter: blur(12px);
    }

    .btn-ghost:hover {
      background: var(--glass-bg-high);
      color: var(--tx-primary);
      border-color: var(--glass-border-hi);
    }

    .btn-icon {
      width: 34px;
      height: 34px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: var(--r-sm);
      border: 1px solid var(--glass-border);
      background: var(--glass-bg);
      color: var(--tx-secondary);
      cursor: pointer;
      transition: all .2s var(--ease);
      text-decoration: none;
    }

    .btn-icon:hover {
      background: var(--glass-bg-med);
      color: var(--tx-primary);
    }

    .btn-icon.ember:hover {
      background: var(--ember-soft);
      color: var(--ember);
      border-color: rgba(255, 77, 26, 0.3);
    }

    .btn-icon.danger:hover {
      background: rgba(255, 50, 50, 0.12);
      color: #FF6B6B;
      border-color: rgba(255, 80, 80, 0.25);
    }

    .btn-danger {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      padding: 11px;
      background: rgba(255, 80, 80, 0.1);
      border: 1px solid rgba(255, 80, 80, 0.2);
      border-radius: var(--r-md);
      color: #FF6B6B;
      font-family: 'Instrument Sans', sans-serif;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all .2s var(--ease);
    }

    .btn-danger:hover {
      background: rgba(255, 80, 80, 0.18);
    }

    /* Forms */
    .field {
      width: 100%;
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      border-radius: var(--r-md);
      padding: 11px 16px;
      font-family: 'Instrument Sans', sans-serif;
      font-size: 13.5px;
      color: var(--tx-primary);
      outline: none;
      transition: all .2s var(--ease);
    }

    .field::placeholder {
      color: var(--tx-tertiary);
    }

    .field:focus {
      border-color: rgba(255, 77, 26, 0.5);
      background: var(--glass-bg-med);
      box-shadow: 0 0 0 3px rgba(255, 77, 26, 0.12);
    }

    .field-label {
      font-size: 11.5px;
      font-weight: 600;
      color: var(--tx-tertiary);
      letter-spacing: .06em;
      text-transform: uppercase;
      margin-bottom: 6px;
      display: block;
    }

    .field-group {
      margin-bottom: 16px;
    }

    select.field {
      appearance: none;
      cursor: pointer;
    }

    textarea.field {
      resize: vertical;
      min-height: 90px;
    }

    /* Badges */
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 4px 10px;
      border-radius: 50px;
      font-size: 11px;
      font-weight: 600;
    }

    .badge::before {
      content: '';
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: currentColor;
      flex-shrink: 0;
    }

    .badge-wait {
      background: var(--s-wait);
      color: var(--s-wait-tx);
    }

    .badge-prep {
      background: var(--s-prep);
      color: var(--s-prep-tx);
    }

    .badge-ready {
      background: var(--s-ready);
      color: var(--s-ready-tx);
    }

    .badge-paid {
      background: var(--s-paid);
      color: var(--s-paid-tx);
    }

    /* Sidebar */
    .sidebar {
      width: var(--sidebar-w);
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      background: rgba(10, 10, 12, 0.7);
      backdrop-filter: blur(40px) saturate(180%);
      -webkit-backdrop-filter: blur(40px) saturate(180%);
      border-right: 1px solid var(--glass-border);
      display: flex;
      flex-direction: column;
      z-index: 200;
      padding: 0 0 20px;
    }

    .sidebar-logo {
      padding: 24px 20px 20px;
      border-bottom: 1px solid var(--glass-border);
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .logo-mark {
      width: 38px;
      height: 38px;
      background: linear-gradient(135deg, var(--ember), var(--ember-light));
      border-radius: var(--r-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 16px var(--ember-glow);
      flex-shrink: 0;
    }

    .logo-mark svg {
      width: 20px;
      height: 20px;
      fill: #fff;
    }

    .logo-name {
      font-family: 'Syne', sans-serif;
      font-size: 15px;
      font-weight: 800;
      letter-spacing: .05em;
    }

    .logo-name span {
      color: var(--ember);
    }

    .sidebar-section {
      font-size: 10px;
      font-weight: 700;
      letter-spacing: .1em;
      text-transform: uppercase;
      color: var(--tx-muted);
      padding: 20px 20px 6px;
    }

    .sidebar nav {
      flex: 1;
      overflow-y: auto;
      padding: 4px 10px;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 12px;
      border-radius: var(--r-md);
      color: var(--tx-secondary);
      text-decoration: none;
      font-size: 13.5px;
      font-weight: 500;
      transition: all .2s var(--ease);
      cursor: pointer;
      border: none;
      background: transparent;
      width: 100%;
      text-align: left;
    }

    .nav-item i {
      font-size: 16px;
      width: 20px;
      text-align: center;
      flex-shrink: 0;
    }

    .nav-item:hover {
      background: var(--glass-bg-med);
      color: var(--tx-primary);
    }

    .nav-item.active {
      background: var(--ember-soft);
      color: var(--ember);
    }

    .nav-badge {
      margin-left: auto;
      background: var(--ember);
      color: #fff;
      font-size: 10px;
      font-weight: 700;
      padding: 2px 7px;
      border-radius: 50px;
    }

    .sidebar-footer {
      padding: 10px;
      border-top: 1px solid var(--glass-border);
      margin-top: 8px;
    }

    .nav-item.logout:hover {
      background: rgba(255, 80, 80, 0.1);
      color: #FF6B6B;
    }

    /* Main */
    .main-wrap {
      margin-left: var(--sidebar-w);
      flex: 1;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      position: relative;
      z-index: 1;
    }

    .topbar {
      height: 60px;
      background: rgba(10, 10, 12, 0.6);
      backdrop-filter: blur(40px) saturate(200%);
      -webkit-backdrop-filter: blur(40px) saturate(200%);
      border-bottom: 1px solid var(--glass-border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 28px;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .topbar-title {
      font-family: 'Syne', sans-serif;
      font-size: 17px;
      font-weight: 700;
    }

    .topbar-right {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .topbar-date {
      font-size: 12px;
      color: var(--tx-tertiary);
      padding: 5px 12px;
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      border-radius: 50px;
    }

    .avatar-ring {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--ember), var(--ember-light));
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Syne', sans-serif;
      font-size: 12px;
      font-weight: 700;
      box-shadow: 0 0 0 2px rgba(255, 77, 26, 0.3);
    }

    .pcontent {
      padding: 28px;
      flex: 1;
    }

    /* Stat cards */
    .stat-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
      margin-bottom: 24px;
    }

    .stat-card {
      border-radius: var(--r-xl);
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 14px;
      position: relative;
      overflow: hidden;
      transition: transform .3s var(--ease);
    }

    .stat-card::after {
      content: '';
      position: absolute;
      top: -30%;
      right: -15%;
      width: 70%;
      height: 70%;
      border-radius: 50%;
      background: radial-gradient(ellipse, var(--card-glow, rgba(255, 255, 255, 0.04)) 0%, transparent 70%);
      pointer-events: none;
    }

    .stat-card:hover {
      transform: translateY(-3px);
    }

    .stat-icon-wrap {
      width: 42px;
      height: 42px;
      border-radius: var(--r-md);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }

    .stat-val {
      font-family: 'Syne', sans-serif;
      font-size: 26px;
      font-weight: 800;
      line-height: 1;
    }

    .stat-lbl {
      font-size: 12px;
      color: var(--tx-tertiary);
      font-weight: 500;
      margin-top: 2px;
    }

    /* Tables */
    .data-table {
      width: 100%;
      border-collapse: collapse;
    }

    .data-table th {
      font-size: 10.5px;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      color: var(--tx-muted);
      padding: 10px 16px;
      text-align: left;
      border-bottom: 1px solid var(--glass-border);
      white-space: nowrap;
    }

    .data-table td {
      padding: 12px 16px;
      font-size: 13.5px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.04);
      vertical-align: middle;
    }

    .data-table tr:last-child td {
      border-bottom: none;
    }

    .data-table tbody tr:hover td {
      background: rgba(255, 255, 255, 0.025);
    }

    .order-id {
      font-family: 'Syne', sans-serif;
      font-size: 13px;
      font-weight: 700;
      color: var(--ember);
    }

    .cell-name {
      font-weight: 600;
      font-size: 13.5px;
    }

    .cell-sub {
      font-size: 11.5px;
      color: var(--tx-tertiary);
      margin-top: 1px;
    }

    /* Panels */
    .panel {
      border-radius: var(--r-xl);
      overflow: hidden;
    }

    .panel-header {
      padding: 16px 20px;
      border-bottom: 1px solid var(--glass-border);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .panel-title {
      font-family: 'Syne', sans-serif;
      font-size: 14px;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 8px;
      color: var(--tx-primary);
    }

    .panel-title i {
      color: var(--ember);
      font-size: 16px;
    }

    .panel-body {
      padding: 20px;
    }

    /* Product cards */
    .product-card {
      border-radius: var(--r-xl);
      overflow: hidden;
      transition: all .3s var(--ease);
    }

    .product-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .product-thumb {
      height: 140px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .product-thumb-bg {
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255, 77, 26, 0.15), rgba(255, 122, 82, 0.08));
    }

    .product-thumb i {
      font-size: 48px;
      color: rgba(255, 77, 26, 0.4);
      position: relative;
      z-index: 1;
    }

    .product-thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      position: relative;
      z-index: 1;
    }

    .product-body {
      padding: 14px 16px;
    }

    .product-name {
      font-family: 'Syne', sans-serif;
      font-size: 14px;
      font-weight: 700;
      margin-bottom: 4px;
    }

    .product-desc {
      font-size: 11.5px;
      color: var(--tx-tertiary);
      line-height: 1.45;
      margin-bottom: 10px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .product-price {
      font-family: 'Syne', sans-serif;
      font-size: 16px;
      font-weight: 800;
      color: var(--ember);
    }

    .stock-pill {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 11px;
      font-weight: 600;
      padding: 3px 9px;
      border-radius: 50px;
    }

    .stock-ok {
      background: var(--s-ready);
      color: var(--s-ready-tx);
    }

    .stock-low {
      background: var(--s-wait);
      color: var(--s-wait-tx);
    }

    .stock-none {
      background: rgba(255, 80, 80, 0.12);
      color: #FF6B6B;
    }

    /* Status btns */
    .status-select-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 8px;
    }

    .status-btn {
      padding: 12px;
      border-radius: var(--r-md);
      border: 1px solid var(--glass-border);
      background: var(--glass-bg);
      cursor: pointer;
      transition: all .2s var(--ease);
      text-align: center;
    }

    .status-btn:hover {
      background: var(--glass-bg-med);
    }

    .status-btn.sel-wait {
      background: var(--s-wait);
      border-color: rgba(255, 196, 0, 0.25);
    }

    .status-btn.sel-prep {
      background: var(--s-prep);
      border-color: rgba(0, 174, 255, 0.25);
    }

    .status-btn.sel-ready {
      background: var(--s-ready);
      border-color: rgba(0, 230, 130, 0.25);
    }

    .status-btn.sel-paid {
      background: var(--s-paid);
      border-color: rgba(140, 100, 255, 0.25);
    }

    .status-btn i {
      font-size: 18px;
      display: block;
      margin-bottom: 5px;
      color: var(--tx-secondary);
    }

    .status-btn span {
      font-size: 12px;
      font-weight: 600;
      color: var(--tx-secondary);
    }

    .sel-wait i,
    .sel-wait span {
      color: var(--s-wait-tx);
    }

    .sel-prep i,
    .sel-prep span {
      color: var(--s-prep-tx);
    }

    .sel-ready i,
    .sel-ready span {
      color: var(--s-ready-tx);
    }

    .sel-paid i,
    .sel-paid span {
      color: var(--s-paid-tx);
    }

    /* Upload zone */
    .upload-zone {
      border: 1.5px dashed var(--glass-border);
      border-radius: var(--r-lg);
      padding: 28px;
      text-align: center;
      cursor: pointer;
      transition: all .2s var(--ease);
      background: var(--glass-bg);
    }

    .upload-zone:hover {
      border-color: rgba(255, 77, 26, 0.4);
      background: var(--ember-soft);
    }

    .upload-zone i {
      font-size: 28px;
      color: var(--tx-muted);
    }

    .upload-zone p {
      font-size: 12.5px;
      color: var(--tx-tertiary);
      margin-top: 8px;
      line-height: 1.5;
    }

    /* Misc */
    .chart-wrap {
      padding: 16px;
    }

    .two-col {
      display: grid;
      grid-template-columns: 1fr 360px;
      gap: 16px;
    }

    .row {
      display: flex;
      gap: 16px;
    }

    .row>* {
      flex: 1;
    }

    .danger-zone {
      border-radius: var(--r-xl);
      overflow: hidden;
      border: 1px solid rgba(255, 80, 80, 0.2);
    }

    .danger-zone .panel-header {
      background: rgba(255, 80, 80, 0.07);
      border-bottom-color: rgba(255, 80, 80, 0.15);
    }

    .danger-zone .panel-title,
    .danger-zone .panel-title i {
      color: #FF6B6B;
    }

    .chip-filter {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      margin-bottom: 20px;
    }

    .chip {
      padding: 5px 14px;
      border-radius: 50px;
      border: 1px solid var(--glass-border);
      background: var(--glass-bg);
      color: var(--tx-secondary);
      font-size: 12px;
      font-weight: 500;
      cursor: pointer;
      transition: all .18s var(--ease);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .chip:hover {
      background: var(--glass-bg-med);
      color: var(--tx-primary);
    }

    .chip.active {
      background: var(--ember-soft);
      color: var(--ember);
      border-color: rgba(255, 77, 26, 0.3);
    }

    .table-footer {
      padding: 14px 20px;
      border-top: 1px solid var(--glass-border);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .table-footer span {
      font-size: 12px;
      color: var(--tx-tertiary);
    }

    .alert-flash {
      padding: 12px 20px;
      border-radius: var(--r-md);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 13px;
      font-weight: 500;
    }

    .alert-success {
      background: var(--s-ready);
      color: var(--s-ready-tx);
      border: 1px solid rgba(0, 230, 130, 0.2);
    }

    .alert-danger {
      background: rgba(255, 80, 80, 0.12);
      color: #FF6B6B;
      border: 1px solid rgba(255, 80, 80, 0.2);
    }

    .alert-warning {
      background: var(--s-wait);
      color: var(--s-wait-tx);
      border: 1px solid rgba(255, 196, 0, 0.2);
    }

    .text-muted {
      color: var(--tx-tertiary);
    }

    .text-ember {
      color: var(--ember);
    }

    .fw-bold {
      font-weight: 700;
    }

    .w-full {
      width: 100%;
    }

    .fs-xs {
      font-size: 12px;
    }

    .fs-sm {
      font-size: 13px;
    }

    .grid-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }

    .mb-2 {
      margin-bottom: 16px;
    }

    .mt-2 {
      margin-top: 16px;
    }

    .flex {
      display: flex;
    }

    .items-center {
      align-items: center;
    }

    .gap-1 {
      gap: 8px;
    }

    @media(max-width:1100px) {
      .stat-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media(max-width:900px) {
      .two-col {
        grid-template-columns: 1fr;
      }

      .sidebar {
        transform: translateX(-100%);
      }

      .main-wrap {
        margin-left: 0;
      }
    }
  </style>
  @stack('styles')
</head>

<body>
  <div class="ambient">
    <div class="ambient-mid"></div>
  </div>

  <aside class="sidebar">
    <div class="sidebar-logo">
      <div class="logo-mark"><svg viewBox="0 0 24 24">
          <path d="M4 6h16v2H4zm2 5h12v2H6zm3 5h6v2H9z" />
        </svg></div>
      <div>
        <div class="logo-name">ISI<span>BURGER</span></div>
        <div style="font-size:10px;color:var(--tx-muted);margin-top:1px;">Administration</div>
      </div>
    </div>
    <nav>
      <div class="sidebar-section">Principal</div>
      <a href="{{ route('admin.dashboard') }}"
        class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-fill"></i> Dashboard
      </a>
      <a href="{{ route('admin.orders.index') }}"
        class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <i class="bi bi-receipt-cutoff"></i> Commandes
        @php
          $nb = \App\Models\Order::whereIn('status', [\App\Models\Order::slugToLabel('en_attente'), \App\Models\Order::slugToLabel('en_preparation')])->count();
        @endphp
        @if($nb > 0)<span class="nav-badge">{{ $nb }}</span>@endif
      </a>
      <a href="{{ route('admin.payments.index') }}"
        class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
        <i class="bi bi-credit-card-2-front"></i> Paiements
      </a>
      <div class="sidebar-section">Catalogue</div>
      <a href="{{ route('admin.burgers.index') }}"
        class="nav-item {{ request()->routeIs('admin.burgers.*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i> Burgers
      </a>
      <div class="sidebar-section">Autre</div>
      <a href="{{ route('catalogue') }}" target="_blank" class="nav-item">
        <i class="bi bi-shop-window"></i> Vue Client
      </a>
    </nav>
    <div class="sidebar-footer">
      <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" class="nav-item logout" style="width:100%;">
          <i class="bi bi-box-arrow-left"></i> Déconnexion
        </button>
      </form>
    </div>
  </aside>

  <div class="main-wrap">
    <header class="topbar">
      <div style="display:flex;align-items:center;gap:12px;">
        @hasSection('back-btn')
          @yield('back-btn')
        @endif
        <div class="topbar-title">@yield('page-title')</div>
      </div>
      <div class="topbar-right">
        @yield('topbar-actions')
        <div class="topbar-date"><i class="bi bi-calendar3"
            style="margin-right:6px;"></i>{{ now()->locale('fr')->isoFormat('D MMM YYYY') }}</div>
        <div class="avatar-ring">A</div>
      </div>
    </header>
    <div class="pcontent">
      @foreach(['success', 'error', 'warning'] as $msg)
        @if(session($msg))
          <div
            class="alert-flash {{ $msg === 'success' ? 'alert-success' : ($msg === 'warning' ? 'alert-warning' : 'alert-danger') }}">
            <i
              class="bi bi-{{ $msg === 'success' ? 'check-circle-fill' : ($msg === 'warning' ? 'exclamation-triangle-fill' : 'x-circle-fill') }}"></i>
            {{ session($msg) }}
          </div>
        @endif
      @endforeach
      @if($errors->any())
        <div class="alert-flash alert-danger"><i class="bi bi-x-circle-fill"></i>{{ $errors->first() }}</div>
      @endif
      @yield('content')
    </div>
  </div>
  @stack('scripts')
</body>

</html>