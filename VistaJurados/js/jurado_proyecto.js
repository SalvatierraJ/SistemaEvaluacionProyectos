function colocarValorEnInput(idInput, valor) {
  const input = document.getElementById(idInput);
  if (input) {
    input.value = valor;
  } else {
    console.error("El input con el ID especificado no fue encontrado.");
  }
}
/* SLIDER Y SPAN */
document.querySelectorAll(".slider").forEach(function (slider) {
  // Encuentra el elemento 'span' relacionado con este control deslizante
  var output = slider.nextElementSibling.querySelector(".percentage");

  // Actualiza el valor del 'span' con el valor actual del control deslizante
  output.textContent = slider.value;

  // Agrega un evento 'input' para actualizar el valor cuando se mueva el control deslizante
  slider.oninput = function () {
    output.textContent = this.value;
  };
});

/* -------------------*/

let formularGuardarEvaluacion = document.getElementById("formularioProyecto");

formularGuardarEvaluacion.addEventListener("submit", function (e) {
  e.preventDefault();

  var myModal = document.getElementById("modalProyecto");
  var modal = bootstrap.Modal.getInstance(myModal);
  modal.hide();

  var myModal2 = document.getElementById("modalprotecto2");
  var modal2 = bootstrap.Modal.getInstance(myModal2);
  modal2.show();
  document.getElementById("cancelacion").addEventListener("click", function () {
    formularGuardarEvaluacion.reset();
    modal2.hide();
    modal.show();
  });

  document
    .getElementById("confirmacion")
    .addEventListener("click", function () {
      enviarDatosEvaluacion();
      modal2.hide();
    });
  modal.hide();
});

function enviarDatosEvaluacion() {
  let datos = new FormData();

  datos.append("guardarEvaluacion", "");
  datos.append("id_proyecto", formularGuardarEvaluacion.elements["id"].value);

  const spans = document.querySelectorAll(".percentage");
  i = 0;

  spans.forEach(function (span) {
    if (i == 0) {
      // cambiar aqui
      const valor = span.innerText;
      const valorEntero = parseInt(valor);
      datos.append("propuesta_academica", valorEntero);
    }
    if (i == 1) {
      const valor = span.innerText;
      const valorEntero = parseInt(valor);
      datos.append("pertinencia_propuesta", valorEntero);
    }
    if (i == 2) {
      const valor = span.innerText;
      const valorEntero = parseInt(valor);
      datos.append("grado_innovacion", valorEntero);
    }
    if (i == 3) {
      const valor = span.innerText;
      const valorEntero = parseInt(valor);
      datos.append("calidad_prototipado", valorEntero);
    }
    if (i == 4) {
      const valor = span.innerText;
      const valorEntero = parseInt(valor);
      datos.append("impacto_social", valorEntero);
    }
    if (i == 5) {
      const valor = span.innerText;
      const valorEntero = parseInt(valor);
      datos.append("sostenibilidad_propuesta", valorEntero);
    }
    i++;
  });

  let solicitudHTTP = new XMLHttpRequest();
  solicitudHTTP.open("POST", "AJAX/jurado_proyectos_crud.php", true);

  solicitudHTTP.onload = function () {
    var myModal = document.getElementById("modalProyecto");
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    console.log(this.responseText);
    if (parseInt(this.responseText) == 1) {
      alerta("success", "Se guardo la evaluacion con exito");
      reiniciarValoresSpans();
      formularGuardarEvaluacion.reset();
    } else {
      alerta("error ", "revise las consultas fallida");
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

function obtenerYCambiarBoton(selector) {
  var idBoton = document.getElementById("inputidproyecto").value;
  cambiarBoton(idBoton, selector);
}

function cambiarBoton(id, selector) {
  if (selector == "1") {
    var boton = document.getElementById(id);
    boton.innerHTML = '<ion-icon name="checkmark-outline"></ion-icon>';
    boton.disabled = true;
    boton.classList.remove("btn-dark");
    boton.classList.add("btn-success");
  } else {
    var boton = document.getElementById(id);
    boton.innerHTML = '<ion-icon name="analytics-outline"></ion-icon> Evaluar';
    boton.disabled = false;
    boton.classList.remove("btn-success");
    boton.classList.add("btn-dark");
  }
}

function reiniciarValoresSpans() {
  document.querySelectorAll(".slider").forEach(function (slider) {
    slider.value = 0; // Establecer el valor del control deslizante en 0
    var output = slider.nextElementSibling.querySelector(".percentage"); // Obtener el span asociado
    output.textContent = slider.value; // Actualizar el valor mostrado en el span
  });
}
