<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Study
 * @package App\Models
 * * @mixin Builder
 */
class Study extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'school',
        'degree', 'type',
        'level', 'from', 'to'
    ];
}
