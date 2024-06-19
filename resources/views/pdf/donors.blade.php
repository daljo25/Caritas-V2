<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <style>
        body {
            padding: 0;
            margin: 20px;
            font-family: helvetica, sans-serif;
            font-size: 12px;
        }

        h1 {
            font-size: 16px;
            color: #777;
        }

        table {
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            table-layout: fixed;
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
            padding: 4px;
            border-collapse: collapse;
            word-wrap: break-word;
        }

        .datos {
            border: 1px solid #333;
            margin: 0;
            padding: 4px;
            border-collapse: collapse;
            word-wrap: break-word;
        }

        .cantidades {
            border: 1px solid #333;
            margin: 0;
            padding: 4px;
            border-collapse: collapse;
            white-space: nowrap;
        }

        .logo {
            width: 150px;
            height: auto;
        }

        .noborder {
            border: none;
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
    </style>
</head>

<body>

    <table>
        <tr>
            <td class="noborder" width="30%">
                <img src="https://caritas.sagradocorazonbellavista.com/images/logo-v.svg" alt="logo" class="logo">
            </td>
            <td class="text-center noborder" colspan="17">
                <h1>Lista de Donantes Año {{ $year }}</h1>
            </td>
        </tr>
    </table>

    <table>
        <tr class="text-center bold">
            <td width="20%">Nombre</td>
            <td width="10%">Teléfono</td>
            <td width="15%">Dirección</td>
            <td width="5%">Ene</td>
            <td width="5%">Feb</td>
            <td width="5%">Mar</td>
            <td width="5%">Abr</td>
            <td width="5%">May</td>
            <td width="5%">Jun</td>
            <td width="5%">Jul</td>
            <td width="5%">Ago</td>
            <td width="5%">Sep</td>
            <td width="5%">Oct</td>
            <td width="5%">Nov</td>
            <td width="5%">Dic</td>
            <td width="10%">Total por Donante</td>
        </tr>

        @php
        $months = ['01' => 'Ene', '02' => 'Feb', '03' => 'Mar', '04' => 'Abr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Ago', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dic'];
        $totalByMonth = array_fill(0, 12, 0);
        @endphp

        @foreach ($donations as $donorId => $donationsByDonor)
        @php
        $donor = $donationsByDonor->first()->donor;
        $monthlyDonations = array_fill(0, 12, 0);
        $totalDonations = 0;

        foreach ($donationsByDonor as $donation) {
        $monthIndex = array_search($donation->donation_month, array_keys($months));
        $monthlyDonations[$monthIndex] += $donation->amount;
        $totalByMonth[$monthIndex] += $donation->amount;
        $totalDonations += $donation->amount;
        }
        @endphp
        <tr>
            <td class="datos">{{ $donor->name }}</td>
            <td class="datos">{{ $donor->phone }}</td>
            <td class="datos">{{ $donor->address }}</td>
            @foreach ($monthlyDonations as $amount)
            <td class="cantidades">{{ number_format($amount, 2, ',', '.') }}</td>
            @endforeach
            <td class="cantidades">{{ number_format($totalDonations, 2, ',', '.') }}</td>
        </tr>
        @endforeach

        <tr class="bold">
            <td class="text-right noborder" colspan="3">Total por mes</td>
            @foreach ($totalByMonth as $total)
            <td class="cantidades">{{ number_format($total, 2, ',', '.') }}</td>
            @endforeach
            <td class="cantidades">{{ number_format(array_sum($totalByMonth), 2, ',', '.') }}</td>
        </tr>
    </table>

</body>

</html>