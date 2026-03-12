@extends('app.master')
@section('titulo')
  Ocupacion
@endsection
@section('contenido')
<div class="forms-container">
    <!-- Desde Laravel 8 en adelante, los controladores ya no se llaman así dentro de action() o Route::get().-->
    <form action="{{ route('ocupacion.save') }}" method="post">
      {{ csrf_field() }} 
      <div>
        <input type="hidden" name="id" class="form-control" value="{{$ocupacion->id ?? ''}}">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Nombre</label>
        <input type="text" name="nombre" value="{{$ocupacion->nombre ?? ''}}">
      </div>
      <div>
        <input type="submit" class="btn btn-outline-secondary" name= "operacion" value="{{ $operacion }}">
        @if ($operacion == 'Guardar Cambios')
        <input type="submit" class="btn btn-outline-secondary" name= "operacion" value="Eliminar">
        @endif
      </div>  
    </form>
  </div>
@endsection

