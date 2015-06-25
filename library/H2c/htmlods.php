<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=document_name.ods");
session_start();
echo "<html>";
echo "<head>";
//echo "<link href=\"layout3col.css\" rel=\"stylesheet\" type=\"text/css\">";
echo "<style type='text/css'>";
echo ".thCabecera{font-weight:bold; color:#ffffff;}";
echo ".thSubCabecera{font-weight:bold; color:#000000;}";
echo "</style>";
echo "</head>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";


//Aqui el estilo no lo acepta en el <tr> por lo que lo ponemos en cada etiqueta <th>
/*
echo "<table><tr><th colspan='4' bgcolor='#9A3634' class='thCabecera'>MATERIAL BASICO</th><th colspan='4' bgcolor='#36609C' class='thCabecera'>UNIDAD DE OBRA</th><th colspan='2' bgcolor='#4F6228' class='thCabecera'>SUBCAPITULO</th><th colspan='2' bgcolor='#60497A' class='thCabecera'>CAPITULO</th><th colspan='2' bgcolor='#9A3634' class='thCabecera'>MATERIAL BASICO</th></tr>";
//Subcabeceras tabla
echo "<tr><th bgcolor='#F2DCDB'>CODIGO</th><th bgcolor='#E6B8B7'>ud</th><th bgcolor='#DA9694'>NOMBRE MATERIAL</th><th bgcolor='#E6B8B7'>CANTIDAD</th><th bgcolor='#DCE6F1'>CODIGO</th><th bgcolor='#DA9694'>ud</th><th bgcolor='#8DB4E2'>NOMBRE</th>";
echo "<th bgcolor='#244062' class='thSubCabecera'>CANTIDAD</th><th bgcolor='#D8E4BC'>CODIGO</th><th bgcolor='#C4D79B'>NOMBRE</th><th bgcolor='#CCC0DA'>CODIGO</th><th bgcolor='#B1A0C7'>NOMBRE</th><th bgcolor='#E6B8B7'>PRECIO</th><th bgcolor='#DA9694'>IMPORTE</th></tr>";
*/

//Cabececeras tabla
echo "<table><tr class='thCabecera'><th colspan='6' bgcolor='#9A3634' class='thCabecera'>MATERIAL BASICO</th><th colspan='4' bgcolor='#36609C' class='thCabecera'>UNIDAD DE OBRA</th><th colspan='2' bgcolor='#4F6228' class='thCabecera'>SUBCAPITULO</th><th colspan='2' bgcolor='#60497A' class='thCabecera'>CAPITULO</th></tr>";
//Subcabeceras tabla
echo "<tr><th bgcolor='#F2DCDB' class='thCabecera'>CODIGO</th><th bgcolor='#E6B8B7' class='thCabecera'>ud</th><th bgcolor='#DA9694' class='thCabecera'>NOMBRE MATERIAL</th><th bgcolor='#E6B8B7' class='thCabecera'>CANTIDAD</th><th bgcolor='#E6B8B7' class='thCabecera'>PRECIO</th><th bgcolor='#DA9694' class='thCabecera'>IMPORTE</th>";
echo "<th bgcolor='#DCE6F1' class='thCabecera'>CODIGO</th><th bgcolor='#8DB4E2' class='thCabecera'>ud</th><th bgcolor='#8DB4E2' class='thCabecera'>NOMBRE</th><th bgcolor='#244062' class='thCabecera'>CANTIDAD</th><th bgcolor='#D8E4BC' class='thCabecera'>CODIGO</th><th bgcolor='#C4D79B' class='thCabecera'>NOMBRE</th><th bgcolor='#CCC0DA' class='thCabecera'>CODIGO</th><th bgcolor='#B1A0C7' class='thCabecera'>NOMBRE</th></tr>";

echo  $_SESSION['$tablaHTMLSess'];
echo "</table>";
echo "</br>";
//header("Cache-Control: no-cache");
//header("Pragma: no-cache");

/*session is started if you don't write this line can't use $_Session  global variable*/

