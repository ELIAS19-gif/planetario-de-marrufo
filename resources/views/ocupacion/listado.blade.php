@extends('app.master')

@section('contenido')
<div id="app" class="p-4 bg-gray-50 min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Listado de Ocupaciones</h2>
        <a href="{{ route('ocupacion.formulario') }}" class="btn btn-outline-secondary">
            Agregar Ocupacion
        </a>
    </div>

    <div v-if="ocupacion.length > 0">
        <div v-for="ocupacion in ocupacion" :key="ocupacion.id" class="mb-3">
            <div class="flex items-center justify-between gap-4 rounded-xl border border-gray-200 p-4 shadow-sm bg-white hover:shadow-md transition">
                
                <div class="flex flex-col gap-1">
                    <a :href="'/ocupacion/formulario/' + ocupacion.id" class="text-[#181511] text-lg font-bold hover:text-blue-600 transition">
                        @{{ocupacion.nombre}}
                    </a>
                   
                </div>
            </div>
        </div>
    </div>

</div>
@section('script')
    <script>
        var app = new Vue({
            el: '#app',
            //estado inicial de los datos
            data: function() {
               return {
                   ocupacion: <?php echo json_encode($ocupacion); ?>,
               }
            }
        });
    </script>
@endsection
@endsection