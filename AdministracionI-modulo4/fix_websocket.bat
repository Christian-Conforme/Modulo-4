@echo off
echo ========================================
echo 🔧 DIAGNOSTICADOR WEBSOCKET REVERB
echo ========================================

echo.
echo 1️⃣ Verificando configuración...
echo.

echo 📝 Verificando variables de entorno:
findstr /C:"BROADCAST_CONNECTION" .env
findstr /C:"QUEUE_CONNECTION" .env  
findstr /C:"REVERB_APP_KEY" .env
findstr /C:"REVERB_HOST" .env
findstr /C:"REVERB_PORT" .env

echo.
echo 2️⃣ Verificando puerto 8080...
netstat -an | findstr :8080

echo.
echo 3️⃣ Matando procesos existentes en puerto 8080...
for /f "tokens=5" %%i in ('netstat -ano ^| findstr :8080 ^| findstr LISTENING') do (
    echo Matando proceso %%i
    taskkill /F /PID %%i 2>nul
)

echo.
echo 4️⃣ Limpiando configuración...
php artisan config:clear
php artisan cache:clear

echo.
echo 5️⃣ Verificando que la base de datos esté disponible...
php artisan migrate:status

echo.
echo 6️⃣ Iniciando Queue Worker (necesario para events)...
start "Queue Worker" php artisan queue:work --timeout=0

echo.
echo 7️⃣ Iniciando Laravel Reverb...
timeout /t 2 /nobreak > nul
start "Laravel Reverb" php artisan reverb:start --host=127.0.0.1 --port=8080

echo.
echo 8️⃣ Esperando que los servicios se inicien...
timeout /t 5 /nobreak > nul

echo.
echo 9️⃣ Verificando que los servicios estén corriendo...
netstat -an | findstr :8080

echo.
echo 🔟 Test de conectividad...
echo Probando conexión WebSocket...

echo.
echo ========================================
echo ✅ SERVICIOS INICIADOS
echo ========================================
echo.
echo 📋 URLs para probar:
echo    • Laravel: http://localhost:8000
echo    • WebSocket Test: http://localhost:8000/websocket-test.html
echo    • WebSocket Server: ws://localhost:8080
echo.
echo 🔧 Si aún hay problemas:
echo    1. Verifica que no haya antivirus bloqueando el puerto 8080
echo    2. Ejecuta como Administrador si es necesario
echo    3. Revisa los logs en storage/logs/laravel.log
echo.
echo 🚀 Abriendo interfaz de test...
start http://localhost:8000/websocket-test.html

pause
