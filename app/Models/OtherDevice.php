<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherDevice extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'device_others';

    protected $fillable = [
        'property_number',
        'device_name',
        'device_type'
    ];

    public function ict() {
        return $this->hasOne('App\Models\ICT');
    }
}
