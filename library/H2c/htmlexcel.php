<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=document_name.xls");
/******************************* Desde aqui ************************************************/
echo "<html>";
echo "<head>";
//echo "<link href=\"layout3col.css\" rel=\"stylesheet\" type=\"text/css\">";
echo "<style type='text/css'>";
echo ".thCabecera{font-weight:bold; color:#ffffff;}";
echo "</style>";
echo "</head>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
//echo "<b>testdata1</b> \t <u>testdata2</u> \t \n ";

//Cabececeras tabla
echo "<table border='1'><tr class='thCabecera'><th colspan='6' bgcolor='#9A3634' >MATERIAL BASICO</th><th colspan='4' bgcolor='#36609C'>UNIDAD DE OBRA</th><th colspan='2' bgcolor='#4F6228'>SUBCAPITULO</th><th colspan='2' bgcolor='#60497A'>CAPITULO</th></tr>";
//Subcabeceras tabla
echo "<tr><th bgcolor='#F2DCDB'>CODIGO</th><th bgcolor='#E6B8B7'>ud</th><th bgcolor='#DA9694'>NOMBRE MATERIAL</th><th bgcolor='#E6B8B7'>CANTIDAD</th><th bgcolor='#E6B8B7'>PRECIO</th><th bgcolor='#DA9694'>IMPORTE</th>";
echo "<th bgcolor='#DCE6F1'>CODIGO</th><th bgcolor='#8DB4E2'>ud</th><th bgcolor='#8DB4E2'>NOMBRE</th><th bgcolor='#244062'>CANTIDAD</th><th bgcolor='#D8E4BC'>CODIGO</th><th bgcolor='#C4D79B'>NOMBRE</th><th bgcolor='#CCC0DA'>CODIGO</th><th bgcolor='#B1A0C7'>NOMBRE</th></tr>";

header("Cache-Control: no-cache");
header("Pragma: no-cache");
session_start();
/*session is started if you don't write this line can't use $_Session  global variable*/


 echo $_SESSION['$tablaHTMLSess'];
/*
$tbl = 1000;
//filas tabla
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
echo "</table>";
//Fin tabla
echo "</body>";
echo "</html>";

/**************************************************************** Hasta aqui **************************************************************/
?>
