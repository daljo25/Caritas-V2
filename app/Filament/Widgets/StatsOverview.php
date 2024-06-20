<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = null;
    protected function getStats(): array
    {
        return [
            Stat::make('Total de Familias', $this->totalbeneficiaries()),
            Stat::make('Ayudas en el Año', $this->totalaids()),
            Stat::make('Total de Ayudas', '€ '.number_format($this->totalAidsAmount(), 2, ',', '.')),
        ];
    }

    //funciones para las estadisticas
    //funcion para el total de familias
    protected function totalbeneficiaries() {
        $beneficiaries = \App\Models\Beneficiary::all();
        $totalbeneficiaries = $beneficiaries->count();
        return $totalbeneficiaries;
    }
    //funcion para el total de ayudas en el año en curso
    protected function totalaids() {
        $currentYear = Carbon::now()->year;
        $aids = \App\Models\Aid::whereYear('start_date', $currentYear)->get();
        $totalaids = $aids->count();
        return $totalaids;
    }
    //funcion de total montos de ayuda en el año en curso
    protected function totalAidsAmount() {
        $currentYear = Carbon::now()->year;
        $aids = \App\Models\Aid::whereYear('created_at', $currentYear)->get();
        $totalAmount = $aids->sum('total_amount');
        return $totalAmount;
    }
}
