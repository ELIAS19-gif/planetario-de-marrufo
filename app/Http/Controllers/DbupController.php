<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Usuario;
use App\Models\Edad;
use App\Models\Extra;
use App\Models\Ocupacion;
use App\Models\Producto;
use App\Servicio\ServicioOrden;
use Faker\Factory as Faker;

class DbUpController extends Controller
{
    var $generos = ['Hombre','Mujer','No indica'];
    var $canales = ['WEB','APP','KIOSKO','TAQUILLA'];

    // Usuarios y clientes
    public function clientes()
    {
        $faker = Faker::create();
        $edades = Edad::all();
        $ocupaciones = Ocupacion::all();

        for ($i = 1; $i <= 100; $i++) {
            $usuario = new Usuario();
            $usuario->idrol = 2;
            $usuario->password = bcrypt('123456');
            $usuario->email = $faker->email;
            $usuario->save();

            $nombre = $faker->name;
            $apellido = $faker->lastname;

            $cliente = new Cliente();
            $cliente->idusuario = $usuario->id;
            $cliente->nombre = $nombre . ' ' . $apellido;
            $cliente->idedad = $edades->random()->id;
            $cliente->idocupacion = $ocupaciones->random()->id;
            $cliente->genero = $faker->randomElement($this->generos);
            $cliente->fecha_registro=$faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now');
            $cliente->save();
        }
    }

    // Órdenes
    public function orden(){
        $servicio = new ServicioOrden();
        $faker = Faker::create();
        $clientes = Cliente::all();
        $productos = Producto::all();
        $extras = Extra::all(); // agregado para generar extras
        for ($i = 1; $i <= 100; $i++) {
            $objeto = new \StdClass();
            $objeto->idusuario = 0;
            $objeto->idcliente = $clientes->random()->id;
            $objeto->canal = $faker->randomElement($this->canales);
            $objeto->idcanal = 0;
            $objeto->fecha = $faker->dateTimeBetween('-1 year', 'now');
            $num_productos = $faker->numberBetween(1, count($productos));
            $lista_productos = $productos->random($num_productos);
            $objeto->productos = [];
            foreach ($lista_productos as $p) {
                /* GENERAR EXTRAS ALEATORIOS */
                $cantidad_extras = $faker->numberBetween(1, count($extras));
                $extras_random = $extras->random($cantidad_extras);
                $lista_extras = [];
                foreach ($extras_random as $extra) {
                    $lista_extras[] = [
                        "id" => $extra->id,
                        "precio" => $extra->precio,
                        "cantidad" => $faker->numberBetween(1, 10)
                    ];
                }
                $objeto->productos[] = [
                    "id" => $p->id,
                    "cantidad" => 1,
                    "precio" => $p->precio,
                    "extras" => $lista_extras
                ];
            }
            $servicio->registrar($objeto);
        }
    }
}
    //Ordenes

