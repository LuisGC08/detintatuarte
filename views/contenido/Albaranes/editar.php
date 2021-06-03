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
<form action="index.php?controller=albaranes&action=editar" method='POST' class="form-neon" autocomplete="off">

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
                        </tr>

                    </thead>
                    <tbody>

                        <input type="hidden" name="cod_albaran" value="<?= $albaran->getCod_albaran() ?>">

                        <?php
                        foreach ($lineas_albaran as $key => $lin_alb) {
                        ?>
                            <tr class="text-center">

                                <td><img src='views/img/<?= $articulos_albaran[$key]->getImagen() ?>' class='img-fluid' width='50px'> </td>
                                <td><?= $articulos_albaran[$key]->getNombre() ?></td>

                                <td>
                                    <input type="num" pattern="[0-9]+(\.[0-9][0-9]?)?" class="form-control" name="precio<?=$key?>" id="precio" maxlength="50" value="<?= $lin_alb->getPrecio() ?>" min="0" <?= ($lin_alb->getEsEditable() == true) ? "" : 'disabled data-toggle="tooltip" data-placement="bottom" title="La línea está en Factura"' ?>>
                                </td>

                                <td><?= $lin_alb->getCantidad() ?></td>
                                <td>
                                    <input type="num" pattern="[0-9]+(\.[0-9][0-9]?)?" class="form-control" name="desc<?= $key ?>" id="desc" maxlength="50" value="<?= $lin_alb->getDescuento() ?>" min="0" <?= ($lin_alb->getEsEditable() == true) ? "" : 'disabled data-toggle="tooltip" data-placement="bottom" title="La línea está en Factura"' ?>>
                                </td>

                                <td>
                                    <input type="num" pattern="[0-9]+(\.[0-9][0-9]?)?" class="form-control" name="IVA<?= $key ?>" id="IVA<?= $key ?>" maxlength="50" value="<?= $lin_alb->getIVA() ?>" min="0" <?= ($lin_alb->getEsEditable() == true) ? "" : 'disabled data-toggle="tooltip" data-placement="bottom" title="La línea está en Factura"' ?>>
                                </td>
                                <input type="hidden" name="num<?= $key ?>" value="<?= $lin_alb->getNum_linea_albaran() ?>">
                           
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