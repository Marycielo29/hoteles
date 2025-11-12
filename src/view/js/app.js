/* const API_CONFIG = {
    baseURL: 'https://reservas.programacion.com.pe/src/control/apiController.php', // Cambiar por tu dominio
    token: '6abe2cda9a65aacb6a8f53f90af4acebfac82cc611b96d7a11733366aa15291e-20251106-9' // Tu token de acceso
}; */
const token = '69df1475dfefa5e87ad70de12423880b4938438dc4e86359f146d5d8aba56736-20251106-6';
const baseURL = 'https://reservas.programacion.com.pe/src/control/apiController.php?tipo=';

async function BuscarToken() {
    try {
        let data = new FormData();
        let respuesta = await fetch(base_url+'src/control/tokenapiController.php?tipo=obtenerTokencliente',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        });
        let json = await respuesta.json();
        if(json.status){
            let datos = json.contenido;
               localStorage.setItem('tokenApi', data.token);
        }else{
           console.log("no hay token causa");
        }
    } catch (e) {
       console.log("erro");
        
    }
}

// ===============================
// 📅 Actualizar fecha y hora
// ===============================
function actualizarFechaHora() {
    const ahora = new Date();
    const opciones = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        language: 'es'
    };
    
    const fecha = ahora.toLocaleDateString('es-ES', opciones);
    const hora = ahora.toLocaleTimeString('es-ES');
    
    document.getElementById('fecha').textContent = fecha.charAt(0).toUpperCase() + fecha.slice(1);
    document.getElementById('hora').textContent = hora;
}

actualizarFechaHora();
setInterval(actualizarFechaHora, 1000);


// ===============================
// ⚙️ Evento principal al cargar DOM
// ===============================
document.addEventListener('DOMContentLoaded', function() {
    listarReservas();

    // Filtro por estado
    document.getElementById('statusFilter').addEventListener('change', function() {
        const selectedStatus = this.value;
        if (selectedStatus === 'all') {
            listarReservas();
        } else {
            listarReservasPorEstado(selectedStatus);
        }
    });
});


// ===============================
// 📊 Listar Reservas por Estado
// ===============================
async function listarReservasPorEstado(status) {
    try {
        let dates = new FormData();
        dates.append('status', status);
        dates.append('token', token);

        const respuesta = await fetch(baseURL + 'listarReservasPorEstado', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: dates
        });
        const json = await respuesta.json();
        renderizarReservas(json);
    } catch (e) {
        console.log('error function || ' + e);
    }
}


// ===============================
// 📋 Listar todas las Reservas
// ===============================
async function listarReservas() {
    try {
        let dates = new FormData();
        dates.append('token', token);
        const respuesta = await fetch(baseURL + 'listarReservas', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: dates
        });
        const json = await respuesta.json();
        if (json.status) {
            renderizarReservas(json);
        } else {
            console.log(json.mensaje);
        }
    } catch (e) {
        console.log('error function listar || ' + e); 
    } 
}


// ===============================
// 🧱 Renderizar Reservas en HTML
// ===============================
function renderizarReservas(json) {
    let cuerpo = document.getElementById("container_content");
    cuerpo.innerHTML = '';
    let datos = json.contenido;
    let total = document.getElementById("total_reservas");
    total.innerHTML = datos.length;

    let cont = 0;
    datos.forEach(item => {
        cont++;

        // Ejemplo: los nuevos campos pueden venir desde tu API
        // Asegúrate que tu backend envíe hotel, tipo_habitacion y servicios.
        const hotel = item.hotel || 'Hotel no especificado';
        const tipoHabitacion = item.tipo_habitacion || 'Habitación estándar';
        const servicios = item.servicios || 'Wi-Fi, Desayuno';

        let nuevaFila = document.createElement("div");
        nuevaFila.className = 'reservas-grid';
        nuevaFila.id = "fila" + item.id_reserva;

        nuevaFila.innerHTML = `
            <div class="reserva-card">
                <div class="reserva-header pendiente">
                    <div>
                        <h6>Reserva #2024-${cont}</h6>
                        <small>Habitación ${item.id_habitacion}</small>
                    </div>
                    <span class="reserva-estado"><i class="bi bi-clock"></i> ${item.status}</span>
                </div> 

                <div class="reserva-body">

                    <div class="reserva-info">
                        <i class="bi bi-person-fill"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Cliente</div>
                            <div class="reserva-info-value">${item.username}</div>
                        </div>
                    </div>

                    <div class="reserva-info">
                        <i class="bi bi-building"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Hotel</div>
                            <div class="reserva-info-value">${hotel}</div>
                        </div>
                    </div>

                    <div class="reserva-info">
                        <i class="bi bi-door-closed"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Tipo de Habitación</div>
                            <div class="reserva-info-value">${tipoHabitacion}</div>
                        </div>
                    </div>

                    <div class="reserva-info">
                        <i class="bi bi-wifi"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Servicios Incluidos</div>
                            <div class="reserva-info-value">${servicios}</div>
                        </div>
                    </div>

                    <div class="reserva-info">
                        <i class="bi bi-calendar-event"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Entrada</div>
                            <div class="reserva-info-value">${item.fecha_inicio} · 15:00</div>
                        </div>
                    </div>

                    <div class="reserva-info">
                        <i class="bi bi-calendar-check"></i>
                        <div class="reserva-info-content">
                            <div class="reserva-info-label">Salida</div>
                            <div class="reserva-info-value">${item.fecha_fin} · 11:00</div>
                        </div>
                    </div>

                    <div class="reserva-footer">
                        <span class="reserva-precio">S/. ${item.monto_total}</span>
                        <span style="color: #999; font-size: 12px;">3 noches</span>
                    </div>
                </div>
            </div>
        `;

        cuerpo.appendChild(nuevaFila);
    });
}