@extends('layouts.admin')
@section('title', 'Nouveau Burger')
@section('page-title', 'Nouveau Burger')
@section('back-btn')
  <a href="{{ route('admin.burgers.index') }}" class="btn-icon"><i class="bi bi-arrow-left"></i></a>
@endsection

@section('content')
  <div style="max-width:640px;margin:0 auto;">
    <div style="display:flex;align-items:center;gap:6px;margin-bottom:20px;font-size:12.5px;color:var(--tx-tertiary);">
      <i class="bi bi-box-seam"></i>
      <a href="{{ route('admin.burgers.index') }}" style="color:var(--tx-tertiary);text-decoration:none;">Burgers</a>
      <i class="bi bi-chevron-right" style="font-size:10px;"></i>
      <span style="color:var(--ember);">Nouveau burger</span>
    </div>

    <div class="panel glass-med" style="border-radius:var(--r-xl);">
      <div class="panel-header">
        <div class="panel-title"><i class="bi bi-plus-square"></i>Informations du burger</div>
      </div>
      <div class="panel-body">
        <form method="POST" action="{{ route('admin.burgers.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="grid-2">
            <div style="grid-column:1/-1;" class="field-group">
              <label class="field-label">Nom du burger <span style="color:var(--ember)">*</span></label>
              <input class="field" name="name" placeholder="ex: Big Mac Maison" value="{{ old('name') }}" required>
            </div>
            <div class="field-group">
              <label class="field-label">Prix (FCFA) <span style="color:var(--ember)">*</span></label>
              <div style="position:relative;">
                <input class="field" type="number" name="price" placeholder="1500" value="{{ old('price') }}"
                  style="padding-left:44px;" required min="0">
                <span
                  style="position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:11px;font-weight:600;color:var(--tx-tertiary);">CFA</span>
              </div>
            </div>
            <div class="field-group">
              <label class="field-label">Stock <span style="color:var(--ember)">*</span></label>
              <div style="position:relative;">
                <i class="bi bi-archive"
                  style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--tx-tertiary);"></i>
                <input class="field" type="number" name="stock" placeholder="0" value="{{ old('stock', 20) }}"
                  style="padding-left:40px;" required min="0">
              </div>
            </div>
            <div style="grid-column:1/-1;" class="field-group">
              <label class="field-label">Description</label>
              <textarea class="field" name="description" rows="3"
                placeholder="Ingrédients, saveurs...">{{ old('description') }}</textarea>
            </div>
            <div class="field-group">
              <label class="field-label">Disponibilité</label>
              <div style="display:flex;gap:10px;margin-top:4px;">
                <label
                  style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:var(--tx-secondary);">
                  <input type="radio" name="available" value="1" {{ old('available', '1') === '1' ? 'checked' : '' }}
                    style="accent-color:var(--ember);width:15px;height:15px;"> Disponible
                </label>
                <label
                  style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:var(--tx-secondary);">
                  <input type="radio" name="available" value="0" {{ old('available') === '0' ? 'checked' : '' }}
                    style="accent-color:var(--ember);width:15px;height:15px;"> Indisponible
                </label>
              </div>
            </div>
            <div style="grid-column:1/-1;" class="field-group">
              <label class="field-label">Image du burger</label>
              <div class="upload-zone" onclick="document.getElementById('imgInput').click()">
                <i class="bi bi-cloud-arrow-up"></i>
                <p>Glissez une image ou cliquez pour sélectionner<br><span style="font-size:11px;">PNG, JPG, WEBP — max 2
                    Mo</span></p>
              </div>
              <input type="file" id="imgInput" name="image" accept="image/*" style="display:none;"
                onchange="document.querySelector('.upload-zone p').textContent=this.files[0]?.name??'Aucun fichier sélectionné'">
            </div>
          </div>
          <div
            style="display:flex;gap:10px;justify-content:flex-end;padding-top:16px;border-top:1px solid var(--glass-border);">
            <a href="{{ route('admin.burgers.index') }}" class="btn-ghost"><i class="bi bi-x"></i>Annuler</a>
            <button type="submit" class="btn-ember"><i class="bi bi-check-lg"></i>Ajouter le burger</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection