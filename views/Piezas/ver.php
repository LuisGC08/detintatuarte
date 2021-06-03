<html>
   <head>
      <title>PROYECTO PROVEEDORES </title>
   </head>
   <body>
      <h1>Ver datos de una pieza</h1>
      <table border="1">
         <tr>
      <th>NUMERO PIEZA</th>
      <th>NOMBRE PIEZA</th>
      <th>PRECIO</th>
         </tr>
         <tr>
      <td><?php echo $pieza->getNUMPIEZA()?></td>
      <td><?php echo $pieza->getNOMPIEZA()?></td>
      <td><?php echo number_format($pieza->getPRECIOVENT(),2,',','.') . "€"?></td>
         </tr>
      </table>
   </body>
</html>
