<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $table = 'diagnosis';

    protected $fillable = [
        'control_number',
        'device_id',
        'diagnosis',
        'recommendation	',
        'user_id',
        'approved_by',
        'approved_position'
    ];

}
