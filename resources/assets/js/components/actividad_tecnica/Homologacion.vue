<template>
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <i class="fa fa-align-justify"></i> HOMOLOGACIÓN
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
                        <input class="form-control" id="text-input" type="text" name="text-input" v-model="placa" placeholder="Text">
                    </div>
                </div>
                <div class="col-md-4 form-group row">
                    <label class="col-md-3 col-form-label" for="text-input">ID GPS (*):</label>
                    <div class="col-md-9">
                        <input class="form-control" id="text-input" type="text" name="text-input" v-model="id_dispositivo" placeholder="Text">
                    </div>
                </div>
                <div class="col-md-4 form-group row"></div>
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
        <div v-show="errorHomologacion" class="form-group row div-error">
            <div class="text-center text-error">
                <div v-for="error in errorMostrarMsjHomologacion" :key="error" v-text="error">

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

                id_dispositivo : '',
                placa : '',
                lugar : '',
                cortemotor : false,
                panico : false,
                posicion: false,
                otros: '',
                observaciones: '',
                arrayVehiculo : [],
                images: [],
                errorHomologacion : 0,
                errorMostrarMsjHomologacion : [], 

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
                
                // Cancelar la homologacion

                let me = this;

                me.$emit('resetear_actividad', '0')

            },

            registrarHomologacion(actividad){

                // Enviar los datos de la homologacion al controlador
                // Al finalizar regresamos al metodo registrarActividadTecnica en el componente ActividadTecnica

                let me = this;

                axios.post('/homologaciones/registrar', {
                    
                    'id_actividadtecnica' : actividad,
                    'id_dispositivo' : me.id_dispositivo,
                    'placa' : me.placa,
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

            validarHomologacion(){
                
                // Validar que al guardar una homologacion, ya exista una placa, un id de gps y un lugar.
                
                this.errorHomologacion = 0;
                this.errorMostrarMsjHomologacion = [];

                if(!this.placa) this.errorMostrarMsjHomologacion.push("DEBE INGRESAR UNA PLACA.");
                if(!this.id_dispositivo) this.errorMostrarMsjHomologacion.push("DEBE INGRESAR EL ID DEL GPS.");
                if(!this.lugar) this.errorMostrarMsjHomologacion.push("DEBE INGRESAR UN LUGAR.");

                if(this.errorMostrarMsjHomologacion.length){
                    this.errorHomologacion = 1;
                }

                return this.errorHomologacion;

            }
            
        },

    }
    
</script>