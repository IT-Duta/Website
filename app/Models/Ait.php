<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ait extends Model
{
    use HasFactory;
    protected $table = 'ait';
    protected $fillable = [
        'type_id',
        'pinjam_id',
        'no_urut',
        'unique',
        'name',
        'old_number',
        'number',
        'serial_number',
        'description',
        'price',
        'condition',
        'location',
        'buy_date',
        'user',
        'status',
        'created_by',
        'updated_by'
    ];

    public function ait_type()
    {
        return $this->belongsTo(AitType::class, 'type_id', 'id');
    }
}
