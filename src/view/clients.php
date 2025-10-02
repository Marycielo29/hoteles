    <style>

        .main-content {
            /* Este es el contenedor principal */
            width: 100%;
            max-width: 1200px; /* Ancho máximo opcional */
            margin: auto;
        }

        .btn-primary {
            background-color: #6a3ab2; /* Tono morado sólido */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            transition: background-color 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #593094;
        }

        .btn-primary i {
            margin-right: 8px;
        }

        .card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .card-header {
            background-color: #343a40;
            color: white;
            padding: 16px 24px;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .card-body {
            padding: 24px;
        }

        .table-container {
            overflow-x: auto; /* Para que la tabla sea responsive en móviles */
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
            white-space: nowrap; /* Evita que el texto se rompa */
        }

        .table thead th {
            background-color: #e9ecef;
            font-weight: 600;
            color: #495057;
        }
        
        /* Estilos para las etiquetas de estado */
        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: capitalize;
        }

        .status-activo {
            background-color: #d4edda;
            color: #155724;
        }

        .status-inactivo {
            background-color: #f8d7da;
            color: #721c24;
        }

        .action-btn {
            border: none;
            padding: 8px 10px;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            margin-right: 5px;
            font-size: 14px;
        }
        
        .btn-edit { background-color: #f0ad4e; } /* Amarillo */
        .btn-delete { background-color: #d9534f; } /* Rojo */
    </style>

<div class="main-content">
    <br>
<button class="btn-primary" style="margin-bottom: 20px;" data-bs-toggle="modal" data-bs-target="#registroCliente"><i class="fas fa-plus"></i> Agregar Cliente</button>
        <!-- Sección de Gestión de Clientes API -->
        <div class="card">
            <div class="card-header">
                Gestión de Clientes API
            </div>
            <div class="card-body">
                
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>RUC</th>
                                <th>Razón Social</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_clienteApi">

<!--                             <tr>
                                <td>1</td>
                                <td>20123456789</td>
                                <td>Soluciones Digitales S.A.C.</td>
                                <td>987654321</td>
                                <td>contacto@solucionesdigitales.com</td>
                                <td><span class="status status-activo">Activo</span></td>
                                <td>
                                    <button class="action-btn btn-edit" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="action-btn btn-delete" title="Desactivar"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal para Registro de cliente -->
        <div class="modal fade" id="registroCliente" tabindex="-1" aria-labelledby="registroClienteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="registroClienteLabel">Registrar Nuevo cliente</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_new_clienteApi">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ruc" class="form-label">Ruc</label>
                                    <input type="text" class="form-control" id="ruc" name="ruc"  required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="razon_social" class="form-label">Razon Social</label>
                                    <input type="text" class="form-control" id="razon_social" name="razon_social"  required>
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Telefono</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="999999999" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="correo" name="correo"></input>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="registrarCliente();">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

                <!-- Modal para actualizar de cliente -->
        <div class="modal fade" id="actualizarCliente" tabindex="-1" aria-labelledby="actualizarClienteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="actualizarClienteLabel">Actualizar cliente</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_upd_clienteApi">
                          <input type="hidden" id="data" name="data" value="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="n_ruc" class="form-label">Ruc</label>
                                    <input type="text" class="form-control" id="n_ruc" name="n_ruc"  required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="n_razon_social" class="form-label">Razon Social</label>
                                    <input type="text" class="form-control" id="n_razon_social" name="n_razon_social"  required>
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="n_telefono" class="form-label">Telefono</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="n_telefono" name="n_telefono" placeholder="999999999" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="n_correo" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="n_correo" name="n_correo"></input>
                            </div>
                            <div class="col-md-6 mb-3">
                              <label for="estado" class="form-label">Estado</label>
                              <select class="form-select" id="estado" name="estado">
                                  <option selected>Seleccione Estado</option>
                                  <option value="0">Inactivo</option>
                                  <option value="1">Activo</option>
                              </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="actualizarCliente();">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
   <script src="<?php echo BASE_URL;?>src/view/js/clients.js"></script>
