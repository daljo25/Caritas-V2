<?php

namespace App\Exports;

use App\Models\Beneficiary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class BeneficiaryExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    /**
     * Obtiene todos los beneficiarios con su relación "Family".
     */
    public function collection()
    {
        return Beneficiary::with('Family')->get(); // Cargar la relación Family
    }

    /**
     * Devuelve la información para cada fila de la exportación.
     */
    public function map($beneficiary): array
    {
        // Calcular la cantidad de familiares por rango de edad
        $ageGroups = $this->getFamilyMemberAgeGroups($beneficiary);

        return [
            $beneficiary->state,
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
        ];
    }

    /**
     * Devuelve los encabezados para el archivo de Excel.
     */
    public function headings(): array
    {
        return [
            'Estado',
            'Expediente',
            'Nombre',
            'DNI',
            '-2 años',
            '2 a 8 años',
            '8 a 14 años',
            '14 a 18 años',
            'Adultos',
            'Total',
            'Dirección',
            'Teléfono',
        ];
    }

    /**
     * Título personalizado para la hoja de Excel.
     */
    public function title(): string
    {
        return 'Beneficiarios';
    }

    /**
     * Obtiene la cantidad de familiares por rango de edad.
     */
    private function getFamilyMemberAgeGroups($beneficiary)
    {
        $groups = [
            '-2' => 0,
            '2a8' => 0,
            '8a14' => 0,
            '14a18' => 0,
            '+18' => 1,
            'total' => 1,
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
        // Obtener la fecha actual para calcular las edades
        $today = Carbon::now();

        foreach ($beneficiary->Family as $familyMember) {
            // Calcular la edad usando la fecha de nacimiento
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

        // Calcular el total de familiares
        $groups['total'] = array_sum($groups);

        return $groups;
    }
}
