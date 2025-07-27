@echo off
echo ================================================================
echo 🚀 INICIO RÁPIDO - LARAVEL + GRAPHQL + WEBSOCKET
echo ================================================================
echo.

REM Limpiar cache
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan route:clear >nul 2>&1

echo ✅ Iniciando servicios...

REM Laravel Serve
start "🌐 Laravel" cmd /k "title Laravel Server && echo 🌐 Laravel Server: http://127.0.0.1:8000 && echo. && php artisan serve"

REM Esperar un momento
timeout /t 2 /nobreak >nul

REM Laravel Reverb WebSocket
start "🔌 WebSocket" cmd /k "title WebSocket Server && echo 🔌 WebSocket Server: ws://127.0.0.1:8080 && echo. && php artisan reverb:start"

REM Queue Worker
start "⚡ Queue" cmd /k "title Queue Worker && echo ⚡ Queue Worker: Procesando eventos && echo. && php artisan queue:work --verbose"

echo.
echo ================================================================
echo ✅ SERVICIOS INICIADOS
echo ================================================================
echo.
echo 🌐 URLs PRINCIPALES:
echo    Laravel App:      http://127.0.0.1:8000
echo    GraphiQL:         http://127.0.0.1:8000/graphiql
echo    Debug WebSocket:  http://127.0.0.1:8000/debug-websocket.html
echo.
echo 💡 PRUEBA RÁPIDA:
echo    1. Abre GraphiQL: http://127.0.0.1:8000/graphiql
echo    2. Ejecuta: { empleados { id_empleado nombre correo } }
echo.
pause
