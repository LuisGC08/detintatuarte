import Carrito from "./Clases/Carrito.js";
import UI from "./Clases/interfaz.js";
import * as selector from "./selectores.js";
import { addProductoDB, editarProductoDB, eliminarProductoDB, eliminarCarritoDB, cargarCarrito} from "./indexedDB.js";


const carrito = new Carrito();
const ui = new UI();



/**
 * Función para vaciar el carrito
 * @param {evento} e 
 */
export function vaciarCompra(e) {
    e.preventDefault();
    vaciarCarritoCompleto();
}

/**
 * Función para agregar artículos
 * @param {event} e 
 */
export function comprarProducto(e) {
    e.preventDefault();
    if (e.target.classList.contains('agregar-carrito')) {
        const producto = e.target.parentElement.parentElement;
        leerDatosProducto(producto);
    }
}
/**
 * Función para leer los datos del artículo y comprueba si existe ya ese producto o no
 * @param {Object} producto 
 */
export function leerDatosProducto(producto) {
    if (parseInt(producto.querySelector("#cantidad").value) > 0) {
        const infoProducto = {


            imagen: producto.querySelector('img').src,
            titulo: producto.querySelector('.nombre').textContent,
            precio: producto.querySelector('.precio').textContent,

            
            id: producto.querySelector('button').getAttribute('data-id'),
            cantidad: producto.querySelector("#cantidad").value
        }

        //Comprueba si hay algún id en el array
        if (carrito.getProductos().some(p => p.id == infoProducto.id)) {

            //Obtengo el el artículo por su id
            let p = carrito.getProductos().find(p => p.id == infoProducto.id);
            infoProducto.cantidad = parseInt(infoProducto.cantidad);
            infoProducto.cantidad += parseInt(p.cantidad);
            carrito.editarProducto(infoProducto);
            editarProductoDB(infoProducto);
        } else {
            carrito.agregarProducto(infoProducto);
            addProductoDB(infoProducto);
        }


        selector.cantidadCarrito.textContent = carrito.cantidadProductos();
        ui.mostrarCarritoHtml(carrito.getProductos());
        setTimeout( () => {
            producto.querySelector("#cantidad").value = "";
        }, 3000);
    } else {
        producto.querySelector(".form-group").classList.add("is-focused");
        const divMensaje = document.createElement('div');
        divMensaje.classList.add('text-center', 'alert', 'd-block', 'col-12');
        divMensaje.classList.add('alert-danger');
        

        // Muestra un mensaje si se intenta agretar algún valor negativo
        divMensaje.textContent = "No se pueden insertar valores negativos";

        // Insertar en el DOM
        producto.querySelector('.precio').after(divMensaje);

        // Quitar el alert despues de 3 segundos
        setTimeout( () => {
            producto.querySelector(".form-group").classList.remove("is-focused");
            divMensaje.remove();
        }, 3000);
    }
}
/**
 * Función para eliminar un producto seleccionado
 * @param {evento} e 
 */
export function eliminarProducto(e) {
    e.preventDefault();
    let producto, productoID;
    if (e.target.classList.contains('borrar-producto')) {

        //voy al elemento padre del botón
        e.target.parentElement.parentElement.remove(); 
        //Recojo el producto
        producto = e.target.parentElement.parentElement; 
        //Recojo el ID del producto
        productoID = producto.querySelector('a').getAttribute('data-id'); 
//Elimino el producto del array a través de la función
        carrito.borrarProducto(producto); 
        //actualizo la cantidad de productos del carrito
        selector.cantidadCarrito.textContent = carrito.cantidadProductos(); 
        //Elimino el producto de la DB
        eliminarProductoDB(productoID); 
    }
    //Recargo el precio de los productos
    ui.mostrarPrecioTotal(carrito.sumarProductos()); 
}
/**
 * Función que añade o quita objetos en el carrito
 * Si el articulo tiene 0 unidades, este se elimina
 * @param {event} e
 * @param {String} cadena 
 */
export function cantidadProducto(e, cadena) {
    e.preventDefault();
    let producto, productoID;
    producto = e.target.parentElement.parentElement;
    productoID = producto.querySelector('i').getAttribute('data-id');
    carrito.getProductos().map(p => {
        if (p.id == productoID) {
            if (cadena == "mas") {
                p.cantidad++;
                carrito.editarProducto(p);
                editarProductoDB(p);
            } else if (cadena == "menos") {
                if (p.cantidad == 1) {
                    carrito.borrarProducto(p.id);
                    eliminarProductoDB(p.id);
                } else {
                    p.cantidad--;
                }
            }

        }
    });
    selector.cantidadCarrito.textContent = carrito.cantidadProductos();
    ui.mostrarCarritoHtml(carrito.getProductos()); //Actualizo el carrito
}
/**
 * Función que procesa la compra y coge los objetos del formulario
 */
export function procesarCompra() {
    var pedido = carrito.getProductos();
    console.log(pedido);
    
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
                console.log(dataResult.data.mensaje);
            }  else {
                vaciarCarritoCompleto();
                window.location.replace('index.php?controller=pedidos&action=listar');
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) { //fallo
            console.log("Error: Numero " + jqXHR.status.toString() + " Texto " + textStatus + " " + errorThrown);
        });
}

//funcion para mostrar el carrito
export function mostrarCarrito(e) {
    e.preventDefault();
    ui.mostrarProductos();
}
//función para cargar los productos del carrito
export function cargarProductos(productos) {
    carrito.setProductos(productos);
    ui.mostrarCarritoHtml(carrito.getProductos());
    selector.cantidadCarrito.textContent = carrito.cantidadProductos();
}
//función para vaciar el carrito
export function vaciarCarritoCompleto(){
    while (selector.listaCarrito.firstChild) { //Mientras listaCarrito tenga hijo lo elimina
        selector.listaCarrito.removeChild(selector.listaCarrito.firstChild);
    }
    carrito.vaciarCarrito(); //vacio el array del Carrito
    selector.cantidadCarrito.textContent = carrito.cantidadProductos(); //Actualizo la cantidad del carrito 
    eliminarCarritoDB();
    ui.mostrarPrecioTotal(carrito.sumarProductos());
}