<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $fillable = ['nama','alamat','telp','jam','lat','lng','is_active'];
}
