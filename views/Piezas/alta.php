    <?php
    foreach ($errores as $indice =>$error): 
    	echo $error;
    endforeach;
    ?>
<FORM ACTION='index.php?controller=piezas&action=alta' METHOD='POST'>
NUMERO PIEZA <input type="text" name='NUMPIEZA' value="<?=$pieza->getNUMPIEZA()?>"><BR>
NOMBRE <input type="text" name='NOMPIEZA' value="<?=$pieza->getNOMPIEZA()?>"><BR>
PRECIO <input type="text" name='PRECIOVENT' value="<?=$pieza->getPRECIOVENT()?>"><BR>
<INPUT TYPE="SUBMIT" name="ALTA" VALUE="ALTA">
</form>