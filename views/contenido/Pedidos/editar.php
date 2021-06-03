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
<form action="index.php?controller=pedidos&action=editar" class="form-neon" method='POST'>

    <legend><i class="fas fa-user"></i> &nbsp; Cliente: <?= $cliente->getNick() ?></legend>
    <legend><i class="fas fa-box-open fa-fw"></i> &nbsp; Código Pedido: <?= $pedido->getCod_pedido() ?></legend>
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
                            <th>Cantidad en Albaran</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <input type="hidden" name="cod_pedido" value="<?= $pedido->getCod_pedido() ?>">
                        <?php
                        foreach ($lineas_pedido as $key => $lin_ped) {
                        ?>
                            <tr class="text-center">

                                <td><img src='views/img/<?= $articulos_pedido[$key]->getImagen() ?>' class='img-fluid' width='50px'> </td>

                                <td>
                                    <?php
                                    if ($lin_ped->getEsEditable() === true) {
                                    ?>
                                        <select class="form-control" id="ProductCategory" name="cod_articulo<?=$key?>">
                                            <?php
                                            foreach ($articulos as $indice => $articulo) {
                                            ?>
                                                <option value="<?= $articulo->getCod_articulo() ?>" <?= ($lin_ped->getCod_articulo() === $articulo->getCod_articulo()) ? "SELECTED" : "" ?>><?= $articulo->getCod_articulo()  ?> &nbsp;- &nbsp;<?= $articulo->getNombre()  ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    <?php
                                    } else {
                                    ?>
                                        <input type="text" class="form-control" id="cod_articulo" value="<?= $articulos_pedido[$key]->getNombre() ?>" readonly data-toggle="tooltip" data-placement="bottom" title="La línea está en Albaran">
                                        <input type="hidden" class="form-control" name ="cod_articulo<?=$key?>" id="cod_articulo" value="<?= $articulos_pedido[$key]->getCod_articulo() ?>">
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <input type="num" pattern="[0-9]+(\.[0-9][0-9]?)?" class="form-control" name="precio<?=$key?>" id="precio" maxlength="50" value="<?= $lin_ped->getPrecio() ?>" <?= ($lin_ped->getEsEditable() === true) ? "" : 'readonly data-toggle="tooltip" data-placement="bottom" title="La línea está en Albaran"'?>>
                                    
                                </td>
                                <td>
                                    <input type="number" pattern="[0-9]+(\.[0-9][0-9]?)?" class="form-control" name="cantidad<?=$key?>" id="cantidad" maxlength="50" value="<?= $lin_ped->getCantidad() ?>" <?= ($lin_ped->getEsEditable() == true) ? "" : 'disabled data-toggle="tooltip" data-placement="bottom" title="La línea está en Albaran"' ?> min="<?= $lin_ped->getCantidadEnAlbaran() ?>">
                                </td>
                                <td><?= $lin_ped->getCantidadEnAlbaran() ?></td>
                                <td><?= $lin_ped->getPrecio() * $lin_ped->getCantidad() ?>€</td>
                                <input type="hidden" name="num<?=$key?>" value="<?= $lin_ped->getNum_linea_pedido() ?>">
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
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