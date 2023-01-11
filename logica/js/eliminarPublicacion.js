//Evento: modalEliminar
//Descripción: Este evento es para mostrar el modal con la confirmación de eliminación del registro

//Constante que obtiene el modal del documento por el id.         
const modalEliminar = document.getElementById('modalEliminar')

//Cuando el modal es activado este debe mostrarse
modalEliminar.addEventListener('show.bs.modal', event => {
                
    //Se crean constantes 
    //button devuelve el elemento relacionado con el elemento que activó el evento del mouse.
    const button = event.relatedTarget 
                
    //Se obtiene el id de la publicación a partir data-bs-idPublicacion, el cual se encuentra en el botón eliminar
    const idPublicacion = button.getAttribute('data-bs-idPublicacion') 

    //Se obtiene el id del vendedor a partir data-bs-idAdmin, el cual se encuentra en el botón eliminar
    const idAdmin = button.getAttribute('data-bs-idAdmin') 

    //Se  obtiene el elemento del modal con el id eliminarPublicacion
    const eliminar = modalEliminar.querySelector('#eliminarPublicacion') 
                
    //Se crea la variable action en la que se obtiene el data-bs-href que contiene el enlace de el archivo eliminarPublicacion
    var action = eliminar.getAttribute("data-bs-href")
    
    //Se asigna el href del enlace del botón
    eliminar.setAttribute("href",action+idAdmin+"&idPublicacion="+idPublicacion)
            
})    