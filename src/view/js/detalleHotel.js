document.addEventListener('DOMContentLoaded', function(){
    listarHabitaciones();
    listarServicios();
    listarHotel();
});

async function listarHotel() {
    let nombrehotel = document.getElementById("nombre_hotel");
    let direccion = document.getElementById("direccion_hotel");
    let ciudad = document.getElementById("ciudad_hotel");
    let telefono = document.getElementById("telefono_hotel");
    let descripcion = document.getElementById("descripcion_hotel");
        try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('data', id_hotel);
        let respuesta = await fetch(base_url_server+'src/control/hoteles.php?tipo=obtenerHotel',{
            method: 'POST',
            mode: 'cors',
            cache : 'no-cache',
            body : datos
        });
        json = await respuesta.json();
        if (json.status){
            let datos = json.contenido;
            nombrehotel.innerHTML = datos.nombre+' '+'<span class="text-warning">'+datos.estrellas+'</span>';
            direccion.innerHTML = '<i class="bi bi-geo-fill"></i> '+ datos.direccion;
            ciudad.innerHTML = '<i class="bi bi-geo-alt-fill"></i> '+ datos.ciudad;
            telefono.innerHTML = '<i class="bi bi-telephone-fill"></i> '+ datos.telefono;
            descripcion.innerHTML =  datos.descripcion;
        }
    } catch (e) {
        console.log('Erro function || '+ e);   
    }
}
async function listarHabitaciones() {
    try {
        let datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('id_hotel', id_hotel);
        let respuesta = await fetch(base_url_server+'src/control/habitaciones.php?tipo=listarHabitaciones',{
            method: 'POST',
            mode: 'cors',
            cache : 'no-cache',
            body : datos
        });
        json = await respuesta.json();
        let bodyHtml = document.getElementById("tbody_habitaciones");
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
                <td>${item.tipo}</td>
                <td>${item.capacidad}</td>
                <td>${item.precio_noche}</td>
                <td>${item.moneda}</td>
              
                <td>${item.cantidad_disponible}</td>
                <td class="text-center">${item.options}</td>
                `;
                document.querySelector('#tbody_habitaciones').appendChild(nuevaFila);
            });
        }
    } catch (e) {
        console.log('Erro function || '+ e);   
    }
}

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

async function registrarHabitacion(){
    try {
        let datos = new FormData(frm_new_habitacion);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('id_hotel', id_hotel);
        let respuesta = await fetch(base_url_server+'src/control/habitaciones.php?tipo=registrarHabitacion',{
            method : 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if(json.status){
            let formOrg = document.getElementById("frm_new_habitacion");
             formOrg.reset();
             let modalEl = document.getElementById("registroHabitacionModal");
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
            listarHabitaciones();
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