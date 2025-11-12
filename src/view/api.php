<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas de Hotel - Estado en Vivo</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <div class="container-main px-4">
            <div class="logo">
                <i class="bi bi-building"></i>
                <span>Hotel Reservas</span>
            </div>
            <div class="header-info">
                <div class="info-item">
                    <i class="bi bi-calendar-event"></i>
                    <span id="fecha"></span>
                </div>
                <div class="info-item">
                    <i class="bi bi-clock"></i>
                    <span id="hora"></span>
                </div>
                <div class="info-item">
                    <i class="bi bi-info-circle"></i>
                    <span>Estado en vivo</span>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container-main px-4">
        <!-- ESTADÍSTICAS -->
        <div class="stats-section">
            <div class="stat-box">
                <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
                <div class="stat-label">Reservas Totales</div>
                <div class="stat-number" id="total_reservas">24</div>
            </div>
            <div class="stat-box">
                <div class="stat-icon"><i class="bi bi-exclamation-circle"></i></div>
                <div class="stat-label">Pendientes</div>
                <div class="stat-number">5</div>
            </div>
            <div class="stat-box">
                <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
                <div class="stat-label">Confirmadas</div>
                <div class="stat-number">12</div>
            </div>
            <div class="stat-box">
                <div class="stat-icon"><i class="bi bi-door-closed"></i></div>
                <div class="stat-label">Ocupadas</div>
                <div class="stat-number">18</div>
            </div>
        </div>

        <!-- RESERVAS PENDIENTES -->
        <h2 class="section-title">
            <i class="bi bi-hourglass-split"></i>
            Reservas Pendientes
        </h2>

        <!-- TOKEN DE API -->    

        <div class="mb-3">
            <label for="statusFilter" class="form-label">Filtrar por estado:</label>
            <select class="form-select" id="statusFilter" style="max-width: 200px;">
                <option value="all">Todos</option>
                <option value="pendiente">Pendiente</option>
                <option value="confirmada">Confirmada</option>
                <option value="cancelada">Cancelada</option>
                <option value="finalizada">Finalizada</option>
            </select>
        </div>

        <div class="reservas-grid" id="container_content">

            <!-- RESERVA 1 -->
            <div class="reserva-card">
                <div class="reserva-header pendiente">
                    <div>
                        <h6>Reserva #2024-001</h6>
                        <small>Habitación 305</small>
                    </div>
                    <span class="reserva-estado"><i class="bi bi-clock"></i> Pendiente</span>
                </div>
                <div class="reserva-body">

                    <div class="reserva-info">
                        <i class="bi bi-person-fill"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Cliente</div>
                            <div class="reserva-info-value">Carlos García</div>
                        </div>
                    </div>

                    <div class="reserva-info">
                        <i class="bi bi-building"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Hotel</div>
                            <div class="reserva-info-value">Hotel Sol Andino</div>
                        </div>
                    </div>

                    <div class="reserva-info">
                        <i class="bi bi-door-closed"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Tipo de Habitación</div>
                            <div class="reserva-info-value">Suite Doble</div>
                        </div>
                    </div>

                    <div class="reserva-info">
                        <i class="bi bi-wifi"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Servicios Incluidos</div>
                            <div class="reserva-info-value">Wi-Fi, Desayuno Buffet, Piscina, Estacionamiento</div>
                        </div>
                    </div>

                    <div class="reserva-info">
                        <i class="bi bi-calendar-event"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Entrada</div>
                            <div class="reserva-info-value">2025-10-20 · 15:00</div>
                        </div>
                    </div>

                    <div class="reserva-info">
                        <i class="bi bi-calendar-check"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Salida</div>
                            <div class="reserva-info-value">2025-10-23 · 11:00</div>
                        </div>
                    </div>

                    <div class="reserva-footer">
                        <span class="reserva-precio">S/. 850.00</span>
                        <span style="color: #999; font-size: 12px;">3 noches</span>
                    </div>
                </div>
            </div>

            <!-- RESERVA 2 -->
            <div class="reserva-card">
                <div class="reserva-header pendiente">
                    <div>
                        <h6>Reserva #2024-002</h6>
                        <small>Habitación 412</small>
                    </div>
                    <span class="reserva-estado"><i class="bi bi-clock"></i> Pendiente</span>
                </div>
                <div class="reserva-body">

                    <div class="reserva-info">
                        <i class="bi bi-person-fill"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Cliente</div>
                            <div class="reserva-info-value">María López</div>
                        </div>
                    </div>

                    <div class="reserva-info">
                        <i class="bi bi-building"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Hotel</div>
                            <div class="reserva-info-value">Hotel Costa Dorada</div>
                        </div>
                    </div>

                    <div class="reserva-info">
                        <i class="bi bi-door-closed"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Tipo de Habitación</div>
                            <div class="reserva-info-value">Habitación Familiar</div>
                        </div>
                    </div>

                    <div class="reserva-info">
                        <i class="bi bi-basket"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Servicios Incluidos</div>
                            <div class="reserva-info-value">Desayuno, Lavandería, Gimnasio</div>
                        </div>
                    </div>

                    <div class="reserva-info">
                        <i class="bi bi-calendar-event"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Entrada</div>
                            <div class="reserva-info-value">2025-10-21 · 14:00</div>
                        </div>
                    </div>

                    <div class="reserva-info">
                        <i class="bi bi-calendar-check"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Salida</div>
                            <div class="reserva-info-value">2025-10-25 · 11:00</div>
                        </div>
                    </div>

                    <div class="reserva-footer">
                        <span class="reserva-precio">S/. 1,250.00</span>
                        <span style="color: #999; font-size: 12px;">4 noches</span>
                    </div>
                </div>
            </div>
        </div>

      

    <!-- FOOTER -->
    <div class="footer">
        <p>&copy; 2025 Sistema de Reservas de Hotel. Actualización automática cada 5 minutos. | <a href="#">Contacto</a></p>
    </div>

    <script src="app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
