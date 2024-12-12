<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);

function adminLogin(){
    session_start();
    
    // Verificar si $_SESSION['adminLogin'] está definida y es igual a true
    if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] === true)){
        // Redirigir al usuario a la página de inicio
        echo "
        <Script>
        window.location.href='index.php';
        </script>
        ";
        
        // Finalizar la ejecución del script
        exit;
    }
}
function juradoLogin(){

    session_start();
    
    // Verificar si $_SESSION['adminLogin'] está definida y es igual a true
    if(!(isset($_SESSION['juradoLogin']) && $_SESSION['juradoLogin'] === true)){
        // Redirigir al usuario a la página de inicio
        echo "
        <Script>
        window.location.href='index.php';
        </script>
        ";
        
        // Finalizar la ejecución del script
        exit;
    }
}


function redireccionar($url){
    // Redirigir al usuario a la URL especificada
    echo "
        <Script>
        window.location.href='$url';
        </script>
    ";
    
    // Finalizar la ejecución del script
    exit;
}


function alerta($tipoAlerta, $mensaje){
    // Determinar la clase CSS de la alerta según el tipo de alerta
    $claseAlerta = ($tipoAlerta == "success") ? "alert-success" : "alert-danger";
    
    // Mostrar la alerta en la página
    echo <<<alert
    <div class="alert $claseAlerta alert-dismissible position-fixed fade show custom-alert" role="alert">
        <strong class="me-3">$mensaje </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    alert;
}

?>