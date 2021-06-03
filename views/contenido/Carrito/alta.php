<!--CONTENT-->
<div class="container-fluid">
    <form action="index.php?controller=carrito&action=alta" class="form-neon" autocomplete="off" method="POST">
        <fieldset>
            <legend><i class="fas fa-user-tie fa-fw"></i> &nbsp; Elige un cliente para realizar el pedido</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="ProductCategory" class="bmd-label-floating">Cliente</label>
                            <select class="form-control" id="ProductCategory" name="cod_cliente">
                                <?php
                                foreach ($clientes as $key => $cliente) {
                                ?>
                                    <option value="<?= $cliente->getCod_cliente() ?>"><?= $cliente->getCod_cliente() ?> &nbsp;- &nbsp;<?= $cliente->getNick() ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <p class="text-center" style="margin-top: 40px;">
            <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sign-in-alt"></i> &nbsp; EMPEZAR PEDIDO</button>
        </p>
    </form>
</div>