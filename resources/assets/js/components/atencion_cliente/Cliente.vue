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
                        <i class="fa fa-align-justify"></i> CLIENTES
                        <button type="button" @click="actualizarSidco()"  class="btn btn-primary">
                            <i class="icon-plus"></i>&nbsp;ACTUALIZAR DESDE SIDCO
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="clientes.nombre">NOMBRE</option>
                                        <option value="codigoavl">CÓDIGO AVL</option>
                                        <option value="direccion">DIRECCIÓN</option>
                                        <option value="giro">GIRO</option>
                                        <option value="estadocliente">ESTADO</option>
                                        <option value="nombrecompleto">SAC</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup="listarCliente(1, buscar, criterio)" class="form-control" placeholder="TEXTO A BUSCAR">
                                    <button type="submit" @click="listarCliente(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> BUSCAR</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">OPCIONES</th>
                                    <th style="text-align: center;">NOMBRE</th>
                                    <th style="text-align: center;">CÓDIGO AVL</th>
                                    <th style="text-align: center;">DIRECCIÓN</th>
                                    <th style="text-align: center;">GIRO</th>
                                    <th style="text-align: center;">ESTADO</th>
                                    <th style="text-align: center;">SAC</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cliente in arrayCliente" :key="cliente.id">
                                    <td style="text-align: center;">
                                        <button type="button" @click="abrirModal('cliente', 'actualizarCodigoAVL', cliente)" class="btn btn-info btn-sm" title="ACTUALIZAR CÓDIGO AVL">
                                          <i class="icon-key"></i>
                                        </button>
                                        <button type="button" @click="abrirModal('cliente', 'actualizarCliente', cliente)" class="btn btn-warning btn-sm" title="EDITAR CLIENTE">
                                          <i class="icon-pencil"></i>
                                        </button>
                                    </td>
                                    <td style="text-align: center;" v-text="cliente.nombre"></td>
                                    <td style="text-align: center;" v-text="cliente.codigoavl"></td>
                                    <td style="text-align: center;" v-text="cliente.direccion"></td>
                                    <td style="text-align: center;" v-text="cliente.giro"></td>
                                    <td style="text-align: center;">
                                        <div v-if="cliente.estadocliente">
                                            <span class="badge badge-success">ACTIVO</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">DESACTIVADO</span>
                                        </div>
                                    </td>
                                    <td style="text-align: center;" v-text="cliente.nombreuser"></td>
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
            <!--Inicio del modal actualizar codigo avl-->
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
                            <div v-if="formodal == 1">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">CÓDIGO AVL:</label>
                                        <div class="col-md-9">
                                            <input type="text" v-model="codigoavl" @blur="validarCodigoAVL(codigoavl, cliente_id)" class="form-control" placeholder="CÓDIGO AVL">
                                        </div>
                                    </div>
                                    <div v-show="errorCliente" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjCliente" :key="error" v-text="error">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">CERRAR</button>
                                        <button type="button" class="btn btn-primary" @click="actualizarCodigoAVL()">ACTUALIZAR</button>
                                    </div>
                                </form>
                            </div>

                            <div v-if="formodal == 2">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">NOMBRE:</label>
                                        <div class="col-md-9">
                                            <label class="form-control-label" for="text-input" v-text="nombre"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">CÓDIGO AVL:</label>
                                        <div class="col-md-9">
                                            <label class="form-control-label" for="text-input" v-text="codigoavl"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">NIT:</label>
                                        <div class="col-md-9">
                                            <label class="form-control-label" for="text-input" v-text="nit"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">DIRECCIÓN:</label>
                                        <div class="col-md-9">
                                            <label class="form-control-label" for="text-input" v-text="direccion"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">GIRO:</label>
                                        <div class="col-md-9">
                                            <label class="form-control-label" for="text-input" v-text="giro"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">DEPARTAMENTO:</label>
                                        <div class="col-md-9">
                                            <label class="form-control-label" for="text-input" v-text="departamento"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">MUNICIPIO:</label>
                                        <div class="col-md-9">
                                            <label class="form-control-label" for="text-input" v-text="municipio"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">TELÉFONO 1:</label>
                                        <div class="col-md-9">
                                            <label class="form-control-label" for="text-input" v-text="telefono1"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">TELÉFONO 2:</label>
                                        <div class="col-md-9">
                                            <label class="form-control-label" for="text-input" v-text="telefono2"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">CORREO NOTIFICACIÓN:</label>
                                        <div class="col-md-9">
                                            <input type="email" v-model="contactocliente" class="form-control" placeholder="CORREO DEL CLIENTE">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="email-input">ESTADO</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="estadocliente">
                                                <option value="1">ACTIVO</option>
                                                <option value="0">INACTIVO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="email-input">SAC</label>
                                        <div class="col-md-9">
                                            <select class="form-control" v-model="sac">
                                                <option value="0"></option>
                                                <option v-for="user in arrayUser" :key="user.id" :value="user.id" v-text="user.nombrecompleto"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">CERRAR</button>
                                        <button type="button" class="btn btn-primary" @click="actualizarCliente()">ACTUALIZAR</button>
                                    </div>
                                </form>
                            </div>
                                
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
                
                cliente_id: 0,
                formodal: 0,
                nombre: '',
                codigoavl: '',
                nit : '',
                direccion : '',
                giro : '',
                contactocliente: '',
                sac: 0,
                nombreuser: '',
                iddepartamento: 0,
                idmunicipio: 0,
                departamento: '',
                municipio: '',
                arrayCliente : [],
                arrayUser : [],
                modal : 0,
                tituloModal : '',
                tipoAccion: 0,
                errorCliente : 0,
                errorMostrarMsjCliente : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'clientes.nombre',
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

            listarCliente(page, buscar, criterio){

                let me = this;
                var url = '/clientes?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                
                axios.get(url).then(function (response) {

                    var respuesta = response.data;
                    me.arrayCliente = respuesta.clientes.data;
                    me.pagination = respuesta.pagination;
                    console.log(response);

                }).catch(function (error) {
                    
                    console.log(error);

                })
            },

            selectUser(){

                let me = this;
                var url = '/usuarios/selectUser';
                
                axios.get(url).then(function (response) {

                    var respuesta = response.data;
                    me.arrayUser = respuesta.users;
                    console.log(response);

                }).catch(function (error) {
                    
                    console.log(error);

                })
            },

            cambiarPagina(page, buscar, criterio){
                
                let me = this;
                me.pagination.current_page = page;
                me.listarCliente(page, buscar, criterio);

            },

            actualizarSidco(){

                let me = this;

                axios.get('/clientes/sidco').then(function (response) {

                    var respuesta = response.data;
                    
                    if(respuesta === "vacio"){

                        me.listarCliente(1, '', 'clientes.nombre');

                        Swal.fire({
                            position: 'top-end',
                            icon: 'warning',
                            title: 'NO HAY CLIENTES NUEVOS EN SIDCO',
                            showConfirmButton: false,
                            timer: 1500
                        });

                    }else if(respuesta === "lleno"){
                        
                        me.listarCliente(1, '', 'clientes.nombre');

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'CLIENTES SINCRONIZADOS',
                            showConfirmButton: false,
                            timer: 1500
                        });

                    }

                }).catch(function (error) {

                    console.log(error);

                });
            },
            
            actualizarCodigoAVL(){

                let me = this;

                axios.put('/clientes/actualizarCodigoAVL', {
                    
                    'codigoavl': this.codigoavl,
                    'id': this.cliente_id

                }).then(function (response) {
                    
                    me.cerrarModal();
                    me.listarCliente(1, '', 'clientes.nombre');
                    
                    Swal.fire({
                        
                        position: 'top-end',
                        icon: 'success',
                        title: 'CÓDIGO AVL ACTUALIZADO',
                        showConfirmButton: false,
                        timer: 1500

                    });

                }).catch(function (error) {
                    
                    console.log(error);

                });

            },
            
            actualizarCliente(){

                let me = this;
                
                axios.put('/clientes/actualizar', {
                    
                    'contactocliente': this.contactocliente,
                    'estadocliente': this.estadocliente,
                    'sac': this.sac,
                    'id': this.cliente_id

                }).then(function (response) {
                    
                    me.cerrarModal();
                    me.listarCliente(1, '', 'clientes.nombre');

                    Swal.fire({
                        
                        position: 'top-end',
                        icon: 'success',
                        title: 'CLIENTE ACTUALIZADO',
                        showConfirmButton: false,
                        timer: 1500

                    });

                }).catch(function (error) {
                    
                    console.log(error);

                });

            },

            validarCodigoAVL(codigoavl, cliente_id){
                
                let me = this;
                me.errorCliente = 0;
                me.errorMostrarMsjCliente = [];
                console.log(cliente_id);
                var url = '/clientes/unico/' + codigoavl + '/' + cliente_id;
                
                axios.get(url).then(function (response) {
                    
                    var respuesta = response.data;
                    
                    if(respuesta=="no") me.errorMostrarMsjCliente.push("EL CÓDIGO AVL " + codigoavl + " YA EXISTE.");
                    
                    if(me.errorMostrarMsjCliente.length){
                            
                        me.codigoavl = '';
                        me.errorCliente = 1;
                            
                    } 
                    
                    return me.errorCliente;
                    
                }).catch(function (error) {
                    
                    console.log(error);

                });

            },

            abrirModal(modelo, accion, data = []){
                
                this.selectUser();
                
                switch (modelo) {
                    
                    case 'cliente':
                        {
                            switch (accion) {
                                
                                case 'actualizarCodigoAVL':
                                    {
                                        
                                        this.modal = 1;
                                        this.formodal = 1;
                                        this.tituloModal = 'ACTUALIZAR IDAVL';
                                        this.cliente_id = data['id'];
                                        this.codigoavl = data['codigoavl'];
                                        break;

                                    }
                                
                                case 'actualizarCliente':
                                    {
                                        
                                        this.modal = 1;
                                        this.formodal = 2;
                                        this.tituloModal = 'ACTUALIZAR CLIENTE';
                                        this.cliente_id = data['id'];
                                        this.nombre = data['nombre'];
                                        this.codigoavl = data['codigoavl'];
                                        this.nit = data['nit'];
                                        this.direccion = data['direccion'];
                                        this.giro = data['giro'];
                                        this.departamento = data['departamento'];
                                        this.municipio = data['municipio'];
                                        this.telefono1 = data['telefono1'];
                                        this.telefono2 = data['telefono2'];
                                        this.contactocliente = data['contactocliente'];
                                        this.estadocliente = data['estadocliente'];
                                        this.sac = data['sac'];
                                        break;

                                    }
                            
                            }
                        }
                        
                }

            },

            cerrarModal(){
                
                this.modal = 0;
                this.tituloModal = '';
                this.codigoavl = '';

            }

        },

        mounted() {
            
            this.listarCliente(1, this.buscar, this.criterio);

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
        position: fixed !important;
        background-color: #3c29297a !important;
        overflow-y: auto;
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