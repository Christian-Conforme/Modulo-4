# 🔌 Guía WebSocket - Laravel Reverb

## ❌ **IMPORTANTE: Postman NO es Compatible**

**Laravel Reverb usa el protocolo Pusher, NO WebSocket estándar.**
**Postman Desktop espera WebSocket RFC 6455, por eso obtienes Error 404.**

## ✅ **Soluciones que SÍ Funcionan**

### **Opción 1: WebSocket Tester (Recomendado)**
```
http://127.0.0.1:8000/websocket-tester.html
```
- ✅ **Funciona perfectamente** con Laravel Reverb
- ✅ **Interfaz completa** con conexión/desconexión
- ✅ **Manejo de errores** y reconexión automática
- ✅ **Diseñada específicamente** para este proyecto

### **Opción 2: Debug Panel**
```
http://127.0.0.1:8000/debug-websocket.html
```

### **Opción 3: Browser DevTools**
```javascript
// En Console del navegador (F12)
const ws = new WebSocket('ws://127.0.0.1:8080');
ws.onopen = () => console.log('✅ Conectado a Laravel Reverb');
ws.onmessage = (e) => console.log('📥 Mensaje:', e.data);
ws.onerror = (e) => console.log('❌ Error:', e);
```

### 4. Enviar Mensajes de Prueba

**Mensaje Simple:**
```json
{
  "type": "ping",
  "data": "test message"
}
```

**Evento de Laravel:**
```json
{
  "event": "test-event",
  "data": {
    "message": "Hello from Postman!"
  }
}
```

### 5. Monitorear Mensajes Recibidos

El panel inferior de Postman mostrará:
- **Mensajes enviados** (color azul)
- **Mensajes recibidos** (color verde)
- **Errores de conexión** (color rojo)

## Variables de Postman Configuradas

Tu colección ya incluye:
```json
{
  "websocket_url": "ws://127.0.0.1:8080",
  "websocket_tester_url": "http://127.0.0.1:8000/websocket-tester.html"
}
```

## Alternativas Si No Funciona

### Opción 1: WebSocket Tester Web
```
http://127.0.0.1:8000/websocket-tester.html
```

### Opción 2: Browser DevTools
```javascript
// En Console del navegador
const ws = new WebSocket('ws://127.0.0.1:8080');
ws.onopen = () => console.log('✅ Conectado');
ws.onmessage = (e) => console.log('📥 Recibido:', e.data);
ws.onerror = (e) => console.log('❌ Error:', e);

// Enviar mensaje
ws.send(JSON.stringify({type: 'test', data: 'Hello!'}));
```

### Opción 3: Verificar Versión Postman
```
Help > About > Version
```
**Necesitas**: v10.18.0 o superior

## Troubleshooting

### Error: "WebSocket not supported"
- ❌ **Postman Web** - No soporta WebSockets
- ✅ **Postman Desktop** - Sí soporta WebSockets

### Error: "Connection refused"
- Verificar que `php artisan reverb:start` esté ejecutándose
- Verificar puerto 8080 disponible: `netstat -an | findstr 8080`

### Error: "Invalid URL"
- URL correcta: `ws://127.0.0.1:8080` (sin rutas adicionales)
- NO usar: `ws://127.0.0.1:8080/ws`

## Comandos Útiles

```bash
# Verificar estado de servidores
netstat -an | findstr "8000\|8080"

# Reiniciar Laravel Reverb
# Ctrl+C para detener
php artisan reverb:start

# Ver logs de WebSocket
php artisan reverb:start --verbose
```

## URLs de Testing Completas

| Herramienta | URL |
|-------------|-----|
| **Postman Desktop** | `ws://127.0.0.1:8080` |
| **WebSocket Tester** | `http://127.0.0.1:8000/websocket-tester.html` |
| **Debug Panel** | `http://127.0.0.1:8000/debug-websocket.html` |
| **GraphiQL** | `http://127.0.0.1:8000/graphiql` |
