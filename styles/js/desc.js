var just = document.querySelector("#just");
var fund = document.querySelector("#fund");
var met = document.querySelector("#met");
var ext = document.querySelector("#ext")

var justC = document.querySelector("#justContent");
var fundC = document.querySelector("#fundContent");
var metC = document.querySelector("#metContent");
var extC = document.querySelector("#extContent");



just.addEventListener("click", function(){

    if(justC.style.display == 'none') {
        justC.style.display = 'block';
      }      
      else {
        justC.style.display = 'none';
      }   
})
fund.addEventListener("click", function(){

    if(fundC.style.display == 'none') {
        fundC.style.display = 'block';
      }      
      else {
        fundC.style.display = 'none';
      }   
})
met.addEventListener("click", function(){

    if(metC.style.display == 'none') {
        metC.style.display = 'block';
      }      
      else {
        metC.style.display = 'none';
      }   
})
ext.addEventListener('click', function(){
  if(extC.style.display == 'none') {
    extC.style.display = 'block';
  }      
  else {
    extC.style.display = 'none';
  } 
})