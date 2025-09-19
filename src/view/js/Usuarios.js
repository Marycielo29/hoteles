
document.addEventListener('DOMContentLoaded', function(){
    listarUsuarios();
});

async function listarUsuarios() {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        let respuesta = await fetch(base_url_server+'src/control/Usuario.php?tipo=listarUsuarios',{
            method: 'POST',
            mode: 'cors',
            cache : 'no-cache',
            body : datos
        });
        json = await respuesta.json();
        let bodyHtml = document.getElementById("tbody_users");
        if (json.status){
            bodyHtml.innerHTML = "";
            let datos = json.contenido;
            let cont = 0;
            datos.forEach(item => {
                let nuevaFila =  document.createElement("tr");
                //nuevaFilaid: es crear // item.Id: viene de la base de datos
                nuevaFila.id = item.Id;
                cont ++;
                nuevaFila.innerHTML = `
                <td scope="row">${cont}</td>
                <td>${item.nombre}</td>
                <td>${item.email}</td>
                <td>${item.rol}</td>
                <td>${item.estado}</td>
                <td class="text-center">${item.options}</td>
                `;
                document.querySelector('#tbody_users').appendChild(nuevaFila);
            });
        }
    } catch (e) {
        console.log('Erro function || '+ e);   
    }
}

async function registrarUsuario(){
    try {
        let datos = new FormData(frm_new_user);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        let respuesta = await fetch(base_url_server+'src/control/Usuario.php?tipo=registrarUsuario',{
            method : 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if(json.status){
            let formOrg = document.getElementById("frm_new_user");
             formOrg.reset();
             let modalEl = document.getElementById("registroUsuarioModal");
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
            listarUsuarios();
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


function antesEliminarUsuario(id){
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
async function eliminarUsuario(id) {
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
}

async function obtenerUsuario(id) {
    let data = document.getElementById("data");
    let nombre = document.getElementById("new_nombre");
    let email = document.getElementById("NewEmail");
    let rol = document.getElementById("newRol");
    let estado = document.getElementById("estadoUsuario");
  try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('idUser', id);
        let respuesta = await fetch(base_url_server+'src/control/Usuario.php?tipo=obtenerUsuario',{
            method: 'POST',
            mode: 'cors',
            cache : 'no-cache',
            body : datos
        });
        json = await respuesta.json();
        if (json.status){
            let dato = json.contenido;
            data.value = dato.id;
            nombre.value = dato.nombre;
            email.value = dato.email;
            rol.value = dato.rol;
            estado.value = dato.estado;
        }
  } catch (e) {
    console.log("erro function || " + e);
  }
}

async function actualizarUsuario() {
    let data = document.getElementById("data").value;
    try {
        let datos = new FormData(frm_update_user);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('idUser', data );
        let respuesta = await fetch(base_url_server+'src/control/Usuario.php?tipo=actualizarUsuario',{
            method : 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if(json.status){
            let formOrg = document.getElementById("frm_update_user");
             formOrg.reset();
             let modalEl = document.getElementById("actualizarUsuario");
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
            listarUsuarios();
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

