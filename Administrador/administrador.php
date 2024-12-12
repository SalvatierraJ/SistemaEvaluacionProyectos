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
    <input type="file" id="botonregistrarequipos" style="display: none;">
    <button type="button" onclick="leerArchivo('botonregistrarequipos')" for="botonregistrarequipos" class="btn botonregistrar" style="background-color: red; color: white">
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
            <th scope="col">Nombre Proyecto</th>
            <th scope="col">Nombre Grupo</th>
            <th scope="col">Carrera</th>
            <th scope="col">Integrantes</th>
          </tr>
        </thead>
        <tbody id="datos_equipo">

          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>
              <button type="button" onclick="editarEquipos()" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalEditarEquipo">
                <ion-icon size="small" name="create-outline"></ion-icon>
              </button>


            </td>
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



  <!-- Modal editar equipos -->
  <div class="modal fade" id="modalEditarEquipo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="editarEquipos">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Equipo</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="nombreProyecto" class="form-label">Nombre del Proyecto</label>
              <input type="text" name="nombreProyecto" class="form-control" id="nombreProyecto">
            </div>
            <div class="mb-3">
              <label for="nombreGrupo" class="form-label">Nombre del Grupo</label>
              <input type="text" name="nombreGrupo" class="form-control" id="nombreGrupo">
            </div>
            <div class="mb-3">
              <label for="carrera" class="form-label">Carrera</label>
              <input type="text" name="carrera" class="form-control" id="carrera">
            </div>
            <div class="form">
              <label for="integrantes">Integrantes</label>
              <textarea class="form-control" id="integrantes" name="integrantes" style="height: 100px"></textarea>

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
<script src="./js//administrador.js"></script>
<?php
require('./php/scriptsgenerales.php')
?>

</html>