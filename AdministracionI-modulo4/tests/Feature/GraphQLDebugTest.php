<?php

namespace Tests\Feature;

use App\Models\Vehiculo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;

class GraphQLDebugTest extends TestCase
{
    use RefreshDatabase, MakesGraphQLRequests;

    public function test_debug_actualizar_vehiculo()
    {
        $vehiculo = Vehiculo::factory()->create();

        $mutation = '
            mutation ActualizarVehiculo($id: ID!, $input: VehiculoInput!) {
                actualizarVehiculo(id_vehiculo: $id, input: $input) {
                    id_vehiculo
                    placa
                    marca
                    estado
                }
            }
        ';

        $response = $this->graphQL($mutation, [
            'id' => $vehiculo->id_vehiculo,
            'input' => [
                'placa' => 'TEST-123',
                'marca' => 'Toyota',
                'modelo' => 'Corolla',
                'anio' => 2021,
                'tipo_id' => 'sedan',
                'estado' => 'disponible'
            ]
        ]);

        // Debug: mostrar la respuesta completa
        echo "\nResponse Status: " . $response->getStatusCode() . "\n";
        echo "Response Content: " . $response->getContent() . "\n";
        
        // Solo verificar que la respuesta sea OK por ahora
        $response->assertOk();
    }
}
