<!-- Content here-->
<?php
if (isset($success) && $success != "") {
?>
    <div class="alert alert-success" role="alert" id="mensaje">
        <p class="text-center"><?= $success ?></p>
    </div>
<?php
}
if (isset($error) && $error != "") { ?>
    <div class="alert alert-danger" role="alert" id="mensaje">
        <p class="text-center"><?= $error ?></p>
    </div>
<?php
}
?>
<form action="index.php?controller=facturas&action=editar" method='POST' class="form-neon" autocomplete="off">
    <legend><i class="fas fa-user"></i> &nbsp; Cliente: <?= $cliente->getNick() ?></legend>
    <legend><i class="fas fa-box-open fa-fw"></i> &nbsp; Código Factura: <?= $factura->getCod_factura() ?></legend>
    <br>

    <fieldset>
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-dark table-sm display" id="tabla">
                    <thead>
                        <tr class="text-center roboto-medium">
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>IVA</th>
                            <th>Descuento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" name="cod_factura" value="<?= $factura->getCod_factura() ?>">
                        <?php
                        foreach ($lineas_facturas as $key => $lin_fac) {
                        ?>
                            <tr class="text-center">
                                <td><img src='views/img/<?= $articulos_albaran[$key]->getImagen() ?>' class='img-fluid' width='50px'> </td>
                                <td><?= $articulos_albaran[$key]->getNombre() ?></td>
                                <td><?= $lin_fac->getPrecio() ?>€</td>
                                <td><?= $lin_fac->getCantidad() ?></td>
                                <td>
                                    <?= $lin_fac->getIVA() ?> %
                                </td>
                                <td>
                                    <?= $lin_fac->getDescuento() ?> €
                                </td>
                            <tr>
                            <?php
                        }
                            ?>
                    </tbody>
                </table>
            </div>
            <div class="float-right">
                <label for="Descuento" class="bmd-label-floating">Descuento</label>
                <input type="num" pattern="[0-9]+(\.[0-9][0-9]?)?" class="form-control" name="descuento" id="descuento" min="0" size="10" value="<?=$factura->getDescuento_factura()?>">
            </div>
        </div>
    </fieldset>
    <br><br><br>
    <p class="text-center" style="margin-top: 40px;">
        <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
        &nbsp; &nbsp;
        <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
    </p>
</form>