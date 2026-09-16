@php($m = $match ?? null)
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Adversaire</label>
<input name="adversaire" class="form-control" required value="{{ old('adversaire', $m?->adversaire) }}"></div>
<div class="col-md-6"><label class="form-label">Date et heure</label>
<input type="datetime-local" name="date_match" class="form-control" required
value="{{ old('date_match', $m ? $m->date_match->format('Y-m-d\TH:i') : '') }}"></div>
<div class="col-md-6"><label class="form-label">Lieu</label>
<input name="lieu" class="form-control" value="{{ old('lieu', $m?->lieu) }}"></div>
<div class="col-md-3"><label class="form-label">Type</label>
<select name="type" class="form-select">
<option value="amical" @selected(old('type', $m?->type) === 'amical')>Amical</option>
<option value="tournoi" @selected(old('type', $m?->type) === 'tournoi')>Tournoi</option>
</select></div>
<div class="col-md-3"><label class="form-label">Catégorie</label>
<select name="categorie_id" class="form-select">
<option value="">—</option>
@foreach($categories as $c)<option value="{{ $c->id }}" @selected(old('categorie_id', $m?->categorie_id) == $c->id)>{{ $c->nom }}</option>@endforeach
</select></div>
<div class="col-md-3"><label class="form-label">Score domicile</label>
<input name="score_domicile" class="form-control" value="{{ old('score_domicile', $m?->score_domicile) }}"></div>
<div class="col-md-3"><label class="form-label">Score extérieur</label>
<input name="score_exterieur" class="form-control" value="{{ old('score_exterieur', $m?->score_exterieur) }}"></div>
<div class="col-12"><label class="form-label">Notes</label>
<textarea name="notes" class="form-control" rows="3">{{ old('notes', $m?->notes) }}</textarea></div>
</div>
