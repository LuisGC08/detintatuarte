<h1>Piezas dados de alta en nuestro sistema</h1>
  <table class="table  table-striped  table-hover" id="tabla">
    <thead>
        <tr>
        <th style="width:120px; background-color: #5DACCD; color:#fff">NUMERO PIEZA</th>
            <th style="width:320px; background-color: #5DACCD; color:#fff">NOMBRE PIEZA</th>
            <th style=" background-color: #5DACCD; color:#fff">NOMBRE PRECIVENT</th>
            <th style=" background-color: #5DACCD; color:#fff"></th>
            <th style=" background-color: #5DACCD; color:#fff"></th>
         </tr>
    </thead>
    <tbody>
    <?php
    foreach ($piezas as $indice =>$pieza): 
    ?>
    <tr>
      <td><?= $pieza->getNUMPIEZA()?></td>
      <td><?= $pieza->getNOMPIEZA()?></td>
      <td><?= number_format($pieza->getPRECIOVENT(),2,',','.') . "€"?></td>
      <td> 
        <?php if ($pieza->getesEditable()){ ?>
          <a  class="btn btn-warning" href="index.php?controller=piezas&action=editar&id=<?php echo $pieza->getNUMPIEZA(); ?>">Editar</a>

        <?php
        }
        ?>
      </td>
      <td>
        <?php if ($pieza->getesBorrable()) {?>
        <a  class="btn btn-danger" onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="index.php?controller=piezas&action=eliminar&id=<?= $pieza->getNUMPIEZA(); ?>">Eliminar</a>
        <?php } ?>
      </td>
     </tr>  
     <?php endforeach;?>
    </table>