<?php
include_once "views/contenido/Pedidos/listar.php";
?>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="ver-pedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-dark">Imagen</th>
                            <th class="text-dark">Nombre</th>
                            <th class="text-dark">Precio</th>
                            <th class="text-dark">Cantidad</th>
                            <th class="text-dark">Cantidad en Albaran</th>
                            <th class="text-dark">Total</th>
                            <th class="text-dark">Modificar</th>
                            <th class="text-dark">Borrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($lineas_pedido[$pedido->getCod_pedido()] as $key => $lin_ped) {
                        ?>
                            <tr>
                                <td><img src='views/img/' class='img-fluid<?= $articulos_pedido[$pedido->getCod_pedido()][$key]->getImagen() ?>' width='50px'> </td>
                                <td><?= $articulos_pedido[$pedido->getCod_pedido()][$key]->getNombre() ?></td>
                                <td><?= $lin_ped->getPrecio() ?>€</td>
                                <td><?= $lin_ped->getCantidad() ?></td>
                                <td><?= $lin_ped->getCantidadEnAlbaran() ?></td>
                                <td><?= $lin_ped->getPrecio() * $lin_ped->getCantidad() ?>€</td>
                                <td><?php if ($lin_ped->getEsEditable()) {
                                    ?>
                                        <form action="index.php?controller=pedidos&action=eliminar" method='POST'>
                                            <input type="hidden" name="cod_pedido" value="<?= $pedido->getCod_pedido() ?>">
                                            <input type="hidden" name="num_lin" value="<?= $lin_ped->getNum_linea_pedido() ?>">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td><?php if ($lin_ped->getEsBorrable()) {
                                    ?>
                                        <form action="index.php?controller=pedidos&action=eliminar" method='POST'>
                                            <input type="hidden" name="cod_pedido" value="<?= $pedido->getCod_pedido() ?>">
                                            <input type="hidden" name="num_lin" value="<?= $lin_ped->getNum_linea_pedido() ?>">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="total mx-auto">
                    <p>Total: 0.00</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-raised btn-danger" id="vaciar-carrito">Vaciar compra</button>
                &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-raised btn-info" id="procesar-pedido">Procesar pedido</button>
            </div>
        </div>
    </div>
</div>