var alert = document.querySelector("#alert-item");
var error = document.querySelector("#alert-error");
var button = document.querySelector("#back");      
button.addEventListener('click', function(){
   if(alert){
   alert.style.top="-100%"
   }
   else{
  error.style.top="-100%"
       }
          })
