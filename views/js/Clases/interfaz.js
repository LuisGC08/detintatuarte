import * as selector from "../selectores.js";

class UI {
    
    mostrarPrecioTotal = (ptotal) => {
        selector.total.textContent = "Total: " + parseFloat(Math.round(ptotal * 100) / 100) + "€";
    }
    /**
    * Función encargada de mostrar los productos del carrito 
    * y llamar a la función sumarProductos que se encarga de mostrar el precio total de los productos comprados
    */
    mostrarCarritoHtml = (arrayCarrito) => {

        selector.listaCarrito.textContent = "";
        var ptotal = 0;
        arrayCarrito.map(producto => {
            const row = document.createElement('tr');
            row.innerHTML = `
        <td><img src='${producto.imagen}' class='img-fluid' width='50px'> </td>
        <td>${producto.titulo}</td>
        <td>
            <a href="#"><i class="fas fa-plus mas"  data-id="${producto.id}"></i></a>
                &nbsp;&nbsp;${producto.cantidad}&nbsp;
                <a href="#"><i class="fas fa-minus menos"  data-id="${producto.id}"></i></a>
        </td>
        <td>${producto.precio}</td>
        <td><a href="#" class="borrar-producto" data-id="${producto.id}">x</a></td>`;
            selector.listaCarrito.appendChild(row);
            ptotal += parseFloat(producto.precio)*producto.cantidad;
        });
        this.mostrarPrecioTotal(ptotal);
    }
}
export default UI;