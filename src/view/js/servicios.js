document.addEventListener('DOMContentLoaded', function(){
    listarServicios();
});

/**
 * Listar servicios de un hotel
 */
async function listarServicios() {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('id_hotel', id_hotel);
        
        let respuesta = await fetch(base_url_server+'src/control/servicios.php?tipo=listarServicios', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        
        json = await respuesta.json();
        let bodyHtml = document.getElementById("tbody_servicios");
        
        if (json.status) {
            bodyHtml.innerHTML = "";
            let datos = json.contenido;
            let cont = 0;
            
            datos.forEach(item => {
                let nuevaFila = document.createElement("tr");
                nuevaFila.id = item.servicio_id; // ID del servicio
                cont++;
                nuevaFila.innerHTML = `
                    <td scope="row">${cont}</td>
                    <td>${item.nombre}</td>
                    <td class="text-center">${item.options}</td>
                `;
                document.querySelector('#tbody_servicios').appendChild(nuevaFila);
            });
        } else {
            // Mostrar mensaje si no hay servicios
            bodyHtml.innerHTML = `
                <tr>
                    <td colspan="3" class="text-center text-muted">
                        No hay servicios registrados para este hotel
                    </td>
                </tr>
            `;
        }
    } catch (e) {
        console.log('Error function listarServicios || ' + e);   
    }
}

/**
 * Registrar nuevo servicio
 */
async function registrarServicio() {
    try {
        let datos = new FormData(frm_new_servicio);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('id_hotel', id_hotel);
        
        let respuesta = await fetch(base_url_server+'src/control/servicios.php?tipo=registrarServicio', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        
        json = await respuesta.json();
        
        if (json.status) {
            let formOrg = document.getElementById("frm_new_servicio");
            formOrg.reset();
            
            let modalEl = document.getElementById("registroServicioModal");
            let modal = bootstrap.Modal.getInstance(modalEl);
            
            // Cerrar modal
            if (modal) {
                modal.hide();
            }
            
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: json.mensaje,
                showConfirmButton: false,
                timer: 1500
            });
            
            listarServicios();
        } else {
            Swal.fire({
                text: json.mensaje,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    } catch (e) {
        console.log('Error function registrarServicio || ' + e);
    }
}

/**
 * Confirmar antes de eliminar servicio
 * ACTUALIZADO: Ahora recibe también el id_hotel
 */
function antesEliminarServicio(id, idHotel = null) {
    // Si no se pasa idHotel, usar la variable global
    const hotelId = idHotel || id_hotel;
    
    Swal.fire({
        title: "¿Eliminar Servicio?",
        text: "¿Estás seguro que quieres eliminar este servicio del hotel?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, elimínalo!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            eliminarServicio(id, hotelId);
        }
    });
}

/**
 * Eliminar servicio (relación hotel-servicio)
 * ACTUALIZADO: Ahora envía el id_hotel al backend
 */
async function eliminarServicio(id, idHotel) {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('data', id);
        datos.append('id_hotel', idHotel); // ⭐ NUEVO: Agregar id_hotel
        
        let respuesta = await fetch(base_url_server+'src/control/servicios.php?tipo=eliminarServicio', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        
        json = await respuesta.json();
        
        if (json.status) {
            Swal.fire({
                text: json.mensaje,
                icon: 'success',
                confirmButtonText: 'OK'
            });
            listarServicios();
        } else {
            Swal.fire({
                text: json.mensaje,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    } catch (e) {
        console.log('Error function eliminarServicio || ' + e);   
    }
}

/**
 * Obtener información de un servicio para editar
 */
async function obtenerServicio(id) {
    let data = document.getElementById("data");
    let nombre = document.getElementById("n_nombreServicio");
    
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('data', id);
        
        let respuesta = await fetch(base_url_server+'src/control/servicios.php?tipo=obtenerServicio', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        
        json = await respuesta.json();
        
        if (json.status) {
            let dato = json.contenido;
            data.value = dato.servicio_id;
            nombre.value = dato.nombre;
        } else {
            Swal.fire({
                text: json.mensaje || 'Error al obtener el servicio',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    } catch (e) {
        console.log("Error function obtenerServicio || " + e);
    }
}

/**
 * Actualizar servicio
 */
async function actualizarServicio() {
    let data = document.getElementById("data").value;
    
    try {
        let datos = new FormData(frm_upd_servicio);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('data', data);
        
        let respuesta = await fetch(base_url_server+'src/control/servicios.php?tipo=actualizarServicio', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        
        json = await respuesta.json();
        
        if (json.status) {
            let formOrg = document.getElementById("frm_upd_servicio");
            formOrg.reset();
            
            let modalEl = document.getElementById("actualizarServicio");
            let modal = bootstrap.Modal.getInstance(modalEl);
            
            // Cerrar modal
            if (modal) {
                modal.hide();
            }
            
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: json.mensaje,
                showConfirmButton: false,
                timer: 1500
            });
            
            listarServicios();
        } else {
            Swal.fire({
                text: json.mensaje,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    } catch (e) {
        console.log('Error function actualizarServicio || ' + e);
    }
}

/**
 * NUEVA FUNCIÓN: Listar todos los servicios disponibles (opcional)
 * Útil si quieres mostrar un selector de servicios existentes
 */
async function listarTodosServiciosDisponibles() {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        
        let respuesta = await fetch(base_url_server+'src/control/servicios.php?tipo=listarTodosServicios', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        
        json = await respuesta.json();
        
        if (json.status) {
            return json.contenido;
        }
        
        return [];
    } catch (e) {
        console.log('Error function listarTodosServiciosDisponibles || ' + e);
        return [];
    }
}

/**
 * NUEVA FUNCIÓN: Verificar si un servicio ya está en el hotel
 */
async function verificarServicioEnHotel(idServicio, idHotel) {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('id_servicio', idServicio);
        datos.append('id_hotel', idHotel);
        
        let respuesta = await fetch(base_url_server+'src/control/servicios.php?tipo=verificarServicioEnHotel', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        
        json = await respuesta.json();
        
        if (json.status) {
            return json.existe;
        }
        
        return false;
    } catch (e) {
        console.log('Error function verificarServicioEnHotel || ' + e);
        return false;
    }
}