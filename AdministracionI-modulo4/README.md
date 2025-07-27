# 🚗 Sistema de Administración de Vehículos y Empleados

## 🎯 Proyecto Final - Microservicios con Laravel 12

Este proyecto implementa una **arquitectura completa en PHP** usando **Laravel 12** con:

- **🔗 GraphQL Gateway** (Lighthouse PHP) como punto único de entrada
- **📡 WebSockets en tiempo real** (Laravel Reverb nativo)
- **📊 Dashboard interactivo** con gráficos en tiempo real
- **🏗️ Arquitectura de microservicios** completamente en PHP
- **🔄 Sistema de eventos** para actualizaciones automáticas

## ✅ Características Implementadas

### 🔗 GraphQL Gateway (Lighthouse PHP)

- **Endpoint único**: `/graphql` para todas las operaciones
- **Schema completo** con tipos para Empleados, Vehículos, Sucursales, Usuarios y Asignaciones
- **Consultas optimizadas** con relaciones Eloquent
- **Validación automática** de datos de entrada
- **GraphiQL Playground** disponible en `/graphiql`

### 📡 WebSockets en Tiempo Real (Laravel Reverb)

- **Servidor WebSocket nativo** de Laravel en puerto 8080
- **Eventos automáticos** para operaciones CRUD
- **Canales específicos** por tipo de entidad
- **Reconexión automática** con manejo de errores
- **Broadcasting** configurado con Pusher Protocol

### 📊 Dashboard Interactivo

- **🎯 Tabla principal**: Asignaciones Vehículo-Sucursal
- **📈 Gráficos en tiempo real** con Chart.js
- **📊 Estadísticas actualizadas** cada 15 segundos
- **🔔 Feed de actividad** en tiempo real
- **🎨 Interfaz responsive** con Bootstrap 5
- **🧭 Navegación suave** entre secciones

## 🏗️ Arquitectura del Sistema

```text
┌─────────────────────────────────────────────────────────────┐
│                     CLIENTE (Navegador)                    │
│                                                             │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────┐ │
│  │   Dashboard     │  │   GraphQL       │  │  WebSocket  │ │
│  │   Principal     │  │   Queries       │  │   Cliente   │ │
│  │  (Bootstrap)    │  │   (Fetch API)   │  │  (Pusher)   │ │
│  └─────────────────┘  └─────────────────┘  └─────────────┘ │
└─────────────────────────────────────────────────────────────┘
                                │
                                ▼
┌─────────────────────────────────────────────────────────────┐
│                 SERVIDOR LARAVEL 12                        │
│                     Puerto: 8000                           │
│                                                             │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────┐ │
│  │   GraphQL       │  │   WebSocket     │  │  Dashboard  │ │
│  │   Lighthouse    │  │   Reverb        │  │   Routes    │ │
│  │   /graphql      │  │   Puerto: 8080  │  │   Blade     │ │
│  └─────────────────┘  └─────────────────┘  └─────────────┘ │
│                                                             │
│  ┌─────────────────────────────────────────────────────────┐ │
│  │                    MODELOS ELOQUENT                    │ │
│  │  Empleado • Vehiculo • Sucursal • User • VehiculoSucursal │
│  └─────────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────┘
                                │
                                ▼
┌─────────────────────────────────────────────────────────────┐
│                 BASE DE DATOS POSTGRESQL                   │
│                                                             │
│  empleado • vehiculo • sucursal • users • vehiculo_sucursal │
└─────────────────────────────────────────────────────────────┘
```

## 🚀 Instalación y Uso

### 1. Comando Único para Todo

```bash
php artisan project:start
```

### 2. Iniciar Servicios Manualmente

**Terminal 1 - WebSocket Server:**

```bash
php artisan reverb:start
```

**Terminal 2 - Laravel Server:**

```bash
php artisan serve
```

## 🌐 URLs de Acceso

| Servicio | URL | Descripción |
|----------|-----|-------------|
| 🏠 **Dashboard Principal** | <http://127.0.0.1:8000/dashboard> | **Dashboard completo funcional** |
| 🔗 GraphQL Endpoint | <http://127.0.0.1:8000/graphql> | API GraphQL |
| 🎮 GraphQL Playground | <http://127.0.0.1:8000/graphiql> | Explorador GraphQL |
| 📡 WebSocket Server | ws://127.0.0.1:8080 | Servidor WebSocket |
| 🧪 Test Dashboard | <http://127.0.0.1:8000/test-dashboard> | Pruebas GraphQL |

## 📊 Datos del Sistema

| Entidad | Cantidad | Descripción |
|---------|----------|-------------|
| 👥 Empleados | 1 | Empleados registrados |
| 🚗 Vehículos | 5 | Inventario de vehículos |
| 🏢 Sucursales | 3 | Oficinas/sucursales |
| 👤 Usuarios | 1 | Usuarios del sistema |
| 🔗 **Asignaciones** | **8** | **Tabla principal** |
| 🎭 Roles | 1 | Roles de usuario |

## 📈 Ejemplos de Consultas GraphQL

### Estadísticas Generales

```graphql
query {
  estadisticas {
    totalEmpleados
    totalVehiculos
    totalSucursales
    totalUsuarios
  }
}
```

### Asignaciones (Tabla Principal)

```graphql
query {
  vehiculoSucursales {
    id
    vehiculo {
      placa
      marca
      modelo
    }
    sucursal {
      nombre
      ciudad
    }
    fecha_asignacion
  }
}
```

### Empleados Completos

```graphql
query {
  empleados {
    id_empleado
    nombre
    correo
    telefono
    cargo
  }
}
```

## 🔔 Eventos WebSocket en Tiempo Real

- `vehiculo_sucursal.asignado` - Nueva asignación vehículo-sucursal
- `vehiculo_sucursal.actualizado` - Asignación modificada
- `empleado.creado` - Nuevo empleado registrado
- `vehiculo.estado_cambiado` - Cambio de estado de vehículo

## 🧪 Comandos de Prueba

### Generar Eventos de Prueba

```bash
php artisan test:websocket-events --count=5
```

### Generar Asignaciones de Prueba

```bash
php artisan test:asignaciones --count=3
```

## 🔧 Tecnologías Utilizadas

- **Framework**: Laravel 12
- **Base de Datos**: PostgreSQL
- **GraphQL**: Lighthouse PHP (nuwave/lighthouse ^6.62)
- **WebSockets**: Laravel Reverb (laravel/reverb ^1.0)
- **Frontend**: Blade + Bootstrap 5 + Chart.js
- **Cliente WebSocket**: Pusher JS + Laravel Echo

---

**✅ Sistema Completamente Funcional** - Dashboard con actualizaciones en tiempo real  
**🎯 Tabla Principal**: Asignaciones Vehículo-Sucursal  
**📡 WebSockets**: Eventos en tiempo real configurados  
**🔗 GraphQL**: API unificada funcionando perfectamente
