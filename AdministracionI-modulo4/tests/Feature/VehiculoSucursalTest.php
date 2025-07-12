<?php

namespace Tests\Feature;

use App\Models\Vehiculo;
use App\Models\Sucursal;
use App\Models\User;
use App\Models\VehiculoSucursal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehiculoSucursalTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        return ['Authorization' => 'Bearer ' . $token];
    }

    public function test_crear_vehiculo_sucursal()
    {
        $headers = $this->authenticate();
        $vehiculo = Vehiculo::factory()->create();
        $sucursal = Sucursal::factory()->create();

        $data = [
            'vehiculo_id' => $vehiculo->id ?? $vehiculo->id_vehiculo,
            'sucursal_id' => $sucursal->id_sucursal,
            'fecha_ingreso' => '2024-07-01'
        ];

        $response = $this->withHeaders($headers)->postJson('/api/vehiculo-sucursal', $data);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'vehiculo_id' => $data['vehiculo_id'],
                'sucursal_id' => $data['sucursal_id'],
                'fecha_ingreso' => $data['fecha_ingreso']
            ]);
    }

    public function test_mostrar_vehiculo_sucursal()
    {
        $headers = $this->authenticate();
        $vehiculoSucursal = VehiculoSucursal::factory()->create();

        $response = $this->withHeaders($headers)->getJson('/api/vehiculo-sucursal/' . ($vehiculoSucursal->id_relacion ?? $vehiculoSucursal->id));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'vehiculo_id' => $vehiculoSucursal->vehiculo_id,
                'sucursal_id' => $vehiculoSucursal->sucursal_id
            ]);
    }

    public function test_actualizar_vehiculo_sucursal()
    {
        $headers = $this->authenticate();
        $vehiculoSucursal = VehiculoSucursal::factory()->create();
        $data = [
            'vehiculo_id' => $vehiculoSucursal->vehiculo_id,
            'sucursal_id' => $vehiculoSucursal->sucursal_id,
            'fecha_ingreso' => '2024-08-01'
        ];

        $response = $this->withHeaders($headers)->putJson('/api/vehiculo-sucursal/' . ($vehiculoSucursal->id_relacion ?? $vehiculoSucursal->id), $data);

        $response->assertStatus(200)
            ->assertJsonFragment($data);
    }

    public function test_eliminar_vehiculo_sucursal()
    {
        $headers = $this->authenticate();
        $vehiculoSucursal = VehiculoSucursal::factory()->create();

        $response = $this->withHeaders($headers)->deleteJson('/api/vehiculo-sucursal/' . ($vehiculoSucursal->id_relacion ?? $vehiculoSucursal->id));

        $response->assertStatus(200)
            ->assertJson(['message' => 'Vehiculo con Sucursal eliminado']);
        $this->assertDatabaseMissing('vehiculo_sucursal', ['id_relacion' => $vehiculoSucursal->id_relacion ?? $vehiculoSucursal->id]);
    }

    public function test_no_autenticado_no_puede_acceder()
    {
        $response = $this->getJson('/api/vehiculo-sucursal');
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }
}