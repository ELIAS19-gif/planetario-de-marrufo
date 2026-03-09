<?php

namespace App\Servicio;
use App\Models\Orden;
use App\Models\DetalleOrden;
use App\Models\ExtraOrden;
use Illuminate\Support\Facades\DB;

class ServicioKPI
{
    //Key
    //Performance
    //Indicator

    //Total De Ventas De Los Ultimos N Meses
    //Atributos
        //Meses - cuantos meses antes genero el KPI
    /*
    selec SUM(orden.total)
    from orden
    whereDATE_SUB(now(), INTERVAL 3 MONTH)

    selec SUM(orden.total)
        ,DATE_FORMAT(orden.fecha %f-%d-%m)
    from orden
    whereDATE_SUB(now(), INTERVAL 3 MONTH)
    */

    function total_ventas($objeto){
    if(!isset($objeto->meses)){
        $objeto->meses=3;
    }

    if(!isset($objeto->tendencias)){
        $objeto->tendencias=false;
    }

    //1.-Defino la Consulta Base
    $consulta = DB::table('orden')
                ->select(
                    DB::raw('SUM(orden.total) as total')
                )
                ->whereRaw("orden.fecha>=DATE_SUB(NOW(), INTERVAL ".$objeto->meses." MONTH)");

    // 2.-Configuro la Consulta
        if($objeto->tendencias){
            $consulta->groupBy(DB::RAW("DATE_FORMAT(orden.fecha,'%m-%Y')"))
                    ->orderBy(DB::RAW("DATE_FORMAT(orden.fecha,'%Y-%m')" ),"asc")
                    ->addSelect(DB::RAW("DATE_FORMAT(orden.fecha,'%m-%Y') as fecha"));
        }

    // 3.-Ejecuto la Consulta
            return $consulta->get();
            }
}