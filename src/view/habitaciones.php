<style>


    /* Títulos */
    h1 {
        font-weight: bold;
        color: #333;
    }

    /* Botón principal */
    .btn-primary {
        background: var(--primary-gradient) !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-primary:hover {
        background: var(--hover-gradient) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }

    /* Botones secundarios */
    .btn-secondary {
        border-radius: 12px !important;
        font-weight: 500;
    }

    /* Cards */
    .card {
        border-radius: 16px !important;
        border: none !important;
        background: #fff;
    }

    /* Tablas */
    .table {
        border-radius: 12px;
        overflow: hidden;
    }
    .table thead {
        background: var(--primary-gradient);
        color: #fff;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(118, 75, 162, 0.08);
        transition: 0.2s ease;
    }
    .table td, .table th {
        vertical-align: middle;
    }

    /* Badges */
    .badge {
        padding: 0.45em 0.7em;
        border-radius: 8px;
        font-weight: 600;
    }

    /* Modales */
    .modal-content {
        border-radius: 16px !important;
        border: none;
        box-shadow: 0 8px 25px rgba(0,0,0,0.25);
    }

    .modal-header {
        background: var(--primary-gradient) !important;
        color: #fff !important;
        border-top-left-radius: 16px !important;
        border-top-right-radius: 16px !important;
    }

    .modal-footer {
        border-top: none !important;
    }

    /* Inputs */
    .form-control, .form-select {
        border-radius: 12px !important;
        border: 1px solid #ddd !important;
        padding: 0.65rem 0.9rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #764ba2 !important;
        box-shadow: 0 0 0 0.2rem rgba(118, 75, 162, 0.25) !important;
    }
</style>

<!-- Page Content -->
<section class="container-fluid p-4">
    <!-- Encabezado y Botón para agregar habitación -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4 text-dark">Gestión de Habitaciones</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registroHabitacionModal">
            <i class="bi bi-plus-circle me-2"></i> Agregar Nueva Habitación
        </button>
    </div>

    <!-- Tabla de Habitaciones -->
    <div class="card shadow-lg">
         <div class="card-header bg-dark text-white">
             <h5 class="mb-0">Listado de Habitaciones</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Capacidad</th>
                            <th scope="col">Precio / Noche</th>
                            <th scope="col">Moneda</th>
                            <th scope="col">Cantidad disponible</th>
                            <th scope="col" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_habitaciones">
                        <!-- js -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- /Page Content -->

<!-- Modal para Registro de Habitación -->
<div class="modal fade" id="registroHabitacionModal" tabindex="-1" aria-labelledby="registroHabitacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="registroHabitacionModalLabel">Registrar Nueva Habitación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frm_new_habitacion">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tipoHabitacion" class="form-label">Tipo de Habitación</label>
                            <select class="form-select" id="tipoHabitacion" name="tipoHabitacion">
                                <option selected>Seleccione un tipo...</option>
                                <option value="simple">Simple</option>
                                <option value="doble">Doble</option>
                                <option value="suite">Suite</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="capacidad" class="form-label">Capacidad</label>
                            <input type="text" class="form-control" id="capacidad" name="capacidad"  required>
                        </div>

                    </div>
                     <div class="mb-3">
                        <label for="precioNoche" class="form-label">Precio por Noche</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" id="precioNoche" name="precioNoche" placeholder="Ej: 150.00" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="moneda" class="form-label">Moneda</label>
                        <input type="text" class="form-control" id="moneda" name="moneda"></input>
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha"></input>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad disponible</label>
                        <input type="text" class="form-control" id="cantidad" name="cantidad"></input>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="registrarHabitacion();">Guardar Habitación</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal actualizar Habitación -->
<div class="modal fade" id="actualizarHabitacion" tabindex="-1" aria-labelledby="actualizarHabitacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="actualizarHabitacionLabel">Actualizar Habitación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frm_upd_habitacion">
                    <input type="hidden" id="data" name="data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="n_tipoHabitacion" class="form-label">Tipo de Habitación</label>
                            <select class="form-select" id="n_tipoHabitacion" name="n_tipoHabitacion">
                                <option selected>Seleccione un tipo...</option>
                                <option value="simple">Simple</option>
                                <option value="doble">Doble</option>
                                <option value="suite">Suite</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="n_capacidad" class="form-label">Capacidad</label>
                            <input type="text" class="form-control" id="n_capacidad" name="n_capacidad"  required>
                        </div>

                    </div>
                     <div class="mb-3">
                        <label for="n_precioNoche" class="form-label">Precio por Noche</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" id="n_precioNoche" name="n_precioNoche" placeholder="Ej: 150.00" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="n_moneda" class="form-label">Moneda</label>
                        <input type="text" class="form-control" id="n_moneda" name="n_moneda"></input>
                    </div>
                    <div class="mb-3">
                        <label for="n_fecha" class="form-label">Fecha</label>
                        <input type="text" class="form-control" id="n_fecha" name="n_fecha"></input>
                    </div>
                    <div class="mb-3">
                        <label for="n_cantidad" class="form-label">Cantidad disponible</label>
                        <input type="text" class="form-control" id="n_cantidad" name="n_cantidad"></input>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="actualizarHabitacion();">Actualizar Habitación</button>
            </div>
        </div>
    </div>
</div>
<script> let id_hotel = '<?php echo $_GET['data'] ?>'</script>
<script src="<?php echo BASE_URL;?>src/view/js/habitaciones.js"></script>