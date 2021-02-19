<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">HOME</li>
            <li class="breadcrumb-item"><a href="#">ADMIN</a></li>
            <li class="breadcrumb-item active">DASHBOARD</li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> VEHÍCULOS
                    <button type="button" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;ACTUALIZAR DESDE SIDCO
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="placa">PLACA</option>
                                    <option value="marca">MARCA</option>
                                    <option value="modelo">MODELO</option>
                                    <option value="chasis">CHASIS</option>
                                    <option value="tipo">TIPO</option>
                                    <option value="anio">AÑO</option>
                                    <option value="condicion">ESTADO</option>
                                </select>
                                <input type="text" v-model="buscar" class="form-control" @keyup="listarVehiculo(1, buscar, criterio)" placeholder="TEXTO A BUSCAR">
                                <button type="submit" class="btn btn-primary" @click="listarVehiculo(1, buscar, criterio)"><i class="fa fa-search"></i> BUSCAR</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th style="text-align: center;">PLACA</th>
                                <th style="text-align: center;">MARCA</th>
                                <th style="text-align: center;">MODELO</th>
                                <th style="text-align: center;">CHASIS</th>
                                <th style="text-align: center;">TIPO</th>
                                <th style="text-align: center;">AÑO</th>
                                <th style="text-align: center;">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="vehiculo in arrayVehiculo" :key="vehiculo.id">
                                <td style="text-align: center;" v-text="vehiculo.placa"></td>
                                <td style="text-align: center;" v-text="vehiculo.marca"></td>
                                <td style="text-align: center;" v-text="vehiculo.modelo"></td>
                                <td style="text-align: center;" v-text="vehiculo.chasis"></td>
                                <td style="text-align: center;" v-text="vehiculo.tipo"></td>
                                <td style="text-align: center;" v-text="vehiculo.anio"></td>
                                <td style="text-align: center;">
                                    <div v-if="vehiculo.condicion">
                                        <span class="badge badge-success">ACTIVO</span>
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-danger">ASIGNADO</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
    </main>
</template>

<script>
    export default {

        data (){

            return {

                vehiculo_id: 0,
                modelo : '',
                placa : '',
                chasis : '',
                marca : '',
                tipo : '',
                anio : '',
                arrayVehiculo : [],
                modal : 0,
                tituloModal : '',
                tipoAccion: 0,
                errorVehiculo : 0,
                errorMostrarMsjVehiculo : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'placa',
                buscar : ''

            }

        },

        computed : {

            isActived : function(){
                return this.pagination.current_page;
            },

            pagesNumber: function() {

                if(!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;

                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);

                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];

                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;

            }

        },

        methods : {

            listarVehiculo(page, buscar, criterio){

                let me = this;
                var url = '/vehiculos?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayVehiculo = respuesta.vehiculos.data;
                    me.pagination = respuesta.pagination;
                    console.log(response);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            cambiarPagina(page, buscar, criterio){
                
                let me = this;

                me.pagination.current_page = page;
                me.listarVehiculo(page, buscar, criterio);

            }

        },

        mounted() {

            this.listarVehiculo(1, this.buscar, this.criterio);

        }

    }
</script>

<style>

    .modal-content{

        width: 100% !important;
        position: absolute !important;

    }

    .mostrar{

        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;

    }

    .div-error{

        display: flex;
        justify-content: center;

    }

    .text-error{
        color: red !important;
        font-weight: bold;
    }

</style>
