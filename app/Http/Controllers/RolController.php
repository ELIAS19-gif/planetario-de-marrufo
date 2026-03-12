<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Rol;
use Illuminate\Support\Facades\DB;
use View;

class RolController extends Controller
{
    function rol()
    {
        $datos=array();
        $datos['lista']=Rol::all();
        return view('rol.listado',$datos);
    }

    function formulario($id=0)
    {
        $datos=array();

        if ($id==0){
            $datos['rol']= new Rol();
            $datos['operacion']='Agregar';
        }
        else{
            $datos['rol']=Rol::find($id);
            $datos['operacion']='Modificar';
        }

        return view('rol.formulario')->with($datos);
    }

    function guardar(Request $datos)
    {
        $context=$datos->all();

        switch($datos['operacion']){

            case 'Agregar':
                $rol=new Rol();
                $rol->nombre=$datos['nombre'];
                $rol->save();
            break;

            case 'Modificar':
                $rol=Rol::find($datos['id']);
                $rol->nombre=$datos['nombre'];
                $rol->save();
            break;

            case 'Eliminar':
                $rol=Rol::find($datos['id']);
                $rol->delete();
            break;
        }

        return redirect()->route('rol');
    }
}