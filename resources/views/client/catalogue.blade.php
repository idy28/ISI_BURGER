@extends('layouts.client')
@section('title', 'ISI BURGER — Nos Burgers')

@section('content')
  <div class="cat-layout">
    <div class="cat-main">
      <!-- Header -->
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
          <input type="text" id="searchInput" placeholder="Rechercher parmi nos burgers..."
            oninput="filterMenu(this.value)">
        </div>
        <div style="margin-left:auto;font-size:12px;color:var(--tx-tertiary);display:flex;align-items:center;gap:6px;">
          <i class="bi bi-geo-alt-fill" style="color:var(--ember);"></i>Dakar — Commander ici
        </div>
      </header>

      <div class="cat-body">
        <div class="cat-content">
          <div style="margin-bottom:20px;">
            <div style="font-family:'Syne',sans-serif;font-size:24px;font-weight:900;margin-bottom:4px;">Nos Burgers</div>
            <div style="font-size:13px;color:var(--tx-tertiary);">Sélection artisanale — préparée à la commande</div>
          </div>

          <div class="filter-row">
            <a class="filter-chip active" id="filterAll" onclick="filterByAvail('all',this)"><i
                class="bi bi-grid-3x3-gap"></i>Tout le menu</a>
            <a class="filter-chip" onclick="filterByAvail('dispo',this)"><i class="bi bi-check-circle"></i>Disponibles</a>
            <div style="margin-left:auto;">
              <select class="field" id="sortSelect" style="width:auto;font-size:12px;padding:6px 12px;border-radius:50px;"
                onchange="sortMenu(this.value)">
                <option value="">Trier : Par défaut</option>
                <option value="asc">Prix croissant</option>
                <option value="desc">Prix décroissant</option>
              </select>
            </div>
          </div>

          <div class="menu-grid" id="menuGrid">
            @foreach($burgers as $burger)
              <div class="menu-card glass-med {{ !$burger->available || $burger->stock <= 0 ? 'out-of-stock' : '' }}"
                data-name="{{ strtolower($burger->name) }}" data-prix="{{ $burger->price }}"
                data-dispo="{{ $burger->available && $burger->stock > 0 ? '1' : '0' }}">
                <div class="menu-img" style="position:relative;">
                  <div class="menu-img-bg"
                    style="background:linear-gradient(135deg,rgba(255,77,26,0.18),rgba(255,122,82,0.05));"></div>
                  @if($burger->image)
                    <img src="{{ Storage::url($burger->image) }}" alt="{{ $burger->name }}">
                  @else
                    <i class="bi bi-layers-half"></i>
                  @endif
                  @if($burger->stock > 0 && $burger->stock <= 5)
                    <span class="stock-badge-sm"><i class="bi bi-exclamation-triangle"
                        style="font-size:9px;margin-right:2px;"></i>{{ $burger->stock }} restants</span>
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
                    @if($burger->available && $burger->stock > 0)
                      <button class="add-circle"
                        onclick="addItem('{{ addslashes($burger->name) }}', {{ $burger->price }}, '{{ $burger->image ? Storage::url($burger->image) : '' }}')">
                        <i class="bi bi-plus" style="font-size:16px;"></i>
                      </button>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Cart panel -->
        <div class="cart-panel">
          <div class="cart-header">
            <div class="cart-title-txt">
              <i class="bi bi-bag-check-fill" style="color:var(--ember);font-size:18px;"></i>
              Ma commande
              <div class="cart-count-badge" id="cartBadge">0</div>
            </div>
            <button class="btn-icon" onclick="clearCart()" title="Vider"><i class="bi bi-trash3"></i></button>
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

  <!-- Modal commande -->
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
          </div>
          <div class="field-group">
            <label class="field-label">Téléphone <span style="color:var(--ember)">*</span></label>
            <div style="position:relative;">
              <i class="bi bi-telephone"
                style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--tx-tertiary);"></i>
              <input class="field" id="cPhone" name="customer_phone" placeholder="7X XXX XX XX" style="padding-left:40px;"
                required>
            </div>
          </div>
          <div class="field-group" style="margin-bottom:0;">
            <label class="field-label">Notes (optionnel)</label>
            <textarea class="field" name="notes" rows="2" placeholder="Sans oignons, extra sauce..."></textarea>
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
    let cartState = {};

    function addItem(name, price, img) {
      if (cartState[name]) cartState[name].qty++;
      else cartState[name] = { price, qty: 1, img };
      renderCart();
    }

    function changeQty(name, delta) {
      if (!cartState[name]) return;
      cartState[name].qty += delta;
      if (cartState[name].qty <= 0) delete cartState[name];
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
        return;
      }
      emptyEl.style.display = 'none';
      summaryEl.style.display = 'block';
      btnOrder.disabled = false;

      let total = 0, count = 0;
      entries.forEach(([name, item]) => {
        total += item.price * item.qty;
        count += item.qty;
        const div = document.createElement('div');
        div.className = 'cart-item';
        div.innerHTML = `
                      <div class="ci-thumb">${item.img ? `<img src="${item.img}" alt="${name}">` : '<i class="bi bi-layers-half" style="font-size:18px;color:rgba(255,77,26,0.5);"></i>'}</div>
                      <div class="ci-info"><div class="ci-name">${name}</div><div class="ci-price">${(item.price * item.qty).toLocaleString('fr-FR')} F</div></div>
                      <div class="qty-ctrl">
                        <button class="qty-btn" onclick="changeQty('${name.replace(/'/g, "\\'")}', -1)">−</button>
                        <span class="qty-num">${item.qty}</span>
                        <button class="qty-btn" onclick="changeQty('${name.replace(/'/g, "\\'")}', 1)">+</button>
                      </div>`;
        emptyEl.after(div);
      });

      const fmt = v => v.toLocaleString('fr-FR') + ' F';
      document.getElementById('cartSubtotal').textContent = fmt(total);
      document.getElementById('cartTotal').textContent = fmt(total);
      badgeEl.textContent = count;

      const rev = document.getElementById('modalReview');
      if (rev) {
        let html = entries.map(([n, i]) => `<div class="or-item"><span>${n} × ${i.qty}</span><span>${(i.price * i.qty).toLocaleString('fr-FR')} F</span></div>`).join('');
        html += `<div class="or-total"><span>Total</span><span>${fmt(total)}</span></div>`;
        rev.innerHTML = html;
      }
    }

    function filterMenu(q) {
      const term = q.toLowerCase().trim();
      document.querySelectorAll('.menu-card').forEach(card => {
        card.style.display = !term || card.dataset.name.includes(term) ? '' : 'none';
      });
    }

    function filterByAvail(mode, el) {
      document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
      el.classList.add('active');
      document.querySelectorAll('.menu-card').forEach(card => {
        if (mode === 'dispo') card.style.display = card.dataset.dispo === '1' ? '' : 'none';
        else card.style.display = '';
      });
    }

    function sortMenu(dir) {
      if (!dir) return;
      const grid = document.getElementById('menuGrid');
      const cards = [...grid.querySelectorAll('.menu-card')];
      cards.sort((a, b) => dir === 'asc' ? a.dataset.prix - b.dataset.prix : b.dataset.prix - a.dataset.prix);
      cards.forEach(c => grid.appendChild(c));
    }

    function openOrderModal() {
      if (!Object.keys(cartState).length) return;
      document.getElementById('orderModal').classList.add('open');
    }
    function closeOrderModal() {
      document.getElementById('orderModal').classList.remove('open');
    }

    function submitOrder() {
      const form = document.getElementById('orderForm');
      const nom = document.getElementById('cName').value.trim();
      const tel = document.getElementById('cPhone').value.trim();
      if (!nom || !tel) { alert('Veuillez remplir les champs obligatoires.'); return; }

      // Injecter les articles dans le formulaire
      const container = document.getElementById('cartItemsInput');
      container.innerHTML = '';
      Object.entries(cartState).forEach(([name, item], i) => {
        container.innerHTML += `<input type="hidden" name="items[${i}][nom]" value="${name}">
                      <input type="hidden" name="items[${i}][prix]" value="${item.price}">
                      <input type="hidden" name="items[${i}][quantite]" value="${item.qty}">`;
      });
      form.submit();
    }
  </script>
@endpush