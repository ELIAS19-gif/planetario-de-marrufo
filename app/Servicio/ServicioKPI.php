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
        //Sin filtro
    selec SUM(orden.total)
    from orden
    where DATE_SUB(now(), INTERVAL 3 MONTH)

        //Con Filtro de Producto
    selec SUM(detalle_orden.precio*de)
    from orden
    join detalle_orden on orden.id=detalle_orden.idorden
    where DATE_SUB(now(), INTERVAL 3 MONTH)
    and detalle_orden.idproducto=1

        //Sin filtro
    SELECT SUM(orden.total)
          ,DATE_FORMAT(orden.fecha,'%m-%Y') as fecha
    FROM orden
    WHERE DATE_SUB(NOW(), INTERVAL 3 MONTH)
    GROUP BY DATE_FORMAT(orden.fecha,'%m-%Y')
    ORDER BY DATE_FORMAT(orden.fecha,'%m-%Y') DESC;

        //Con filtro
    SELECT SUM(detalle_orden.cantidad*detalle_orden.precio)
          ,DATE_FORMAT(orden.fecha,'%m-%Y') as fecha
    FROM orden
    join detalle_orden on detalle_orden.idorden=orden.id
    WHERE DATE_SUB(NOW(), INTERVAL 3 MONTH)
    AND detalle_orden.idproducto=13
    GROUP BY DATE_FORMAT(orden.fecha,'%m-%Y')
    ORDER BY DATE_FORMAT(orden.fecha,'%m-%Y') DESC;
    */

    function total_ventas($objeto){
    if(!isset($objeto->meses)){
        //$objeto->meses=3;
        $objeto->meses=2;
    }

    if(!isset($objeto->tendencias)){
        $objeto->tendencias=false;
    }

    if(!isset($objeto->idproducto)){
        $objeto->idproducto=0;
    }

    //1.-Defino la Consulta Base
    if($objeto->idproducto==0){
        //Sin filtro de Producto
        $consulta = DB::table('orden')
                ->select(
                    DB::raw('SUM(orden.total) as total')
                )
                ->whereRaw("orden.fecha>=DATE_SUB(now(), INTERVAL ".$objeto->meses." MONTH)");

    }
    else{
        //Con filtro de Producto
        $consulta = DB::table('orden')
                ->join('detalle_orden','detalle_orden.idorden','=','orden.id')
                ->select(
                    DB::raw('SUM(detalle_orden.precio*detalle_orden.cantidad) as total')
                )
                ->whereRaw("orden.fecha>=DATE_SUB(now(), INTERVAL ".$objeto->meses." MONTH)")
                ->where('detalle_orden.idproducto',$objeto->idproducto);

    }
    
    // 2.-Configuro la Consulta
        if($objeto->tendencias){
            $consulta->groupBy(DB::RAW("DATE_FORMAT(orden.fecha,'%m-%Y')"))
                    ->orderBy(DB::RAW("DATE_FORMAT(orden.fecha,'%Y-%m')" ),"asc")
                    ->addSelect(DB::RAW("DATE_FORMAT(orden.fecha,'%m-%Y') as fecha"));
        }

    // 3.-Ejecuto la Consulta
            return $consulta->get();
            }

    /*
    Consulta Base
    SELECT orden.canal,
           ,SUM(orden.total) AS total_por_canal
    FROM orden
    WHERE orden.fecha >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
    GROUP BY orden.canal
    ORDER BY total_por_canal;

    Tendencia por Mes y Canal
    SELECT orden.canal,
        SUM(orden.total) AS total_por_canal,
        DATE_FORMAT(orden.fecha,'%m-%y') AS mes
    FROM orden
    WHERE orden.fecha >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
    GROUP BY orden.canal, DATE_FORMAT(orden.fecha,'%m-%y')
    ORDER BY mes;
     */
     function tendencias_canal($objeto) {
        if (!isset($objeto->meses)) {
            $objeto->meses = 3;
        }

        if (!isset($objeto->tendencias)) {
            $objeto->tendencias=false;
        }


         // Defino la consulta base
        $consulta = DB::table('orden')
            ->select(
                DB::RAW('sum(orden.total) as total')
                ,"orden.canal"
            )
            ->whereRaw("orden.fecha>=DATE_SUB(now(),INTERVAL " . $objeto->meses . " MONTH)")
            ->groupBy("orden.canal");
            // ->orderBy(DB::RAW('sum(orden.total) as total'),"asc");

             if ($objeto->tendencias) {
            $consulta->groupBy(DB::raw("DATE_FORMAT(orden.fecha,'%m-%Y')"))
                ->orderBy(DB::raw("DATE_FORMAT(orden.fecha,'%m-%Y')"), "desc")
                ->addSelect(DB::raw("DATE_FORMAT(orden.fecha,'%m-%Y') as fecha"));
        }

        //    3.-Ejecuto la consulta
        return $consulta->get();
    }

    // Producto mas vendido
        // Producto menos vendido
        // Tendencias por producto
        /*
                    SELECT 
                producto.nombre,
                SUM(detalle_orden.cantidad * detalle_orden.precio) AS total
            FROM detalle_orden
            JOIN producto 
                ON detalle_orden.idproducto = producto.id
            JOIN orden 
                ON orden.id = detalle_orden.idorden
            WHERE orden.fecha >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
            GROUP BY producto.id
            ORDER BY SUM(detalle_orden.cantidad * detalle_orden.precio) DESC;
            */

    function ventas_productos($objeto) {

        if(!isset($objeto->meses)){
                $objeto->meses=3;
            }

        if(!isset($objeto->tendencias)){
                $objeto->tendencias=false;
            }
        if(!isset($objeto->idproducto)){
                $objeto->idproducto=0;
            }

        $consulta=DB::table('orden')
                 ->join('detalle_orden','detalle_orden.idorden','=','orden.id')
                 ->join('producto','detalle_orden.idproducto','=','producto.id')
                 ->select(
                    "producto.nombre"
                    ,DB::RAW("SUM(detalle_orden.cantidad * detalle_orden.precio) AS total")
                 )
                 ->whereRaw("orden.fecha>=DATE_SUB(now(),INTERVAL " . $objeto->meses . " MONTH)")
                 ->groupBy("producto.id","producto.nombre")
                 ->orderByRaw("SUM(detalle_orden.cantidad * detalle_orden.precio) DESC");
            if ($objeto->tendencias){
                $consulta->groupBy(DB::raw("DATE_FORMAT(orden.fecha,'%m-%Y')"))
                    ->orderByRaw("DATE_FORMAT(orden.fecha,'%Y-%m') ASC")
                    ->addSelect(DB::raw("DATE_FORMAT(orden.fecha,'%m-%Y') as fecha"));
        }

            if($objeto->idproducto!=0){
                $consulta->where("producto.id",$objeto->idproducto);
            }


        return $consulta->get();
    }
    /*
    //SIN Filtro de Clientes
    SELECT categoria.nombre
       ,SUM(detalle_orden.precio*detalle_orden.cantidad)as total
    from orden
    join detalle_orden on orden.id=detalle_orden.idorden
    join producto on producto.id=detalle_orden.idproducto
    join categoria on categoria.id=producto.categoria
    where DATE_SUB(NOW(), INTERVAL 3 MONTH);

    //CON Filtro de Clientes
    SELECT categoria.nombre,
       SUM(detalle_orden.precio * detalle_orden.cantidad) AS total
    FROM orden
    JOIN detalle_orden ON orden.id = detalle_orden.idorden
    JOIN producto ON producto.id = detalle_orden.idproducto
    JOIN categoria ON categoria.id = producto.categoria
    JOIN cliente ON orden.idcliente = cliente.id
    WHERE orden.fecha >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
    AND cliente.genero = 'Mujer'
    GROUP BY categoria.nombre;
    */
    function total_categorias($objeto){
        if(!isset($objeto->genero))
            $objeto->genero='';
        
        if(!isset($objeto->meses)){
                $objeto->meses=3;
            }

        $consulta=DB::table('orden')
                 ->join('detalle_orden','detalle_orden.idorden','=','orden.id')
                 ->join('producto','detalle_orden.idproducto','=','producto.id')
                 ->join('categoria','categoria.id','=','producto.categoria')
                 ->select(
                    "categoria.nombre"
                    ,DB::RAW("SUM(detalle_orden.cantidad * detalle_orden.precio) AS total")
                 )
                 ->whereRaw("orden.fecha>=DATE_SUB(now(),INTERVAL " . $objeto->meses . " MONTH)")
                 ->groupBy("categoria.nombre");

                 if($objeto->genero=''){
                    $consulta->join('cliente','orden.idcliente','=','cliente.id')
                             ->where('cliente.genero',$objeto->genero);
                 }

                 return $consulta->get();
    }
/*
select cliente.genero
    ,count(*) as total
from cliente
group by cliente.genero
*/
    function demografico_generos($objeto){
        if(!isset($objeto->idedad))
            $objeto->idedad=0;
        if(!isset($objeto->idocupacion))
            $objeto->idocupacion=0;

        $consulta=DB::table('cliente')
                    ->select(
                        'cliente.genero'
                        ,DB::Raw("count(*) as total")
                    )
                    ->groupBy('cliente.genero');
            if($objeto->idedad!=0){
                $consulta->where('cliente.idedad',$objeto->idedad);
            }
            if($objeto->idocupacion!=0){
                $consulta->where('cliente.idocupacion',$objeto->idocupacion);
            }

        return $consulta->get();
    }
}