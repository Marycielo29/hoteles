document.addEventListener('DOMContentLoaded', function(){
    listarHoteles();
});

async function listarHoteles() {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        let respuesta = await fetch(base_url_server+'src/control/hoteles.php?tipo=listarHoteles',{
            method: 'POST',
            mode: 'cors',
            cache : 'no-cache',
            body : datos
        });
        json = await respuesta.json();
        let bodyHtml = document.getElementById("tbody_hoteles");
        if (json.status){
            bodyHtml.innerHTML = "";
            let datos = json.contenido;
            let cont = 0;
            datos.forEach(item => {
                let nuevaFila =  document.createElement("tr");
                nuevaFila.id = item.hotel_id;
                cont ++;
                nuevaFila.innerHTML = `
                <td scope="row">${cont}</td>
                <td>${item.nombre}</td>
                <td>${item.ciudad}</td>
                <td class="text-center text-warning">${item.estrellas}</td>
                <td>${item.telefono}</td>
                <td>${item.direccion}</td>
                <td class="text-center">${item.options}</td>
                `;
                document.querySelector('#tbody_hoteles').appendChild(nuevaFila);
            });
        }
    } catch (e) {
        console.log('Erro function || '+ e);   
    }
}

async function registrarHotel(){
    try {
        let datos = new FormData(frm_new_hotel);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        let respuesta = await fetch(base_url_server+'src/control/hoteles.php?tipo=registrarHotel',{
            method : 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if(json.status){
            let formOrg = document.getElementById("frm_new_hotel");
             formOrg.reset();
             let modalEl = document.getElementById("registroHotelModal");
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
            listarHoteles();
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


function antesEliminarHotel(id){
 Swal.fire({
  title: "Eliminar Usuario?",
  text: "¿Estas seguro que quieres eliminar este usuario?",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Sí, eliminalo!"
}).then((result) => {
  if (result.isConfirmed) {
   eliminarUsuario(id);
  }
});
}
/* async function eliminarUsuario(id) {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('idUser', id);
        let respuesta = await fetch(base_url_server+'src/control/Usuario.php?tipo=eliminarUsuario',{
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
            listarUsuarios();

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
} */

async function obtenerHotel(id) {
    let data = document.getElementById("data");
    let nombre = document.getElementById("new_nombreHotel");
    let ciudad = document.getElementById("NewCiudadHotel");
    let estrellas = document.getElementById("NewEstrellasHotel");
    let direccion = document.getElementById("newDireccion");
    let telefono = document.getElementById("newTelefono");
    let email = document.getElementById("newEmailHotel");
    let descripcion = document.getElementById("NewDescripcion");
  try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('data', id);
        let respuesta = await fetch(base_url_server+'src/control/hoteles.php?tipo=obtenerHotel',{
            method: 'POST',
            mode: 'cors',
            cache : 'no-cache',
            body : datos
        });
        json = await respuesta.json();
        if (json.status){
            let dato = json.contenido;
            data.value = dato.hotel_id;
            nombre.value = dato.nombre;
            ciudad.value = dato.ciudad;
            estrellas.value = dato.categoria;
            direccion.value = dato.direccion;
            telefono.value = dato.telefono;
            email.value = dato.email_contacto;
            descripcion.value = dato.descripcion;
        }
  } catch (e) {
    console.log("erro function || " + e);
  }
}

async function actualizarHotel() {
    let data = document.getElementById("data").value;
    try {
        let datos = new FormData(frm_upd_hotel);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('data', data );
        let respuesta = await fetch(base_url_server+'src/control/hoteles.php?tipo=actualizarHotel',{
            method : 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if(json.status){
            let formOrg = document.getElementById("frm_upd_hotel");
             formOrg.reset();
             let modalEl = document.getElementById("actualizarHotel");
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
            listarHoteles();
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
