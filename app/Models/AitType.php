<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AitType extends Model
{
    use HasFactory;
    protected $table = 'ait_type';
    protected $fillable = [
        'name',
        'description'
    ];

    protected $guarded = [];

    public function ait()
    {
        return $this->hasMany(Ait::class, 'type_id', 'id');
    }
}
