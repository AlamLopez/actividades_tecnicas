<table>
    <thead>
        <tr>
            <th>CLIENTE</th>
            <th>FECHA DE INSTALACION</th>
            <th>TECNICO</th>
            <th>PLACA</th>
            <th>ID DISPOSITIVO GPS</th>
            <th>IMEI</th>
            <th>SERIE</th>
            <th>MARCA</th>
            <th>MODELO</th>
            <th>SIM</th>
            <th>IP</th>
            <th>TELEFONO</th>
            <th>LUGAR</th>
            <th>CORTE DE MOTOR</th>
            <th>PANICO</th>
            <th>POSICION</th>
            <th>OTROS</th>
            <th>OBSERVACION</th>
        </tr>
    </thead>
    <tbody>
        @foreach($instalaciones as $instalacion)
            <tr>
                <td>{{ $instalacion->nombre }}</td>
                <td>{{ $instalacion->fecha }}</td>
                <td>{{ $instalacion->nombretecnico . ' ' . $instalacion->apellido }}</td>
                <td>{{ $instalacion->placa }}</td>
                <td>{{ $instalacion->id_dispositivo }}</td>
                <td>{{ $instalacion->imei }}</td>
                <td>{{ $instalacion->serie }}</td>
                <td>{{ $instalacion->marca }}</td>
                <td>{{ $instalacion->modelo }}</td>
                <td>{{ $instalacion->imsi }}</td>
                <td>{{ $instalacion->ip }}</td>
                <td>{{ $instalacion->telefono }}</td>
                <td>{{ $instalacion->lugar }}</td>
                @if($instalacion->cortemotor)
                    <td>SI</td>
                @else
                    <td>NO</td>
                @endif
                @if($instalacion->panico)
                    <td>SI</td>
                @else
                    <td>NO</td>
                @endif
                @if($instalacion->posicion)
                    <td>SI</td>
                @else
                    <td>NO</td>
                @endif
                <td>{{ $instalacion->otros }}</td>
                <td>{{ $instalacion->observacion }}</td>
            </tr>
        @endforeach
    </tbody>
</table>