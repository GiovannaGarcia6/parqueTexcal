       //Evento: modalEliminar
            //Descripción: Este evento es para mostrar el modal con la confirmación de eliminación del registro

            //Constante que obtiene el modal del documento por el id.         
            const modalEliminar = document.getElementById('modalEliminar')
            modalEliminar.addEventListener('show.bs.modal', event => {
                
                //Se crean constantes 
                //button devuelve el elemento relacionado con el elemento que activó el evento del mouse.
                const button = event.relatedTarget 
               
                //Se obtiene el id del administrador a partir data-bs-id
                const idAdmin = button.getAttribute('data-bs-id') 

                //Se obtiene el id del boleto a partir data-bs-idBoleto, el cual se encuentra en el botón eliminar
                const idBoleto = button.getAttribute('data-bs-idBoleto') 

                //Se  obtiene el elemento del modal con el id eliminarBoleto
                const eliminar = modalEliminar.querySelector('#eliminarBoleto') 
                
                //Se crea la variable action en la que se obtiene el data-bs-href que contiene el enlace de el archivo eliminarBoleto
                var action = eliminar.getAttribute("data-bs-href")
                    
                //Se asigna el href del enlace del botón
                eliminar.setAttribute("href",action+idAdmin+"&idBoleto="+idBoleto)
            
            })  