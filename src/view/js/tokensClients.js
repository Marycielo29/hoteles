document.addEventListener('DOMContentLoaded', function(){
 listarTokens();
obtenerCliente();
});

async function listarTokens() {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('id_client', id_client);
        let respuesta = await fetch(base_url_server+'src/control/tokensController.php?tipo=listarTokens',{
            method: 'POST',
            mode: 'cors',
            cache : 'no-cache',
            body : datos
        });
        json = await respuesta.json();
        let bodyHtml = document.getElementById("tbody_tokens");
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
                <td class="token-cell">
                    <span id="token-to-copy">${item.token}</span>
                    <i class="bi bi-clipboard" 
                    title="Copiar token" 
                    style="cursor: pointer;"></i>
                </td>
                <td>${item.fecha_reg}</td>
                <td>${item.estado}</td>
                <td class="text-center">${item.options}</td>
                `;
                document.querySelector('#tbody_tokens').appendChild(nuevaFila);
            });
        }
    } catch (e) {
        console.log('Error listar tokens '+ e);   
    }
}

async function obtenerCliente() {
    let razon = document.getElementById("client_name");

    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('data', id_client);
        let respuesta = await fetch(base_url_server+'src/control/ClientController.php?tipo=obtenerCliente',{
            method: 'POST',
            mode: 'cors',
            cache : 'no-cache',
            body : datos
        });
        json = await respuesta.json();
        if (json.status){
            let datos = json.contenido;
            razon.innerText = datos.razon_social;
        }
    } catch (e) {
        console.log("Error obtenerCliente || " + e);
    }
}

async function cambiarEstado(idToken,estado) {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('idToken', idToken );
        datos.append('estado', estado );
        let respuesta = await fetch(base_url_server+'src/control/tokensController.php?tipo=cambiarEstado',{
            method : 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if(json.status){

            listarTokens();
        }else{
            Swal.fire({
                text: json.mensaje,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    } catch (e) {
        console.log('Error cambiar estado || ' + e);
    }
}


function asignarToken(){
    Swal.fire({
  title: "Generar Token?",
    text: "¿Deseas generar token para este cliente?",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Sí, Generar!"
}).then((result) => {
  if (result.isConfirmed) {
     tokenGenerated();
  }
});
}

async function tokenGenerated() {
    try {
        let form = new FormData();
        form.append('token',token_token);
        form.append('sesion',session_session);
        form.append('id_client',id_client);

        let respuesta = await fetch (base_url_server+'src/control/tokensController.php?tipo=generarToken',{
            method : 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: form
        });

        json = await respuesta.json();
        if(json.status){
            Swal.fire({
            title: "Generado!",
            text: json.mensaje,
            icon: "success"
            });
            listarTokens();
        }else{
            Swal.fire({
                title: "Error de sistema!",
                text: json.mensaje,
                icon: "error"
                });
        }
    } catch (e) {
        console.log('arror al generar token || ' + e);  
    }
}