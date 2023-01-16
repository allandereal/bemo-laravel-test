<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Column extends Model
{
    use HasFactory, SoftDeletes;

    public function cards(): hasMany
    {
        return $this->hasMany(Card::class);
    }

    public function getLastCardPosition(){
        return self::cards()->orderBy('position', 'desc')->first()?->position;
    }
}
