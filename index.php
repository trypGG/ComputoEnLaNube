<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AquaFeed - Control de Alimento para Pecera</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --color-ocean: #1a6fc9;
      --color-light-ocean: #4d9de0;
      --color-sand: #f5d393;
      --color-coral: #ff7f50;
      --color-dark-coral: #e67347;
      --color-seaweed: #2e8b57;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      text-align: center;
      margin: 0;
      padding: 0;
      background-color: #e0f7fa;
      background-image: linear-gradient(to bottom, #e0f7fa, #b3e5fc);
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
    }
    
    /* Animación de burbujas */
    .bubble {
      position: absolute;
      bottom: 0;
      background-color: rgba(255, 255, 255, 0.6);
      border-radius: 50%;
      animation: float linear infinite;
      z-index: -1;
    }
    
    @keyframes float {
      0% {
        transform: translateY(0) rotate(0deg);
        opacity: 1;
      }
      100% {
        transform: translateY(-100vh) rotate(360deg);
        opacity: 0;
      }
    }
    
    /* Peces animados */
    .fish {
      position: absolute;
      font-size: 2rem;
      animation: swim linear infinite;
      z-index: -1;
      opacity: 0.7;
    }
    
    @keyframes swim {
      0% {
        transform: translateX(-100px);
      }
      100% {
        transform: translateX(calc(100vw + 100px));
      }
    }
    
    /* Cabecera */
    header {
      background-color: var(--color-ocean);
      color: white;
      padding: 1rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }
    
    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .logo i {
      font-size: 2rem;
      color: var(--color-sand);
    }
    
    .logo h1 {
      margin: 0;
      font-size: 1.8rem;
      font-weight: 600;
    }
    
    /* Contenedor principal */
    .container {
      display: inline-block;
      border: 3px solid var(--color-ocean);
      padding: 30px;
      border-radius: 15px;
      background: rgba(255, 255, 255, 0.9);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      margin: 30px auto;
      max-width: 500px;
      width: 90%;
      position: relative;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .container:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
    }
    
    .container::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 8px;
      background: linear-gradient(90deg, var(--color-ocean), var(--color-light-ocean), var(--color-ocean));
    }
    
    h2 {
      color: var(--color-ocean);
      margin-bottom: 25px;
      font-size: 1.8rem;
      position: relative;
      display: inline-block;
    }
    
    h2::after {
      content: "";
      position: absolute;
      bottom: -8px;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 3px;
      background-color: var(--color-coral);
    }
    
    h3 {
      color: var(--color-seaweed);
      margin-top: 25px;
      margin-bottom: 15px;
    }
    
    /* Botones */
    button {
      padding: 12px 25px;
      margin: 10px;
      font-size: 16px;
      border: none;
      border-radius: 50px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    
    button:active {
      transform: translateY(0);
    }
    
    button:first-of-type {
      background-color: var(--color-coral);
      color: white;
    }
    
    button:first-of-type:hover {
      background-color: var(--color-dark-coral);
    }
    
    button[type="submit"] {
      background-color: var(--color-seaweed);
      color: white;
    }
    
    button[type="submit"]:hover {
      background-color: #267a4d;
    }
    
    /* Formulario */
    form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    label {
      margin: 8px 0;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      width: 100%;
      max-width: 250px;
      color: var(--color-ocean);
      font-weight: 500;
    }
    
    input {
      padding: 10px 15px;
      margin: 5px 0;
      font-size: 16px;
      border: 2px solid #ddd;
      border-radius: 8px;
      width: 100%;
      transition: border-color 0.3s;
    }
    
    input:focus {
      outline: none;
      border-color: var(--color-light-ocean);
    }
    
    /* Respuesta */
    #respuesta {
      margin-top: 20px;
      padding: 12px;
      border-radius: 8px;
      font-weight: 500;
      opacity: 0;
      transition: opacity 0.3s ease;
      background-color: #e8f5e9;
      color: #2e7d32;
    }
    
    #respuesta.show {
      opacity: 1;
    }
    
    /* Olas decorativas */
    .wave {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 100px;
      background-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg"><path fill="%231a6fc9" fill-opacity="0.2" d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
      background-repeat: repeat-x;
      background-size: 1440px 100px;
      z-index: -1;
      animation: wave 15s linear infinite;
    }
    
    .wave:nth-child(2) {
      animation-duration: 20s;
      opacity: 0.5;
      background-position-y: 20px;
    }
    
    @keyframes wave {
      0% {
        background-position-x: 0;
      }
      100% {
        background-position-x: 1440px;
      }
    }
    
    /* Footer */
    footer {
      background-color: var(--color-ocean);
      color: white;
      padding: 1rem;
      position: fixed;
      bottom: 0;
      width: 100%;
      font-size: 0.9rem;
    }
    
    /* Responsive */
    @media (max-width: 600px) {
      .container {
        padding: 20px;
      }
      
      h2 {
        font-size: 1.5rem;
      }
      
      button {
        padding: 10px 20px;
      }
    }
  </style>
