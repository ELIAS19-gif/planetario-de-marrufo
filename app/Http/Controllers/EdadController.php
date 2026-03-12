<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Edad;
use Illuminate\Support\Facades\DB;
use View;

class EdadController extends Controller
{
    function edad()
    {
        $datos=array();
        $datos['lista']=Edad::all();
        return view('edad.listado',$datos);
    }

    function formulario($id=0)
    {
        $datos=array();
        if ($id==0){
            $datos['edad']= new Edad();
            $datos['operacion']='Agregar';
        }
        else{
            $datos['edad']=Edad::find($id);
            $datos['operacion']='Modificar';
        }

        return view('edad.formulario')->with($datos);
    }

    function guardar(Request $datos)
    {
        //Recoge todos los datos del formulario
        $contex=$datos->all();

        switch($datos['operacion']){
            case 'Agregar':
                $edad=new Edad();
                $edad->nombre=$datos['nombre'];
                $edad->save();
            break;

            case 'Modificar':
                $edad=Edad::find($datos['id']);
                $edad->nombre=$datos['nombre'];
                $edad->save();
            break;

            case 'Eliminar':
                $edad=Edad::find($datos['id']);
                $edad->delete();
            break;
        }

        return redirect()->route('edad');
    }
}