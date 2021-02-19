@extends('principal')

    @section('contenido')

        @if(Auth::check())

            @if(Auth::user()->idrol == 1)

                <template v-if="menu==0">
                    <principal></principal>
                </template>

                <template v-if="menu==13">
                    <cliente></cliente>
                </template>

                <template v-if="menu==14">
                    <simcard></simcard>
                </template>

                <template v-if="menu==15">
                    <gps></gps>
                </template>

                <keep-alive include="actividadtecnica">
                    <template v-if="menu==17">
                        <actividadtecnica></actividadtecnica>
                    </template>
                </keep-alive>
            
                <template v-if="menu==18">
                    <listadoactividadtecnica></listadoactividadtecnica>
                </template>

                <template v-if="menu==16">
                    <vehiculo></vehiculo>
                </template>
        
                <template v-if="menu==7">
                    <tecnico></tecnico>
                </template>
        
                <template v-if="menu==8">
                    <usuario></usuario>            
                </template>
        
                <template v-if="menu==9">
                    <rol></rol>
                </template>
        
                <template v-if="menu==10">
                    <reporteactividadtecnica></reporteactividadtecnica>
                </template>
        
                <template v-if="menu==11">
                    <h1>PDF</h1>
                </template>
        
                <template v-if="menu==12">
                    <h1>IT</h1>
                </template>

            @elseif(Auth::user()->idrol == 2)

                <template v-if="menu==13">
                    <cliente></cliente>
                </template>

                <template v-if="menu==14">
                    <simcard></simcard>
                </template>

                <template v-if="menu==15">
                    <gps></gps>
                </template>

                <keep-alive include="actividadtecnica">
                    <template v-if="menu==17">
                        <actividadtecnica></actividadtecnica>
                    </template>
                </keep-alive>

                <template v-if="menu==18">
                    <listadoactividadtecnica></listadoactividadtecnica>
                </template>

                <template v-if="menu==16">
                    <vehiculo></vehiculo>
                </template>

                <template v-if="menu==10">
                    <reporteactividadtecnica></reporteactividadtecnica>
                </template>
        
                <template v-if="menu==11">
                    <h1>PDF</h1>
                </template>
        
                <template v-if="menu==12">
                    <h1>IT</h1>
                </template>

            @elseif(Auth::user()->idrol == 3)

                <template v-if="menu==13">
                    <cliente></cliente>
                </template>

                <template v-if="menu==14">
                    <simcard></simcard>
                </template>

                <template v-if="menu==15">
                    <gps></gps>
                </template>

                <keep-alive include="actividadtecnica">
                    <template v-if="menu==17">
                        <actividadtecnica></actividadtecnica>
                    </template>
                </keep-alive>

                <template v-if="menu==18">
                    <listadoactividadtecnica></listadoactividadtecnica>
                </template>

                <template v-if="menu==16">
                    <vehiculo></vehiculo>
                </template>
        
                <template v-if="menu==7">
                    <tecnico></tecnico>
                </template>
        
                <template v-if="menu==10">
                    <reporteactividadtecnica></reporteactividadtecnica>
                </template>
        
                <template v-if="menu==11">
                    <h1>PDF</h1>
                </template>
        
                <template v-if="menu==12">
                    <h1>IT</h1>
                </template>

            @else

            @endif

        @endif
        
    @endsection