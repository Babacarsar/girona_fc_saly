@extends('layouts.admin')
@section('title', 'Modifier match')
@section('content')
<x-admin.page-header title="Modifier le match" />
<div class="admin-card col-lg-8"><div class="admin-card__body admin-form">
<form method="POST" action="{{ route('admin.matchs.update', $match) }}">@csrf @method('PUT')
@include('admin.matchs._form', ['match' => $match])
<button class="btn btn-girona">Mettre à jour</button>
</form></div></div>
@endsection
