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
<!-- Content here-->
<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-dark table-sm display" id="tabla">
            <thead>
                <tr class="text-center roboto-medium">
                    <th>#</th>
                    <th>Nick</th>
                    <th>CIF-DNI</th>
                    <th>Razón Social</th>
                    <th>Domicilio Social</th>
                    <th>Ciudad</th>
                    <th>Email</th>
                    <th>TELEFONO</th>
                    <th>Dar de Baja/Alta</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $indice => $cliente) {
                ?>
                    <tr class="text-center">
                        <td><?= $cliente->getCod_cliente()  ?></td>
                        <td><?= $cliente->getNick()  ?></td>
                        <td><?= $cliente->getCIF_DNI()  ?></td>
                        <td><?= $cliente->getRazon_social()  ?></td>
                        <td><?= $cliente->getDomicilio_social()  ?></td>
                        <td><?= $cliente->getCiudad()  ?></td>
                        <td><?= $cliente->getEmail() ?></td>
                        <td><?= $cliente->getTelefono()  ?></td>
                        <td>
                            <?php if ($cliente->getBaja() == false) {
                            ?>
                                <form action="index.php?controller=clientes&action=eliminar" method='POST'>
                                    <input type="hidden" name="id" value="<?= $cliente->getCod_cliente() ?>">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-minus-square"></i>
                                    </button>
                                </form>
                            <?php
                            } else {
                            ?>
                                <form action="index.php?controller=clientes&action=eliminar" method='POST'>
                                    <input type="hidden" name="id" value="<?= $cliente->getCod_cliente() ?>">
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