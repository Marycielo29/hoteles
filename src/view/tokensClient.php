     <style>
        .main-content {
            width: 100%;
            max-width: 1200px;
            margin: auto;
        }

        .btn-primary {
            background-color: #6a3ab2;
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
        
        .card-header .client-name {
            font-weight: normal;
            color: #e0e0e0;
            font-style: italic;
        }

        .card-body {
            padding: 24px;
        }

        .table-container {
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
            white-space: nowrap;
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

        .status-activo {
            background-color: #d4edda;
            color: #155724;
        }

        .status-revocado {
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
        
        .btn-delete { background-color: #d9534f; } /* Rojo */

        .token-cell {
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            align-items: center;
        }

        .copy-icon {
            margin-left: 10px;
            cursor: pointer;
            color: #6c757d;
        }
        .copy-icon:hover {
            color: #343a40;
        }
    </style>
 <div class="main-content">

        <!-- Sección de Gestión de Tokens API -->
        <div class="card">
            <div class="card-header">
                Gestión de Tokens API para: <span class="client-name">Soluciones Digitales S.A.C.</span>
            </div>
            <div class="card-body">
                <button class="btn-primary" style="margin-bottom: 20px;"><i class="fas fa-key"></i> Generar Nuevo Token</button>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Token</th>
                                <th>Fecha de Creación</th>
                                <th>Fecha de Expiración</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="token-cell">
                                    <span>sk_live_xxxx...a4f8</span>
                                    <i class="far fa-copy copy-icon" title="Copiar token"></i>
                                </td>
                                <td>2024-09-20 11:45:00</td>
                                <td>2025-09-20 11:45:00</td>
                                <td><span class="status status-activo">Activo</span></td>
                                <td>
                                    <button class="action-btn btn-delete" title="Revocar Token"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="token-cell">
                                    <span>sk_live_xxxx...b9c1</span>
                                    <i class="far fa-copy copy-icon" title="Copiar token"></i>
                                </td>
                                <td>2024-05-10 09:00:00</td>
                                <td>2025-05-10 09:00:00</td>
                                <td><span class="status status-activo">Activo</span></td>
                                <td>
                                    <button class="action-btn btn-delete" title="Revocar Token"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="token-cell">
                                    <span>sk_live_xxxx...d3e7</span>
                                </td>
                                <td>2023-11-01 16:20:30</td>
                                <td>2024-11-01 16:20:30</td>
                                <td><span class="status status-revocado">Revocado</span></td>
                                <td>
                                    <!-- No hay acciones para un token revocado -->
                                </td>
                            </tr>
                             <tr>
                                <td>4</td>
                                <td class="token-cell">
                                    <span>sk_test_xxxx...f2a5</span>
                                    <i class="far fa-copy copy-icon" title="Copiar token"></i>
                                </td>
                                <td>2024-01-15 12:00:00</td>
                                <td>Nunca</td>
                                <td><span class="status status-activo">Activo</span></td>
                                <td>
                                    <button class="action-btn btn-delete" title="Revocar Token"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
