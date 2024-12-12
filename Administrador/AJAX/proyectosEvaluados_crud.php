<?php
require('../php/conexionBasededatos.php');
require('../php/esenciales.php');
if (isset($_POST['obtenerTodosLosEvaluados'])) {

  $respuesta = seleccionarTodaLa('proyectos');
  $controlador=1;
  $i = 1;

  $datos = ""; 
  
  while ($fila = mysqli_fetch_assoc($respuesta)) {
      $proyecto = seleccionarTabla("SELECT `total_evaluacion` FROM `vista_evaluaciones_proyectos` WHERE `id_proyecto`=?",[$fila['id']],'i');  
      $promedio = seleccionarTabla("SELECT `total_promedio` FROM `vista_promedio_evaluacion` WHERE `id_proyecto`=?",[$fila['id']],'i');
      $jurados = seleccionarTodaLa('usuarios');
      $datos .= "
      <tr><th scope='row'>$i</th>
      <td>$fila[nombre_proyecto]</td>
      ";

      while($filajurados = mysqli_fetch_assoc($jurados)){
          if($filajurados['rol'] == 'jurado' && $filajurados['estado'] == 'activo'){
              $filaevaluacion = mysqli_fetch_assoc($proyecto);
              if ($filaevaluacion && isset($filaevaluacion['total_evaluacion'])) {
                  $datos .= "<td>$filaevaluacion[total_evaluacion]</td>";
              } else {
                  $datos .= "<td>0</td>";
              }
          }
      }

      if ($promedio) {
          $filapromedio = mysqli_fetch_assoc($promedio);
          if ($filapromedio && isset($filapromedio['total_promedio'])) {
              $datos .= "<td>". round($filapromedio['total_promedio'], 2) ."</td>";
          } else {
              $datos .= "<td>0</td>";
          }
      } else {
          $datos .= "<td>No hay promedio</td>";
      }

      $datos .= "<td><button type='button' onclick=' obtenerDatosEvaluacion($fila[id])' 
      class='btn btn-dark' data-bs-toggle='modal' data-bs-target='#modalverEvaluacion'><ion-icon name='eye-outline'></ion-icon></button></td></tr>";
      $i++;
  }

  echo $datos;
}


if (isset($_POST['obtenerDatosEvaluacion'])) {
  $datosformulario=filtrarPor($_POST);

  $respuesta = seleccionarTabla("SELECT * FROM `vista_evaluaciones_proyectos` WHERE id_proyecto =?",[$datosformulario['obtenerDatosEvaluacion']],'i');
  $i = 1;

  $datos = ""; 

  while ($fila = mysqli_fetch_assoc($respuesta)) {
      
 
      $datos .="
          <tr>
          <th scope='row'>$i</th>
          <td>$fila[nombre_jurado]</td>
          <td>$fila[propuesta_academica]</td>
          <td>$fila[pertinencia_propuesta]</td>
          <td>$fila[grado_innovacion]</td>
          <td>$fila[calidad_prototipado]</td>
          <td>$fila[impacto_social]</td>
          <td>$fila[sostenibilidad_propuesta]</td>
          
         
          
        </tr>
      ";
      $i++;
  }

  echo $datos;
}