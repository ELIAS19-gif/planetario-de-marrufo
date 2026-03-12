@extends('app.master')

@section('titulo')
Edades
@endsection

@section('contenido')
<div class="col-md-12">

<a class="btn btn-info" href="{{ route ('edad.formulario')}}">Agregar</a>

<table class="table">
      <tr>
          <td>Id</td>
          <td>Nombre</td>
       </tr>

    @foreach($lista as $elemento)
      <tr>
          <td>{{$elemento->id}}</td>

          <td>
              <a href="{{ route ('edad.formulario', $elemento->id)}}">
                  {{$elemento->nombre}}
              </a>
          </td>

      </tr>
    @endforeach

</table>

</div>
@endsection