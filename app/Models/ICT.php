<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ICT extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'ict_equipment';
    
    protected $fillable = [
        'user',
        'center',
        'unit',
        'device_id',
        'issuance_date',
        'purchase_year',
        'burn_in_date'
    ];

    public function other_device() {
        return $this->belongsTo('App\Models\OtherDevice');
    }

    public function pc_device() {
        return $this->belongsTo('App\Models\PCDevice');
    }
}
