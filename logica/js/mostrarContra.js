
function mostrarContrasena(){
    var tipo = document.getElementById("password");
    var icono = document.getElementById("icono");
    if(tipo.type == "password"){
        tipo.type = "text";
        icono.className ="fa-solid fa-eye-slash icono";
    }else{
        tipo.type = "password";
        icono.className ="fa-solid fa-eye icono";
    }
}
