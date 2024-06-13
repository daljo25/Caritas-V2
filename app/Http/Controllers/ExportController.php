<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\BeneficiaryExport;
use App\Exports\AidExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    //
    public function beneficiaries()
    {
        return Excel::download(new BeneficiaryExport, 'Usuarios-'. date('d-m-Y') .'.xlsx', \Maatwebsite\Excel\Excel::XLSX, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);        
    }
    public function aids()
    {
        return Excel::download(new AidExport(), 'Ayudas-'. date('d-m-Y') .'.xlsx', \Maatwebsite\Excel\Excel::XLSX, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);        
    }
}
