<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class StatsChart extends ChartWidget
{
    protected static ?string $heading = 'Ayudas';
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = null;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
{
    // Inicializamos un array para almacenar el total de ayudas por mes
    $totalAidsByMonth = [];
    
    // Obtenemos el año actual
    $currentYear = date('Y');

    // Iteramos sobre los meses del año
    for ($month = 1; $month <= 12; $month++) {
        // Obtenemos el total de ayudas creadas en el mes actual
        $totalAids = \App\Models\Aid::whereYear('start_date', $currentYear)
            ->whereMonth('start_date', $month)
            ->count();

        // Agregamos el total al array de totales por mes
        $totalAidsByMonth[] = $totalAids;
    }

    // Definimos el array de datos para el gráfico
    $data = [
        'datasets' => [
            [
                'label' => 'Ayudas en el Año',
                'data' => $totalAidsByMonth,
            ],
        ],
        'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    ];

    // Retornamos el array de datos
    return $data;
}


    protected function getType(): string
    {
        return 'line';
    }
}
