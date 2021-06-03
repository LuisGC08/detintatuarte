import { vaciarCompra,
    comprarProducto,
    eliminarProducto,
    cantidadProducto,
    procesarCompra
} from '../funciones.js';
import * as selector from '../selectores.js';
class App {
    constructor() {
        this.initApp();
    }

    initApp() {
        if(selector.listaProductos){
            selector.listaProductos.addEventListener('click', (e) => { comprarProducto(e) });
        }
        
        selector.carro.addEventListener('click', (e) => {
            if (e.target.classList.contains('borrar-producto')) {
                eliminarProducto(e);
            } else if (e.target.classList.contains('mas')) {
                cantidadProducto(e, "mas");
            } else if (e.target.classList.contains('menos')) {
                cantidadProducto(e, "menos");
            }
        });
        selector.vaciarCarritoBtn.addEventListener('click', (e) => { vaciarCompra(e) });
        selector.procesarCompraBtn.addEventListener('click', (e) => { 
            e.preventDefault();
            procesarCompra() });
    }
}

export default App;