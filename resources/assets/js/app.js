/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// filpes.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('principal', require('./components/acceso/Principal.vue').default);
Vue.component('tecnico', require('./components/acceso/Tecnico.vue').default);
Vue.component('rol', require('./components/acceso/Rol.vue').default);
Vue.component('usuario', require('./components/acceso/User.vue').default);
Vue.component('cliente', require('./components/atencion_cliente/Cliente.vue').default);
Vue.component('simcard', require('./components/matriculacion/SimCard.vue').default);
Vue.component('gps', require('./components/matriculacion/Gps.vue').default);
Vue.component('vehiculo', require('./components/matriculacion/Vehiculo.vue').default);
Vue.component('actividadtecnica', require('./components/actividad_tecnica/ActividadTecnica.vue').default);
Vue.component('instalacionnueva', require('./components/actividad_tecnica/InstalacionNueva.vue').default);
Vue.component('revision', require('./components/actividad_tecnica/Revision.vue').default);
Vue.component('cambiogps', require('./components/actividad_tecnica/CambioGps').default);
Vue.component('cambiosim', require('./components/actividad_tecnica/CambioSim.vue').default);
Vue.component('trasladogps', require('./components/actividad_tecnica/TrasladoGps.vue').default);
Vue.component('desinstalacion', require('./components/actividad_tecnica/Desinstalacion.vue').default);
Vue.component('homologacion', require('./components/actividad_tecnica/Homologacion.vue').default);
Vue.component('reinstalacion', require('./components/actividad_tecnica/Reinstalacion.vue').default);
Vue.component('listadoactividadtecnica', require('./components/actividad_tecnica/Listado.vue').default);
Vue.component('reporteactividadtecnica', require('./components/reporteria/ActividadTecnica.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data :{
        menu : 0
    }
});

