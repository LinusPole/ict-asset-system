<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetHistory extends Model
{
    protected $fillable = [
        'asset_id',
        'action',
        'performed_by',
        'description',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}