<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <style>
    :root {
      --primary-gradient: linear-gradient(135deg, #667eea, #764ba2);
    }

    body {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: var(--primary-gradient);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-card {
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(12px);
      border-radius: 20px;
      padding: 2.5rem;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
      color: #fff;
      width: 100%;
      max-width: 400px;
    }

    .login-card h1 {
      font-size: 1.8rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 1.8rem;
    }

    .form-control {
      border-radius: 12px;
      border: none;
      padding: 0.75rem;
      margin-bottom: 1rem;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .form-check-label {
      font-size: 0.9rem;
      color: #ddd;
    }

    .btn-primary {
      background: var(--primary-gradient);
      border: none;
      border-radius: 12px;
      padding: 0.75rem;
      width: 100%;
      font-weight: bold;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }
  </style>

  <script>
    const base_url = '<?php echo BASE_URL; ?>';
    const base_url_server = '<?php echo BASE_URL_SERVER; ?>';
  </script>
</head>

<body>
  <div class="login-card">
    <h1>Iniciar Sesión</h1>
    <form id="frm_login">
      <div class="form-group">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="correo.com">
      </div>
      <div class="form-group">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="********">
      </div>
      <div class="form-group form-check mb-3">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Recordarme</label>
      </div>
      <button type="submit" class="btn btn-primary">Ingresar</button>
    </form>
  </div>
</body>

<script src="<?php echo BASE_URL; ?>src/view/js/sesion.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>
