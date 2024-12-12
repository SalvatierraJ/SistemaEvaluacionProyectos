<?php
require('../php/conexionBasededatos.php');
require('../php/esenciales.php');


if (isset($_POST['agregarJurado'])) {
    $bandera = 0;
    $datosformulario = filtrarPor($_POST);
    // Inicializamos un array para almacenar los datos de los jurados
    $jurados = [];

    // Recorremos $_POST para identificar los jurados y almacenar sus datos
    foreach ($datosformulario as $clave => $valor) {
        // Verificamos si la clave corresponde a un atributo de un equipo
        if (strpos($clave, 'jurado') === 0) {
            // Obtenemos el número de equipo
            $numJurado = substr($clave, 6, strpos($clave, '_') - 6);

            // Si es la primera vez que encontramos este equipo, inicializamos su array
            if (!isset($jurados[$numJurado])) {
                $jurados[$numJurado] = [];
            }

            // Obtenemos el nombre del atributo
            $atributo = substr($clave, strpos($clave, '_') + 1);

            // Almacenamos el valor en el array del equipo correspondiente
            $jurados[$numJurado][$atributo] = $valor;
        }
    }


    // enviar los datos al servidor
    foreach ($jurados as $numJurado => $datosJurado) {
        $valores = [
            $datosJurado['nombre_completo'],
            $datosJurado['usuario'],
            $datosJurado['contrasena'],
            $datosJurado['rol']
        ];
        $tipoDeDatos = "ssis";
        $consulta1 = "INSERT INTO `usuarios`( `nombre_completo`, `usuario`, `contrasena`, `rol`) VALUES (?,?,?,?)";

        if (insertarValoresTabla($consulta1, $valores, $tipoDeDatos)) {
            $bandera = 1;
        }
    }
    if ($bandera) {
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['obtenerTodosLosJurados'])) {

    $respuesta = seleccionarTodaLa('vista_jurados');
    $i = 1;

    $datos = "";

    while ($fila = mysqli_fetch_assoc($respuesta)) {
        $estado = "";
        if ($fila['estado'] == 'activo') {
            $estado = 'checked="true"';
        }
        $datos .= "  
        <tr>
        <th scope='row'>$i</th>
        <td>$fila[nombre_completo]</td>
        <td>$fila[usuario]</td>
        <td>$fila[contrasena]</td>
        <td><input juradoid='$fila[id]' class='form-check-input' type='checkbox' value='activo' id='juradocheck' $estado></td>
        <td>
        <button type='button' onclick='editarJurado($fila[id])' class='btn btn-dark' data-bs-toggle='modal' data-bs-target='#modalEditarJurado'>
                <ion-icon size='small' name='create-outline'></ion-icon>
              </button>
        </ion-icon></td>
      </tr>
      ";
        $i++;
    }

    echo $datos;
}


if (isset($_POST['obtenerJurado'])) {


    $datosFormulario = filtrarPor($_POST);
    $respuesta1 = seleccionarTabla("SELECT `id`,`nombre_completo`, `usuario`, `contrasena` FROM `usuarios` WHERE `id`=?", [$datosFormulario['obtenerJurado']], 'i');

    


    $datosUsuario = mysqli_fetch_assoc($respuesta1);


    $datos = ["datoJurado" => $datosUsuario];


    $datos = json_encode($datos);


    echo $datos;
}


if (isset($_POST['edicionJurado'])) {

    $datosFormulario = filtrarPor($_POST);
    $bandera = 0;

    $consulta1 = "UPDATE `usuarios` SET `nombre_completo`=?,`usuario`=?,`contrasena`=? WHERE `id`=?";
    $valores1 = [$datosFormulario['nombre_completo'], $datosFormulario['usuario'], $datosFormulario['contrasena'], $datosFormulario['id']];


    if (actualizarTabla($consulta1, $valores1, 'ssii') ) {
      $bandera=1;
    }
    echo $bandera;
}
