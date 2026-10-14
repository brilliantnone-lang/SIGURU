<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $fillable = [
        'journal_id',
        'murid_id',
        'status_kehadiran',
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }
}