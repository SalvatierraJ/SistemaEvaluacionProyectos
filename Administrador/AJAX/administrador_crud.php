<?php
require('../php/conexionBasededatos.php');
require('../php/esenciales.php');



if (isset($_POST['agregarequipos'])) {
    $bandera = 0;
    $datosformulario = filtrarPor($_POST);
    // Inicializamos un array para almacenar los datos de los equipos
    $equipos = [];

    // Recorremos $_POST para identificar los equipos y almacenar sus datos
    foreach ($datosformulario as $clave => $valor) {
        // Verificamos si la clave corresponde a un atributo de un equipo
        if (strpos($clave, 'equipo') === 0) {
            // Obtenemos el número de equipo
            $numEquipo = substr($clave, 6, strpos($clave, '_') - 6);

            // Si es la primera vez que encontramos este equipo, inicializamos su array
            if (!isset($equipos[$numEquipo])) {
                $equipos[$numEquipo] = [];
            }

            // Obtenemos el nombre del atributo
            $atributo = substr($clave, strpos($clave, '_') + 1);

            // Almacenamos el valor en el array del equipo correspondiente
            $equipos[$numEquipo][$atributo] = $valor;
        }
    }


    // enviar los datos al servidor
    foreach ($equipos as $numEquipo => $datosEquipo) {
        $valores = [
            $datosEquipo['nombre_proyecto'],
            $datosEquipo['nombre_grupo'],
            $datosEquipo['carrera']
        ];
        $tipoDeDatos = "sss";
        $consulta1 = "INSERT INTO `proyectos`(`nombre_proyecto`, `nombre_grupo`, `carrera`) VALUES (?,?,?)";

        if (insertarValoresTabla($consulta1, $valores, $tipoDeDatos)) {
            $bandera = 1;
        }

        $proyectoID = mysqli_insert_id($conexion);

        $consulta2 = "INSERT INTO `integrantes`(`id_proyecto`, `nombre_integrante`) VALUES (?,?)";

        if ($sentenciaPreparada = mysqli_prepare($conexion, $consulta2)) {

            mysqli_stmt_bind_param($sentenciaPreparada, 'is', $proyectoID, $datosEquipo['nombre_integrante']);
            mysqli_stmt_execute($sentenciaPreparada);
            mysqli_stmt_close($sentenciaPreparada);
        } else {
            $bandera = 0;
            die('El query de habitacion no está siendo preparado - INSERT');
            // Si la preparación de la sentencia no tiene éxito, se establece $bandera en 0 y se muestra un mensaje de error
        }
    }
    if ($bandera) {
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['obtenerTodosLosEquipos'])) {

    $respuesta = seleccionarTodaLa('equipos');
    $i = 1;

    $datos = "";

    while ($fila = mysqli_fetch_assoc($respuesta)) {

        $datos .= "  
        <tr>
        <th scope='row'>$i</th>
        <td>$fila[proyecto]</td>
        <td>$fila[grupo]</td>
        <td>$fila[carrera]</td>
        <td>$fila[integrantes]</td>
        <td>
        <button type='button' onclick='editarEquipos($fila[id_proyecto])' class='btn btn-dark' data-bs-toggle='modal' data-bs-target='#modalEditarEquipo'>
                <ion-icon size='small' name='create-outline'></ion-icon>
              </button>
        </ion-icon></td>
      </tr>
      ";
        $i++;
    }

    echo $datos;
}

if (isset($_POST['obtenerEquipo'])) {


    $datosFormulario = filtrarPor($_POST);
    $respuesta1 = seleccionarTabla("SELECT `id`, `nombre_proyecto`, `nombre_grupo`, `carrera` FROM `proyectos` WHERE`id`=?", [$datosFormulario['obtenerEquipo']], 'i');

    $respuesta2 = seleccionarTabla("SELECT `nombre_integrante` FROM `integrantes` WHERE `id_proyecto`=?", [$datosFormulario['obtenerEquipo']], 'i');


    $datosProyecto = mysqli_fetch_assoc($respuesta1);
    $datosIntegrantes = mysqli_fetch_assoc($respuesta2);


    $datos = ["datoProyecto" => $datosProyecto, "datosIntegrantes" => $datosIntegrantes];


    $datos = json_encode($datos);


    echo $datos;
}

if (isset($_POST['juradocheck']) && isset($_POST['juradocheckid'])) {
    $datos = filtrarPor($_POST);
    // Comprobar si se envió el valor del checkbox y asignarlo a una variable
    $estadoJuradoCheck = isset($datos['juradocheck']) ? $datos['juradocheck'] : 'inactivo';
    // Por ejemplo, imprimir el estado o guardarlo en una base de datos
    $consulta1="CALL ActualizarEstadoUsuario(?, ?)";
    $valores1=[$datos['juradocheckid'],$estadoJuradoCheck];
    actualizarTabla($consulta1,$valores1,'is');
    if ($estadoJuradoCheck == 'activo') {
        echo "El checkbox está marcado.";
    } else {
        echo "El checkbox no está marcado.";
    }
}



if (isset($_POST['edicionDeEquipos'])) {

    $datosFormulario = filtrarPor($_POST);
    $bandera = 0;

    $consulta1 = "UPDATE `proyectos` SET `nombre_proyecto`=? ,`nombre_grupo`=?,`carrera`=? WHERE  `id`=?";
    $valores1 = [$datosFormulario['nombre_proyecto'], $datosFormulario['nombre_grupo'], $datosFormulario['carrera'], $datosFormulario['id']];
    $consulta2 = "UPDATE `integrantes` SET `nombre_integrante`=? WHERE `id_proyecto`=?";
    $valores2 = [$datosFormulario['nombre_integrante'], $datosFormulario['id_proyecto']];

    if (actualizarTabla($consulta1, $valores1, 'sssi') ) {
      $bandera=1;
    }
    if(actualizarTabla($consulta2, $valores2, 'si')){
        $bandera=1;
    }

    echo $bandera;
}

