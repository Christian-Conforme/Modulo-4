<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Vehiculo
 *
 * @property int $id_vehiculo
 * @property string $placa
 * @property string $marca
 * @property string $modelo
 * @property int $anio
 * @property string $tipo_id
 * @property string $estado
 *
 * @example {
 *   "id_vehiculo": 1,
 *   "placa": "ABC123",
 *   "marca": "Toyota",
 *   "modelo": "Corolla",
 *   "anio": 2022,
 *   "tipo_id": "Sedan",
 *   "estado": "Disponible"
 * }
 */
class Vehiculo extends Model
{
    use HasFactory;
    protected $table = 'vehiculo';
    protected $primaryKey = 'id_vehiculo';
    public $incrementing = true;
    protected $fillable = ['placa', 'marca', 'modelo', 'anio', 'tipo_id', 'estado'];
}