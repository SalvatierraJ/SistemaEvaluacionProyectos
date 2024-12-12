<?php
require('../Administrador/php/esenciales.php');
require('./php/conexionBasededatos.php');
adminLogin();
session_regenerate_id(true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Administrador</title>
  <?php require('./php/linksGenerales.php') ?>
</head>

<body>
  <?php require('./php/menusuperior.php') ?>

  <div class="container-fluid containertablaboton">
 
    <div class="tablaListaEquipos">
      <table class="table caption-top">
        <caption>
          Lista de Equipos Registrados
        </caption>
        <thead c>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre Proyecto</th>
            <?php
            $resultado = seleccionarTodaLa('usuarios');
            $i = 1;
            while ($fila = mysqli_fetch_assoc($resultado)) {

              if ($fila['rol'] == 'jurado' && $fila['estado'] == 'activo') {
                echo <<<datos
                      <th scope="col">Jurado $i </th>
                    datos;
                $i++;
              }
            }
            echo '<th scope="col">Promedio</th>';

            ?>

          </tr>
        </thead>
        <tbody id="tablajurado">
          <tr>
            <th scope="row">1</th>
            <td>nombre</td>
            <td>juradp1</td>
            <td>jurado2</td>
            <td>jurado3</td>
            <td><ion-icon size="large" style="cursor: pointer;" name="create-outline"></ion-icon></td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
            <td>@mdo</td>
            <td>@mdo</td>
            <td>boton</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
            <td>@mdo</td>
            <td>@mdo</td>
            <td>boton</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>




  <!-- Modal ver Evaluacion -->
  <div class="modal fade" id="modalverEvaluacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <form id="editarEquipos">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Equipo</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="cuerpodelmodal">
          <div class="tablaListaEquipos">
      <table class="table caption-top">
        <caption>
          Lista de Equipos Registrados
        </caption>
        <thead c>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre del Jurado</th>
            <th scope="col">Propuesta Academica</th>
            <th scope="col">Pertinencia de Propuesta</th>
            <th scope="col">Grado de Innovacion</th>
            <th scope="col">Calidad de Prototipado</th>
            <th scope="col">Impacto Social</th>
            <th scope="col">Sostenibilidad de la Propuesta</th>
          </tr>
        </thead>
        <tbody id="datos_evaluacion">
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>@mdo</td>
            
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
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
            <!-- <button type="submit" class="btn btn-primary">Guardar Cambios</button> -->
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
<script>
  function obtenerTodosLosEvaluados() {

    let solicitudHTTP = new XMLHttpRequest();
    solicitudHTTP.open("POST", "AJAX/proyectosEvaluados_crud.php", true);
    solicitudHTTP.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


    solicitudHTTP.onload = function() {
      document.getElementById('tablajurado').innerHTML = this.responseText;


    }
    solicitudHTTP.send('obtenerTodosLosEvaluados');
  }

  function obtenerDatosEvaluacion(id) {

    let solicitudHTTP = new XMLHttpRequest();
    solicitudHTTP.open("POST", "AJAX/proyectosEvaluados_crud.php", true);
    solicitudHTTP.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');


    solicitudHTTP.onload = function() {
      document.getElementById('datos_evaluacion').innerHTML = this.responseText;


    }
    solicitudHTTP.send('obtenerDatosEvaluacion='+id);
  }

  window.onload = function() {
    obtenerTodosLosEvaluados();
  };
</script>
<?php
require('./php/scriptsgenerales.php')
?>

</html>