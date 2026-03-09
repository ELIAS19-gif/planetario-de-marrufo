<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Usuario;
use App\Models\Edad;
use App\Models\Ocupacion;
use App\Models\Producto;
use App\Servicio\ServicioKPI;
use Faker\Factory as Faker;

class DashboardController extends Controller{
    
    function total_venta(){
        $servicio=new ServicioKPI();
        $objeto=new \StdClass();
        $info1=$servicio->total_ventas($objeto);
        //dd($info1[0]);

        $objeto1 = new \StdClass();
        $objeto1->tendencias=true;
        $objeto1->meses=6;
        $info2 = $servicio->total_ventas($objeto1);
        // dd($info2);

        $resultado=new \StdCLass();
        $resultado->tendencias=$info2;
        $resultado->total=$info1[0]->total;

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