<?php

namespace App\Servicio;
use App\Models\Orden;
use App\Models\DetalleOrden;

class ServicioOrden
{

    /*
$productos ed Lista de la oredn
$idcliente es quiene esta comprando
$idusuario es quien esta realizando la compra
$canal (opcional) representa el canal de venta
$idcanal (opcional) representa el identidicador del canal
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
        
        if (isset($objeto->canal))
            $o->canal=$objeto->canal;
        else
            $o->canal='WEB';

        if (isset($objeto->idcanal))
            $o->idcanal=$objeto->idcanal;
        else
            $o->idcanal=0;

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

        foreach($objetos->productos as $elementos){
            $d=new DetalleOrden();
            $d->idorden=$o->id;
            $d->idproducto=$elemento['id'];
            if((isset($elemento['cantidad'])))
            $d->cantidad=$elemento['cantidad'];
        else
            $d->cantidad=1;

        $d->precio=$elemento['precio'];

        if((isset($elemento['idpromocion'])))
            $d->idpromocion=$elemento['idpromocion'];
        else
            $d->idpromocion=0;

        $d->save();
        }
    }
}