echo "</br>";
echo "</br>";
//Cabececeras tabla
echo "<table><tr class='thCabecera'><th colspan='6' bgcolor='#9A3634' class='thCabecera'>MAQUINARIA</th><th colspan='4' bgcolor='#36609C' class='thCabecera'>UNIDAD DE OBRA</th><th colspan='2' bgcolor='#4F6228' class='thCabecera'>SUBCAPITULO</th><th colspan='2' bgcolor='#60497A' class='thCabecera'>CAPITULO</th></tr>";
//Subcabeceras tabla
echo "<tr><th bgcolor='#F2DCDB' class='thCabecera'>CODIGO</th><th bgcolor='#E6B8B7' class='thCabecera'>ud</th><th bgcolor='#DA9694' class='thCabecera'>NOMBRE MAQUINARIA</th><th bgcolor='#E6B8B7' class='thCabecera'>CANTIDAD</th><th bgcolor='#E6B8B7' class='thCabecera'>PRECIO</th><th bgcolor='#DA9694' class='thCabecera'>IMPORTE</th>";
echo "<th bgcolor='#DCE6F1' class='thCabecera'>CODIGO</th><th bgcolor='#8DB4E2' class='thCabecera'>ud</th><th bgcolor='#8DB4E2' class='thCabecera'>NOMBRE</th><th bgcolor='#244062' class='thCabecera'>CANTIDAD</th><th bgcolor='#D8E4BC' class='thCabecera'>CODIGO</th><th bgcolor='#C4D79B' class='thCabecera'>NOMBRE</th><th bgcolor='#CCC0DA' class='thCabecera'>CODIGO</th><th bgcolor='#B1A0C7' class='thCabecera'>NOMBRE</th></tr>";
echo  $_SESSION['$tablaHTML1Sess'];
echo "</table>";
echo "</br>";
echo "</br>";
//Cabececeras tabla
echo "<table><tr class='thCabecera'><th colspan='6' bgcolor='#9A3634' class='thCabecera'>MANO DE OBRA</th><th colspan='4' bgcolor='#36609C' class='thCabecera'>UNIDAD DE OBRA</th><th colspan='2' bgcolor='#4F6228' class='thCabecera'>SUBCAPITULO</th><th colspan='2' bgcolor='#60497A' class='thCabecera'>CAPITULO</th></tr>";
//Subcabeceras tabla
echo "<tr><th bgcolor='#F2DCDB' class='thCabecera'>CODIGO</th><th bgcolor='#E6B8B7' class='thCabecera'>ud</th><th bgcolor='#DA9694' class='thCabecera'>NOMBRE MANO DE OBRA</th><th bgcolor='#E6B8B7' class='thCabecera'>CANTIDAD</th><th bgcolor='#E6B8B7' class='thCabecera'>PRECIO</th><th bgcolor='#DA9694' class='thCabecera'>IMPORTE</th>";
echo "<th bgcolor='#DCE6F1' class='thCabecera'>CODIGO</th><th bgcolor='#8DB4E2' class='thCabecera'>ud</th><th bgcolor='#8DB4E2' class='thCabecera'>NOMBRE</th><th bgcolor='#244062' class='thCabecera'>CANTIDAD</th><th bgcolor='#D8E4BC' class='thCabecera'>CODIGO</th><th bgcolor='#C4D79B' class='thCabecera'>NOMBRE</th><th bgcolor='#CCC0DA' class='thCabecera'>CODIGO</th><th bgcolor='#B1A0C7' class='thCabecera'>NOMBRE</th></tr>";
echo  $_SESSION['$tablaHTML2Sess'];
echo "</table>";
$tbl = 10;
//filas tabla
/*
for($j=0;$j<$tbl;$j++) {
echo "<tr><td>9995</td><td>6489</td><td>3080</td><td>2065</td><td>1245</td><td>6292</td><td>2109</td><td>0849</td><td>6945</td><td>3615</td><td>2109</td><td>0849</td><td>6945</td><td>3615</td></tr>";
echo "<tr><td>4230</td><td>6154</td><td>2524</td><td>6144</td><td>7320</td><td>2463</td><td>8380</td><td>6423</td><td>8722</td><td>4873</td><td>2109</td><td>0849</td><td>6945</td><td>3615</td></tr>";
echo "<tr><td>9995</td><td>6489</td><td>3080</td><td>2065</td><td>1245</td><td>6292</td><td>2109</td><td>0849</td><td>6945</td><td>3615</td><td>2109</td><td>0849</td><td>6945</td><td>3615</td></tr>";
echo "<tr><td>4230</td><td>6154</td><td>2524</td><td>6144</td><td>7320</td><td>2463</td><td>8380</td><td>6423</td><td>8722</td><td>4873</td><td>2109</td><td>0849</td><td>6945</td><td>3615</td></tr>";
echo "<tr><td>9995</td><td>6489</td><td>3080</td><td>2065</td><td>1245</td><td>6292</td><td>2109</td><td>8490</td><td>6945</td><td>3615</td><td>2109</td><td>0849</td><td>6945</td><td>3615</td></tr>";
echo "<tr><td>4230</td><td>6154</td><td>2524</td><td>6144</td><td>7320</td><td>2463</td><td>8380</td><td>6423</td><td>8722</td><td>4873</td><td>2109</td><td>0849</td><td>6945</td><td>3615</td></tr>";
echo "<tr><td>9995</td><td>6489</td><td>3080</td><td>2065</td><td>1245</td><td>6292</td><td>2109</td><td>8490</td><td>6945</td><td>3615</td><td>2109</td><td>0849</td><td>6945</td><td>3615</td></tr>";
echo "<tr><td>4230</td><td>6154</td><td>2524</td><td>6144</td><td>7320</td><td>2463</td><td>8380</td><td>6423</td><td>8722</td><td>4873</td><td>2109</td><td>0849</td><td>6945</td><td>3615</td></tr>";
echo "<tr><td>9995</td><td>6489</td><td>3080</td><td>2065</td><td>1245</td><td>6292</td><td>2109</td><td>8490</td><td>6945</td><td>3615</td><td>2109</td><td>0849</td><td>6945</td><td>3615</td></tr>";
echo "<tr><td>4230</td><td>6154</td><td>2524</td><td>6144</td><td>7320</td><td>2463</td><td>8380</td><td>6423</td><td>8722</td><td>4873</td><td>2109</td><td>0849</td><td>6945</td><td>3615</td></tr>";
}

*/

echo "</body>";
echo "</html>";
?>



