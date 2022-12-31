//Evento: modalEliminar
            //Descripción: Este evento es para mostrar el modal con la confirmación de eliminación del registro

            //Constante que obtiene el modal del documento por el id.         
            const modalEliminar = document.getElementById('modalEliminar')
            modalEliminar.addEventListener('show.bs.modal', event => {
                
                //Se crean constantes 
                //button devuelve el elemento relacionado con el elemento que activó el evento del mouse.
                const button = event.relatedTarget 
                
                //Se obtiene el id del negocio a partir data-bs-id, el cual se encuentra en el botón eliminar
                const idNegocio = button.getAttribute('data-bs-id') 

                //Se obtiene el id del vendedor a partir data-bs-idVendedor, el cual se encuentra en el botón eliminar
                const idVendedor = button.getAttribute('data-bs-idVendedor') 

                //Se  obtiene el elemento del modal con el id eliminarNegocio
                const eliminar = modalEliminar.querySelector('#eliminarNegocio') 
                
                //Se crea la variable action en la que se obtiene el data-bs-href que contiene el enlace de el archivo eliminarNEgocio
                var action = eliminar.getAttribute("data-bs-href")
                var link = action+idNegocio+"&idVendedor="+idVendedor;
                console.log(link);
                //Se asigna el href del enlace del botón
                eliminar.setAttribute("href",action+idNegocio+"&idVendedor="+idVendedor)
            
            })   