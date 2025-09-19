<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Clientes API</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <h2 class="mb-4 text-center">Gestión de Clientes</h2>

  <div class="row">
    <!-- Listado de clientes -->
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span class="fw-bold">Listado de Clientes</span>
          <button class="btn btn-sm btn-success" onclick="loadClients()">
            <i class="bi bi-arrow-repeat"></i> Cargar
          </button>
        </div>
        <div class="card-body">
          <table class="table table-striped table-hover" id="clientsTable">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>RUC</th>
                <th>Razón Social</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Formulario -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <span id="formTitle">Nuevo Cliente</span>
        </div>
        <div class="card-body">
          <form id="clientForm">
            <input type="hidden" id="id">

            <div class="mb-3">
              <label for="ruc" class="form-label">RUC</label>
              <input type="text" class="form-control" id="ruc" placeholder="Ingrese RUC" required>
            </div>

            <div class="mb-3">
              <label for="razon_social" class="form-label">Razón Social</label>
              <input type="text" class="form-control" id="razon_social" placeholder="Ingrese razón social" required>
            </div>

            <div class="mb-3">
              <label for="telefono" class="form-label">Teléfono</label>
              <input type="text" class="form-control" id="telefono" placeholder="Ingrese teléfono">
            </div>

            <div class="mb-3">
              <label for="correo" class="form-label">Correo</label>
              <input type="email" class="form-control" id="correo" placeholder="Ingrese correo">
            </div>

            <div class="mb-3">
              <label for="estado" class="form-label">Estado</label>
              <select id="estado" class="form-select">
                <option value="1" selected>Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Guardar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<!-- Script del CRUD -->
<script src="assets/js/clients.js"></script>
</body>
</html>
