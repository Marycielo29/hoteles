document.addEventListener('DOMContentLoaded', function(){
    listarServicios();
});
async function listarServicios() {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('id_hotel', id_hotel);
        let respuesta = await fetch(base_url_server+'src/control/servicios.php?tipo=listarServicios',{
            method: 'POST',
            mode: 'cors',
            cache : 'no-cache',
            body : datos
        });
        json = await respuesta.json();
        let bodyHtml = document.getElementById("tbody_servicios");
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
                <td>${item.nombre}</td>
                <td class="text-center">${item.options}</td>
                `;
                document.querySelector('#tbody_servicios').appendChild(nuevaFila);
            });
        }
    } catch (e) {
        console.log('Erro function || '+ e);   
    }
}

async function registrarServicio(){
    try {
        let datos = new FormData(frm_new_servicio);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('id_hotel', id_hotel);
        let respuesta = await fetch(base_url_server+'src/control/servicios.php?tipo=registrarServicio',{
            method : 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if(json.status){
            let formOrg = document.getElementById("frm_new_servicio");
             formOrg.reset();
             let modalEl = document.getElementById("registroServicioModal");
             let modal = bootstrap.Modal.getInstance(modalEl);
      // Cerrar modal
            modal.hide();
            Swal.fire({
            position: "top-end",
            icon: "success",
            title: json.mensaje,
            showConfirmButton: false,
            timer: 1500
            });
            listarServicios();
        }else{
            Swal.fire({
                text: json.mensaje,
                icon: 'error',
                confirmButtonText: 'OK'
                });
        }
    } catch (e) {
        console.log('error function || ' + e);
    }
}


function antesEliminarServicio(id){
 Swal.fire({
  title: "Eliminar Habitacion?",
  text: "¿Estas seguro que quieres eliminar esta habitacion?",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Sí, eliminalo!"
}).then((result) => {
  if (result.isConfirmed) {
   eliminarServicio(id);
  }
});
}
async function eliminarServicio(id) {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('data', id);
        let respuesta = await fetch(base_url_server+'src/control/servicios.php?tipo=eliminarServicio',{
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
            listarServicios();
        }else{
             Swal.fire({
                text: json.mensaje,
                icon: 'error',
                confirmButtonText: 'OK'
                });
        }
    } catch (e) {
        console.log('Erro function || '+ e);   
    }
}

async function obtenerServicio(id) {
    let data = document.getElementById("data");
    let nombre = document.getElementById("n_nombreServicio");
  try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('data', id);
        let respuesta = await fetch(base_url_server+'src/control/servicios.php?tipo=obtenerServicio',{
            method: 'POST',
            mode: 'cors',
            cache : 'no-cache',
            body : datos
        });
        json = await respuesta.json();
        if (json.status){
            let dato = json.contenido;
            data.value = dato.servicio_id;
            nombre.value = dato.nombre;
        }
  } catch (e) {
    console.log("erro function || " + e);
  }
}

async function actualizarServicio() {
    let data = document.getElementById("data").value;
    try {
        let datos = new FormData(frm_upd_servicio);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('data', data );
        let respuesta = await fetch(base_url_server+'src/control/servicios.php?tipo=actualizarServicio',{
            method : 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if(json.status){
            let formOrg = document.getElementById("frm_upd_servicio");
             formOrg.reset();
             let modalEl = document.getElementById("actualizarServicio");
             let modal = bootstrap.Modal.getInstance(modalEl);
      // Cerrar modal
            modal.hide();
            Swal.fire({
            position: "top-end",
            icon: "success",
            title: json.mensaje,
            showConfirmButton: false,
            timer: 1500
            });
            listarServicios();
        }else{
            Swal.fire({
                text: json.mensaje,
                icon: 'error',
                confirmButtonText: 'OK'
                });
        }
    } catch (e) {
        console.log('error function || ' + e);
    }
}
