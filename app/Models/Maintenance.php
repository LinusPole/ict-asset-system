<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = [
        'asset_id',
        'issue_reported',
        'reported_by',
        'technician_assigned',
        'status',
        'repair_cost',
        'reported_date',
        'completed_date',
        'remarks',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}