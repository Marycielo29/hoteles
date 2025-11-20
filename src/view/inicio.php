<!-- Page Content -->
<section class="container-fluid p-4">
    <style>
    :root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --danger-gradient: linear-gradient(135deg, #57a608ff 0%, #72e222ff 100%);
    --info-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --dark-gradient: linear-gradient(135deg, #e0f3ff 0%, #4a90e2 50%, #0a1f44 100%);
    --secondary-gradient: linear-gradient(135deg, #ffe5e9 0%, #c41e3a 50%, #3b000f 100%);
    --secon-gradient: linear-gradient(135deg, #f3e8ff 0%, #9b5de5 50%, #2d0052 100%);
    --glass-bg: rgba(255, 255, 255, 0.9);
    --glass-border: rgba(0, 0, 0, 0.1);
    --shadow-soft: 0 8px 24px rgba(0, 0, 0, 0.1);
    --shadow-hover: 0 15px 35px rgba(0, 0, 0, 0.15);
}

body {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}

.card {
    background: var(--glass-bg) !important;
    backdrop-filter: blur(12px) !important;
    border: 1px solid var(--glass-border) !important;
    border-radius: 20px !important;
    box-shadow: var(--shadow-soft) !important;
    transition: all 0.3s ease !important;
    overflow: hidden !important;
    position: relative !important;
}

.card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px; opacity: 0.85;
}
.card.bg-primary::before { background: var(--primary-gradient); }
.card.bg-success::before { background: var(--success-gradient); }
.card.bg-warning::before { background: var(--warning-gradient); }
.card.bg-danger::before { background: var(--danger-gradient); }

.card:hover {
    transform: translateY(-8px) scale(1.02) !important;
    box-shadow: var(--shadow-hover) !important;
}

/* Íconos */
.bi.fs-2 {
    width: 60px; height: 60px;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    margin-right: 1rem;
    color: white;
    flex-shrink: 0;
}
.card.bg-primary .bi.fs-2 { background: var(--primary-gradient); }
.card.bg-success .bi.fs-2 { background: var(--success-gradient); }
.card.bg-warning .bi.fs-2 { background: var(--warning-gradient); color: #2d3748; }
.card.bg-danger .bi.fs-2 { background: var(--danger-gradient); }

/* Textos en negro */
.fs-5.fw-bold {
    font-size: 1.75rem !important;
    font-weight: 700 !important;
    color: #1a202c !important;
    margin-bottom: 0.25rem !important;
}
.text-dark-50 {
    font-size: 0.9rem !important;
    font-weight: 500 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px;
    color: #4a5568 !important;
}

.card-footer {
    background: rgba(255, 255, 255, 0.6) !important;
    backdrop-filter: blur(10px) !important;
    border: none !important;
    margin-top: 1rem;
    padding: 0.75rem 1.25rem !important;
    border-top: 1px solid var(--glass-border) !important;
}
.card-footer a {
    font-size: 0.9rem; font-weight: 600;
    color: #2d3748 !important; text-decoration: none !important;
    display: inline-flex; align-items: center;
}
.card-footer a i { transition: transform 0.2s ease; }
.card-footer a:hover i { transform: translateX(4px); }
.card-footer a:hover { color: #1a202c !important; }

.card-header {
    background: var(--primary-gradient) !important;
    border: none !important;
    padding: 1.25rem 1.5rem !important;
    font-weight: 600 !important;
    font-size: 1.1rem !important;
    color: white !important;
    border-bottom: 1px solid rgba(255,255,255,0.15) !important;
}
.card-header.bg-info { background: var(--info-gradient) !important; }
.card-header.bg-danger { background: var(--danger-gradient) !important; }

/* Badges más oscuros */
.badge.bg-secondary {
    background: #4a5568 !important;
    color: white !important;
}

/* 👇 Solo servicios y habitaciones: texto e íconos negros */
.card-body .list-group-item,
.card-body .list-group-item i {
    color: #000 !important;
}

        
    </style>

    <h1 class="mt-4 mb-4 text-dark fw-bold">
        Bienvenido <?php echo $_SESSION['sesion_usuario_nom']; ?>
    </h1>
    <p class="lead text-secondary">
        Esta es la sección principal  modo administrador donde se mostrará el contenido de tu aplicación.
    </p>

    <!-- Tarjetas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-building-fill fs-2" style="background: var(--primary-gradient);"></i>
                    <div>
                        <div class="fs-5 fw-bold">12</div>
                        <div class="text-dark-50">Hoteles</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo BASE_URL;?>hoteles">Ver Detalles <i class="bi bi-arrow-right-short"></i> 
                </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-person-fill fs-2" style="background: var(--success-gradient);"></i>
                    <div>
                        <div class="fs-5 fw-bold">01</div>
                        <div class="text-dark-50">Usuario</div>
                    </div>
                </div>
                <div class="card-footer">
                    <!-- <a href="#">Ver Detalles <i class="bi bi-arrow-right-short"></i></a> -->
                     <a href="<?php echo BASE_URL;?>usuario">Ver Detalles <i class="bi bi-arrow-right-short"></i>
                </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-calendar-check fs-2" style="background: var(--warning-gradient); color:#2d3748;"></i>
                    <div>
                        <div class="fs-5 fw-bold">03</div>
                        <div class="text-dark-50">Habitaciones</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#">Ver Detalles <i class="bi bi-arrow-right-short"></i></a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-bell-fill fs-2" style="background: var(--danger-gradient);"></i>
                    <div>
                        <div class="fs-5 fw-bold">05</div>
                        <div class="text-dark-50">servicios</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#">Ver Detalles <i class="bi bi-arrow-right-short"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas 2-->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-people-fill fs-2" style="background: var(--dark-gradient);"></i>
                    <div>
                        <div class="fs-5 fw-bold">02</div>
                        <div class="text-dark-50">Clientes</div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo BASE_URL;?>clients">Ver Detalles <i class="bi bi-arrow-right-short"></i> 
                </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-key-fill fs-2" style="background: var(--secondary-gradient);"></i>
                    <div>
                        <div class="fs-5 fw-bold">01</div>
                        <div class="text-dark-50">Token Api</div>
                    </div>
                </div>
                <div class="card-footer">
                    <!-- <a href="#">Ver Detalles <i class="bi bi-arrow-right-short"></i></a> -->
                     <a href="<?php echo BASE_URL;?>tokenApi">Ver Detalles <i class="bi bi-arrow-right-short"></i>
                </a>
                </div>
            </div>
        </div>

            <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-key-fill fs-2" style="background: var(--secon-gradient);"></i>
                    <div>
                        <div class="fs-5 fw-bold">Api</div>
                        <div class="text-dark-50">Reservas</div>
                    </div>
                </div>
                <div class="card-footer">
                    <!-- <a href="#">Ver Detalles <i class="bi bi-arrow-right-short"></i></a> -->
                     <a href="<?php echo BASE_URL;?>api">Ver Detalles <i class="bi bi-arrow-right-short"></i>
                </a>
                </div>
            </div>
        </div>
    </div>

    


    <!-- habitaciones -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-info">
                    Tipo de habitaciones
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-dark">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Simple
                            <span class="badge bg-secondary float-end">Disponible</span>
                        </li>
                        <li class="list-group-item text-dark">
                           <i class="bi bi-check-circle text-success me-2"></i>
                            Doble
                            <span class="badge bg-secondary float-end">Disponible</span>
                        </li>
                        <li class="list-group-item text-dark">
                           <i class="bi bi-check-circle text-success me-2"></i>
                            Suite
                            <span class="badge bg-secondary float-end">Disponible</span>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
         <!-- servicios -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-danger">
                    Tipos de servicios
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-dark">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Cochera
                            <span class="badge bg-secondary float-end">Incluido</span>
                        </li>
                        <li class="list-group-item text-dark">
                           <i class="bi bi-check-circle text-success me-2"></i>
                            Piscina
                            <span class="badge bg-secondary float-end">Incluido</span>
                        </li>
                        <li class="list-group-item text-dark">
                           <i class="bi bi-check-circle text-success me-2"></i>
                            Restaurante
                            <span class="badge bg-secondary float-end">Incluido</span>
                        </li>
                        <li class="list-group-item text-dark">
                           <i class="bi bi-check-circle text-success me-2"></i>
                            Wifi
                            <span class="badge bg-secondary float-end">Incluido</span>
                        </li>
                          <li class="list-group-item text-dark">
                           <i class="bi bi-check-circle text-success me-2"></i>
                            Agua caliente
                            <span class="badge bg-secondary float-end">Incluido</span>
                        </li>
                         <li class="list-group-item text-dark">
                           <i class="bi bi-check-circle text-success me-2"></i>
                            Netflix
                            <span class="badge bg-secondary float-end">Incluido</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Page Content -->
