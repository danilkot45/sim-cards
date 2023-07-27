<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'imei',
        'number',
        'fio',
        'tariff_id',
    ];
    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
}
