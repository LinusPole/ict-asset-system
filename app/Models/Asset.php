<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'name',
        'category',
        'department',
        'serial_number',
        'status',
        'assigned_to',
        'location'
    ];
}