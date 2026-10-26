<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = ['ruc', 'razon_social'];

    public function movimientos(): HasMany
    {
        return $this->hasMany(Movimiento::class);
    }
}
