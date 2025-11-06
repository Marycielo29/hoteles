document.addEventListener('DOMContentLoaded', function(){
    listarTokens();
});

// ===== LISTAR TOKENS =====
async function listarTokens() {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);

        let respuesta = await fetch(base_url_server + 'src/control/tokenapiController.php?tipo=listarTokens', {
            method: 'POST',
            body: datos
        });

        // Leer primero como texto
        let texto = await respuesta.text();

        // Validar que el texto sea JSON válido
        if (!texto.trim().startsWith('{') && !texto.trim().startsWith('[')) {
            console.error("Respuesta no JSON:", texto);
            Swal.fire({
                icon: "error",
                title: "Error en el servidor",
                text: "El servidor devolvió una respuesta no válida.",
            });
            return;
        }

        let json = JSON.parse(texto);
        let tbody = document.getElementById("tbody_tokenApi");
        tbody.innerHTML = "";

        if (json.status) {
            let cont = 0;
            json.contenido.forEach(item => {
                cont++;
                let tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${cont}</td>
                    <td>${item.token}</td>
                    <td>
                        <button class="btn btn-outline-secondary btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#actualizarToken" 
                            onclick="cargarToken('${item.token}')">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        } else {
            tbody.innerHTML = `<tr><td colspan="3" class="text-center text-muted">${json.mensaje}</td></tr>`;
        }

    } catch (e) {
        console.error("Error listarTokens || ", e);
        Swal.fire({
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo conectar con el servidor."
        });
    }
}

// ===== CARGAR TOKEN =====
function cargarToken(token) {
    document.getElementById("n_token").value = token;
}

// ===== ACTUALIZAR TOKEN =====
async function actualizarToken() {
    try {
        let datos = new FormData(document.getElementById("frm_upd_tokenApi"));
        datos.append('sesion', session_session);
        datos.append('token', token_token);

        let respuesta = await fetch(base_url_server + 'src/control/tokenapiController.php?tipo=actualizarToken', {
            method: 'POST',
            body: datos
        });

        let texto = await respuesta.text();
        if (!texto.trim().startsWith('{')) {
            console.error("Respuesta no JSON:", texto);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "El servidor devolvió una respuesta no válida."
            });
            return;
        }

        let json = JSON.parse(texto);
        if (json.status) {
            Swal.fire({
                icon: "success",
                title: json.mensaje,
                timer: 1500,
                showConfirmButton: false,
                position: "top-end"
            });
            let modal = bootstrap.Modal.getInstance(document.getElementById("actualizarToken"));
            modal.hide();
            listarTokens();
        } else {
            Swal.fire({
                icon: "error",
                text: json.mensaje
            });
        }

    } catch (e) {
        console.error("Error actualizarToken || ", e);
    }
}
