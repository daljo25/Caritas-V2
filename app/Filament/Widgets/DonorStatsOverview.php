<?php

namespace App\Filament\Widgets;

use App\Models\Donation;
use App\Models\Donor;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DonorStatsOverview extends BaseWidget
{
    protected static ?int $sort = 4;
    protected static ?string $pollingInterval = null;
    protected function getStats(): array
    {
        return [
            Stat::make('Total de Donadores', $this->totaldonors()),
            Stat::make('Donaciones en el Año', '€ '.number_format($this->totalDonationsThisYear(), 2, ',', '.')),
            Stat::make('Total de Donaciones', '€ '.number_format($this->totalDonations(), 2, ',', '.')),
        ];
    }

    //funciones para las estadisticas
    //funcion para el total de donadores
    protected function totaldonors() {
        $donors = Donor::all();
        $totaldonors = $donors->count();
        return $totaldonors;
    }
    //funcion de total montos de Donaciones
    protected function totalDonations() {
        $donations = Donation::all();
        $totalAmount = $donations->sum('amount');
        return $totalAmount;
    }
    //funcion de total de donaciones este año
    protected function totalDonationsThisYear() {
        $currentYear = Carbon::now()->year;
        $donations = Donation::where('donation_year', $currentYear)->get();
        $totalAmount = $donations->sum('amount');
        return $totalAmount;
    }



}
