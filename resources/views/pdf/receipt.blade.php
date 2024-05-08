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
        .logo {
            width: 200px;
            height: auto;
        }
        .icon {
            width: 15px;
            height: auto;
            vertical-align: middle;
        }

        .row {
            width: 100%;
            margin: 0;
            display: block;
            float: left;
        }

        .Recibo {
            text-align: right;

        }

        table {
            width: 100%;
            border-spacing: 0;
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

        .Firma {
            vertical-align: top;
            height: 80px;
        }
        .text-justify {
            text-align: justify;
        }
    </style>


</head>

<body>
    <header>
        <table>
            <tr>
                <td colspan="2" width="50%" class="noborder"><img
                        src="https://caritas.sagradocorazonbellavista.com/images/caritas-diosesana.png" alt="Logo"
                        class="logo" /></td>
            </tr>
            <tr>
                <td width="50%" class="noborder">
                    <h2>RECEPCION DE AYUDA</h2>
                </td>
                <td width="50%" class="Recibo noborder">Recibo de Ayuda Nº._________</td>
            </tr>
        </table>

    </header>

    <main>

        <table>
            <tr>
                <td width="10%">D./Dña.</td>
                <td width="90%"><strong>{{ $record->Beneficiary->expedient }} {{ $record->Beneficiary->name }}</strong></td>

            </tr>
        </table>
        <table>
            <tr>
                <td width="20%">Con DNI/ NIE o nº de pasaporte</td>
                <td width="80%"><strong>{{ $record->Beneficiary->dni }}</strong></td>

            </tr>
        </table>
        <p class="text-justify">
            <strong>Ha recibido la cantidad de
                {{ $record->approved_amount }} euros en concepto de
                AYUDA para cubrir la/s nececidad/es especificadas a
                continuacion:</strong>
        </p>
            <article class="text-justify">
                <strong><mark>LUCHA CONTRA LA POBRESA ENERGETICA</mark></strong>
            </article>
        <table>
            <tr>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Pago de suministro" ? "square-x" : "square"}}.webp" class="icon" />Pago de suministro</td>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Adquision y reposicion de elementos luminosos de bajo consumo" ? "square-x" : "square"}}.webp" class="icon" />Adquision y reposicion de elementos luminosos de bajo consumo</td>
            </tr>
            <tr>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Mejora de aislamiento" ? "square-x" : "square"}}.webp" class="icon" />Mejora de aislamiento</td>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Adecuacion, mejora, reparacion y/o mantenimiento de instalaciones y equipamoientos" ? "square-x" : "square"}}.webp" class="icon" />Adecuacion, mejora, reparacion y/o mantenimiento de instalaciones y equipamoientos
                </td>
            </tr>
            <tr>
                <td colspan="2" width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Otras nececidades basicas de energia" ? "square-x" : "square"}}.webp" class="icon" />Otras nececidades basicas de energia</td>
            </tr>
        </table>
            <article class="text-justify">
                <br />
                <strong><mark>GASTOS RELATIVOS A LA VIVIENDA</mark></strong>
            </article>
        <table>
            <tr>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Impago de Alquiler" ? "square-x" : "square"}}.webp" class="icon" />Impago de Alquiler</td>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Impago de credito hipotecario" ? "square-x" : "square"}}.webp" class="icon" />Impago de credito hipotecario</td>
            </tr>
            <tr>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Gastos derivados de las alternativas al alquiler" ? "square-x" : "square"}}.webp" class="icon" />Gastos derivados de las alternativas al alquiler</td>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Adecuacion, mejora, reparacion y/o mantenimiento de instalaciones y equipos NO relacionados con la eficiencia Energetica" ? "square-x" : "square"}}.webp" class="icon" />Adecuacion, mejora, reparacion y/o mantenimiento de instalaciones y equipos NO
                    relacionados con la eficiencia Energetica</td>
            </tr>
            <tr>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Equipamiento basico del Hogar" ? "square-x" : "square"}}.webp" class="icon" />Equipamiento basico del Hogar</td>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Roperia (Ropa, Zapatos, Uniformes, Lenceria del Hogar, etc.)" ? "square-x" : "square"}}.webp" class="icon" />Roperia (Ropa, Zapatos, Uniformes, Lenceria del Hogar, etc.)</td>
            </tr>
            <tr>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Reparacion de Vehiculo" ? "square-x" : "square"}}.webp" class="icon" />Reparacion de Vehiculo</td>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Otras nececidades basicas de vivienda" ? "square-x" : "square"}}.webp" class="icon" />Otras nececidades basicas de vivienda</td>
            </tr>
        </table>
            <article class="text-justify">
                <br />
                <strong><mark>GASTOS RELATIVOS A LA REDUCCION DE LA BRECHA DIGITAL</mark></strong>
            </article>
        <table>
            <tr>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Pago de Telefonia e Internet" ? "square-x" : "square"}}.webp" class="icon" />Pago de Telefonia e Internet</td>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Equipamiento Digital" ? "square-x" : "square"}}.webp" class="icon" />Equipamiento Digital</td>
            </tr>
            <tr>
                <td colspan="2" width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Otras nececidades basicas de la brecha digital" ? "square-x" : "square"}}.webp" class="icon" />Otras nececidades basicas de la brecha digital</td>
            </tr>
        </table>
            <article class="text-justify">
                <br />
                <strong><mark>GASTOS RELATIVOS A LA EDUCACION Y FORMACION</mark></strong>
            </article>
        <table>
            <tr>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Material Escolar" ? "square-x" : "square"}}.webp" class="icon" />Material Escolar</td>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Servicios escolares (Aula Matinal, Aula de Medio dia, Comedor, Extraescolares, etc.)" ? "square-x" : "square"}}.webp" class="icon" />Servicios escolares (Aula Matinal, Aula de Medio dia, Comedor, Extraescolares, etc.)
                </td>
            </tr>
            <tr>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Gastos de Transporte" ? "square-x" : "square"}}.webp" class="icon" />Gastos de Transporte</td>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Otras nececidades basicas de educacion" ? "square-x" : "square"}}.webp" class="icon" />Otras nececidades basicas de educacion</td>
            </tr>
        </table>
            <article class="text-justify">
                <br />
                <strong><mark>GASTOS RELATIVOS A LA SALUD</mark></strong>
            </article>
        <table>
            <tr>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Material farmaceutico (farmacos, copagos, etc.)" ? "square-x" : "square"}}.webp" class="icon" />Material farmaceutico(farmacos, copagos, etc.)</td>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Optica y ortopedia" ? "square-x" : "square"}}.webp" class="icon" />Optica y ortopedia</td>
            </tr>
            <tr>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Odontologia" ? "square-x" : "square"}}.webp" class="icon" />Odontologia</td>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Servicios terapeuticos" ? "square-x" : "square"}}.webp" class="icon" />Servicios terapeuticos</td>
            </tr>
            <tr>
                <td colspan="2" width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Otras nececidades basicas de salud" ? "square-x" : "square"}}.webp" class="icon" />Otras nececidades basicas de salud</td>
            </tr>
        </table>
            <article class="text-justify">
                <br />
                <strong><mark>OTRAS NECESIDADES BASICAS</mark></strong>
            </article>
        <table>
            <tr>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Alimentacion e higiene" ? "square-x" : "square"}}.webp" class="icon" />Alimentacion e higiene</td>
                <td width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Gastos de Transporte o Viajes" ? "square-x" : "square"}}.webp" class="icon" />Gastos de Transporte o Viajes</td>
            </tr>
            <tr>
                <td colspan="2" width="50%"><img src="https://caritas.sagradocorazonbellavista.com/images/{{$record->type == "Otras nececidades basicas" ? "square-x" : "square"}}.webp" class="icon" />Otras nececidades basicas</td>
            </tr>
        </table>

        </div>
    </main>

    <footer>
        <br />
        <table>
            <tr>
                <td width="60%" class="noborder"><img src="https://caritas.sagradocorazonbellavista.com/images/square-x.webp" class="icon" /> Autorizo el Pago a terceros <br />
                    En Sevilla, a {{ date("d/m/Y") }}</td>
                <td width="40%" class="Firma">Firma</td>
            </tr>
        </table>

    </footer>

</body>

</html>