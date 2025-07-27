<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Test GraphQL Estadisticas ===\n";

try {
    // Probar el resolver directamente
    $estadisticasQuery = new \App\GraphQL\Queries\EstadisticasQuery();
    $result = $estadisticasQuery->resolve(null, [], null, null);
    
    echo "✅ Estadisticas Query funciona:\n";
    print_r($result);
    
} catch (\Exception $e) {
    echo "❌ Error en EstadisticasQuery: " . $e->getMessage() . "\n";
}

echo "\n=== Test modelos directos ===\n";
try {
    echo "Empleados: " . \App\Models\Empleado::count() . "\n";
    echo "Usuarios: " . \App\Models\User::count() . "\n";
    echo "Vehículos: " . \App\Models\Vehiculo::count() . "\n";
    echo "Sucursales: " . \App\Models\Sucursal::count() . "\n";
    echo "Roles: " . \App\Models\Rol::count() . "\n";
} catch (\Exception $e) {
    echo "❌ Error contando modelos: " . $e->getMessage() . "\n";
}
