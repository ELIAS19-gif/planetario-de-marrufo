<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Usuario;
use App\Models\Edad;
use App\Models\Ocupacion;
use App\Models\Producto;
use App\Servicio\ServicioKPI;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

class DashboardController extends Controller{

    function index(){
        $datos=array();
        $datos['productos']=Producto::all();
        $datos['edades']=Edad::all();
        $datos['ocupaciones']=Ocupacion::all();
        $datos['generos']=array('Hombre','Mujer','No indica');
        $datos['canales']=array('WEB', 'APP', 'KIOSKO', 'TAQUILLA');
        return view('dashboard.index')->with($datos);
    }
    
    function total_venta(Request $r){
        $context = $r->all();
        // dd($context);
        $servicio = new ServicioKPI();
        $objeto = new \StdClass();
        if(isset($context['idproducto']))
            $objeto->idproducto=$context['idproducto'];
        $info = $servicio->total_ventas($objeto);

        $objeto1 = new \StdClass();
        if(isset($context['idproducto']))
            $objeto1->idproducto=$context['idproducto'];
        $objeto1->tendencias = true;
        $info2 = $servicio->total_ventas($objeto1);

        $resultado = new \StdClass();
        $resultado->tendencias = $info2;
        $resultado->total = $info[0]->total;

        return response()->json($resultado);
    }
    function total_venta_canal(){
        $servicio=new ServicioKPI();
        $objeto=new \StdClass();
        $info1=$servicio->tendencias_canal($objeto);

        //dd($info1);

        $objeto1 = new \StdClass();
        $objeto1->tendencias=true;
        $objeto1->meses=6;
        $info2 = $servicio->tendencias_canal($objeto1);
        //dd($info2);

        $resultado=new \StdCLass();
        $resultado->tendencias=$info2;
        $resultado->total=$info1[0]->total;

        return response()->json($resultado);
    }

    function total_venta_producto(Request $r){
    $context = $r->all();
    $servicio=new ServicioKPI();
    $objeto=new \StdClass();
    if(isset($context['genero']))
        $objeto->genero=$context['genero'];
    $info=$servicio->ventas_productos($objeto);
    $resultado=new \StdCLass();
    $resultado->productos=$info;

    return response()->json($resultado);
}

    function total_ventas_categorias(Request $r){
        $context = $r->all();
        $servicio=new ServicioKPI();
        $objeto=new \StdClass();
        if(isset($context['genero']))
            $objeto->genero=$context['genero'];
        $resultado=new \StdCLass();
        $info=$servicio->total_categorias($objeto);
        $resultado->categorias=$info;
       return response()->json($resultado);
        
    }
    function demografico_genero(Request $r){
        $context = $r->all();
        $servicio=new ServicioKPI();
        $objeto=new \StdClass();
        if(isset($context['idedad']))
            $objeto->idedad=$context['idedad'];
        if(isset($context['idocupacion']))
            $objeto->idocupacion=$context['idocupacion'];
        $resultado=new \StdCLass();
        $resultado=$servicio->demografico_generos($objeto);
        //dd($info);
        return response()->json($resultado);
    }
    function demografico_edad(Request $r){
        $context=$r->all();
        $servicio=new ServicioKPI();
        $objeto=new \StdClass();
        if(isset($context['idocupacion']))
            $objeto->idocupacion=$context['idocupacion'];
        if(isset($context['idgenero']))
            $objeto->idgenero=$context['idgenero'];
        $resultado=new \StdClass();
        $resultado=$servicio->demografico_edad($objeto);
        return response ()->json($resultado);
    }

    function ventas_producto_genero(Request $r){
        $context=$r->all();
        $servicio=new ServicioKPI();
        $objeto=new \StdClass();
        if(isset($context['genero']))
            $objeto->genero=$context['genero'];
        $info=$servicio->ventas_productos_genero($objeto);
        $resultado=new \StdClass();
        $resultado->productos=$info;

        return response()->json($resultado);
    }
}