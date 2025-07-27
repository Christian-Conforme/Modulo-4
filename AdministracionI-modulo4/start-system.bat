@echo off
echo ==================================================
echo     Sistema de Administracion - Microservicios
echo     GraphQL Gateway + WebSockets + Dashboard
echo ==================================================
echo.

echo [1/4] Iniciando servidor Laravel...
start "Laravel Server" cmd /k "php artisan serve --host=localhost --port=8000"
timeout /t 3 /nobreak >nul

echo [2/4] Iniciando servidor Reverb (WebSockets)...
start "Reverb WebSocket Server" cmd /k "php artisan reverb:start --host=127.0.0.1 --port=8080"
timeout /t 3 /nobreak >nul

echo [3/4] Iniciando procesador de colas...
start "Queue Worker" cmd /k "php artisan queue:work --tries=3"
timeout /t 2 /nobreak >nul

echo [4/4] Ejecutando migraciones y seeders...
php artisan migrate --force
php artisan db:seed --force

echo.
echo ==================================================
echo     SISTEMA INICIADO CORRECTAMENTE
echo ==================================================
echo.
echo Servicios disponibles:
echo   - Laravel App:        http://localhost:8000
echo   - GraphQL Endpoint:   http://localhost:8000/graphql
echo   - Dashboard:          http://localhost:8000/dashboard
echo   - WebSocket Server:   ws://localhost:8080
echo.
echo GraphQL Playground:     http://localhost:8000/graphiql
echo.
echo Presiona cualquier tecla para abrir el dashboard...
pause >nul

start "" "http://localhost:8000/dashboard"

echo.
echo Para detener todos los servicios, cierra todas las ventanas de comandos.
echo.
pause
