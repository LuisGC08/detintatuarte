<!--CONTENT-->
<div class="container-fluid">
    <fieldset>
        <legend><i class="fas fa-user-tie fa-fw"></i> &nbsp; Elige un cliente para realizar el pedido</legend>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <form action="index.php?controller=articulos&action=alta" method="post">
                        <div class="form-group">
                            <label for="ProductCategory" class="bmd-label-floating">Cliente</label>
                            <select class="form-control" id="ProductCategory" name="cod_cliente">
                                <?php
                                foreach ($clientes as $key => $cliente) {
                                ?>
                                    <option value="<?=$cliente->getCod_cliente()?>"><?=$cliente->getCod_cliente()?> &nbsp;- &nbsp;<?=$cliente->getNick()?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </fieldset>
</div>