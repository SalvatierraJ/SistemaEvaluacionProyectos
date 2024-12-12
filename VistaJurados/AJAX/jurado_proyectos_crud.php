<?php 

require "../../Administrador/php/conexionBasededatos.php";
require "../../Administrador/php/esenciales.php";

juradoLogin();
session_regenerate_id(true);

if(isset($_POST['guardarEvaluacion'])){
    $bandera = 0;
    $datosFormaulario = filtrarPor($_POST);
    if (isset($_SESSION['id_jurado']) && !empty($_SESSION['id_jurado'])) {
        // El ID del jurado está definido y no es nulo, puedes usarlo en la consulta
        $valores = [
            $_SESSION['id_jurado'],
            $datosFormaulario['id_proyecto'],
            $datosFormaulario['propuesta_academica'],
            $datosFormaulario['pertinencia_propuesta'],
            $datosFormaulario['grado_innovacion'],
            $datosFormaulario['calidad_prototipado'],
            $datosFormaulario['impacto_social'],
            $datosFormaulario['sostenibilidad_propuesta'],
        ];
    
        $datos = 'iiiiiiii';
        $sql = "INSERT INTO `evaluaciones`(`id_jurado`, `id_proyecto`, `propuesta_academica`, `pertinencia_propuesta`, `grado_innovacion`, `calidad_prototipado`, `impacto_social`, `sostenibilidad_propuesta`)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
        if (insertarValoresTabla($sql, $valores, $datos)) {
            $bandera = 1;
        }
    
        echo $bandera;
    } else {
        // El ID del jurado no está definido o es nulo, mostrar un mensaje de error o tomar alguna otra acción
        echo "Error: ID del jurado no definido o nulo";
    }
    
}