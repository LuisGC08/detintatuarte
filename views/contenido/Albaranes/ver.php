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

<legend><i class="fas fa-user"></i> &nbsp; Cliente: <?= $cliente->getNick() ?></legend>
<legend><i class="fas fa-box-open fa-fw"></i> &nbsp; Código Albarán: <?= $albaran->getCod_albaran() ?></legend>
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
                        <th>Descuento</th>
                        <th>IVA</th>
                        <th>Modificar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($lineas_albaran as $key => $lin_alb) {
                    ?>
                        <tr class="text-center">
                            <td><img src='views/img/<?= $articulos_albaran[$key]->getImagen() ?>' class='img-fluid' width='50px'> </td>
                            <td><?= $articulos_albaran[$key]->getNombre() ?></td>
                            <td><?= $lin_alb->getPrecio() ?>€</td>
                            <td><?= $lin_alb->getCantidad() ?></td>
                            <td>
                                <?= $lin_alb->getDescuento() ?>
                            </td>
                            <td>
                                <?= $lin_alb->getIVA() ?>
                            </td>
                            <td>
                                <form action="index.php?controller=lineas_albaran&action=editar" method='POST'>
                                    <input type="hidden" name="id" value="<?= $albaran->getCod_albaran() ?>">
                                    <input type="hidden" name="num" value="<?= $lin_alb->getNum_linea_albaran() ?>">
                                    <button type="submit" class="btn btn-success" <?= ($lin_alb->getEsEditable()) ? "" : 'disabled data-toggle="tooltip" data-placement="bottom" title="La línea está en Factura"' ?>>
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>

                            </td>
                            <td>

                                <form action="index.php?controller=lineas_albaran&action=eliminar" method='POST'>
                                    <input type="hidden" name="id" value="<?= $albaran->getCod_albaran() ?>">
                                    <input type="hidden" name="num" value="<?= $lin_alb->getNum_linea_albaran() ?>">
                                    <button type="submit" class="btn btn-warning" <?= ($lin_alb->getEsBorrable() == true) ? "" : 'disabled data-toggle="tooltip" data-placement="bottom" title="La línea está en Factura"' ?>>
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</fieldset>