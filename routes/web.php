<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoffeshopController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CategoriaExtraController;
use App\Http\Controllers\TamanioController;
use App\Http\Controllers\ExtraController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\DbupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EdadController;
use App\Http\Controllers\OcupacionController;
use App\Http\Controllers\RolController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware'=>'auth'], function (){

Route::get('/venta',[CoffeshopController::class, 'venta'])->name('venta');
Route::get('/venta/productos',[CoffeshopController::class, 'productos'])->name('productos');
Route::get('/venta/categorias',[CoffeshopController::class, 'categorias'])->name('categorias');
Route::get('/venta/tamanios',[CoffeshopController::class, 'tamanios'])->name('tamanios');
//Route::post('/venta/save',[CoffeshopController::class, 'guardar_orden'])->name('guardar_orden');

//Catalogo tipo de Categorias
Route::get('/categoria', [CategoriaController::class, 'categoria'])->name ('categoria');
Route::get('categoria/formulario/{id?}', [CategoriaController::class, 'formulario'])->name ('categoria.formulario');
Route::post('categoria/guardar', [CategoriaController::class, 'guardar'])->name ('categoria.guardar');


//Catalogo tipo de Categorias extras
Route::get('/categoriaExtra', [CategoriaExtraController::class, 'categoriaExtra'])->name ('categoriaExtra');
Route::get('categoriaExtra/formulario/{id?}', [CategoriaExtraController::class, 'formulario'])->name ('categoriaExtra.formulario');
Route::post('categoriaExtra/guardar', [CategoriaExtraController::class, 'guardar'])->name ('categoriaExtra.guardar');

//Catalogo tipo de Tamanios
Route::get('/tamanio', [TamanioController::class, 'tamanio'])->name ('tamanio');
Route::get('tamanio/formulario/{id?}', [TamanioController::class, 'formulario'])->name ('tamanio.formulario');
Route::post('tamanio/guardar', [TamanioController::class, 'guardar'])->name ('tamanio.guardar');

//Catalogo tipo de Extras
Route::get('/extra', [ExtraController::class, 'extra'])->name ('extra');
Route::get('extra/formulario/{id?}', [ExtraController::class, 'formulario'])->name ('extra.formulario');
Route::post('extra/guardar', [ExtraController::class, 'guardar'])->name ('extra.guardar');


//Catalogo tipo de Productos
Route::get('/producto', [ProductoController::class, 'producto'])->name ('producto');
Route::get('producto/formulario/{id?}', [ProductoController::class, 'formulario'])->name ('producto.formulario');
Route::post('producto/guardar', [ProductoController::class, 'guardar'])->name ('producto.guardar');

// Catálogo Usuario
Route::get('/usuario', [UsuarioController::class, 'lista'])->name('lista');
Route::get('/usuario/formulario/{id?}', [UsuarioController::class, 'formulario'])->name('usuario.formulario');
Route::post('/usuario/save', [UsuarioController::class, 'save'])->name('usuario.save');

//Catalogo edad
Route::get('/edad', [EdadController::class,'edad'])->name('edad');
Route::get('/edad/formulario/{id?}',[EdadController::class,'formulario'])->name('edad.formulario');
Route::post('/edad/guardar',[EdadController::class,'guardar'])->name('edad.guardar');

// Catalogo ocupacion
Route::get('/ocupacion', [OcupacionController::class,'ocupacion'])->name('ocupacion');
Route::get('/ocupacion/formulario/{id?}',[OcupacionController::class,'formulario'])->name('ocupacion.formulario');
Route::post('/ocupacion/guardar',[OcupacionController::class,'guardar'])->name('ocupacion.guardar');

// Catalogo Rol
Route::get('/rol',[RolController::class,'rol'])->name('rol');
Route::get('/rol/formulario/{id?}',[RolController::class,'formulario'])->name('rol.formulario');
Route::post('/rol/guardar',[RolController::class,'guardar'])->name('rol.guardar');

//DBup / faker
Route::get('/dbup/cliente', [DbupController::class, 'clientes']);
Route::get('/dbup/orden', [DbupController::class, 'orden']);
// Route::post('/dashboard/ventas', [DashboardController::class, 'total_venta']);
Route::match(['GET','POST'],'/dashboard/ventas', [DashboardController::class, 'total_venta']);
Route::match(['GET','POST'],'/dashboard/ventas/categorias', [DashboardController::class, 'total_ventas_categorias']);
Route::match(['GET','POST'],'/dashboard/ventas/producto_genero',[DashBoardController::class, 'ventas_producto_genero'])->name('ventas_producto_genero');
Route::get('/dashboard/ventas/canal', [DashboardController::class, 'total_venta_canal']);
Route::get('/dashboard/ventas/productos', [DashboardController::class, 'total_venta_producto']);
Route::match(['GET','POST'],'/dashboard/demogratafico/genero', [DashboardController::class, 'demografico_genero']);
Route::match(['GET','POST'],'/dashboard/demografico/edad',[DashboardController::class, 'demografico_edad'])->name('demografico_edad');
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::post('/dashboard/ventas/productos',[DashboardController::class,'ventas_producto_genero']);
});
 

use App\Http\Controllers\Auth\SignupController;
Route::get('/signup', [SignupController::class, 'show'])->name('signup.show');
Route::post('/signup', [SignupController::class, 'register'])->name('signup.register');

use App\Http\Controllers\Auth\LoginController;
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');