<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ISI BURGER')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800;900&family=Instrument+Sans:wght@300;400;500;600&display=swap"
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
            --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.28), 0 1px 0 rgba(255, 255, 255, 0.1) inset;
            --glass-shadow-lg: 0 24px 64px rgba(0, 0, 0, 0.40), 0 1px 0 rgba(255, 255, 255, 0.12) inset;
            --bg-void: #0A0A0C;
            --tx-primary: rgba(255, 255, 255, 0.95);
            --tx-secondary: rgba(255, 255, 255, 0.60);
            --tx-tertiary: rgba(255, 255, 255, 0.35);
            --tx-muted: rgba(255, 255, 255, 0.20);
            --s-wait: rgba(255, 196, 0, 0.15);
            --s-wait-tx: #FFD93D;
            --s-ready: rgba(0, 230, 130, 0.15);
            --s-ready-tx: #00E682;
            --r-sm: 10px;
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
            background: var(--bg-void);
            color: var(--tx-primary);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
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

        .btn-ember:disabled {
            opacity: .4;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
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
        }

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

        textarea.field {
            resize: vertical;
            min-height: 70px;
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(12px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s var(--ease);
        }

        .modal-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .modal-box {
            width: 100%;
            max-width: 480px;
            border-radius: var(--r-2xl);
            overflow: hidden;
            transform: scale(0.94) translateY(10px);
            transition: transform .3s var(--ease);
        }

        .modal-overlay.open .modal-box {
            transform: scale(1) translateY(0);
        }

        .modal-header {
            padding: 22px 24px 18px;
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 800;
        }

        .modal-body {
            padding: 22px 24px;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--glass-border);
            display: flex;
            gap: 10px;
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
        }

        .btn-icon:hover {
            background: var(--glass-bg-med);
            color: var(--tx-primary);
        }

        /* Cat layout */
        .cat-layout {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        .cat-main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .cat-header {
            height: 64px;
            background: rgba(10, 10, 12, 0.75);
            backdrop-filter: blur(40px) saturate(180%);
            -webkit-backdrop-filter: blur(40px) saturate(180%);
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 20px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .cat-brand {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cat-brand-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--ember);
            box-shadow: 0 0 8px var(--ember);
        }

        .search-wrap {
            flex: 1;
            max-width: 380px;
            position: relative;
        }

        .search-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--tx-tertiary);
            font-size: 14px;
        }

        .search-wrap input {
            width: 100%;
            background: var(--glass-bg-med);
            border: 1px solid var(--glass-border);
            border-radius: 50px;
            padding: 9px 16px 9px 40px;
            font-family: 'Instrument Sans', sans-serif;
            font-size: 13px;
            color: var(--tx-primary);
            outline: none;
            transition: all .2s var(--ease);
        }

        .search-wrap input::placeholder {
            color: var(--tx-tertiary);
        }

        .search-wrap input:focus {
            border-color: rgba(255, 77, 26, 0.4);
            box-shadow: 0 0 0 3px rgba(255, 77, 26, 0.08);
        }

        .cat-body {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        .cat-content {
            flex: 1;
            padding: 24px;
            overflow-y: auto;
            height: calc(100vh - 64px);
        }

        .filter-row {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            border-radius: 50px;
            border: 1px solid var(--glass-border);
            background: var(--glass-bg);
            color: var(--tx-secondary);
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s var(--ease);
            text-decoration: none;
        }

        .filter-chip:hover {
            background: var(--glass-bg-med);
            color: var(--tx-primary);
        }

        .filter-chip.active {
            background: var(--ember-soft);
            color: var(--ember);
            border-color: rgba(255, 77, 26, 0.3);
        }

        /* Menu grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 14px;
        }

        .menu-card {
            border-radius: var(--r-xl);
            overflow: hidden;
            cursor: pointer;
            transition: all .28s var(--ease);
            position: relative;
        }

        .menu-card:hover:not(.out-of-stock) {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .menu-card.out-of-stock {
            opacity: .45;
            cursor: not-allowed;
        }

        .menu-img {
            height: 150px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-img-bg {
            position: absolute;
            inset: 0;
        }

        .menu-img i {
            font-size: 52px;
            color: rgba(255, 77, 26, 0.35);
            position: relative;
            z-index: 1;
        }

        .menu-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .oos-overlay {
            position: absolute;
            inset: 0;
            background: rgba(10, 10, 12, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .oos-tag {
            background: rgba(255, 80, 80, 0.2);
            border: 1px solid rgba(255, 80, 80, 0.3);
            color: #FF6B6B;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            padding: 5px 12px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .menu-info {
            padding: 14px 16px;
        }

        .menu-name {
            font-family: 'Syne', sans-serif;
            font-size: 14.5px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .menu-desc {
            font-size: 12px;
            color: var(--tx-tertiary);
            line-height: 1.4;
            margin-bottom: 10px;

            display: -webkit-box;
            /* Nécessaire pour le multi-line ellipsis */
            -webkit-line-clamp: 2;
            /* Limite à 2 lignes */
            -webkit-box-orient: vertical;
            /* Orientation verticale pour le clamp */
            overflow: hidden;
            /* Masque le texte qui dépasse */
            text-overflow: ellipsis;
        }

        .menu-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .menu-price {
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 800;
            color: var(--ember);
        }

        .add-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--ember), var(--ember-light));
            border: none;
            color: #fff;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .2s var(--ease);
            box-shadow: 0 4px 12px var(--ember-glow);
            line-height: 1;
        }

        .add-circle:hover {
            transform: scale(1.15);
        }

        .stock-badge-sm {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 50px;
            z-index: 3;
            background: var(--s-wait);
            color: var(--s-wait-tx);
        }

        /* Cart */
        .cart-panel {
            width: 320px;
            background: rgba(10, 10, 12, 0.80);
            backdrop-filter: blur(40px) saturate(200%);
            -webkit-backdrop-filter: blur(40px) saturate(200%);
            border-left: 1px solid var(--glass-border);
            display: flex;
            flex-direction: column;
            height: calc(100vh - 64px);
            position: sticky;
            top: 64px;
        }

        .cart-header {
            padding: 20px 20px 16px;
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-title-txt {
            font-family: 'Syne', sans-serif;
            font-size: 16px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cart-count-badge {
            background: var(--ember);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            min-width: 20px;
            height: 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 6px;
            box-shadow: 0 2px 8px var(--ember-glow);
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 12px;
        }

        .cart-empty {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 40px 20px;
        }

        .cart-empty i {
            font-size: 40px;
            color: var(--tx-muted);
        }

        .cart-empty p {
            font-size: 13px;
            color: var(--tx-tertiary);
            text-align: center;
            line-height: 1.5;
        }

        .cart-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border-radius: var(--r-md);
            margin-bottom: 6px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            transition: background .15s;
        }

        .cart-item:hover {
            background: var(--glass-bg-med);
        }

        .ci-thumb {
            width: 44px;
            height: 44px;
            border-radius: var(--r-sm);
            background: linear-gradient(135deg, rgba(255, 77, 26, 0.2), rgba(255, 122, 82, 0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            border: 1px solid rgba(255, 77, 26, 0.15);
        }

        .ci-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .ci-info {
            flex: 1;
            min-width: 0;
        }

        .ci-name {
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ci-price {
            font-size: 12px;
            color: var(--tx-tertiary);
        }

        .qty-ctrl {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .qty-btn {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 1px solid var(--glass-border);
            background: var(--glass-bg-med);
            color: var(--tx-secondary);
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .15s;
            line-height: 1;
        }

        .qty-btn:hover {
            background: var(--ember-soft);
            color: var(--ember);
            border-color: rgba(255, 77, 26, 0.3);
        }

        .qty-btn:disabled,
        .qty-btn[disabled] {
            opacity: 0.45;
            cursor: not-allowed;
            background: rgba(255, 255, 255, 0.02);
            color: var(--tx-muted);
            border-color: rgba(255, 255, 255, 0.06);
            pointer-events: none;
            transform: none;
            box-shadow: none;
        }

        /* Add-circle (menu card add button) */

        .add-circle:disabled,
        .add-circle[disabled] {
            opacity: 0.45;
            cursor: not-allowed;
            pointer-events: none;
            filter: grayscale(60%);
            background: rgba(255, 255, 255, 0.02);
            color: var(--tx-muted);
            border-color: rgba(255, 255, 255, 0.06);
            transform: none;
            box-shadow: none;
        }

        .qty-num {
            font-size: 13px;
            font-weight: 700;
            min-width: 18px;
            text-align: center;
        }

        .cart-footer {
            padding: 16px;
            border-top: 1px solid var(--glass-border);
        }

        .cs-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: var(--tx-secondary);
            margin-bottom: 6px;
        }

        .cs-total {
            display: flex;
            justify-content: space-between;
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 800;
            padding-top: 8px;
            border-top: 1px solid var(--glass-border);
            margin-top: 8px;
            margin-bottom: 12px;
        }

        .cs-total span:last-child {
            color: var(--ember);
        }

        .btn-order {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--ember), var(--ember-light));
            border: none;
            border-radius: var(--r-md);
            color: #fff;
            font-family: 'Syne', sans-serif;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .25s var(--ease);
            box-shadow: 0 6px 24px var(--ember-glow);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            letter-spacing: .03em;
        }

        .btn-order:hover {
            box-shadow: 0 10px 40px var(--ember-glow);
            transform: translateY(-2px);
        }

        .btn-order:disabled {
            opacity: .4;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Order review */
        .order-review {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: var(--r-lg);
            padding: 14px;
            margin-bottom: 18px;
        }

        .or-item {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            padding: 5px 0;
            color: var(--tx-secondary);
        }

        .or-total {
            display: flex;
            justify-content: space-between;
            font-family: 'Syne', sans-serif;
            font-size: 16px;
            font-weight: 800;
            padding-top: 10px;
            border-top: 1px solid var(--glass-border);
            margin-top: 8px;
        }

        .or-total span:last-child {
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

        @media(max-width:900px) {
            .cart-panel {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="ambient"></div>
    @yield('content')
    @stack('scripts')
</body>

</html>