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
    <!-- Encabezado y Botón para agregar servicio -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4 text-dark">Gestión de Servicios del Hotel</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registroServicioModal">
            <i class="bi bi-plus-circle me-2"></i> Agregar Nuevo Servicio
        </button>
    </div>

    <!-- Tabla de Servicios -->
    <div class="card shadow-lg">
         <div class="card-header bg-dark text-white">
             <h5 class="mb-0">Listado de Servicios Disponibles</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre del Servicio</th>
                            <th scope="col" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_servicios">
<!--                         <tr>
                            <th scope="row">1</th>
                            <td>Spa y Masajes</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm me-1" title="Editar"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-danger btn-sm" title="Eliminar"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- /Page Content -->

<!-- Modal para Registro de Servicio -->
<div class="modal fade" id="registroServicioModal" tabindex="-1" aria-labelledby="registroServicioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="registroServicioModalLabel">Registrar Nuevo Servicio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frm_new_servicio">
                    <div class="mb-3">
                        <label for="nombreServicio" class="form-label">Nombre del Servicio</label>
                        <input type="text" class="form-control" id="nombreServicio" name="nombreServicio" placeholder="Ej: Servicio de Lavandería" required>
                    </div>

<!--                     <div class="mb-3">
                        <label for="precioServicio" class="form-label">Precio</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" id="precioServicio" placeholder="0.00" required>
                        </div>
                        <div class="form-text">
                          Si el servicio está incluido o no tiene costo, deje el valor en 0.
                        </div>
                    </div>

                     <div class="mb-3">
                        <label for="estadoServicio" class="form-label">Estado</label>
                        <select class="form-select" id="estadoServicio">
                            <option value="1" selected>Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div> -->

<!--                     <div class="mb-3">
                        <label for="descripcionServicio" class="form-label">Descripción del Servicio</label>
                        <textarea class="form-control" id="descripcionServicio" rows="3" placeholder="Añada una breve descripción de lo que incluye el servicio"></textarea>
                    </div> -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="registrarServicio();">Guardar Servicio</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal actualizar Servicio -->
<div class="modal fade" id="actualizarServicio" tabindex="-1" aria-labelledby="actualizarServicioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="actualizarServicioLabel">Actualizar Servicio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frm_upd_servicio">
                    <input type="hidden" id="data" name="data">
                    <div class="mb-3">
                        <label for="n_nombreServicio" class="form-label">Nombre del Servicio</label>
                        <input type="text" class="form-control" id="n_nombreServicio" name="n_nombreServicio" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="actualizarServicio();">Actualizar Servicio</button>
            </div>
        </div>
    </div>
</div>
<script> let id_hotel = '<?php echo $_GET['data'] ?>'</script>
<script src="<?php echo BASE_URL;?>src/view/js/servicios.js"></script>