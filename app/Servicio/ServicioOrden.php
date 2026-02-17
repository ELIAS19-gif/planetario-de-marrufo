<?php

namespace App\Servicio;
use App\Models\Orden;

class ServicioOrden
{

    /*
$productos ed Lista de la oredn
$idcliente es quiene esta comprando
$idusuario es quien esta realizando la compra
$canal representa el canal de venta
$idcanal representa el identidicador del canal
$fecha (opcional) representa la fecha de venta
$status (opcional)
 */
    //function registrar($producos,$idcliente,$idusuario,$canal,$idcanal){
    function registrar($objeto)
    {
        $o = new Orden();
        $o->idusuario=$objeto->idusuario;
        $o->idcliente=$objeto->idcliente;
        $o->total = 0;
        
        if (isset($objeto->fecha))
            $o->canal=$objeto->canal;
        else
            $o->canal='APP';

        $o->idcanal=$objeto->idcanal;

        if (isset($objeto->fecha))
            $o->fecha=$objeto->fecha;
        else
            $o->fecha=hoy();

        if (isset($objeto->status))
            $o->status=$objeto->status;
        else
            $o->status=1;

        $o->num_productos=0;
        $o->save();
    }
}
