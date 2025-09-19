   <!-- Footer -->
            <footer class="bg-dark text-white text-center py-3 mt-auto shadow-lg">
                <div class="container">
                    <p class="mb-0">&copy; 2025 Dashboard Hoteles - Huanta. Todos los derechos reservados.</p>
                </div>
            </footer>
            <!-- /Footer -->

        </div>
        <!-- /Page Content Wrapper -->

    </div>

    <!-- Incluye los JS de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>  
<script src="<?php echo BASE_URL;?>src/view/js/sesion.js"></script>  
<script>
        // JavaScript para alternar el sidebar en pantallas pequeñas (opcional)
        var sidebarToggle = document.getElementById("sidebarToggle");
        if (sidebarToggle) {
            sidebarToggle.addEventListener("click", function() {
                var wrapper = document.getElementById("wrapper");
                if (wrapper) {
                    wrapper.classList.toggle("toggled");
                }
            });
        }
    </script>
</body>
</html>




