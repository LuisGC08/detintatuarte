/* $(document).ready(function (e) {
    $('.pedido').on('click', function (event) {
        $(".modal-body tbody").empty();
        var par = $(event.target).parent().parent();
        var id = par.find("#cod_ped").text();
        console.log(id);
        $.ajax({
            url: 'index.php?controller=pedidos&action=ver',
            method: 'POST',
            dataType: 'JSON',
            data: {
                id: id
            },
            cache: false
        })
            .done(function (dataResult) {
                var contenido = "";
                for (let index = 0; index < dataResult.data.lineas_pedido.length; index++) {
                    contenido += `<td><img src='${dataResult.data.lineas_pedido[index].imagen}' class='img-fluid' width='50px'> </td>
                    <td>${dataResult.data.articulos_pedido[index].nombre}</td>
                    <td>
                        ${dataResult.data.articulos_pedido[index].precio} €
                    </td>
                    <td>
                        ${dataResult.data.lineas_pedido[index].cantidad} €
                    </td>
                    <td>${dataResult.data.lineas_pedido[index].cantidadenAlbaran}</td>
                    <td>
                        ` + dataResult.data.lineas_pedido[index].cantidad * dataResult.data.articulos_pedido[index].precio ` €
                    </td>`;
                    if(dataResult.data.lineas_pedido[index].esBorrable == true){
                        contenido += ` <td><a href="#" class="borrar-producto" data-id="${producto.id}">x</a></td>`;
                    } else {
                        contenido += `<td>En albaran</td>`;
                    }
                   
                    
                }
                
                $(".modal-body tbody").append(dataResult.data.mensaje);
                $(".modal-body .total").empty();
                $(".modal-body .total").append("Total: " + dataResult.data.total + " €");
            })
            .fail(function (jqXHR) {
                $("#mensaje").addClass('alert alert-danger');
                $("#mensaje p").html("Error: Numero " + jqXHR.status.toString());
            })
    }); 

});
function cogerValores(parent){
    console.log(parent.childNode());
}
 */