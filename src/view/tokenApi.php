<div class="main-content">
    <br>
    <div class="card">
        <div class="card-header">
            Gestión de Tokens API
        </div>
        <div class="card-body">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Token</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_tokenApi">
                        <!-- Tokens aquí -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal actualizar token -->
    <div class="modal fade" id="actualizarToken" tabindex="-1" aria-labelledby="actualizarTokenLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="actualizarTokenLabel">Actualizar Token</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frm_upd_tokenApi">
                        <div class="mb-3">
                            <label for="n_token" class="form-label">Nuevo Token</label>
                            <input type="text" class="form-control" id="n_token" name="n_token" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="actualizarToken();">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo BASE_URL;?>src/view/js/tokenApi.js"></script>
