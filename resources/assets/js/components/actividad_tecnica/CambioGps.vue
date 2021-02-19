<template>
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <i class="fa fa-align-justify"></i> CAMBIO DE GPS
            <button type="button" @click="resetear()" class="close" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="card-body border">
            <div class="row">
                <div class="col-sm-4 col-md-4 col-xs-4"></div>
                <div class="col-sm-4 col-md-4 col-xs-4">
                    <p class="card-text">Todos los campos que incluyen (*) son obligatorios.</p>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-4"></div>
                <br>
                <br>
                <br>
                <div class="col-md-4 form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">NOMBRE (*):</label>
                    <div class="col-md-9">
                        <input class="form-control" id="text-input" type="text" name="text-input" v-model="nombre" placeholder="Text">
                    </div>
                </div>
                <div class="col-md-4 form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">PLACA (*):</label>
                    <div class="col-md-9">
                        <v-select 
                            @input="getDatosVehiculo"
                            @search="selectVehiculo" 
                            label="placa"
                            v-model="placa"
                            :options="arrayVehiculo"
                            placeholder="BUSCAR PLACAS..."
                        >
                        </v-select>
                    </div>
                </div>
                <div class="col-md-4 form-group row"></div>
            </div>
        </div>
        <div class="card-body border">
            <div class="row">
                <div class="col-md-4 form-group row">
                    <label class="col-md-5 col-form-label" for="text-input">ID GPS ANTERIOR (*):</label>
                    <div class="col-md-7">
                        <input class="form-control" id="text-input" type="text" name="text-input" v-model="id_dispositivo_viejo" placeholder="Text">
                    </div>
                </div>
                <div class="col-md-8 form-group row"></div>
                <div class="col-md-6 form-group row">
                    <label class="col-md-8 col-form-label" for="text-input">DISPOSITIVO GPS ANTERIOR (*):</label>
                    <div class="col-md-10">
                        <v-select 
                            @input="getDatosGpsViejo"
                            @search="selectGpsViejo" 
                            label="imei"
                            :options="arrayGpsViejo"
                            placeholder="BUSCAR DISPOSITIVOS..."
                        >
                        </v-select>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-3 form-group row">
                    <label class="col-md-4 col-form-label" for="text-input">IMEI:</label>
                    <div class="col-md-8" v-text="gps_viejo.imei">
                    </div>
                </div>
                <div class="col-md-3 form-group row">
                    <label class="col-md-4 col-form-label" for="text-input">SERIE:</label>
                    <div class="col-md-8" v-text="gps_viejo.serie">
                    </div>
                </div>
                <div class="col-md-3 form-group row">
                    <label class="col-md-4 col-form-label" for="text-input">MARCA:</label>
                    <div class="col-md-8" v-text="gps_viejo.marca">
                    </div>
                </div>
                <div class="col-md-3 form-group row">
                    <label class="col-md-4 col-form-label" for="text-input">MODELO:</label>
                    <div class="col-md-8" v-text="gps_viejo.modelo">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border">
            <div class="row">
                <div class="col-md-4 form-group row">
                    <label class="col-md-5 col-form-label" for="text-input">ID GPS NUEVO (*):</label>
                    <div class="col-md-7">
                        <input class="form-control" id="text-input" type="text" name="text-input" v-model="id_dispositivo_nuevo" placeholder="Text">
                    </div>
                </div>
                <div class="col-md-8 form-group row"></div>
                <div class="col-md-6 form-group row">
                    <label class="col-md-8 col-form-label" for="text-input">DISPOSITIVO GPS NUEVO (*):</label>
                    <div class="col-md-10">
                        <v-select 
                            @input="getDatosGpsNuevo"
                            @search="selectGpsNuevo" 
                            label="imei"
                            :options="arrayGpsNuevo"
                            placeholder="BUSCAR DISPOSITIVOS..."
                        >
                        </v-select>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-3 form-group row">
                    <label class="col-md-4 col-form-label" for="text-input">IMEI:</label>
                    <div class="col-md-8" v-text="gps_nuevo.imei">
                    </div>
                </div>
                <div class="col-md-3 form-group row">
                    <label class="col-md-4 col-form-label" for="text-input">SERIE:</label>
                    <div class="col-md-8" v-text="gps_nuevo.serie">
                    </div>
                </div>
                <div class="col-md-3 form-group row">
                    <label class="col-md-4 col-form-label" for="text-input">MARCA:</label>
                    <div class="col-md-8" v-text="gps_nuevo.marca">
                    </div>
                </div>
                <div class="col-md-3 form-group row">
                    <label class="col-md-4 col-form-label" for="text-input">MODELO:</label>
                    <div class="col-md-8" v-text="gps_nuevo.modelo">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border">
            <div class="row">
                <div class="col-md-6 form-group row">
                    <label class="col-md-8 col-form-label" for="text-input">SIMCARD NUEVO (*):</label>
                    <div class="col-md-10">
                        <v-select 
                            @input="getDatosSimNuevo"
                            @search="selectSimNuevo" 
                            label="imsi"
                            :options="arraySimNuevo"
                            placeholder="BUSCAR SIMCARDS..."
                        >
                        </v-select>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-4 form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">SIM:</label>
                    <div class="col-md-9" v-text="simcard_nuevo.sim">
                    </div>
                </div>
                <div class="col-md-4 form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">IP:</label>
                    <div class="col-md-9" v-text="simcard_nuevo.ip">
                    </div>
                </div>
                <div class="col-md-4 form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">TELÉFONO:</label>
                    <div class="col-md-9" v-text="simcard_nuevo.telefono">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border">
            <div class="row">
                <div class="col-md-4 form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">LUGAR (*):</label>
                    <div class="col-md-9">
                        <input class="form-control" id="text-input" type="text" name="text-input" v-model="lugar" placeholder="Text">
                    </div>
                </div>
                <div class="col-md-8 form-group row">
                    <label class="col-md-3 col-form-label">PRUEBAS REALIZADAS:</label>
                    <div class="col-md-9 col-form-label">
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-checkbox1" type="checkbox" v-model="cortemotor" value="check1">
                            <label class="form-check-label" for="inline-checkbox1">CORTE DE MOTOR</label>
                        </div>
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-checkbox2" type="checkbox" v-model="panico" value="check2">
                            <label class="form-check-label" for="inline-checkbox2">PÁNICO</label>
                        </div>
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" id="inline-checkbox3" type="checkbox" v-model="posicion" value="check3">
                            <label class="form-check-label" for="inline-checkbox3">POSICIÓN</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 form-group row">
                    <label class="col-md-1 col-form-label" for="text-input">OTRAS PRUEBAS:</label>
                    <div class="col-md-11">
                        <input class="form-control" id="text-input" type="text" name="text-input" v-model="otros" placeholder="Text">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border">
            <div class="row">
                <div class="col-md-12 form-group row">
                    <label class="col-md-2 col-form-label" for="text-input">OBSERVACIONES:</label>
                    <div class="col-md-10">
                        <textarea class="form-control observaciones" cols="30" rows="3" name="text-input" v-model="observaciones" placeholder="Text"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border">
            <div class="row">
                <div class="col-md-6 form-group row">
                    <label class="col-md-3 col-form-label" for="file-multiple-input">FOTOS:</label>
                    <div class="col-md-9">
                        <input
                            type="file"
                            multiple
                            :ref="'image'"
                            accept="image/*"
                            @change="onFileChange"
                        />
                    </div>
                </div>
                <div class="col-md-6 form-group row"></div>
            </div>
            <div class="row">
                <div v-for="(image, key) in images" :key="key" class="col-md-4">
                    <img class="img-thumbnail img-rounded img-responsive" :ref="'image'" />
                </div>
            </div>
        </div>
        <div v-show="errorCambioGps" class="form-group row div-error">
            <div class="text-center text-error">
                <div v-for="error in errorMostrarMsjCambioGps" :key="error" v-text="error">

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    
    import Vue from 'vue';
    import vSelect from 'vue-select';

    import 'vue-select/dist/vue-select.css';

    Vue.component('v-select', vSelect);

    export default {        

        data (){

            return {

                gps_viejo : {
                    id : 0,
                    imei : '',
                    serie : '',
                    marca : '',
                    modelo : ''
                },

                gps_nuevo : {
                    id : 0,
                    imei : '',
                    serie : '',
                    marca : '',
                    modelo : ''
                },

                simcard_nuevo : {
                    id : 0,
                    sim : '',
                    ip : '',
                    telefono : ''
                },

                nombre : '',
                placa : '',
                id_dispositivo_viejo : '',
                id_dispositivo_nuevo : '',
                lugar : '',
                cortemotor : false,
                panico : false,
                posicion: false,
                otros: '',
                observaciones: '',
                arrayGpsViejo : [],
                arrayGpsNuevo : [],
                arraySimNuevo : [],
                arrayVehiculo : [],
                images: [],
                errorCambioGps : 0,
                errorMostrarMsjCambioGps : [],

            }

        },

        methods : {

            onFileChange(e) {

                // Obtener la informacion de las imagenes que selecciona el usuario en formato base64

                let vm = this;
                vm.images = [];

                let selectedFiles = e.target.files || e.dataTransfer.files;
                let file = document.querySelector('input[type=file]').files;

                for (let i = 0; i < selectedFiles.length; i++) {
                    
                    console.log(selectedFiles[i]);
                    vm.images.push(selectedFiles[i]);

                }

                for (let i = 0; i < vm.images.length; i++) {
                    
                    let reader = new FileReader();
                    
                    reader.onload = (e) => {
                        vm.$refs.image[i].src = reader.result;
                        vm.images[i] = e.target.result;
                        console.log(vm.$refs.image[i].src);
                    };

                    reader.readAsDataURL(file[i]);
                }

            },

            resetear(){
                
                // Cancelar el cambio de sim

                let me = this;

                me.$emit('resetear_actividad', '0')

            },

            registrarCambioGps(actividad){

                // Enviar los datos del cambio de sim al controlador
                // Al finalizar regresamos al metodo registrarActividadTecnica en el componente ActividadTecnica

                let me = this;

                axios.post('/cambiogps/registrar', {
                    
                    'id_actividadtecnica' : actividad,
                    'nombre' : me.nombre,
                    'placa' : me.placa,
                    'id_dispositivo_viejo' : me.id_dispositivo_viejo,
                    'id_gps_viejo' : me.gps_viejo.id,
                    'id_dispositivo_nuevo' : me.id_dispositivo_nuevo,
                    'id_gps_nuevo' : me.gps_nuevo.id,
                    'simcard_nuevo_id' : me.simcard_nuevo.id,
                    'lugar' : me.lugar,
                    'cortemotor' : me.cortemotor,
                    'panico' : me.panico,
                    'posicion' : me.posicion,
                    'otros' : me.otros,
                    'observaciones' : me.observaciones,
                    'fotos' : me.images

                }).then(function (response) {


                }).catch(function (error) {

                    console.log(error);

                });

            },

            selectVehiculo(search, loading){

                // Buscar los vehiculos que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/vehiculos/selectVehiculo?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.arrayVehiculo = respuesta.vehiculos;
                    loading(false);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            getDatosVehiculo(val1){

                // Asignar los datos del vehiculo seleccionado a la data

                let me = this;
                me.loading = true;

                if(val1!==null){
                    me.placa = val1.placa;
                }else{
                    me.placa = '';
                }

            },

            selectGpsViejo(search, loading){

                // Buscar las sims que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/gps/selectGps?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.arrayGpsViejo = respuesta.gps;
                    loading(false);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            getDatosGpsViejo(val1){

                // Asignar los datos del sim seleccionado a la data

                let me = this;
                me.loading = true;
               
                if(val1!==null){
                    me.gps_viejo.id = val1.id;
                    let arregloimei = val1.imei.split(',', 2);
                    me.gps_viejo.imei = arregloimei[0];
                    me.gps_viejo.serie = val1.serie;
                    me.gps_viejo.marca = val1.marca;
                    me.gps_viejo.modelo = val1.modelo;
                }else{
                    me.gps_viejo.id = 0;
                    me.gps_viejo.imei = '';
                    me.gps_viejo.serie = '';
                    me.gps_viejo.marca = '';
                    me.gps_viejo.modelo = '';
                }

            },

            selectGpsNuevo(search, loading){

                // Buscar las sims que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/gps/selectGps?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.arrayGpsNuevo = respuesta.gps;
                    loading(false);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            getDatosGpsNuevo(val1){

                // Asignar los datos del sim seleccionado a la data

                let me = this;
                me.loading = true;
               
                if(val1!==null){
                    me.gps_nuevo.id = val1.id;
                    let arregloimei = val1.imei.split(',', 2);
                    me.gps_nuevo.imei = arregloimei[0];
                    me.gps_nuevo.serie = val1.serie;
                    me.gps_nuevo.marca = val1.marca;
                    me.gps_nuevo.modelo = val1.modelo;
                }else{
                    me.gps_nuevo.id = 0;
                    me.gps_nuevo.imei = '';
                    me.gps_nuevo.serie = '';
                    me.gps_nuevo.marca = '';
                    me.gps_nuevo.modelo = '';
                }

            },

            selectSimNuevo(search, loading){

                // Buscar las sims que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/simcards/selectSim?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.arraySimNuevo = respuesta.simcards;
                    loading(false);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            getDatosSimNuevo(val1){

                // Asignar los datos del sim seleccionado a la data

                let me = this;
                me.loading = true;
               
                if(val1!==null){
                    me.simcard_nuevo.id = val1.id;
                    me.simcard_nuevo.sim = val1.imsi;
                    me.simcard_nuevo.ip = val1.ip;
                    me.simcard_nuevo.telefono = val1.telefono;
                }else{
                    me.simcard_nuevo.id = 0;
                    me.simcard_nuevo.sim = '';
                    me.simcard_nuevo.ip = '';
                    me.simcard_nuevo.telefono = '';
                }

            },

            validarCambioGps(){
                
                // Validar que al seleccionar una actividad, ya exista un cliente, un tecnico y una fecha
                
                this.errorCambioGps = 0;
                this.errorMostrarMsjCambioGps = [];

                if(!this.nombre) this.errorMostrarMsjCambioGps.push("DEBE INGRESAR UN NOMBRE.");
                if(!this.placa) this.errorMostrarMsjCambioGps.push("DEBE SELECCIONAR UNA PLACA.");
                if(!this.id_dispositivo_viejo) this.errorMostrarMsjCambioGps.push("DEBE INGRESAR EL ID DEL DISPOSITIVO VIEJO.");
                if(!this.id_dispositivo_nuevo) this.errorMostrarMsjCambioGps.push("DEBE INGRESAR EL ID DEL DISPOSITIVO NUEVO.");
                if(!this.gps_viejo.id) this.errorMostrarMsjCambioGps.push("DEBE SELECCIONAR EL GPS VIEJO.");
                if(!this.gps_nuevo.id) this.errorMostrarMsjCambioGps.push("DEBE SELECCIONAR EL GPS NUEVO.");
                if(!this.simcard_nuevo.id) this.errorMostrarMsjCambioGps.push("DEBE SELECCIONAR UNA SIM NUEVA.");
                if(!this.lugar) this.errorMostrarMsjCambioGps.push("DEBE INGRESAR UN LUGAR.");

                if(this.errorMostrarMsjCambioGps.length){
                    this.errorCambioGps = 1;
                }

                return this.errorCambioGps;

            }
            
        },

    }
    
</script>