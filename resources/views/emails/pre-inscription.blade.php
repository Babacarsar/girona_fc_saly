@component('mail::message')
# Nouvelle pré-inscription

**Enfant :** {{ $inscription->prenom }} {{ $inscription->nom }}  
**Date de naissance :** {{ $inscription->date_naissance->format('d/m/Y') }}  
**Catégorie :** {{ $inscription->categorie->nom ?? '—' }}  
**Contact :** {{ $inscription->email_parent }} @if($inscription->telephone) · {{ $inscription->telephone }} @endif

@if($inscription->message)
**Message :**  
{{ $inscription->message }}
@endif

Consultez l’admin pour exporter ou traiter la demande.

@endcomponent
