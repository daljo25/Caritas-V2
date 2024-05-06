@php
$entradas = $record->collection + $record->donation_by_bank + $record->membership_receipts + $record->charity_receipts;
$gastos = $record->charity_transfer + $record->food + $record->supplies_receipt + $record->bank + $record->housing + $record->other_interventions + $record->health + $record->guests;
$balance = $entradas - $gastos;
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
<h2 class="text-center">COMUNICADO MENSUAL DE CARITAS PARROQUIAL</h2><br><br>

<p class="text-justify">{!!$record->message!!}</p><br><br>

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
            <td class="text-center">{{$record->collection}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Donativos por Banco</td>
            <td class="text-center">{{$record->donation_by_bank}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Recibos de Socios Cobrados</td>
            <td class="text-center">{{$record->membership_receipts}}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Recibido de C. Diosesana, el 50% de los recibos cobrados por ella.</td>
            <td class="text-center">{{$record->charity_receipts}}</td>
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
            <td class="text-center">{{$record->charity_transfer}}</td>
            <td></td>
        </tr>
        <tr>
            <td>Gastos para Alimentacion e Higiene Personal</td>
            <td></td>
            <td class="text-center">{{$record->food}}</td>
            <td></td>
        </tr>
        <tr>
            <td>Gastos de Recibos de Suministros Basicos (comunidad, electricidad, agua, gas)</td>
            <td></td>
            <td class="text-center">{{$record->supplies_receipt}}</td>
            <td></td>
        </tr>
        <tr>
            <td>Gastos de Banco</td>
            <td></td>
            <td class="text-center">{{$record->bank}}</td>
            <td></td>
        </tr>
        <tr>
            <td>Gastos en Vivienda (alquileres, hipotecas, equipamiento de vivienda)</td>
            <td></td>
            <td class="text-center">{{$record->housing}}</td>
            <td></td>
        </tr>
        <tr>
            <td>Otras Intervenciones (material escolar, proyectos de trabajo, bonobus, etc)</td>
            <td></td>
            <td class="text-center">{{$record->other_interventions}}</td>
            <td></td>
        </tr>
        <tr>
            <td>Gastos de Salud (medicamentos, ortopedia, optica, ortodoncia, etc)</td>
            <td></td>
            <td class="text-center">{{$record->health}}</td>
            <td></td>
        </tr>
        <tr>
            <td>Transeuntes</td>
            <td></td>
            <td class="text-center">{{$record->guests}}</td>
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
            <td class="text-center">{{number_format($entradas, 2, '.', '')}}</td>
            <td class="text-center">{{number_format($gastos, 2, '.', '')}}</td>
            <td class="text-center"><span class="text-bold {{ $balance < 0 ? 'text-danger' : '' }}">{{number_format($balance, 2, '.', '')}}</span></td>
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