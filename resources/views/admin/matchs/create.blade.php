@extends('layouts.admin')
@section('title', 'Nouveau match')
@section('content')
<x-admin.page-header title="Nouveau match" breadcrumb='<a href="'.route('admin.matchs.index').'">Matchs</a>' />
<div class="admin-card col-lg-8"><div class="admin-card__body admin-form">
<form method="POST" action="{{ route('admin.matchs.store') }}">@csrf
@include('admin.matchs._form')
<button class="btn btn-girona">Enregistrer</button>
<a href="{{ route('admin.matchs.index') }}" class="btn btn-light">Annuler</a>
</form></div></div>
@endsection
