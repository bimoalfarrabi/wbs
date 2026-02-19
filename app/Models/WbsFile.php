<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WbsFile extends Model
{
    protected $fillable = [
        'wbs_report_id',
        'file_path',
        'file_type',
    ];

    public function report()
    {
        return $this->belongsTo(WbsReport::class, 'wbs_report_id');
    }
}