</head>
<body>
  <!-- Cabecera con logo -->
  <header>
    <div class="logo">
      <i class="fas fa-fish"></i>
      <h1>AquaFeed Control</h1>
    </div>
  </header>
  
  <!-- Contenedor principal -->
  <div class="container">
    <h2>Control de Alimento para Pecera</h2>
    
    <button onclick="alimentarManual()">
      <i class="fas fa-utensils"></i> Dar Alimento Ahora
    </button>
    
    <h3>Programar Horario</h3>
    <form onsubmit="programar(event)">
      <label>
        Hora (24h):
        <input type="number" id="hora" min="0" max="23" required>
      </label>
      <label>
        Minuto:
        <input type="number" id="minuto" min="0" max="59" required>
      </label>
      <label>
        Día (1-31 o -1 para cualquier día):
        <input type="number" id="dia" min="-1" max="31" required>
      </label>
      <button type="submit">
        <i class="far fa-clock"></i> Programar
      </button>
    </form>
    <div id="respuesta"></div>
  </div>
  
  <!-- Olas decorativas -->
  <div class="wave"></div>
  <div class="wave"></div>
  
  <!-- Footer -->
  <footer>
    Sistema de Control de Alimentación para Pecera &copy; 2023
  </footer>

  <script>
    const DEVICE_ID = "0a10aced202194944a055b7c";
    const ACCESS_TOKEN = "81290ef92c95e6da2b79850a4d38ffbacaf216e4";
    
    // Crear burbujas
    function createBubbles() {
      const bubbleCount = 20;
      for (let i = 0; i < bubbleCount; i++) {
        const bubble = document.createElement('div');
        bubble.classList.add('bubble');
        
        // Tamaño aleatorio
        const size = Math.random() * 30 + 10;
        bubble.style.width = `${size}px`;
        bubble.style.height = `${size}px`;
        
        // Posición aleatoria
        bubble.style.left = `${Math.random() * 100}%`;
        
        // Duración de animación aleatoria
        const duration = Math.random() * 15 + 10;
        bubble.style.animationDuration = `${duration}s`;
        
        // Retraso aleatorio
        bubble.style.animationDelay = `${Math.random() * 5}s`;
        
        document.body.appendChild(bubble);
      }
    }
    
    // Crear peces
    function createFish() {
      const fishCount = 5;
      const fishIcons = ['fas fa-fish', 'fas fa-fish', 'fas fa-fish', 'fas fa-kiwi-bird', 'fas fa-shrimp'];
      const fishColors = ['#FF5722', '#3F51B5', '#009688', '#E91E63', '#795548'];
      
      for (let i = 0; i < fishCount; i++) {
        const fish = document.createElement('i');
        fish.className = fishIcons[Math.floor(Math.random() * fishIcons.length)] + ' fish';
        fish.style.color = fishColors[Math.floor(Math.random() * fishColors.length)];
        
        // Posición vertical aleatoria
        fish.style.top = `${Math.random() * 80 + 10}%`;
        
        // Duración de animación aleatoria
        const duration = Math.random() * 30 + 20;
        fish.style.animationDuration = `${duration}s`;
        
        // Retraso aleatorio
        fish.style.animationDelay = `${Math.random() * 10}s`;
        
        // Dirección (algunos peces mirando al revés)
        if (Math.random() > 0.5) {
          fish.style.transform = 'scaleX(-1)';
        }
        
        document.body.appendChild(fish);
      }
    }
    
    // Mostrar respuesta
    function showResponse(message) {
      const respuesta = document.getElementById('respuesta');
      respuesta.innerText = message;
      respuesta.classList.add('show');
      
      setTimeout(() => {
        respuesta.classList.remove('show');
      }, 3000);
    }
    
    function alimentarManual() {
      fetch(`https://api.particle.io/v1/devices/${DEVICE_ID}/alimentar`, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `access_token=${ACCESS_TOKEN}`
      }).then(res => res.json())
        .then(data => {
          showResponse("¡Alimento proporcionado! 🐠");
          
          // Animación de comida cayendo
          const foodDrop = document.createElement('div');
          foodDrop.innerHTML = '<i class="fas fa-utensils" style="font-size: 2rem; color: var(--color-coral);"></i>';
          foodDrop.style.position = 'fixed';
          foodDrop.style.top = '100px';
          foodDrop.style.left = '50%';
          foodDrop.style.transform = 'translateX(-50%)';
          foodDrop.style.animation = 'drop 2s linear forwards';
          document.body.appendChild(foodDrop);
          
          // Crear estilo para la animación
          const style = document.createElement('style');
          style.innerHTML = `
            @keyframes drop {
              0% { transform: translate(-50%, 0) rotate(0deg); opacity: 1; }
              100% { transform: translate(-50%, 300px) rotate(360deg); opacity: 0; }
            }
          `;
          document.head.appendChild(style);
          
          // Eliminar después de la animación
          setTimeout(() => {
            foodDrop.remove();
            style.remove();
          }, 2000);
        }).catch(error => {
          console.error("Error:", error);
          showResponse("Error al alimentar. Intente nuevamente.");
        });
    }
    
    function programar(e) {
      e.preventDefault();
      const hora = document.getElementById("hora").value;
      const minuto = document.getElementById("minuto").value;
      const dia = document.getElementById("dia").value;
      const datos = `${hora},${minuto},${dia}`;
      
      // Validación adicional
      if (hora < 0 || hora > 23 || minuto < 0 || minuto > 59 || dia < -1 || dia > 31 || (dia == 0 && dia != -1)) {
        showResponse("Por favor ingrese valores válidos.");
        return;
      }
      
      fetch(`https://api.particle.io/v1/devices/${DEVICE_ID}/programar`, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `access_token=${ACCESS_TOKEN}&args=${datos}`
      }).then(res => res.json())
        .then(data => {
          showResponse("✅ Horario programado con éxito.");
        }).catch(error => {
          console.error("Error:", error);
          showResponse("Error al programar. Intente nuevamente.");
        });
    }
    
    // Inicializar elementos decorativos
    window.onload = function() {
      createBubbles();
      createFish();
    };
  </script>
</body>
</html>
