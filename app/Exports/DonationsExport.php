<?php

namespace App\Exports;

use App\Models\Donation;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DonationsExport implements FromQuery, WithHeadings
{
    use Exportable;

    private $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Donation::query()
            ->select('donors.name', 'donors.phone', 'donors.email', 'donors.address', 'donations.amount', 'donations.donation_month', 'donations.donation_year', 'donations.source')
            ->join('donors', 'donations.donor_id', '=', 'donors.id');

        if (!empty($this->filters['donor_name'])) {
            $query->whereIn('donors.name', $this->filters['donor_name']);
        }

        if (!empty($this->filters['source'])) {
            $query->whereIn('donations.source', $this->filters['source']);
        }

        if (!empty($this->filters['donation_month'])) {
            $query->whereIn('donations.donation_month', $this->filters['donation_month']);
        }

        if (!empty($this->filters['donation_year'])) {
            $query->whereIn('donations.donation_year', $this->filters['donation_year']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [

            'Nombre',
            'Telefono',
            'Email',
            'Dirección',
            'Cantidad',
            'Mes',
            'Año',
            'Medio de Donación',
        ];
    }
}
