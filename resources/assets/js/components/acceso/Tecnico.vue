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
                        <i class="fa fa-align-justify"></i> TÉCNICOS
                        <button type="button" @click="abrirModal('tecnico', 'registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;NUEVO
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">NOMBRE</option>
                                      <option value="apellido">APELLIDO</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup="listarTecnico(1, buscar, criterio)" class="form-control" placeholder="TEXTO A BUSCAR">
                                    <button type="submit" @click="listarTecnico(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> BUSCAR</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">OPCIONES</th>
                                    <th style="text-align: center;">NOMBRE</th>
                                    <th style="text-align: center;">APELLIDO</th>
                                    <th style="text-align: center;">ESTADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="tecnico in arrayTecnico" :key="tecnico.id">
                                    <td style="text-align: center;">
                                        <button type="button" @click="abrirModal('tecnico', 'actualizar', tecnico)" class="btn btn-warning btn-sm" title="EDITAR TÉCNICO">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="tecnico.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarTecnico(tecnico.id)" title="DESACTIVAR TÉCNICO">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarTecnico(tecnico.id)" title="ACTIVAR TÉCNICO">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td style="text-align: center;" v-text="tecnico.nombre"></td>
                                    <td style="text-align: center;" v-text="tecnico.apellido"></td>
                                    <td style="text-align: center;">
                                        <div v-if="tecnico.condicion">
                                            <span class="badge badge-success">ACTIVO</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">DESACTIVADO</span>
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
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" @click="cerrarModal()" class="close" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">NOMBRE</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="NOMBRE DEL TÉCNICO">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">APELLIDO</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellido" class="form-control" placeholder="APELLIDO DEL TÉCNICO">
                                    </div>
                                </div>
                                <div v-show="errorTecnico" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjTecnico" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">CERRAR</button>
                            <button type="button" v-if="tipoAccion==1" @click="registrarTecnico()" class="btn btn-primary">GUARDAR</button>
                            <button type="button" v-if="tipoAccion==2" @click="actualizarTecnico()" class="btn btn-primary">ACTUALIZAR</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    export default {

        data (){

            return {

                tecnico_id: 0,
                nombre : '',
                apellido : '',
                arrayTecnico : [],
                modal : 0,
                tituloModal : '',
                tipoAccion: 0,
                errorTecnico : 0,
                errorMostrarMsjTecnico : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
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

            listarTecnico(page, buscar, criterio){

                let me = this;
                var url = '/tecnicos?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayTecnico = respuesta.tecnicos.data;
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
                me.listarTecnico(page, buscar, criterio);

            },

            registrarTecnico(){

                if(this.validarTecnico()){

                    return;
                    
                }

                let me = this;

                axios.post('/tecnicos/registrar', {

                    'nombre': this.nombre,
                    'apellido': this.apellido

                }).then(function (response) {

                    me.cerrarModal();
                    me.listarTecnico(1, '', 'nombre');

                }).catch(function (error) {

                    console.log(error);

                });

            },

            actualizarTecnico(){

                if(this.validarTecnico()){

                    return;
                    
                }

                let me = this;

                axios.put('/tecnicos/actualizar', {

                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'id': this.tecnico_id

                }).then(function (response) {

                    me.cerrarModal();
                    me.listarTecnico(1, '', 'nombre');

                }).catch(function (error) {

                    console.log(error);

                });

            },

            desactivarTecnico(id){

                const swalWithBootstrapButtons = Swal.mixin({

                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },

                    buttonsStyling: false

                    })

                    swalWithBootstrapButtons.fire({
                    
                        title: 'ESTÁ SEGURO DE DESACTIVAR A ESTE TÉCNICO?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'SÍ, DESACTÍVALO!',
                        cancelButtonText: 'NO, CANCELAR!',
                        reverseButtons: true

                    }).then((result) => {

                        if (result.value) {

                            let me = this;

                            axios.put('/tecnicos/desactivar', {

                                'id': id

                            }).then(function (response) {

                                me.listarTecnico(1, '', 'nombre');
                                swalWithBootstrapButtons.fire(
                                    'DESACTIVADO!',
                                    'EL TÉCNICO HA SIDO DESACTIVADO.',
                                    'success'
                                )

                            }).catch(function (error) {

                                console.log(error);

                            });

                            
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            
                        }

                });
            },

            activarTecnico(id){

                const swalWithBootstrapButtons = Swal.mixin({

                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },

                    buttonsStyling: false

                    })

                    swalWithBootstrapButtons.fire({
                    
                        title: 'ESTÁ SEGURO DE ACTIVAR A ESTE TÉCNICO?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'SÍ, ACTÍVALO!',
                        cancelButtonText: 'NO, CANCELAR!',
                        reverseButtons: true

                    }).then((result) => {

                        if (result.value) {

                            let me = this;

                            axios.put('/tecnicos/activar', {

                                'id': id

                            }).then(function (response) {

                                me.listarTecnico(1, '', 'nombre');
                                swalWithBootstrapButtons.fire(
                                    'ACTIVADO!',
                                    'EL TÉCNICO HA SIDO ACTIVADO.',
                                    'success'
                                )

                            }).catch(function (error) {

                                console.log(error);

                            });

                            
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            
                        }

                });
            },

            validarTecnico(){
                
                this.errorTecnico = 0;
                this.errorMostrarMsjTecnico = [];

                if(!this.nombre) this.errorMostrarMsjTecnico.push("EL NOMBRE DEL TÉCNICO NO PUEDE IR VACÍO.");
                if(!this.apellido) this.errorMostrarMsjTecnico.push("EL APELLIDO DEL TÉCNICO NO PUEDE IR VACÍO.");
                if(this.errorMostrarMsjTecnico.length) this.errorTecnico = 1;

                return this.errorTecnico;

            },

            abrirModal(modelo, accion, data = []){

                switch (modelo) {

                    case 'tecnico':
                        
                        {

                            switch (accion) {
                                
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'REGISTRAR TÉCNICO'
                                        this.nombre = '';
                                        this.apellido = '';
                                        this.tipoAccion = 1;
                                        break;
                                    }

                                case 'actualizar':
                                    {
                                         //console.log(data);
                                         this.modal = 1;
                                         this.tituloModal = 'ACTUALIZAR TÉCNICO';
                                         this.tipoAccion = 2;
                                         this.tecnico_id = data['id'];
                                         this.nombre = data['nombre'];
                                         this.apellido = data['apellido'];
                                         break;
                                    }
                            
                            }

                        }
                        
                }
            },

            cerrarModal(){

                this.modal = 0;
                this.tituloModal = '';
                this.nombre = '';
                this.apellido = '';

            }

        },

        mounted() {

            this.listarTecnico(1, this.buscar, this.criterio);

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
