@echo off
setlocal enabledelayedexpansion
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
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan view:clear >nul 2>&1
echo ✅ Cache limpiado

echo.
echo 📋 PASO 2: Verificando configuración del sistema...
echo 🔹 Configuración de Base de Datos:
php -r "
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
echo '   DB_CONNECTION: ' . config('database.default') . PHP_EOL;
echo '   DB_HOST: ' . config('database.connections.pgsql.host') . PHP_EOL;
echo '   BROADCAST_CONNECTION: ' . config('broadcasting.default') . PHP_EOL;
echo '   QUEUE_CONNECTION: ' . config('queue.default') . PHP_EOL;
"

echo.
echo 🔹 Verificando estado de la base de datos...
php artisan migrate:status >nul 2>&1
if %errorlevel% equ 0 (
    echo ✅ Conexión a base de datos: OK
) else (
    echo ❌ Error de conexión a base de datos
    echo 💡 Verifica tu archivo .env y que PostgreSQL esté ejecutándose
)

echo.
echo � Verificando esquema GraphQL...
php artisan lighthouse:print-schema >nul 2>&1
if %errorlevel% equ 0 (
    echo ✅ Esquema GraphQL: OK
) else (
    echo ❌ Error en esquema GraphQL
)

echo.
echo �📋 PASO 3: Iniciando servicios principales...
echo 🔹 Iniciando Laravel Serve (puerto 8000)...
start "🌐 Laravel Serve" cmd /k "cd /d %~dp0 && title Laravel Serve - Puerto 8000 && echo 🌐 Laravel Serve iniciado en http://127.0.0.1:8000 && echo. && php artisan serve --host=127.0.0.1 --port=8000"

echo 🔹 Esperando inicialización del servidor...
timeout /t 4 /nobreak >nul

echo 🔹 Iniciando Laravel Reverb WebSocket (puerto 8080)...
start "🔌 Laravel Reverb" cmd /k "cd /d %~dp0 && title Laravel Reverb - Puerto 8080 && echo 🔌 Laravel Reverb WebSocket iniciado en ws://127.0.0.1:8080 && echo. && php artisan reverb:start --host=127.0.0.1 --port=8080"

echo 🔹 Esperando inicialización de WebSocket...
timeout /t 4 /nobreak >nul

echo 🔹 Iniciando Queue Worker para eventos...
start "⚡ Queue Worker" cmd /k "cd /d %~dp0 && title Queue Worker - Eventos && echo ⚡ Queue Worker iniciado para procesar eventos && echo. && php artisan queue:work --verbose --timeout=0"

echo.
echo 📋 PASO 4: Verificando conectividad de servicios...
timeout /t 3 /nobreak >nul

echo 🔹 Verificando Laravel Serve...
curl -s -o nul -w "   Laravel Serve (puerto 8000): HTTP %%{http_code}" http://127.0.0.1:8000
echo.

echo 🔹 Verificando Laravel Reverb...
powershell -Command "try { $client = New-Object System.Net.Sockets.TcpClient; $client.Connect('127.0.0.1', 8080); $client.Close(); Write-Host '   Laravel Reverb (puerto 8080): ✅ Conectado' } catch { Write-Host '   Laravel Reverb (puerto 8080): ❌ No disponible' }"

echo.
echo 📋 PASO 5: Ejecutando tests de verificación...
echo 🔹 Test rápido GraphQL...
php -r "
\$ch = curl_init('http://127.0.0.1:8000/graphql');
curl_setopt(\$ch, CURLOPT_POST, true);
curl_setopt(\$ch, CURLOPT_POSTFIELDS, json_encode(['query' => '{ empleados { id_empleado nombre } }']));
curl_setopt(\$ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt(\$ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt(\$ch, CURLOPT_TIMEOUT, 5);
\$response = curl_exec(\$ch);
\$httpCode = curl_getinfo(\$ch, CURLINFO_HTTP_CODE);
curl_close(\$ch);
if (\$httpCode === 200) {
    \$data = json_decode(\$response, true);
    if (isset(\$data['data'])) {
        echo '   GraphQL Endpoint: ✅ Funcionando' . PHP_EOL;
    } else {
        echo '   GraphQL Endpoint: ⚠️  Respuesta inesperada' . PHP_EOL;
    }
} else {
    echo '   GraphQL Endpoint: ❌ Error HTTP ' . \$httpCode . PHP_EOL;
}
"

echo.
echo ================================================================
echo ✅ SISTEMA COMPLETAMENTE INICIADO
echo ================================================================
echo.
echo 🌐 SERVICIOS PRINCIPALES:
echo    ├─ Laravel Serve:     http://127.0.0.1:8000
echo    ├─ Laravel Reverb:    ws://127.0.0.1:8080
echo    └─ Queue Worker:      Procesando eventos en background
echo.
echo 🔧 HERRAMIENTAS DE DESARROLLO:
echo    ├─ GraphiQL:          http://127.0.0.1:8000/graphiql
echo    ├─ Debug WebSocket:   http://127.0.0.1:8000/debug-websocket.html
echo    ├─ Test WebSocket:    http://127.0.0.1:8000/websocket-test.html
echo    └─ Dashboard:         http://127.0.0.1:8000/dashboard
echo.
echo � ENDPOINTS API:
echo    ├─ GraphQL:           POST http://127.0.0.1:8000/graphql
echo    ├─ REST API:          http://127.0.0.1:8000/api/*
echo    └─ WebSocket Events:  ws://127.0.0.1:8080
echo.
echo 🧪 GUÍA DE PRUEBAS RÁPIDAS:
echo    1. GraphiQL Interface:
echo       → Abre: http://127.0.0.1:8000/graphiql
echo       → Ejecuta: { empleados { id_empleado nombre correo } }
echo.
echo    2. WebSocket + GraphQL:
echo       → Abre: http://127.0.0.1:8000/debug-websocket.html
echo       → Conecta WebSocket y ejecuta mutations
echo       → Verifica eventos en tiempo real
echo.
echo    3. Test Completo del Sistema:
echo       → Abre: http://127.0.0.1:8000/websocket-test.html
echo       → Ejecuta "🚀 Flujo Completo"
echo       → Observa creación de entidades + eventos WebSocket
echo.
echo 💡 COMANDOS ÚTILES ADICIONALES:
echo    ├─ Ver logs:          php artisan log-viewer
echo    ├─ Tests:             php artisan test --filter GraphQL
echo    ├─ Schema GraphQL:    php artisan lighthouse:print-schema
echo    └─ Reiniciar Queue:   php artisan queue:restart
echo.
echo 📝 NOTA: Las ventanas de los servicios permanecerán abiertas.
echo    Para detener el sistema, cierra las ventanas de terminal.
echo.
pause
