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
<form action="index.php?controller=facturas&action=alta" method='POST' autocomplete="off" class="form-neon">
    <fieldset>
        <legend><i class="fas fa-user-tie fa-fw"></i> &nbsp; Cliente: <?= $cliente->getCod_Cliente() ?></legend>
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-dark table-sm display" id="tabla">
                    <thead>
                        <tr class="text-center roboto-medium">
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Nick Cliente</th>
                            <th>Generar Factura</th>
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
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="check[]" value="<?= $albaran->getCod_albaran() ?>" id="flexCheckDefault">
                                        <input type="hidden" name="cod_cliente" value="<?=$cliente->getCod_cliente()?>">
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="float-right">
                <label for="Descuento" class="bmd-label-floating">Descuento</label>
                <input type="num" pattern="[0-9]+(\.[0-9][0-9]?)?" class="form-control" name="descuento" id="descuento" min="0" size="10">
            </div>
        </div>
    </fieldset> <br><br><br>
    <p class="text-center" style="margin-top: 40px;">
        <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
        &nbsp; &nbsp;
        <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
    </p>
</form>