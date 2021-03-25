<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Favourite
 * @package App\Models
 * @mixin Builder
 */
class Favourite extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'user_id', 'job_id', 'type', 'created_at', 'company', 'location', 'title', 'company_logo'
    ];
}
