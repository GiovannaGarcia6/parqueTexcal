//Evento: modalEliminar
//Descripción: Este evento es para mostrar el modal con la confirmación de eliminación del registro

//Constante que obtiene el modal del documento por el id.         
const modalEliminar = document.getElementById('modalEliminar')
modalEliminar.addEventListener('show.bs.modal', event => {
    
    //Se crean constantes 
    //button devuelve el elemento relacionado con el elemento que activó el evento del mouse.
    const button = event.relatedTarget 
    
    //Se obtiene el id del comentario a partir data-bs-idComentario, el cual se encuentra en el botón eliminar
    const idComentario = button.getAttribute('data-bs-idComentario') 

    //Se obtiene el id del usuario a partir data-bs-idVendedor, el cual se encuentra en el botón eliminar
    const id = button.getAttribute('data-bs-id') 

    //Se  obtiene el elemento del modal con el id eliminarComentario
    const eliminar = modalEliminar.querySelector('#eliminarComentario') 
    
    //Se crea la variable action en la que se obtiene el data-bs-href que contiene el enlace de el archivo 
    var action = eliminar.getAttribute("data-bs-href")
    
    //Se asigna el href del enlace del botón
    eliminar.setAttribute("href",action+id+"&idComentario="+idComentario)

})                