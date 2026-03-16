@extends('layouts.app')

@section('contenido')

<h2>Vista Editar calificaciones</h2>
@isset($id)
    <p>Editando la calificacion con id: {{ $id }}</p>

@endisset

@endsection
