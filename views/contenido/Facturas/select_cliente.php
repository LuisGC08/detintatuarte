<!--CONTENT-->
<div class="container-fluid">
    <form action="index.php?controller=facturas&action=alta" class="form-neon" autocomplete="off" method="POST">
        <fieldset>
            <legend><i class="fas fa-user-tie fa-fw"></i> &nbsp; SELECCIONA UN CLIENTE PARA REALIZAR LA FACTURA</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="ProductCategory" class="bmd-label-floating">Cliente</label>
                            <select class="form-control" id="ProductCategory" name="cod_cliente">
                                <?php
                                foreach ($clientes as $key => $cli) {
                                ?>
                                    <option value="<?= $cli->getCod_cliente() ?>" <?= (isset($cliente) && $cliente->getCod_cliente() == $cli->getCod_cliente()) ? "SELECTED" : "" ?>><?= $cli->getCod_cliente() ?> &nbsp;- &nbsp;<?= $cli->getNick() ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <p class="text-center" style="margin-top: 40px;">
            <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sign-in-alt"></i> &nbsp; CREAR FACTURAS</button>
        </p>
    </form>
</div>
