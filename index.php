<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Control de Alimento - Pecera</title>
  <style>
    body {
      font-family: Arial;
      text-align: center;
      margin-top: 50px;
      background-color: #f0f8ff;
    }
    button, input {
      padding: 10px;
      margin: 10px;
      font-size: 16px;
    }
    .container {
      display: inline-block;
      border: 1px solid #ccc;
      padding: 20px;
      border-radius: 10px;
      background: #fff;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Control de Alimento para Pecera</h2>
    
    <button onclick="alimentarManual()">Dar Alimento Ahora</button>
    
    <h3>Programar Horario</h3>
    <form onsubmit="programar(event)">
      <label>Hora (24h): <input type="number" id="hora" min="0" max="23" required></label><br>
      <label>Minuto: <input type="number" id="minuto" min="0" max="59" required></label><br>
      <label>Día (1-31 o -1 para cualquier día): <input type="number" id="dia" min="-1" max="31" required></label><br>
      <button type="submit">Programar</button>
    </form>
    <div id="respuesta"></div>
  </div>

  <script>
    const DEVICE_ID = "0a10aced202194944a055b7c";
    const ACCESS_TOKEN = "81290ef92c95e6da2b79850a4d38ffbacaf216e4";

    function alimentarManual() {
      fetch(`https://api.particle.io/v1/devices/${DEVICE_ID}/alimentar`, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `access_token=${ACCESS_TOKEN}`
      }).then(res => res.json())
        .then(data => {
          document.getElementById("respuesta").innerText = "¡Alimento proporcionado!";
        }).catch(error => {
          console.error("Error:", error);
        });
    }

    function programar(e) {
      e.preventDefault();
      const hora = document.getElementById("hora").value;
      const minuto = document.getElementById("minuto").value;
      const dia = document.getElementById("dia").value;
      const datos = `${hora},${minuto},${dia}`;

      fetch(`https://api.particle.io/v1/devices/${DEVICE_ID}/programar`, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `access_token=${ACCESS_TOKEN}&args=${datos}`
      }).then(res => res.json())
        .then(data => {
          document.getElementById("respuesta").innerText = "Horario programado con éxito.";
        }).catch(error => {
          console.error("Error:", error);
        });
    }
  </script>
</body>
</html>
