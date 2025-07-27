@echo off
REM Script para iniciar todos los servicios de la arquitectura de microservicios
REM Administración I - Módulo 4

echo 🚀 Iniciando Arquitectura de Microservicios - Sistema de Administración
echo =================================================================

REM Directorio base
set BASE_DIR=d:\Modulo-4\AdministracionI-modulo4

REM Verificar si Node.js está instalado
node --version >nul 2>&1
if errorlevel 1 (
    echo ❌ Node.js no está instalado
    pause
    exit /b 1
)

REM Verificar si PHP está instalado
php --version >nul 2>&1
if errorlevel 1 (
    echo ❌ PHP no está instalado
    pause
    exit /b 1
)

echo ✅ Dependencias verificadas

REM 1. Instalar dependencias de GraphQL Gateway si no existen
if not exist "%BASE_DIR%\graphql-gateway\node_modules" (
    echo 📦 Instalando dependencias de GraphQL Gateway...
    cd /d "%BASE_DIR%\graphql-gateway"
    call npm install
)

REM 2. Instalar dependencias de WebSocket Service si no existen
if not exist "%BASE_DIR%\websocket-service\node_modules" (
    echo 📦 Instalando dependencias de WebSocket Service...
    cd /d "%BASE_DIR%\websocket-service"
    call npm install
)

REM 3. Compilar TypeScript
echo 🔨 Compilando servicios TypeScript...
cd /d "%BASE_DIR%\graphql-gateway"
call npm run build

cd /d "%BASE_DIR%\websocket-service"
call npm run build

REM 4. Iniciar Laravel API
echo 🔥 Iniciando Laravel API en puerto 8000...
start "Laravel API" cmd /k "cd /d %BASE_DIR% && php artisan serve --host=0.0.0.0 --port=8000"
timeout /t 3 /nobreak >nul

REM 5. Iniciar WebSocket Service
echo 📡 Iniciando WebSocket Service en puerto 3001...
start "WebSocket Service" cmd /k "cd /d %BASE_DIR%\websocket-service && npm run dev"
timeout /t 3 /nobreak >nul

REM 6. Iniciar GraphQL Gateway
echo 🌐 Iniciando GraphQL Gateway en puerto 4000...
start "GraphQL Gateway" cmd /k "cd /d %BASE_DIR%\graphql-gateway && npm run dev"
timeout /t 3 /nobreak >nul

REM 7. Iniciar Dashboard PHP
echo 📊 Iniciando Dashboard PHP en puerto 3000...
start "Dashboard PHP" cmd /k "cd /d %BASE_DIR%\dashboard && php -S localhost:3000 server.php"
timeout /t 3 /nobreak >nul

echo.
echo 🎉 Todos los servicios han sido iniciados!
echo =================================================================
echo 📋 URLs de acceso:
echo    • Laravel API:      http://localhost:8000
echo    • WebSocket Service: http://localhost:3001
echo    • GraphQL Gateway:   http://localhost:4000/graphql
echo    • Dashboard:         http://localhost:3000
echo.
echo 📖 Documentación GraphQL: http://localhost:4000/graphql
echo 🔍 Health Checks:
echo    • Laravel:    http://localhost:8000/api/health
echo    • WebSocket:  http://localhost:3001/health  
echo    • GraphQL:    http://localhost:4000/health
echo    • Dashboard:  http://localhost:3000/api/system-info
echo.
echo ⚡ Para probar notificaciones en tiempo real:
echo    1. Abre el Dashboard en tu navegador
echo    2. Realiza operaciones CRUD via GraphQL o Laravel API
echo    3. Observa las notificaciones en tiempo real en el Dashboard
echo.
echo 🛑 Para detener todos los servicios, cierra las ventanas de comandos
echo.
pause
