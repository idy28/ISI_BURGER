@extends('layouts.admin')
@section('title', 'Modifier ' . $burger->nom)
@section('page-title', 'Modifier le burger')
@section('back-btn')
  <a href="{{ route('admin.burgers.index') }}" class="btn-icon"><i class="bi bi-arrow-left"></i></a>
@endsection

@section('content')
  <div style="max-width:640px;margin:0 auto;">
    <div style="display:flex;align-items:center;gap:6px;margin-bottom:20px;font-size:12.5px;color:var(--tx-tertiary);">
      <i class="bi bi-box-seam"></i>
      <a href="{{ route('admin.burgers.index') }}" style="color:var(--tx-tertiary);text-decoration:none;">Burgers</a>
      <i class="bi bi-chevron-right" style="font-size:10px;"></i>
      <span style="color:var(--ember);">{{ $burger->nom }}</span>
    </div>

    <div class="panel glass-med" style="border-radius:var(--r-xl);">
      <div class="panel-header">
        <div class="panel-title"><i class="bi bi-pencil-square"></i>Modifier : {{ $burger->nom }}</div>
      </div>
      <div class="panel-body">
        <form method="POST" action="{{ route('admin.burgers.update', $burger->id) }}" enctype="multipart/form-data">
          @csrf @method('PUT')
          <div class="grid-2">
            <div style="grid-column:1/-1;" class="field-group">
              <label class="field-label">Nom du burger <span style="color:var(--ember)">*</span></label>
              <input class="field" name="name" value="{{ old('name', $burger->name) }}" required>
            </div>
            <div class="field-group">
              <label class="field-label">Prix (FCFA) <span style="color:var(--ember)">*</span></label>
              <div style="position:relative;">
                <input class="field" type="number" name="price" value="{{ old('price', $burger->price) }}"
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
                <input class="field" type="number" name="stock" value="{{ old('stock', $burger->stock) }}"
                  style="padding-left:40px;" required min="0">
              </div>
            </div>
            <div style="grid-column:1/-1;" class="field-group">
              <label class="field-label">Description</label>
              <textarea class="field" name="description"
                rows="3">{{ old('description', $burger->description) }}</textarea>
            </div>
            <div class="field-group">
              <label class="field-label">Disponibilité</label>
              <div style="display:flex;gap:10px;margin-top:4px;">
                <label
                  style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:var(--tx-secondary);">
                  <input type="radio" name="available" value="1" {{ old('available', $burger->available ? '1' : '0') === '1' || $burger->available ? 'checked' : '' }} style="accent-color:var(--ember);width:15px;height:15px;">
                  Disponible
                </label>
                <label
                  style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:var(--tx-secondary);">
                  <input type="radio" name="available" value="0" {{ !$burger->available ? 'checked' : '' }}
                    style="accent-color:var(--ember);width:15px;height:15px;"> Indisponible
                </label>
              </div>
            </div>
            <div style="grid-column:1/-1;" class="field-group">
              <label class="field-label">Image</label>
              @if($burger->image)
                <div style="margin-bottom:10px;display:flex;align-items:center;gap:10px;">
                  <img src="{{ Storage::url($burger->image) }}"
                    style="width:60px;height:60px;object-fit:cover;border-radius:var(--r-md);border:1px solid var(--glass-border);">
                  <span style="font-size:12px;color:var(--tx-tertiary);">Image actuelle</span>
                </div>
              @endif
              <div class="upload-zone" onclick="document.getElementById('imgInput').click()">
                <i class="bi bi-cloud-arrow-up"></i>
                <p>Nouvelle image (optionnel)<br><span style="font-size:11px;">PNG, JPG, WEBP — max 2 Mo</span></p>
              </div>
              <input type="file" id="imgInput" name="image" accept="image/*" style="display:none;"
                onchange="document.querySelector('.upload-zone p').textContent=this.files[0]?.name??'Nouvelle image'">
            </div>
          </div>
          <div
            style="display:flex;gap:10px;justify-content:flex-end;padding-top:16px;border-top:1px solid var(--glass-border);">
            <a href="{{ route('admin.burgers.index') }}" class="btn-ghost"><i class="bi bi-x"></i>Annuler</a>
            <button type="submit" class="btn-ember"><i class="bi bi-check-lg"></i>Sauvegarder</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection