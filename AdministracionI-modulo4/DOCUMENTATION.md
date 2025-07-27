# 🚀 Sistema GraphQL + WebSocket Completo

## 📋 Descripción General

Este sistema implementa una solución completa de administración con:
- **GraphQL API** para operaciones CRUD
- **WebSocket** para notificaciones en tiempo real
- **Laravel Reverb** como servidor WebSocket
- **Lighthouse GraphQL** para el esquema y resolvers
- **Broadcasting** para eventos en tiempo real

## 🏗️ Arquitectura del Sistema

### Entidades Implementadas
- **👥 Usuarios** - Gestión de usuarios del sistema
- **👨‍💼 Empleados** - Personal de la empresa
- **🏷️ Roles** - Roles y permisos
- **🚗 Vehículos** - Flota de vehículos
- **🏢 Sucursales** - Ubicaciones de la empresa
- **🔗 VehículoSucursal** - Relación vehículos-sucursales

### Componentes Técnicos
```
├── GraphQL Schema (graphql/schema.graphql)
├── Resolvers
│   ├── Queries (app/GraphQL/Queries/)
│   └── Mutations (app/GraphQL/Mutations/)
├── Events (app/Events/)
├── Models (app/Models/)
└── Tests (tests/Feature/)
```

## 🔧 Instalación y Configuración

### 1. Requisitos Previos
- PHP 8.2+
- Composer
- PostgreSQL
- Node.js (para Vite)

### 2. Configuración Automática
```bash
# Ejecutar script de inicio automático
start_system.bat
```

### 3. Configuración Manual

#### Base de Datos
```bash
php artisan migrate:fresh --seed
```

#### Servicios WebSocket
```bash
# Terminal 1: WebSocket Server
php artisan reverb:start

# Terminal 2: Queue Worker
php artisan queue:work

# Terminal 3: Laravel Server
php artisan serve
```

## 📊 GraphQL API

### Endpoint Principal
```
POST http://localhost:8000/graphql
```

### Operaciones Disponibles

#### 👥 Usuarios
```graphql
# Crear Usuario
mutation CrearUser($input: UserInput!) {
    crearUser(input: $input) {
        id_usuario
        username
        empleado_id
        rol_id
    }
}

# Listar Usuarios
query ObtenerUsuarios {
    users {
        id_usuario
        username
        rol { nombre }
        empleado { nombre }
    }
}

# Actualizar Usuario
mutation ActualizarUser($id: ID!, $input: UserInput!) {
    actualizarUser(id_usuario: $id, input: $input) {
        id_usuario
        username
    }
}

# Eliminar Usuario
mutation EliminarUser($id: ID!) {
    eliminarUser(id_usuario: $id) {
        success
        message
    }
}
```

#### 👨‍💼 Empleados
```graphql
# Crear Empleado
mutation CrearEmpleado($input: EmpleadoInput!) {
    crearEmpleado(input: $input) {
        id_empleado
        nombre
        cargo
        correo
    }
}

# Listar Empleados
query ObtenerEmpleados {
    empleados {
        id_empleado
        nombre
        cargo
        correo
        telefono
    }
}
```

#### 🏷️ Roles
```graphql
# Crear Rol
mutation CrearRol($input: RolInput!) {
    crearRol(input: $input) {
        id_rol
        nombre
        descripcion
    }
}

# Listar Roles
query ObtenerRoles {
    roles {
        id_rol
        nombre
        descripcion
    }
}
```

#### 🚗 Vehículos
```graphql
# Crear Vehículo
mutation CrearVehiculo($input: VehiculoInput!) {
    crearVehiculo(input: $input) {
        id_vehiculo
        placa
        marca
        modelo
        estado
    }
}

# Listar Vehículos
query ObtenerVehiculos {
    vehiculos {
        id_vehiculo
        placa
        marca
        modelo
        anio
        estado
    }
}
```

#### 🏢 Sucursales
```graphql
# Crear Sucursal
mutation CrearSucursal($input: SucursalInput!) {
    crearSucursal(input: $input) {
        id_sucursal
        nombre
        direccion
        ciudad
    }
}

# Listar Sucursales
query ObtenerSucursales {
    sucursales {
        id_sucursal
        nombre
        direccion
        ciudad
        telefono
    }
}
```

## 📡 WebSocket Events

### Canales Disponibles
- `usuarios` - Eventos de usuarios
- `empleados` - Eventos de empleados
- `roles` - Eventos de roles
- `vehiculos` - Eventos de vehículos
- `sucursales` - Eventos de sucursales
- `dashboard` - Eventos generales del dashboard

### Tipos de Eventos
- `{entidad}.creado` - Cuando se crea una entidad
- `{entidad}.actualizado` - Cuando se actualiza una entidad
- `{entidad}.eliminado` - Cuando se elimina una entidad

### Ejemplo de Conexión WebSocket (JavaScript)
```javascript
const pusher = new Pusher('app-key', {
    wsHost: '127.0.0.1',
    wsPort: 8080,
    forceTLS: false
});

const channel = pusher.subscribe('usuarios');
channel.bind('usuario.creado', (data) => {
    console.log('Nuevo usuario:', data.user);
});
```

