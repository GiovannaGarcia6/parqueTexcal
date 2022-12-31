//Se obtiene los datos del input.
var inputImagen = document.getElementById('imagen');
var inputVideo = document.getElementById('video');
var imagenMostrada= document.getElementById('mostrarImagen');

//La función habilitar hace editable el campo correspondiente al tipo de publicación
function habilitar(elemento) {
    tipoPublicacion = elemento.value;
    //Si la clave que se envia es igual a estudiante no se pedira este requisito de agregar una clave.
    if(tipoPublicacion == "Imagen"){
        inputVideo.style.display = 'none'; 
        inputImagen.style.display = ''; 
        imagenMostrada.style.display = '';

    }else{
        if(tipoPublicacion == "Video"){
            inputVideo.style.display = ''; 
            inputImagen.style.display = 'none';
            imagenMostrada.style.display = 'none';

        }else{
            inputVideo.style.display = ''; 
            inputImagen.style.display = ''; 
            imagenMostrada.style.display = '';

        }
    }
}