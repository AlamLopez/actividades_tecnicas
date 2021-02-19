<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">HOME</li>
            <li class="breadcrumb-item"><a href="#">ADMIN</a></li>
            <li class="breadcrumb-item active">DASHBOARD</li>
        </ol>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <i class="fa fa-align-justify"></i> REPORTE DE ACTIVIDADES TÉCNICAS
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 col-md-6 col-xs-6 form-group row">
                                        <label class="col-md-3 col-sm-3 col-xs-3 col-form-label" for="select1">CLIENTE (*):</label>
                                        <div class="col-md-8 col-sm-8 col-xs-8">
                                            <v-select 
                                                multiple
                                                @search="selectCliente" 
                                                label="nombre"
                                                v-model="clientes"
                                                :options="arrayCliente"
                                                placeholder="BUSCAR CLIENTES..."
                                            >
                                            </v-select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group row">
                                        <label class="col-md-3 col-form-label" for="select1">TÉCNICO (*):</label>
                                        <div class="col-md-8">
                                            <v-select 
                                                @search="selectTecnico"
                                                multiple  
                                                label="nombre"
                                                v-model="tecnicos"
                                                :options="arrayTecnico"
                                                placeholder="BUSCAR TÉCNICO..."
                                            >
                                            </v-select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group row">
                                        <label class="col-md-3 col-form-label" for="date-input">FECHA (*):</label>
                                        <div class="col-md-8">
                                            <datepicker 
                                                :bootstrap-styling="true" 
                                                :clear-button="true" 
                                                v-model="fecha"
                                                :format="'dd MMM yyyy'"
                                                :required="true"
                                            >
                                            </datepicker>                                  
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group row">
                                        <label class="col-md-3 col-form-label" for="select1">ACTIVIDAD (*):</label>
                                        <div class="col-md-8">
                                            <select class="form-control" v-model="actividad_id">
                                                <option value="0">SELECCIONE UNA ACTIVIDAD</option>
                                                <option value="1">INSTALACIÓN</option>
                                                <option value="2">REVISIÓN</option>
                                                <option value="3">CAMBIO DE SIM</option>
                                                <option value="4">CAMBIO DE GPS</option>
                                                <option value="5">TRASLADO DE GPS</option>
                                                <option value="6">DESINSTALACIÓN</option>
                                                <option value="7">HOMOLOGACIÓN</option>
                                                <option value="8">REINSTALACIÓN</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-sm btn-success" @click="reporteActividadTecnica()">Descargar</button>                          
                            </div>   
                        </div>  
                    </form>     
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    
    import Vue from 'vue';
    import VueRouter from 'vue-router';
    import vSelect from 'vue-select';
    import Datepicker from 'vuejs-datepicker';
    
    import 'vue-select/dist/vue-select.css';

    Vue.component('v-select', vSelect);

    export default { 
        
        components: {

            vSelect, 
            Datepicker

        },

        data (){

            return {

                clientes : [],
                tecnicos : [],
                actividad_id : 0,
                arrayCliente : [],
                arrayTecnico : [],
                fecha : '',
                errorActividadTecnica : 0,
                errorMostrarMsjActividadTecnica : [],

            }

        },

        mounted(){
            
            this.getSession();

        },

        methods : {

            getSession(){

                // Obtener el id del usuario logueado 

                let me = this;

                var url = '/usuarios/getUser';

                axios.get(url).then(function (response){

                    let respuesta = response.data;
                    me.ingresado_por = respuesta.usuario.id;
                    console.log(response);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },
            
            selectCliente(search, loading){

                // Buscar los clientes que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/clientes/selectClientes?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.arrayCliente = respuesta.clientes;
                    loading(false);
                    console.log(response);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            selectTecnico(search, loading){

                // Buscar los tecnicos que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/tecnicos/selectTecnicos?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.arrayTecnico = respuesta.tecnicos;
                    loading(false);
                    console.log(response);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            reporteActividadTecnica(){
                let me = this;
                axios.post('/reportes/actividadtecnica', {
                    responseType: 'blob',
                    'clientes' : me.clientes,
                    'tecnicos' : me.tecnicos,
                    'fecha' : me.fecha,
                    'actividad_id' : me.actividad_id,
                }).then((response) => {
                    
                    /*var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                    var fileLink = document.createElement('a');

                    fileLink.href = fileURL;
                    fileLink.setAttribute('download', 'instalacion.xlsx');
                    document.body.appendChild(fileLink);

                    fileLink.click();*/
                    
                    /*
                    let blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })

                    let link = document.createElement('a')
                    link.href = window.URL.createObjectURL(blob)
                    link.download = 'instalacion.xlsx'
                    link.click()*/
                    

                    me.clientes = [];
                    me.tecnicos = [];
                    me.actividad_id = 0;
                    me.fecha = '';

                });
            }

            
        }

    }
</script>