## 🧪 Testing

### Tests Automatizados
```bash
# Todos los tests
php artisan test

# Test específico de usuarios
php artisan test tests/Feature/UserGraphQLWebSocketTest.php

# Ejecutor personalizado
php run_all_tests.php
```

### Test Manual con Interfaz Web
Acceder a: `http://localhost:8000/websocket-test.html`

Funcionalidades de la interfaz:
- ✅ Operaciones CRUD para todas las entidades
- ✅ Visualización de respuestas GraphQL
- ✅ Logs de eventos WebSocket en tiempo real
- ✅ Estado de conexión WebSocket
- ✅ Tabs organizados por entidad

## 📁 Estructura de Archivos

### GraphQL
```
graphql/
└── schema.graphql              # Esquema completo GraphQL
```

### Resolvers
```
app/GraphQL/
├── Queries/
│   ├── User.php               # Query individual de usuario
│   ├── Users.php              # Query lista de usuarios
│   ├── Empleado.php           # Query individual de empleado
│   ├── Empleados.php          # Query lista de empleados
│   └── ...                    # Más queries
└── Mutations/
    ├── CrearUser.php          # Crear usuario
    ├── ActualizarUser.php     # Actualizar usuario
    ├── EliminarUser.php       # Eliminar usuario
    └── ...                    # Más mutations
```

### Events
```
app/Events/
├── UserCreado.php             # Evento creación usuario
├── UserActualizado.php        # Evento actualización usuario
├── UserEliminado.php          # Evento eliminación usuario
└── ...                        # Más eventos
```

### Models
```
app/Models/
├── User.php                   # Modelo Usuario
├── Empleado.php               # Modelo Empleado
├── Rol.php                    # Modelo Rol
├── Vehiculo.php               # Modelo Vehículo
├── Sucursal.php               # Modelo Sucursal
└── VehiculoSucursal.php       # Modelo relación
```

### Tests
```
tests/Feature/
├── GraphQLWebSocketTestCase.php          # Clase base para tests
├── UserGraphQLWebSocketTest.php          # Tests de usuarios
├── EmpleadoGraphQLWebSocketTest.php      # Tests de empleados
└── ...                                   # Más tests
```

## 🔄 Flujo de Operaciones

### 1. Creación de Entidad
```
Cliente → GraphQL Mutation → Resolver → Model → Database
                                ↓
                          Event Dispatch → WebSocket → Clientes Conectados
```

### 2. Consulta de Datos
```
Cliente → GraphQL Query → Resolver → Model → Database → Respuesta
```

### 3. Notificación en Tiempo Real
```
Operación CRUD → Event → Broadcasting → WebSocket Server → Clientes
```

## 🛠️ Configuración Avanzada

### Variables de Entorno
```env
# GraphQL
LIGHTHOUSE_SCHEMA_CACHE_ENABLE=false

# WebSocket
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=257917
REVERB_APP_KEY=gzbmxzp7oozsmb8cor5t
REVERB_APP_SECRET=6rudunxxuye33wsyffex
REVERB_HOST=127.0.0.1
REVERB_PORT=8080

# Queue para eventos
QUEUE_CONNECTION=database
```

### Comandos Útiles
```bash
# Limpiar cachés
php artisan config:clear
php artisan lighthouse:clear-cache

# Validar esquema GraphQL
php artisan lighthouse:validate-schema

# Ver rutas GraphQL
php artisan lighthouse:print-schema

# Monitor de colas
php artisan queue:monitor
```

## 🚦 Estado del Sistema

### ✅ Completamente Implementado
- [x] Modelos y migraciones
- [x] GraphQL Schema completo
- [x] Resolvers para todas las entidades
- [x] Eventos WebSocket
- [x] Tests automatizados
- [x] Interfaz web de testing
- [x] Documentación completa

### 📊 Entidades Funcionales
- [x] **Usuarios** - CRUD + WebSocket
- [x] **Empleados** - CRUD + WebSocket
- [x] **Roles** - CRUD + WebSocket
- [x] **Vehículos** - CRUD + WebSocket
- [x] **Sucursales** - CRUD + WebSocket
- [x] **VehículoSucursal** - CRUD + WebSocket

## 🔍 Troubleshooting

### Problemas Comunes

#### WebSocket no conecta
```bash
# Verificar puerto disponible
netstat -an | findstr :8080

# Reiniciar Reverb
php artisan reverb:restart
```

#### GraphQL no responde
```bash
# Verificar esquema
php artisan lighthouse:validate-schema

# Limpiar caché
php artisan lighthouse:clear-cache
```

#### Tests fallan
```bash
# Verificar base de datos de testing
php artisan migrate:fresh --env=testing

# Ejecutar test específico
php artisan test tests/Feature/UserGraphQLWebSocketTest.php --verbose
```

## 📞 Soporte

Para más información o soporte:
- Revisar logs: `storage/logs/laravel.log`
- Verificar implementación: `php verify_implementation.php`
- Test completo: `php test_user_complete.php`
- Interfaz de pruebas: `http://localhost:8000/websocket-test.html`

---

**🎉 Sistema GraphQL + WebSocket completamente funcional y listo para producción!**
