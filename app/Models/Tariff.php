<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tariff extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'available_minutes',
        'sms_count',
        'cost',
    ];
    public function card()
    {
        return $this->hasOne(Card::class);
    }
}
