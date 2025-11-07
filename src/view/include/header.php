<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoteles Huanta</title>
    <!-- Incluye los CSS de Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">    <!-- Iconos de Bootstrap (opcional, pero útil para un dashboard) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">    
<script><!-- Bootstrap Icons -->


        const base_url = '<?php echo BASE_URL; ?>';
        const base_url_server = '<?php echo BASE_URL_SERVER; ?>';
        const session_session = '<?php echo $_SESSION['sesion_id']; ?>';
        const token_token = '<?php echo $_SESSION['sesion_token']; ?>';
</script>
</head>
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --hover-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --glass-border: rgba(255, 255, 255, 0.18);
    }

    /* Sidebar negro */
    nav.bg-dark {
        background: #000 !important; /* Negro sólido */
        border-right: 1px solid var(--glass-border);
    }

    .sidebar-heading {
        color: #fff !important;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    /* Items del menú */
    .list-group-item {
        background: transparent !important;
        color: #f1f1f1 !important;
        border: none !important;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .list-group-item:hover,
    .list-group-item.active {
        background: var(--hover-gradient) !important;
        color: #fff !important;
        border-radius: 12px !important;
        transform: translateX(6px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .list-group-item i {
        color: #fff !important;
    }

    /* Navbar superior (degradado morado) */
    .navbar {
        background: var(--primary-gradient) !important;
        border-bottom: 1px solid var(--glass-border) !important;
    }

    .navbar .nav-link,
    .navbar .navbar-brand {
        color: #fff !important;
        font-weight: 500;
    }

    .navbar .dropdown-menu {
        border-radius: 12px !important;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    /* Footer degradado morado */
    footer {
        background: var(--primary-gradient) !important;
        color: #fff;
        text-align: center;
        padding: 1rem;
    }
</style>


<body class="bg-light">

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <nav class="bg-dark text-white p-3 shadow-lg vh-100 position-fixed" style="width: 250px;">
            <div class="sidebar-heading text-center py-4 fs-4 fw-bold border-bottom border-secondary mb-4">
                <i class="bi bi-house-fill"></i> HotelSeek
            </div>
            <div class="list-group list-group-flush">
                <a href="<?php echo BASE_URL;?>" class="list-group-item list-group-item-action active">
                    <i class="bi bi-house-door me-2"></i> Inicio
                </a>
                <a href="<?php echo BASE_URL;?>usuario" class="list-group-item list-group-item-action">
                    <i class="bi bi-people me-2"></i> Usuarios
                </a>
                <a href="<?php echo BASE_URL;?>hoteles" class="list-group-item list-group-item-action">
                    <i class="bi bi-building me-2"></i> Hoteles
                </a>
                <a href="<?php echo BASE_URL;?>clients" class="list-group-item list-group-item-action">
                    <i class="<bi bi-people me-2"></i> Clientes
                </a>
                 <a href="<?php echo BASE_URL;?>tokenApi" class="list-group-item list-group-item-action">
                    <i class="bi bi-lock-fill me-2"></i> Api
                </a>
                <a href="<?php echo BASE_URL;?>api" class="list-group-item list-group-item-action">
                    <i class="bi bi-file me-2"></i> Reservas
                </a>
                <a href="#" onclick="cerrar_sesion();" class="list-group-item list-group-item-action">
                    <i class="bi bi-box-arrow-right me-2"></i> Salir
                </a>
            </div>
        </nav>
        <!-- /Sidebar -->

        <!-- Page Content Wrapper -->
        <div id="page-content-wrapper" style="margin-left: 250px; width: calc(100% - 250px);">

            <!-- Navbar superior -->
            <nav class="navbar navbar-expand-lg navbar-light py-3 shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-primary d-block d-md-none" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <a class="navbar-brand ms-auto" href="#"> </a>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           <i class="bi bi-person-circle"></i> Admin
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" onclick="cerrar_sesion();">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- /Navbar superior -->
