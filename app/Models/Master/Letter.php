<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Letter extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function timbangans(): HasMany
    {
        return $this->hasMany(Timbangan::class, 'id_letter', 'id');
    }
}
