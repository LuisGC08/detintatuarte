class Carrito {
    constructor() {
        this.productos = [];
    }
    /**
     * Getter de Productos
     */
    getProductos() {
        return this.productos;
    }
    /**
     * Setter de Productos
     * @param {*} productos 
     */
    setProductos(productos){
        this.productos = productos;
    }
    /**
    * Función encargada de agregar un producto
    * @param {Object} producto 
    */
    agregarProducto = (producto) => {
        this.productos.push(producto);
    }
    /**
     * Función encargada de eliminar un producto
     * @param {object} producto 
     */
    borrarProducto = (producto) => {
        [producto, ...this.productos] = this.productos;
    }
    /**
     * Función encargada de modificar un producto
     * @param {object} productoActualizado
     */
    editarProducto(productoActualizado) {
        this.productos = this.productos.map( producto => producto.id === productoActualizado.id ? productoActualizado : producto);
    }
    /**
     * Función utilizada para actualizar el precio total de la compra
     */
    sumarProductos = () => {
        let ptotal = this.productos.reduce((acumulador, product) => (acumulador + parseFloat(product.precio)) * product.cantidad, 0);
        return ptotal;
    }
    vaciarCarrito = () =>{
        this.productos.length = 0;
    }
    cantidadProductos = () =>{
        let cantidad = 0;
        this.productos.map(producto =>{
            cantidad += parseInt(producto.cantidad);
        })
        return cantidad;
    }
}
export default Carrito;