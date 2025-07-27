@echo off
echo ================================================================
echo 🚀 INICIANDO SISTEMA COMPLETO LARAVEL + GRAPHQL + WEBSOCKET
echo ================================================================
echo.

REM Verificar que estamos en el directorio correcto
if not exist "artisan" (
    echo ❌ Error: No se encuentra el archivo artisan
    echo Asegúrate de estar en el directorio raíz del proyecto Laravel
    pause
    exit /b 1
)

echo 📋 PASO 1: Limpiando cache y configuraciones...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
echo ✅ Cache limpiado

echo.
echo 📋 PASO 2: Verificando configuración...
echo 🔹 Configuración de Base de Datos:
php -r "
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
echo 'DB_CONNECTION: ' . config('database.default') . PHP_EOL;
echo 'DB_HOST: ' . config('database.connections.pgsql.host') . PHP_EOL;
echo 'BROADCAST_CONNECTION: ' . config('broadcasting.default') . PHP_EOL;
echo 'QUEUE_CONNECTION: ' . config('queue.default') . PHP_EOL;
"

echo.
echo 📋 PASO 3: Iniciando servicios...
echo 🔹 Iniciando Laravel Serve (puerto 8000)...
start "Laravel Serve" cmd /k "cd /d %~dp0 && echo 🌐 Laravel Serve iniciado en http://127.0.0.1:8000 && php artisan serve"

echo 🔹 Esperando 3 segundos...
timeout /t 3 /nobreak >nul

echo 🔹 Iniciando Laravel Reverb WebSocket (puerto 8080)...
start "Laravel Reverb" cmd /k "cd /d %~dp0 && echo 🔌 Laravel Reverb iniciado en ws://127.0.0.1:8080 && php artisan reverb:start"

echo 🔹 Esperando 3 segundos...
timeout /t 3 /nobreak >nul

echo.
echo 📋 PASO 4: Verificando conexiones...
timeout /t 2 /nobreak >nul

echo 🔹 Probando Laravel Serve...
curl -s -o nul -w "Código de respuesta: %%{http_code}" http://127.0.0.1:8000 || echo Puerto 8000: No disponible

echo.
echo 🔹 Probando Laravel Reverb...
powershell -Command "try { $client = New-Object System.Net.Sockets.TcpClient; $client.Connect('127.0.0.1', 8080); $client.Close(); Write-Host 'Puerto 8080: ✅ Disponible' } catch { Write-Host 'Puerto 8080: ❌ No disponible' }"

echo.
echo ================================================================
echo ✅ SERVICIOS INICIADOS
echo ================================================================
echo 🌐 Laravel Serve: http://127.0.0.1:8000
echo 🔌 Laravel Reverb: ws://127.0.0.1:8080
echo 📊 Interface de Pruebas: http://127.0.0.1:8000/websocket-test.html
echo 🔧 Debug WebSocket: http://127.0.0.1:8000/debug-websocket.html
echo.
echo 💡 PARA PROBAR EL SISTEMA:
echo    1. Abre: http://127.0.0.1:8000/websocket-test.html
echo    2. Conecta WebSocket (debería conectar automáticamente)
echo    3. Ejecuta "🚀 Flujo Completo" o crea entidades individualmente
echo    4. Verifica eventos en el log de la página
echo.
pause
