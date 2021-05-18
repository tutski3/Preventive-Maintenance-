<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreventiveMaintenance extends Model
{
    use HasFactory;
	
	protected $table = 'preventive_maintenance';

    protected $fillable = [
        'device_id',
        'user_id',
        'remarks'
    ];
}
