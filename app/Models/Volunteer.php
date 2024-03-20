<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Volunteer extends Model
{
    use HasFactory;

    public function Beneficiary():HasMany {
        return $this->hasMany(Beneficiary::class);
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
    
}
