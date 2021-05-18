<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PCDevice extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $table = 'device_pc';

    protected $fillable = [
        'property_number',
        'type',
        'procie',
        'gpu',
        'ram',
        'storage',
        'os',
        'office',
        'ip_lan',
        'ip_wlan',
        'mac_lan',
        'mac_wlan',
    ];

    public function ict() {
        return $this->hasOne('App\Models\ICT');
    }
}
