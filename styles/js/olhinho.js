function myFunction() {
    var x = document.getElementById("csenha");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}