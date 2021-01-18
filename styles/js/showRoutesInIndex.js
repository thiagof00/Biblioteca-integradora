var routes = documment.querySelectorAll(".routes")
var addRoutes = document.querySelectorAll(".addRoutes")

routes.addEventListener('onmouseover', function(){
    addRoutes.style.display = 'block'
})

routes.addEventListener('onmouseout', function(){
    addRoutes.style.display = 'none'
})