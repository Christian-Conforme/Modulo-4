<?php

namespace Tests\Feature;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolDebugTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        return ['Authorization' => 'Bearer ' . $token];
    }

    public function test_debug_eliminar_rol()
    {
        $headers = $this->authenticate();
        $rol = Rol::factory()->create();

        echo "\nRol creado con ID: " . $rol->id_rol . "\n";
        
        // Probemos diferentes URLs
        echo "Probando URLs diferentes:\n";
        
        // URL original
        $response1 = $this->withHeaders($headers)->deleteJson('/api/roles/' . $rol->id_rol);
        echo "1. /api/roles/" . $rol->id_rol . " -> Status: " . $response1->getStatusCode() . "\n";
        
        // Crear otro rol para la segunda prueba
        $rol2 = Rol::factory()->create();
        
        // URL con el ID estándar (auto-incremento)
        $response2 = $this->withHeaders($headers)->deleteJson('/api/roles/' . $rol2->getKey());
        echo "2. /api/roles/" . $rol2->getKey() . " -> Status: " . $response2->getStatusCode() . "\n";
        
        // Solo verificar que obtuvimos algo
        $this->assertTrue(true);
    }
}
