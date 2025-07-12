<?php
namespace Database\Factories;

use App\Models\Vehiculo;
use App\Models\Sucursal;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehiculoSucursalFactory extends Factory
{
    public function definition(): array
    {
        return [
            'vehiculo_id' => Vehiculo::factory(),
            'sucursal_id' => Sucursal::factory(),
            'fecha_ingreso' => $this->faker->date(),
        ];
    }
}