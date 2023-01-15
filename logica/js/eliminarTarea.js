//Evento: modalEliminar
//Descripción: Este evento es para mostrar el modal con la confirmación de eliminación del registro

//Constante que obtiene el modal del documento por el id.         
const modalEliminar = document.getElementById('modalEliminar')
modalEliminar.addEventListener('show.bs.modal', event => {
    
    //Se crean constantes 
    //button devuelve el elemento relacionado con el elemento que activó el evento del mouse.
    const button = event.relatedTarget 
    
    //Se obtiene el id de la tarea a partir data-bs-idTarea, el cual se encuentra en el botón eliminar
    const idTarea = button.getAttribute('data-bs-idTarea') 

    //Se obtiene el id del mantenimientoa partir data-bs-idMantenimiento, el cual se encuentra en el botón eliminar
    const idMantenimiento = button.getAttribute('data-bs-idMantenimiento') 

    //Se obtiene el id del admin a partir data-bs-idAdmin, el cual se encuentra en el botón eliminar
    const idAdmin = button.getAttribute('data-bs-idAdmin') 

    //Se  obtiene el elemento del modal con el id eliminarTarea
    const eliminar = modalEliminar.querySelector('#eliminarTarea') 
    
    //Se crea la variable action en la que se obtiene el data-bs-href que contiene el enlace de el archivo
    var action = eliminar.getAttribute("data-bs-href")
    
    //Se asigna el href del enlace del botón
    eliminar.setAttribute("href",action+idAdmin+"&idTarea="+idTarea+"&idMantenimiento="+idMantenimiento)

})   