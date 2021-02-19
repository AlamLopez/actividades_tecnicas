<template>
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <i class="fa fa-align-justify"></i> INSTALACIÓN NUEVA
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
                    <label class="col-md-3 col-form-label" for="text-input">ID GPS (*):</label>
                    <div class="col-md-9">
                        <input class="form-control" id="text-input" type="text" name="text-input" v-model="id_dispositivo" placeholder="Text">
                    </div>
                </div>
                <div class="col-md-4 form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">PLACA (*):</label>
                    <div class="col-md-9">
                        <input class="form-control" id="text-input" type="text" name="text-input" v-model="placa" placeholder="Text">
                    </div>
                </div>
                <div class="col-md-4 form-group row"></div>
            </div>
        </div>
        <div class="card-body border">
            <div class="row">
                <div class="col-md-6 form-group row">
                    <label class="col-md-8 col-form-label" for="text-input">DISPOSITIVO GPS (*):</label>
                    <div class="col-md-10">
                        <v-select 
                            @input="getDatosGps"
                            @search="selectGps" 
                            label="imei"
                            :options="arrayGps"
                            placeholder="BUSCAR DISPOSITIVOS..."
                        >
                        </v-select>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-3 form-group row">
                    <label class="col-md-4 col-form-label" for="text-input">IMEI:</label>
                    <div class="col-md-8" v-text="gps.imei">
                    </div>
                </div>
                <div class="col-md-3 form-group row">
                    <label class="col-md-4 col-form-label" for="text-input">SERIE:</label>
                    <div class="col-md-8" v-text="gps.serie">
                    </div>
                </div>
                <div class="col-md-3 form-group row">
                    <label class="col-md-4 col-form-label" for="text-input">MARCA:</label>
                    <div class="col-md-8" v-text="gps.marca">
                    </div>
                </div>
                <div class="col-md-3 form-group row">
                    <label class="col-md-4 col-form-label" for="text-input">MODELO:</label>
                    <div class="col-md-8" v-text="gps.modelo">
                    </div>
                </div>
                </div>
        </div>
        <div class="card-body border">
            <div class="row">
                <div class="col-md-6 form-group row">
                    <label class="col-md-8 col-form-label" for="text-input">SIMCARD (*):</label>
                    <div class="col-md-10">
                        <v-select 
                            @input="getDatosSim"
                            @search="selectSim" 
                            label="imsi"
                            :options="arraySim"
                            placeholder="BUSCAR SIMCARDS..."
                        >
                        </v-select>
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-4 form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">SIM:</label>
                    <div class="col-md-9" v-text="simcard.sim">
                    </div>
                </div>
                <div class="col-md-4 form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">IP:</label>
                    <div class="col-md-9" v-text="simcard.ip">
                    </div>
                </div>
                <div class="col-md-4 form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">TELÉFONO:</label>
                    <div class="col-md-9" v-text="simcard.telefono">
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
        <div v-show="errorInstalacion" class="form-group row div-error">
            <div class="text-center text-error">
                <div v-for="error in errorMostrarMsjInstalacion" :key="error" v-text="error">

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

                gps : {
                    id : 0,
                    imei : '',
                    serie : '',
                    marca : '',
                    modelo : ''
                },

                simcard : {
                    id : 0,
                    sim : '',
                    ip : '',
                    telefono : ''
                },

                id_dispositivo : '',
                placa : '',
                lugar : '',
                cortemotor : false,
                panico : false,
                posicion: false,
                otros: '',
                observaciones: '',
                arrayGps : [],
                arraySim : [],
                images: [],
                errorInstalacion : 0,
                errorMostrarMsjInstalacion : [],

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

            registrarInstalacion(actividad){

                // Enviar los datos del cambio de sim al controlador
                // Al finalizar regresamos al metodo registrarActividadTecnica en el componente ActividadTecnica

                let me = this;

                axios.post('/instalaciones/registrar', {
                    
                    'id_actividadtecnica' : actividad,
                    'id_dispositivo' : me.id_dispositivo,
                    'placa' : me.placa,
                    'id_gps' : me.gps.id,
                    'simcard_id' : me.simcard.id,
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

            selectGps(search, loading){

                // Buscar las sims que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/gps/selectGps?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.arrayGps = respuesta.gps;
                    loading(false);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            getDatosGps(val1){

                // Asignar los datos del sim seleccionado a la data

                let me = this;
                me.loading = true;
               
                if(val1!==null){
                    me.gps.id = val1.id;
                    let arregloimei = val1.imei.split(',', 2);
                    me.gps.imei = arregloimei[0];
                    me.gps.serie = val1.serie;
                    me.gps.marca = val1.marca;
                    me.gps.modelo = val1.modelo;
                }else{
                    me.gps.id = 0;
                    me.gps.imei = '';
                    me.gps.serie = '';
                    me.gps.marca = '';
                    me.gps.modelo = '';
                }

            },

            selectSim(search, loading){

                // Buscar las sims que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/simcards/selectSim?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.arraySim = respuesta.simcards;
                    loading(false);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            getDatosSim(val1){

                // Asignar los datos del sim seleccionado a la data

                let me = this;
                me.loading = true;
               
                if(val1!==null){
                    me.simcard.id = val1.id;
                    me.simcard.sim = val1.imsi;
                    me.simcard.ip = val1.ip;
                    me.simcard.telefono = val1.telefono;
                }else{
                    me.simcard.id = 0;
                    me.simcard.sim = '';
                    me.simcard.ip = '';
                    me.simcard.telefono = '';
                }

            },

            validarInstalacion(){
                
                // Validar que al seleccionar una actividad, ya exista un cliente, un tecnico y una fecha
                
                this.errorInstalacion = 0;
                this.errorMostrarMsjInstalacion = [];

                if(!this.id_dispositivo) this.errorMostrarMsjInstalacion.push("DEBE INGRESAR UN NOMBRE.");
                if(!this.placa) this.errorMostrarMsjInstalacion.push("DEBE SELECCIONAR UNA PLACA.");
                if(!this.gps.id) this.errorMostrarMsjInstalacion.push("DEBE SELECCIONAR EL GPS VIEJO.");
                if(!this.simcard.id) this.errorMostrarMsjInstalacion.push("DEBE SELECCIONAR UNA SIM NUEVA.");
                if(!this.lugar) this.errorMostrarMsjInstalacion.push("DEBE INGRESAR UN LUGAR.");

                if(this.errorMostrarMsjInstalacion.length){
                    this.errorInstalacion = 1;
                }

                return this.errorInstalacion;

            }
            
        },

    }
    
</script>