@extends('app.master')

@section('titulo')
Roles
@endsection

@section('contenido')
<div class="col-md-12">

    <form action="{{ route('rol.guardar') }}" method="POST">
        @csrf

        <input type="hidden" class="form-control" name="id" value="{{$rol->id}}">

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" name="nombre" value="{{$rol->nombre}}">
        </div>

        <input type="submit" class="btn btn-primary" name="operacion" value="{{$operacion}}">

        @if($operacion=='Modificar')
        <input type="submit" class="btn btn-danger" name="operacion" value="Eliminar">
        @endif

    </form>

</div>
@endsection