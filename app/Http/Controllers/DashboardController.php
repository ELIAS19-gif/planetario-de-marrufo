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
        $info=$servicio->total_ventas($objeto);

        $objeto1 = new \StdClass();
        $objeto1->tendencias = true;
        $info2 = $servicio->total_ventas($objeto1);

    }
}