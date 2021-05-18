<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clearance extends Model
{
    use HasFactory;

    protected $table = 'clearance';

    protected $fillable = [
        'control_number',
        'specs_within_standard_minimum_req',
        'revised_specs',
        'item_cleared_for',
        'item_already_purchased',
        'replacement',
        'repair',
        'others',
        'user_id',
        'approved_by',
        'approved_position'
    ];
}
