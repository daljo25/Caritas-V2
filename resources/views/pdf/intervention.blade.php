<!DOCTYPE html>
<html lang="es">

<head>
    
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <!-- Latest compiled and minified CSS -->

    <style>
        body {
            padding: 0;
            margin: 0;
            font-family: helvetica, sans-serif;
            font-size: 14px;
        }

        h2 {
            font-size: 18px;
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
        }
        thead {
            font-weight: bold;
            border: 1px solid #333;
            margin: 0;
            border-collapse: collapse;
        }

        td {
            border: 1px solid #333;
            margin: 0;
            border-collapse: collapse;

        }

        .noborder {
            border: none;
        }

        .text-justify {
            text-align: justify;
        }
        .text-center {
            text-align: center;
        }
        .bold {
            font-weight: bold;
        }
        .page-break {
            page-break-after: always;
        }
    </style>


</head>

<body>
    <div class="text-center"><h2>Hoja de Intervención</h2></div>
    <table>
        <tr>
            <td width="10%">Nº: {{ $record->id }}</td>
            <td width="10%">Exp: {{ $record->expedient }}</td>
            <td width="50%">Nombre: {{ $record->name }} </td>
            <td width="30%">Atención: {{ $record->Volunteer->name }} </td>
        </tr>
    </table><br>

    <table>
        <tr>
            <td>Fecha: {{ date("d/m/Y") }}</td>
            <td colspan="2">DNI/NIE/PAS: {{ $record->dni }}</td>
            <td>Caducidad: {{ \Carbon\Carbon::parse($record->expiration_date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Domicilio: {{ $record->address }}</td>
            <td colspan="2">Telf: {{ $record->phone }}</td>
            <td>Correo: {{ $record->email }}</td>
        </tr>
        <tr>
            <td>Fecha de Nacimiento: {{ \Carbon\Carbon::parse($record->birth_date)->format('d/m/Y') }}</td>
            <td>Edad: {{  \Carbon\Carbon::parse($record->birth_date)->age }}</td>
            <td>Nacionalidad: {{ $record->nationality }}</td>
            <td>Formacion: {{ $record->education }}</td>
        </tr>
    </table><br>

    <table>
        <tr class="text-center bold">
            <td width="20%">Miembros</td>
            <td width="10%">DNI/NIE/PAS</td>
            <td width="10%">Caducidad</td>
            <td width="10%">Nacionalidad</td>
            <td width="10%">Parentesco</td>
            <td width="10%">F. Nac.</td>
            <td width="10%">Edad</td>
            <td width="10%">Formación</td>
        </tr>
        @foreach ($record->Family as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->dni }}</td>
                <td>{{ \Carbon\Carbon::parse($member->expiration_date)->format('d/m/Y') }}</td>
                <td>{{ $member->nationality }}</td>
                <td>{{ $member->relationship }}</td>
                <td>{{ \Carbon\Carbon::parse($member->birth_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($member->birth_date)->age }}</td>
                <td>{{ $member->education }}</td>)
                
            </tr>
        @endforeach
    </table><br>

    <table>
        <tr>
            <td width="16%">Vivienda Habitual:</td>
            <td width="16%">{{ $record->housing_type }}</td>
            <td width="16%">Igresos Brutos:</td>
            <td width="16%">{{ $record->incomes != null ? $record->incomes : 0 }} €</td>
            <td width="16%">Ingresos - Gastos:</td>
            <td width="16%">{{ $Total = $record->incomes - ($record->light + $record->water + $record->community + $record->rent + $record->others) }} €</td>
        </tr>
        <tr>
            <td width="16%">Gastos Fijos Mensuales:</td>
            <td width="16%">Luz: {{ $record->light != null ? $record->light : 0 }} €</td>
            <td width="16%">Agua: {{ $record->water != null ? $record->water : 0 }} €</td>
            <td width="16%">Cominidad: {{ $record->community != null ? $record->community : 0 }} €</td>
            <td width="16%">Alquiler/Hipoteca: {{ $record->rent != null ? $record->rent : 0 }} €</td>
            <td width="16%">Otros: {{ $record->others != null ? $record->others : 0 }} €</td>
        </tr>
    </table><br>

    <table>
        
        <tr>
            <td width="30%">Documentos</td>
            <td width="30%">Fecha</td>
            <td width="20%">Fecha Alta</td>
            <td width="20%">Fecha Baja</td>
        </tr>
        <tr>
            <td>Informe de Vida Laboral</td>
            <td colspan="3">
                <table>
                    <tr>
                        <td width="38%" class="noborder">Titular: {{ $record->ivl_emission_date != null ? Carbon\Carbon::parse($record->ivl_emission_date)->format('d/m/Y') : '' }} </td>
                        <td width="25%" class="noborder">{{ $record->ivl_alta_date != null ? Carbon\Carbon::parse($record->ivl_alta_date)->format('d/m/Y') : ''}}</td>
                        <td width="25%" class="noborder">{{ $record->ivl_baja_date != null ? Carbon\Carbon::parse($record->ivl_baja_date)->format('d/m/Y') : ''}}</td>
                    </tr>
                    @foreach ($record->Family as $member)
                        @php
                            $edad = \Carbon\Carbon::parse($member->birth_date)->age;
                        @endphp
                        @if ($edad >= 18)
                            <tr>
                                <td  class="noborder">{{$member->relationship}}: {{ $record->ivl_emission_date != null ? Carbon\Carbon::parse($member->ivl_emission_date)->format('d/m/Y') : '' }}</td>
                                <td  class="noborder">{{ $member->ivl_alta_date != null ? Carbon\Carbon::parse($member->ivl_alta_date)->format('d/m/Y') : ''}}</td>
                                <td  class="noborder">{{ $member->ivl_baja_date != null ? Carbon\Carbon::parse($member->ivl_baja_date)->format('d/m/Y') : ''}}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>Positivo</td>
            <td>Negativo</td>
        </tr>
        <tr>
            <td>Certificado de pensionista</td>
            <td colspan="3">
                <table>
                    <tr>
                        <td width="38%" class="noborder">Titular: {{ $record->cdp_emission_date != null ? Carbon\Carbon::parse($record->cdp_emission_date)->format('d/m/Y') : '' }}</td>
                        <td width="25%" class="noborder">{{$record->cdp_state == true ? $record->cdp_amount : '' }}</td>
                        <td width="25%" class="noborder">{{$record->cdp_state == false ? 'X' : '' }}</td>
                    </tr>
                    @foreach ($record->Family as $member)
                        @php
                            $edad = \Carbon\Carbon::parse($member->birth_date)->age;
                        @endphp
                        @if ($edad >= 18)
                            <tr>
                                <td class="noborder">{{$member->relationship}}: {{ $member->cdp_emission_date != null ? Carbon\Carbon::parse($member->cdp_emission_date)->format('d/m/Y') : '' }}</td>
                                <td class="noborder">{{$member->cdp_state == true ? $member->cdp_amount : '' }}</td>
                                <td class="noborder">{{$member->cdp_state == false ? 'X' : '' }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td>SEPE</td>
            <td colspan="3">
                <table>
                    <tr>
                        <td width="38%" class="noborder">Titular: {{ $record->sepe_emission_date != null ? Carbon\Carbon::parse($record->sepe_emission_date)->format('d/m/Y') : '' }}</td>
                        <td width="25%" class="noborder">{{$record->sepe_state == true ? $record->sepe_amount : '' }}</td>
                        <td width="25%" class="noborder">{{$record->sepe_state == false ? 'X' : '' }}</td>
                    </tr>
                    @foreach ($record->Family as $member)
                        @php
                            $edad = \Carbon\Carbon::parse($member->birth_date)->age;
                        @endphp
                        @if ($edad >= 18)
                            <tr>
                                <td class="noborder">{{$member->relationship}}: {{ $member->sepe_emission_date != null ? Carbon\Carbon::parse($member->sepe_emission_date)->format('d/m/Y') : '' }}</td>
                                <td class="noborder">{{$member->sepe_state == true ? $member->sepe_amount : '' }}</td>
                                <td class="noborder">{{$member->sepe_state == false ? 'X' : '' }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td>Renta minima vital</td>
            <td colspan="3">
                <table>
                    <tr>
                        <td width="38%" class="noborder">Titular: {{ $record->rmv_emission_date != null ? Carbon\Carbon::parse($record->rmv_emission_date)->format('d/m/Y') : '' }}</td>
                        <td width="25%" class="noborder">{{$record->rmv_state == true ? $record->rmv_amount : '' }}</td>
                        <td width="25%" class="noborder">{{$record->rmv_state == false ? 'X' : '' }}</td>
                    </tr>
                    @foreach ($record->Family as $member)
                        @php
                            $edad = \Carbon\Carbon::parse($member->birth_date)->age;
                        @endphp
                        @if ($edad >= 18)
                            <tr>
                                <td class="noborder">{{$member->relationship}}: {{ $member->rmv_emission_date != null ? Carbon\Carbon::parse($member->rmv_emission_date)->format('d/m/Y') : '' }}</td>
                                <td class="noborder">{{$member->rmv_state == true ? $member->rmv_amount : '' }}</td>
                                <td class="noborder">{{$member->rmv_state == false ? 'X' : '' }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tabrmv
            </td>
        </tr>
        <tr>
            <td>Certificado REMISA</td>
            <td colspan="3">
                <table>
                    <tr>
                        <td width="38%" class="noborder">Titular: {{ $record->remisa_emission_date != null ? Carbon\Carbon::parse($record->remisa_emission_date)->format('d/m/Y') : '' }}</td>
                        <td width="25%" class="noborder">{{$record->remisa_state == true ? $record->remisa_amount : '' }}</td>
                        <td width="25%" class="noborder">{{$record->remisa_state == false ? 'X' : '' }}</td>
                    </tr>
                    @foreach ($record->Family as $member)
                        @php
                            $edad = \Carbon\Carbon::parse($member->birth_date)->age;
                        @endphp
                        @if ($edad >= 18)
                            <tr>
                                <td class="noborder">{{$member->relationship}}: {{ $member->remisa_emission_date != null ? Carbon\Carbon::parse($member->remisa_emission_date)->format('d/m/Y') : '' }}</td>
                                <td class="noborder">{{$member->remisa_state == true ? $member->remisa_amount : '' }}</td>
                                <td class="noborder">{{$member->remisa_state == false ? 'X' : '' }}</td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td>Padrón municipal</td>
            <td>Fecha de Emision</td>
            <td colspan="2">{{ Carbon\Carbon::parse($record->municipal_registration_date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Libro de famila	</td>
            <td>¿Documento Entregado?</td>
            <td colspan="2">{{ $record->family_book == true ? "Si" : "No" }}</td>
        </tr>
        <tr>
            <td>Contrato alquiler</td>
            <td>¿Documento Entregado?</td>
            <td colspan="2">{{ $record->rent_contract == true ? "Si" : "No" }}</td>
        </tr>
        <tr>
            <td>Asistencia social</td>
            <td colspan="3">{{ $record->social_assistance_name }}</td>
        </tr>
        <tr>
            <td>Derivaciones</td>
            <td colspan="3">
                <table>
                    @foreach ($record->Derivations as $derivation)
                        <tr>
                            <td width="38%" class="noborder">{{ $derivation->Collaborator->name }}</td>
                            <td width="25%" class="noborder">Fecha</td>
                            <td width="25%" class="noborder">{{ Carbon\Carbon::parse($derivation->created_at)->format('d/m/Y') }}</td>
                        </tr>
                        
                    @endforeach
                </table>
            </td>
            
        </tr>
        
    </table>

    @if ($record->Record->count() > 0)
    <div class="page-break"></div>

    <div class="text-center"><h2>Hoja de Acompañamiento</h2></div>
    <table>
        <tr>
            <td width="15%" class="text-center bold">Fecha</td>
            <td width="85%" class="text-center bold">Incidencia</td>
        </tr>
        @foreach ($record->Record as $incident)
        <tr>
            <td class="text-center">{{Carbon\Carbon::parse($incident->date)->format('d/m/Y')}}</td>
            <td>{!! $incident->incident !!}</td>
        </tr>
        @endforeach
    </table>
    @endif

</body>

</html>