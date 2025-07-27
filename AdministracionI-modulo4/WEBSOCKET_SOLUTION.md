# 🔧 SOLUCIÓN STEP-BY-STEP PARA ERROR WEBSOCKET

## ❌ Error que estás viendo:
```
WebSocket connection to 'ws://127.0.0.1:8080/app/gzbmxzp7oozsmb8cor5t?protocol=7&client=js&version=8.2.0&flash=false' failed
```

## ✅ SOLUCIÓN PASO A PASO:

### PASO 1: Verificar configuración
Abre el archivo `.env` y verifica estas líneas:
```env
QUEUE_CONNECTION=sync
BROADCAST_CONNECTION=reverb
REVERB_APP_KEY=gzbmxzp7oozsmb8cor5t
REVERB_HOST=127.0.0.1
REVERB_PORT=8080
```

### PASO 2: Limpiar configuración
```bash
php artisan config:clear
php artisan cache:clear
```

### PASO 3: Matar procesos en puerto 8080
```bash
# En Windows:
netstat -ano | findstr :8080
# Si hay procesos, matar con: taskkill /F /PID [numero_del_proceso]

# O simplemente cierra todas las ventanas de terminal que tengas abiertas
```

### PASO 4: Iniciar servicios en el ORDEN CORRECTO

**Terminal 1** - Iniciar Laravel Reverb:
```bash
php artisan reverb:start --host=127.0.0.1 --port=8080
```
Debes ver algo como:
```
Starting server on 127.0.0.1:8080
Reverb server started successfully.
```

**Terminal 2** - Iniciar Laravel Server:
```bash
php artisan serve
```

### PASO 5: Probar la conexión
1. Ve a: `http://localhost:8000/websocket-test.html`
2. Haz clic en "🔧 Diagnosticar Conexión"
3. Luego haz clic en "Conectar"

### PASO 6: Si sigue fallando

#### Opción A: Cambiar puerto
En `.env` cambia:
```env
REVERB_PORT=8081
```
Y reinicia Reverb:
```bash
php artisan reverb:start --host=127.0.0.1 --port=8081
```

#### Opción B: Verificar firewall
- Windows Defender podría estar bloqueando el puerto
- Ejecuta CMD como Administrador y prueba

#### Opción C: Test manual con navegador
Abre la consola del navegador (F12) y ejecuta:
```javascript
const testSocket = new WebSocket('ws://127.0.0.1:8080/app/gzbmxzp7oozsmb8cor5t');
testSocket.onopen = () => console.log('✅ Conectado!');
testSocket.onerror = (e) => console.log('❌ Error:', e);
```

### PASO 7: Verificar que todo funciona
Una vez conectado el WebSocket:
1. En la interfaz web, llena los campos de "Crear Usuario"
2. Haz clic en "Crear Usuario (GraphQL)"
3. Deberías ver:
   - ✅ Respuesta GraphQL exitosa
   - 🎉 Evento WebSocket "usuario.creado" en el log

## 🚨 ERRORES COMUNES:

### Error: "Server not available"
**Solución**: Reverb no está corriendo
```bash
php artisan reverb:start
```

### Error: "Connection refused"
**Solución**: Puerto bloqueado o ya en uso
```bash
netstat -ano | findstr :8080
# Mata el proceso o cambia el puerto
```

### Error: "No events received"
**Solución**: QUEUE_CONNECTION debe ser 'sync' para testing
```env
QUEUE_CONNECTION=sync
```

## ✅ CONFIRMACIÓN FINAL:

Cuando todo funcione correctamente verás:
1. ✅ WebSocket conectado en la interfaz
2. 🎉 Eventos aparecen en el log cuando creas/actualizas/eliminas usuarios
3. 📡 Estado "Conectado a Laravel Reverb" en verde

¡Sígueme estos pasos y debería funcionar! 🚀
