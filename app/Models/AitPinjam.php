<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AitPinjam extends Model
{
    use HasFactory;
    protected $table = 'ait_pinjam';
    protected $fillable = [
        'id',
        'ait_id',
        'user_id',
        'description',
        'status',
        'tanggal_pinjam',
        'submitted_by',
        'tanggal_kembali',
        'received_by',
    ];

    public function ait()
    {
        return $this->belongsTo(Ait::class, 'ait_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(Users::class, 'user_id', 'id');
    }
}
