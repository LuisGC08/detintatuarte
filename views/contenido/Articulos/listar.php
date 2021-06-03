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
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>% IVA</th>
                    <th>Modificar</th>
                    <th>Dar de Baja/Alta</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articulos as $indice => $articulo) {
                ?>
                    <tr class="text-center">
                        <td><?= $articulo->getCod_articulo()  ?></td>
                        <td><?= $articulo->getNombre()  ?></td>
                        <td><?= $articulo->getDescripcion()  ?></td>
                        <td><?= $articulo->getPrecio()  ?> €</td>
                        <td><?= $articulo->getIVA()  ?>%</td>

                        <td>
                            <form action="index.php?controller=articulos&action=editar" method='POST'>
                                <input type="hidden" name="id" value="<?= $articulo->getCod_articulo() ?>">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <?php if ($articulo->getBaja() == false) {
                            ?>
                                <form action="index.php?controller=articulos&action=eliminar" method='POST'>
                                    <input type="hidden" name="id" value="<?= $articulo->getCod_articulo() ?>">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-minus-square"></i>
                                    </button>
                                </form>
                            <?php
                            } else {
                            ?>
                                <form action="index.php?controller=articulos&action=eliminar" method='POST'>
                                    <input type="hidden" name="id" value="<?= $articulo->getCod_articulo() ?>">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-plus-square"></i>
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
    </div>
</div>