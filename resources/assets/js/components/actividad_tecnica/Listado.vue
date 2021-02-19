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
                    <i class="fa fa-align-justify"></i> ACTIVIDADES TÉCNICAS
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="id">ID DISPOSITIVO</option>
                                    <option value="fecha">FECHA ACTIVIDAD</option>
                                    <option value="id_tecnico">TÉCNICO</option>
                                    <option value="nombre">TIPO DE ACTIVIDAD</option>
                                    <option value="id_cliente">CLIENTE</option>
                                    <option value="ingresado_por">INGRESADO POR</option>
                                    <option value="created_at">FECHA INGRESO</option>
                                    <option value="revisado_por">REVISADO POR</option>
                                    <option value="fecha_revision">FECHA REVISION</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup="listarActividadTecnica(1, buscar, criterio)" class="form-control" placeholder="TEXTO A BUSCAR">
                                <button type="submit" @click="listarActividadTecnica(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> BUSCAR</button>
                                <button type="submit" @click="listarActividadTecnica(1, '', id)" class="btn btn-success"><i class="fa fa-refresh"></i> ACTUALIZAR</button>
                            </div>
                        </div>
                        
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th style="text-align: center;">OPCIONES</th>
                                <th style="text-align: center;">FECHA ACTIVIDAD</th>
                                <th style="text-align: center;">TIPO DE ACTIVIDAD</th>
                                <th style="text-align: center;">CLIENTE</th>
                                <th style="text-align: center;">INGRESADO POR</th>
                                <th style="text-align: center;">FECHA INGRESO</th>
                                <th style="text-align: center;">REVISADO POR</th>
                                <th style="text-align: center;">FECHA REVISION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="actividad in arrayActividadTecnica" :key="actividad.id">
                                <td style="text-align: center;">
                                    <template v-if="user.idrol!==2">
                                        <template v-if="!actividad.revisado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="revisarActividadTecnica(actividad.id)" title="CONFIRMAR ACTIVIDAD TÉCNICA">
                                                <i class="icon-info"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" @click="desrevisarActividadTecnica(actividad.id)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        <template>
                                            <button type="button" class="btn btn-info btn-sm" @click="abrirModal('ver', actividad)" title="VER ACTIVIDAD TÉCNICA">
                                                <i class="icon-eye"></i>
                                            </button>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <template v-if="!actividad.revisado">
                                            <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('editar', actividad)" title="EDITAR ACTIVIDAD TÉCNICA">
                                                <i class="icon-pencil"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-warning btn-sm" title="EDITAR ACTIVIDAD TÉCNICA" disabled>
                                                <i class="icon-pencil"></i>
                                            </button>
                                        </template>
                                    </template>
                                </td>
                                <td style="text-align: center;" v-text="actividad.fecha"></td>
                                <td style="text-align: center;" >
                                    <div v-if="actividad.nombre==='INSTALACION'">
                                        <span class="badge badge-primary" v-text="actividad.nombre"></span>
                                    </div>
                                    <div v-else-if="actividad.nombre==='REVISION'">
                                        <span class="badge badge-secondary" v-text="actividad.nombre"></span>
                                    </div>
                                    <div v-else-if="actividad.nombre==='CAMBIO DE SIM'">
                                        <span class="badge badge-success" v-text="actividad.nombre"></span>
                                    </div>
                                    <div v-else-if="actividad.nombre==='CAMBIO DE GPS'">
                                        <span class="badge badge-danger" v-text="actividad.nombre"></span>
                                    </div>
                                    <div v-else-if="actividad.nombre==='TRASLADO DE GPS'">
                                        <span class="badge badge-warning" v-text="actividad.nombre"></span>
                                    </div>
                                    <div v-else-if="actividad.nombre==='DESINSTALACION'">
                                        <span class="badge badge-info" v-text="actividad.nombre"></span>
                                    </div>
                                    <div v-else-if="actividad.nombre==='HOMOLOGACION'">
                                        <span class="badge badge-light" v-text="actividad.nombre"></span>
                                    </div>
                                    <div v-else-if="actividad.nombre==='REINSTALACION'">
                                        <span class="badge badge-dark" v-text="actividad.nombre"></span>
                                    </div>
                                </td>
                                <td style="text-align: center;" v-text="actividad.cliente.codigoavl + ', ' + actividad.cliente.nombre"></td>
                                <td style="text-align: center;" v-text="actividad.ingresado_por.nombrecompleto"></td>
                                <td style="text-align: center;" v-text="actividad.created_at"></td>
                                <td style="text-align: center;" v-if="actividad.revisado_por" v-text="actividad.revisado_por.nombrecompleto"></td>
                                <td style="text-align: center;" v-else></td>
                                <td style="text-align: center;" v-text="actividad.fecha_revision"></td>
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
                        <div v-if="vermodal == 1">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">TÉCNICO:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="tecnico.nombre"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">PLACA:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="instalacion.placa"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">ID_DISPOSITIVO:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="instalacion.id_dispositivo"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">IMEI:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="instalacion.gps.imei"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">SERIE:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="instalacion.gps.serie"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">MARCA:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="instalacion.gps.marca"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">MODELO:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="instalacion.gps.modelo"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">SIM:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="instalacion.simcard.sim"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">IP:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="instalacion.simcard.ip"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">TELÉFONO:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="instalacion.gps.telefono"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">LUGAR:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="instalacion.lugar"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">CORTE DE MOTOR:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-if="instalacion.cortemotor">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">POSICIÓN:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-if="instalacion.posicion">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">PÁNICO:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-if="instalacion.panico">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">OTROS:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="instalacion.otros"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">OBSERVACIONES:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="instalacion.observacion"></label>
                                </div>
                                <div class="row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenInstalacion/'+image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="vermodal == 2">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">TÉCNICO:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="tecnico.nombre"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">NOMBRE:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="revision.nombre"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">PLACA:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="revision.placa"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">LUGAR:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="revision.lugar"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">CORTE DE MOTOR:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-if="revision.cortemotor">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">POSICIÓN:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-if="revision.posicion">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">PÁNICO:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-if="revision.panico">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">OTROS:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="revision.otros"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">OBSERVACIONES:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="revision.observacion"></label>
                                </div>
                                <div class="row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenRevisiones/'+image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="vermodal == 3">
                            <div class="form-group row">
                                <label class="col-md-5 form-control-label" for="text-input">TÉCNICO:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="tecnico.nombre"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">NOMBRE:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiosim.nombre"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">PLACA:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiosim.placa"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">SIM (VIEJO):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiosim.simcard_viejo.sim"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">IP (VIEJO):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiosim.simcard_viejo.ip"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">TELÉFONO (VIEJO):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiosim.simcard_viejo.telefono"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">SIM (NUEVO):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiosim.simcard_nuevo.sim"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">IP (NUEVO):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiosim.simcard_nuevo.ip"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">TELÉFONO (NUEVO):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiosim.simcard_nuevo.telefono"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">LUGAR:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiosim.lugar"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">CORTE DE MOTOR:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-if="cambiosim.cortemotor">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">POSICIÓN:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-if="cambiosim.posicion">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">PÁNICO:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-if="cambiosim.panico">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">OTROS:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiosim.otros"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">OBSERVACIONES:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiosim.observacion"></label>
                                </div>
                                <div class="row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenCambioSim/'+image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="vermodal == 4">
                            <div class="form-group row">
                                <label class="col-md-5 form-control-label" for="text-input">TÉCNICO:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="tecnico.nombre"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">NOMBRE:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.nombre"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">PLACA:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.placa"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">ID_DISPOSITIVO (ANTERIOR):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.id_dispositivo_viejo"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">IMEI (ANTERIOR):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.gps_viejo.imei"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">SERIE (ANTERIOR):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.gps_viejo.serie"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">MARCA (ANTERIOR):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.gps_viejo.marca"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">MODELO (ANTERIOR):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.gps_viejo.modelo"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">ID_DISPOSITIVO (NUEVO):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.id_dispositivo_nuevo"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">IMEI (NUEVO):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.gps_nuevo.imei"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">SERIE (NUEVO):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.gps_nuevo.serie"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">MARCA (NUEVO):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.gps_nuevo.marca"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">MODELO (NUEVO):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.gps_nuevo.modelo"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">SIM (NUEVO):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.simcard_nuevo.sim"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">IP (NUEVO):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.simcard_nuevo.ip"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">TELÉFONO (NUEVO):</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.simcard_nuevo.telefono"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">LUGAR:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.lugar"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">CORTE DE MOTOR:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-if="cambiogps.cortemotor">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">POSICIÓN:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-if="cambiogps.posicion">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">PÁNICO:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-if="cambiogps.panico">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">OTROS:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.otros"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">OBSERVACIONES:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="cambiogps.observacion"></label>
                                </div>
                                <div class="row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenCambioGps/'+image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="vermodal == 5">
                            <div class="form-group row">
                                <label class="col-md-5 form-control-label" for="text-input">TÉCNICO:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="tecnico.nombre"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">PLACA ANTERIOR:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="trasladogps.placa_anterior"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">PLACA NUEVA:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="trasladogps.placa_nueva"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">LUGAR:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="trasladogps.lugar"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">CORTE DE MOTOR:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-if="trasladogps.cortemotor">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">POSICIÓN:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-if="trasladogps.posicion">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">PÁNICO:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-if="trasladogps.panico">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">OTROS:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="trasladogps.otros"></label>
                                </div>
                                <label class="col-md-5 form-control-label" for="text-input">OBSERVACIONES:</label>
                                <div class="col-md-7">
                                    <label class="form-control-label" v-text="trasladogps.observacion"></label>
                                </div>
                                <div class="row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenTrasladoGps/'+image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="vermodal == 6">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">TÉCNICO:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="tecnico.nombre"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">PLACA:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="desinstalacion.placa"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">NOMBRE:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="desinstalacion.placa"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">ID_DISPOSITIVO:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="desinstalacion.id_dispositivo"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">LUGAR:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="desinstalacion.lugar"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">OTROS:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="desinstalacion.otros"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">OBSERVACIONES:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="desinstalacion.observacion"></label>
                                </div>
                                <div class="row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenDesinstalacion/'+image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="vermodal == 7">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">TÉCNICO:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="tecnico.nombre"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">PLACA:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="homologacion.placa"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">ID DEL DISPOSITIVO:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="homologacion.id_dispositivo"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">LUGAR:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="homologacion.lugar"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">CORTE DE MOTOR:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-if="homologacion.cortemotor">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">POSICIÓN:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-if="homologacion.posicion">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">PÁNICO:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-if="homologacion.panico">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">OTROS:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="homologacion.otros"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">OBSERVACIONES:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="homologacion.observacion"></label>
                                </div>
                                <div class="row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenHomologacion/'+image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="vermodal == 8">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">TÉCNICO:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="tecnico.nombre"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">PLACA:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="reinstalacion.placa"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">NOMBRE:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="reinstalacion.nombre"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">ID DEL DISPOSITIVO:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="reinstalacion.id_dispositivo"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">LUGAR:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="reinstalacion.lugar"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">CORTE DE MOTOR:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-if="reinstalacion.cortemotor">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">POSICIÓN:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-if="reinstalacion.posicion">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">PÁNICO:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-if="reinstalacion.panico">SI</label>
                                    <label class="form-control-label" v-else>NO</label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">OTROS:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="reinstalacion.otros"></label>
                                </div>
                                <label class="col-md-3 form-control-label" for="text-input">OBSERVACIONES:</label>
                                <div class="col-md-9">
                                    <label class="form-control-label" v-text="reinstalacion.observacion"></label>
                                </div>
                                <div class="row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenReinstalacion/'+image" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="formodal == 1">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">CLIENTE:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">TÉCNICO:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">FECHA:</label>
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
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">ID DEL GPS:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="instalacion.id_dispositivo" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">PLACA:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="instalacion.placa" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">DISPOSITIVO GPS:</label>
                                    <div class="col-md-8">
                                        <v-select 
                                            @input="getDatosGps"
                                            @search="selectGps" 
                                            label="imei"
                                            :options="instalacion.arrayGps"
                                            placeholder="BUSCAR DISPOSITIVOS..."
                                        >
                                        </v-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label" for="text-input">IMEI:</label>
                                    <div class="col-md-8" v-text="instalacion.gps.imei"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">SERIE:</label>
                                    <div class="col-md-8" v-text="instalacion.gps.serie"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">MARCA:</label>
                                    <div class="col-md-8" v-text="instalacion.gps.marca"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">MODELO:</label>
                                    <div class="col-md-8" v-text="instalacion.gps.modelo"></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">SIMCARD:</label>
                                    <div class="col-md-8">
                                        <v-select 
                                            @input="getDatosSim"
                                            @search="selectSim" 
                                            label="imsi"
                                            :options="instalacion.arraySim"
                                            placeholder="BUSCAR SIMCARDS..."
                                        >
                                        </v-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label" for="text-input">SIM:</label>
                                    <div class="col-md-8" v-text="instalacion.simcard.sim"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">IP:</label>
                                    <div class="col-md-8" v-text="instalacion.simcard.ip"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">TELÉFONO:</label>
                                    <div class="col-md-8" v-text="instalacion.simcard.telefono"></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">LUGAR:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="instalacion.lugar" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">PRUEBAS REALIZADAS:</label>
                                    <div class="col-md-9 col-form-label">
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox1" type="checkbox" v-model="instalacion.cortemotor" value="check1">
                                            <label class="form-check-label" for="inline-checkbox1">CORTE DE MOTOR</label>
                                        </div>
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox2" type="checkbox" v-model="instalacion.panico" value="check2">
                                            <label class="form-check-label" for="inline-checkbox2">PÁNICO</label>
                                        </div>
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox3" type="checkbox" v-model="instalacion.posicion" value="check3">
                                            <label class="form-check-label" for="inline-checkbox3">POSICIÓN</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OTROS:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="instalacion.otros" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OBSERVACIONES:</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control observaciones" cols="30" rows="3" v-model="instalacion.observacion" placeholder="Text"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
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
                                <div v-if="tipoAccion==1" class="form-group row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenInstalacion/'+image" />
                                    </div>
                                </div>
                                <div v-else-if="tipoAccion==2" class="form-group row">
                                    <div v-for="(image, key) in fotosnuevas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :ref="'fotosnuevas'" />
                                    </div>
                                </div>
                            </form>
                            <div v-show="errorInstalacion" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjInstalacion" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" @click="actualizarInstalacion()" class="btn btn-primary">ACTUALIZAR</button>
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">CERRAR</button>
                            </div>
                        </div>
                        <div v-if="formodal == 2">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">CLIENTE:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">TÉCNICO:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">FECHA:</label>
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
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">PLACA:</label>
                                    <div class="col-md-8">
                                        <v-select 
                                            @input="getDatosVehiculo"
                                            @search="selectVehiculo" 
                                            label="placa"
                                            v-model="revision.placa"
                                            :options="revision.arrayVehiculo"
                                            placeholder="BUSCAR PLACAS..."
                                        >
                                        </v-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">NOMBRE:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="revision.nombre" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">LUGAR:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="revision.lugar" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">PRUEBAS REALIZADAS:</label>
                                    <div class="col-md-9 col-form-label">
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox1" type="checkbox" v-model="revision.cortemotor" value="check1">
                                            <label class="form-check-label" for="inline-checkbox1">CORTE DE MOTOR</label>
                                        </div>
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox2" type="checkbox" v-model="revision.panico" value="check2">
                                            <label class="form-check-label" for="inline-checkbox2">PÁNICO</label>
                                        </div>
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox3" type="checkbox" v-model="revision.posicion" value="check3">
                                            <label class="form-check-label" for="inline-checkbox3">POSICIÓN</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OTROS:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="revision.otros" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OBSERVACIONES:</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control observaciones" cols="30" rows="3" v-model="revision.observacion" placeholder="Text"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
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
                                <div v-if="tipoAccion==1" class="form-group row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenRevisiones/'+image" />
                                    </div>
                                </div>
                                <div v-else-if="tipoAccion==2" class="form-group row">
                                    <div v-for="(image, key) in fotosnuevas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :ref="'fotosnuevas'" />
                                    </div>
                                </div>
                            </form>
                            <div v-show="errorRevision" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjRevision" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" @click="actualizarRevision()">ACTUALIZAR</button>
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">CERRAR</button>
                            </div>
                        </div>
                        <div v-if="formodal == 3">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">CLIENTE:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">TÉCNICO:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">FECHA:</label>
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
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">NOMBRE:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="cambiosim.nombre" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">PLACA:</label>
                                    <div class="col-md-8">
                                        <v-select 
                                            @input="getDatosVehiculoCambioSim"
                                            @search="selectVehiculoCambioSim" 
                                            label="placa"
                                            v-model="cambiosim.placa"
                                            :options="cambiosim.arrayVehiculo"
                                            placeholder="BUSCAR PLACAS..."
                                        >
                                        </v-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">SIMCARD ANTERIOR:</label>
                                    <div class="col-md-8">
                                        <v-select 
                                            @input="getDatosSimViejoCambioSim"
                                            @search="selectSimViejoCambioSim" 
                                            label="imsi"
                                            :options="cambiosim.arraySim"
                                            placeholder="BUSCAR SIMCARDS..."
                                        >
                                        </v-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label" for="text-input">SIM:</label>
                                    <div class="col-md-8" v-text="cambiosim.simcard_viejo.sim"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">IP:</label>
                                    <div class="col-md-8" v-text="cambiosim.simcard_viejo.ip"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">TELÉFONO:</label>
                                    <div class="col-md-8" v-text="cambiosim.simcard_viejo.telefono"></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">SIMCARD:</label>
                                    <div class="col-md-8">
                                        <v-select 
                                            @input="getDatosSimNuevoCambioSim"
                                            @search="selectSimNuevoCambioSim" 
                                            label="imsi"
                                            :options="cambiosim.arraySim"
                                            placeholder="BUSCAR SIMCARDS..."
                                        >
                                        </v-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label" for="text-input">SIM:</label>
                                    <div class="col-md-8" v-text="cambiosim.simcard_nuevo.sim"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">IP:</label>
                                    <div class="col-md-8" v-text="cambiosim.simcard_nuevo.ip"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">TELÉFONO:</label>
                                    <div class="col-md-8" v-text="cambiosim.simcard_nuevo.telefono"></div>
                                </div>                           
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">LUGAR:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="cambiosim.lugar" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">PRUEBAS REALIZADAS:</label>
                                    <div class="col-md-9 col-form-label">
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox1" type="checkbox" v-model="cambiosim.cortemotor" value="check1">
                                            <label class="form-check-label" for="inline-checkbox1">CORTE DE MOTOR</label>
                                        </div>
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox2" type="checkbox" v-model="cambiosim.panico" value="check2">
                                            <label class="form-check-label" for="inline-checkbox2">PÁNICO</label>
                                        </div>
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox3" type="checkbox" v-model="cambiosim.posicion" value="check3">
                                            <label class="form-check-label" for="inline-checkbox3">POSICIÓN</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OTROS:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="cambiosim.otros" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OBSERVACIONES:</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control observaciones" cols="30" rows="3" v-model="cambiosim.observacion" placeholder="Text"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
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
                                <div v-if="tipoAccion==1" class="form-group row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenCambioSim/'+image" />
                                    </div>
                                </div>
                                <div v-else-if="tipoAccion==2" class="form-group row">
                                    <div v-for="(image, key) in fotosnuevas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :ref="'fotosnuevas'" />
                                    </div>
                                </div>
                            </form>
                            <div v-show="errorCambioSim" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjCambioSim" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" @click="actualizarCambioSim()">ACTUALIZAR</button>
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">CERRAR</button>
                            </div>
                        </div>
                        <div v-if="formodal == 4">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">CLIENTE:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">TÉCNICO:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">FECHA:</label>
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
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">NOMBRE:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="cambiogps.nombre" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">PLACA:</label>
                                    <div class="col-md-8">
                                        <v-select 
                                            @input="getDatosVehiculoCambioGps"
                                            @search="selectVehiculoCambioGps" 
                                            label="placa"
                                            v-model="cambiogps.placa"
                                            :options="cambiogps.arrayVehiculo"
                                            placeholder="BUSCAR PLACAS..."
                                        >
                                        </v-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">ID DISPOSITIVO ANTERIOR:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="cambiogps.id_dispositivo_viejo" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">DISPOSITIVO GPS ANTERIOR:</label>
                                    <div class="col-md-8">
                                        <v-select 
                                            @input="getDatosGpsViejoCambioGps"
                                            @search="selectGpsViejoCambioGps" 
                                            label="imei"
                                            :options="cambiogps.arrayGps"
                                            placeholder="BUSCAR DISPOSITIVOS..."
                                        >
                                        </v-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label" for="text-input">IMEI:</label>
                                    <div class="col-md-8" v-text="cambiogps.gps_viejo.imei"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">SERIE:</label>
                                    <div class="col-md-8" v-text="cambiogps.gps_viejo.serie"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">MARCA:</label>
                                    <div class="col-md-8" v-text="cambiogps.gps_viejo.marca"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">MODELO:</label>
                                    <div class="col-md-8" v-text="cambiogps.gps_viejo.modelo"></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">ID DISPOSITIVO NUEVO:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="cambiogps.id_dispositivo_nuevo" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">DISPOSITIVO GPS NUEVO:</label>
                                    <div class="col-md-8">
                                        <v-select 
                                            @input="getDatosGpsNuevoCambioGps"
                                            @search="selectGpsNuevoCambioGps" 
                                            label="imei"
                                            :options="cambiogps.arrayGps"
                                            placeholder="BUSCAR DISPOSITIVOS..."
                                        >
                                        </v-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label" for="text-input">IMEI:</label>
                                    <div class="col-md-8" v-text="cambiogps.gps_nuevo.imei"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">SERIE:</label>
                                    <div class="col-md-8" v-text="cambiogps.gps_nuevo.serie"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">MARCA:</label>
                                    <div class="col-md-8" v-text="cambiogps.gps_nuevo.marca"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">MODELO:</label>
                                    <div class="col-md-8" v-text="cambiogps.gps_nuevo.modelo"></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">SIMCARD:</label>
                                    <div class="col-md-8">
                                        <v-select 
                                            @input="getDatosSimNuevoCambioGps"
                                            @search="selectSimNuevoCambioGps" 
                                            label="imsi"
                                            :options="cambiogps.arraySim"
                                            placeholder="BUSCAR SIMCARDS..."
                                        >
                                        </v-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label" for="text-input">SIM:</label>
                                    <div class="col-md-8" v-text="cambiogps.simcard_nuevo.sim"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">IP:</label>
                                    <div class="col-md-8" v-text="cambiogps.simcard_nuevo.ip"></div>
                                
                                    <label class="col-md-4 col-form-label" for="text-input">TELÉFONO:</label>
                                    <div class="col-md-8" v-text="cambiogps.simcard_nuevo.telefono"></div>
                                </div>                           
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">LUGAR:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="cambiogps.lugar" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">PRUEBAS REALIZADAS:</label>
                                    <div class="col-md-9 col-form-label">
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox1" type="checkbox" v-model="cambiogps.cortemotor" value="check1">
                                            <label class="form-check-label" for="inline-checkbox1">CORTE DE MOTOR</label>
                                        </div>
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox2" type="checkbox" v-model="cambiogps.panico" value="check2">
                                            <label class="form-check-label" for="inline-checkbox2">PÁNICO</label>
                                        </div>
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox3" type="checkbox" v-model="cambiogps.posicion" value="check3">
                                            <label class="form-check-label" for="inline-checkbox3">POSICIÓN</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OTROS:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="cambiogps.otros" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OBSERVACIONES:</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control observaciones" cols="30" rows="3" v-model="cambiogps.observacion" placeholder="Text"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
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
                                <div v-if="tipoAccion==1" class="form-group row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenCambioGps/'+image" />
                                    </div>
                                </div>
                                <div v-else-if="tipoAccion==2" class="form-group row">
                                    <div v-for="(image, key) in fotosnuevas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :ref="'fotosnuevas'" />
                                    </div>
                                </div>
                            </form>
                            <div v-show="errorCambioGps" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjCambioGps" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" @click="actualizarCambioGps()">ACTUALIZAR</button>
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">CERRAR</button>
                            </div>
                        </div>
                        <div v-if="formodal == 5">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">CLIENTE:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">TÉCNICO:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">FECHA:</label>
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
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">PLACA ANTERIOR:</label>
                                    <div class="col-md-8">
                                        <v-select 
                                            @input="getDatosVehiculoViejoTrasladoGps"
                                            @search="selectVehiculoViejoTrasladoGps" 
                                            label="placa"
                                            v-model="trasladogps.placa_anterior"
                                            :options="trasladogps.arrayVehiculo"
                                            placeholder="BUSCAR PLACAS..."
                                        >
                                        </v-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">PLACA NUEVA:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="trasladogps.placa_nueva" placeholder="Text">
                                    </div>
                                </div>                           
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">LUGAR:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="trasladogps.lugar" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">PRUEBAS REALIZADAS:</label>
                                    <div class="col-md-9 col-form-label">
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox1" type="checkbox" v-model="trasladogps.cortemotor" value="check1">
                                            <label class="form-check-label" for="inline-checkbox1">CORTE DE MOTOR</label>
                                        </div>
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox2" type="checkbox" v-model="trasladogps.panico" value="check2">
                                            <label class="form-check-label" for="inline-checkbox2">PÁNICO</label>
                                        </div>
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox3" type="checkbox" v-model="trasladogps.posicion" value="check3">
                                            <label class="form-check-label" for="inline-checkbox3">POSICIÓN</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OTROS:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="trasladogps.otros" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OBSERVACIONES:</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control observaciones" cols="30" rows="3" v-model="trasladogps.observacion" placeholder="Text"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
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
                                <div v-if="tipoAccion==1" class="form-group row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenTrasladoGps/'+image" />
                                    </div>
                                </div>
                                <div v-else-if="tipoAccion==2" class="form-group row">
                                    <div v-for="(image, key) in fotosnuevas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :ref="'fotosnuevas'" />
                                    </div>
                                </div>
                            </form>
                            <div v-show="errorTrasladoGps" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjTrasladoGps" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" @click="actualizarTrasladoGps()">ACTUALIZAR</button>
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">CERRAR</button>
                            </div>
                        </div>
                        <div v-if="formodal == 6">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">CLIENTE:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">TÉCNICO:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">FECHA:</label>
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
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">PLACA:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="desinstalacion.placa" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">NOMBRE:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="desinstalacion.nombre" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">ID DEL GPS:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="desinstalacion.id_dispositivo" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">LUGAR:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="desinstalacion.lugar" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OTROS:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="desinstalacion.otros" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OBSERVACIONES:</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control observaciones" cols="30" rows="3" v-model="desinstalacion.observacion" placeholder="Text"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
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
                                <div v-if="tipoAccion==1" class="form-group row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenDesinstalacion/'+image" />
                                    </div>
                                </div>
                                <div v-else-if="tipoAccion==2" class="form-group row">
                                    <div v-for="(image, key) in fotosnuevas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :ref="'fotosnuevas'" />
                                    </div>
                                </div>
                            </form>
                            <div v-show="errorDesinstalacion" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjDesinstalacion" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" @click="actualizarDesinstalacion()">ACTUALIZAR</button>
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">CERRAR</button>
                            </div>
                        </div>
                        <div v-if="formodal == 7">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">CLIENTE:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">TÉCNICO:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">FECHA:</label>
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
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">PLACA:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="homologacion.placa" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">ID DEL DISPOSITIVO:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="homologacion.id_dispositivo" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">LUGAR:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="homologacion.lugar" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">PRUEBAS REALIZADAS:</label>
                                    <div class="col-md-9 col-form-label">
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox1" type="checkbox" v-model="homologacion.cortemotor" value="check1">
                                            <label class="form-check-label" for="inline-checkbox1">CORTE DE MOTOR</label>
                                        </div>
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox2" type="checkbox" v-model="homologacion.panico" value="check2">
                                            <label class="form-check-label" for="inline-checkbox2">PÁNICO</label>
                                        </div>
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox3" type="checkbox" v-model="homologacion.posicion" value="check3">
                                            <label class="form-check-label" for="inline-checkbox3">POSICIÓN</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OTROS:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="homologacion.otros" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OBSERVACIONES:</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control observaciones" cols="30" rows="3" v-model="homologacion.observacion" placeholder="Text"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
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
                                <div v-if="tipoAccion==1" class="form-group row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenHomologacion/'+image" />
                                    </div>
                                </div>
                                <div v-else-if="tipoAccion==2" class="form-group row">
                                    <div v-for="(image, key) in fotosnuevas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :ref="'fotosnuevas'" />
                                    </div>
                                </div>
                            </form>
                            <div v-show="errorHomologacion" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjHomologacion" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" @click="actualizarHomologacion()">ACTUALIZAR</button>
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">CERRAR</button>
                            </div>
                        </div>
                        <div v-if="formodal == 8">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">CLIENTE:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">TÉCNICO:</label>
                                    <div class="col-md-9">
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">FECHA:</label>
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
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">PLACA:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="reinstalacion.placa" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">NOMBRE:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="reinstalacion.nombre" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">ID DEL DISPOSITIVO:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="reinstalacion.id_dispositivo" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">LUGAR:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="reinstalacion.lugar" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">PRUEBAS REALIZADAS:</label>
                                    <div class="col-md-9 col-form-label">
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox1" type="checkbox" v-model="reinstalacion.cortemotor" value="check1">
                                            <label class="form-check-label" for="inline-checkbox1">CORTE DE MOTOR</label>
                                        </div>
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox2" type="checkbox" v-model="reinstalacion.panico" value="check2">
                                            <label class="form-check-label" for="inline-checkbox2">PÁNICO</label>
                                        </div>
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" id="inline-checkbox3" type="checkbox" v-model="reinstalacion.posicion" value="check3">
                                            <label class="form-check-label" for="inline-checkbox3">POSICIÓN</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OTROS:</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" v-model="reinstalacion.otros" placeholder="Text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="date-input">OBSERVACIONES:</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control observaciones" cols="30" rows="3" v-model="reinstalacion.observacion" placeholder="Text"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
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
                                <div v-if="tipoAccion==1" class="form-group row">
                                    <div v-for="(image, key) in fotosviejas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :src="'/obtenerImagenReinstalacion/'+image" />
                                    </div>
                                </div>
                                <div v-else-if="tipoAccion==2" class="form-group row">
                                    <div v-for="(image, key) in fotosnuevas" :key="key" class="col-md-4">
                                        <img class="img-thumbnail img-rounded img-responsive" :ref="'fotosnuevas'" />
                                    </div>
                                </div>
                            </form>
                            <div v-show="errorReinstalacion" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjReinstalacion" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" @click="actualizarReinstalacion()">ACTUALIZAR</button>
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">CERRAR</button>
                            </div>
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

    import Vue from 'vue';
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

                fecha : '',
                
                instalacion : {
                    id : 0,
                    placa : '',
                    id_dispositivo : '',
                    id_actividadtecnica : 0,
                    gps : {
                        id : 0,
                        imei : '',
                        serie : '',
                        marca : '',
                        modelo : '',
                    },
                    arrayGps : [],
                    simcard : {
                        id : 0,
                        sim : '',
                        ip : '',
                        telefono : ''
                    },
                    arraySim : [],
                    lugar : '',
                    posicion : false,
                    panico : false,
                    cortemotor : false,
                    otros : '',
                    observacion : '',
                },
                revision : {
                    id : 0,
                    id_actividadtecnica : 0,
                    placa : '',
                    nombre : '',
                    lugar : '',
                    posicion : false,
                    panico : false,
                    cortemotor : false,
                    otros : '',
                    observacion : '',
                    arrayVehiculo : []
                },
                cambiosim : {
                    id : 0,
                    id_actividadtecnica : 0,
                    nombre : '',
                    placa : '',
                    lugar : '',
                    posicion : false,
                    panico : false,
                    cortemotor : false,
                    otros : '',
                    observacion : '',
                    arrayVehiculo : [],
                    arrayGps : [],
                    arraySim : [],
                    simcard_viejo : {
                        id: 0,
                        sim : '',
                        ip : '',
                        telefono : ''
                    },
                    simcard_nuevo : {
                        id: 0,
                        sim : '',
                        ip : '',
                        telefono : ''
                    }
                },
                cambiogps : {
                    id : 0,
                    id_actividadtecnica : 0,
                    nombre : '',
                    placa : '',
                    id_dispositivo_viejo : '',
                    id_dispositivo_nuevo : '',
                    lugar : '',
                    posicion : false,
                    panico : false,
                    cortemotor : false,
                    otros : '',
                    observacion : '',
                    arrayVehiculo : [],
                    arrayGps : [],
                    arraySim : [],
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
                        id: 0,
                        sim : '',
                        ip : '',
                        telefono : ''
                    }
                },
                trasladogps : {
                    id : 0,
                    id_actividadtecnica : 0,
                    nombre : '',
                    placa_anterior : '',
                    placa_nueva : '',
                    lugar : '',
                    posicion : false,
                    panico : false,
                    cortemotor : false,
                    otros : '',
                    observacion : '',
                    arrayVehiculo : [],
                },
                homologacion : {
                    id : 0,
                    id_actividadtecnica : 0,
                    placa : '',
                    id_dispositivo : '',
                    lugar : '',
                    posicion : false,
                    panico : false,
                    cortemotor : false,
                    otros : '',
                    observacion : '',
                    arrayVehiculo : []
                },
                reinstalacion : {
                    id : 0,
                    id_actividadtecnica : 0,
                    placa : '',
                    id_dispositivo : '',
                    nombre : '',
                    lugar : '',
                    posicion : false,
                    panico : false,
                    cortemotor : false,
                    otros : '',
                    observacion : '',
                    arrayVehiculo : []
                },
                desinstalacion : {
                    id : 0,
                    id_actividadtecnica : 0,
                    placa : '',
                    id_dispositivo : '',
                    nombre : '',
                    lugar : '',
                    otros : '',
                    observacion : '',
                },
                fotosviejas : [],
                fotosnuevas : [],
                cliente_id : 0,
                arrayCliente : [],
                cliente : {
                    id : 0,
                    nombre : ''
                },
                tecnico_id : 0,
                arrayTecnico : [],
                tecnico : {
                    id : 0,
                    nombre : ''
                },
                user : {
                    usuario : '',
                    nombrecompleto : '',
                    email : '',
                    idrol : 0
                },
                errorInstalacion : 0,
                errorMostrarMsjInstalacion : [],
                errorRevision : 0,
                errorMostrarMsjRevision : [],
                errorCambioSim : 0,
                errorMostrarMsjCambioSim : [],
                errorCambioGps : 0,
                errorMostrarMsjCambioGps : [],
                errorTrasladoGps : 0,
                errorMostrarMsjTrasladoGps : [],
                errorDesinstalacion : 0,
                errorMostrarMsjDesinstalacion : [],
                errorHomologacion : 0,
                errorMostrarMsjHomologacion : [],
                errorReinstalacion : 0,
                errorMostrarMsjReinstalacion : [],
                vermodal : 0,
                formodal : 0,            
                arrayActividadTecnica : [],
                modal : 0,
                tituloModal : '',
                tipoAccion: 0,
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'id',
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

            onFileChange(e) {

                // Obtener la informacion de las imagenes que selecciona el usuario en formato base64

                let vm = this;
                vm.tipoAccion = 2;
                vm.fotosnuevas = [];

                let selectedFiles = e.target.files || e.dataTransfer.files;
                let file = document.querySelector('input[type=file]').files;

                for (let i = 0; i < selectedFiles.length; i++) {
                    
                    console.log(selectedFiles[i]);
                    vm.fotosnuevas.push(selectedFiles[i]);

                }

                for (let i = 0; i < vm.fotosnuevas.length; i++) {
                    
                    let reader = new FileReader();
                    
                    reader.onload = (e) => {
                        vm.$refs.fotosnuevas[i].src = reader.result;
                        vm.fotosnuevas[i] = e.target.result;
                        console.log(vm.$refs.fotosnuevas[i].src);
                    };

                    reader.readAsDataURL(file[i]);
                }

            },

            listarActividadTecnica(page, buscar, criterio){

                let me = this;
                var url = '/actividadestecnicas?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                
                axios.get(url).then(function (response) {

                    var respuesta = response.data;
                    me.arrayActividadTecnica = respuesta.actividades.data;
                    me.user.id = respuesta.user.id;
                    me.user.usuario = respuesta.user.usuario;
                    me.user.email = respuesta.user.email;
                    me.user.idrol = respuesta.user.idrol;
                    me.pagination = respuesta.pagination;
                    console.log(response);

                }).catch(function (error) {
                    
                    console.log(error);

                })
            },

            cambiarPagina(page, buscar, criterio){
                
                let me = this;
                me.pagination.current_page = page;
                me.listarActividadTecnica(page, buscar, criterio);

            },

            revisarActividadTecnica(id){

                const swalWithBootstrapButtons = Swal.mixin({

                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },

                    buttonsStyling: false

                    })

                    swalWithBootstrapButtons.fire({
                    
                        title: 'ESTÁ SEGURO DE CONFIRMAR LA ACTIVIDAD TÉCNICA?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'SÍ, YA ESTÁ REVISADA!',
                        cancelButtonText: 'NO, NECESITO MÁS TIEMPO!',
                        reverseButtons: true

                    }).then((result) => {

                        if (result.value) {

                            let me = this;

                            axios.put('/actividadestecnicas/confirmar', {

                                'id': id

                            }).then(function (response) {

                                me.listarActividadTecnica(1, '', 'fecha');
                                swalWithBootstrapButtons.fire(
                                    'CONFIRMADA!',
                                    'LA ACTIVIDAD TÉCNICA HA SIDO REVISADA Y CONFIRMADA.',
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

            desrevisarActividadTecnica(id){

                const swalWithBootstrapButtons = Swal.mixin({

                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },

                    buttonsStyling: false

                    })

                    swalWithBootstrapButtons.fire({
                    
                        title: 'ESTÁ SEGURO DE VOLVER A REVISAR LA ACTIVIDAD TÉCNICA?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'SÍ, HAY QUE CORREGIR ALGO!',
                        cancelButtonText: 'NO, ASI ESTA BIEN!',
                        reverseButtons: true

                    }).then((result) => {

                        if (result.value) {

                            let me = this;

                            axios.put('/actividadestecnicas/desconfirmar', {

                                'id': id

                            }).then(function (response) {

                                me.listarActividadTecnica(1, '', 'fecha');
                                swalWithBootstrapButtons.fire(
                                    'CONFIRMADA!',
                                    'LA ACTIVIDAD TÉCNICA SE PUEDE REVISAR OTRA VEZ.',
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

            actualizarInstalacion(){

                if(this.validarEdicion('INSTALACION')){
                    return;
                }

                let me = this;

                axios.put('/instalaciones/actualizar', {

                    'id_instalacion' : me.instalacion.id,
                    'placa' : me.instalacion.placa,
                    'id_dispositivo' : me.instalacion.id_dispositivo,
                    'id_gps' : me.instalacion.gps.id,
                    'id_simcard' : me.instalacion.simcard.id,
                    'lugar' : me.instalacion.lugar,
                    'posicion' : me.instalacion.posicion,
                    'panico' : me.instalacion.panico,
                    'cortemotor' : me.instalacion.cortemotor,
                    'otros' : me.instalacion.otros,
                    'observacion' : me.instalacion.observacion,
                    'id_actividadtecnica' : me.instalacion.id_actividadtecnica,
                    'id_tecnico' : me.tecnico.id,
                    'id_cliente' : me.cliente.id,
                    'fecha' : me.fecha,
                    'fotosviejas' : me.fotosviejas,
                    'fotosnuevas' : me.fotosnuevas

                }).then(function (response) {

                    me.cerrarModal();
                    me.listarActividadTecnica(1, '', 'fecha');

                    Swal.fire({
                            
                        position: 'top-end',
                        icon: 'success',
                        title: 'ACTIVIDAD TÉCNICA ACTUALIZADA',
                        showConfirmButton: false,
                        timer: 1500

                    });

                }).catch(function (error) {

                    console.log(error);

                });

            },

            actualizarRevision(){

                if(this.validarEdicion('REVISION')){
                    return;
                }

                let me = this;

                axios.put('/revisiones/actualizar', {

                    'id_revision' : me.revision.id,
                    'placa' : me.revision.placa,
                    'nombre' : me.revision.nombre,
                    'lugar' : me.revision.lugar,
                    'posicion' : me.revision.posicion,
                    'panico' : me.revision.panico,
                    'cortemotor' : me.revision.cortemotor,
                    'otros' : me.revision.otros,
                    'observacion' : me.revision.observacion,
                    'id_actividadtecnica' : me.revision.id_actividadtecnica,
                    'id_tecnico' : me.tecnico.id,
                    'id_cliente' : me.cliente.id,
                    'fecha' : me.fecha,
                    'fotosviejas' : me.fotosviejas,
                    'fotosnuevas' : me.fotosnuevas

                }).then(function (response) {

                    me.cerrarModal();
                    me.listarActividadTecnica(1, '', 'fecha');

                    Swal.fire({
                            
                        position: 'top-end',
                        icon: 'success',
                        title: 'ACTIVIDAD TÉCNICA ACTUALIZADA',
                        showConfirmButton: false,
                        timer: 1500

                    });

                }).catch(function (error) {

                    console.log(error);

                });

            },

            actualizarCambioSim(){

                if(this.validarEdicion('CAMBIO DE SIM')){
                    return;
                }

                let me = this;

                axios.put('/cambiosimcards/actualizar', {

                    'id_cambiosim' : me.cambiosim.id,
                    'placa' : me.cambiosim.placa,
                    'nombre' : me.cambiosim.nombre,
                    'id_simcard_viejo' : me.cambiosim.simcard_viejo.id,
                    'id_simcard_nuevo' : me.cambiosim.simcard_nuevo.id,
                    'lugar' : me.cambiosim.lugar,
                    'posicion' : me.cambiosim.posicion,
                    'panico' : me.cambiosim.panico,
                    'cortemotor' : me.cambiosim.cortemotor,
                    'otros' : me.cambiosim.otros,
                    'observacion' : me.cambiosim.observacion,
                    'id_actividadtecnica' : me.cambiosim.id_actividadtecnica,
                    'id_tecnico' : me.tecnico.id,
                    'id_cliente' : me.cliente.id,
                    'fecha' : me.fecha,
                    'fotosviejas' : me.fotosviejas,
                    'fotosnuevas' : me.fotosnuevas

                }).then(function (response) {

                    me.cerrarModal();
                    me.listarActividadTecnica(1, '', 'fecha');

                    Swal.fire({
                            
                        position: 'top-end',
                        icon: 'success',
                        title: 'ACTIVIDAD TÉCNICA ACTUALIZADA',
                        showConfirmButton: false,
                        timer: 1500

                    });

                }).catch(function (error) {

                    console.log(error);

                });

            },

            actualizarCambioGps(){

                if(this.validarEdicion('CAMBIO DE GPS')){
                    return;
                }

                let me = this;

                axios.put('/cambiogps/actualizar', {

                    'id_cambiogps' : me.cambiogps.id,
                    'placa' : me.cambiogps.placa,
                    'nombre' : me.cambiogps.nombre,
                    'id_dispositivo_viejo' : me.cambiogps.id_dispositivo_viejo,
                    'id_dispositivo_nuevo' : me.cambiogps.id_dispositivo_nuevo,
                    'id_gps_viejo' : me.cambiogps.gps_viejo.id,
                    'id_gps_nuevo' : me.cambiogps.gps_nuevo.id,
                    'id_simcard_nuevo' : me.cambiogps.simcard_nuevo.id,
                    'lugar' : me.cambiogps.lugar,
                    'posicion' : me.cambiogps.posicion,
                    'panico' : me.cambiogps.panico,
                    'cortemotor' : me.cambiogps.cortemotor,
                    'otros' : me.cambiogps.otros,
                    'observacion' : me.cambiogps.observacion,
                    'id_actividadtecnica' : me.cambiogps.id_actividadtecnica,
                    'id_tecnico' : me.tecnico.id,
                    'id_cliente' : me.cliente.id,
                    'fecha' : me.fecha,
                    'fotosviejas' : me.fotosviejas,
                    'fotosnuevas' : me.fotosnuevas

                }).then(function (response) {

                    me.cerrarModal();
                    me.listarActividadTecnica(1, '', 'fecha');

                    Swal.fire({
                            
                        position: 'top-end',
                        icon: 'success',
                        title: 'ACTIVIDAD TÉCNICA ACTUALIZADA',
                        showConfirmButton: false,
                        timer: 1500

                    });

                }).catch(function (error) {

                    console.log(error);

                });

            },

            actualizarTrasladoGps(){

                if(this.validarEdicion('TRASLADO DE GPS')){
                    return;
                }

                let me = this;

                axios.put('/trasladosgps/actualizar', {

                    'id_trasladogps' : me.trasladogps.id,
                    'placa_anterior' : me.trasladogps.placa_anterior,
                    'placa_nueva' : me.trasladogps.placa_nueva,
                    'lugar' : me.trasladogps.lugar,
                    'posicion' : me.trasladogps.posicion,
                    'panico' : me.trasladogps.panico,
                    'cortemotor' : me.trasladogps.cortemotor,
                    'otros' : me.trasladogps.otros,
                    'observacion' : me.trasladogps.observacion,
                    'id_actividadtecnica' : me.trasladogps.id_actividadtecnica,
                    'id_tecnico' : me.tecnico.id,
                    'id_cliente' : me.cliente.id,
                    'fecha' : me.fecha,
                    'fotosviejas' : me.fotosviejas,
                    'fotosnuevas' : me.fotosnuevas

                }).then(function (response) {

                    me.cerrarModal();
                    me.listarActividadTecnica(1, '', 'fecha');

                    Swal.fire({
                            
                        position: 'top-end',
                        icon: 'success',
                        title: 'ACTIVIDAD TÉCNICA ACTUALIZADA',
                        showConfirmButton: false,
                        timer: 1500

                    });

                }).catch(function (error) {

                    console.log(error);

                });

            },

            actualizarDesinstalacion(){

                if(this.validarEdicion('DESINSTALACION')){
                    return;
                }

                let me = this;

                axios.put('/desinstalaciones/actualizar', {

                    'id_desinstalacion' : me.desinstalacion.id,
                    'placa' : me.desinstalacion.placa,
                    'nombre' : me.desinstalacion.nombre,
                    'id_dispositivo' : me.desinstalacion.id_dispositivo,
                    'lugar' : me.desinstalacion.lugar,
                    'otros' : me.desinstalacion.otros,
                    'observacion' : me.desinstalacion.observacion,
                    'id_actividadtecnica' : me.desinstalacion.id_actividadtecnica,
                    'id_tecnico' : me.tecnico.id,
                    'id_cliente' : me.cliente.id,
                    'fecha' : me.fecha,
                    'fotosviejas' : me.fotosviejas,
                    'fotosnuevas' : me.fotosnuevas

                }).then(function (response) {

                    me.cerrarModal();
                    me.listarActividadTecnica(1, '', 'fecha');

                    Swal.fire({
                            
                        position: 'top-end',
                        icon: 'success',
                        title: 'ACTIVIDAD TÉCNICA ACTUALIZADA',
                        showConfirmButton: false,
                        timer: 1500

                    });

                }).catch(function (error) {

                    console.log(error);

                });

            },

            actualizarHomologacion(){

                if(this.validarEdicion('HOMOLOGACION')){
                    return;
                }

                let me = this;

                axios.put('/homologaciones/actualizar', {

                    'id_homologacion' : me.homologacion.id,
                    'placa' : me.homologacion.placa,
                    'id_dispositivo' : me.homologacion.id_dispositivo,
                    'lugar' : me.homologacion.lugar,
                    'posicion' : me.homologacion.posicion,
                    'panico' : me.homologacion.panico,
                    'cortemotor' : me.homologacion.cortemotor,
                    'otros' : me.homologacion.otros,
                    'observacion' : me.homologacion.observacion,
                    'id_actividadtecnica' : me.homologacion.id_actividadtecnica,
                    'id_tecnico' : me.tecnico.id,
                    'id_cliente' : me.cliente.id,
                    'fecha' : me.fecha,
                    'fotosviejas' : me.fotosviejas,
                    'fotosnuevas' : me.fotosnuevas

                }).then(function (response) {

                    me.cerrarModal();
                    me.listarActividadTecnica(1, '', 'fecha');

                    Swal.fire({
                            
                        position: 'top-end',
                        icon: 'success',
                        title: 'ACTIVIDAD TÉCNICA ACTUALIZADA',
                        showConfirmButton: false,
                        timer: 1500

                    });

                }).catch(function (error) {

                    console.log(error);

                });

            },

            actualizarReinstalacion(){

                if(this.validarEdicion('REINSTALACION')){
                    return;
                }

                let me = this;

                axios.put('/reinstalaciones/actualizar', {

                    'id_reinstalacion' : me.reinstalacion.id,
                    'placa' : me.reinstalacion.placa,
                    'nombre' : me.reinstalacion.nombre,
                    'id_dispositivo' : me.reinstalacion.id_dispositivo,
                    'lugar' : me.reinstalacion.lugar,
                    'posicion' : me.reinstalacion.posicion,
                    'panico' : me.reinstalacion.panico,
                    'cortemotor' : me.reinstalacion.cortemotor,
                    'otros' : me.reinstalacion.otros,
                    'observacion' : me.reinstalacion.observacion,
                    'id_actividadtecnica' : me.reinstalacion.id_actividadtecnica,
                    'id_tecnico' : me.tecnico.id,
                    'id_cliente' : me.cliente.id,
                    'fecha' : me.fecha,
                    'fotosviejas' : me.fotosviejas,
                    'fotosnuevas' : me.fotosnuevas

                }).then(function (response) {

                    me.cerrarModal();
                    me.listarActividadTecnica(1, '', 'fecha');

                    Swal.fire({
                            
                        position: 'top-end',
                        icon: 'success',
                        title: 'ACTIVIDAD TÉCNICA ACTUALIZADA',
                        showConfirmButton: false,
                        timer: 1500

                    });

                }).catch(function (error) {

                    console.log(error);

                });

            },

            validarEdicion(accion){

                switch (accion) {

                    case 'INSTALACION':
                        {
                            this.errorInstalacion = 0;
                            this.errorMostrarMsjInstalacion = [];

                            if(!this.cliente.id) this.errorMostrarMsjInstalacion.push("DEBE SELECCIONAR UN CLIENTE.");
                            if(!this.tecnico.id) this.errorMostrarMsjInstalacion.push("DEBE SELECCIONAR UN TÉCNICO.");
                            if(!this.fecha) this.errorMostrarMsjInstalacion.push("DEBE INGRESAR UNA FECHA.");
                            if(!this.instalacion.id_dispositivo) this.errorMostrarMsjInstalacion.push("DEBE INGRESAR UN NOMBRE AL DISPOSITIVO.");
                            if(!this.instalacion.placa) this.errorMostrarMsjInstalacion.push("DEBE SELECCIONAR UNA PLACA.");
                            if(!this.instalacion.gps.id) this.errorMostrarMsjInstalacion.push("DEBE SELECCIONAR EL GPS VIEJO.");
                            if(!this.instalacion.simcard.id) this.errorMostrarMsjInstalacion.push("DEBE SELECCIONAR UNA SIM NUEVA.");
                            if(!this.instalacion.lugar) this.errorMostrarMsjInstalacion.push("DEBE INGRESAR UN LUGAR.");

                            if(this.errorMostrarMsjInstalacion.length){
                                this.errorInstalacion = 1;
                            }

                            return this.errorInstalacion;

                            break;
                        }

                    case 'REVISION':
                        {
                            this.errorRevision = 0;
                            this.errorMostrarMsjRevision = [];

                            if(!this.cliente.id) this.errorMostrarMsjRevision.push("DEBE SELECCIONAR UN CLIENTE.");
                            if(!this.tecnico.id) this.errorMostrarMsjRevision.push("DEBE SELECCIONAR UN TÉCNICO.");
                            if(!this.fecha) this.errorMostrarMsjRevision.push("DEBE INGRESAR UNA FECHA.");
                            if(!this.revision.nombre) this.errorMostrarMsjRevision.push("DEBE INGRESAR UN NOMBRE AL VEHÍCULO.");
                            if(!this.revision.placa) this.errorMostrarMsjRevision.push("DEBE SELECCIONAR UNA PLACA.");
                            if(!this.revision.lugar) this.errorMostrarMsjRevision.push("DEBE INGRESAR UN LUGAR.");

                            if(this.errorMostrarMsjRevision.length){
                                this.errorRevision = 1;
                            }

                            return this.errorRevision;

                            break;
                        }

                    case 'CAMBIO DE SIM':
                        {
                            this.errorCambioSim = 0;
                            this.errorMostrarMsjCambioSim = [];

                            if(!this.cliente.id) this.errorMostrarMsjCambioSim.push("DEBE SELECCIONAR UN CLIENTE.");
                            if(!this.tecnico.id) this.errorMostrarMsjCambioSim.push("DEBE SELECCIONAR UN TÉCNICO.");
                            if(!this.fecha) this.errorMostrarMsjCambioSim.push("DEBE INGRESAR UNA FECHA.");
                            if(!this.cambiosim.nombre) this.errorMostrarMsjCambioSim.push("DEBE INGRESAR UN NOMBRE AL VEHÍCULO.");
                            if(!this.cambiosim.placa) this.errorMostrarMsjCambioSim.push("DEBE SELECCIONAR UNA PLACA.");
                            if(!this.cambiosim.simcard_viejo.id) this.errorMostrarMsjCambioSim.push("DEBE SELECCIONAR UNA SIM ANTERIOR.");
                            if(!this.cambiosim.simcard_nuevo.id) this.errorMostrarMsjCambioSim.push("DEBE SELECCIONAR UNA SIM NUEVA.");
                            if(!this.cambiosim.lugar) this.errorMostrarMsjCambioSim.push("DEBE INGRESAR UN LUGAR.");

                            if(this.errorMostrarMsjCambioSim.length){
                                this.errorCambioSim = 1;
                            }

                            return this.errorCambioSim;

                            break;
                        }

                    case 'CAMBIO DE GPS':
                        {
                            this.errorCambioGps = 0;
                            this.errorMostrarMsjCambioGps = [];

                            if(!this.cliente.id) this.errorMostrarMsjCambioGps.push("DEBE SELECCIONAR UN CLIENTE.");
                            if(!this.tecnico.id) this.errorMostrarMsjCambioGps.push("DEBE SELECCIONAR UN TÉCNICO.");
                            if(!this.fecha) this.errorMostrarMsjCambioGps.push("DEBE INGRESAR UNA FECHA.");
                            if(!this.cambiogps.nombre) this.errorMostrarMsjCambioGps.push("DEBE INGRESAR UN NOMBRE AL VEHÍCULO.");
                            if(!this.cambiogps.placa) this.errorMostrarMsjCambioGps.push("DEBE SELECCIONAR UNA PLACA.");
                            if(!this.cambiogps.id_dispositivo_viejo) this.errorMostrarMsjCambioGps.push("DEBE INGRESAR EL ID DEL DISPOSITIVO ANTERIOR.");
                            if(!this.cambiogps.id_dispositivo_nuevo) this.errorMostrarMsjCambioGps.push("DEBE INGRESAR EL ID DEL DISPOSITIVO NUEVO.");
                            if(!this.cambiogps.gps_viejo.id) this.errorMostrarMsjCambioGps.push("DEBE SELECCIONAR EL GPS ANTERIOR.");
                            if(!this.cambiogps.gps_nuevo.id) this.errorMostrarMsjCambioGps.push("DEBE SELECCIONAR EL GPS NUEVO.");
                            if(!this.cambiogps.simcard_nuevo.id) this.errorMostrarMsjCambioGps.push("DEBE SELECCIONAR UNA SIM NUEVA.");
                            if(!this.cambiogps.lugar) this.errorMostrarMsjCambioGps.push("DEBE INGRESAR UN LUGAR.");

                            if(this.errorMostrarMsjCambioGps.length){
                                this.errorCambioGps = 1;
                            }

                            return this.errorCambioGps;

                            break;
                        }

                    case 'TRASLADO DE GPS':
                        {
                            this.errorTrasladoGps = 0;
                            this.errorMostrarMsjTrasladoGps = [];

                            if(!this.cliente.id) this.errorMostrarMsjTrasladoGps.push("DEBE SELECCIONAR UN CLIENTE.");
                            if(!this.tecnico.id) this.errorMostrarMsjTrasladoGps.push("DEBE SELECCIONAR UN TÉCNICO.");
                            if(!this.fecha) this.errorMostrarMsjTrasladoGps.push("DEBE INGRESAR UNA FECHA.");
                            if(!this.trasladogps.placa_anterior) this.errorMostrarMsjTrasladoGps.push("DEBE SELECCIONAR LA PLACA ANTERIOR.");
                            if(!this.trasladogps.placa_nueva) this.errorMostrarMsjTrasladoGps.push("DEBE INGRESAR LA PLACA NUEVA.");
                            if(!this.trasladogps.lugar) this.errorMostrarMsjTrasladoGps.push("DEBE INGRESAR UN LUGAR.");

                            if(this.errorMostrarMsjTrasladoGps.length){
                                this.errorTrasladoGps = 1;
                            }

                            return this.errorTrasladoGps;

                            break;
                        }

                    case 'DESINSTALACION':
                        {
                            this.errorDesinstalacion = 0;
                            this.errorMostrarMsjDesinstalacion = [];

                            if(!this.cliente.id) this.errorMostrarMsjDesinstalacion.push("DEBE SELECCIONAR UN CLIENTE.");
                            if(!this.tecnico.id) this.errorMostrarMsjDesinstalacion.push("DEBE SELECCIONAR UN TÉCNICO.");
                            if(!this.fecha) this.errorMostrarMsjDesinstalacion.push("DEBE INGRESAR UNA FECHA.");
                            if(!this.desinstalacion.placa) this.errorMostrarMsjDesinstalacion.push("DEBE SELECCIONAR UNA PLACA.");
                            if(!this.desinstalacion.nombre) this.errorMostrarMsjDesinstalacion.push("DEBE INGRESAR UN NOMBRE AL VEHÍCULO.");
                            if(!this.desinstalacion.id_dispositivo) this.errorMostrarMsjDesinstalacion.push("DEBE INGRESAR UN NOMBRE AL DISPOSITIVO.");
                            if(!this.desinstalacion.lugar) this.errorMostrarMsjDesinstalacion.push("DEBE INGRESAR UN LUGAR.");

                            if(this.errorMostrarMsjDesinstalacion.length){
                                this.errorDesinstalacion = 1;
                            }

                            return this.errorDesinstalacion;

                            break;
                        }

                    case 'HOMOLOGACION':
                        {
                            this.errorHomologacion = 0;
                            this.errorMostrarMsjHomologacion = [];

                            if(!this.cliente.id) this.errorMostrarMsjHomologacion.push("DEBE SELECCIONAR UN CLIENTE.");
                            if(!this.tecnico.id) this.errorMostrarMsjHomologacion.push("DEBE SELECCIONAR UN TÉCNICO.");
                            if(!this.fecha) this.errorMostrarMsjHomologacion.push("DEBE INGRESAR UNA FECHA.");
                            if(!this.homologacion.placa) this.errorMostrarMsjHomologacion.push("DEBE INGRESAR UNA PLACA.");
                            if(!this.homologacion.id_dispositivo) this.errorMostrarMsjHomologacion.push("DEBE INGRESAR ID DEL DISPOSITIVO.");
                            if(!this.homologacion.lugar) this.errorMostrarMsjHomologacion.push("DEBE INGRESAR UN LUGAR.");

                            if(this.errorMostrarMsjHomologacion.length){
                                this.errorHomologacion = 1;
                            }

                            return this.errorHomologacion;

                            break;
                        }

                    case 'REINSTALACION':
                        {
                            this.errorReinstalacion = 0;
                            this.errorMostrarMsjReinstalacion = [];

                            if(!this.cliente.id) this.errorMostrarMsjReinstalacion.push("DEBE SELECCIONAR UN CLIENTE.");
                            if(!this.tecnico.id) this.errorMostrarMsjReinstalacion.push("DEBE SELECCIONAR UN TÉCNICO.");
                            if(!this.fecha) this.errorMostrarMsjReinstalacion.push("DEBE INGRESAR UNA FECHA.");
                            if(!this.reinstalacion.placa) this.errorMostrarMsjReinstalacion.push("DEBE INGRESAR UNA PLACA.");
                            if(!this.reinstalacion.nombre) this.errorMostrarMsjReinstalacion.push("DEBE INGRESAR UNA NOMBRE.");
                            if(!this.reinstalacion.id_dispositivo) this.errorMostrarMsjReinstalacion.push("DEBE INGRESAR ID DEL DISPOSITIVO.");
                            if(!this.reinstalacion.lugar) this.errorMostrarMsjReinstalacion.push("DEBE INGRESAR UN LUGAR.");

                            if(this.errorMostrarMsjReinstalacion.length){
                                this.errorReinstalacion = 1;
                            }

                            return this.errorReinstalacion;

                            break;
                        }

                }                

            },

            abrirModal(accion, data = []){

                let me = this;

                switch (data['nombre']) {

                    case 'INSTALACION':
                        {
                            var url = '/instalaciones/mostrar/' + data['id'];
                                
                            axios.get(url).then(function (response) {

                                var respuesta = response.data.instalacion;

                                me.modal = 1;
                                me.tituloModal = 'INSTALACIÓN NUEVA';

                                me.cliente_id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.nombre = respuesta.actividad_tecnica.cliente.nombre;

                                me.fecha = respuesta.actividad_tecnica.fecha;

                                me.tecnico_id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.nombre = respuesta.actividad_tecnica.tecnico.nombre + ' ' + respuesta.actividad_tecnica.tecnico.apellido;

                                me.instalacion.id = respuesta.id;
                                me.instalacion.id_actividadtecnica = respuesta.id_actividadtecnica;
                                me.instalacion.placa = respuesta.placa;
                                me.instalacion.id_dispositivo = respuesta.id_dispositivo;
                                me.instalacion.lugar = respuesta.lugar;
                                me.instalacion.posicion = respuesta.posicion;
                                me.instalacion.panico = respuesta.panico;
                                me.instalacion.cortemotor = respuesta.cortemotor;
                                me.instalacion.otros = respuesta.otros;
                                me.instalacion.observacion = respuesta.observacion;

                                me.instalacion.gps.id = respuesta.gps.id;
                                me.instalacion.gps.imei = respuesta.gps.imei;
                                me.instalacion.gps.serie = respuesta.gps.serie;
                                me.instalacion.gps.marca = respuesta.gps.marca;
                                me.instalacion.gps.modelo = respuesta.gps.modelo;

                                me.instalacion.simcard.id = respuesta.simcard.id;
                                me.instalacion.simcard.sim = respuesta.simcard.imsi;
                                me.instalacion.simcard.ip = respuesta.simcard.ip;
                                me.instalacion.simcard.telefono = respuesta.simcard.telefono;

                                me.fotosviejas = respuesta.fotos;

                                console.log(response);

                            }).catch(function (error) {
                                
                                console.log(error);

                            });

                            switch (accion) { 

                                case 'ver':
                                    {
                                        me.vermodal = 1;
                                        me.formodal = 0;
                                        me.tipoAccion = 1;
                                        break;

                                    }

                                case 'editar':
                                    {
                                        me.vermodal = 0;
                                        me.formodal = 1;
                                        me.tipoAccion = 1;
                                        break;
                                    }

                            }

                            break;

                        }

                    case 'REVISION':
                        {
                            var url = '/revisiones/mostrar/' + data['id'];
                                
                            axios.get(url).then(function (response) {

                                var respuesta = response.data.revision;

                                me.modal = 1;
                                me.tituloModal = 'REVISION';

                                me.cliente_id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.nombre = respuesta.actividad_tecnica.cliente.nombre;

                                me.fecha = respuesta.actividad_tecnica.fecha;

                                me.tecnico_id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.nombre = respuesta.actividad_tecnica.tecnico.nombre + ' ' + respuesta.actividad_tecnica.tecnico.apellido;

                                me.revision.id = respuesta.id;
                                me.revision.id_actividadtecnica = respuesta.id_actividadtecnica;
                                me.revision.placa = respuesta.placa;
                                me.revision.nombre = respuesta.nombre;
                                me.revision.lugar = respuesta.lugar;
                                me.revision.posicion = respuesta.posicion;
                                me.revision.panico = respuesta.panico;
                                me.revision.cortemotor = respuesta.cortemotor;
                                me.revision.otros = respuesta.otros;
                                me.revision.observacion = respuesta.observacion;

                                me.fotosviejas = respuesta.fotos;

                                console.log(response);

                            }).catch(function (error) {
                                
                                console.log(error);

                            });

                            switch (accion) { 

                                case 'ver':
                                    {
                                        me.vermodal = 2;
                                        me.formodal = 0;
                                        me.tipoAccion = 1;
                                        break;

                                    }

                                case 'editar':
                                    {
                                        me.vermodal = 0;
                                        me.formodal = 2;
                                        me.tipoAccion = 1;
                                        break;
                                    }

                            }

                            break;
                        }

                    case 'CAMBIO DE SIM':
                        {
                            var url = '/cambiosimcards/mostrar/' + data['id'];
                                
                            axios.get(url).then(function (response) {

                                var respuesta = response.data.cambiosim;

                                me.modal = 1;
                                me.tituloModal = 'CAMBIO DE SIM';

                                me.cliente_id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.nombre = respuesta.actividad_tecnica.cliente.nombre;

                                me.fecha = respuesta.actividad_tecnica.fecha;

                                me.tecnico_id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.nombre = respuesta.actividad_tecnica.tecnico.nombre + ' ' + respuesta.actividad_tecnica.tecnico.apellido;

                                me.cambiosim.id = respuesta.id;
                                me.cambiosim.id_actividadtecnica = respuesta.id_actividadtecnica;
                                me.cambiosim.placa = respuesta.placa;
                                me.cambiosim.nombre = respuesta.nombre;
                                me.cambiosim.lugar = respuesta.lugar;
                                me.cambiosim.posicion = respuesta.posicion;
                                me.cambiosim.panico = respuesta.panico;
                                me.cambiosim.cortemotor = respuesta.cortemotor;
                                me.cambiosim.otros = respuesta.otros;
                                me.cambiosim.observacion = respuesta.observacion;

                                me.cambiosim.simcard_viejo.id = respuesta.simcard_viejo.id;
                                me.cambiosim.simcard_viejo.sim = respuesta.simcard_viejo.imsi;
                                me.cambiosim.simcard_viejo.ip = respuesta.simcard_viejo.ip;
                                me.cambiosim.simcard_viejo.telefono = respuesta.simcard_viejo.telefono;

                                me.cambiosim.simcard_nuevo.id = respuesta.simcard_nuevo.id;
                                me.cambiosim.simcard_nuevo.sim = respuesta.simcard_nuevo.imsi;
                                me.cambiosim.simcard_nuevo.ip = respuesta.simcard_nuevo.ip;
                                me.cambiosim.simcard_nuevo.telefono = respuesta.simcard_nuevo.telefono;

                                me.fotosviejas = respuesta.fotos;

                                console.log(response);

                            }).catch(function (error) {
                                
                                console.log(error);

                            });

                            switch (accion) { 

                                case 'ver':
                                    {
                                        me.vermodal = 3;
                                        me.formodal = 0;
                                        me.tipoAccion = 1;
                                        break;

                                    }

                                case 'editar':
                                    {
                                        me.vermodal = 0;
                                        me.formodal = 3;
                                        me.tipoAccion = 1;
                                        break;
                                    }

                            }

                            break;

                        }

                    case 'CAMBIO DE GPS':
                        {
                            var url = '/cambiogps/mostrar/' + data['id'];
                                
                            axios.get(url).then(function (response) {

                                var respuesta = response.data.cambiogps;

                                me.modal = 1;
                                me.tituloModal = 'CAMBIO DE GPS';

                                me.cliente_id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.nombre = respuesta.actividad_tecnica.cliente.nombre;

                                me.fecha = respuesta.actividad_tecnica.fecha;

                                me.tecnico_id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.nombre = respuesta.actividad_tecnica.tecnico.nombre + ' ' + respuesta.actividad_tecnica.tecnico.apellido;

                                me.cambiogps.id = respuesta.id;
                                me.cambiogps.id_actividadtecnica = respuesta.id_actividadtecnica;
                                me.cambiogps.placa = respuesta.placa;
                                me.cambiogps.nombre = respuesta.nombre;
                                me.cambiogps.id_dispositivo_viejo = respuesta.id_dispositivo_viejo;
                                me.cambiogps.id_dispositivo_nuevo = respuesta.id_dispositivo_nuevo;
                                me.cambiogps.lugar = respuesta.lugar;
                                me.cambiogps.posicion = respuesta.posicion;
                                me.cambiogps.panico = respuesta.panico;
                                me.cambiogps.cortemotor = respuesta.cortemotor;
                                me.cambiogps.otros = respuesta.otros;
                                me.cambiogps.observacion = respuesta.observacion;

                                me.cambiogps.gps_viejo.id = respuesta.gps_viejo.id;
                                me.cambiogps.gps_viejo.imei = respuesta.gps_viejo.imei;
                                me.cambiogps.gps_viejo.serie = respuesta.gps_viejo.serie;
                                me.cambiogps.gps_viejo.marca = respuesta.gps_viejo.marca;
                                me.cambiogps.gps_viejo.modelo = respuesta.gps_viejo.modelo;

                                me.cambiogps.gps_nuevo.id = respuesta.gps_nuevo.id;
                                me.cambiogps.gps_nuevo.imei = respuesta.gps_nuevo.imei;
                                me.cambiogps.gps_nuevo.serie = respuesta.gps_nuevo.serie;
                                me.cambiogps.gps_nuevo.marca = respuesta.gps_nuevo.marca;
                                me.cambiogps.gps_nuevo.modelo = respuesta.gps_nuevo.modelo;

                                me.cambiogps.simcard_nuevo.id = respuesta.simcard_nuevo.id;
                                me.cambiogps.simcard_nuevo.sim = respuesta.simcard_nuevo.imsi;
                                me.cambiogps.simcard_nuevo.ip = respuesta.simcard_nuevo.ip;
                                me.cambiogps.simcard_nuevo.telefono = respuesta.simcard_nuevo.telefono;

                                me.fotosviejas = respuesta.fotos;

                                console.log(response);

                            }).catch(function (error) {
                                
                                console.log(error);

                            });

                            switch (accion) { 

                                case 'ver':
                                    {
                                        me.vermodal = 4;
                                        me.formodal = 0;
                                        me.tipoAccion = 1;
                                        break;

                                    }

                                case 'editar':
                                    {
                                        me.vermodal = 0;
                                        me.formodal = 4;
                                        me.tipoAccion = 1;
                                        break;
                                    }

                            }

                            break;

                        }

                    case 'TRASLADO DE GPS':
                        {
                            var url = '/trasladosgps/mostrar/' + data['id'];
                                
                            axios.get(url).then(function (response) {

                                var respuesta = response.data.trasladogps;

                                me.modal = 1;
                                me.tituloModal = 'TRASLADO DE GPS';

                                me.cliente_id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.nombre = respuesta.actividad_tecnica.cliente.nombre;

                                me.fecha = respuesta.actividad_tecnica.fecha;

                                me.tecnico_id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.nombre = respuesta.actividad_tecnica.tecnico.nombre + ' ' + respuesta.actividad_tecnica.tecnico.apellido;

                                me.trasladogps.id = respuesta.id;
                                me.trasladogps.id_actividadtecnica = respuesta.id_actividadtecnica;
                                me.trasladogps.placa_anterior = respuesta.placa_anterior;
                                me.trasladogps.placa_nueva = respuesta.placa_nueva;
                                me.trasladogps.lugar = respuesta.lugar;
                                me.trasladogps.posicion = respuesta.posicion;
                                me.trasladogps.panico = respuesta.panico;
                                me.trasladogps.cortemotor = respuesta.cortemotor;
                                me.trasladogps.otros = respuesta.otros;
                                me.trasladogps.observacion = respuesta.observacion;

                                me.fotosviejas = respuesta.fotos;

                                console.log(response);

                            }).catch(function (error) {
                                
                                console.log(error);

                            });

                            switch (accion) { 

                                case 'ver':
                                    {
                                        me.vermodal = 5;
                                        me.formodal = 0;
                                        me.tipoAccion = 1;
                                        break;

                                    }

                                case 'editar':
                                    {
                                        me.vermodal = 0;
                                        me.formodal = 5;
                                        me.tipoAccion = 1;
                                        break;
                                    }

                            }

                            break;

                        }

                    case 'DESINSTALACION':
                        {
                            var url = '/desinstalaciones/mostrar/' + data['id'];
                                
                            axios.get(url).then(function (response) {

                                var respuesta = response.data.desinstalacion;

                                me.modal = 1;
                                me.tituloModal = 'DESINSTALACIÓN';

                                me.cliente_id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.nombre = respuesta.actividad_tecnica.cliente.nombre;

                                me.fecha = respuesta.actividad_tecnica.fecha;

                                me.tecnico_id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.nombre = respuesta.actividad_tecnica.tecnico.nombre + ' ' + respuesta.actividad_tecnica.tecnico.apellido;

                                me.desinstalacion.id = respuesta.id;
                                me.desinstalacion.id_actividadtecnica = respuesta.id_actividadtecnica;
                                me.desinstalacion.placa = respuesta.placa;
                                me.desinstalacion.id_dispositivo = respuesta.id_dispositivo;
                                me.desinstalacion.nombre = respuesta.nombre;
                                me.desinstalacion.lugar = respuesta.lugar;
                                me.desinstalacion.otros = respuesta.otros;
                                me.desinstalacion.observacion = respuesta.observacion;

                                me.fotosviejas = respuesta.fotos;

                                console.log(response);

                            }).catch(function (error) {
                                
                                console.log(error);

                            });

                            switch (accion) { 

                                case 'ver':
                                    {
                                        me.vermodal = 6;
                                        me.formodal = 0;
                                        me.tipoAccion = 1;
                                        break;

                                    }

                                case 'editar':
                                    {
                                        me.vermodal = 0;
                                        me.formodal = 6;
                                        me.tipoAccion = 1;
                                        break;
                                    }

                            }

                            break;
                        }

                    case 'HOMOLOGACION':
                        {
                            var url = '/homologaciones/mostrar/' + data['id'];
                                
                            axios.get(url).then(function (response) {

                                var respuesta = response.data.homologacion;

                                me.modal = 1;
                                me.tituloModal = 'HOMOLOGACIÓN';

                                me.cliente_id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.nombre = respuesta.actividad_tecnica.cliente.nombre;

                                me.fecha = respuesta.actividad_tecnica.fecha;

                                me.tecnico_id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.nombre = respuesta.actividad_tecnica.tecnico.nombre + ' ' + respuesta.actividad_tecnica.tecnico.apellido;

                                me.homologacion.id = respuesta.id;
                                me.homologacion.id_actividadtecnica = respuesta.id_actividadtecnica;
                                me.homologacion.placa = respuesta.placa;
                                me.homologacion.id_dispositivo = respuesta.id_dispositivo;
                                me.homologacion.lugar = respuesta.lugar;
                                me.homologacion.posicion = respuesta.posicion;
                                me.homologacion.panico = respuesta.panico;
                                me.homologacion.cortemotor = respuesta.cortemotor;
                                me.homologacion.otros = respuesta.otros;
                                me.homologacion.observacion = respuesta.observacion;

                                me.fotosviejas = respuesta.fotos;

                                console.log(response);

                            }).catch(function (error) {
                                
                                console.log(error);

                            });

                            switch (accion) { 

                                case 'ver':
                                    {
                                        me.vermodal = 7;
                                        me.formodal = 0;
                                        me.tipoAccion = 1;
                                        break;

                                    }

                                case 'editar':
                                    {
                                        me.vermodal = 0;
                                        me.formodal = 7;
                                        me.tipoAccion = 1;
                                        break;
                                    }

                            }

                            break;
                        }

                    case 'REINSTALACION':
                        {
                            var url = '/reinstalaciones/mostrar/' + data['id'];
                                
                            axios.get(url).then(function (response) {

                                var respuesta = response.data.reinstalacion;

                                me.modal = 1;
                                me.tituloModal = 'REINSTALACIÓN';

                                me.cliente_id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.id = respuesta.actividad_tecnica.cliente.id;
                                me.cliente.nombre = respuesta.actividad_tecnica.cliente.nombre;

                                me.fecha = respuesta.actividad_tecnica.fecha;

                                me.tecnico_id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.id = respuesta.actividad_tecnica.tecnico.id;
                                me.tecnico.nombre = respuesta.actividad_tecnica.tecnico.nombre + ' ' + respuesta.actividad_tecnica.tecnico.apellido;

                                me.reinstalacion.id = respuesta.id;
                                me.reinstalacion.id_actividadtecnica = respuesta.id_actividadtecnica;
                                me.reinstalacion.placa = respuesta.placa;
                                me.reinstalacion.id_dispositivo = respuesta.id_dispositivo;
                                me.reinstalacion.nombre = respuesta.nombre;
                                me.reinstalacion.lugar = respuesta.lugar;
                                me.reinstalacion.posicion = respuesta.posicion;
                                me.reinstalacion.panico = respuesta.panico;
                                me.reinstalacion.cortemotor = respuesta.cortemotor;
                                me.reinstalacion.otros = respuesta.otros;
                                me.reinstalacion.observacion = respuesta.observacion;

                                me.fotosviejas = respuesta.fotos;

                                console.log(response);

                            }).catch(function (error) {
                                
                                console.log(error);

                            });

                            switch (accion) { 

                                case 'ver':
                                    {
                                        me.vermodal = 8;
                                        me.formodal = 0;
                                        me.tipoAccion = 1;
                                        break;

                                    }

                                case 'editar':
                                    {
                                        me.vermodal = 0;
                                        me.formodal = 8;
                                        me.tipoAccion = 1;
                                        break;
                                    }

                            }

                            break;
                        }

                }
            },

            cerrarModal(){

                let me = this;

                me.modal = 0;
                me.tipoAccion = 0;
                me.formodal = 0;
                me.vermodal = 0;
                me.tituloModal = '';
                me.instalacion = {
                    id : 0,
                    id_actividadtecnica : 0,
                    placa : '',
                    id_dispositivo : '',
                    gps : {
                        id : 0,
                        imei : '',
                        serie : '',
                        marca : '',
                        modelo : '',
                    },
                    simcard : {
                        id : 0,
                        sim : '',
                        ip : '',
                        telefono : ''
                    },
                    arrayGps : [],
                    arraySim : [],
                    lugar : '',
                    posicion : false,
                    panico : false,
                    cortemotor : false,
                    otros : '',
                    observacion : '',
                };
                me.revision = {
                    id : 0,
                    id_actividadtecnica : 0,
                    placa : '',
                    nombre : '',
                    lugar : '',
                    posicion : false,
                    panico : false,
                    cortemotor : false,
                    otros : '',
                    observacion : '',
                    arrayVehiculo : []
                };
                me.cambiogps = {
                    id : 0,
                    id_actividadtecnica : 0,
                    placa : '',
                    nombre : '',
                    lugar : '',
                    posicion : false,
                    panico : false,
                    cortemotor : false,
                    otros : '',
                    observacion : '',
                    arrayVehiculo : [],
                    arrayGps : [],
                    arraSim : [],
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
                        id: 0,
                        sim : '',
                        ip : '',
                        telefono : ''
                    }

                };
                me.trasladogps = {
                    id : 0,
                    id_actividadtecnica : 0,
                    nombre : '',
                    placa_anterior : '',
                    placa_nueva : '',
                    lugar : '',
                    posicion : false,
                    panico : false,
                    cortemotor : false,
                    otros : '',
                    observacion : '',
                    arrayVehiculo : [],
                };
                me.desinstalacion = {
                    id : 0,
                    id_actividadtecnica : 0,
                    placa : '',
                    id_dispositivo : '',
                    nombre : '',
                    lugar : '',
                    otros : '',
                    observacion : '',
                };
                me.homologacion = {
                    id : 0,
                    id_actividadtecnica : 0,
                    placa : '',
                    id_dispositivo : '',
                    lugar : '',
                    posicion : false,
                    panico : false,
                    cortemotor : false,
                    otros : '',
                    observacion : '',
                    arrayVehiculo : []
                };
                me.cliente_id = 0;
                me.arrayCliente = [];
                me.cliente = {
                    id : 0,
                    nombre : ''
                };
                me.tecnico_id = 0;
                me.arrayTecnico = [];
                me.tecnico = {
                    id : 0,
                    nombre : ''
                };
                me.fecha = '';
                me.errorInstalacion = 0;
                me.errorMostrarMsjInstalacion = [];
                me.errorRevision = 0;
                me.errorMostrarMsjRevision = [];
                me.errorCambioSim = 0;
                me.errorMostrarMsjCambioSim = [];
                me.errorCambioGps = 0;
                me.errorMostrarMsjCambioGps = [];
                me.errorTrasladoGps = 0;
                me.errorMostrarMsjTrasladoGps = [];
                me.errorDesinstalacion = 0;
                me.errorMostrarMsjDesinstalacion = [];
                me.errorHomologacion = 0;
                me.errorMostrarMsjHomologacion = [];
                me.fotosviejas = [];
                me.fotosnuevas = [];
                
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
                    me.cliente.id = 0;
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

            selectGps(search, loading){

                // Buscar las sims que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/gps/selectGps?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.instalacion.arrayGps = respuesta.gps;
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
                    me.instalacion.gps.id = val1.id;
                    let arregloimei = val1.imei.split(',', 2);
                    me.instalacion.gps.imei = arregloimei[0];
                    me.instalacion.gps.serie = val1.serie;
                    me.instalacion.gps.marca = val1.marca;
                    me.instalacion.gps.modelo = val1.modelo;

                }else{
                    me.instalacion.gps.id = 0;
                    me.instalacion.gps.imei = '';
                    me.instalacion.gps.serie = '';
                    me.instalacion.gps.marca = '';
                    me.instalacion.gps.modelo = '';
                }

            },

            selectGpsViejoCambioGps(search, loading){

                // Buscar las sims que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/gps/selectGps?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.cambiogps.arrayGps = respuesta.gps;
                    loading(false);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            getDatosGpsViejoCambioGps(val1){

                // Asignar los datos del sim seleccionado a la data

                let me = this;
                me.loading = true;
               
                if(val1!==null){
                    me.cambiogps.gps_viejo.id = val1.id;
                    let arregloimei = val1.imei.split(',', 2);
                    me.cambiogps.gps_viejo.imei = arregloimei[0];
                    me.cambiogps.gps_viejo.serie = val1.serie;
                    me.cambiogps.gps_viejo.marca = val1.marca;
                    me.cambiogps.gps_viejo.modelo = val1.modelo;

                }else{
                    me.cambiogps.gps_viejo.id = 0;
                    me.cambiogps.gps_viejo.imei = '';
                    me.cambiogps.gps_viejo.serie = '';
                    me.cambiogps.gps_viejo.marca = '';
                    me.cambiogps.gps_viejo.modelo = '';
                }

            },

            selectGpsNuevoCambioGps(search, loading){

                // Buscar las sims que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/gps/selectGps?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.cambiogps.arrayGps = respuesta.gps;
                    loading(false);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            getDatosGpsNuevoCambioGps(val1){

                // Asignar los datos del sim seleccionado a la data

                let me = this;
                me.loading = true;
               
                if(val1!==null){
                    me.cambiogps.gps_nuevo.id = val1.id;
                    let arregloimei = val1.imei.split(',', 2);
                    me.cambiogps.gps_nuevo.imei = arregloimei[0];
                    me.cambiogps.gps_nuevo.serie = val1.serie;
                    me.cambiogps.gps_nuevo.marca = val1.marca;
                    me.cambiogps.gps_nuevo.modelo = val1.modelo;

                }else{
                    me.cambiogps.gps_nuevo.id = 0;
                    me.cambiogps.gps_nuevo.imei = '';
                    me.cambiogps.gps_nuevo.serie = '';
                    me.cambiogps.gps_nuevo.marca = '';
                    me.cambiogps.gps_nuevo.modelo = '';
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
                    me.instalacion.arraySim = respuesta.simcards;
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
                    me.instalacion.simcard.id = val1.id;
                    me.instalacion.simcard.sim = val1.imsi;
                    me.instalacion.simcard.ip = val1.ip;
                    me.instalacion.simcard.telefono = val1.telefono;
                }else{
                    me.instalacion.simcard.id = 0;
                    me.instalacion.simcard.sim = '';
                    me.instalacion.simcard.ip = '';
                    me.instalacion.simcard.telefono = '';
                }

            },

            selectSimNuevoCambioGps(search, loading){

                // Buscar las sims que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/simcards/selectSim?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.cambiogps.arraySim = respuesta.simcards;
                    loading(false);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            getDatosSimNuevoCambioGps(val1){

                // Asignar los datos del sim seleccionado a la data

                let me = this;
                me.loading = true;
               
                if(val1!==null){ 
                    me.cambiogps.simcard_nuevo.id = val1.id;
                    me.cambiogps.simcard_nuevo.sim = val1.imsi;
                    me.cambiogps.simcard_nuevo.ip = val1.ip;
                    me.cambiogps.simcard_nuevo.telefono = val1.telefono;
                }else{
                    me.cambiogps.simcard_nuevo.id = 0;
                    me.cambiogps.simcard_nuevo.sim = '';
                    me.cambiogps.simcard_nuevo.ip = '';
                    me.cambiogps.simcard_nuevo.telefono = '';
                }

            },

            selectSimViejoCambioSim(search, loading){

                // Buscar las sims que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/simcards/selectSim?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.cambiosim.arraySim = respuesta.simcards;
                    loading(false);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            getDatosSimViejoCambioSim(val1){

                // Asignar los datos del sim seleccionado a la data

                let me = this;
                me.loading = true;
               
                if(val1!==null){ 
                    me.cambiosim.simcard_viejo.id = val1.id;
                    me.cambiosim.simcard_viejo.sim = val1.imsi;
                    me.cambiosim.simcard_viejo.ip = val1.ip;
                    me.cambiosim.simcard_viejo.telefono = val1.telefono;
                }else{
                    me.cambiosim.simcard_viejo.id = 0;
                    me.cambiosim.simcard_viejo.sim = '';
                    me.cambiosim.simcard_viejo.ip = '';
                    me.cambiosim.simcard_viejo.telefono = '';
                }

            },

            selectSimNuevoCambioSim(search, loading){

                // Buscar las sims que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/simcards/selectSim?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.cambiosim.arraySim = respuesta.simcards;
                    loading(false);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            getDatosSimNuevoCambioSim(val1){

                // Asignar los datos del sim seleccionado a la data

                let me = this;
                me.loading = true;
               
                if(val1!==null){ 
                    me.cambiosim.simcard_nuevo.id = val1.id;
                    me.cambiosim.simcard_nuevo.sim = val1.imsi;
                    me.cambiosim.simcard_nuevo.ip = val1.ip;
                    me.cambiosim.simcard_nuevo.telefono = val1.telefono;
                }else{
                    me.cambiosim.simcard_nuevo.id = 0;
                    me.cambiosim.simcard_nuevo.sim = '';
                    me.cambiosim.simcard_nuevo.ip = '';
                    me.cambiosim.simcard_nuevo.telefono = '';
                }

            },

            selectVehiculo(search, loading){

                // Buscar los vehiculos que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/vehiculos/selectVehiculo?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.revision.arrayVehiculo = respuesta.vehiculos;
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
                    me.revision.placa = val1.placa;
                }else{
                    me.revision.placa = '';
                }

            },

            selectVehiculoCambioGps(search, loading){

                // Buscar los vehiculos que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/vehiculos/selectVehiculo?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.cambiogps.arrayVehiculo = respuesta.vehiculos;
                    loading(false);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            getDatosVehiculoCambioGps(val1){

                // Asignar los datos del vehiculo seleccionado a la data

                let me = this;
                me.loading = true;

                if(val1!==null){
                    me.cambiogps.placa = val1.placa;
                }else{
                    me.cambiogps.placa = '';
                }

            },

            selectVehiculoCambioSim(search, loading){

                // Buscar los vehiculos que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/vehiculos/selectVehiculo?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.cambiosim.arrayVehiculo = respuesta.vehiculos;
                    loading(false);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            getDatosVehiculoCambioSim(val1){

                // Asignar los datos del vehiculo seleccionado a la data

                let me = this;
                me.loading = true;

                if(val1!==null){
                    me.cambiosim.placa = val1.placa;
                }else{
                    me.cambiosim.placa = '';
                }

            },

            selectVehiculoViejoTrasladoGps(search, loading){

                // Buscar los vehiculos que coincidan con el campo search

                let me = this;
                loading(true);

                var url = '/vehiculos/selectVehiculo?filtro='+search;
                
                axios.get(url).then(function (response) {
                    
                    let respuesta = response.data;
                    q: search
                    me.trasladogps.arrayVehiculo = respuesta.vehiculos;
                    loading(false);

                })
                .catch(function (error) {
                    
                    console.log(error);

                })

            },

            getDatosVehiculoViejoTrasladoGps(val1){

                // Asignar los datos del vehiculo seleccionado a la data

                let me = this;
                me.loading = true;

                if(val1!==null){
                    me.trasladogps.placa_anterior = val1.placa;
                }else{
                    me.trasladogps.placa_anterior = '';
                }

            }

        },

        mounted() {

            this.listarActividadTecnica(1, this.buscar, this.criterio);

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