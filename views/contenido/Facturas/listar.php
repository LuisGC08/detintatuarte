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
<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-dark table-sm display" id="tabla">
            <thead>
                <tr class="text-center roboto-medium">
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Nick Cliente</th>
                    <th>Ver Factura</th>
                    <th>Modificar</th>
                    <th>Borrar</th>
                    <th>Desfacturar</th>
                    <th>Imprimir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($facturas as $indice => $factura) {
                ?>
                    <tr class="text-center">
                        <td id="cod_alb"><?= $factura->getCod_factura()  ?></td>
                        <td><?= $factura->getFecha()  ?></td>
                        <td><?= $clientes_facturas[$indice]->getNick()  ?> </td>
                        <td>
                            <form action="index.php?controller=facturas&action=ver" method='POST'>
                                <input type="hidden" name="id" value="<?= $factura->getCod_factura() ?>">
                                <button type="submit" class="btn btn-success pedido" id="pedido">
                                    <i class="fas fa-plus-square "></i>
                                </button>
                            </form>
                        </td>

                        <td>

                            <form action="index.php?controller=facturas&action=editar" method='POST'>
                                <input type="hidden" name="id" value="<?= $factura->getCod_factura() ?>">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>

                        </td>
                        <td>

                            <form action="index.php?controller=facturas&action=eliminar" method='POST'>
                                <input type="hidden" name="id" value="<?= $factura->getCod_factura() ?>">
                                <button type="submit" class="btn btn-warning">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>

                        </td>
                        <td>

                            <form action="index.php?controller=lineas_facturas&action=eliminar" method='POST'>
                                <input type="hidden" name="id" value="<?= $factura->getCod_factura() ?>">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-eraser"></i>
                                </button>
                            </form>

                        </td>
                        <td>

                            <form action="index.php?controller=facturas&action=imprimir" method='POST' target="_blank">
                                <input type="hidden" name="id" value="<?= $factura->getCod_factura() ?>">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-file-pdf"></i>
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