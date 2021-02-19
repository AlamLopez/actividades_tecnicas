<template>
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <i class="fa fa-align-justify"></i> DESINSTALACIÓN
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
                <div class="col-md-4 form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">NOMBRE (*):</label>
                    <div class="col-md-9">
                        <input class="form-control" id="text-input" type="text" name="text-input" v-model="nombre" placeholder="Text">
                    </div>
                </div>
                <div class="col-md-4 form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">ID GPS (*):</label>
                    <div class="col-md-9">
                        <input class="form-control" id="text-input" type="text" name="text-input" v-model="id_dispositivo" placeholder="Text">
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
                <div class="col-md-8 form-group row"></div>
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
        <div v-show="errorDesinstalacion" class="form-group row div-error">
            <div class="text-center text-error">
                <div v-for="error in errorMostrarMsjDesinstalacion" :key="error" v-text="error">

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

                nombre : '',
                placa : '',
                id_dispositivo : '',
                lugar : '',
                otros: '',
                observaciones: '',
                arrayVehiculo : [],
                images: [],
                errorDesinstalacion : 0,
                errorMostrarMsjDesinstalacion : [], 

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
                
                // Cancelar la desinstalacion

                let me = this;

                me.$emit('resetear_actividad', '0')

            },

            registrarDesinstalacion(actividad){

                // Enviar los datos de la desinstalacion al controlador
                // Al finalizar regresamos al metodo registrarActividadTecnica en el componente ActividadTecnica

                let me = this;

                axios.post('/desinstalaciones/registrar', {
                    
                    'id_actividadtecnica' : actividad,
                    'nombre' : me.nombre,
                    'placa' : me.placa,
                    'id_dispositivo' : me.id_dispositivo,
                    'lugar' : me.lugar,
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

            validarDesinstalacion(){
                
                // Validar que al seleccionar una actividad, ya exista un cliente, un tecnico y una fecha
                
                this.errorDesinstalacion = 0;
                this.errorMostrarMsjDesinstalacion = [];

                if(!this.nombre) this.errorMostrarMsjDesinstalacion.push("DEBE INGRESAR EL NOMBRE.");
                if(!this.id_dispositivo) this.errorMostrarMsjDesinstalacion.push("DEBE INGRESAR EL ID DEL GPS.");
                if(!this.placa) this.errorMostrarMsjDesinstalacion.push("DEBE SELECCIONAR UNA PLACA.");
                if(!this.lugar) this.errorMostrarMsjDesinstalacion.push("DEBE INGRESAR UN LUGAR.");

                if(this.errorMostrarMsjDesinstalacion.length){
                    this.errorDesinstalacion = 1;
                }

                return this.errorDesinstalacion;

            }
            
        },

    }
    
</script>