<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Rol
 *
 * @property int $id_rol
 * @property string $nombre
 *
 * @example {
 *   "id_rol": 1,
 *   "nombre": "Administrador"
 * }
 */
class Rol extends Model
{
    use HasFactory;
    protected $table = 'rol';
    protected $primaryKey = 'id_rol';
    public $incrementing = true;
    protected $fillable = ['nombre'];
    public function getRouteKeyName()
    {
        return 'id_rol';
    }
}