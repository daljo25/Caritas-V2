<?php

namespace App\Exports;

use App\Models\Aid;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class AidExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    /**
     * Obtiene todos los registros de Aid con la relación Beneficiary.
     */
    public function collection()
    {
        return Aid::with('beneficiary.Family')->get(); // Cargar la relación con Beneficiary y Family
    }

    /**
     * Devuelve la información para cada fila de la exportación.
     */
    public function map($aid): array
    {
        // Obtener información del beneficiario
        $beneficiary = $aid->beneficiary;

        // Calcular la cantidad de familiares por rango de edad
        $ageGroups = $this->getFamilyMemberAgeGroups($beneficiary);

        return [
            $beneficiary->expedient,
            $beneficiary->name,
            $beneficiary->dni,
            $ageGroups['-2'],
            $ageGroups['2a8'],
            $ageGroups['8a14'],
            $ageGroups['14a18'],
            $ageGroups['+18'],
            $ageGroups['total'], // Total de familiares
            $beneficiary->address,
            $beneficiary->phone,
            $aid->type, // Campo adicional de Aid
            $aid->approved_amount, // Campo adicional de Aid
            Carbon::parse($aid->start_date)->format('d-m-Y'), // Formato de la fecha
            Carbon::parse($aid->end_date)->format('d-m-Y'), // Formato de la fecha
        ];
    }

    /**
     * Define los encabezados de las columnas para el archivo Excel.
     */
    public function headings(): array
    {
        return [
            'Expediente',
            'Nombre',
            'DNI',
            'Menos de 2 años',
            '2 a 8 años',
            '8 a 14 años',
            '14 a 18 años',
            'Adultos',
            'Total Familiares',
            'Dirección',
            'Teléfono',
            'Tipo de Ayuda',
            'Monto Aprobado',
            'Fecha de Inicio',
            'Fecha de Fin',
        ];
    }

    /**
     * Título personalizado para la hoja de Excel.
     */
    public function title(): string
    {
        return 'Ayudas';
    }

    /**
     * Método para obtener la cantidad de familiares por rango de edad.
     */
    private function getFamilyMemberAgeGroups($beneficiary)
    {
        $groups = [
            '-2' => 0,
            '2a8' => 0,
            '8a14' => 0,
            '14a18' => 0,
            '+18' => 1, // Predeterminado si no hay familiares
            'total' => 1, // El propio beneficiario cuenta como adulto
        ];

        if ($beneficiary->Family->isEmpty()) {
            return $groups;
        }
        else {
            $groups=[
                '-2' => 0,
                '2a8' => 0,
                '8a14' => 0,
                '14a18' => 0,
                '+18' => 1,
                'total' => 0,
                ] ;
        }

        $today = Carbon::now();

        foreach ($beneficiary->Family as $familyMember) {
            $age = $today->diffInYears(Carbon::parse($familyMember->birth_date));

            if ($age < 2) {
                $groups['-2']++;
            } elseif ($age <= 8) {
                $groups['2a8']++;
            } elseif ($age <= 14) {
                $groups['8a14']++;
            } elseif ($age <= 18) {
                $groups['14a18']++;
            } else {
                $groups['+18']++;
            }
        }

        $groups['total'] = array_sum($groups);

        return $groups;
    }
}
