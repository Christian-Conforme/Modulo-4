#!/bin/bash

# Script para iniciar todos los servicios de la arquitectura de microservicios
# Administración I - Módulo 4

echo "🚀 Iniciando Arquitectura de Microservicios - Sistema de Administración"
echo "================================================================="

# Función para verificar si un puerto está en uso
check_port() {
    local port=$1
    if netstat -an | grep ":$port " > /dev/null 2>&1; then
        echo "⚠️  Puerto $port ya está en uso"
        return 1
    fi
    return 0
}

# Función para iniciar un servicio en una nueva ventana de terminal
start_service() {
    local service_name=$1
    local directory=$2
    local command=$3
    local port=$4
    
    echo "📦 Iniciando $service_name en puerto $port..."
    
    if check_port $port; then
        # Crear comando para PowerShell
        powershell -Command "Start-Process powershell -ArgumentList '-NoExit', '-Command', 'cd \"$directory\"; $command; Write-Host \"$service_name iniciado en puerto $port\"; Read-Host \"Presiona Enter para continuar\"' -WindowStyle Normal"
        sleep 2
        echo "✅ $service_name iniciado"
    else
        echo "❌ No se pudo iniciar $service_name - puerto $port ocupado"
    fi
}

# Verificar dependencias
echo "🔍 Verificando dependencias..."

# Node.js
if ! command -v node &> /dev/null; then
    echo "❌ Node.js no está instalado"
    exit 1
fi

# PHP
if ! command -v php &> /dev/null; then
    echo "❌ PHP no está instalado"
    exit 1
fi

# Composer
if ! command -v composer &> /dev/null; then
    echo "❌ Composer no está instalado"
    exit 1
fi

echo "✅ Todas las dependencias están instaladas"

# Directorio base
BASE_DIR="d:/Modulo-4/AdministracionI-modulo4"

# 1. Instalar dependencias si no existen
echo "📦 Verificando dependencias de Node.js..."

if [ ! -d "$BASE_DIR/graphql-gateway/node_modules" ]; then
    echo "📦 Instalando dependencias de GraphQL Gateway..."
    cd "$BASE_DIR/graphql-gateway"
    npm install
fi

if [ ! -d "$BASE_DIR/websocket-service/node_modules" ]; then
    echo "📦 Instalando dependencias de WebSocket Service..."
    cd "$BASE_DIR/websocket-service"
    npm install
fi

# 2. Compilar TypeScript
echo "🔨 Compilando servicios TypeScript..."

cd "$BASE_DIR/graphql-gateway"
npm run build

cd "$BASE_DIR/websocket-service"
npm run build

# 3. Iniciar Laravel (API principal)
echo "🔥 Iniciando Laravel API..."
start_service "Laravel API" "$BASE_DIR" "php artisan serve --host=0.0.0.0 --port=8000" 8000

# 4. Iniciar WebSocket Service
echo "📡 Iniciando WebSocket Service..."
start_service "WebSocket Service" "$BASE_DIR/websocket-service" "npm run dev" 3001

# 5. Iniciar GraphQL Gateway
echo "🌐 Iniciando GraphQL Gateway..."
start_service "GraphQL Gateway" "$BASE_DIR/graphql-gateway" "npm run dev" 4000

# 6. Iniciar Dashboard PHP
echo "📊 Iniciando Dashboard PHP..."
start_service "Dashboard PHP" "$BASE_DIR/dashboard" "php -S localhost:3000 server.php" 3000

echo ""
echo "🎉 Todos los servicios han sido iniciados!"
echo "================================================================="
echo "📋 URLs de acceso:"
echo "   • Laravel API:      http://localhost:8000"
echo "   • WebSocket Service: http://localhost:3001"
echo "   • GraphQL Gateway:   http://localhost:4000/graphql"
echo "   • Dashboard:         http://localhost:3000"
echo ""
echo "📖 Documentación GraphQL: http://localhost:4000/graphql"
echo "🔍 Health Checks:"
echo "   • Laravel:    http://localhost:8000/api/health"
echo "   • WebSocket:  http://localhost:3001/health"
echo "   • GraphQL:    http://localhost:4000/health"
echo "   • Dashboard:  http://localhost:3000/api/system-info"
echo ""
echo "⚡ Para probar notificaciones en tiempo real:"
echo "   1. Abre el Dashboard en tu navegador"
echo "   2. Realiza operaciones CRUD via GraphQL o Laravel API"
echo "   3. Observa las notificaciones en tiempo real en el Dashboard"
echo ""
echo "🛑 Para detener todos los servicios, cierra las ventanas de terminal"
