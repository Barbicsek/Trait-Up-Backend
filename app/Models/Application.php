<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Application extends Model
{
    use HasFactory;
    protected $table = "application";
    protected $fillable = [
        'user_id', 'job_id', 'type', 'created_at', 'company', 'location', 'title', 'description'
    ];
}
