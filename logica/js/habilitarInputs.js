//Se obtiene los datos del input.
var inputImagen = document.getElementById('imagen');
var inputVideo = document.getElementById('video');

//La función habilitar hace editable el campo correspondiente al tipo de publicación
function habilitar(elemento) {
    tipoPublicacion = elemento.value;
    //Si la clave que se envia es igual a estudiante no se pedira este requisito de agregar una clave.
    if(tipoPublicacion == "Imagen"){
        inputVideo.style.display = 'none'; // hide
        inputImagen.style.display = ''; // show
    }else{
        if(tipoPublicacion == "Video"){
            inputVideo.style.display = ''; // hide
            inputImagen.style.display = 'none'; // show
        }else{
            inputVideo.style.display = ''; // hide
            inputImagen.style.display = ''; // show
        }
    }
}