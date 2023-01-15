
//Evento: modalCambiarEstado
//Descripción: Este evento es para mostrar el modal con la confirmación de eliminación del registro

//Constante que obtiene el modal del documento por el id.         
const modalFinalizar = document.getElementById('modalCambiarEstado')
modalFinalizar.addEventListener('show.bs.modal', event => {
                
    //Se crean constantes 
    //button devuelve el elemento relacionado con el elemento que activó el evento del mouse.
    const button = event.relatedTarget 
                
    //Se obtiene el id del empleado a partir data-bs-id, el cual se encuentra en el botón finalizar
    const idEmpleado = button.getAttribute('data-bs-idEmpleado') 

    //Se obtiene el id del vendedor a partir data-bs-idVendedor, el cual se encuentra en el botón eliminar
    const idTarea = button.getAttribute('data-bs-idTarea') 

    //Se obtiene el estado de la tarea a partir del data-bs-estado
    const estado = button.getAttribute('data-bs-estado') 

    //Se  obtiene el elemento del modal 
    const finalizar = modalFinalizar.querySelector('#finalizarTarea') 
                
    //Se crea la variable action en la que se obtiene el data-bs-href que contiene el enlace de el archivo eliminarNEgocio
    var action = finalizar.getAttribute("data-bs-href")
    
    //Se asigna el href del enlace del botón
    finalizar.setAttribute("href",action+idEmpleado+"&idTarea="+idTarea+"&estado="+estado)
            
})