<!-- Content here-->
<div class="container-fluid">
    <form class="form-neon" action="index.php?controller=albaranes&action=filtrar" method="POST">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="inputSearch" class="bmd-label-floating">¿Qué factura estas buscando?</label>
                        <input type="text" class="form-control" name="texto" id="inputSearch" maxlength="30">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="campo" class="bmd-label-floating">Campo</label>
                        <select class="form-control" name="campo" id="item_estado">
                            <option value="cod_albaran" <?= ($campo == "cod_albaran") ? "SELECTED" : "" ?>> Codigo factura</option>
                            <option value="fecha" <?= ($campo == "fecha") ? "SELECTED" : "" ?>> Fecha</option>
                            <option value="cod_cliente" <?= ($campo == "cod_cliente") ? "SELECTED" : "" ?>> Codigo cliente</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="filtro" class="bmd-label-floating">Filtro</label>
                        <select class="form-control" name="filtro" id="item_estado">
                            <option value="empieza" <?= ($filtro == "empieza") ? "SELECTED" : "" ?>>Empieza Por</option>
                            <option value="contiene" <?= ($filtro == "contiene") ? "SELECTED" : "" ?>>Contiene a</option>
                            <option value="acaba" <?= ($filtro == "acaba") ? "SELECTED" : "" ?>>Acaba en</option>
                            <option value="igual" <?= ($filtro == "igual") ? "SELECTED" : "" ?>>Es Igual a</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 40px;">
                        <button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>


<div class="container-fluid">
    <form action="index.php?controller=pedidos&action=filtrar" method="POST">
        <input type="hidden" name="eliminar-busqueda" value="eliminar">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <?php if($texto != "%"){
                ?>
                <div class="col-12 col-md-6">
                    <p class="text-center" style="font-size: 20px;">
                        Resultados de la busqueda <strong>“<?= $texto ?>”</strong>
                    </p>
                </div>
                <?php } ?>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 20px;">
                        <button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>