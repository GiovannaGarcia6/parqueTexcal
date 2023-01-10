/*
    Nombre de la función: mostrarContrasena() 
    Descripción: Esta función permite mostrar y ocultar la contraseña 
    cada que se active el botón. 
*/
function mostrarContrasena(){
    //Se almacenan los elementos por el id
    var tipo = document.getElementById("password"); 
    var icono = document.getElementById("icono");

    //Si el tipo del input de la contraseña es password, lo convertirá a texto 
    //y cambiará la clase de el icono que se encuentra en el botón
    if(tipo.type == "password"){
        tipo.type = "text";
        icono.className ="fa-solid fa-eye-slash icono";
    }else{
        //En cambio, si el tipo del input es text este se cambiará a password 
        //y cambiará la clase de el icono que se encuentra en el botón
        tipo.type = "password";
        icono.className ="fa-solid fa-eye icono";
    }
}
