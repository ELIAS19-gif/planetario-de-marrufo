@extends('app.master') 

@section('titulo')
Edades
@endsection

@section('contenido')
<div class="col-md-12">

<form action="{{ route('edad.guardar') }}" method="POST">
    @csrf

    <input type="hidden" class="form-control" name="id" value="{{$edad->id}}">

  <div class="form-group">
    <label for="exampleInputEmail1">Nombre</label>
    <input type="text" class="form-control" name="nombre" value="{{$edad->nombre}}">
  </div>

  <input type="submit" class="btn btn-primary" name="operacion" value="{{$operacion}}">

  @if($operacion=='Modificar')
  <input type="submit" class="btn btn-danger" name="operacion" value="Eliminar">
  @endif

</form>

</div>
@endsection