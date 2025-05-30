<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function PHPUnit\Framework\returnArgument;

class Airline extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'code',
        'name',
        'logo',
    ];

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }
}
