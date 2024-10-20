@php
    use app\Models\Aid;
    $cont = 0;
    $total = 0;
@endphp

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

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
        .logo {
            width: 150px;
            height: auto;
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

    <table>
        <tr>
            <td class="noborder"><img src="https://caritas.sagradocorazonbellavista.com/images/logo-v.svg" alt="logo" class="logo"></td>
            <td class="text-right noborder">CARITAS PARROQUIAL DEL <br>
                SAGRADO CORAZON DE JESUS <br>
                Calle Soria 5, Bellavista <br>
                41014 Sevilla</td>
        </tr>
        <tr>
            <td class="noborder"></td>
            <td class="text-right noborder">Sevilla, a {{ date("d/m/Y") }}</td>
        </tr>
    </table>
<br><br>
    <p class="text-justify">
        Supermercado Coviran. <br>
Les remito la relacion de usuarios de nuestra Caritas, para que puedan retiurar los
alimentos que correspondan a las cantidades subvencionadas a cada uno de ellos.
Dicha compra la podran efectuar a partir del 01/{{ date("m/Y") }}, durante todo el mes.
Quedando agradecido por su colaboracion.
    </p>
<br><br>
<table>
    <tr class="text-center bold">
        <td>NUMERO</td>
        <td>TITULAR</td>
        <td>DNI/NIE/PAS</td>
        <td>CANTIDAD</td>
    </tr>
    @foreach (Aid::where('type', 'Alimentacion e higiene')
             ->where('status', 'Aceptada')
             ->with('Beneficiary')
             ->get() as $aid)
        <tr class="text-center">
            <td>{{$aid->Beneficiary->id}}</td>
            <td>{{$aid->Beneficiary->name}}</td>
            <td>{{$aid->Beneficiary->dni}}</td>
            <td>{{$aid->approved_amount}}</td>
        </tr>
        @php
            $cont++;
            $total += $aid->approved_amount;
        @endphp
    @endforeach
    <tr class="text-center">
        <td>{{$cont}} {{ $cont > 1 ? 'Familias' : 'Familia'}}</td>
        <td></td>
        <td>Total</td>
        <td>{{number_format($total, 2, '.', ',')}}</td>
    </tr>
</table>
<br><br><br><br>
<div class="text-center">
    Fdo. Sabino Antoli Garcia <br>
    Director de Caritas Parroquial
</div>
</body>