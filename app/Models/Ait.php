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
        'quantity',
        'user',
        'status' //Available or Not availble.
    ];

    public function ait_type()
    {
        return $this->belongsTo(AitType::class, 'type_id', 'id');
    }

    public function ait_pinjam()
    {
        return $this->hasOne(AitPinjam::class, 'pinjam_id', 'id');
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
