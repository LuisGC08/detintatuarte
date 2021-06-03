<?php

// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');
class MYPDF extends TCPDF
{

    //Page header
    public function Header()
    {
        // Logo
        $image_file = K_PATH_IMAGES . 'logo.png';
        $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }
}
// create new PDF document
//Todas las mayusculas son defines
//estos se encuentran definidos en
// RUTA tcpdf/config/tcpdf_config.php
// Si quieres cambiar algo ahí tienes todas las opcciones
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Datos del creador
// //que evidentemente no SOY YO
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Luis García');
$pdf->SetTitle('FACTURA');
$pdf->SetSubject('');
$pdf->SetKeywords('factura');

// Que llava Cabecera por defecto
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 006', PDF_HEADER_STRING);

// Poner la fuentes por defecto de pie y cabecera
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Fuente por defecto de tipo monospaced 
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Margenes por defecto
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Cuando por ejemplo una tabla no cabe, que pasa
// // en este caso creo una nueva página
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Como esclar las fotos
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// ---------------------------------------------------------
// Imprimir una tabla
$pdf->SetFont('dejavusans', '', 10);
// Nueva pagina
$pdf->AddPage();
$html = '<table>
    <tr>
        <th colspan="8" width="100%" align="left">
            <b>FACTURA Nº: ' . $factura->getCod_factura() . '</b>
        </th>
    </tr>
    <tr>
        <th colspan="4" width="50%" align="left">
            Cliente: ' . $cliente->getRazon_social() . '
        </th>
        <th colspan="4" align="right" width="50%" >
            <b>De Tinta tu Arte</b>
        </th>
    </tr>
    <tr>
         <td colspan="4" width="50%" align="left">CIF-DNI: ' . $cliente->getCif_dni() . '</td>
         <td colspan="4" align="right" width="50%">CIF-DNI: 12345678L </td>
    </tr>
    <tr>
         <td colspan="4" width="50%" align="left">' . $cliente->getDomicilio_social() . ', Ciudad' . $cliente->getCiudad() . '</td>
         <td colspan="4" align="right" width="50%" >Calle Sol, Aspe</td>
    </tr>
    <tr>
         <td colspan="4" width="50%" align="left">Email: ' . $cliente->getEmail() . '</td>
         <td colspan="4" align="right" width="50%" >Email: deTintaTuArte@tattoo.es</td>
    </tr>
    <tr>
         <td colspan="4" width="50%" align="left">Teléfono: ' . $cliente->getTelefono() . '</td>
         <td colspan="4" align="right" width="50%" >Teléfono de contacto: 123456789</td>
    </tr>
    <tr>
         <td height="78">&nbsp; </td>
    </tr>
    <tr border="1">
        <th	style="color:white;" bgcolor="#8D8299" align="center" colspan="2">ARTÍCULO</th>
        <th	style="color:white;" bgcolor="#8D8299" align="center">PRECIO UNITARIO</th>
        <th	style="color:white;" bgcolor="#8D8299" align="center">CANTIDAD</th>
        <th	style="color:white;" bgcolor="#8D8299" align="center">IVA</th>
        <th	style="color:white;" bgcolor="#8D8299" align="center">DESCUENTO</th>
        <th	style="color:white;" bgcolor="#8D8299" align="center">IMPORTE</th>
        <th	style="color:white;" bgcolor="#8D8299" align="center">IMPORTE CON IVA</th>
    </tr>';

$subtotal = 0;
$tot_desc = 0;
foreach ($lineas_facturas as $key => $lin_fac) {
    $subtotal += $lin_fac->getPrecio() * $lin_fac->getCantidad() * (($lin_fac->getIVA() / 100) + 1);
    $tot_desc += $lin_fac->getDescuento() * $lin_fac->getCantidad();
    $html .= '
        <tr border="1">
             <td bgcolor="#824DBC"  align="center" colspan="2">' . $articulos_factura[$key]->getNombre() . '</td>
             <td bgcolor="#824DBC"  align="center">' . $lin_fac->getPrecio() . '€</td>
             <td bgcolor="#824DBC"  align="center">' . $lin_fac->getCantidad() . '</td>
             <td bgcolor="#824DBC"  align="center">
                ' . $lin_fac->getIVA() . ' %
            </td>
             <td bgcolor="#824DBC"  align="center">
                ' . $lin_fac->getDescuento() . ' €
            </td>

             <td bgcolor="#824DBC"  align="center">' . $lin_fac->getPrecio() * $lin_fac->getCantidad() . ' €</td>
             <td bgcolor="#824DBC"  align="center">' . $lin_fac->getPrecio() * $lin_fac->getCantidad() * (($lin_fac->getIVA() / 100) + 1) . ' €</td>
        </tr>
        <tr>
             <td height="20">&nbsp; </td>
        </tr>';
}
$html .= '  <tr>
                 <td colspan="5"></td>
				 <td bgcolor="#824DBC"  colspan="2" align="center" style="color:white;">SUBTOTAL</td>
				 <td bgcolor="#824DBC"  align="center">
					' . $subtotal . '
				</td>
		    </tr>
			<tr>
             <td colspan="5"></td>
				 <td bgcolor="#824DBC"  colspan="2" align="center">DESCUENTO ARTICULOS</td>
				 <td bgcolor="#824DBC"  align="center">' . $tot_desc . '</td>
			</tr>';
$total = $subtotal - $tot_desc - $factura->getDescuento_factura();
if ($factura->getDescuento_factura() != 0) {
    $html .= '<tr>
                 <td colspan="5"></td>
                 <td bgcolor="#824DBC"  colspan="2" align="center">DESCUENTO FACTURA</td>
                 <td bgcolor="#824DBC"  align="center">' . $factura->getDescuento_factura() . '</td>
            </tr>';
}
$html .= '
        <tr>
             <td colspan="5"></td>
             <td colspan="2" align="center" style="color:white;" bgcolor="#8D8299">TOTAL FACTURA</td>
             <td align="center"  bgcolor="#824DBC">' . $total . '</td>
        </tr>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');
// Colocamos el puntero al final
$pdf->lastPage();


$pdf->Output('Factura.pdf', 'I');
