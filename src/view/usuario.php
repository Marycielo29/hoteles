            <!-- Page Content -->
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

            <section class="container-fluid p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="mt-4 text-dark">Gestión de Usuarios</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registroUsuarioModal">
                        <i class="bi bi-plus-circle me-2"></i> Agregar Nuevo Usuario
                    </button>
                </div>

                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle" id="tbl_users">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Rol</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_users">
<!--                                     <tr>
                                        <th scope="row">1</th>
                                        <td>Ana García</td>
                                        <td>ana.garcia@example.com</td>
                                        <td>Administrador</td>
                                        <td><span class="badge bg-success">Activo</span></td>
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil-square"></i></button>
                                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /Page Content -->

             <!-- Modal para Registro de Usuario -->
    <div class="modal fade" id="registroUsuarioModal" tabindex="-1" aria-labelledby="registroUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="registroUsuarioModalLabel">Registrar Nuevo Usuario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frm_new_user">
                        <div class="mb-3">
                            <label for="nombreCompleto" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" placeholder="Ingrese el nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="emailUsuario" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="emailUsuario" name="emailUsuario" placeholder="usuario@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="passwordUsuario" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="passwordUsuario" name="passwordUsuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="rolUsuario" class="form-label">Rol</label>
                            <select class="form-select" id="rolUsuario" name="rolUsuario">
                                <option selected>Seleccione un rol...</option>
                                <option value="admin">Administrador</option>
                                <option value="empleado">Empleado</option>
                                <option value="cliente">Cliente</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="registrarUsuario();">Guardar Usuario</button>
                </div>
            </div>
        </div>
    </div>
  <!-- Modal para editar usuario -->
    <div class="modal fade" id="actualizarUsuario" tabindex="-1" aria-labelledby="actualizarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="actualizarUsuarioLabel">Actualizar Usuario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frm_update_user">
                        <input type="hidden" id="data" name="data">
                        <div class="mb-3">
                            <label for="new_nombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="new_nombre" name="new_nombre" placeholder="Ingrese el nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="NewEmail" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="NewEmail" name="NewEmail" placeholder="usuario@example.com" required>
                        </div>
<!--                         <div class="mb-3">
                            <label for="NewPassword" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="NewPassword" name="NewPassword" required>
                        </div> -->
                        <div class="mb-3">
                            <label for="newRol" class="form-label">Rol</label>
                            <select class="form-select" id="newRol" name="newRol">
                                <option selected>Seleccione un rol...</option>
                                <option value="admin">Administrador</option>
                                <option value="empleado">Empleado</option>
                                <option value="cliente">Cliente</option>
                            </select>
                        </div>
                         <div class="mb-3">
                            <label for="estadoUsuario" class="form-label">Estado</label>
                            <select class="form-select" id="estadoUsuario" name="estadoUsuario">
                                <option value="1" selected>Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="actualizarUsuario();">Guardar Usuario</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo BASE_URL;?>src/view/js/Usuarios.js"></script>