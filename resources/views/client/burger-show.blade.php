@extends('layouts.client')
@section('title', $burger->name . ' — ISI BURGER')

@push('styles')
    <style>
        /* ── Page layout ── */
        .show-page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            padding: 0 0 60px;
        }

        /* ── Hero ── */
        .show-hero {
            position: relative;
            height: 420px;
            overflow: hidden;
            display: flex;
            align-items: flex-end;
        }

        .show-hero-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .6s var(--ease);
        }

        .show-hero-img:hover {
            transform: scale(1.04);
        }

        .show-hero-placeholder {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 77, 26, 0.18), rgba(10, 10, 12, 0.9));
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .show-hero-placeholder i {
            font-size: 100px;
            color: rgba(255, 77, 26, 0.25);
        }

        .show-hero-gradient {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(10, 10, 12, 0.98) 0%, rgba(10, 10, 12, 0.4) 50%, transparent 100%);
        }

        .show-hero-content {
            position: relative;
            z-index: 2;
            width: 100%;
            padding: 28px 40px;
        }

        /* ── Back btn ── */
        .back-btn {
            position: absolute;
            top: 20px;
            left: 24px;
            z-index: 10;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: var(--r-md);
            background: rgba(10, 10, 12, 0.65);
            border: 1px solid var(--glass-border);
            color: var(--tx-secondary);
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            backdrop-filter: blur(16px);
            transition: all .2s var(--ease);
        }

        .back-btn:hover {
            background: rgba(10, 10, 12, 0.85);
            color: var(--tx-primary);
        }

        /* ── Main content ── */
        .show-body {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ── Info card ── */
        .show-info-card {
            margin-top: -60px;
            position: relative;
            z-index: 3;
            border-radius: var(--r-2xl);
            padding: 28px 32px;
            margin-bottom: 24px;
        }

        .show-name {
            font-family: 'Syne', sans-serif;
            font-size: 32px;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 10px;
        }

        .show-price {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: var(--ember);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .show-desc {
            font-size: 14px;
            color: var(--tx-secondary);
            line-height: 1.7;
            margin-bottom: 20px;
        }

        /* ── Stock badge ── */
        .stock-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
        }

        .stock-tag.ok {
            background: var(--s-ready);
            color: var(--s-ready-tx);
            border: 1px solid rgba(0, 230, 130, 0.2);
        }

        .stock-tag.low {
            background: var(--s-wait);
            color: var(--s-wait-tx);
            border: 1px solid rgba(255, 196, 0, 0.2);
        }

        .stock-tag.none {
            background: rgba(255, 80, 80, 0.12);
            color: #FF6B6B;
            border: 1px solid rgba(255, 80, 80, 0.2);
        }

        /* ── Qty selector ── */
        .qty-selector {
            display: flex;
            align-items: center;
            background: var(--glass-bg-med);
            border: 1px solid var(--glass-border);
            border-radius: var(--r-md);
            overflow: hidden;
            width: fit-content;
        }

        .qty-selector button {
            width: 42px;
            height: 42px;
            border: none;
            background: transparent;
            color: var(--tx-secondary);
            font-size: 18px;
            cursor: pointer;
            transition: all .2s var(--ease);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-selector button:hover:not(:disabled) {
            background: var(--ember-soft);
            color: var(--ember);
        }

        .qty-selector button:disabled {
            opacity: .3;
            cursor: not-allowed;
        }

        .qty-selector span {
            min-width: 48px;
            text-align: center;
            font-family: 'Syne', sans-serif;
            font-size: 16px;
            font-weight: 800;
            color: var(--tx-primary);
            border-left: 1px solid var(--glass-border);
            border-right: 1px solid var(--glass-border);
            padding: 0 8px;
            line-height: 42px;
        }

        /* ── Add to cart btn ── */
        .btn-add-cart {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 28px;
            border-radius: var(--r-md);
            background: linear-gradient(135deg, var(--ember), var(--ember-light));
            color: #fff;
            border: none;
            font-family: 'Syne', sans-serif;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .25s var(--ease);
            box-shadow: 0 6px 24px var(--ember-glow);
            letter-spacing: .02em;
        }

        .btn-add-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 36px var(--ember-glow);
        }

        .btn-add-cart:active {
            transform: translateY(0);
        }

        .btn-add-cart:disabled {
            opacity: .4;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* ── Toast ── */
        .toast {
            position: fixed;
            bottom: 28px;
            left: 50%;
            transform: translateX(-50%) translateY(80px);
            background: rgba(10, 10, 12, 0.92);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border-hi);
            border-radius: var(--r-xl);
            padding: 12px 22px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 600;
            color: var(--tx-primary);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.5);
            transition: transform .35s var(--ease), opacity .35s;
            opacity: 0;
            z-index: 999;
            white-space: nowrap;
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        .toast i {
            color: var(--s-ready-tx);
            font-size: 16px;
        }

        /* ── Related ── */
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 14px;
        }

        .related-card {
            border-radius: var(--r-xl);
            overflow: hidden;
            text-decoration: none;
            transition: all .28s var(--ease);
            display: block;
        }

        .related-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5);
        }

        .related-card:hover .related-name {
            color: var(--ember);
        }

        .related-img {
            height: 120px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(255, 77, 26, 0.15), rgba(10, 10, 12, 0.8));
        }

        .related-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .related-img i {
            font-size: 40px;
            color: rgba(255, 77, 26, 0.3);
        }

        .related-info {
            padding: 12px 14px;
        }

        .related-name {
            font-family: 'Syne', sans-serif;
            font-size: 13.5px;
            font-weight: 700;
            margin-bottom: 4px;
            transition: color .2s;
            color: var(--tx-primary);
        }

        .related-price {
            font-size: 13px;
            font-weight: 700;
            color: var(--ember);
        }

        /* ── Section label ── */
        .section-label {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--glass-border);
        }

        @media (max-width: 640px) {
            .show-hero {
                height: 280px;
            }

            .show-hero-content {
                padding: 20px;
            }

            .show-name {
                font-size: 24px;
            }

            .show-info-card {
                padding: 20px;
                margin-top: -40px;
            }

            .show-body {
                padding: 0 16px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="show-page">

        <!-- ── Back ── -->
        <a href="{{ route('catalogue') }}" class="back-btn">
            <i class="bi bi-arrow-left"></i>Retour au menu
        </a>

        <!-- ── Hero ── -->
        <div class="show-hero">
            @if($burger->image)
                <img class="show-hero-img" src="{{ Storage::url($burger->image) }}" alt="{{ $burger->name }}">
            @else
                <div class="show-hero-placeholder">
                    <i class="bi bi-layers-half"></i>
                </div>
            @endif
            <div class="show-hero-gradient"></div>
            <div class="show-hero-content">
                <div class="show-body" style="padding:0;">
                    <div style="display:flex;gap:8px;align-items:center;margin-bottom:10px;">
                        @if(!$burger->available || $burger->stock <= 0)
                            <span class="stock-tag none"><i class="bi bi-x-circle"></i>Rupture de stock</span>
                        @elseif($burger->stock <= 5)
                            <span class="stock-tag low"><i class="bi bi-exclamation-triangle"></i>Plus que {{ $burger->stock }}
                                restants</span>
                        @else
                            <span class="stock-tag ok"><i class="bi bi-check-circle"></i>Disponible</span>
                        @endif
                    </div>
                    <h1 class="show-name">{{ $burger->name }}</h1>
                </div>
            </div>
        </div>

        <!-- ── Body ── -->
        <div class="show-body">

            <!-- Info card -->
            <div class="show-info-card glass-high">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:16px;">

                    <!-- Gauche : prix + desc -->
                    <div style="flex:1;min-width:260px;">
                        <div class="show-price">
                            {{ number_format($burger->price, 0, ',', ' ') }}
                            <span style="font-size:16px;font-weight:500;color:var(--tx-tertiary);">FCFA</span>
                        </div>
                        @if($burger->description)
                            <p class="show-desc">{{ $burger->description }}</p>
                        @else
                            <p class="show-desc" style="color:var(--tx-muted);font-style:italic;">Aucune description disponible.
                            </p>
                        @endif
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
                            <i class="bi bi-archive" style="color:var(--tx-muted);font-size:13px;"></i>
                            <span style="font-size:13px;color:var(--tx-tertiary);">
                                @if($burger->stock <= 0)
                                    Stock épuisé
                                @else
                                    <strong style="color:var(--tx-secondary);">{{ $burger->stock }}</strong> unités en stock
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Droite : actions -->
                    @if($burger->available && $burger->stock > 0)
                        <div style="display:flex;flex-direction:column;gap:14px;align-items:flex-start;">
                            <div>
                                <div
                                    style="font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--tx-muted);margin-bottom:8px;">
                                    Quantité</div>
                                <div class="qty-selector">
                                    <button type="button" id="btnMinus" onclick="changeQty(-1)" disabled>−</button>
                                    <span id="qtyDisplay">1</span>
                                    <button type="button" id="btnPlus" onclick="changeQty(1)">+</button>
                                </div>
                            </div>
                            <button class="btn-add-cart" id="btnAddCart"
                                onclick="addToCart('{{ addslashes($burger->name) }}', {{ $burger->price }}, '{{ $burger->image ? Storage::url($burger->image) : '' }}')">
                                <i class="bi bi-bag-plus-fill"></i>
                                Ajouter au panier — <span id="btnTotal">{{ number_format($burger->price, 0, ',', ' ') }}
                                    F</span>
                            </button>
                        </div>
                    @else
                        <div
                            style="display:flex;flex-direction:column;align-items:center;gap:10px;padding:16px 24px;border-radius:var(--r-lg);background:rgba(255,80,80,0.06);border:1px solid rgba(255,80,80,0.15);">
                            <i class="bi bi-x-circle" style="font-size:28px;color:rgba(255,80,80,0.5);"></i>
                            <span style="font-size:13px;color:#FF6B6B;font-weight:600;">Indisponible</span>
                        </div>
                    @endif

                </div>

                <!-- Paiement info -->
                <div
                    style="margin-top:20px;padding:12px 16px;border-radius:var(--r-lg);background:var(--glass-bg);border:1px solid var(--glass-border);display:flex;align-items:center;gap:10px;font-size:13px;color:var(--tx-tertiary);">
                    <i class="bi bi-cash-coin" style="color:var(--ember);font-size:16px;"></i>
                    Paiement en <strong style="color:var(--tx-secondary);">espèces</strong> uniquement au comptoir
                    <span style="margin-left:auto;font-size:11px;opacity:.6;">ISI BURGER · Dakar</span>
                </div>
            </div>

            <!-- Burgers similaires -->
            @if($related->count() > 0)
                <div style="margin-top:8px;">
                    <div class="section-label">
                        <i class="bi bi-grid-3x3-gap" style="color:var(--ember);"></i>
                        Vous aimerez aussi
                    </div>
                    <div class="related-grid">
                        @foreach($related as $r)
                            <a href="{{ route('burger.show', $r->id) }}" class="related-card glass-med">
                                <div class="related-img">
                                    @if($r->image)
                                        <img src="{{ Storage::url($r->image) }}" alt="{{ $r->name }}">
                                    @else
                                        <i class="bi bi-layers-half"></i>
                                    @endif
                                    @if(!$r->available || $r->stock <= 0)
                                        <div
                                            style="position:absolute;inset:0;background:rgba(10,10,12,0.65);display:flex;align-items:center;justify-content:center;">
                                            <span
                                                style="font-size:10px;font-weight:700;color:#FF6B6B;background:rgba(255,80,80,0.2);padding:3px 10px;border-radius:50px;border:1px solid rgba(255,80,80,0.3);">Rupture</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="related-info">
                                    <div class="related-name">{{ $r->name }}</div>
                                    <div class="related-price">{{ number_format($r->price, 0, ',', ' ') }} F</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast">
        <i class="bi bi-bag-check-fill"></i>
        <span id="toastMsg">Ajouté au panier !</span>
    </div>
@endsection

@push('scripts')
    <script>
        const MAX_STOCK = {{ $burger->stock }};
        const PRICE = {{ $burger->price }};
        let qty = 1;

        function changeQty(delta) {
            qty = Math.max(1, Math.min(MAX_STOCK, qty + delta));
            document.getElementById('qtyDisplay').textContent = qty;
            document.getElementById('btnMinus').disabled = qty <= 1;
            document.getElementById('btnPlus').disabled = qty >= MAX_STOCK;
            document.getElementById('btnTotal').textContent =
                (PRICE * qty).toLocaleString('fr-FR') + ' F';
        }

        function addToCart(name, price, img) {
            const existing = JSON.parse(localStorage.getItem('isiCart') || '{}');
            if (existing[name]) {
                existing[name].qty = Math.min(MAX_STOCK, existing[name].qty + qty);
            } else {
                existing[name] = { price, qty, img, max: MAX_STOCK };
            }
            localStorage.setItem('isiCart', JSON.stringify(existing));

            // Toast
            const toastEl = document.getElementById('toast');
            document.getElementById('toastMsg').textContent =
                qty + '× ' + name + ' ajouté' + (qty > 1 ? 's' : '') + ' au panier !';
            toastEl.classList.add('show');
            setTimeout(() => toastEl.classList.remove('show'), 2800);

            // Bouton feedback
            const btn = document.getElementById('btnAddCart');
            btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Ajouté !';
            btn.style.background = 'linear-gradient(135deg,#00c97a,#00e682)';
            setTimeout(() => {
                btn.innerHTML = `<i class="bi bi-bag-plus-fill"></i> Ajouter au panier — <span id="btnTotal">${(PRICE * qty).toLocaleString('fr-FR')} F</span>`;
                btn.style.background = '';
            }, 2000);
        }

        document.addEventListener('DOMContentLoaded', () => changeQty(0));
    </script>
@endpush