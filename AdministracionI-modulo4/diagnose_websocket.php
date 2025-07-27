<?php

// Test simple de WebSocket para diagnosticar problemas

require_once 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🔍 DIAGNÓSTICO WEBSOCKET REVERB\n\n";

// 1. Verificar configuración
echo "1️⃣ Verificando configuración...\n";

$broadcastConnection = config('broadcasting.default');
$reverbConfig = config('broadcasting.connections.reverb');

echo "   BROADCAST_CONNECTION: {$broadcastConnection}\n";
echo "   REVERB_APP_KEY: " . env('REVERB_APP_KEY') . "\n";
echo "   REVERB_HOST: " . env('REVERB_HOST') . "\n";
echo "   REVERB_PORT: " . env('REVERB_PORT') . "\n";
echo "   QUEUE_CONNECTION: " . config('queue.default') . "\n\n";

// 2. Test de evento simple
echo "2️⃣ Testeando sistema de eventos...\n";

try {
    $user = new \App\Models\User();
    $user->id_usuario = 999;
    $user->username = 'test_user';
    $user->empleado_id = 1;
    $user->rol_id = 1;
    
    $event = new \App\Events\UserCreado($user);
    echo "   ✅ Evento UserCreado creado correctamente\n";
    
    $broadcastData = $event->broadcastWith();
    echo "   ✅ Datos de broadcast generados: " . json_encode($broadcastData) . "\n";
    
    $channels = $event->broadcastOn();
    echo "   ✅ Canales de broadcast: " . count($channels) . " canales\n";
    
    foreach ($channels as $channel) {
        echo "      - " . $channel->name . "\n";
    }
    
} catch (\Exception $e) {
    echo "   ❌ Error en evento: " . $e->getMessage() . "\n";
}

echo "\n";

// 3. Test de broadcasting config
echo "3️⃣ Verificando configuración de broadcasting...\n";

if ($broadcastConnection === 'reverb') {
    echo "   ✅ Broadcasting configurado para Reverb\n";
} else {
    echo "   ❌ Broadcasting NO configurado para Reverb (actual: {$broadcastConnection})\n";
}

if (!empty($reverbConfig)) {
    echo "   ✅ Configuración Reverb encontrada\n";
    echo "      App ID: " . $reverbConfig['app_id'] . "\n";
    echo "      App Key: " . $reverbConfig['key'] . "\n";
    echo "      Host: " . $reverbConfig['options']['host'] . "\n";
    echo "      Port: " . $reverbConfig['options']['port'] . "\n";
} else {
    echo "   ❌ Configuración Reverb NO encontrada\n";
}

echo "\n";

// 4. Instrucciones de solución
echo "4️⃣ Instrucciones para solucionar:\n\n";

echo "   🔧 Para iniciar correctamente:\n";
echo "   1. Terminal 1: php artisan queue:work\n";
echo "   2. Terminal 2: php artisan reverb:start\n";
echo "   3. Terminal 3: php artisan serve\n\n";

echo "   🌐 URLs para probar:\n";
echo "   - WebSocket: ws://127.0.0.1:8080/app/" . env('REVERB_APP_KEY') . "\n";
echo "   - Test Interface: http://localhost:8000/websocket-test.html\n\n";

echo "   🔍 Si el error persiste:\n";
echo "   1. Verifica que no haya firewall bloqueando puerto 8080\n";
echo "   2. Ejecuta como administrador\n";
echo "   3. Verifica que no haya otro servicio usando puerto 8080\n";
echo "   4. Prueba cambiar el puerto en .env: REVERB_PORT=8081\n\n";

echo "✅ Diagnóstico completado!\n";
