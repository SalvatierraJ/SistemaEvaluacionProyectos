
///////////////////////

function leerArchivo(id) {
  let input = document.getElementById(id);
  input.click(); // Abre el selector de archivos

  input.addEventListener("change", function () {
    let archivo = input.files[0];
    let lector = new FileReader();

    lector.onload = function (evento) {
      let contenido = evento.target.result;
      let lineas = contenido.split(";");

      let datos = new FormData();
      datos.append("agregarequipos", "");

      let contadorEquipos = 1;

      lineas.forEach(function (linea) {
        let elementos = linea.trim().split(",");
        if (elementos.length >= 4) { // Verificar que hay al menos 4 elementos por línea
          let nombreGrupo = elementos[0].trim();
          let carrera = elementos[1].trim();
          let nombreProyecto = elementos[2].trim();
          let integrantes = elementos
            .slice(3)
            .map((item) => item.trim())
            .join(", ");
          datos.append(`equipo${contadorEquipos}_nombre_grupo`, nombreGrupo);
          datos.append(`equipo${contadorEquipos}_carrera`, carrera);
          datos.append(`equipo${contadorEquipos}_nombre_proyecto`, nombreProyecto);
          datos.append(`equipo${contadorEquipos}_nombre_integrante`, integrantes);
          contadorEquipos++;
        }
      });
      for (let entry of datos.entries()) { 
        console.log(entry[0] + ": " + entry[1]);
      }
      let solicitudHTTP = new XMLHttpRequest();

      solicitudHTTP.open("POST", "AJAX/administrador_crud.php", true);

      solicitudHTTP.onload = function() {
        if (this.status === 200) {
          if (this.responseText == 1) {
            alerta('success', 'Se guardaron los datos de los equipos con éxito');

            obtenerTodosLosEquipos();

          } else {

            alerta('error', 'Cargar datos de equipo falló');
          }
        } else {
          alerta('error', 'Hubo un error al comunicarse con el servidor');
        }
      };

      solicitudHTTP.send(datos);
    };

    lector.readAsText(archivo);
  });
}
////////////////////

function obtenerTodosLosEquipos() {
  let solicitudHTTP = new XMLHttpRequest();
  solicitudHTTP.open("POST", "AJAX/administrador_crud.php", true);
  solicitudHTTP.setRequestHeader(
    "Content-Type",
    "application/x-www-form-urlencoded"
  );

  solicitudHTTP.onload = function () {
    document.getElementById("datos_equipo").innerHTML = this.responseText;
  };
  solicitudHTTP.send("obtenerTodosLosEquipos");
}

let formularioEditarEquipos = document.getElementById("editarEquipos");

function editarEquipos(id) {
  let solicitudHTTP = new XMLHttpRequest();
  solicitudHTTP.open("POST", "AJAX/administrador_crud.php", true);
  solicitudHTTP.setRequestHeader(
    "Content-Type",
    "application/x-www-form-urlencoded"
  );

  solicitudHTTP.onload = function () {
    let datos = JSON.parse(this.responseText);

    formularioEditarEquipos.elements["nombreProyecto"].value =
      datos.datoProyecto.nombre_proyecto;
    formularioEditarEquipos.elements["nombreGrupo"].value =
      datos.datoProyecto.nombre_grupo;
    formularioEditarEquipos.elements["carrera"].value =datos.datoProyecto.carrera;
    formularioEditarEquipos.elements["integrantes"].value =
      datos.datosIntegrantes.nombre_integrante;
    formularioEditarEquipos.elements["id"].value = datos.datoProyecto.id;
  };
  solicitudHTTP.send("obtenerEquipo=" + id);
}

formularioEditarEquipos.addEventListener("submit", function (e) {
  e.preventDefault();
  enviarEdicionEquipo();
});

function enviarEdicionEquipo() {
  let datos = new FormData();
  datos.append("edicionDeEquipos", "");
  datos.append(
    "nombre_proyecto",
    formularioEditarEquipos.elements["nombreProyecto"].value
  );
  datos.append(
    "nombre_grupo",
    formularioEditarEquipos.elements["nombreGrupo"].value
  );
  datos.append(
    "carrera",
    formularioEditarEquipos.elements["carrera"].value
  );
  datos.append(
    "nombre_integrante",
    formularioEditarEquipos.elements["integrantes"].value
  );
  datos.append("id", formularioEditarEquipos.elements["id"].value);
  datos.append("id_proyecto", formularioEditarEquipos.elements["id"].value);

  let solicitudHTTP = new XMLHttpRequest();
  solicitudHTTP.open("POST", "AJAX/administrador_crud.php", true);

  solicitudHTTP.onload = function () {
    var myModal = document.getElementById("modalEditarEquipo");
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if (this.responseText == 1) {
      alerta("success", "Se editaron los datos del equipo con exito");
      formularioEditarEquipos.reset();
      obtenerTodosLosEquipos();
    } else {
      alerta("error ", "no se pudieron editar los datos del equipo ");
    }
  };

  solicitudHTTP.send(datos);
}

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

  setTimeout(function () {
    alertaDiv.remove();
  }, 5000);
}
window.onload = function () {
  obtenerTodosLosEquipos();
};
