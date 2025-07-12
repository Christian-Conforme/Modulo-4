<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo VehiculoSucursal
 *
 * @property int $id_relacion
 * @property int $vehiculo_id
 * @property int $sucursal_id
 * @property string $fecha_ingreso
 *
 * @example {
 *   "id_relacion": 1,
 *   "vehiculo_id": 1,
 *   "sucursal_id": 2,
 *   "fecha_ingreso": "2024-07-01"
 * }
 */
class VehiculoSucursal extends Model
{
    use HasFactory;
    protected $table = 'vehiculo_sucursal';
    protected $primaryKey = 'id_relacion';
    public $incrementing = true;
    protected $fillable = ['vehiculo_id', 'sucursal_id', 'fecha_ingreso'];
}