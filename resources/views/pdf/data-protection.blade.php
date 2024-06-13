<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <style>
        body {
            padding: 0;
            margin: 30px;
            font-family: helvetica, sans-serif;
            font-size: 14px;
        }

        h1 {
            font-size: 18px;
            color: #777;
        }

        h2 {
            font-size: 16px;
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
            width: 450px;
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

        .mini-text {
            font-size: 10px;
        }
    </style>
</head>

<body>

    <table>
        <tr>
            <td class="noborder"><img src="https://caritas.sagradocorazonbellavista.com/images/logo.svg" alt="logo" class="logo"></td>
        </tr>
    </table>

    <div class="text-center">
        <h1>FORMULARIO DE PROTECCIÓN DE DATOS PERSONALES</h1><br><br>
        <p class="mini-text">IMPRESCINDIBLE CUMPLIMENTAR LOS DATOS Y FIRMAR EL DOCUMENTO PARA PODERSE TRAMITAR LA SOLICITUD</p><br>
    </div>

    <div>
        <h2>A. DATOS DE LA PARROQUIA</h2>
    </div>

    <table>
        <tr>
            <td width="20%">NOMBRE DE LA PARROQUIA:</td>
            <td colspan="3">SAGARADO CORAZON DE JESUS</td>
        </tr>
        <tr>
            <td>Dirección:</td>
            <td colspan="3">CALLE SORIA 5, BELLAVISTA</td>
        </tr>
        <tr>
            <td width="20%">POBLACIÓN:</td>
            <td width="20%">SEVILLA</td>
            <td width="20%">CODIGO POSTAL:</td>
            <td width="20%">41014</td>
        </tr>
    </table>

    <div>
        <h2>B. DATOS PERSONALES DEL INTERVINIENTE</h2>
    </div>
    <table>
        <tr>
            <td width="20%">NOMBRE Y APELLIDOS(Y DEL REPRESENTANTE LEGAL EN SU CASO):</td>
            <td colspan="3">{{ $record->name }}</td>
        </tr>
        <tr>
            <td width="20%">DIRECCIÓN:</td>
            <td colspan="3">{{ $record->address }}</td>
        </tr>
        <tr>
            <td width="20%">POBLACIÓN:</td>
            <td width="20%">SEVILLA</td>
            <td width="20%">CODIGO POSTAL:</td>
            <td width="20%">41014</td>
        </tr>
        <tr>
            <td width="20%">DNI (O DOCUMENTO QUE LO SUSTITUYA):</td>
            <td width="20%">{{ $record->dni }}</td>
            <td width="20%">EMAIL:</td>
            <td width="20%">{{ $record->email }}</td>
        </tr>
        <tr>
            <td width="20%">TELEFONO:</td>
            <td colspan="3">{{ $record->phone }}</td>
        </tr>
        <tr>
            <td width="20%">FECHA Y FIRMA:</td>
            <td colspan="3"> {{ date("d/m/Y") }} <br><br><br><br><br><br></td>
        </tr>
    </table>

    <div class="page-break"></div>

    <div>
        <p class="text-justify mini-text">De conformidad con lo establecido en la Ley Orgánica 15/1999, de 13 de diciembre, de Protección de Datos de Carácter Personal, el firmante, queda informado y presta su consentimiento expreso a la incorporación de sus datos a los ficheros, automatizados o no, de la mencionada PARROQUIA perteneciente a la ARCHIDIÓCESIS DE SEVILLA, así como al tratamiento de los mismos, con fines informativos, pastorales, de intervención social y de gestión. Los datos solicitados y cualesquiera otros que puedan ser exigidos por la normativa aplicable son de obligada cumplimentación. La destinataria de dichos datos será dicha PARROQUIA, la cual, se compromete al cumplimiento de su obligación de secreto y conservación de los mismos, adoptando las medidas necesarias para evitar su alteración, pérdida, tratamiento o acceso no autorizado, habida cuenta en todo momento del estado de la tecnología. <br><br>

De conformidad con lo establecido en la Ley Orgánica 15/1999 de Protección de Datos de Carácter Personal y en el Real Decreto 1720/2007, que aprueba su Reglamento de desarrollo, el Interviniente queda informado y presta su consentimiento a la incorporación de sus datos a los ficheros, automatizados o no, existentes en esta CÁRITAS PARROQUIAL y al tratamiento de los mismos a los que se tenga acceso (mediante la grabación de imágenes por cámaras de seguridad que pudieran estar ubicadas en los despachos y/o dependencias, los recabados en la petición, en cualquier clase de soporte o documento aportado al expediente con posterioridad, digitalización de los documentos, así como en las entrevistas, reuniones y/o conversaciones telefónicas) con relación a las finalidades propias de esta CÁRITAS PARROQUIAL: Acción Social, Formación, Animación y Divulgación. Así, los datos personales recabados, serán tratados para aquellos fines que guarden relación directa con la solicitud del peticionario al objeto de intentar satisfacerla. En particular los datos personales también podrán ser utilizados para el envío de publicaciones, boletines o informaciones sobre actividades (incluidas las comunicaciones electrónicas, a los efectos del artículo 21 de la Ley 34/2002, de Servicios de la Sociedad de la Información) al objeto de adecuar nuestras actividades a su perfil particular y de realizar, en su caso, modelos valorativos. Todo ello sin perjuicio de los derechos de los afectados de manifestar expresamente su negativa al tratamiento o a la comunicación de sus datos personales no directamente relacionados con el mantenimiento, desarrollo o control de la petición formulada ante esta CÁRITAS PARROQUIAL, en los términos señalados posteriormente. <br><br>

Los datos identificativos, los referentes al perfil profesional, los de contacto cuyo carácter imprescindible se establezca expresamente y cualesquiera otros que puedan ser exigidos por la normativa aplicable son obligatorios y la negativa a suministrarlos supondrá la imposibilidad de incoar su expediente. Los restantes datos y/o documentación que pudieran solicitarse por esta CÁRITAS PARROQUIAL son voluntarios, no obstante, el hecho de no facilitarlos podría llegar a suponer la paralización en la tramitación del expediente. <br><br>

El Interviniente consiente expresamente que sus datos puedan ser cedidos, exclusivamente para las finalidades a las que se refiere el párrafo primero, a otras entidades distintas de esta CÁRITAS PARROQUIAL (y en particular a CÁRITAS DIOCESANA, CÁRITAS ESPAÑOLA, la ARCHIDIÓCESIS DE SEVILLA, y/o las Administraciones Públicas) cuyas actividades sean de Acción Social, prestación de Servicios Sociales o similar, y autorizan a aquellas a que les remitan comunicaciones sobre cualesquiera actividades relacionadas.  <br><br>

La aceptación del Interviniente para que sus datos puedan ser tratados o cedidos en la forma establecida en la presente cláusula tiene siempre carácter revocable, sin efectos retroactivos, conforme a lo que disponen los artículos 6 y 11 de la Ley Orgánica 15/1999 de Protección de Datos de Carácter Personal.  <br><br>

Esta CÁRITAS PARROQUIAL es la única entidad titular responsable de los datos personales del Interviniente, si bien, ha designado expresamente al ARZOBISPADO DE SEVILLA como entidad que actúa por cuenta de CÁRITAS PARROQUIAL para atender aquellas solicitudes relativas al ejercicio de los derechos de acceso, rectificación, cancelación u oposición, así como para revocar el consentimiento aquí prestado sobre los datos tratados o cedidos. El Interviniente podrá dirigirse (mediante escrito, o bien, presencialmente en horario de atención al público) ante el ARZOBISPADO DE SEVILLA, (REF. Datos) Plaza Virgen de los Reyes s/n, Apartado 6 - 41004 Sevilla, expresando junto a su petición, el nombre de la Parroquia y la población en que se contactó con esta CÁRITAS PARROQUIAL, todo ello, en los términos establecidos en la legislación vigente. <br><br>

El Interviniente autoriza a que tanto esta CÁRITAS PARROQUIAL como CÁRITAS DIOCESANA contacte con usted a través de su teléfono móvil y/o su correo electrónico con el objeto de informarle periódicamente sobre cualquier otra actividad de las mismas que pudiera ser de su interés a tenor de su petición. <br>

</p>
    </div>
</body>