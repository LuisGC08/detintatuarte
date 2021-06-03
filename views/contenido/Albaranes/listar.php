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
                    <th>Ver Albarán</th>
                    <th>Modificar</th>
                    <th>Borrar</th>

                </tr>
            </thead>

            <tbody>


                <?php foreach ($albaranes as $indice => $albaran) {
                ?>


                    <tr class="text-center">
                        <td id="cod_ped"><?= $albaran->getCod_albaran()  ?></td>
                        <td><?= $albaran->getFecha()  ?></td>
                        <td><?= $clientes_pedidos[$indice]->getNick()  ?> </td>
                        <td>
                            <form action="index.php?controller=albaranes&action=ver" method='POST'>
                            <input type="hidden" name="id" value="<?= $albaran->getCod_albaran() ?>">
                                <button type="submit" class="btn btn-success pedido" id="pedido" data-toggle="modal" data-target="#ver-pedido">
                                    <i class="fas fa-plus-square "></i>
                                </button>
                            </form>
                        </td>

                        <td>
                        
                    <form action="index.php?controller=albaranes&action=editar" method='POST'>
                           <input type="hidden" name="id" value="<?= $albaran->getCod_albaran() ?>">
                            <button type="submit" class="btn btn-success" <?= ($albaran->getEsEditable() == true) ? "" : 'disabled data-toggle="tooltip" data-placement="bottom" title="La línea está en Albaran"' ?>>
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            </form>
                            
                        </td>
                        <td>
                            
                                <form action="index.php?controller=albaranes&action=eliminar" method='POST'>
                                    <input type="hidden" name="id" value="<?= $albaran->getCod_albaran() ?>">
                                    <button type="submit" class="btn btn-warning" <?= ($albaran->getEsBorrable() == true) ? "" : 'disabled data-toggle="tooltip" data-placement="bottom" title="La línea está en Albaran"' ?>>
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
