<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Fundaciones Registradas</title>
  <link rel="stylesheet" href="../CSS/estilosFundaciones.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    .fundacion {
      border: 1px solid #ccc;
      border-radius: 10px;
      margin-bottom: 10px;
      padding: 15px;
      background-color: #f9f9f9;
    }
    h2 {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

  <h2>Fundaciones Registradas</h2>
  <div id="fundaciones-container">
    <p>Cargando fundaciones...</p>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      fetch("../../Modelo/ObtenerFundaciones.php")
        .then(response => response.json())
        .then(data => {
          const container = document.getElementById("fundaciones-container");
          container.innerHTML = "";

          if (data.length === 0) {
            container.innerHTML = "<p>No hay fundaciones registradas.</p>";
            return;
          }

          data.forEach(fundacion => {
            const div = document.createElement("div");
            div.className = "fundacion";
            div.innerHTML = `
              <p><strong>Nombre:</strong> ${fundacion.Usu_Username}</p>
              <p><strong>Correo:</strong> ${fundacion.Usu_Correo}</p>
              <p><strong>ID:</strong> ${fundacion.Usu_Id}</p>
            `;
            container.appendChild(div);
          });
        })
        .catch(error => {
          console.error("Error al cargar fundaciones:", error);
          document.getElementById("fundaciones-container").innerHTML = "<p>Error al cargar los datos.</p>";
        });
    });
  </script>

</body>
</html>
