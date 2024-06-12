<?php

namespace App\Exports;

use App\Models\Aid;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Facades\Excel;

class AidExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * Obtiene la colección de registros de Aid según los filtros proporcionados.
     */
    public function collection(): Collection
    {
        $query = Aid::query();
        //dd($this->filters);

        // Aplicar los filtros si se proporcionan
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['type'])) {
            $query->whereIn('type', $this->filters['type']);
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $startDate = $this->filters['start_date'];
            $endDate = $this->filters['end_date'];
    
            $query->where(function($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function($q) use ($startDate, $endDate) {
                      $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                  });
            });
        } elseif (!empty($this->filters['start_date'])) {
            $query->where('start_date', '>=', $this->filters['start_date']);
        } elseif (!empty($this->filters['end_date'])) {
            $query->where('end_date', '<=', $this->filters['end_date']);
        }

        return $query->with('beneficiary.Family')->get();
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
            $aid->status,
            $aid->paid_by,
            $aid->type, 
            $aid->approved_amount, 
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
            'Etapa',
            'Pagado por',
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
     * Descargar el archivo la hoja de Excel.
     */
    public function download() {
        return Excel::download(new AidExport($this->filters));
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
