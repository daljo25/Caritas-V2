<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Derivation extends Model
{
    use HasFactory;

    //relaciones
    public function Beneficiary():BelongsTo{
        return $this->belongsTo(Beneficiary::class);
    }
    public function Volunteer():BelongsTo{
        return $this->belongsTo(Volunteer::class);
    }
    public function Collaborator():BelongsTo{
        return $this->belongsTo(Collaborator::class);
    }


    
}
