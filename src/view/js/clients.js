document.addEventListener('DOMContentLoaded', function(){
    listarClientes();
});

// LISTAR CLIENTES
async function listarClientes() {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        let respuesta = await fetch(base_url_server+'src/control/clients.php?tipo=listarClientes',{
            method: 'POST',
            mode: 'cors',
            cache : 'no-cache',
            body : datos
        });
        json = await respuesta.json();
        let bodyHtml = document.getElementById("tbody_clients");
        if (json.status){
            bodyHtml.innerHTML = "";
            let datos = json.contenido;
            let cont = 0;
            datos.forEach(item => {
                let nuevaFila =  document.createElement("tr");
                nuevaFila.id = item.cliente_id;
                cont ++;
                nuevaFila.innerHTML = `
                <td scope="row">${cont}</td>
                <td>${item.ruc}</td>
                <td>${item.razon_social}</td>
                <td>${item.telefono}</td>
                <td>${item.correo}</td>
                <td class="text-center">${item.options}</td>
                `;
                document.querySelector('#tbody_clients').appendChild(nuevaFila);
            });
        }
    } catch (e) {
        console.log('Error listarClientes || '+ e);   
    }
}

// REGISTRAR CLIENTE
async function registrarCliente(){
    try {
        let datos = new FormData(frm_new_client);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        let respuesta = await fetch(base_url_server+'src/control/clients.php?tipo=registrarCliente',{
            method : 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if(json.status){
            let formOrg = document.getElementById("frm_new_client");
            formOrg.reset();
            let modalEl = document.getElementById("registroClienteModal");
            let modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();

            Swal.fire({
                position: "top-end",
                icon: "success",
                title: json.mensaje,
                showConfirmButton: false,
                timer: 1500
            });

            listarClientes();
        }else{
            Swal.fire({
                text: json.mensaje,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    } catch (e) {
        console.log('Error registrarCliente || ' + e);
    }
}

// CONFIRMAR ELIMINAR
function antesEliminarCliente(id){
    Swal.fire({
        title: "Eliminar Cliente?",
        text: "¿Estas seguro que quieres eliminar este cliente?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminalo!"
    }).then((result) => {
        if (result.isConfirmed) {
            eliminarCliente(id);
        }
    });
}

// ELIMINAR CLIENTE
async function eliminarCliente(id) {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('idCliente', id);
        let respuesta = await fetch(base_url_server+'src/control/clients.php?tipo=eliminarCliente',{
            method: 'POST',
            mode: 'cors',
            cache : 'no-cache',
            body : datos
        });
        json = await respuesta.json();
        if (json.status){
            Swal.fire({
                text: json.mensaje,
                icon: 'success',
                confirmButtonText: 'OK'
            });
            listarClientes();
        }else{
            Swal.fire({
                text: json.mensaje,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    } catch (e) {
        console.log('Error eliminarCliente || '+ e);   
    }
}

// OBTENER CLIENTE
async function obtenerCliente(id) {
    let data = document.getElementById("data");
    let ruc = document.getElementById("upd_ruc");
    let razon = document.getElementById("upd_razon_social");
    let telefono = document.getElementById("upd_telefono");
    let correo = document.getElementById("upd_correo");

    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('data', id);
        let respuesta = await fetch(base_url_server+'src/control/clients.php?tipo=obtenerCliente',{
            method: 'POST',
            mode: 'cors',
            cache : 'no-cache',
            body : datos
        });
        json = await respuesta.json();
        if (json.status){
            let dato = json.contenido;
            data.value = dato.cliente_id;
            ruc.value = dato.ruc;
            razon.value = dato.razon_social;
            telefono.value = dato.telefono;
            correo.value = dato.correo;
        }
    } catch (e) {
        console.log("Error obtenerCliente || " + e);
    }
}

// ACTUALIZAR CLIENTE
async function actualizarCliente() {
    let data = document.getElementById("data").value;
    try {
        let datos = new FormData(frm_upd_client);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('data', data );
        let respuesta = await fetch(base_url_server+'src/control/clients.php?tipo=actualizarCliente',{
            method : 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if(json.status){
            let formOrg = document.getElementById("frm_upd_client");
            formOrg.reset();
            let modalEl = document.getElementById("actualizarClienteModal");
            let modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();

            Swal.fire({
                position: "top-end",
                icon: "success",
                title: json.mensaje,
                showConfirmButton: false,
                timer: 1500
            });

            listarClientes();
        }else{
            Swal.fire({
                text: json.mensaje,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    } catch (e) {
        console.log('Error actualizarCliente || ' + e);
    }
}
