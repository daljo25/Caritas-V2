@php
$entradas = $record->collection + $record->bank_donation + $record->parroquial_receipt + $record->volunteer_campaign_donation + $record->diosesano_receipt + $record->other_donation + $record->special_donation;
$gastos = $record->transfer_collection + $record->transfer_membership + $record->transfer_campaign + $record->transfer_other + $record->transfer_arciprestal + $record->health + $record->housing + $record->food + $record->supplies_receipt + $record->other_intervention + $record->parish_project + $record->general_expense + $record->other_entity + $record->campaign_volunteers + $record->campaign_local_emergency + $record->campaign_international_emergency + $record->development_cooperation;
$balance = $entradas - $gastos;
$trasferencia_diosesano = $record->transfer_collection + $record->transfer_membership;
@endphp

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
        .text-danger {
            color: red;
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
        .text-right {
            text-align: right;
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
<h2 class="text-center">COMUNICADO MENSUAL DE CARITAS PARROQUIAL</h2>

<p class="text-justify">{!! $record->message !!}</p><br>

<table>
    <thead>
        <tr>
            <td class="text-center" width="50%">CONCEPTOS</td>
            <td class="text-center" width="16%">ENTRADAS</td>
            <td class="text-center" width="16%">GASTOS</td>
            <td class="text-center" width="16%">TOTAL</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Recaudacion en la Colecta</td>
            <td class="text-center">{{ number_format($record->collection, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Recibos de Socios Cobrados</td>
            <td class="text-center">{{ number_format($record->parroquial_receipt, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Donativos por Banco</td>
            <td class="text-center">{{ number_format($record->bank_donation, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Campaña de Socios / Voluntarios</td>
            <td class="text-center">{{ number_format($record->volunteer_campaign_donation, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Recibido de C. Diosesana, el 50% de los recibos cobrados por ella.</td>
            <td class="text-center">{{ number_format($record->diosesano_receipt, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Recibido de Otras Entidades</td>
            <td class="text-center">{{ number_format($record->other_donation, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Donaciones en Especie</td>
            <td class="text-center">{{ number_format($record->special_donation, 2, ',', '.') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Transferencia hecha al Fondo Comun Diosesano, el 50% de Colecta y recibos de socios, cobrados por nosotros.</td>
            <td></td>
            <td class="text-center">{{ number_format($trasferencia_diosesano, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Transferencia a C. Diosesana por Campañas</td>
            <td></td>
            <td class="text-center">{{ number_format($record->transfer_campaign, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Transferencia a C. Diosesana por Otros Conceptos</td>
            <td></td>
            <td class="text-center">{{ number_format($record->transfer_other, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Transferencia a Arciprestal</td>
            <td></td>
            <td class="text-center">{{ number_format($record->transfer_arciprestal, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Gastos de Salud (medicamentos, ortopedia, optica, ortodoncia, etc)</td>
            <td></td>
            <td class="text-center">{{ number_format($record->health, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Gastos en Vivienda (alquileres, hipotecas, equipamiento de vivienda)</td>
            <td></td>
            <td class="text-center">{{ number_format($record->housing, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Gastos para Alimentacion e Higiene Personal</td>
            <td></td>
            <td class="text-center">{{ number_format($record->food, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Gastos de Recibos de Suministros Basicos (comunidad, electricidad, agua, gas)</td>
            <td></td>
            <td class="text-center">{{ number_format($record->supplies_receipt, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Otras Intervenciones (material escolar, proyectos de trabajo, bonobus, etc)</td>
            <td></td>
            <td class="text-center">{{ number_format($record->other_intervention, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Proyectos especificos parroquiales</td>
            <td></td>
            <td class="text-center">{{ number_format($record->parish_project, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Gastos Generales (incluye mantemimiento)</td>
            <td></td>
            <td class="text-center">{{ number_format($record->general_expense, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>A otras Entidades</td>
            <td></td>
            <td class="text-center">{{ number_format($record->other_entity, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Campañas de Socios / Voluntarios</td>
            <td></td>
            <td class="text-center">{{ number_format($record->campaign_volunteers, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Campañas (Emergencia Local)</td>
            <td></td>
            <td class="text-center">{{ number_format($record->campaign_local_emergency, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Campañas (Emergencia Intervencional)</td>
            <td></td>
            <td class="text-center">{{ number_format($record->campaign_international_emergency, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Cooperación al desarrollo</td>
            <td></td>
            <td class="text-center">{{ number_format($record->development_cooperation, 2, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
    <thead>
        <tr>
            <td>TOTAL</td>
            <td class="text-center">{{ number_format($entradas, 2, ',', '.') }}</td>
            <td class="text-center">{{ number_format($gastos, 2, ',', '.') }}</td>
            <td class="text-center"><span class="bold {{ $balance < 0 ? 'text-danger' : '' }}">{{ number_format($balance, 2, ',', '.') }}</span></td>
        </tr>
    </thead>
</table>

<p class="text-justify">Reciban, como siempre, nuestro agradecimiento por su colaboracion. Muchas Gracias. DIOS SE LO PAGUE</p><br><br>

<table>
    <tr>
        <td class="text-center noborder">Sevilla, a {{ date("d/m/Y") }}</td>
        <td class="text-center noborder">Fdo. Sabino Antolí. <br>Director de Caritas Parroquial </td>
    </tr>
</table>

</body>
</html>