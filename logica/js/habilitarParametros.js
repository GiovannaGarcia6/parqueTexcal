
var parametro1 = document.getElementById('parametro1');
var parametro2 = document.getElementById('parametro2');
var parametro3 = document.getElementById('parametro3');

  
//La función habilitar hace que se habiliten los parametros correspondientes a la seccion elegida
function habilitar(elemento) {
    seccion = elemento.value;
    //Si la clave que se envia es igual a estudiante no se pedira este requisito de agregar una clave.
    if(seccion == "Comentarios"){
        parametro1.style.display = ''; // show
        parametro2.style.display = ''; // show
        parametro3.style.display = 'none'; // hide
    }else{
       
            parametro1.style.display = 'none'; // hide
            parametro2.style.display = 'none'; // hide
            parametro3.style.display = ''; // show

    }
}