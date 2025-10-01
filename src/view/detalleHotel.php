    <style>
        /* Estilos Generales para el Contenido */


        .main-content {
            /* Este es el contenedor principal que pediste */
            width: 100%;
            max-width: 1200px; /* Ancho máximo opcional */
            margin: auto;
        }

        .btn-primary {
            /* Estilo del botón "Agregar" sin el degradado */
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

        /* Estilos específicos para la página de detalle */
        .hotel-info-header {
            display: flex;
            align-items: center;
            flex-wrap: wrap; /* Para mejor responsividad */
            margin-bottom: 20px;
        }

        .hotel-info-header img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 24px;
            margin-bottom: 15px;
        }

        .hotel-details h2 {
            margin: 0;
            font-size: 1.8rem;
        }

        .hotel-details .stars {
            color: #f1c40f;
            margin: 5px 0;
        }

        .hotel-details p {
            margin: 5px 0;
            color: #6c757d;
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

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: capitalize;
        }

        .status-disponible {
            background-color: #d4edda;
            color: #155724;
        }

        .status-ocupada {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-mantenimiento {
            background-color: #fff3cd;
            color: #856404;
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

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 20px;
            text-align: center;
        }

        .service-item {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }

        .service-item i {
            font-size: 2rem;
            color: #8A2BE2; /* Morado */
            margin-bottom: 10px;
        }
    </style>
<div class="main-content">

        <!-- Sección de Detalles del Hotel -->
        <div class="card">
            <div class="card-body">
                <div class="hotel-info-header">
                    <img src="https://static.vecteezy.com/system/resources/previews/027/543/232/non_2x/hotel-logo-silhouette-hotel-icon-vector.jpg" alt="Fachada del Hotel">
                    <div class="hotel-details">
                        <h2 id="nombre_hotel">GRAN HOTEL IMPERIAL</h2>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <p id="direccion_hotel"><i class="fas fa-map-marker-alt"></i> Jr. Miguel Untiveros 257, Huanta 05121</p>
                        <p id="ciudad_hotel"><i class="fas fa-map-marker-alt"></i> JHuanta</p>
                        <p id="telefono_hotel"><i class="fas fa-phone"></i> 923056622</p>
                        <p id="descripcion_hotel"><i class="fas fa-phone"></i> 923056622</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Habitaciones -->
        <div class="card">
            <div class="card-header">
                Listado de Habitaciones
            </div>
            <div class="card-body">
                <button class="btn-primary" style="margin-bottom: 20px;" data-bs-toggle="modal" data-bs-target="#registroHabitacionModal"><i class="fas fa-plus"></i> Agregar Habitación</button>
                <div class="table-container">
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
        </div>
        
        <!-- Sección de Servicios -->
        <div class="card">
            <div class="card-header">
                Servicios Incluidos
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

    </div>
    <script> let id_hotel = '<?php echo $_GET['data'] ?>'</script>
    <script src="<?php echo BASE_URL;?>src/view/js/detalleHotel.js"></script>