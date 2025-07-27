<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>🚗 Dashboard Sistema de Administración v{{ time() }}</title>
    
    <!-- Configuration for WebSocket -->
    <script>
        window.appConfig = {
            appKey: '{{ env('REVERB_APP_KEY') }}',
            wsHost: '{{ env('REVERB_HOST', '127.0.0.1') }}',
            wsPort: {{ env('REVERB_PORT', 8080) }},
            wssPort: {{ env('REVERB_PORT', 8080) }},
            scheme: '{{ env('REVERB_SCHEME', 'http') }}',
            csrfToken: '{{ csrf_token() }}',
            timestamp: {{ time() }}
        };
        console.log('🔧 WebSocket Config ({{ time() }}):', window.appConfig);
    </script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(120deg, #a8edea 0%, #fed6e3 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-container {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .metric-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            transition: transform 0.3s ease;
            border: none;
        }
        
        .metric-card:hover {
            transform: translateY(-5px);
        }
        
        .metric-card.success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        
        .metric-card.warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .metric-card.info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .table-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            overflow: hidden;
        }
        
        .table-card .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        .table-card .table {
            margin-bottom: 0;
        }
        
        .table-card .table thead {
            background: #f8f9fa;
        }
        
        .table-card .table td, 
        .table-card .table th {
            padding: 12px 15px;
            vertical-align: middle;
            border-color: #e9ecef;
        }
        
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-disponible {
            background: #d4edda;
            color: #155724;
        }
        
        .status-ocupado {
            background: #f8d7da;
            color: #721c24;
        }
        
        .status-mantenimiento {
            background: #fff3cd;
            color: #856404;
        }
        
        .real-time-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
            animation: pulse 2s infinite;
        }
        
        .indicator-connected {
            background-color: #28a745;
        }
        
        .indicator-connecting {
            background-color: #ffc107;
        }
        
        .indicator-disconnected {
            background-color: #dc3545;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
        
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            height: 400px;
        }
        
        .activity-feed {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            max-height: 400px;
            overflow-y: auto;
        }
        
        .activity-item {
            border-left: 4px solid #007bff;
            padding-left: 15px;
            margin-bottom: 15px;
            background: rgba(0,123,255,0.05);
            border-radius: 0 8px 8px 0;
            padding: 15px;
        }
        
        .activity-time {
            font-size: 0.8em;
            color: #6c757d;
        }
        
        .nav-tabs-custom {
            border-bottom: 2px solid #dee2e6;
        }
        
        .nav-tabs-custom .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            color: #6c757d;
            font-weight: 600;
            padding: 15px 20px;
        }
        
        .nav-tabs-custom .nav-link.active {
            color: #667eea;
            border-bottom-color: #667eea;
            background: none;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="main-container p-4">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="display-5 fw-bold text-primary mb-0">
                                <i class="fas fa-car-side me-2"></i>Dashboard Administrativo
                            </h1>
                            <p class="text-muted mb-0">Sistema de Gestión de Vehículos y Personal</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="real-time-indicator indicator-connecting" id="connection-status"></span>
                            <span class="me-3" id="connection-text">Conectando...</span>
                            <span class="badge bg-primary">En tiempo real</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Métricas Principales -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="metric-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Empleados</h5>
                                <h2 class="card-text" id="total-empleados">0</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="metric-card success">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Vehículos</h5>
                                <h2 class="card-text" id="total-vehiculos">0</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-car fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="metric-card warning">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Sucursales</h5>
                                <h2 class="card-text" id="total-sucursales">0</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-building fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="metric-card info">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Usuarios</h5>
                                <h2 class="card-text" id="total-usuarios">0</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-user-shield fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="chart-container">
                        <h5 class="mb-3"><i class="fas fa-chart-pie me-2"></i>Estado de Vehículos</h5>
                        <canvas id="vehiculos-chart"></canvas>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="activity-feed">
                        <h5 class="mb-3"><i class="fas fa-clock me-2"></i>Actividad Reciente</h5>
                        <div id="activity-feed">
                            <div class="activity-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong>Sistema iniciado</strong>
                                        <div class="activity-time">Dashboard cargado correctamente</div>
                                    </div>
                                    <div>
                                        <i class="fas fa-check-circle text-success"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong>WebSocket conectado</strong>
                                        <div class="activity-time">Escuchando eventos en tiempo real</div>
                                    </div>
                                    <div>
                                        <i class="fas fa-wifi text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tablas en Pestañas -->
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-tabs nav-tabs-custom" id="dataTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="empleados-tab" data-bs-toggle="tab" data-bs-target="#empleados" type="button" role="tab">
                                <i class="fas fa-users me-2"></i>Empleados
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="vehiculos-tab" data-bs-toggle="tab" data-bs-target="#vehiculos" type="button" role="tab">
                                <i class="fas fa-car me-2"></i>Vehículos
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sucursales-tab" data-bs-toggle="tab" data-bs-target="#sucursales" type="button" role="tab">
                                <i class="fas fa-building me-2"></i>Sucursales
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="usuarios-tab" data-bs-toggle="tab" data-bs-target="#usuarios" type="button" role="tab">
                                <i class="fas fa-user-shield me-2"></i>Usuarios
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="asignaciones-tab" data-bs-toggle="tab" data-bs-target="#asignaciones" type="button" role="tab">
                                <i class="fas fa-link me-2"></i>Asignaciones
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="dataTabContent">
                        <!-- Empleados -->
                        <div class="tab-pane fade show active" id="empleados" role="tabpanel">
                            <div class="table-card">
                                <div class="card-header">
                                    <i class="fas fa-users me-2"></i>Listado de Empleados
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Cargo</th>
                                                <th>Correo</th>
                                                <th>Teléfono</th>
                                                <th>Fecha Registro</th>
                                            </tr>
                                        </thead>
                                        <tbody id="empleados-table-body">
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                                                    <p class="mt-2 text-muted">Cargando empleados...</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Vehículos -->
                        <div class="tab-pane fade" id="vehiculos" role="tabpanel">
                            <div class="table-card">
                                <div class="card-header">
                                    <i class="fas fa-car me-2"></i>Listado de Vehículos
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Placa</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Año</th>
                                                <th>Tipo</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody id="vehiculos-table-body">
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                                                    <p class="mt-2 text-muted">Cargando vehículos...</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Sucursales -->
                        <div class="tab-pane fade" id="sucursales" role="tabpanel">
                            <div class="table-card">
                                <div class="card-header">
                                    <i class="fas fa-building me-2"></i>Listado de Sucursales
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Dirección</th>
                                                <th>Ciudad</th>
                                                <th>Teléfono</th>
                                                <th>Fecha Creación</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sucursales-table-body">
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                                                    <p class="mt-2 text-muted">Cargando sucursales...</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Usuarios -->
                        <div class="tab-pane fade" id="usuarios" role="tabpanel">
                            <div class="table-card">
                                <div class="card-header">
                                    <i class="fas fa-user-shield me-2"></i>Listado de Usuarios
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Rol</th>
                                                <th>Verificado</th>
                                                <th>Fecha Registro</th>
                                            </tr>
                                        </thead>
                                        <tbody id="usuarios-table-body">
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                                                    <p class="mt-2 text-muted">Cargando usuarios...</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Asignaciones -->
                        <div class="tab-pane fade" id="asignaciones" role="tabpanel">
                            <div class="table-card">
                                <div class="card-header">
                                    <i class="fas fa-link me-2"></i>Asignaciones Vehículo-Sucursal
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Vehículo</th>
                                                <th>Sucursal</th>
                                                <th>Fecha Asignación</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody id="asignaciones-table-body">
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                                                    <p class="mt-2 text-muted">Cargando asignaciones...</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // ===== CONFIGURACIÓN =====
        const GRAPHQL_ENDPOINT = '/graphql';
        const WEBSOCKET_HOST = '127.0.0.1:8080';
        
        // Variables globales
        let vehiculosChart = null;
        let channels = {};
        
        // ===== CLIENTE GRAPHQL =====
        async function graphqlQuery(query, variables = {}) {
            try {
                const response = await fetch(GRAPHQL_ENDPOINT, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ query, variables })
                });
                
                const result = await response.json();
                
                if (result.errors) {
                    console.error('GraphQL Errors:', result.errors);
                    throw new Error(result.errors[0].message);
                }
                
                return result.data;
            } catch (error) {
                console.error('Error en GraphQL query:', error);
                throw error;
            }
        }

        // ===== CONEXIÓN WEBSOCKET =====
        function initializeWebSocket() {
            try {
                // Esperar a que Echo esté disponible
                const checkEcho = () => {
                    if (window.Echo) {
                        console.log('🔌 Conectando con Laravel Echo (Reverb)...');
                        
                        // Suscribirse a canales públicos
                        const channelNames = ['empleados', 'vehiculos', 'sucursales', 'usuarios', 'asignaciones', 'dashboard'];
                        
                        channelNames.forEach(channelName => {
                            const channel = window.Echo.channel(channelName);
                            channels[channelName] = channel;
                            
                            // Escuchar eventos específicos para cada canal
                            channel.listen('.empleado.creado', (data) => {
                                console.log(`📡 Empleado creado:`, data);
                                handleRealTimeEvent({...data, type: 'empleado.creado'});
                                addActivityItem({...data, type: 'empleado.creado'});
                            });
                            
                            channel.listen('.empleado.actualizado', (data) => {
                                console.log(`📡 Empleado actualizado:`, data);
                                handleRealTimeEvent({...data, type: 'empleado.actualizado'});
                                addActivityItem({...data, type: 'empleado.actualizado'});
                            });
                            
                            channel.listen('.empleado.eliminado', (data) => {
                                console.log(`📡 Empleado eliminado:`, data);
                                handleRealTimeEvent({...data, type: 'empleado.eliminado'});
                                addActivityItem({...data, type: 'empleado.eliminado'});
                            });
                            
                            channel.listen('.vehiculo.creado', (data) => {
                                console.log(`📡 Vehículo creado:`, data);
                                handleRealTimeEvent({...data, type: 'vehiculo.creado'});
                                addActivityItem({...data, type: 'vehiculo.creado'});
                            });
                            
                            channel.listen('.vehiculo.actualizado', (data) => {
                                console.log(`📡 Vehículo actualizado:`, data);
                                handleRealTimeEvent({...data, type: 'vehiculo.actualizado'});
                                addActivityItem({...data, type: 'vehiculo.actualizado'});
                            });
                            
                            // Más listeners para otros eventos...
                            
                            console.log(`✅ Suscrito a canal: ${channelName}`);
                        });

                        // Estado de conexión - simulado ya que Reverb no expone el estado directamente
                        updateConnectionStatus('connected');
                        console.log('🔗 WebSocket conectado con Laravel Reverb');
                        
                    } else {
                        console.log('⏳ Esperando Echo...');
                        setTimeout(checkEcho, 500);
                    }
                };
                
                checkEcho();

            } catch (error) {
                console.error('❌ Error inicializando WebSocket:', error);
                updateConnectionStatus('disconnected');
            }
        }

        // ===== GESTIÓN DE ESTADO DE CONEXIÓN =====
        function updateConnectionStatus(status) {
            const indicator = document.getElementById('connection-status');
            const text = document.getElementById('connection-text');
            
            indicator.className = `real-time-indicator indicator-${status}`;
            
            switch(status) {
                case 'connected':
                    text.textContent = 'Conectado';
                    break;
                case 'connecting':
                    text.textContent = 'Conectando...';
                    break;
                case 'disconnected':
                    text.textContent = 'Desconectado';
                    break;
            }
        }

        // ===== MANEJO DE EVENTOS EN TIEMPO REAL =====
        function handleRealTimeEvent(data) {
            switch(data.entity_type) {
                case 'empleado':
                    loadEmpleados();
                    updateMetrics();
                    break;
                case 'vehiculo':
                    loadVehiculos();
                    updateMetrics();
                    updateVehiculosChart();
                    break;
                case 'sucursal':
                    loadSucursales();
                    updateMetrics();
                    break;
                case 'usuario':
                    loadUsuarios();
                    updateMetrics();
                    break;
                case 'vehiculo_sucursal':
                    loadAsignaciones();
                    break;
            }
        }

        // ===== CARGA DE DATOS =====
        async function loadMetrics() {
            try {
                console.log('⚠️ LoadMetrics deshabilitado temporalmente para debug');
                
                // Poner valores por defecto mientras solucionamos el query
                document.getElementById('total-empleados').textContent = '---';
                document.getElementById('total-vehiculos').textContent = '---';
                document.getElementById('total-sucursales').textContent = '---';
                document.getElementById('total-usuarios').textContent = '---';
                
                return; // Salir temprano
                
                const query = `
                    query {
                        estadisticas {
                            totalEmpleados
                            totalVehiculos
                            totalSucursales
                            totalUsuarios
                            vehiculosPorEstado {
                                estado
                                count
                            }
                        }
                    }
                `;
                
                const data = await graphqlQuery(query);
                const stats = data.estadisticas;
                
                document.getElementById('total-empleados').textContent = stats.totalEmpleados;
                document.getElementById('total-vehiculos').textContent = stats.totalVehiculos;
                document.getElementById('total-sucursales').textContent = stats.totalSucursales;
                document.getElementById('total-usuarios').textContent = stats.totalUsuarios;
                
                // Actualizar gráfico
                updateVehiculosChart(stats.vehiculosPorEstado);
                
            } catch (error) {
                console.error('Error cargando métricas:', error);
            }
        }

        async function loadEmpleados() {
            try {
                const query = `
                    query {
                        empleados {
                            id_empleado
                            nombre
                            cargo
                            correo
                            telefono
                            created_at
                        }
                    }
                `;
                
                const data = await graphqlQuery(query);
                const tbody = document.getElementById('empleados-table-body');
                
                if (data.empleados.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No hay empleados registrados</td></tr>';
                    return;
                }
                
                tbody.innerHTML = data.empleados.map(empleado => `
                    <tr>
                        <td>${empleado.id_empleado}</td>
                        <td><strong>${empleado.nombre}</strong></td>
                        <td><span class="badge bg-secondary">${empleado.cargo}</span></td>
                        <td>${empleado.correo}</td>
                        <td>${empleado.telefono || 'N/A'}</td>
                        <td>${new Date(empleado.created_at).toLocaleDateString()}</td>
                    </tr>
                `).join('');
                
            } catch (error) {
                console.error('Error cargando empleados:', error);
                document.getElementById('empleados-table-body').innerHTML = 
                    '<tr><td colspan="6" class="text-center py-4 text-danger">Error cargando datos</td></tr>';
            }
        }

        async function loadVehiculos() {
            try {
                const query = `
                    query {
                        vehiculos {
                            id_vehiculo
                            placa
                            marca
                            modelo
                            anio
                            tipo_id
                            estado
                        }
                    }
                `;
                
                const data = await graphqlQuery(query);
                const tbody = document.getElementById('vehiculos-table-body');
                
                if (data.vehiculos.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No hay vehículos registrados</td></tr>';
                    return;
                }
                
                tbody.innerHTML = data.vehiculos.map(vehiculo => `
                    <tr>
                        <td><strong>${vehiculo.placa}</strong></td>
                        <td>${vehiculo.marca}</td>
                        <td>${vehiculo.modelo}</td>
                        <td>${vehiculo.anio}</td>
                        <td><span class="badge bg-info">${vehiculo.tipo_id}</span></td>
                        <td><span class="status-badge status-${vehiculo.estado}">${vehiculo.estado}</span></td>
                    </tr>
                `).join('');
                
            } catch (error) {
                console.error('Error cargando vehículos:', error);
                document.getElementById('vehiculos-table-body').innerHTML = 
                    '<tr><td colspan="6" class="text-center py-4 text-danger">Error cargando datos</td></tr>';
            }
        }

        async function loadSucursales() {
            try {
                const query = `
                    query {
                        sucursales {
                            id_sucursal
                            nombre
                            direccion
                            ciudad
                            telefono
                            created_at
                        }
                    }
                `;
                
                const data = await graphqlQuery(query);
                const tbody = document.getElementById('sucursales-table-body');
                
                if (data.sucursales.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No hay sucursales registradas</td></tr>';
                    return;
                }
                
                tbody.innerHTML = data.sucursales.map(sucursal => `
                    <tr>
                        <td>${sucursal.id_sucursal}</td>
                        <td><strong>${sucursal.nombre}</strong></td>
                        <td>${sucursal.direccion}</td>
                        <td><span class="badge bg-primary">${sucursal.ciudad}</span></td>
                        <td>${sucursal.telefono || 'N/A'}</td>
                        <td>${new Date(sucursal.created_at).toLocaleDateString()}</td>
                    </tr>
                `).join('');
                
            } catch (error) {
                console.error('Error cargando sucursales:', error);
                document.getElementById('sucursales-table-body').innerHTML = 
                    '<tr><td colspan="6" class="text-center py-4 text-danger">Error cargando datos</td></tr>';
            }
        }

        async function loadUsuarios() {
            try {
                const query = `
                    query {
                        users {
                            id
                            name
                            email
                            email_verified_at
                            created_at
                            rol {
                                nombre
                            }
                        }
                    }
                `;
                
                const data = await graphqlQuery(query);
                const tbody = document.getElementById('usuarios-table-body');
                
                if (data.users.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No hay usuarios registrados</td></tr>';
                    return;
                }
                
                tbody.innerHTML = data.users.map(user => `
                    <tr>
                        <td>${user.id}</td>
                        <td><strong>${user.name}</strong></td>
                        <td>${user.email}</td>
                        <td><span class="badge bg-success">${user.rol ? user.rol.nombre : 'Sin rol'}</span></td>
                        <td>${user.email_verified_at ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'}</td>
                        <td>${new Date(user.created_at).toLocaleDateString()}</td>
                    </tr>
                `).join('');
                
            } catch (error) {
                console.error('Error cargando usuarios:', error);
                document.getElementById('usuarios-table-body').innerHTML = 
                    '<tr><td colspan="6" class="text-center py-4 text-danger">Error cargando datos</td></tr>';
            }
        }

        async function loadAsignaciones() {
            try {
                const query = `
                    query {
                        vehiculoSucursales {
                            id
                            id_vehiculo
                            id_sucursal
                            fecha_asignacion
                            vehiculo {
                                placa
                                marca
                                modelo
                            }
                            sucursal {
                                nombre
                                ciudad
                            }
                        }
                    }
                `;
                
                const data = await graphqlQuery(query);
                const tbody = document.getElementById('asignaciones-table-body');
                
                if (data.vehiculoSucursales.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-muted">No hay asignaciones registradas</td></tr>';
                    return;
                }
                
                tbody.innerHTML = data.vehiculoSucursales.map(asignacion => `
                    <tr>
                        <td>${asignacion.id}</td>
                        <td>
                            <strong>${asignacion.vehiculo.placa}</strong><br>
                            <small class="text-muted">${asignacion.vehiculo.marca} ${asignacion.vehiculo.modelo}</small>
                        </td>
                        <td>
                            <strong>${asignacion.sucursal.nombre}</strong><br>
                            <small class="text-muted">${asignacion.sucursal.ciudad}</small>
                        </td>
                        <td>${new Date(asignacion.fecha_asignacion).toLocaleDateString()}</td>
                        <td><span class="badge bg-success">Activa</span></td>
                    </tr>
                `).join('');
                
            } catch (error) {
                console.error('Error cargando asignaciones:', error);
                document.getElementById('asignaciones-table-body').innerHTML = 
                    '<tr><td colspan="5" class="text-center py-4 text-danger">Error cargando datos</td></tr>';
            }
        }

        // ===== GRÁFICOS =====
        function updateVehiculosChart(vehiculosPorEstado = []) {
            const ctx = document.getElementById('vehiculos-chart').getContext('2d');
            
            if (vehiculosChart) {
                vehiculosChart.destroy();
            }
            
            const estados = vehiculosPorEstado.map(v => v.estado);
            const counts = vehiculosPorEstado.map(v => v.count);
            
            vehiculosChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: estados,
                    datasets: [{
                        data: counts,
                        backgroundColor: [
                            '#28a745',
                            '#dc3545', 
                            '#ffc107',
                            '#6c757d'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // ===== ACTIVIDAD =====
        function addActivityItem(data) {
            const feed = document.getElementById('activity-feed');
            const time = new Date().toLocaleTimeString();
            
            const activityItem = document.createElement('div');
            activityItem.className = 'activity-item';
            activityItem.innerHTML = `
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>${getActionText(data)}</strong>
                        <div class="activity-time">${time}</div>
                    </div>
                    <div>
                        <i class="fas fa-${getActionIcon(data.entity_type)} text-primary"></i>
                    </div>
                </div>
            `;
            
            feed.insertBefore(activityItem, feed.firstChild);
            
            // Mantener solo los últimos 10 elementos
            while (feed.children.length > 10) {
                feed.removeChild(feed.lastChild);
            }
        }

        function getActionText(data) {
            const actions = {
                'created': 'creó',
                'updated': 'actualizó',
                'deleted': 'eliminó',
                'assigned': 'asignó'
            };
            
            const entities = {
                'empleado': 'empleado',
                'vehiculo': 'vehículo',
                'sucursal': 'sucursal',
                'usuario': 'usuario',
                'vehiculo_sucursal': 'asignación'
            };
            
            return `Se ${actions[data.action] || 'modificó'} ${entities[data.entity_type] || 'elemento'}`;
        }

        function getActionIcon(entityType) {
            const icons = {
                'empleado': 'user',
                'vehiculo': 'car',
                'sucursal': 'building',
                'usuario': 'user-shield',
                'vehiculo_sucursal': 'link'
            };
            
            return icons[entityType] || 'circle';
        }

        // ===== UTILIDADES =====
        async function updateMetrics() {
            await loadMetrics();
        }

        // ===== INICIALIZACIÓN =====
        document.addEventListener('DOMContentLoaded', async function() {
            console.log('🚀 Inicializando Dashboard...');
            
            try {
                // Carga inicial de datos
                await Promise.allSettled([
                    loadMetrics(),
                    loadEmpleados(),
                    loadVehiculos(),
                    loadSucursales(),
                    loadUsuarios(),
                    loadAsignaciones()
                ]);
                
                // Inicializar WebSocket
                initializeWebSocket();
                
                // Simular algunas actividades iniciales después de un momento
                setTimeout(() => {
                    addActivityItem({
                        entity_type: 'sistema',
                        action: 'initialized',
                        message: 'Dashboard listo para recibir eventos'
                    });
                }, 2000);
                
                // Añadir botón de test en el dashboard
                addTestButton();
                
                console.log('✅ Dashboard inicializado correctamente');
                
            } catch (error) {
                console.error('❌ Error inicializando dashboard:', error);
            }
        });

        // Función para añadir botón de test
        function addTestButton() {
            const activityFeed = document.querySelector('.activity-feed h5');
            if (activityFeed) {
                const testButton = document.createElement('button');
                testButton.className = 'btn btn-sm btn-outline-primary ms-2';
                testButton.innerHTML = '<i class="fas fa-test-tube"></i> Test';
                testButton.onclick = async () => {
                    try {
                        const response = await fetch('/websocket-test/empleado-creado');
                        const result = await response.json();
                        if (result.success) {
                            addActivityItem({
                                entity_type: 'empleado',
                                action: 'created',
                                message: 'Test: ' + result.message,
                                timestamp: new Date().toISOString()
                            });
                        }
                    } catch (error) {
                        console.error('Error en test:', error);
                    }
                };
                activityFeed.appendChild(testButton);
            }
        }

        // ===== MANEJO DE PESTAÑAS =====
        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
            tab.addEventListener('shown.bs.tab', function(event) {
                const targetId = event.target.getAttribute('data-bs-target').substring(1);
                console.log(`📋 Cambiando a pestaña: ${targetId}`);
            });
        });
    </script>
    
    <!-- Assets compilados de Vite que incluyen Laravel Echo -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Setup personalizado de WebSocket - Simplificado ya que Echo viene en app.js -->
    <script>
        // Echo ya está disponible globalmente desde app.js
        document.addEventListener('DOMContentLoaded', function() {
            console.log('📄 DOM cargado');
            console.log('🔍 Estado de Echo:', {
                Echo: typeof window.Echo,
                EchoInstance: window.Echo,
                Pusher: typeof window.Pusher
            });
            
            if (window.Echo) {
                console.log('🎉 Laravel Echo está disponible y configurado');
            } else {
                console.error('❌ Laravel Echo no está disponible');
            }
        });
    </script>
    
    <!-- Debug adicional -->
    <script>
        setTimeout(() => {
            console.log('🔍 Estado final librerías:', {
                Pusher: typeof Pusher,
                Echo: typeof Echo,
                window_Echo: typeof window.Echo
            });
        }, 2000);
    </script>
</body>
</html>
