<?php

// Script para verificar datos existentes en la base de datos
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "🔍 Verificando datos existentes en la base de datos:\n\n";

    $sucursales = \App\Models\Sucursal::count();
    echo "🏢 Sucursales: {$sucursales}\n";
    if ($sucursales > 0) {
        $primera_sucursal = \App\Models\Sucursal::first();
        echo "   - Primera sucursal: ID {$primera_sucursal->id_sucursal} - {$primera_sucursal->nombre}\n";
    }

    $roles = \App\Models\Rol::count();
    echo "🔐 Roles: {$roles}\n";
    if ($roles > 0) {
        $primer_rol = \App\Models\Rol::first();
        echo "   - Primer rol: ID {$primer_rol->id_rol} - {$primer_rol->nombre}\n";
    }

    $empleados = \App\Models\Empleado::count();
    echo "👥 Empleados: {$empleados}\n";
    if ($empleados > 0) {
        $primer_empleado = \App\Models\Empleado::first();
        echo "   - Primer empleado: ID {$primer_empleado->id_empleado} - {$primer_empleado->nombre} {$primer_empleado->apellido}\n";
    }

    $usuarios = \App\Models\User::count();
    echo "👤 Usuarios: {$usuarios}\n";
    if ($usuarios > 0) {
        $primer_usuario = \App\Models\User::first();
        echo "   - Primer usuario: ID {$primer_usuario->id_usuario} - {$primer_usuario->username}\n";
    }

    $vehiculos = \App\Models\Vehiculo::count();
    echo "🚗 Vehículos: {$vehiculos}\n";
    if ($vehiculos > 0) {
        $primer_vehiculo = \App\Models\Vehiculo::first();
        echo "   - Primer vehículo: ID {$primer_vehiculo->id_vehiculo} - {$primer_vehiculo->marca} {$primer_vehiculo->modelo}\n";
    }

    $asignaciones = \App\Models\VehiculoSucursal::count();
    echo "🔗 Asignaciones Vehículo-Sucursal: {$asignaciones}\n";

    echo "\n📋 Resumen:\n";
    if ($sucursales > 0 && $roles > 0 && $empleados > 0) {
        echo "✅ Datos básicos disponibles - Puedes crear usuarios\n";
    } else {
        echo "⚠️  Faltan datos básicos - Ejecuta: php setup_initial_data.php\n";
    }

    if ($vehiculos > 0 && $sucursales > 0) {
        echo "✅ Datos disponibles para asignaciones vehículo-sucursal\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "💡 Verifica que la base de datos esté conectada y las tablas existan\n";
}
