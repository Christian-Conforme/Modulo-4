@echo off
echo 🚀 Iniciando servicios para WebSocket...
echo.

echo 1. Iniciando Laravel Serve (puerto 8000)...
start "Laravel Serve" cmd /k "cd /d %~dp0 && php artisan serve"

echo 2. Esperando 3 segundos...
timeout /t 3 /nobreak >nul

echo 3. Iniciando Laravel Reverb (puerto 8080)...
start "Laravel Reverb" cmd /k "cd /d %~dp0 && php artisan reverb:start"

echo 4. Esperando 3 segundos...
timeout /t 3 /nobreak >nul

echo 5. Iniciando Queue Worker (procesa eventos WebSocket)...
start "Queue Worker" cmd /k "cd /d %~dp0 && php artisan queue:work --verbose"

echo.
echo ✅ Todos los servicios iniciados:
echo    - Laravel Serve: http://127.0.0.1:8000
echo    - Laravel Reverb: ws://127.0.0.1:8080
echo    - Queue Worker: Procesando eventos
echo.
echo 🔍 Para verificar eventos WebSocket:
echo    1. Abre: http://127.0.0.1:8000/debug-websocket.html
echo    2. Abre consola del navegador (F12)
echo    3. Crea una entidad y verifica los logs
echo.
pause
