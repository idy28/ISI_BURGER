@extends('layouts.client')
@section('title', 'ISI BURGER — Nos Burgers')

@push('styles')
  <style>
    /* ── Options select lisibles ── */
    #sortSelect option {
      background: #0A0A0C;
      color: #FF7A52;
    }

    /* ── Filter bar ── */
    .filter-bar {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 8px;
      padding: 12px 16px;
      border-radius: var(--r-xl);
      margin-bottom: 20px;
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      backdrop-filter: blur(20px);
    }

    /* ── Price inputs ── */
    .price-input-wrap {
      position: relative;
      display: flex;
      align-items: center;
    }

    .price-input-wrap i {
      position: absolute;
      left: 11px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 11px;
      pointer-events: none;
      z-index: 1;
    }

    .price-input-wrap input {
      width: 100px;
      padding: 8px 10px 8px 26px;
      border-radius: var(--r-md);
      font-size: 12.5px;
      font-weight: 600;
      background: var(--glass-bg-med);
      border: 1px solid var(--glass-border);
      color: var(--tx-primary);
      outline: none;
      transition: all .2s var(--ease);
      font-family: 'Instrument Sans', sans-serif;
    }

    .price-input-wrap input::placeholder {
      color: var(--tx-muted);
    }

    .price-input-wrap input:focus {
      border-color: rgba(255, 77, 26, 0.5);
      background: var(--glass-bg-high);
      box-shadow: 0 0 0 3px rgba(255, 77, 26, 0.1);
    }

    .price-input-wrap input:not(:placeholder-shown) {
      border-color: rgba(255, 77, 26, 0.35);
      color: var(--ember);
    }

    /* Séparateur — */
    .price-sep {
      font-size: 13px;
      font-weight: 700;
      color: var(--tx-muted);
      flex-shrink: 0;
      padding: 0 2px;
    }

    /* ── Btn appliquer compact ── */
    .btn-apply {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      border-radius: var(--r-md);
      background: linear-gradient(135deg, var(--ember), var(--ember-light));
      color: #fff;
      border: none;
      font-family: 'Instrument Sans', sans-serif;
      font-size: 12.5px;
      font-weight: 700;
      cursor: pointer;
      transition: all .2s var(--ease);
      box-shadow: 0 3px 12px var(--ember-glow);
      white-space: nowrap;
    }

    .btn-apply:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 20px var(--ember-glow);
    }

    .btn-apply:active {
      transform: translateY(0);
    }

    /* ── Sort select ── */
    .sort-select {
      appearance: none;
      padding: 8px 14px;
      border-radius: var(--r-md);
      background: var(--glass-bg-med);
      border: 1px solid var(--glass-border);
      color: var(--tx-secondary);
      font-family: 'Instrument Sans', sans-serif;
      font-size: 12.5px;
      font-weight: 500;
      cursor: pointer;
      outline: none;
      transition: all .2s var(--ease);
    }

    .sort-select:focus,
    .sort-select:hover {
      border-color: var(--glass-border-hi);
      color: var(--tx-primary);
      background: var(--glass-bg-high);
    }

    /* ── Reset btn ── */
    .btn-reset {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 8px 14px;
      border-radius: var(--r-md);
      background: rgba(255, 80, 80, 0.08);
      border: 1px solid rgba(255, 80, 80, 0.18);
      color: #FF6B6B;
      font-family: 'Instrument Sans', sans-serif;
      font-size: 12.5px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      transition: all .2s var(--ease);
      white-space: nowrap;
    }

    .btn-reset:hover {
      background: rgba(255, 80, 80, 0.15);
      border-color: rgba(255, 80, 80, 0.3);
      color: #ff4f4f;
    }

    /* ── Divider vertical ── */
    .filter-divider {
      width: 1px;
      height: 22px;
      background: var(--glass-border);
      flex-shrink: 0;
    }

    /* ── Active price indicator ── */
    .price-active-badge {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      padding: 3px 9px;
      border-radius: 50px;
      background: var(--ember-soft);
      border: 1px solid rgba(255, 77, 26, 0.25);
      color: var(--ember);
      font-size: 11px;
      font-weight: 700;
    }

    /* ── Pagination ── */
    .pag-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      border-radius: var(--r-md);
      font-family: 'Instrument Sans', sans-serif;
      font-size: 12px;
      font-weight: 600;
      text-decoration: none;
      transition: all .2s var(--ease);
      white-space: nowrap;
      border: 1px solid var(--glass-border);
    }

    .pag-btn.active-nav {
      background: var(--glass-bg-med);
      color: var(--tx-secondary);
      backdrop-filter: blur(12px);
    }

    .pag-btn.active-nav:hover {
      background: var(--glass-bg-high);
      color: var(--tx-primary);
      border-color: var(--glass-border-hi);
    }

    .pag-btn.disabled-nav {
      background: transparent;
      border-color: rgba(255, 255, 255, 0.05);
      color: var(--tx-muted);
      cursor: not-allowed;
      pointer-events: none;
    }

    .pag-num {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 34px;
      height: 34px;
      border-radius: var(--r-md);
      font-size: 12px;
      font-weight: 700;
      text-decoration: none;
      transition: all .2s var(--ease);
      border: 1px solid var(--glass-border);
      flex-shrink: 0;
    }

    .pag-num.current {
      background: linear-gradient(135deg, var(--ember), var(--ember-light));
      color: #fff;
      border: none;
      box-shadow: 0 4px 14px var(--ember-glow);
    }

    .pag-num.other {
      background: var(--glass-bg-med);
      color: var(--tx-secondary);
      backdrop-filter: blur(12px);
    }

    .pag-num.other:hover {
      background: var(--ember-soft);
      color: var(--ember);
      border-color: rgba(255, 77, 26, 0.3);
    }

    /* ── Detail btn ── */
    .detail-btn {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background: var(--glass-bg-med);
      border: 1px solid var(--glass-border);
      color: var(--tx-secondary);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all .2s var(--ease);
      font-size: 13px;
      flex-shrink: 0;
    }

    .detail-btn:hover {
      background: var(--ember-soft);
      color: var(--ember);
      border-color: rgba(255, 77, 26, 0.3);
    }

    /* ── Burger detail modal ── */
    .detail-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.8);
      backdrop-filter: blur(14px);
      z-index: 1100;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      opacity: 0;
      pointer-events: none;
      transition: opacity .28s var(--ease);
    }

    .detail-overlay.open {
      opacity: 1;
      pointer-events: all;
    }

    .detail-modal {
      width: 100%;
      max-width: 560px;
      border-radius: var(--r-2xl);
      overflow: hidden;
      transform: scale(0.93) translateY(12px);
      transition: transform .3s var(--ease);
      background: var(--glass-bg-high);
      backdrop-filter: blur(40px) saturate(200%);
      -webkit-backdrop-filter: blur(40px) saturate(200%);
      border: 1px solid var(--glass-border-hi);
      box-shadow: 0 32px 80px rgba(0, 0, 0, 0.6);
    }

    .detail-overlay.open .detail-modal {
      transform: scale(1) translateY(0);
    }

    /* Hero image de la modal */
    .detail-hero {
      height: 240px;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: flex-end;
    }

    .detail-hero img {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .detail-hero-placeholder {
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255, 77, 26, 0.2), rgba(10, 10, 12, 0.9));
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .detail-hero-placeholder i {
      font-size: 72px;
      color: rgba(255, 77, 26, 0.25);
    }

    .detail-hero-gradient {
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(10, 10, 12, 0.95) 0%, transparent 60%);
    }

    .detail-hero-close {
      position: absolute;
      top: 12px;
      right: 12px;
      z-index: 2;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: rgba(10, 10, 12, 0.7);
      border: 1px solid var(--glass-border);
      color: var(--tx-secondary);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      backdrop-filter: blur(12px);
      font-size: 14px;
      transition: all .2s;
    }

    .detail-hero-close:hover {
      background: rgba(255, 80, 80, 0.2);
      color: #FF6B6B;
      border-color: rgba(255, 80, 80, 0.3);
    }

    .detail-hero-badge {
      position: relative;
      z-index: 2;
      padding: 0 20px 16px;
    }

    /* Body de la modal */
    .detail-body {
      padding: 20px 24px 24px;
    }

    .detail-title {
      font-family: 'Syne', sans-serif;
      font-size: 22px;
      font-weight: 900;
      margin-bottom: 6px;
    }

    .detail-price {
      font-family: 'Syne', sans-serif;
      font-size: 22px;
      font-weight: 800;
      color: var(--ember);
      margin-bottom: 12px;
    }

    .detail-desc {
      font-size: 13.5px;
      color: var(--tx-secondary);
      line-height: 1.7;
      margin-bottom: 16px;
      padding-bottom: 16px;
      border-bottom: 1px solid var(--glass-border);
    }

    .detail-stock-row {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      color: var(--tx-tertiary);
      margin-bottom: 18px;
    }

    .detail-actions {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    /* Qty inline dans la modal */
    .detail-qty {
      display: flex;
      align-items: center;
      background: var(--glass-bg-med);
      border: 1px solid var(--glass-border);
      border-radius: var(--r-md);
      overflow: hidden;
    }

    .detail-qty button {
      width: 38px;
      height: 38px;
      border: none;
      background: transparent;
      color: var(--tx-secondary);
      font-size: 16px;
      cursor: pointer;
      transition: all .15s;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .detail-qty button:hover:not(:disabled) {
      background: var(--ember-soft);
      color: var(--ember);
    }

    .detail-qty button:disabled {
      opacity: .28;
      cursor: not-allowed;
    }

    .detail-qty span {
      min-width: 36px;
      text-align: center;
      font-family: 'Syne', sans-serif;
      font-size: 15px;
      font-weight: 800;
      color: var(--tx-primary);
      border-left: 1px solid var(--glass-border);
      border-right: 1px solid var(--glass-border);
      line-height: 38px;
    }

    .detail-add-btn {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 0 20px;
      height: 38px;
      border-radius: var(--r-md);
      background: linear-gradient(135deg, var(--ember), var(--ember-light));
      color: #fff;
      border: none;
      font-family: 'Syne', sans-serif;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      transition: all .22s var(--ease);
      box-shadow: 0 4px 16px var(--ember-glow);
    }

    .detail-add-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 24px var(--ember-glow);
    }

    .detail-add-btn:disabled {
      opacity: .4;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }
  </style>
@endpush

@section('content')
  <div class="cat-layout">
    <div class="cat-main">

      <!-- ── Header ── -->
      <header class="cat-header">
        <div class="cat-brand">
          <div
            style="width:30px;height:30px;background:linear-gradient(135deg,var(--ember),var(--ember-light));border-radius:8px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px var(--ember-glow);">
            <i class="bi bi-layers-half" style="color:#fff;font-size:14px;"></i>
          </div>
          ISI BURGER
          <div class="cat-brand-dot"></div>
        </div>
        <div class="search-wrap">
          <i class="bi bi-search"></i>
          <input type="text" id="searchInput" name="search" placeholder="Rechercher parmi nos burgers…"
            value="{{ request('search') }}" oninput="liveSearch(this.value)">
        </div>
        <div style="margin-left:auto;font-size:12px;color:var(--tx-tertiary);display:flex;align-items:center;gap:6px;">
          <i class="bi bi-geo-alt-fill" style="color:var(--ember);"></i>Dakar — Commander ici
        </div>
      </header>

      <div class="cat-body">
        <div class="cat-content">

          @error('stock')
            <div
              style="padding:10px 14px;border-radius:var(--r-md);margin-bottom:16px;display:flex;align-items:center;gap:8px;font-size:13px;background:rgba(255,80,80,0.12);color:#FF6B6B;border:1px solid rgba(255,80,80,0.2);">
              <i class="bi bi-x-circle-fill"></i>{{ $message }}
            </div>
          @enderror

          <!-- Titre section -->
          <div style="margin-bottom:20px;display:flex;align-items:flex-end;justify-content:space-between;">
            <div>
              <div style="font-family:'Syne',sans-serif;font-size:24px;font-weight:900;margin-bottom:3px;">Nos Burgers
              </div>
              <div style="font-size:13px;color:var(--tx-tertiary);">
                Sélection artisanale — préparée à la commande
                @if($burgers->total() > 0)
                  <span
                    style="margin-left:8px;padding:2px 8px;border-radius:50px;background:var(--ember-soft);color:var(--ember);font-size:11px;font-weight:700;">
                    {{ $burgers->total() }} burger{{ $burgers->total() > 1 ? 's' : '' }}
                  </span>
                @endif
              </div>
            </div>
          </div>

          <!-- ── Filtres : une seule ligne ── -->
          <form method="GET" action="{{ route('catalogue') }}" id="filterForm">
            <div class="filter-row" style="flex-wrap:wrap;gap:8px;margin-bottom:20px;align-items:center;">

              {{-- Chips dispo --}}
              <a class="filter-chip active" id="filterAll" onclick="filterByAvail('all',this)">
                <i class="bi bi-grid-3x3-gap"></i>Tout le menu
              </a>
              <a class="filter-chip" onclick="filterByAvail('dispo',this)">
                <i class="bi bi-check-circle"></i>Disponibles
              </a>

              {{-- 🏷 Min --}}
              <div class="price-input-wrap">
                <i class="bi bi-tag" style="color:var(--tx-tertiary);"></i>
                <input type="number" name="min_price" id="minPrice" placeholder="Min F" value="{{ request('min_price') }}"
                  min="0" max="{{ $maxPrice }}" title="Prix minimum">
              </div>

              <span class="price-sep">—</span>

              {{-- 🏷 Max --}}
              <div class="price-input-wrap">
                <i class="bi bi-tag-fill" style="color:var(--ember);"></i>
                <input type="number" name="max_price" id="maxPrice" placeholder="Max F"
                  value="{{ request('max_price', $maxPrice) }}" min="0" max="{{ $maxPrice }}" title="Prix maximum">
              </div>

              {{-- Appliquer --}}
              <button type="submit" class="btn-apply">
                <i class="bi bi-check2"></i>Appliquer
              </button>

              {{-- Reset (visible si filtre actif) --}}
              @if(request('min_price') || (request('max_price') && request('max_price') != $maxPrice))
                <a href="{{ route('catalogue') }}" class="btn-reset">
                  <i class="bi bi-x-lg"></i>Reset
                </a>
              @endif

              {{-- Trier repoussé à droite --}}
              <div style="margin-left:auto;">
                <select class="sort-select" id="sortSelect" onchange="sortMenu(this.value)">
                  <option value="">Trier : Par défaut</option>
                  <option value="asc">Prix croissant</option>
                  <option value="desc">Prix décroissant</option>
                </select>
              </div>

            </div>
          </form>

          <!-- ══════════════════════════════
                                       GRILLE BURGERS
                                  ══════════════════════════════ -->
          <div class="menu-grid" id="menuGrid">
            @forelse($burgers as $burger)
              <div class="menu-card glass-med {{ !$burger->available || $burger->stock <= 0 ? 'out-of-stock' : '' }}"
                data-name="{{ strtolower($burger->name) }}" data-prix="{{ $burger->price }}"
                data-stock="{{ $burger->stock }}" data-dispo="{{ $burger->available && $burger->stock > 0 ? '1' : '0' }}"
                onclick="openDetail(
                                                                  '{{ addslashes($burger->name) }}',
                                                                  {{ $burger->price }},
                                                                  '{{ addslashes($burger->description ?? '') }}',
                                                                  '{{ $burger->image ? Storage::url($burger->image) : '' }}',
                                                                  {{ $burger->stock }},
                                                                  {{ $burger->available ? 'true' : 'false' }}
                                                                )" style="cursor:pointer;" title="Voir les détails">

                <div class="menu-img" style="position:relative;">
                  <div class="menu-img-bg"
                    style="background:linear-gradient(135deg,rgba(255,77,26,0.18),rgba(255,122,82,0.05));"></div>
                  @if($burger->image)
                    <img src="{{ Storage::url($burger->image) }}" alt="{{ $burger->name }}">
                  @else
                    <i class="bi bi-layers-half"></i>
                  @endif
                  @if($burger->stock > 0 && $burger->stock <= 5)
                    <span class="stock-badge-sm">
                      <i class="bi bi-exclamation-triangle" style="font-size:9px;margin-right:2px;"></i>{{ $burger->stock }}
                      restants
                    </span>
                  @endif
                  @if(!$burger->available || $burger->stock <= 0)
                    <div class="oos-overlay">
                      <div class="oos-tag"><i class="bi bi-x-circle"></i>Rupture de stock</div>
                    </div>
                  @endif
                </div>

                <div class="menu-info">
                  <div class="menu-name">{{ $burger->name }}</div>
                  <div class="menu-desc">{{ $burger->description ?? '' }}</div>
                  <div class="menu-footer">
                    <span class="menu-price">{{ number_format($burger->price, 0, ',', ' ') }} F</span>
                    <div style="display:flex;gap:6px;align-items:center;">
                      <!-- <button class="detail-btn" onclick="openDetail(
                                                                          '{{ addslashes($burger->name) }}',
                                                                          {{ $burger->price }},
                                                                          '{{ addslashes($burger->description ?? '') }}',
                                                                          '{{ $burger->image ? Storage::url($burger->image) : '' }}',
                                                                          {{ $burger->stock }},
                                                                          {{ $burger->available ? 'true' : 'false' }}
                                                                        )" title="Voir les détails">
                                                                <i class="bi bi-eye"></i>
                                                              </button> -->
                      @if($burger->available && $burger->stock > 0)
                        <button class="add-circle"
                          onclick="event.stopPropagation(); addItem('{{ addslashes($burger->name) }}', {{ $burger->price }}, '{{ $burger->image ? Storage::url($burger->image) : '' }}')">
                          <i class="bi bi-plus" style="font-size:16px;"></i>
                        </button>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div style="grid-column:1/-1;text-align:center;padding:60px 20px;color:var(--tx-muted);">
                <i class="bi bi-search" style="font-size:40px;display:block;margin-bottom:14px;opacity:.5;"></i>
                <div
                  style="font-family:'Syne',sans-serif;font-size:16px;font-weight:700;margin-bottom:6px;color:var(--tx-secondary);">
                  Aucun burger trouvé</div>
                <div style="font-size:13px;margin-bottom:16px;">Essayez d'élargir votre fourchette de prix</div>
                <a href="{{ route('catalogue') }}"
                  style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:var(--r-md);background:var(--ember-soft);border:1px solid rgba(255,77,26,0.25);color:var(--ember);font-size:13px;font-weight:600;text-decoration:none;">
                  <i class="bi bi-arrow-counterclockwise"></i>Réinitialiser
                </a>
              </div>
            @endforelse
          </div>

          <!-- ══════════════════════════════
                                       PAGINATION
                                  ══════════════════════════════ -->
          @if($burgers->hasPages())
            <div
              style="display:flex;flex-direction:column;align-items:center;gap:10px;margin-top:36px;padding-bottom:12px;">

              <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;justify-content:center;">

                {{-- ← Précédent --}}
                @if($burgers->onFirstPage())
                  <span class="pag-btn disabled-nav"><i class="bi bi-chevron-left"></i>Précédent</span>
                @else
                  <a href="{{ $burgers->previousPageUrl() }}" class="pag-btn active-nav">
                    <i class="bi bi-chevron-left"></i>Précédent
                  </a>
                @endif

                {{-- Numéros --}}
                @foreach($burgers->getUrlRange(1, $burgers->lastPage()) as $page => $url)
                  @if($page == $burgers->currentPage())
                    <span class="pag-num current">{{ $page }}</span>
                  @else
                    <a href="{{ $url }}" class="pag-num other">{{ $page }}</a>
                  @endif
                @endforeach

                {{-- Suivant → --}}
                @if($burgers->hasMorePages())
                  <a href="{{ $burgers->nextPageUrl() }}" class="pag-btn active-nav">
                    Suivant<i class="bi bi-chevron-right"></i>
                  </a>
                @else
                  <span class="pag-btn disabled-nav">Suivant<i class="bi bi-chevron-right"></i></span>
                @endif

              </div>

              {{-- Compteur --}}
              <div style="font-size:12px;color:var(--tx-muted);">
                Affichage <strong
                  style="color:var(--tx-secondary);">{{ $burgers->firstItem() }}–{{ $burgers->lastItem() }}</strong>
                sur <strong style="color:var(--tx-secondary);">{{ $burgers->total() }}</strong> burgers
              </div>

            </div>
          @endif

        </div>

        <!-- ══════════════════════════════
                                     CART PANEL
                                ══════════════════════════════ -->
        <div class="cart-panel">
          <div class="cart-header">
            <div class="cart-title-txt">
              <i class="bi bi-bag-check-fill" style="color:var(--ember);font-size:18px;"></i>
              Ma commande
              <div class="cart-count-badge" id="cartBadge">0</div>
            </div>
            <button class="btn-icon" onclick="clearCart()" title="Vider le panier"><i class="bi bi-trash3"></i></button>
          </div>
          <div class="cart-items" id="cartItems">
            <div class="cart-empty" id="cartEmpty">
              <i class="bi bi-bag-x"></i>
              <p>Votre panier est vide.<br>Ajoutez des burgers !</p>
            </div>
          </div>
          <div class="cart-footer">
            <div id="cartSummary" style="display:none;">
              <div class="cs-row"><span>Sous-total</span><span id="cartSubtotal">0 F</span></div>
              <div class="cs-total"><span>Total</span><span id="cartTotal">0 F</span></div>
            </div>
            <button class="btn-order" id="btnOrder" disabled onclick="openOrderModal()">
              <i class="bi bi-bag-check-fill"></i> Commander
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════
                               MODAL DÉTAIL BURGER
                          ══════════════════════════════ -->
  <div class="detail-overlay" id="detailModal">
    <div class="detail-modal">

      <!-- Hero -->
      <div class="detail-hero" id="detailHero">
        <div class="detail-hero-placeholder" id="detailPlaceholder">
          <i class="bi bi-layers-half"></i>
        </div>
        <img id="detailImg" src="" alt="" style="display:none;">
        <div class="detail-hero-gradient"></div>
        <button class="detail-hero-close" onclick="closeDetail()">
          <i class="bi bi-x-lg"></i>
        </button>
        <div class="detail-hero-badge">
          <span id="detailBadge"></span>
        </div>
      </div>

      <!-- Body -->
      <div class="detail-body">
        <div class="detail-title" id="detailTitle"></div>
        <div class="detail-price" id="detailPrice"></div>
        <div class="detail-desc" id="detailDesc"></div>
        <div class="detail-stock-row">
          <i class="bi bi-archive" style="color:var(--tx-muted);"></i>
          <span id="detailStock"></span>
        </div>
        <div class="detail-actions" id="detailActions"></div>
      </div>

    </div>
  </div>

  <!-- ══════════════════════════════
                               MODAL COMMANDE
                          ══════════════════════════════ -->
  <div class="modal-overlay" id="orderModal">
    <div class="modal-box glass-high">
      <div class="modal-header">
        <h3>Confirmer la commande</h3>
        <button class="btn-icon" onclick="closeOrderModal()"><i class="bi bi-x-lg"></i></button>
      </div>
      <div class="modal-body">
        <div class="order-review" id="modalReview"></div>
        <form id="orderForm" method="POST" action="{{ route('orders.store') }}">
          @csrf
          <div id="cartItemsInput"></div>
          <div class="field-group">
            <label class="field-label">Nom complet <span style="color:var(--ember)">*</span></label>
            <div style="position:relative;">
              <i class="bi bi-person"
                style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--tx-tertiary);"></i>
              <input class="field" id="cName" name="customer_name" placeholder="Prénom et Nom" style="padding-left:40px;"
                required>
            </div>
            @error('customer_name')
              <span style="font-size:11px;color:#FF6B6B;margin-top:4px;display:block;"><i
                  class="bi bi-exclamation-circle"></i> {{ $message }}</span>
            @enderror
          </div>
          <div class="field-group">
            <label class="field-label">Téléphone <span style="color:var(--ember)">*</span></label>
            <div style="position:relative;">
              <i class="bi bi-telephone"
                style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--tx-tertiary);"></i>
              <input class="field" id="cPhone" name="customer_phone" placeholder="7X XXX XX XX" style="padding-left:40px;"
                required>
            </div>
            @error('customer_phone')
              <span style="font-size:11px;color:#FF6B6B;margin-top:4px;display:block;"><i
                  class="bi bi-exclamation-circle"></i> {{ $message }}</span>
            @enderror
          </div>
          <div class="field-group" style="margin-bottom:0;">
            <label class="field-label">Notes (optionnel)</label>
            <textarea class="field" name="notes" rows="2" placeholder="Sans oignons, extra sauce…"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn-ghost" onclick="closeOrderModal()"><i class="bi bi-chevron-left"></i>Modifier</button>
        <button class="btn-ember" style="flex:1;justify-content:center;" onclick="submitOrder()">
          <i class="bi bi-check-circle-fill"></i>Passer la commande
        </button>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>

    /* ══════════════════════
       MODAL DÉTAIL BURGER
    ══════════════════════ */
    let detailQty = 1;
    let detailMax = 0;
    let detailData = {};

    function openDetail(name, price, desc, img, stock, available) {
      detailQty = 1;
      detailMax = stock;
      detailData = { name, price, img };

      // Image
      const imgEl = document.getElementById('detailImg');
      const ph = document.getElementById('detailPlaceholder');
      if (img) {
        imgEl.src = img; imgEl.alt = name;
        imgEl.style.display = 'block';
        ph.style.display = 'none';
      } else {
        imgEl.style.display = 'none';
        ph.style.display = 'flex';
      }

      // Badge statut
      const badge = document.getElementById('detailBadge');
      if (!available || stock <= 0) {
        badge.innerHTML = '<span style="display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:50px;background:rgba(255,80,80,0.15);border:1px solid rgba(255,80,80,0.2);color:#FF6B6B;font-size:11px;font-weight:700;"><i class=\"bi bi-x-circle\"></i>Rupture de stock</span>';
      } else if (stock <= 5) {
        badge.innerHTML = '<span style="display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:50px;background:rgba(255,196,0,0.15);border:1px solid rgba(255,196,0,0.2);color:#FFD93D;font-size:11px;font-weight:700;"><i class=\"bi bi-exclamation-triangle\"></i>Plus que ' + stock + ' restants</span>';
      } else {
        badge.innerHTML = '<span style="display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:50px;background:rgba(0,230,130,0.12);border:1px solid rgba(0,230,130,0.2);color:#00E682;font-size:11px;font-weight:700;"><i class=\"bi bi-check-circle\"></i>Disponible</span>';
      }

      // Infos texte
      document.getElementById('detailTitle').textContent = name;
      document.getElementById('detailPrice').textContent =
        price.toLocaleString('fr-FR') + ' F';
      document.getElementById('detailDesc').textContent =
        desc || 'Aucune description disponible.';
      document.getElementById('detailStock').textContent =
        stock <= 0 ? 'Stock épuisé' : stock + ' unités en stock';

      // Actions
      const actionsEl = document.getElementById('detailActions');
      if (available && stock > 0) {
        actionsEl.innerHTML = `
                                <div class="detail-qty">
                                  <button type="button" id="dMinus" onclick="detailChangeQty(-1)" disabled>−</button>
                                  <span id="dQty">1</span>
                                  <button type="button" id="dPlus" onclick="detailChangeQty(1)" ${stock <= 1 ? 'disabled' : ''}>+</button>
                                </div>
                                <button class="detail-add-btn" id="dAddBtn" onclick="detailAddToCart()">
                                  <i class="bi bi-bag-plus-fill"></i>
                                  Ajouter — <span id="dTotal">${price.toLocaleString('fr-FR')} F</span>
                                </button>`;
      } else {
        actionsEl.innerHTML = `
                                <div style="width:100%;padding:10px 14px;border-radius:var(--r-md);background:rgba(255,80,80,0.08);border:1px solid rgba(255,80,80,0.15);color:#FF6B6B;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;">
                                  <i class="bi bi-x-circle"></i>Ce burger est actuellement indisponible
                                </div>`;
      }

      document.getElementById('detailModal').classList.add('open');
      document.body.style.overflow = 'hidden';
    }

    function closeDetail() {
      document.getElementById('detailModal').classList.remove('open');
      document.body.style.overflow = '';
    }

    // Fermer en cliquant sur le fond
    document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('detailModal').addEventListener('click', function (e) {
        if (e.target === this) closeDetail();
      });
    });

    function detailChangeQty(delta) {
      detailQty = Math.max(1, Math.min(detailMax, detailQty + delta));
      document.getElementById('dQty').textContent = detailQty;
      document.getElementById('dMinus').disabled = detailQty <= 1;
      document.getElementById('dPlus').disabled = detailQty >= detailMax;
      document.getElementById('dTotal').textContent =
        (detailData.price * detailQty).toLocaleString('fr-FR') + ' F';
    }

    function detailAddToCart() {
      const { name, price, img } = detailData;
      // Ajouter au cartState existant
      if (cartState[name]) {
        cartState[name].qty = Math.min(detailMax, cartState[name].qty + detailQty);
      } else {
        cartState[name] = { price, qty: detailQty, img, max: detailMax };
      }
      renderCart();

      // Feedback visuel sur le bouton
      const btn = document.getElementById('dAddBtn');
      if (btn) {
        btn.innerHTML = '<i class=\"bi bi-check-circle-fill\"></i> Ajouté !';
        btn.style.background = 'linear-gradient(135deg,#00c97a,#00e682)';
        setTimeout(() => {
          btn.innerHTML = `<i class="bi bi-bag-plus-fill"></i> Ajouter — <span id="dTotal">${(price * detailQty).toLocaleString('fr-FR')} F</span>`;
          btn.style.background = '';
        }, 1800);
      }
    }

    /* ══════════════════════
       CART
    ══════════════════════ */
    let cartState = {};

    function addItem(name, price, img) {
      const card = document.querySelector(`.menu-card[data-name="${name.toLowerCase()}"]`);
      const max = card ? parseInt(card.dataset.stock || '0', 10) : 0;
      if (cartState[name]) {
        if (cartState[name].qty >= max) return;
        cartState[name].qty++;
      } else {
        cartState[name] = { price, qty: 1, img, max };
      }
      renderCart();
    }

    function changeQty(name, delta) {
      if (!cartState[name]) return;
      const item = cartState[name];
      if (delta > 0) {
        const max = item.max || (() => {
          const c = document.querySelector(`.menu-card[data-name="${name.toLowerCase()}"]`);
          return c ? parseInt(c.dataset.stock || '0', 10) : 0;
        })();
        if (item.qty >= max) return;
      }
      item.qty += delta;
      if (item.qty <= 0) delete cartState[name];
      renderCart();
    }

    function clearCart() { cartState = {}; renderCart(); }

    function renderCart() {
      const entries = Object.entries(cartState);
      const itemsEl = document.getElementById('cartItems');
      const emptyEl = document.getElementById('cartEmpty');
      const summaryEl = document.getElementById('cartSummary');
      const badgeEl = document.getElementById('cartBadge');
      const btnOrder = document.getElementById('btnOrder');

      itemsEl.querySelectorAll('.cart-item').forEach(e => e.remove());

      if (!entries.length) {
        emptyEl.style.display = 'flex';
        summaryEl.style.display = 'none';
        badgeEl.textContent = '0';
        btnOrder.disabled = true;
        updateAddCircleButtons();
        return;
      }

      emptyEl.style.display = 'none';
      summaryEl.style.display = 'block';
      btnOrder.disabled = false;

      let total = 0, count = 0;
      entries.forEach(([name, item]) => {
        total += item.price * item.qty;
        count += item.qty;

        const cardEl = document.querySelector(`.menu-card[data-name="${name.toLowerCase()}"]`);
        const max = item.max || (cardEl ? parseInt(cardEl.dataset.stock || '0', 10) : 0);
        const disablePlus = max > 0 && item.qty >= max;

        const div = document.createElement('div');
        div.className = 'cart-item';
        div.innerHTML = `
                                <div class="ci-thumb">${item.img
            ? `<img src="${item.img}" alt="${name}">`
            : '<i class="bi bi-layers-half" style="font-size:18px;color:rgba(255,77,26,0.5);"></i>'
          }</div>
                                <div class="ci-info">
                                  <div class="ci-name">${name}</div>
                                  <div class="ci-price">${(item.price * item.qty).toLocaleString('fr-FR')} F</div>
                                </div>
                                <div class="qty-ctrl">
                                  <button class="qty-btn" onclick="changeQty('${name.replace(/'/g, "\\'")}', -1)">−</button>
                                  <span class="qty-num">${item.qty}</span>
                                  <button class="qty-btn"
                                    ${disablePlus ? 'disabled style="opacity:.3;cursor:not-allowed;"' : ''}
                                    onclick="changeQty('${name.replace(/'/g, "\\'")}', 1)">+</button>
                                </div>`;
        emptyEl.after(div);
      });

      const fmt = v => v.toLocaleString('fr-FR') + ' F';
      document.getElementById('cartSubtotal').textContent = fmt(total);
      document.getElementById('cartTotal').textContent = fmt(total);
      badgeEl.textContent = count;

      const rev = document.getElementById('modalReview');
      if (rev) {
        rev.innerHTML = entries.map(([n, i]) =>
          `<div class="or-item"><span>${n} × ${i.qty}</span><span>${(i.price * i.qty).toLocaleString('fr-FR')} F</span></div>`
        ).join('') + `<div class="or-total"><span>Total</span><span>${fmt(total)}</span></div>`;
      }
      updateAddCircleButtons();
    }

    function updateAddCircleButtons() {
      document.querySelectorAll('.menu-card').forEach(card => {
        const stock = parseInt(card.dataset.stock || '0', 10);
        const btn = card.querySelector('.add-circle');
        if (!btn) return;
        const key = Object.keys(cartState).find(k => k.toLowerCase() === card.dataset.name);
        btn.disabled = !!(key && cartState[key] && stock > 0 && cartState[key].qty >= stock);
      });
    }

    /* ══════════════════════
       FILTRES CLIENT
    ══════════════════════ */
    function liveSearch(q) {

      const term = q.toLowerCase().trim();

      // Filtrage instantané
      document.querySelectorAll('.menu-card').forEach(card => {
        card.style.display =
          !term || card.dataset.name.includes(term) ? '' : 'none';
      });

      // Mise à jour de l'URL sans reload
      const url = new URL(window.location);

      if (term) {
        url.searchParams.set('search', term);
      } else {
        url.searchParams.delete('search');
      }

      window.history.replaceState({}, '', url);
    }

    document.addEventListener("DOMContentLoaded", () => {

      const params = new URLSearchParams(window.location.search);
      const search = params.get('search');

      if (search) {
        const input = document.getElementById('searchInput');
        input.value = search;
        liveSearch(search);
      }

    });

    function filterByAvail(mode, el) {
      document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
      el.classList.add('active');
      document.querySelectorAll('.menu-card').forEach(card => {
        card.style.display = mode === 'dispo' ? (card.dataset.dispo === '1' ? '' : 'none') : '';
      });
    }

    function sortMenu(dir) {
      if (!dir) return;
      const grid = document.getElementById('menuGrid');
      const cards = [...grid.querySelectorAll('.menu-card')];
      cards.sort((a, b) => dir === 'asc' ? a.dataset.prix - b.dataset.prix : b.dataset.prix - a.dataset.prix);
      cards.forEach(c => grid.appendChild(c));
    }

    /* ══════════════════════
       VALIDATION PRIX
       (empêche min > max)
    ══════════════════════ */
    document.addEventListener('DOMContentLoaded', () => {
      const minEl = document.getElementById('minPrice');
      const maxEl = document.getElementById('maxPrice');
      if (!minEl || !maxEl) return;

      minEl.addEventListener('input', () => {
        if (maxEl.value && parseInt(minEl.value) > parseInt(maxEl.value)) {
          minEl.value = maxEl.value;
        }
      });
      maxEl.addEventListener('input', () => {
        if (minEl.value && parseInt(maxEl.value) < parseInt(minEl.value)) {
          maxEl.value = minEl.value;
        }
      });
    });

    /* ══════════════════════
       MODAL
    ══════════════════════ */
    function openOrderModal() {
      if (!Object.keys(cartState).length) return;
      document.getElementById('orderModal').classList.add('open');
    }
    function closeOrderModal() {
      document.getElementById('orderModal').classList.remove('open');
    }

    function submitOrder() {
      const nom = document.getElementById('cName').value.trim();
      const tel = document.getElementById('cPhone').value.trim();
      if (!nom || !tel) { alert('Veuillez remplir les champs obligatoires.'); return; }

      const container = document.getElementById('cartItemsInput');
      container.innerHTML = '';
      Object.entries(cartState).forEach(([name, item], i) => {
        container.innerHTML += `
                                <input type="hidden" name="items[${i}][name]"     value="${name}">
                                <input type="hidden" name="items[${i}][price]"    value="${item.price}">
                                <input type="hidden" name="items[${i}][quantity]" value="${item.qty}">`;
      });
      document.getElementById('orderForm').submit();
    }
  </script>
@endpush