<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Ocupacion;
use Illuminate\Support\Facades\DB;
use View;

class OcupacionController extends Controller
{
    function ocupacion()
    {
        $datos=array();
        $datos['lista']=Ocupacion::all();
        return view('ocupacion.listado',$datos);
    }

    function formulario($id=0)
    {
        $datos=array();

        if ($id==0){
            $datos['ocupacion']= new Ocupacion();
            $datos['operacion']='Agregar';
        }
        else{
            $datos['ocupacion']=Ocupacion::find($id);
            $datos['operacion']='Modificar';
        }

        return view('ocupacion.formulario')->with($datos);
    }

    function guardar(Request $datos)
    {
        $context=$datos->all();

        switch($datos['operacion']){

            case 'Agregar':
                $ocupacion=new Ocupacion();
                $ocupacion->nombre=$datos['nombre'];
                $ocupacion->save();
            break;

            case 'Modificar':
                $ocupacion=Ocupacion::find($datos['id']);
                $ocupacion->nombre=$datos['nombre'];
                $ocupacion->save();
            break;

            case 'Eliminar':
                $ocupacion=Ocupacion::find($datos['id']);
                $ocupacion->delete();
            break;
        }

        return redirect()->route('ocupacion');
    }
}