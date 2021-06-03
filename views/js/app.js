import App from "./Clases/App.js";
import {crearDB} from "./indexedDB.js";

const app = new App();

document.addEventListener('DOMContentLoaded', () => {
    crearDB();
});

