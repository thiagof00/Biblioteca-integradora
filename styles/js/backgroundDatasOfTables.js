var dados = document.getElementsByClassName("claro")
var i = 0


var quantDados = dados.length()

while(i < quantDados){
    if(dados[i]% 2 == 0){
        dados[i].style.background = "#FFF"
    }
}