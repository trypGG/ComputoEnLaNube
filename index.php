<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Fire Guardian</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            color: #333;
            overflow-x: hidden;
            position: relative;
        }

        .status-bar {
            height: 24px;
            background: rgba(0,0,0,0.2);
        }

        .app-header {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(20px);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .app-title {
            color: white;
            font-size: 1.4rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .connection-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .connected {
            background: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
            border: 1px solid #4CAF50;
        }

        .disconnected {
            background: rgba(244, 67, 54, 0.2);
            color: #f44336;
            border: 1px solid #f44336;
        }

        .main-content {
            padding: 20px;
            height: calc(100vh - 120px);
            overflow-y: auto;
        }

        .room-status {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }

        .room-icon {
            font-size: 4rem;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .safe-mode {
            color: #4CAF50;
        }

        .danger-mode {
            color: #f44336;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.7; }
        }

        .room-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .room-subtitle {
            font-size: 1rem;
            color: #666;
            margin-bottom: 20px;
        }

        .sensor-data {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .sensor-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 15px;
            text-align: center;
        }

        .sensor-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: #2196F3;
        }

        .sensor-label {
            font-size: 0.9rem;
            color: #666;
            margin-top: 5px;
        }

        .control-section {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .control-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        .pump-status {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .pump-icon {
            font-size: 2.5rem;
            transition: all 0.3s ease;
        }

        .pump-off {
            color: #9E9E9E;
        }

        .pump-on {
            color: #2196F3;
            animation: rotate 2s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .info-message {
            background: rgba(33, 150, 243, 0.1);
            border: 1px solid #2196F3;
            color: #1976D2;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .notifications {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .notifications-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notification-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .notification-item:last-child {
            margin-bottom: 0;
        }

        .notification-icon {
            font-size: 1.5rem;
        }

        .notification-content {
            flex: 1;
        }

        .notification-text {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .notification-time {
            font-size: 0.8rem;
            color: #666;
        }

        .alert-notification {
            background: rgba(244, 67, 54, 0.1);
            border-left: 4px solid #f44336;
        }

        .info-notification {
            background: rgba(33, 150, 243, 0.1);
            border-left: 4px solid #2196F3;
        }

        .success-notification {
            background: rgba(76, 175, 80, 0.1);
            border-left: 4px solid #4CAF50;
        }

        .fab {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            border: none;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .fab:active {
            transform: scale(0.9);
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 20px;
            margin: 20px;
            max-width: 400px;
            width: 100%;
        }

        .modal-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
        }

        .form-input:focus {
            outline: none;
            border-color: #2196F3;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 15px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2196F3, #1976D2);
            color: white;
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }

        .btn:active {
            transform: scale(0.95);
        }

        .emergency-alert {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(244, 67, 54, 0.95);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 3000;
            color: white;
            text-align: center;
        }

        .alert-content {
            padding: 40px;
        }

        .alert-icon {
            font-size: 6rem;
            margin-bottom: 20px;
            animation: pulse 1s infinite;
        }

        .alert-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .alert-message {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .threshold-indicator {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 10px;
            margin-top: 10px;
            font-size: 0.9rem;
            color: #666;
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="status-bar"></div>
    
    <div class="app-header">
        <div class="app-title">
            🔥 Fire Guardian
        </div>
        <div class="connection-status disconnected" id="connectionStatus">
            🔴 Desconectado
        </div>
    </div>

    <div class="main-content">
        <div class="room-status">
            <div class="room-icon safe-mode" id="roomIcon">🏠</div>
            <div class="room-title" id="roomTitle">Estado Normal</div>
            <div class="room-subtitle" id="roomSubtitle">Esperando conexión con el dispositivo</div>
            
            <div class="sensor-data">
                <div class="sensor-item">
                    <div class="sensor-value" id="temperatureValue">--°C</div>
                    <div class="sensor-label">Temperatura</div>
                    <div class="threshold-indicator">
                        Umbral de alerta: 40°C
                    </div>
                </div>
                <div class="sensor-item">
                    <div class="sensor-value" id="systemStatus">Esperando</div>
                    <div class="sensor-label">Estado del Sistema</div>
                </div>
            </div>
        </div>

        <div class="control-section">
            <div class="control-title">Estado del Sistema de Extinción</div>
            
            <div class="pump-status">
                <div class="pump-icon pump-off" id="pumpIcon">💧</div>
                <div>
                    <div style="font-weight: 600; font-size: 1.1rem;" id="pumpStatus">Sistema Inactivo</div>
                    <div style="color: #666; font-size: 0.9rem;" id="pumpSubstatus">Esperando datos del sensor</div>
                </div>
            </div>

            <div class="info-message">
                📡 Este sistema se activa automáticamente cuando la temperatura supera los 40°C.
                El dispositivo controla la bomba, LEDs y buzzer de forma independiente.
            </div>
        </div>

        <div class="notifications">
            <div class="notifications-title">
                🔔 Registro de Eventos
            </div>
            <div id="notificationsList">
                <div class="notification-item info-notification">
                    <div class="notification-icon">ℹ️</div>
                    <div class="notification-content">
                        <div class="notification-text">Sistema web iniciado</div>
                        <div class="notification-time">Ahora</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="fab" onclick="openSettings()">⚙️</button>

    <!-- Modal de Configuración -->
    <div class="modal" id="settingsModal">
        <div class="modal-content">
            <div class="modal-title">Configuración de Dispositivo</div>
            <p style="margin-bottom: 20px; color: #666; text-align: center;">
                Configura la conexión con tu Particle Photon
            </p>
            
            <div class="form-group">
                <label class="form-label">Device ID</label>
                <input type="text" class="form-input" id="deviceId" placeholder="Tu Particle Device ID">
                <small style="color: #666; font-size: 0.8rem;">Encuentra tu Device ID en la consola de Particle</small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Access Token</label>
                <input type="password" class="form-input" id="accessToken" placeholder="Tu Access Token">
                <small style="color: #666; font-size: 0.8rem;">Genera un token desde tu cuenta de Particle</small>
            </div>

            <div class="modal-buttons">
                <button class="btn btn-primary" onclick="saveSettings()">Conectar</button>
                <button class="btn btn-secondary" onclick="closeSettings()">Cancelar</button>
            </div>
        </div>
    </div>

    <!-- Alerta de Emergencia -->
    <div class="emergency-alert" id="emergencyAlert">
        <div class="alert-content">
            <div class="alert-icon">🚨</div>
            <div class="alert-title">¡TEMPERATURA CRÍTICA!</div>
            <div class="alert-message" id="alertMessage">Sistema de extinción activado automáticamente</div>
            <button class="btn btn-primary" onclick="acknowledgeAlert()" style="font-size: 1.2rem; padding: 15px 30px;">
                Confirmar Recibido
            </button>
        </div>
    </div>

    <script>
        // Variables globales
        let deviceId = "0a10aced202194944a055b7c";
        let accessToken = "81290ef92c95e6da2b79850a4d38ffbacaf216e4";
        let isConnected = false;
        let pollInterval;
        let eventSource;
        let lastTemperature = 0;
        let alertShown = false;

        // Configuración inicial
        window.addEventListener('load', function() {
            // Cargar configuración inicial con los valores proporcionados
            document.getElementById('deviceId').value = deviceId;
            document.getElementById('accessToken').value = accessToken;
            
            // Iniciar monitoreo automáticamente con las credenciales proporcionadas
            startMonitoring();
            
            // Solicitar permisos de notificación
            if ('Notification' in window) {
                Notification.requestPermission();
            }
        });

        // Gestión de configuración
        function openSettings() {
            document.getElementById('deviceId').value = deviceId;
            document.getElementById('accessToken').value = accessToken;
            document.getElementById('settingsModal').style.display = 'flex';
        }

        function closeSettings() {
            document.getElementById('settingsModal').style.display = 'none';
        }

        function saveSettings() {
            const newDeviceId = document.getElementById('deviceId').value.trim();
            const newAccessToken = document.getElementById('accessToken').value.trim();
            
            if (!newDeviceId || !newAccessToken) {
                alert('Por favor, ingresa tanto el Device ID como el Access Token');
                return;
            }

            deviceId = newDeviceId;
            accessToken = newAccessToken;
            
            // Guardar en localStorage para persistencia
            localStorage.setItem('particleDeviceId', deviceId);
            localStorage.setItem('particleAccessToken', accessToken);
            
            closeSettings();
            addNotification('Configuración guardada, intentando conectar...', 'info');
            
            // Reiniciar la conexión
            restartConnection();
        }

        function loadSettings() {
            // Cargar desde localStorage si existe
            const savedDeviceId = localStorage.getItem('particleDeviceId');
            const savedAccessToken = localStorage.getItem('particleAccessToken');
            
            if (savedDeviceId && savedAccessToken) {
                deviceId = savedDeviceId;
                accessToken = savedAccessToken;
            }
        }

        // Monitoreo del dispositivo
        function startMonitoring() {
            addNotification('Iniciando conexión con el dispositivo...', 'info');
            
            // Verificar conexión inicial
            testConnection();
            
            // Configurar EventSource para escuchar eventos en tiempo real
            setupEventSource();
            
            // Iniciar polling cada 2 segundos para datos adicionales
            pollInterval = setInterval(async () => {
                await checkSensorData();
            }, 2000);
        }

        function restartConnection() {
            // Limpiar conexiones anteriores
            if (pollInterval) {
                clearInterval(pollInterval);
            }
            if (eventSource) {
                eventSource.close();
            }
            
            // Iniciar nueva conexión
            startMonitoring();
        }

        async function testConnection() {
            try {
                const response = await fetch(`https://api.particle.io/v1/devices/${deviceId}/ping`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                });

                if (response.ok) {
                    updateConnectionStatus(true);
                    addNotification('Dispositivo conectado correctamente', 'success');
                } else {
                    throw new Error('No se pudo conectar con el dispositivo');
                }
            } catch (error) {
                console.error('Connection test failed:', error);
                updateConnectionStatus(false);
                addNotification('Error de conexión. Verifica tus credenciales', 'alert');
            }
        }

        function setupEventSource() {
            if (eventSource) {
                eventSource.close();
            }
            
            // Configurar conexión SSE para eventos en tiempo real
            eventSource = new EventSource(`https://api.particle.io/v1/devices/${deviceId}/events?access_token=${accessToken}`);
            
            eventSource.addEventListener('open', () => {
                console.log('Conexión SSE establecida');
                updateConnectionStatus(true);
            });
            
            eventSource.addEventListener('error', () => {
                console.error('Error en conexión SSE');
                updateConnectionStatus(false);
            });
            
            // Escuchar eventos de temperatura
            eventSource.addEventListener('temperature', (e) => {
                const data = JSON.parse(e.data);
                const temperature = parseFloat(data.data);
                
                if (!isNaN(temperature)) {
                    updateTemperature(temperature);
                    
                    // Determinar estado del sistema basado en la temperatura
                    if (temperature >= 40.0) {
                        if (!alertShown) {
                            triggerFireAlarm(temperature);
                        }
                        updateSystemStatus('active', temperature);
                        updateRoomStatus('danger');
                    } else {
                        if (alertShown) {
                            resetFireAlarm();
                        }
                        updateSystemStatus('normal', temperature);
                        updateRoomStatus('safe');
                    }
                }
            });
            
            // Escuchar eventos de estado del sistema
            eventSource.addEventListener('system_status', (e) => {
                const data = JSON.parse(e.data);
                addNotification(`Estado del sistema: ${data.data}`, 'info');
            });
        }

        async function checkSensorData() {
            if (!isConnected) return;

            try {
                // Obtener temperatura desde el Particle Photon
                const response = await fetch(`https://api.particle.io/v1/devices/${deviceId}/temperature?access_token=${accessToken}`);
                
                if (response.ok) {
                    const data = await response.json();
                    const temperature = parseFloat(data.result);
                    
                    if (!isNaN(temperature)) {
                        updateTemperature(temperature);
                    }
                }
            } catch (error) {
                console.error('Error reading sensor data:', error);
                updateConnectionStatus(false);
            }
        }

        function updateTemperature(temperature) {
            lastTemperature = temperature;
            document.getElementById('temperatureValue').textContent = `${temperature.toFixed(1)}°C`;
        }

        function triggerFireAlarm(temperature) {
            alertShown = true;
            
            // Mostrar alerta de emergencia
            document.getElementById('alertMessage').textContent = 
                `Temperatura crítica detectada: ${temperature.toFixed(1)}°C. Sistema de extinción activado automáticamente.`;
            document.getElementById('emergencyAlert').style.display = 'flex';
            
            // Enviar notificación push
            sendPushNotification(
                '🚨 TEMPERATURA CRÍTICA', 
                `${temperature.toFixed(1)}°C detectados. Sistema activado automáticamente.`
            );
            
            // Agregar a log de notificaciones
            addNotification(
                `¡TEMPERATURA CRÍTICA! ${temperature.toFixed(1)}°C - Sistema activado automáticamente`, 
                'alert'
            );
            
            // Vibrar dispositivo si está disponible
            if ('vibrate' in navigator) {
                navigator.vibrate([200, 100, 200, 100, 200]);
            }
        }

        function resetFireAlarm() {
            alertShown = false;
            document.getElementById('emergencyAlert').style.display = 'none';
            addNotification('Temperatura normalizada - Sistema desactivado', 'success');
        }

        function acknowledgeAlert() {
            document.getElementById('emergencyAlert').style.display = 'none';
            addNotification('Alerta confirmada por el usuario', 'info');
        }

        // Actualización de UI
        function updateConnectionStatus(connected) {
            isConnected = connected;
            const statusEl = document.getElementById('connectionStatus');
            
            if (connected) {
                statusEl.textContent = '🟢 Conectado';
                statusEl.className = 'connection-status connected';
            } else {
                statusEl.textContent = '🔴 Desconectado';
                statusEl.className = 'connection-status disconnected';
            }
        }

        function updateRoomStatus(status) {
            const iconEl = document.getElementById('roomIcon');
            const titleEl = document.getElementById('roomTitle');
            const subtitleEl = document.getElementById('roomSubtitle');
            
            if (status === 'danger') {
                iconEl.textContent = '🔥';
                iconEl.className = 'room-icon danger-mode';
                titleEl.textContent = '¡PELIGRO - TEMPERATURA CRÍTICA!';
                subtitleEl.textContent = 'Sistema de extinción activado automáticamente';
            } else {
                iconEl.textContent = '🏠';
                iconEl.className = 'room-icon safe-mode';
                titleEl.textContent = 'Estado Normal';
                subtitleEl.textContent = 'Temperatura dentro de parámetros normales';
            }
        }

        function updateSystemStatus(status, temperature) {
            const systemStatusEl = document.getElementById('systemStatus');
            const pumpIconEl = document.getElementById('pumpIcon');
            const pumpStatusEl = document.getElementById('pumpStatus');
            const pumpSubstatusEl = document.getElementById('pumpSubstatus');
            
            if (status === 'active') {
                systemStatusEl.textContent = 'ACTIVO';
                systemStatusEl.style.color = '#f44336';
                pumpIconEl.className = 'pump-icon pump-on';
                pumpStatusEl.textContent = 'Sistema Activo';
                pumpSubstatusEl.textContent = 'Bomba, LEDs y buzzer activados';
            } else {
                systemStatusEl.textContent = 'Normal';
                systemStatusEl.style.color = '#4CAF50';
                pumpIconEl.className = 'pump-icon pump-off';
                pumpStatusEl.textContent = 'Sistema Inactivo';
                pumpSubstatusEl.textContent = `Temperatura: ${temperature.toFixed(1)}°C (Normal)`;
            }
        }

        function addNotification(message, type) {
            const listEl = document.getElementById('notificationsList');
            const time = new Date().toLocaleTimeString('es-ES', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            
            const notificationEl = document.createElement('div');
            notificationEl.className = `notification-item ${type}-notification`;
            
            const iconMap = {
                'alert': '🚨',
                'info': 'ℹ️',
                'success': '✅'
            };
            const icon = iconMap[type] || '🔔';
            
            notificationEl.innerHTML = `
                <div class="notification-icon">${icon}</div>
                <div class="notification-content">
                    <div class="notification-text">${message}</div>
                    <div class="notification-time">${time}</div>
                </div>
            `;
            
            listEl.insertBefore(notificationEl, listEl.firstChild);
            
            // Mantener solo las últimas 8 notificaciones
            while (listEl.children.length > 8) {
                listEl.removeChild(listEl.lastChild);
            }
        }

        function sendPushNotification(title, message) {
            if ('Notification' in window && Notification.permission === 'granted') {
                new Notification(title, {
                    body: message,
                    icon: '🔥',
                    tag: 'fire-alert',
                    requireInteraction: true
                });
            }
        }

        // Limpiar al cerrar
        window.addEventListener('beforeunload', function() {
            if (pollInterval) {
                clearInterval(pollInterval);
            }
            if (eventSource) {
                eventSource.close();
            }
        });
    </script>
</body>
</html>
