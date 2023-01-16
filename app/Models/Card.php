<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'column_id',
        'description',
        'position'
    ];

    public function column(): belongsTo
    {
        return $this->belongsTo(Column::class);
    }

    public static function getLastPosition()
    {
        return self::query()
            ->orderBy('position', 'desc')
            ->first('position')
            ?->position;
    }
}
