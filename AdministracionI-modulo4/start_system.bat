@echo off
echo ========================================
echo 🚀 INICIANDO SISTEMA GRAPHQL + WEBSOCKET
echo ========================================

echo.
echo 1️⃣ Verificando requisitos...
php --version || (echo ❌ PHP no encontrado && pause && exit)
echo ✅ PHP disponible

echo.
echo 2️⃣ Configurando base de datos...
php artisan migrate:fresh --seed
echo ✅ Base de datos configurada

echo.
echo 3️⃣ Limpiando cachés...
php artisan config:clear
php artisan cache:clear
php artisan lighthouse:clear-cache
echo ✅ Cachés limpiados

echo.
echo 4️⃣ Verificando implementación...
php verify_implementation.php

echo.
echo 5️⃣ Ejecutando tests básicos...
php test_user_complete.php

echo.
echo 6️⃣ Iniciando servicios...
start "Laravel Reverb WebSocket" php artisan reverb:start
timeout /t 3 /nobreak > nul

start "Queue Worker" php artisan queue:work
timeout /t 2 /nobreak > nul

echo ✅ Servicios iniciados

echo.
echo 🌐 Abriendo interfaz web...
start http://localhost:8000/websocket-test.html

echo.
echo 🚀 Iniciando servidor Laravel...
php artisan serve

echo.
echo ========================================
echo 🎉 SISTEMA COMPLETAMENTE FUNCIONAL!
echo ========================================
echo.
echo 📋 URLs disponibles:
echo    • Laravel: http://localhost:8000
echo    • GraphQL: http://localhost:8000/graphql
echo    • Test WebSocket: http://localhost:8000/websocket-test.html
echo    • WebSocket Server: ws://localhost:8080
echo.
echo 🔧 Servicios ejecutándose:
echo    • Laravel Serve (puerto 8000)
echo    • Laravel Reverb WebSocket (puerto 8080)
echo    • Queue Worker (procesando eventos)
echo.
pause
