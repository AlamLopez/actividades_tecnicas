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
                                <i class="fa fa-align-justify"></i> NUEVA ACTIVIDAD TÉCNICA
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 col-md-4 col-xs-4"></div>
                                    <div class="col-sm-4 col-md-4 col-xs-4">
                                        <p class="card-text">Todos los campos que incluyen (*) son obligatorios.</p>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-xs-4"></div>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="col-sm-6 col-md-6 col-xs-6 form-group row">
                                        <label class="col-md-3 col-sm-3 col-xs-3 col-form-label" for="select1">CLIENTE (*):</label>
                                        <div v-if="ventana==0" class="col-md-8 col-sm-8 col-xs-8">
                                            <v-select 
                                                @input="getDatosCliente"
                                                @search="selectCliente" 
                                                label="nombre"
                                                v-model="cliente.nombre"
                                                :options="arrayCliente"
                                                placeholder="BUSCAR CLIENTES..."
                                            >
                                            </v-select>
                                        </div>
                                        <label v-else class="col-md-8 col-form-label" v-text="cliente.nombre"></label>
                                    </div>
                                    <div class="col-md-6 form-group row">
                                        <label class="col-md-3 col-form-label" for="select1">TÉCNICO (*):</label>
                                        <div v-if="ventana==0" class="col-md-8">
                                            <v-select 
                                                @input="getDatosTecnico"
                                                @search="selectTecnico" 
                                                label="nombre"
                                                v-model="tecnico.nombre"
                                                :options="arrayTecnico"
                                                placeholder="BUSCAR TÉCNICO..."
                                            >
                                            </v-select>
                                        </div>
                                        <label v-else class="col-md-8 col-form-label" v-text="tecnico.nombre"></label>
                                    </div>
                                    <div class="col-md-6 form-group row">
                                        <label class="col-md-3 col-form-label" for="date-input">FECHA (*):</label>
                                        <div v-if="ventana==0" class="col-md-8">
                                            <datepicker 
                                                :bootstrap-styling="true" 
                                                :clear-button="true" 
                                                v-model="fecha"
                                                :format="'dd MMM yyyy'"
                                                :required="true"
                                            >
                                            </datepicker>                                        
                                        </div>
                                        <label v-else class="col-md-8 col-form-label" v-text="fecha"></label>
                                    </div>
                                    <div class="col-md-6 form-group row">
                                        <label class="col-md-3 col-form-label" for="select1">ACTIVIDAD (*):</label>
                                        <div v-if="ventana==0" class="col-md-8">
                                            <select class="form-control" v-model="actividad_id" @change="validarActividadTecnica">
                                                <option value="0">SELECCIONE UNA ACTIVIDAD</option>
                                                <option value="INSTALACION">INSTALACIÓN</option>
                                                <option value="REVISION">REVISIÓN</option>
                                                <option value="CAMBIO DE SIM">CAMBIO DE SIM</option>
                                                <option value="CAMBIO DE GPS">CAMBIO DE GPS</option>
                                                <option value="TRASLADO DE GPS">TRASLADO DE GPS</option>
                                                <option value="DESINSTALACION">DESINSTALACIÓN</option>
                                                <option value="HOMOLOGACION">HOMOLOGACIÓN</option>
                                                <option value="REINSTALACION">REINSTALACIÓN</option>
                                            </select>
                                        </div>
                                        <label v-else class="col-md-8 col-form-label" v-text="actividad_id"></label>
                                    </div>
                                </div>
                                <div v-show="errorActividadTecnica" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjActividadTecnica" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                            <template v-if="actividad_id=='INSTALACION'">
                                <instalacionnueva   ref="instalacion"
                                                    @resetear_actividad="resetearActividad">
                                </instalacionnueva>
                            </template>
                            <template v-if="actividad_id=='REVISION'">
                                <revision   ref="revision"
                                            @resetear_actividad="resetearActividad">
                                </revision>
                            </template>
                            <template v-if="actividad_id=='CAMBIO DE SIM'">
                                <cambiosim  ref="cambiosim"
                                            @resetear_actividad="resetearActividad">
                                </cambiosim>
                            </template>
                            <template v-if="actividad_id=='CAMBIO DE GPS'">
                                <cambiogps  ref="cambiogps"
                                            @resetear_actividad="resetearActividad"></cambiogps>
                            </template>
                            <template v-if="actividad_id=='TRASLADO DE GPS'">
                                <trasladogps ref="trasladogps"
                                            @resetear_actividad="resetearActividad">
                                </trasladogps>
                            </template>
                            <template v-if="actividad_id=='DESINSTALACION'">
                                <desinstalacion ref="desinstalacion"
                                                @resetear_actividad="resetearActividad">
                                </desinstalacion>
                            </template>
                            <template v-if="actividad_id=='HOMOLOGACION'">
                                <homologacion   ref="homologacion"
                                                @resetear_actividad="resetearActividad">
                                </homologacion>
                            </template>
                            <template v-if="actividad_id=='REINSTALACION'">
                                <reinstalacion  ref="reinstalacion"
                                                @resetear_actividad="resetearActividad">
                                </reinstalacion>
                            </template>
        
                    </form>
                    <div class="card" v-if="actividad_id !== '0'">
                        <div class="card-footer">
                            <button class="btn btn-sm btn-primary" @click="registrarActividadTecnica()">
                                <i class="fa fa-dot-circle-o"></i>&nbsp;GUARDAR
                            </button>
                            <button class="btn btn-sm btn-danger" type="reset">
                                <i class="fa fa-ban"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import Datepicker from 'vuejs-datepicker';

    import 'vue-select/dist/vue-select.css';

    import cambiosim from '../../components/actividad_tecnica/CambioSim.vue';
    import cambiogps from '../../components/actividad_tecnica/CambioGps.vue';
    import desinstalacion from '../../components/actividad_tecnica/Desinstalacion.vue';
    import homologacion from '../../components/actividad_tecnica/Homologacion.vue';
    import instalacion from '../../components/actividad_tecnica/InstalacionNueva.vue';
    import reinstalacion from '../../components/actividad_tecnica/Reinstalacion.vue';
    import revision from '../../components/actividad_tecnica/Revision.vue';
    import trasladogps from '../../components/actividad_tecnica/TrasladoGps.vue';


    Vue.component('v-select', vSelect);

    export default { 

        name : 'actividadtecnica',
        
        components: {

            vSelect, 
            Datepicker, 
            cambiosim,
            cambiogps,
            desinstalacion,
            homologacion,
            instalacion,
            reinstalacion,
            revision,
            trasladogps,

        },

        data (){

            return {

                cliente : {
                    id : 0,
                    nombre : ''
                },

                tecnico: {
                    id: 0,
                    nombre : ''
                },

                ventana : 0,
                cliente_id : 0,
                tecnico_id : 0,
                fecha: '',
                ingresado_por: 0,
                revisado_por: 0,
                revisado: false,
                actividad_id: '0',
                arrayCliente : [],
                arrayTecnico : [],
                errorActividadTecnica : 0,
                errorMostrarMsjActividadTecnica : [],

            }

        },

        mounted(){
            
            this.getSession();

        },

        methods : {

            resetearActividad(newValue) {

                // Asigna los valores por defecto a la data
                
                let me = this;
                
                me.actividad_id = newValue  // 3.Updating
                me.ventana = 0;

            },

            registrarActividadTecnica(){

                // Enviar los datos de la actividad tecnica al controlador
                // Al finalizar se recuperan los valores por defecto a la data

                let me = this;

                if(me.actividad_id === 'CAMBIO DE SIM'){
                    if(me.$refs.cambiosim.validarCambioSim()){
                        return;
                    }
                }

                if(me.actividad_id === 'CAMBIO DE GPS'){
                    if(me.$refs.cambiogps.validarCambioGps()){
                        return;
                    }
                }

                if(me.actividad_id === 'DESINSTALACION'){
                    if(me.$refs.desinstalacion.validarDesinstalacion()){
                        return;
                    }
                }

                if(me.actividad_id === 'HOMOLOGACION'){
                    if(me.$refs.homologacion.validarHomologacion()){
                        return;
                    }
                }

                if(me.actividad_id === 'INSTALACION'){
                    if(me.$refs.instalacion.validarInstalacion()){
                        return;
                    }
                }

                if(me.actividad_id === 'REINSTALACION'){
                    if(me.$refs.reinstalacion.validarReinstalacion()){
                        return;
                    }
                }

                if(me.actividad_id === 'REVISION'){
                    if(me.$refs.revision.validarRevision()){
                        return;
                    }
                }

                if(me.actividad_id === 'TRASLADO DE GPS'){
                    if(me.$refs.trasladogps.validarTrasladoGps()){
                        return;
                    }
                }

                axios.post('/actividadestecnicas/registrar', {

                    'nombre': this.actividad_id,
                    'id_tecnico': this.tecnico_id,
                    'id_cliente': this.cliente_id,
                    'ingresado_por': this.ingresado_por,
                    'revisado': this.revisado,
                    'fecha': this.fecha,

                }).then(function (response) {

                    if(me.actividad_id === 'CAMBIO DE SIM') me.$refs.cambiosim.registrarCambioSim(response.data.actividad.id);
                    if(me.actividad_id === 'CAMBIO DE GPS') me.$refs.cambiogps.registrarCambioGps(response.data.actividad.id);
                    if(me.actividad_id === 'DESINSTALACION') me.$refs.desinstalacion.registrarDesinstalacion(response.data.actividad.id);
                    if(me.actividad_id === 'HOMOLOGACION') me.$refs.homologacion.registrarHomologacion(response.data.actividad.id);
                    if(me.actividad_id === 'INSTALACION') me.$refs.instalacion.registrarInstalacion(response.data.actividad.id);
                    if(me.actividad_id === 'REINSTALACION') me.$refs.reinstalacion.registrarReinstalacion(response.data.actividad.id);
                    if(me.actividad_id === 'REVISION') me.$refs.revision.registrarRevision(response.data.actividad.id);
                    if(me.actividad_id === 'TRASLADO DE GPS') me.$refs.trasladogps.registrarTrasladoGps(response.data.actividad.id);

                    me.cliente_id = 0;
                    me.cliente.id = 0;
                    me.cliente.nombre = '';
                    me.tecnico_id = 0;
                    me.tecnico.id = 0;
                    me.tecnico.nombre = '';
                    me.fecha = '';
                    me.actividad_id = '0';
                    me.arrayCliente = [];
                    me.arrayTecnico = [];
                    me.ventana = 0;

                    Swal.fire({
                            
                        position: 'top-end',
                        icon: 'success',
                        title: 'ACTIVIDAD TÉCNICA INGRESADA',
                        showConfirmButton: false,
                        timer: 1500

                    });

                }).catch(function (error) {

                    console.log(error);

                });

            },

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

            getDatosCliente(val1){

                // Asignar los datos del cliente seleccionado a la data

                let me = this;
                me.loading = true;

                if(val1 !== null){
                    me.cliente_id = val1.id;
                    me.cliente.id = me.cliente_id;
                    me.cliente.nombre = val1.nombre;
                }else{
                    me.cliente_id = 0;
                    me.cliente.id = 1;
                    me.cliente.nombre = '';
                }
                

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

            getDatosTecnico(val1){

                // Asignar los datos del tecnico seleccionado a la data

                let me = this;
                me.loading = true;

                if(val1 !== null){
                    me.tecnico.id = val1.id;
                    me.tecnico_id = me.tecnico.id
                    me.tecnico.nombre = val1.nombre;
                }else{
                    me.tecnico_id = 0;
                    me.tecnico.id = 0;
                    me.tecnico.nombre = '';
                }

            },

            validarActividadTecnica(){
                
                // Validar que al seleccionar una actividad, ya exista un cliente, un tecnico y una fecha
                
                this.errorActividadTecnica = 0;
                this.errorMostrarMsjActividadTecnica = [];

                if(!this.cliente_id) this.errorMostrarMsjActividadTecnica.push("DEBE SELECCIONAR UN CLIENTE.");
                if(!this.tecnico.nombre) this.errorMostrarMsjActividadTecnica.push("DEBE SELECCIONAR UN TÉCNICO.");
                if(!this.fecha) this.errorMostrarMsjActividadTecnica.push("DEBE SELECCIONAR UNA FECHA.");

                if(this.errorMostrarMsjActividadTecnica.length){
                    this.errorActividadTecnica = 1;
                    this.ventana = 0;
                    this.actividad_id = '0';
                }else{
                    this.ventana = 1;
                }

                return this.errorActividadTecnica;

            }
            
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


