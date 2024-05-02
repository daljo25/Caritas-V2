<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use App\Models\Beneficiary;
use Filament\Widgets\ChartWidget;

class NationalityChart extends ChartWidget
{
    protected static ?string $heading = 'Pais de Origen';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        return $this->getPieChartData();
    }

    protected function getType(): string
    {
        return 'pie';
    }

    public function getNationalityCounts()
    {
        return Beneficiary::select('nationality', DB::raw('count(*) as count'))
            ->groupBy('nationality')
            ->get();
    }

    // Transformar los datos para el pie chart
    public function getPieChartData()
    {
        $nationalityCounts = $this->getNationalityCounts();

        $labels = $nationalityCounts->map(function ($item) {
            return country_flag($item->nationality) . ' ' . $item->nationality; // Incluye la bandera
        })->toArray();
        $data = $nationalityCounts->pluck('count')->toArray(); // Cantidades por nacionalidad

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.5)', // Rosa con transparencia
                        'rgba(54, 162, 235, 0.5)', // Azul con transparencia
                        'rgba(255, 206, 86, 0.5)', // Amarillo con transparencia
                        'rgba(75, 192, 192, 0.5)', // Verde azulado con transparencia
                        'rgba(153, 102, 255, 0.5)', // Violeta con transparencia
                        'rgba(255, 159, 64, 0.5)', // Naranja con transparencia
                        'rgba(201, 203, 207, 0.5)', // Gris con transparencia
                        'rgba(233, 30, 99, 0.5)',  // Rojo rosado con transparencia
                        'rgba(63, 81, 181, 0.5)',  // Azul índigo con transparencia
                        'rgba(0, 150, 136, 0.5)',  // Verde azulado oscuro con transparencia
                        'rgba(255, 87, 34, 0.5)',  // Naranja rojizo con transparencia
                        'rgba(205, 220, 57, 0.5)', // Verde lima con transparencia
                        'rgba(121, 85, 72, 0.5)',  // Marrón con transparencia
                        'rgba(192, 192, 192, 0.5)',// Gris claro con transparencia
                        'rgba(255, 235, 59, 0.5)', // Amarillo dorado con transparencia
                        'rgba(76, 175, 80, 0.5)',  // Verde con transparencia
                        'rgba(156, 39, 176, 0.5)', // Violeta oscuro con transparencia
                        'rgba(244, 67, 54, 0.5)',  // Rojo intenso con transparencia
                        'rgba(255, 152, 0, 0.5)',  // Naranja brillante con transparencia
                        'rgba(103, 58, 183, 0.5)', // Púrpura con transparencia
                    ],
                    
                    
                ],
            ],
        ];
    }
}
