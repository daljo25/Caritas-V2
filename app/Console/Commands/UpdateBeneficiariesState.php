<?php

namespace App\Console\Commands;

use App\Models\Beneficiary;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateBeneficiariesState extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beneficiaries:update-state';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar el estado de los beneficiarios según el tiempo transcurrido';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        // Actualizar de 'Activo' a 'Pasivo' si han pasado 3 meses desde la última actualización
        $pasivos =Beneficiary::where('state', 'Activo')
            ->where('updated_at', '<=', $threeMonthsAgo)
            ->update(['state' => 'Pasivo']);

        // Actualizar de 'Pasivo' a 'Archivado' si han pasado 3 meses desde la última actualización
        $archivados = Beneficiary::where('state', 'Pasivo')
            ->where('updated_at', '<=', $threeMonthsAgo)
            ->update(['state' => 'Archivado']);

        $this->info("Se actualizaron $pasivos beneficiarios a pasivos y $archivados beneficiarios a archivados.");
    }
}
