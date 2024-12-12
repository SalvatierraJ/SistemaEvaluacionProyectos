<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(E_ALL); // Error/Exception engine, always use E_ALL

ini_set('ignore_repeated_errors', TRUE); // always use TRUE

ini_set('display_errors', FALSE); // Error/Exception display, use FALSE only in production environment or real server. Use TRUE in development environment

ini_set('log_errors', TRUE); // Error/Exception file logging engine.

ini_set("error_log", "C:/xampp/htdocs/Proyectos/php-error.log");

require('./Administrador/php/esenciales.php');
require('./Administrador/php/conexionBasededatos.php');
session_start();
if ((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
  redireccionar('./Administrador/administrador.php');
} elseif ((isset($_SESSION['juradoLogin']) && $_SESSION['juradoLogin'] == true)) {
  redireccionar('./VistaJurados/jurado_proyectos.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="./Estilos/index.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
</head>

<body style="
    /* height: 100%; */
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center; ">
  <div class="login-screen">
    <img src="./public/30confondodecolorrojo-removebg-preview.png" alt="" style="
    width: 300px;
"/>
    <div class="login-form">
      <form method="POST">
        <br />
        <div class="form__group field">
          <input type="text" class="form__field" placeholder="USUARIO" name="usuario" id='usuario' required />
          <label for="usuario" class="form__label">USUARIO</label>
        </div>
        <br>
        <div class="form__group field">
          <input type="password" class="form__field" placeholder="CONTRASEÑA" name="password" id='password' required />
          <label for="password" class="form__label">CONTRASEÑA</label>

        </div>
        <br>
        <br>
        <input name="iniciarSesion" type="submit" value="INGRESAR" />
        <br>
        <br>
      </form>
    </div>
  </div>

  <?php




  if (isset($_POST['iniciarSesion'])) {

    $frm_data = filtrarPor($_POST);
    $query = "SELECT * FROM usuarios WHERE usuario = ? AND contrasena = ?";
    $values = [$frm_data['usuario'], $frm_data['password']];
    $datatypes = "ss";

    $res = seleccionarTabla($query, $values, $datatypes);
    if ($res->num_rows == 1) {
      $row = mysqli_fetch_assoc($res);
      if ($row['rol'] == 'adm') {
        $_SESSION['adminLogin'] = true;
        $_SESSION['adminId'] = $row['id'];
        redireccionar('./Administrador/administrador.php');
      } elseif ($row['rol'] == 'jurado' && $row['estado'] == 'activo') {
        $_SESSION['juradoLogin'] = true;
        $_SESSION['id_jurado'] = $row['id'];
        redireccionar('./VistaJurados/jurado_proyectos.php');
      } else {
        alerta('error', 'Usuario Inactivo');
      }
    } else {
      alerta('error', 'Usuario o contraseña inválida');
    }
  }


  ?>
</body>
<script>
  function alerta(tipoAlerta, mensaje) {
    let claseAlerta = tipoAlerta == "success" ? "alert-success" : "alert-danger";
    let alertaDiv = document.createElement("div");
    alertaDiv.classList.add(
      "alert",
      claseAlerta,
      "alert-dismissible",
      "position-fixed",
      "fade",
      "show",
      "custom-alert"
    );
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
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</html>