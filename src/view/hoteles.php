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
    <!-- Encabezado y Botón para agregar hotel -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4 text-dark">Gestión de Hoteles</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registroHotelModal">
            <i class="bi bi-plus-circle me-2"></i> Agregar Nuevo Hotel
        </button>
    </div>

    <!-- Tabla de Hoteles -->
    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white">
             <h5 class="mb-0">Listado de Hoteles Registrados</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre del Hotel</th>
                            <th scope="col">Ciudad</th>
                            <th scope="col" class="text-center">Estrellas</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Dirección</th>
                            <th scope="col" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_hoteles">
<!--                         <tr>
                            <th scope="row">1</th>
                            <td>Hotel Paraíso Tropical</td>
                            <td>Cancún</td>
                            <td class="text-center text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </td>
                            <td>066 435435</td>
                            <td>hotel@gmail.com</td>
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

<!-- Modal para Registro de Hotel -->
<div class="modal fade" id="registroHotelModal" tabindex="-1" aria-labelledby="registroHotelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="registroHotelModalLabel">Registrar Nuevo Hotel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frm_new_hotel">
                    <div class="mb-3">
                        <label for="nombreHotel" class="form-label">Nombre del Hotel</label>
                        <input type="text" class="form-control" id="nombreHotel" name="nombreHotel" placeholder="Ingrese el nombre del hotel" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ciudadHotel" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="ciudadHotel" name="ciudadHotel" placeholder="Ciudad de ubicación" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="estrellasHotel" class="form-label">Estrellas</label>
                            <select class="form-select" id="estrellasHotel" name="estrellasHotel">
                                <option selected>Seleccione calificación...</option>
                                <option value="1">1 Estrella</option>
                                <option value="2">2 Estrellas</option>
                                <option value="3">3 Estrellas</option>
                                <option value="4">4 Estrellas</option>
                                <option value="5">5 Estrellas</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="direccionHotel" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccionHotel" name="direccionHotel" placeholder="Dirección completa" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefonoHotel" class="form-label">telefono</label>
                        <input type="text" class="form-control" id="telefonoHotel" name="telefonoHotel" placeholder="Telefono de contacto" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailHotel" class="form-label">Correo Electronico</label>
                        <input type="email" class="form-control" id="emailHotel" name="emailHotel" placeholder="Correo de contacto" required>
                    </div>
<!--                      <div class="mb-3">
                        <label for="estadoHotel" class="form-label">Estado</label>
                        <select class="form-select" id="estadoHotel">
                            <option value="1" selected>Disponible</option>
                            <option value="2">Ocupado</option>
                            <option value="3">Mantenimiento</option>
                        </select>
                    </div> -->
                    <div class="mb-3">
                        <label for="descripcionHotel" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcionHotel" name="descripcionHotel" rows="3" placeholder="Añada una breve descripción del hotel"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="registrarHotel();">Guardar Hotel</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal actualizar Hotel -->
<div class="modal fade" id="actualizarHotel" tabindex="-1" aria-labelledby="actualizarHotelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="actualizarHotelLabel">Actualizar Hotel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frm_upd_hotel">
                    <input type="hidden" id="data" name="data">
                    <div class="mb-3">
                        <label for="new_nombreHotel" class="form-label">Nombre del Hotel</label>
                        <input type="text" class="form-control" id="new_nombreHotel" name="new_nombreHotel"  required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="NewCiudadHotel" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="NewCiudadHotel" name="NewCiudadHotel"  required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="NewEstrellasHotel" class="form-label">Estrellas</label>
                            <select class="form-select" id="NewEstrellasHotel" name="NewEstrellasHotel">
                                <option selected>Seleccione calificación...</option>
                                <option value="1">1 Estrella</option>
                                <option value="2">2 Estrellas</option>
                                <option value="3">3 Estrellas</option>
                                <option value="4">4 Estrellas</option>
                                <option value="5">5 Estrellas</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="newDireccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="newDireccion" name="newDireccion"  required>
                    </div>
                    <div class="mb-3">
                        <label for="newTelefono" class="form-label">telefono</label>
                        <input type="text" class="form-control" id="newTelefono" name="newTelefono"  required>
                    </div>
                    <div class="mb-3">
                        <label for="newEmailHotel" class="form-label">Correo Electronico</label>
                        <input type="email" class="form-control" id="newEmailHotel" name="newEmailHotel" required>
                    </div>
                    <div class="mb-3">
                        <label for="NewDescripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="NewDescripcion" name="NewDescripcion" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="actualizarHotel();">Actualizar Hotel</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo BASE_URL;?>src/view/js/hoteles.js"></script>