<div class="container-fluid" id="lista-productos">
    <div class="row">
        <?php
        foreach ($articulos as $key => $articulo) {
        ?>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="card" style="width: 18rem; margin-left:50px; margin-bottom:50px;">
                    <img class="card-img-top" src="views/img/<?= (!is_null($articulo->getImagen())) ? $articulo->getImagen() : "default.png" ?>" alt="Card image cap" width="100%" height="225">
                    <div class="card-body">
                        <h5 class="cart-title text-center nombre" id="nombre"><?= $articulo->getNombre() ?></h5>
                        <p class="cart-text text-center" id="descripcion"><?= $articulo->getDescripcion() ?></p>
                        <p class="cart-text text-center precio"><?= $articulo->getPrecio() ?>€</p>
                        <div class="form-group float-left">
                            <label for="cantidad" class="bmd-label-floating">Cantidad</label>
                            <input type="num" pattern="[0-9]+(\.[0-9][0-9]?)?" class="form-control cantidad" name="cantidad" id="cantidad" maxlength="50" default="0" value="1">
                        </div>
                        <button type="button" class="btn btn-primary float-right mt-4 agregar-carrito" data-id="<?= $articulo->getCod_articulo(); ?>">Agregar</button>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>
</div>
