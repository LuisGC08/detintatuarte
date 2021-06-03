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
<form action="index.php?controller=lineas_albaran&action=alta" method='POST' autocomplete="off" class="form-neon">
<legend><i class="fas fa-user"></i> &nbsp; Cliente: <?=$cliente->getNick()?></legend>
<legend><i class="fas fa-box-open fa-fw"></i> &nbsp; Código Pedido: <?= $pedido->getCod_pedido() ?></legend>
<br>

    <fieldset>
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-dark table-sm" id="tabla">
                    <thead>
                        <tr class="text-center roboto-medium display">
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>En Albaran</th>
                            <th>Cantidad a pasar</th>
                            <th>Pasar a Albaran</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($lineas_pedido as $key => $lin_ped) {
                        ?>
                            <tr class="text-center">
                                <td><img src='views/img/<?= $articulos_pedido[$key]->getImagen() ?>' class='img-fluid' width='50px'> </td>
                                <td><?= $articulos_pedido[$key]->getNombre() ?></td>
                                <td><?= $lin_ped->getPrecio() ?>€</td>
                                <td><?= $lin_ped->getCantidad() ?></td>
                                <td><?= $lin_ped->getCantidadEnAlbaran() ?></td>
                                <td>
                                    <input type="number" pattern="[0-9]+(\.[0-9][0-9]?)?" class="form-control" name="cantidad<?=$key?>" id="cantidad" maxlength="50" value="<?= $lin_ped->getCantidad() - $lin_ped->getCantidadEnAlbaran() ?>" max="<?= $lin_ped->getCantidad() - $lin_ped->getCantidadEnAlbaran() ?>" min="0">
                                </td>
                                <td>
                                    <input type="hidden" name="id" value="<?= $pedido->getCod_pedido() ?>">
                                    <div class="form-check">
                                        <input class="" type="checkbox" name="check[]" value="<?= $lin_ped->getNum_linea_pedido() ?>" id="flexCheckDefault" <?=(( $lin_ped->getCantidad() - $lin_ped->getCantidadEnAlbaran()) == 0)?'checked disabled data-toggle="tooltip" data-placement="bottom" title="La línea está en Albaran"':""?>>
                                    </div>
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
    <br><br><br>
    <p class="text-center" style="margin-top: 40px;">
        <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
        &nbsp; &nbsp;
        <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
    </p>
</form>