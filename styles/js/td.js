// Get the modal
function myFunction() {
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
    }
}



// function myFunction() {
//     var x = document.getElementById("mostrarsenha");
//     if (x.type === "password") {
//       x.type = "text";
//     } else {
//       x.type = "password";
//     }
//   }


//   <label id="mostrar" onclick="myFunction()"> Mostrar Senha! </label>