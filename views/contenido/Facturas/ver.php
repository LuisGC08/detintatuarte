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

<div class="form-neon">
    <fieldset>
        <legend><i class="fas fa-user"></i> &nbsp; Cliente: <?= $cliente->getNick() ?></legend>
        <legend><i class="fas fa-file-invoice-dollar fa-fw"></i> &nbsp; Código Factura: <?= $factura->getCod_factura() ?></legend>
        <br>
        <div class="container-fluid">
            <div class="row justify-content-between">
                <div class="col-4">

                    <h4> Cliente: <?= $cliente->getRazon_social() ?></h4>
                    
                    <p>CIF-DNI: <?= $cliente->getCif_dni() ?></p>
                    <p>Dirección: <?= $cliente->getDomicilio_social() ?></p>
                    <p>Ciudad: <?= $cliente->getCiudad() ?></p>
                    <p>Email: <?= $cliente->getEmail() ?></p>
                    <p>Teléfono: <?= $cliente->getTelefono() ?></p>

                </div>
                <div class="col-4">

                    <h4 class="text-right">Empresa: AxpeExpress</h4>

                    <p class="text-right">CIF-DNI: </p>
                    <p class="text-right">Dirección: C:/ La Ponia</p>
                    <p class="text-right">Ciudad: Aspe</p>
                    <p class="text-right">Email: axpeexpress@todomasbarato.com</p>
                    <p class="text-right">Teléfono: 654321987</p>

                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-sm display" id="tabla">
                    <thead>
                        <tr class="text-center roboto-medium">
                            <th>Imagen</th>
                            <th>Artículo</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>IVA</th>
                            <th>Descuento</th>
                            <th>Importe</th>
                            <th>Importe con IVA</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $subtotal = 0;
                        $tot_desc = 0;
                        foreach ($lineas_facturas as $key => $lin_fac) {
                            $subtotal += $lin_fac->getPrecio() * $lin_fac->getCantidad() * (($lin_fac->getIVA() / 100) + 1);
                            $tot_desc += $lin_fac->getDescuento() * $lin_fac->getCantidad();
                        ?>
                            <tr class="text-center">
                                <td><img src='views/img/<?= $articulos_albaran[$key]->getImagen() ?>' class='img-fluid' width='50px'> </td>
                                <td><?= $articulos_albaran[$key]->getNombre() ?></td>
                                <td><?= $lin_fac->getPrecio() ?>€</td>
                                <td><?= $lin_fac->getCantidad() ?></td>
                                <td>
                                    <?= $lin_fac->getIVA() ?> %
                                </td>
                                <td>
                                    <?= $lin_fac->getDescuento() ?> €
                                </td>

                                <td><?= $lin_fac->getPrecio() * $lin_fac->getCantidad() ?> €</td>
                                <td><?= $lin_fac->getPrecio() * $lin_fac->getCantidad() * (($lin_fac->getIVA() / 100) + 1) ?> €</td>
                            <tr>
                            <?php
                        }
                            ?>
                            <tr class="text-center">
                                <td colspan="5"></td>
                                <td class="roboto-medium" colspan="2">SUBTOTAL</td>
                                <td><?= $subtotal ?> €</td>
                            </tr>
                            <tr class="text-center">
                            <td colspan="5"></td>
                                <td class="roboto-medium" colspan="2">DESCUENTO ARTICULOS</td>
                                <td><?= $tot_desc ?>€</td>
                            </tr>
                            <?php
                            if ($factura->getDescuento_factura() != 0) {
                            ?>
                                <tr class="text-center">
                                    <td colspan="5"></td>
                                    <td class="roboto-medium" colspan="2">DESCUENTO FACTURA</td>
                                    <td><?= $factura->getDescuento_factura() ?>€</td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr class="text-center">
                            <td colspan="5"></td>
                                <td class="roboto-medium" colspan="2">TOTAL FACTURA</td>
                                <td><b><?= $subtotal - $tot_desc - $factura->getDescuento_factura() ?> €<b></td>
                            </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </fieldset>
    <br><br><br>
    <div class="text-center">
        <form action="index.php?controller=facturas&action=imprimir" method='POST' target="_blank">
            <input type="hidden" name="id" value="<?= $factura->getCod_factura() ?>">
            <button type="submit" class="btn btn-raised btn-info btn-sm">
                <i class="fas fa-file-pdf"> &nbsp;IMPRIMIR FACTURA</i>
            </button>
        </form>
    </div>

</div>