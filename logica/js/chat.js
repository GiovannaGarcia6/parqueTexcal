
$(document).ready(function() {
    // Establecer variables
    var trigger = $('.container .display-chat '),
        container = $('#content');

    // Se activa cuando hace clic
    trigger.on('click', function() {
        
        // $this es para reutilizarlo y $target se usa para obtener los datos
        var $this = $(this),
            target = $this.data('target');

        //Carga lo que contiene la página
        container.load(target + '.php');

        return false;
    });
    //Bajar el scroll
    $('.display-chat').scrollTop( $('.display-chat').prop('scrollHeight') );   
});
