//Evento: modalFinalizar
            //Descripción: Este evento es para mostrar el modal con la confirmación de eliminación del registro

            //Constante que obtiene el modal del documento por el id.         
            const modalFinalizar = document.getElementById('modalFinalizar')
            modalFinalizar.addEventListener('show.bs.modal', event => {
                
                //Se crean constantes 
                //button devuelve el elemento relacionado con el elemento que activó el evento del mouse.
                const button = event.relatedTarget 
                
                //Se obtiene el id del negocio a partir data-bs-id, el cual se encuentra en el botón cancelar
                const id = button.getAttribute('data-bs-id') 

                //Se obtiene el id del vendedor a partir data-bs-idVendedor, el cual se encuentra en el botón eliminar
                const idVisita = button.getAttribute('data-bs-idVisita') 

                //Se  obtiene el elemento del modal con el id eliminarNegocio
                const finalizar = modalFinalizar.querySelector('#finalizarVisita') 
                
                //Se crea la variable action en la que se obtiene el data-bs-href que contiene el enlace de el archivo eliminarNEgocio
                var action = finalizar.getAttribute("data-bs-href")
                //Se asigna el href del enlace del botón
                finalizar.setAttribute("href",action+id+"&idVisita="+idVisita)
            })   