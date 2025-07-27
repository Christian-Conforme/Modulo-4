<?php

echo "Iniciando configuración de datos iniciales...\n";

// Script para crear datos iniciales en la base de datos
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Creando sucursal inicial...\n";
    // Crear sucursal inicial
    $sucursal = \App\Models\Sucursal::create([
        'nombre' => 'Sucursal Principal',
        'direccion' => 'Av. Principal 123',
        'ciudad' => 'Ciudad Principal',
        'telefono' => '123456789'
    ]);
    echo " Sucursal creada: ID {$sucursal->id_sucursal}\n";

    echo "Creando rol inicial...\n";
    // Crear rol inicial
    $rol = \App\Models\Rol::create([
        'nombre' => 'Administrador',
        'descripcion' => 'Administrador del sistema'
    ]);
    echo " Rol creado: ID {$rol->id_rol}\n";

    echo "Creando rol de prueba WebSocket...\n";
    // Crear rol de prueba para WebSocket
    $rolTest = \App\Models\Rol::create([
        'nombre' => 'Rol Test WebSocket',
        'descripcion' => 'Test para eventos WebSocket'
    ]);
    echo " Rol test creado: ID {$rolTest->id_rol}\n";

    echo "Creando empleado inicial...\n";
    // Crear empleado inicial
    $empleado = \App\Models\Empleado::create([
        'nombre' => 'Juan Pérez',
        'cargo' => 'Administrador',
        'correo' => 'juan.perez@empresa.com',
        'telefono' => '987654321'
    ]);
    echo " Empleado creado: ID {$empleado->id_empleado}\n";

    echo " Datos iniciales creados exitosamente!\n";
    echo "- Sucursal ID: {$sucursal->id_sucursal}\n";
    echo "- Rol ID: {$rol->id_rol}\n";
    echo "- Empleado ID: {$empleado->id_empleado}\n";

} catch (\Exception $e) {
    echo " Error al crear datos iniciales: " . $e->getMessage() . "\n";
    echo "Detalles: " . $e->getTraceAsString() . "\n";
}
