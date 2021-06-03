<!--CONTENT-->
<div class="container-fluid">
    <form action="index.php?controller=articulos&action=alta" class="form-neon" autocomplete="off" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>
                <img src="views/img/<?= (is_null($articulo->getImagen())) ? "default.png" : $articulo->getImagen() ?>" alt="icon" width="50" height="50"> &nbsp; Información del articulo
            </legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="nombre" class="bmd-label-floating">Nombre</label>
                            <input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="nombre" id="nombre" maxlength="140" value="<?= (isset($articulo)) ? $articulo->getNombre() : "" ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="descripcion" class="bmd-label-floating">Descripción</label>
                            <input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9()- ]{1,190}" class="form-control" name="descripcion" id="descripcion" maxlength="200" value="<?= (isset($articulo)) ? $articulo->getDescripcion() : "" ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="precio" class="bmd-label-floating">Precio</label>
                            <input type="num" pattern="[0-9]+(\.[0-9][0-9]?)?" class="form-control" name="precio" id="precio" maxlength="50" value="<?= (isset($articulo)) ? $articulo->getPrecio() : "" ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="IVA" class="bmd-label-floating">% IVA</label>
                            <input type="num" pattern="[0-9]+(\.[0-9][0-9]?)?" class="form-control" name="IVA" id="IVA" maxlength="9" value="<?= (isset($articulo)) ? $articulo->getIVA() : "" ?>">
                        </div>
                    </div>
                    <!-- <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="imagen" class="bmd-label-floating"><i class="fas fa-upload"></i></label>
                            <input type="file" name="imagen" class="form-control">
                        </div> -->
                    <!-- </div> -->
                </div>
            </div>
        </fieldset>
        <br><br><br>
        <fieldset>
            <legend><i class="far fa-image"></i> &nbsp; Imagen</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="imagen" class="bmd-label-floating">Imagen del articulo</label>
                            <input type="file" class="form-control-file" id="ProductImg" name="imagen">
                            <small class="text-muted">Tamaño máximo de los archivos adjuntos 2MB. Tipos de archivos permitidos imágenes: PNG, JPEG, JPG y GIF.</small>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <p class="text-center" style="margin-top: 40px;">
            <?php
            if (isset($errores) && !empty($errores)) {
            ?>
        <div class="alert alert-danger" role="alert" id="mensaje">
            <p class="text-center">
                <?php
                foreach ($errores as $key => $error) {
                    echo $error . "<br>";
                }
                ?>
            </p>
        </div>
    <?php
            }
            if (isset($success) && $success != "") {
    ?>
        <div class="alert alert-success" role="alert" id="mensaje">
            <p class="text-center"><?= $success ?></p>
        </div>
    <?php
            }
    ?>
    <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
    &nbsp; &nbsp;
    <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
        </p>
    </form>
</div>