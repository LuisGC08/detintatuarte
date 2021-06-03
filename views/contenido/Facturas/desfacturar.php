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
<form action="index.php?controller=lineas_facturas&action=eliminar" method='POST' autocomplete="off" class="form-neon">
    <fieldset>
        <legend><i class="fas fa-user-tie fa-fw"></i> &nbsp; Cliente: <?= $cliente->getCod_cliente() ?></legend>
        <legend><i class="fas fa-user-tie fa-fw"></i> &nbsp; Factura: <?= $factura->getCod_factura() ?></legend>
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-dark table-sm display" id="tabla">
                    <thead>
                        <tr class="text-center roboto-medium">
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Nick Cliente</th>
                            <th>Desfacturar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($albaranes as $indice => $albaran) {
                        ?>
                            <tr class="text-center">
                                <td id="cod_alb"><?= $albaran->getCod_albaran()  ?></td>
                                <td><?= $albaran->getFecha()  ?></td>
                                <td><?= $cliente->getNick()  ?> </td>
                                <td>
                                    <form action="index.php?controller=lineas_facturas&action=eliminar" method='POST'>
                                        <input type="hidden" name="cod_albaran" value="<?= $albaran->getCod_albaran() ?>">
                                        <button type="submit" class="btn btn-warning">
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
</form>