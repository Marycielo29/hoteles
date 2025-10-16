<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Buscador de Hoteles | API Cliente</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f4f4f4; }
    header { text-align: center; margin-bottom: 20px; }
    .buscador { background: #fff; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    form { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
    input, select, button { padding: 10px; border-radius: 5px; border: 1px solid #ccc; }
    button { background: #007bff; color: white; cursor: pointer; border: none; }
    button:hover { background: #0056b3; }
    #resultados { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px; }
    .card { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .card h3 { margin: 0 0 10px; color: #333; }
    .card p { margin: 5px 0; }
  </style>
</head>
<body>

  <header>
    <h1>🏨 Buscador de Hoteles</h1>
    <p>Consulta de hoteles desde API</p>
  </header>

  <section class="buscador">
    <h2>🔍 Filtrar Hoteles</h2>
    <form id="formBusqueda">
      <input type="text" id="nombreHotel" placeholder="Nombre del hotel">
      <select id="tipoHabitacion">
        <option value="">-- Tipo de habitación --</option>
        <option value="Matrimonial">Matrimonial</option>
        <option value="Doble">Doble</option>
        <option value="Triple">Triple</option>
        <option value="Suite">Suite</option>
      </select>
      <button type="submit">Buscar</button>
    </form>
  </section>

  <section id="resultados">
    <!-- Resultados aparecerán aquí -->
  </section>

  <script>
    document.getElementById("formBusqueda").addEventListener("submit", async function(e) {
      e.preventDefault();

      const nombre = document.getElementById("nombreHotel").value;
      const habitacion = document.getElementById("tipoHabitacion").value;

      const formData = new FormData();
      formData.append("tipo", "verHotelesApiByNombreHabitacion");
      formData.append("nombre", nombre);
      formData.append("habitacion", habitacion);
      formData.append("token", "123-xyz-5"); // Cambiar por tu token real

      const respuesta = await fetch("http://tuservidor.com/api/index.php", {
        method: "POST",
        body: formData
      });

      const data = await respuesta.json();
      mostrarResultados(data.contenido);
    });

    function mostrarResultados(hoteles) {
      const contenedor = document.getElementById("resultados");
      contenedor.innerHTML = "";

      if (!hoteles || hoteles.length === 0) {
        contenedor.innerHTML = "<p>No se encontraron hoteles</p>";
        return;
      }

      hoteles.forEach(hotel => {
        contenedor.innerHTML += `
          <div class="card">
            <h3>${hotel.nombre}</h3>
            <p><strong>Ciudad:</strong> ${hotel.ciudad}</p>
            <p><strong>Habitación:</strong> ${hotel.tipo_habitacion}</p>
            <p><strong>Precio por noche:</strong> S/ ${hotel.precio}</p>
          </div>
        `;
      });
    }
  </script>

</body>
</html>
