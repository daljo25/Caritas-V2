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
            background-color: black;
            color: white;
            text-align: center;
        }

        tbody {
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
            width: 100px;
            height: auto;
        }

        .noborder,
        .noborder td,
        .noborder th,
        .noborder tr {
            border: none !important;
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

    <div>
        <img src="https://caritas.sagradocorazonbellavista.com/images/logo-v.svg" alt="logo" class="logo">
        <h1 class="text-center bold">Lista de Citas del {{ date('d-m-Y', strtotime($day)) }}</h1>
    </div>
    <table>
        <thead>
            <tr>
                <td class="text-center">NOMBRES</td>
                <td class="text-center">DIRECCION</td>
                <td class="text-center">TELEFONO</td>
                <td class="text-center">EMAIL</td>
                <td class="text-center">FECHA</td>
                <td class="text-center">HORA</td>
                <td class="text-center">NOTA</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
            <tr>
                <td class="text-center">{{ $appointment->beneficiary->name }}</td>
                <td class="text-center">{{ $appointment->beneficiary->address }}</td>
                <td class="text-center">{{ $appointment->beneficiary->phone }}</td>
                <td class="text-center">{{ $appointment->beneficiary->email }}</td>
                <td class="text-center">{{ $appointment->appointment_date }}</td>
                <td class="text-center">{{ $appointment->appointment_time }}</td>
                <td class="text-center">{{ $appointment->notes }}</td>
            </tr>
            @endforeach
        </tbody>
    </table><br><br>

    <div class="text-center bold">
        <h1>Otras Citas Pendientes</h1>
    </div>
    <table>
        <thead>
            <tr>
                <td class="text-center">NOMBRES</td>
                <td class="text-center">DIRECCION</td>
                <td class="text-center">TELEFONO</td>
                <td class="text-center">EMAIL</td>
                <td class="text-center">FECHA</td>
                <td class="text-center">HORA</td>
                <td class="text-center">NOTA</td>
                <td class="text-center">ESTADO</td>
        </thead>
        <tbody>
            @foreach ($otherAppointments as $appointment)
            <tr>
                <td class="text-center">{{ $appointment->beneficiary->name }}</td>
                <td class="text-center">{{ $appointment->beneficiary->address }}</td>
                <td class="text-center">{{ $appointment->beneficiary->phone }}</td>
                <td class="text-center">{{ $appointment->beneficiary->email }}</td>
                <td class="text-center">{{ $appointment->appointment_date }}</td>
                <td class="text-center">{{ $appointment->appointment_time }}</td>
                <td class="text-center">{{ $appointment->notes }}</td>
                <td class="text-center">{{ $appointment->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>