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
        return view('dashboard.index')->with($datos);
    }
    
    function total_venta(Request $r){
        $context = $r->all();
        // dd($context);
        $servicio = new ServicioKPI();
        $objeto = new \StdClass();
        $info = $servicio->total_ventas($objeto);

        $objeto1 = new \StdClass();
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

    function total_venta_producto(){
        $servicio=new ServicioKPI();
        $objeto=new \StdClass();
        $info=$servicio->ventas_productos($objeto);
        $resultado=new \StdCLass();
        $resultado->top=$info[0];
        $resultado->botton=$info[count($info)-1];
        $resultado->productos=$info;

        $objeto1=new \StdClass();
        $objeto1->tendencias=true;
        //$objeto1->idproducto=3;
        $info2=$servicio->ventas_productos($objeto1);
        $resultado->tendencias=$info2;
        dd($info2);

         return response()->json($resultado);
    }
}