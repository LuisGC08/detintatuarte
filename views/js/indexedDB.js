import Carrito from "./Clases/Carrito.js";
import { cargarProductos } from "./funciones.js";
let DB;
/**
 * Función que crea el indexDB
 */
export function crearDB() {

    const crearDB = window.indexedDB.open('carrito', 1);
    //Compruebo que no se han producido errores
    crearDB.onerror = function () {
        console.log('Error en IndexedDB');
    }
//si no presenta ningún error
    crearDB.onsuccess = function () {
        console.log('Carrito cargado con éxito');
        DB = crearDB.result;
        cargarCarrito();
    }


//crea los elementos con su información
    crearDB.onupgradeneeded = function (e) {

        const db = e.target.result;

        const objectStore = db.createObjectStore('carrito', { keyPath: 'id' });
        
        objectStore.createIndex('titulo', 'titulo', { unique: false });
        objectStore.createIndex('subtitulo', 'subtitulo', { unique: false });
        objectStore.createIndex('precio', 'precio', { unique: false });
        objectStore.createIndex('cantidad', 'cantidad', { unique: false });
        objectStore.createIndex('imagen', 'imagen', { unique: false });
        objectStore.createIndex('id', 'id', { unique: true });
    }
}
/**
 * Función encargada de cargar el carrito 
 */
export function cargarCarrito() {
    const objectStore = DB.transaction('carrito').objectStore('carrito');
    const total = objectStore.getAll();
    total.onsuccess = function () {
        cargarProductos(total.result);
    }
}

/**
 * Función que elimina un producto cogiendolo por su id
 * @param {string} id 
 */
export function eliminarProductoDB(id) {


    const transaction = DB.transaction(['carrito'], 'readwrite');
    const objectStore = transaction.objectStore('carrito');

    const resultado = objectStore.delete(id);

    transaction.oncomplete = () => {
        console.log(`Eliminado`);
    }

//si ocurre algún error
    transaction.onerror = () => {
        console.log('Error en IndexedDB');
    }
}
/**
 * Función que añade un producto al indexDB
 * @param {Object} producto 
 */
export function addProductoDB(producto) {
    const transaction = DB.transaction(['carrito'], 'readwrite');
    const objectStore = transaction.objectStore('carrito');
    const peticion = objectStore.add(producto);

    transaction.oncomplete = () => {
        console.log('Producto agregado correctamente');
    }

    transaction.onerror = () => {
        console.log('Error en IndexedDB');
    }
}
/**
 * Función que edita un articulo
 * @param {Object} producto 
 */

export function editarProductoDB(producto) {
    const transaction = DB.transaction(['carrito'], 'readwrite');
    const objectStore = transaction.objectStore('carrito');
    const peticion = objectStore.put(producto);


    transaction.oncomplete = () => {
        console.log('Editado Correctamente.')
    }
    transaction.onerror = () => {
        console.log('Hubo un error.')
    }
}
/**
 * Función que elimina todos los artículos del carrito
 */
export function eliminarCarritoDB() {
    const transaction = DB.transaction(['carrito'], 'readwrite');
    const objectStore = transaction.objectStore('carrito');
    const peticion = objectStore.clear();

    //si todo funcina correctamente
    transaction.oncomplete = () => {
        console.log('Editado Correctamente.')
    }
    //si existe algún error
    transaction.onerror = () => {
        console.log('Hubo un error.')
    }
}
