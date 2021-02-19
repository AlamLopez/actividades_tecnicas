<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">HOME</li>
            <li class="breadcrumb-item"><a href="#">ADMIN</a></li>
            <li class="breadcrumb-item active">DASHBOARD</li>
        </ol>
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value display-4" v-text="cantidadClientes"></div>
                                    <div>CLIENTES</div>
                                </div>
                                <div class="chart-wrapper mt-3 mx-3" style="height:40px;">
                                    <canvas class="chart" id="card-chart1" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-success">
                                <div class="card-body pb-0">
                                    <div class="text-value display-4" v-text="cantidadVehiculos"></div>
                                    <div>VEHÍCULOS</div>
                                </div>
                                <div class="chart-wrapper mt-3 mx-3" style="height:40px;">
                                    <canvas class="chart" id="card-chart2" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-warning">
                                <div class="card-body pb-0">
                                    <div class="text-value display-4" v-text="cantidadSimcards"></div>
                                    <div>SIMCARDS</div>
                                </div>
                                <div class="chart-wrapper mt-3" style="height:40px;">
                                    <canvas class="chart" id="card-chart3" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-danger">
                            <div class="card-body pb-0">
                                <div class="text-value display-4" v-text="cantidadGps"></div>
                                <div>DISPOSITIVOS GPS</div>
                            </div>
                            <div class="chart-wrapper mt-3 mx-3" style="height:40px;">
                                <canvas class="chart" id="card-chart4" height="40"></canvas>
                            </div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    <!-- /.row-->
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value display-4" v-text="cantidadTecnicos"></div>
                                    <div>TÉCNICOS</div>
                                </div>
                                <div class="chart-wrapper mt-3 mx-3" style="height:40px;">
                                    <canvas class="chart" id="card-chart1" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-success">
                                <div class="card-body pb-0">
                                    <div class="text-value display-4" v-text="cantidadUsuarios"></div>
                                    <div>USUARIOS</div>
                                </div>
                                <div class="chart-wrapper mt-3 mx-3" style="height:40px;">
                                    <canvas class="chart" id="card-chart2" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-warning">
                                <div class="card-body pb-0">
                                    <div class="text-value display-4" v-text="cantidadActiTecnica"></div>
                                    <div>ACTIVIDADES TÉCNICAS</div>
                                </div>
                                <div class="chart-wrapper mt-3" style="height:40px;">
                                    <canvas class="chart" id="card-chart3" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-danger">
                            <div class="card-body pb-0">
                                <div class="text-value display-4" v-text="cantidadActiTecniPendiente"></div>
                                <div>ACTIVIDADES TÉCNICAS PENDIENTES</div>
                            </div>
                            <div class="chart-wrapper mt-3 mx-3" style="height:40px;">
                                <canvas class="chart" id="card-chart4" height="40"></canvas>
                            </div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    <!-- /.row-->
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    export default {

        data (){

            return {

                cantidadClientes : 0,
                cantidadVehiculos : 0,
                cantidadSimcards : 0,
                cantidadGps : 0,
                cantidadTecnicos : 0,
                cantidadUsuarios : 0,
                cantidadActiTecnica: 0,
                cantidadActiTecniPendiente : 0

            }

        },

        methods : {

            contar(){

                let me = this;
                var url = '/conteo';
                
                axios.get(url).then(function (response) {
                    
                    var respuesta = response.data;

                    me.cantidadClientes = respuesta.cantidadClientes;
                    me.cantidadVehiculos = respuesta.cantidadVehiculos;
                    me.cantidadSimcards = respuesta.cantidadSimcards;
                    me.cantidadGps = respuesta.cantidadGps;
                    me.cantidadTecnicos = respuesta.cantidadTecnicos;
                    me.cantidadUsuarios = respuesta.cantidadUsuarios;
                    me.cantidadActiTecnica = respuesta.cantidadActiTecnicas;
                    me.cantidadActiTecniPendiente = respuesta.cantidadActiTecniPendiente;
                    
                    console.log(response);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            }

        },

        mounted() {

            this.contar();

        }

    }
</script>