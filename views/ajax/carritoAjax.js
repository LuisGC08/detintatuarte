import { procesarCompra,
    vaciarCarritoCompleto
} from '../js/funciones.js';
/* $(document).ready(function (e) {
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body input').val(recipient)
    });
}); */
export function procesarCompraAjax(){
    
    var pedido = procesarCompra();
    console.log("pedido");
    console.log(pedido);
    vaciarCarritoCompleto();
    $.ajax({
        url: 'index.php?controller=carrito&action=procesar',
        method: 'POST',
        dataType: 'JSON',
        data: {
            compra: pedido
        },
        cache: false
    })
        .done(function (dataResult) {
            if (dataResult.success == false) {
                $("#mensaje").addClass('alert alert-danger');
                $("#mensaje p").html(dataResult.data.mensaje);
            }  else {
                window.location.replace('index.php?controller=pedidos&action=listar');
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) { //fallo
            console.log("Error: Numero " + jqXHR.status.toString() + " Texto " + textStatus + " " + errorThrown);
        });
}
