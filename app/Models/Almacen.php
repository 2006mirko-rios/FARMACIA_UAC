<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Almacen extends Model
{
    protected $table = 'almacenes';

    protected $fillable = ['nombre', 'ubicacion'];

    public function movimientos(): HasMany
    {
        return $this->hasMany(Movimiento::class);
    }

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'stock_almacen')
            ->withPivot('stock')
            ->withTimestamps();
    }
}
