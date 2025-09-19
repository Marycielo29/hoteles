async function iniciar_sesion() {
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    if (email == "" || password == "") {
        Swal.fire({
            type: 'error',
            title: 'Error',
            text: 'Campos vacíos...',
            footer: '',
            timer: 1500
        })
        return;
    }
    try {
        // capturamos datos del formulario html
        const datos = new FormData(frm_login);
        //enviar datos hacia el controlador
        let respuesta = await fetch(base_url_server + 'src/control/Login.php?tipo=iniciar_sesion', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if (json.status) {
            //swal("Iniciar Sesion", json.mensaje, "success");
            const formData = new FormData();
            formData.append('session', json.contenido['sesion_id']);
            formData.append('usuario', json.contenido['sesion_usuario']);
            formData.append('nombres_apellidos', json.contenido['sesion_usuario_nom']);
            formData.append('token', json.contenido['sesion_token']);

            fetch(base_url_server + 'src/control/sesion_cliente.php?tipo=iniciar_sesion', {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            location.replace(base_url);
        } else {
            Swal.fire({
            title: 'Error!',
            text: json.msg,
            icon: 'error',
            confirmButtonText: 'OK'
            });
        }
        //console.log(respuesta);
    } catch (e) {
        console.log("Error al cargar categorias" + e);
    }
}

if (document.querySelector('#frm_login')) {
    // evita que se envie el formulario
    let frm_iniciar_sesion = document.querySelector('#frm_login');
    frm_iniciar_sesion.onsubmit = function (e) {
        e.preventDefault();
        iniciar_sesion();
    }
}
async function cerrar_sesion() {
    let respuesta = await fetch(base_url + 'src/control/sesion_cliente.php?tipo=cerrar_sesion');
    json = await respuesta.json();
    if (json.status) {
        location.replace(base_url + "login");
    }
}

async function send_email_password() {
    const datos = new FormData();
    datos.append('sesion', session_session);
    datos.append('token', token_token);
    try {
        let respuesta = await fetch(base_url_server + 'src/control/Usuario.php?tipo=sent_email_password',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
            
        })
    } catch (error) {
        
    }
}