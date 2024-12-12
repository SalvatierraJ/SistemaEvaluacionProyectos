<?php

require('../Administrador/php/esenciales.php');
require('../Administrador/php/conexionBasededatos.php');
juradoLogin();
session_regenerate_id(true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./../Estilos/jurado_proyecto.css">
    <?php require "./../Administrador/php/linksGenerales.php"; ?>

    <style>
        .metric-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .metric {
            margin: 20px;
            width: 250px;
            background-color: #f7f7f7;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .progress-bar {
            width: 100%;
            height: 20px;
            background-color: #ccc;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress {
            width: 20%;
            /* adjust this value based on the percentage */
            height: 100%;
            background-color: #4CAF50;
            transition: width 0.5s ease-in-out;
        }

        .percentage {
            font-size: 18px;
            font-weight: bold;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <?php require "./php/menusuperior.php"; ?>
    <form id="formulariocartas">
        <div class="container-fluid containerCartas">
            <div class="row row-cols-1 row-cols-md-2 g-4 contenedorjusto" style="margin: auto;">

                <?php
                $respuesta = seleccionarTodaLa('equipos');



                while ($fila = mysqli_fetch_assoc($respuesta)) {

                    $verificar = seleccionarTabla("SELECT `id_jurado`, `id_proyecto` FROM `evaluaciones` WHERE `id_jurado`= ? AND `id_proyecto`=? ", [$_SESSION['id_jurado'], $fila['id_proyecto']], "ii");


                    echo <<<cartaequipo
                        <div class="col cartas" style="width:auto;">
                            <div class="card cartaequipo">
                                <img src="../public/30confondodecolorrojo-removebg-preview.png" class="card-img-top img-thumbnail" style="height: 70px; width: 70px;" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">$fila[proyecto]</h5>
                                    <p class="card-text">$fila[grupo]</p>
                        cartaequipo;
                    if (mysqli_num_rows($verificar) >= 1) {
                        echo <<<cartaequipo
                    
                            <button type="button" id="$fila[id_proyecto]" disabled   class="btn btn-success " data-bs-toggle="modal" data-bs-target="#modalProyecto">
                                <ion-icon name="checkmark-outline"></ion-icon>
                            </button>
                    cartaequipo;
                    } else {
                        echo <<<cartaequipo
                        
                        <button type="button" id="$fila[id_proyecto]" onclick="colocarValorEnInput('inputidproyecto',$fila[id_proyecto] )"  class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalProyecto">
                            <ion-icon name="analytics-outline"></ion-icon> Evaluar
                        </button>
                    cartaequipo;
                    }

                    echo <<<cartaequipo
                                </div>
                            </div>
                        </div>
                        cartaequipo;
                }
                ?>
            </div>
        </div>
    </form>



    <!-- Modal Evaluar Proyecto -->
    <div class="modal fade" id="modalProyecto" tabindex="-1" aria-labelledby="modalProyectoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="formularioProyecto">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalProyectoLabel">Evaluacion</h5>
                        <!-- <button type="button"  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    </div>
                    <div class="modal-body">

                        <div class="metric-container">
                            <div class="metric">
                                <h2 class="text-center text-wrap fs-6">Propuesta académica del proyecto</h2>
                                <br>
                                <br>
                                <input type="range" min="0" max="20" value="0" step="1" class="slider" id="range">
                                <div class="progress-bar">
                                    <span class="percentage" id="propuestaAcademica">20</span>
                                </div>
                            </div>
                            <div class="metric">
                                <h2 class="text-center text-wrap fs-6">Pertinencia de la propuesta con necesidades de una empresa o de la sociedad</h2>
                                <br>
                                <br>
                                <input type="range" min="0" max="20" value="0" step="1" class="slider" id="range">
                                <div class="progress-bar">
                                    <span class="percentage" id="">20</span>
                                </div>
                            </div>
                            <div class="metric">
                                <h2 class="text-center text-wrap fs-6">Grado de innovación y originalidad</h2>
                                <br>
                                <br>
                                <input type="range" min="0" max="15" value="0" step="1" class="slider" id="range">
                                <div class="progress-bar">
                                    <span class="percentage" id="">15</span>
                                </div>
                            </div>
                            <div class="metric">
                                <h2 class="text-center text-wrap fs-6">Calidad del prototipado</h2>
                                <br>

                                <input type="range" min="0" max="15" value="0" step="1" class="slider" id="range">
                                <div class="progress-bar">
                                    <span class="percentage" id="">15</span>
                                </div>
                            </div>
                            <div class="metric">
                                <h2 class="text-center text-wrap fs-6">Impacto social </h2>
                                <br>

                                <input type="range" min="0" max="15" value="0" step="1" class="slider" id="range">
                                <div class="progress-bar">
                                    <span class="percentage" id="">15</span>
                                </div>
                            </div>
                            <div class="metric">
                                <h2 class="text-center text-wrap fs-6">Sostenibilidad</h2>
                                <br>
                                <input type="range" min="0" max="15" value="0" step="1" class="slider" id="range">
                                <div class="progress-bar">
                                    <span class="percentage" id="">15</span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" id="inputidproyecto">


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="obtenerYCambiarBoton('2'); reiniciarValoresSpans();" data-bs-dismiss="modal">Close</button>
                        <button type="submit" onclick="obtenerYCambiarBoton('1');" data-bs-target="#modalprotecto2" data-bs-toggle="modal" class="btn btn-primary">Guardar Evaluacion</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalprotecto2" aria-hidden="true" aria-labelledby="modalprotectoLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalprotectoLabel2">confirmacion</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">
                    TODOS LOS DATOS SON CORRECTOS?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" id="cancelacion" data-bs-target="#modalProyecto" data-bs-toggle="modal" data-bs-dismiss="modal">Volver</button>
                    <button class="btn btn-success" id="confirmacion" data-bs-dismiss="modal">Confirmar!!</button>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="./js/jurado_proyecto.js"></script>
<?php require "../Administrador/php/scriptsgenerales.php"; ?>

</html>