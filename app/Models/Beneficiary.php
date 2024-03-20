<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beneficiary extends Model
{
    use HasFactory;

    //relaciones
    public function Volunteer():BelongsTo {
        return $this->belongsTo(Volunteer::class);
    }
    public function Family():HasMany {
        return $this->hasMany(Family::class);
    }
    public function Record():HasMany {
        return $this->hasMany(Record::class);
    }
    public function Derivations():HasMany{
        return $this->hasMany(Derivation::class);
    }
    public function Aids():HasMany{
        return $this->hasMany(Aid::class);
    }


    //cast
    protected $casts = [
        'family_book' => 'boolean',
        'rent_contract' => 'boolean',
        'cdp_state' => 'boolean',
        'sepe_state' => 'boolean',
        'rmv_state' => 'boolean',
        'remisa_state' => 'boolean',

    ];

    public function age(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->date_of_birth)->age,
        );
    }
}
