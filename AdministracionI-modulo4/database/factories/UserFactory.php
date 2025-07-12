<?php

namespace Database\Factories;

use App\Models\Empleado;
use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'empleado_id' => Empleado::factory(),
            'username' => $this->faker->unique()->userName,
            'password' => Hash::make('password'),
            'rol_id' => Rol::factory(),
        ];
    }
}