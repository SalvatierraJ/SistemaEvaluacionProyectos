
document.addEventListener('click', function (event) {
    if(event.target.id === 'juradocheck'){
        var solicitudHTTP = new XMLHttpRequest();
        var estadoCheckbox = event.target.checked ? 'activo' : 'inactivo';
        var juradocheckid = event.target.getAttribute("juradoid");
        solicitudHTTP.open("POST", "AJAX/administrador_crud.php", true);
        solicitudHTTP.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        solicitudHTTP.onload = function () {
            console.log(this.responseText);
        };
        
        // Incluir el estado y el valor del checkbox en los datos enviados
        solicitudHTTP.send("juradocheck=" + estadoCheckbox + "&juradocheckid=" + juradocheckid);
    }
});


function enviarEstadoCheckbox() {
    
    var checkbox = document.getElementById('juradocheck');
    var estadoCheckbox = checkbox.checked ? 'si' : 'no';
  
    solicitudHTTP.open("POST", "AJAX/administrador_crud.php", true);
    solicitudHTTP.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
    solicitudHTTP.onload = function () {
      document.getElementById("datos_equipo").innerHTML = this.responseText;
    };
  
    // Incluir el estado del checkbox en los datos enviados
    solicitudHTTP.send("obtenerTodosLosEquipos&juradocheck=" + estadoCheckbox);
  }
  