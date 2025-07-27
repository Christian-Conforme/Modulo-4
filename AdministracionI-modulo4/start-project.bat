@echo off
echo 🚀 Iniciando Sistema de Administración de Vehículos y Empleados
echo.

echo 📋 Verificando sistema...
php artisan project:start

echo.
echo 🌐 Iniciando servicios...
echo.

echo 📡 Iniciando WebSocket Server (Reverb)...
start "WebSocket Server" cmd /k "php artisan reverb:start"

timeout /t 3 /nobreak > nul

echo 🖥️ Iniciando Laravel Server...
start "Laravel Server" cmd /k "php artisan serve"

timeout /t 5 /nobreak > nul

echo 🌍 Abriendo Dashboard en navegador...
start http://127.0.0.1:8000/dashboard

echo.
echo ✅ Sistema iniciado correctamente!
echo.
echo 💡 Comandos útiles:
echo    - Generar eventos: php artisan test:asignaciones --count=5
echo    - Ver logs WebSocket: Revisar la ventana "WebSocket Server"
echo    - Ver logs Laravel: Revisar la ventana "Laravel Server"
echo.
echo 🔗 URLs importantes:
echo    - Dashboard: http://127.0.0.1:8000/dashboard
echo    - GraphQL: http://127.0.0.1:8000/graphiql
echo    - WebSocket: ws://127.0.0.1:8080
echo.
pause
