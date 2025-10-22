<!--<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Api</title>
</head>
<body>
  <input type="text" id="api" value="Api.com">

  <form action="" id="frmApi">
  <input type="text" value="7c3ba123184b8cd3f5997694407c5fb561893af7c6004683776f701ac3524a76-20251003-1" name="token">
  <input type="text" name="dato" id="dato">
  <br>
  <button id="btn_buscar" onclick="llamar_api();" >Buscar</button>
  </form>
  <br>
  <div id="contenido"></div>
</body>
<script src="<?php echo BASE_URL;?>src/view/js/api.js"></script>
</html> -->

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cliente API | Hoteles Huanta</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Iconos FontAwesome -->
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background: linear-gradient(135deg, #2c2c54, #6d28d9);
      font-family: 'Poppins', sans-serif;
      color: #222;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .api-container {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
      width: 420px;
      padding: 35px 40px;
      animation: fadeIn 0.7s ease-in-out;
    }

    .api-header {
      text-align: center;
      margin-bottom: 25px;
    }

    .api-header h2 {
      font-weight: 700;
      font-size: 1.6rem;
      color: #3b1f82;
    }

    .api-header i {
      font-size: 2.4rem;
      color: #6d28d9;
      margin-bottom: 8px;
    }

    label {
      font-weight: 600;
      font-size: 0.95rem;
      margin-top: 12px;
    }

    input.form-control {
      border-radius: 8px;
      border: 1px solid #ddd;
      padding: 10px;
      transition: 0.3s;
    }

    input.form-control:focus {
      border-color: #6d28d9;
      box-shadow: 0 0 6px rgba(109, 40, 217, 0.3);
    }

    button {
      background: linear-gradient(90deg, #6d28d9, #7c3aed);
      border: none;
      color: #fff;
      font-weight: 600;
      border-radius: 8px;
      padding: 10px;
      margin-top: 20px;
      width: 100%;
      transition: 0.3s ease-in-out;
    }

    button:hover {
      background: linear-gradient(90deg, #5b21b6, #6d28d9);
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(109, 40, 217, 0.4);
    }

    #contenido {
      margin-top: 20px;
      font-size: 0.95rem;
      background: #f9fafb;
      padding: 15px;
      border-radius: 8px;
      border: 1px solid #eee;
    }

    footer {
      text-align: center;
      margin-top: 25px;
      color: #aaa;
      font-size: 0.85rem;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>
  <div class="api-container">
    <div class="api-header">
      <i class="fa-solid fa-hotel"></i>
      <h2>Cliente API - HotelSeek</h2>
      <p class="text-muted">Consulta rápida y segura a tu API de hoteles</p>
    </div>

    <input type="text" id="ruta_api" value="http://localhost:8888/hoteles/"  class="form-control">

    <form id="frmApi">
      <label for="token"><i class="fa-solid fa-key"></i> Token de seguridad</label>
      <input type="text" id="token" name="token"
        class="form-control"
        value="7c3ba123184b8cd3f5997694407c5fb561893af7c6004683776f701ac3524a76-20251003-1" required>

      <label for="dato"><i class="fa-solid fa-magnifying-glass"></i> Buscar hotel o habitación</label>
      <input type="text" id="dato" name="dato" class="form-control" placeholder="Ejemplo: Royal, Huanta, habitación simple">

      <button type="button" onclick="llamar_api();">
        <i class="fa-solid fa-paper-plane"></i> Consultar API
      </button>
    </form>

    <div id="contenido"></div>

    <footer>
      <p>© 2025 Hoteles Huanta | Cliente API</p>
    </footer>
  </div>

  <!-- Aquí irá el archivo JS -->
  <script src="src/view/js/api.js"></script>
</body>
</html>
