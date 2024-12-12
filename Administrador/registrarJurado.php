<?php

require('./php/esenciales.php');
require('./php/conexionBasededatos.php');
adminLogin();
session_regenerate_id(true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registrar Jurados </title>
  <?php require('./php/linksGenerales.php') ?>
</head>

<body>
  <?php require('./php/menusuperior.php') ?>

  <div class="container-fluid containertablaboton">
    <input type="file" id="botonregistrarjurado" style="display: none;">
    <button type="button" onclick="leerArchivo('botonregistrarjurado')" id="botonregistrarjurado" class="btn botonregistrar" style="background-color: red; color: white">
      Registrar
    </button>
    <div class="tablaListaEquipos">
      <table class="table caption-top">
        <caption>
          Lista de Equipos Registrados
        </caption>
        <thead c>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre del Jurado</th>
            <th scope="col">Usuario</th>
            <th scope="col">Contraseña</th>
          </tr>
        </thead>
        <tbody id="datos_jurado">
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td><ion-icon size="large" style="cursor: pointer;" name="create-outline"></ion-icon></td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
            <td>boton</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
            <td>boton</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  
  <!-- Modal editar jurados -->
  <div class="modal fade" id="modalEditarJurado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="editarJurados">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="nombre_completo" class="form-label">Nombre del Jurado</label>
              <input type="text" name="nombre_completo" class="form-control" id="nombre_completo">
            </div>
            <div class="mb-3">
              <label for="usuario" class="form-label">Usuario</label>
              <input type="text" name="usuario" class="form-control" id="usuario">
            </div>
            <div class="mb-3">
              <label for="contrasena" class="form-label">Contraseña</label>
              <input type="text" name="contrasena" class="form-control" id="contrasena">
            </div>
            <input type="number" style="display: none;"  name="id">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>


</body>
<script>
  function leerArchivo(id) {
    let input = document.getElementById(id);
    input.click(); // Abre el selector de archivos

    input.addEventListener('change', function() {
      let archivo = input.files[0];
      let lector = new FileReader();

      lector.onload = function(evento) {
        let contenido = evento.target.result;
        let lineas = contenido.split(';');

        let datos = new FormData();
        datos.append('agregarJurado', '');

        let contadorJurado = 1;

        lineas.forEach(function(linea) {
          let elementos = linea.trim().split(',');
          if (elementos.length === 3) {
            let nombrecompleto = elementos[0].trim();
            let usuario = elementos[1].trim();
            let contrasena = elementos[2].trim();
            datos.append(`jurado${contadorJurado}_nombre_completo`, nombrecompleto);
            datos.append(`jurado${contadorJurado}_usuario`, usuario);
            datos.append(`jurado${contadorJurado}_contrasena`, contrasena);
            datos.append(`jurado${contadorJurado}_rol`, 'jurado');
            contadorJurado++;
          }
        });

        let solicitudHTTP = new XMLHttpRequest();

        solicitudHTTP.open("POST", "AJAX/registrarJurado_crud.php", true);

        solicitudHTTP.onload = function() {
          if (this.status === 200) {
            if (this.responseText == 1) {
              alerta('success', 'Se guardaron los datos de los equipos con éxito');
              obtenerTodosLosJurados();


            } else {

              alerta('error', 'Cargar datos de equipo falló');
            }
          } else {
            alerta('error', 'Hubo un error al comunicarse con el servidor');
          }
        };

        for (let entry of datos.entries()) {
          console.log(entry[0] + ': ' + entry[1]);
        }
        solicitudHTTP.send(datos);
      };

      lector.readAsText(archivo);
    });
  }


  function obtenerTodosLosJurados() {

    let solicitudHTTP = new XMLHttpRequest();
    solicitudHTTP.open("POST", "AJAX/registrarJurado_crud.php", true);
    solicitudHTTP.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


    solicitudHTTP.onload = function() {
      document.getElementById('datos_jurado').innerHTML = this.responseText;


    }
    solicitudHTTP.send('obtenerTodosLosJurados');
  }

  let formularioEditarJurado = document.getElementById('editarJurados');

  function editarJurado(id) {
    let solicitudHTTP = new XMLHttpRequest();
    solicitudHTTP.open("POST", "AJAX/registrarJurado_crud.php", true);
    solicitudHTTP.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


    solicitudHTTP.onload = function() {
      let datos = JSON.parse(this.responseText);

      formularioEditarJurado.elements['nombre_completo'].value = datos.datoJurado.nombre_completo;
      formularioEditarJurado.elements['usuario'].value = datos.datoJurado.usuario;
      formularioEditarJurado.elements['contrasena'].value = datos.datoJurado.contrasena;
      formularioEditarJurado.elements['id'].value = datos.datoJurado.id;


    }
    solicitudHTTP.send('obtenerJurado=' + id);
  }


  formularioEditarJurado.addEventListener('submit', function(e) {
    e.preventDefault();
    enviarEdicionJurado();

  });

  function enviarEdicionJurado() {

    let datos = new FormData();
    datos.append('edicionJurado', '');
    datos.append('nombre_completo', formularioEditarJurado.elements['nombre_completo'].value);
    datos.append('usuario', formularioEditarJurado.elements['usuario'].value);
    datos.append('contrasena', formularioEditarJurado.elements['contrasena'].value);
    datos.append('id', formularioEditarJurado.elements['id'].value);


    let solicitudHTTP = new XMLHttpRequest();
    solicitudHTTP.open("POST", "AJAX/registrarJurado_crud.php", true);


    solicitudHTTP.onload = function() {
      var myModal = document.getElementById('modalEditarJurado');
      var modal = bootstrap.Modal.getInstance(myModal);
      modal.hide();




      if (this.responseText == 1) {
        alerta('success', 'Se editaron los datos del equipo con exito');
        formularioEditarJurado.reset();
        obtenerTodosLosJurados();

      } else {
        alerta('error ', 'no se pudieron editar los datos del equipo ');
      }


    }

    solicitudHTTP.send(datos);
  }


  function alerta(tipoAlerta, mensaje) {
    let claseAlerta = (tipoAlerta == "success") ? "alert-success" : "alert-danger";
    let alertaDiv = document.createElement("div");
    alertaDiv.classList.add("alert", claseAlerta, "alert-dismissible", "position-fixed", "fade", "show", "custom-alert");
    alertaDiv.setAttribute("role", "alert");


    let strongElement = document.createElement("strong");
    strongElement.classList.add("me-3");
    strongElement.textContent = mensaje;

    let buttonElement = document.createElement("button");
    buttonElement.setAttribute("type", "button");
    buttonElement.classList.add("btn-close");
    buttonElement.setAttribute("data-bs-dismiss", "alert");
    buttonElement.setAttribute("aria-label", "Close");


    alertaDiv.appendChild(strongElement);
    alertaDiv.appendChild(buttonElement);


    document.body.appendChild(alertaDiv);


    setTimeout(function() {
      alertaDiv.remove();
    }, 5000);
  }
  window.onload = function() {
    obtenerTodosLosJurados();
  }
</script>
<script src="./js/registrarjurado.js" type="module"></script>
<?php
require('./php/scriptsgenerales.php')
?>

</html>