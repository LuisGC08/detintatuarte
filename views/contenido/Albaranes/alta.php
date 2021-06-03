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
             <th>Ver Pedido</th>
               <th>Generar Albaran Completo</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($pedidos as $indice => $pedido) {
                ?>
                    <tr class="text-center">

                <td id="cod_ped"><?= $pedido->getCod_pedido()  ?></td>
                  <td><?= $pedido->getFecha()  ?></td>
                        <td><?= $clientes_pedidos[$indice]->getNick()  ?> </td>
                    <td>

                            <form action="index.php?controller=lineas_albaran&action=alta" method='POST'>

                                <input type="hidden" name="id" value="<?= $pedido->getCod_pedido() ?>">

                      <button type="submit" class="btn btn-success pedido" id="pedido">

                                    <i class="fas fa-plus-square "></i>
                                </button>
                            </form>
                        </td>

                        <td>

             <form action="index.php?controller=albaranes&action=alta" method='POST'>

                    <input type="hidden" name="id" value="<?= $pedido->getCod_pedido() ?>">

                 <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-file-medical"></i>
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