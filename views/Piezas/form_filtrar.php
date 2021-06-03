<form action="index.php?controller=piezas&action=filtrar" method="POST">
  <select name="campo">
      <option value="NUMPIEZA" <?= ($campo=="NUMPIEZA")?"SELECTED":""?> > ID PIEZA</option>
      <option value="NOMPIEZA" <?= ($campo=="NOMPIEZA")?"SELECTED":""?>> NOMBRE</option>
      <option value="PRECIOVENT" <?= ($campo=="PRECIOVENT")?"SELECTED":""?>> PRECIO</option>
  </select>
  <select name="filtro">
      <option value="empieza"<?= ($filtro=="empieza")?"SELECTED":""?> >Empieza Por</option>
      <option value="contiene" <?= ($filtro=="contiene")?"SELECTED":""?> >Contiene a</option>
      <option value="acaba" <?= ($filtro=="acaba")?"SELECTED":""?> >Acaba en</option>
      <option value="igual" <?= ($filtro=="igual")?"SELECTED":""?> >Es Igual a</option>
  </select>
  Texto a Buscar<INPUT TYPE='TEXT' NAME='texto' VALUE='<?=$texto?>'/>
  <INPUT TYPE='submit' VALUE="BUSCAR"/>
</form>
