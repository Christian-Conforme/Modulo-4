# 🚀 Sistema Laravel + GraphQL + WebSocket - Guía Completa

## 📋 Inicio Rápido

### Opción 1: Inicio Completo (Recomendado)
```bash
start-system-complete.bat
```
- ✅ Verificación completa del sistema
- ✅ Tests automáticos
- ✅ Información detallada de todos los servicios

### Opción 2: Inicio Rápido
```bash
start-quick.bat
```
- ✅ Inicio rápido sin verificaciones
- ✅ Solo servicios esenciales

## 🌐 URLs Principales

| Servicio | URL | Descripción |
|----------|-----|-------------|
| **Laravel App** | http://127.0.0.1:8000 | Aplicación principal |
| **GraphiQL** | http://127.0.0.1:8000/graphiql | ⭐ Interface GraphQL |
| **GraphQL API** | http://127.0.0.1:8000/graphql | Endpoint GraphQL |
| **Debug WebSocket** | http://127.0.0.1:8000/debug-websocket.html | Panel de debug |
| **WebSocket Server** | ws://127.0.0.1:8080 | Servidor WebSocket |

## 🧪 Pruebas Rápidas

### 1. Probar GraphQL con GraphiQL
1. Abre: **http://127.0.0.1:8000/graphiql**
2. Ejecuta estas queries:

**Listar empleados:**
```graphql
{
  empleados {
    id_empleado
    nombre
    correo
    cargo
  }
}
```

**Listar vehículos:**
```graphql
{
  vehiculos {
    id_vehiculo
    marca
    modelo
    anio
    estado
    placa
  }
}
```

**Crear empleado:**
```graphql
mutation {
  crearEmpleado(input: {
    nombre: "Juan Test"
    correo: "juan.test@empresa.com"
    cargo: "Desarrollador"
  }) {
    id_empleado
    nombre
    correo
  }
}
```

### 2. Probar WebSocket + GraphQL
1. Abre: **http://127.0.0.1:8000/debug-websocket.html**
2. Conecta WebSocket (botón "Conectar")
3. Ejecuta mutations GraphQL
4. Observa eventos en tiempo real

### 3. Test Completo del Sistema
1. Ejecuta mutations en GraphiQL
2. Verifica que aparezcan eventos WebSocket en debug panel
3. Confirma que los datos se guardan en base de datos

## 📊 Estructura de Datos GraphQL

### Tipos Disponibles
- **Empleado** - Gestión de empleados
- **Vehiculo** - Gestión de vehículos
- **Sucursal** - Gestión de sucursales
- **User** - Gestión de usuarios
- **Rol** - Gestión de roles
- **VehiculoSucursal** - Asignaciones vehículo-sucursal

### Operaciones CRUD Completas
Cada tipo soporta:
- ✅ **Create** - `crear[Tipo](input: ...)`
- ✅ **Read** - `[tipos]` y `[tipo](id: ...)`
- ✅ **Update** - `actualizar[Tipo](id: ..., input: ...)`
- ✅ **Delete** - `eliminar[Tipo](id: ...)`

## 🔧 Comandos Útiles

### Desarrollo
```bash
# Ver esquema GraphQL
php artisan lighthouse:print-schema

# Ejecutar tests
php artisan test --filter GraphQL

# Limpiar cache
php artisan config:clear && php artisan cache:clear

# Ver logs en tiempo real
php artisan log-viewer
```

### Debugging
```bash
# Verificar conexión DB
php artisan migrate:status

# Verificar configuración
php artisan config:show database

# Reiniciar queue worker
php artisan queue:restart
```

## 🚨 Solución de Problemas

### Error: "GraphQL Request must include at least one of those two parameters"
- ✅ **Solucionado**: Agregada ruta GET para `/graphql`
- 💡 Usa GraphiQL para queries interactivas

### WebSocket no conecta
1. Verifica que Laravel Reverb esté ejecutándose (puerto 8080)
2. Revisa firewall/antivirus
3. Usa el panel debug para diagnosticar

### GraphQL no responde
1. Verifica que Laravel Serve esté ejecutándose (puerto 8000)
2. Confirma que la base de datos esté conectada
3. Revisa logs en `storage/logs/laravel.log`

## 📈 Estado del Sistema

### Tests ✅
- **50/50 tests GraphQL** pasando
- **511 assertions** exitosas
- **Cobertura completa** CRUD + WebSocket

### Funcionalidades ✅
- ✅ GraphQL API completa
- ✅ WebSocket eventos en tiempo real
- ✅ Interface GraphiQL
- ✅ Panel de debug
- ✅ Sistema de queue para eventos
- ✅ Base de datos PostgreSQL
- ✅ Validaciones completas

### Servicios Activos ✅
- ✅ Laravel Serve (puerto 8000)
- ✅ Laravel Reverb WebSocket (puerto 8080)
- ✅ Queue Worker (background)
- ✅ PostgreSQL Database (Neon cloud)

---

## 🎯 Workflow Recomendado

1. **Inicia el sistema:** `start-system-complete.bat`
2. **Abre GraphiQL:** http://127.0.0.1:8000/graphiql
3. **Explora el schema** usando el explorador lateral
4. **Ejecuta queries** para familiarizarte con los datos
5. **Prueba mutations** para crear/modificar datos
6. **Abre debug panel** para ver eventos WebSocket
7. **Desarrolla tu aplicación** usando la API GraphQL

¡El sistema está completamente funcional y listo para desarrollo! 🚀
