<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Empleado;
use App\Models\Rol;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_usuario()
    {
        $empleado = Empleado::factory()->create();
        $rol = Rol::factory()->create();

        $data = [
            'empleado_id' => $empleado->id_empleado,
            'username' => 'admin',
            'rol_id' => $rol->id_rol,
            'password' => 'secret123'
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'username' => 'admin',
                'empleado_id' => $empleado->id_empleado,
                'rol_id' => $rol->id_rol
            ]);
    }

    public function test_login_usuario()
    {
        $empleado = Empleado::factory()->create();
        $rol = Rol::factory()->create();

        $user = User::factory()->create([
            'empleado_id' => $empleado->id_empleado,
            'username' => 'admin',
            'rol_id' => $rol->id_rol,
            'password' => bcrypt('secret123')
        ]);

        $data = [
            'username' => 'admin',
            'password' => 'secret123'
        ];

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token']);
    }
}