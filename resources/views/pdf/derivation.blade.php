<style>
    div{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 20px;
    }
    .logo{
        width: 150px;
    }
    .fecha{
        text-align: right;
    }
    .titulo{
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        text-transform: uppercase;
        text-decoration: underline;
    }
    .firma{
        text-align: center;
        font-style: italic;
        font-weight: bold;

    }
</style>

<div><img src="https://caritas.sagradocorazonbellavista.com/images/logo-v.svg" alt="Logo" class="logo"></div><br>
<div class="fecha">Fecha: Sevilla {{ date("d/m/Y") }}</div>
<div><p class="titulo">Carta de Derivacion </p></div><br><br>
<div><strong>Dirigida a:</strong> {{ $record->Collaborator->name }}</div>
<div>Direccion: {{ $record->Collaborator->address }}</div>
<div>Telefono: {{ $record->Collaborator->phone }}</div>
<div>Email: {{ $record->Collaborator->email }}</div><br><br>
<div><strong>Derivado por:</strong> CARITAS PARROQUIAL Sagrado Corazon de Jesus (Bellavista) Sevilla.</div><br><br>
<div><strong>Nombre: </strong> {{ $record->Beneficiary->name }}</div>
<div>Direccion: {{ $record->Beneficiary->address }}</div>
<div>DNI / NIE / PAS: {{ $record->Beneficiary->dni }}</div><br><br>
<div>Motivo: {{ $record->reason }}</div><br>
<div>Observaciones: {{ $record->observation }}</div><br><br><br><br><br><br>
<div class="firma">Fdo. Sabino Antoli Garcia</div>
<div class="firma">Director de Caritas</div>
