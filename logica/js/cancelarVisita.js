//Evento: modalCancelar
//Descripción: Este evento es para mostrar el modal con la confirmación para cancelar la visita

//Constante que obtiene el modal del documento por el id.         
const modalCancelar = document.getElementById('modalCancelar')
modalCancelar.addEventListener('show.bs.modal', event => {
                
    //Se crean constantes 
    //button devuelve el elemento relacionado con el elemento que activó el evento del mouse.
    const button = event.relatedTarget 
                
    //Se obtiene el id del vendedor a partir data-bs-id, el cual se encuentra en el botón cancelar
    const id = button.getAttribute('data-bs-id') 

    //Se obtiene el id de la visita a partir data-bs-idVisita, el cual se encuentra en el botón eliminar
    const idVisita = button.getAttribute('data-bs-idVisita') 

    //Se  obtiene el elemento del modal con el id cancelarVisita
    const cancelar = modalCancelar.querySelector('#cancelarVisita') 
                
    //Se crea la variable action en la que se obtiene el data-bs-href que contiene el enlace de el archivo eliminarNEgocio
    var action = cancelar.getAttribute("data-bs-href")
                
    //Se asigna el href del enlace del botón
    cancelar.setAttribute("href",action+id+"&idVisita="+idVisita)
            
})      