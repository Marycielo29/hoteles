document.addEventListener('DOMContentLoaded', function(){
    listarClientes();
});

// LISTAR CLIENTES
async function listarClientes() {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        let respuesta = await fetch(base_url_server+'src/control/ClientController.php?tipo=listarClientes',{
            method: 'POST',
            mode: 'cors',
            cache : 'no-cache',
            body : datos
        });
        json = await respuesta.json();
        let bodyHtml = document.getElementById("tbody_clienteApi");
        if (json.status){
            bodyHtml.innerHTML = "";
            let datos = json.contenido;
            let cont = 0;
            datos.forEach(item => {
                let nuevaFila =  document.createElement("tr");
                nuevaFila.id = item.id;
                cont ++;
                nuevaFila.innerHTML = `
                <td scope="row">${cont}</td>
                <td>${item.ruc}</td>
                <td>${item.razon_social}</td>
                <td>${item.telefono}</td>
                <td>${item.correo}</td>
                <td>${item.estado}</td>
                <td class="text-center">${item.options}</td>
                `;
                document.querySelector('#tbody_clienteApi').appendChild(nuevaFila);
            });
        }
    } catch (e) {
        console.log('Error listarClientes || '+ e);   
    }
}

// REGISTRAR CLIENTE
async function registrarCliente(){
    try {
        let datos = new FormData(frm_new_clienteApi);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        let respuesta = await fetch(base_url_server+'src/control/ClientController.php?tipo=registrarCliente',{
            method : 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if(json.status){
            let formOrg = document.getElementById("frm_new_clienteApi");
            formOrg.reset();
            let modalEl = document.getElementById("registroCliente");
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


// OBTENER CLIENTE
async function obtenerCliente(id) {
    let data = document.getElementById("data");
    let ruc = document.getElementById("n_ruc");
    let razon = document.getElementById("n_razon_social");
    let telefono = document.getElementById("n_telefono");
    let correo = document.getElementById("n_correo");
    let estado = document.getElementById("estado");

    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('data', id);
        let respuesta = await fetch(base_url_server+'src/control/ClientController.php?tipo=obtenerCliente',{
            method: 'POST',
            mode: 'cors',
            cache : 'no-cache',
            body : datos
        });
        json = await respuesta.json();
        if (json.status){
            let datos = json.contenido;
            data.value = datos.id;
            ruc.value = datos.ruc;
            razon.value = datos.razon_social;
            telefono.value = datos.telefono;
            correo.value = datos.correo;
            estado.value = datos.estado;
        }
    } catch (e) {
        console.log("Error obtenerCliente || " + e);
    }
}

// ACTUALIZAR CLIENTE
async function actualizarCliente() {
    let data = document.getElementById("data").value;
    try {
        let datos = new FormData(frm_upd_clienteApi);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('data', data );
        let respuesta = await fetch(base_url_server+'src/control/ClientController.php?tipo=actualizarCliente',{
            method : 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if(json.status){
            let formOrg = document.getElementById("frm_upd_clienteApi");
            formOrg.reset();
            let modalEl = document.getElementById("actualizarCliente");
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

