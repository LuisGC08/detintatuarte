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
<legend><i class="fas fa-box-open fa-fw"></i> &nbsp; Código Pedido: <?= $pedido->getCod_pedido() ?></legend>
<br>
<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-dark table-sm display" id="tabla">
            <thead>
                <tr class="text-center roboto-medium">
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Cantidad en Albaran</th>
                    <th>Total</th>
                    <th>Modificar</th>
                    <th>Borrar</th>
                </tr>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($lineas_pedido as $key => $lin_ped) {
                ?>
                    <tr>
                        <td><img src='views/img/<?= $articulos_pedido[$key]->getImagen() ?>' class='img-fluid' width='50px'> </td>
                        <td><?= $articulos_pedido[$key]->getNombre() ?></td>
                        <td><?= $lin_ped->getPrecio() ?>€</td>
                        <td><?= $lin_ped->getCantidad() ?></td>
                        <td><?= $lin_ped->getCantidadEnAlbaran() ?></td>
                        <td><?= $lin_ped->getPrecio() * $lin_ped->getCantidad() ?>€</td>
                        <td>
                                <form action="index.php?controller=lineas_pedidos&action=editar" method='POST'>
                                    <input type="hidden" name="id" value="<?= $pedido->getCod_pedido() ?>">
                                    <input type="hidden" name="num" value="<?= $lin_ped->getNum_linea_pedido() ?>">
                                    <button type="submit" class="btn btn-success" <?= ($lin_ped->getEsEditable() == true) ? "" : 'disabled data-toggle="tooltip" data-placement="bottom" title="La línea está en Albaran"' ?>>
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>
                            
                        </td>
                        <td>
                                <form action="index.php?controller=lineas_pedidos&action=eliminar" method='POST'>
                                    <input type="hidden" name="cod_pedido" value="<?= $pedido->getCod_pedido() ?>">
                                    <input type="hidden" name="num" value="<?= $lin_ped->getNum_linea_pedido() ?>">
                                    <button type="submit" class="btn btn-warning" <?= ($lin_ped->getEsBorrable() == true) ? "" : 'disabled data-toggle="tooltip" data-placement="bottom" title="La línea está en Albaran"' ?>>
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