<?php
$campo = 0;

$numLineas = 0;
$pos0 = "";
$pos12 = "";
$pos3 = "";
$pos4 = "";
$pos0aux = " ";
$pos12aux = " ";
$pos3aux = " ";

$TablaMateriales = array();
$TablaManodeObra = array();
$TablaMaquinaria = array();
$TablaCapitulos = array();
$TablaSubcapitulos = array();
$TablaPartidas = array();
$TablaParMat = array();
$TablaParPar = array();
$TablaSubPar = array();
$TablaSubSub = array();
$TablaCapPar = array();
$TablaCapSub = array();
$WrdArray = array();
$PartidaCantidad = array();
$LineaInf = array();
$NumMat = -1;
$NumMaq = -1;
$NumMao = -1;
$NumCap = -1;
$NumSub = -1;
$NumPar = -1;
$i_par = -1;
$sp = -1;
$ss = -1;
$cp = -1;
$cs = -1;
$pp = -1;
$inf = 0;
function validateLetras($texto) {
    $patrón = '/[a-zA-Z]/';
    return (bool)preg_match($patrón, $texto);
}
if (($handle = fopen($_FILES['fichero']['tmp_name'], 'rb')) !== FALSE) {
    # Set the parent multidimensional array key to 0.
    $nn = 0;
    while (($data = fgetcsv($handle, 10000, "|")) !== FALSE) {
        # Count the total keys in the row.
        $c = count($data);
        //echo "El valor de $c = ". $c;
        # Populate the multidimensional array.
        for ($x=0;$x<$c;$x++)
        {
            $csvarray[$nn][$x] = $data[$x];
        }
        $nn++;
    }
    # Close the File.
    fclose($handle);
}
# Print the contents of the multidimensional array.
//print_r($csvarray);
//  echo $pintar = $csvarray [0][0];
//***************************************************************
//********* LEEMOS EL FICHERO DE ENTRADA Y GENERAMOS LAS TABLAS
//***************************************************************
$numLineas = count($csvarray);
//echo "El valor de $numLineas =".$numLineas;
//
//echo "<br>";
for ($x=0;$x<$numLineas;$x++) {
    //echo "csvarray: ". $csvarray [$x][1]. " Valor de la X: ".$x."<br>";
    //echo "spos0: ".substr($csvarray  [$x][1], 0, 1);
    $pos0 = substr($csvarray  [$x][1], 0, 1);
    //if($pos0 == null){
    //    echo "Soy un valor nulo";
    //}
    $pos12 = substr($csvarray [$x][1], 1, 2);
    $pos3 = substr($csvarray [$x][1], 3, 1);
    $pos4 = substr($csvarray [$x][1], 4, 1);


    if (($csvarray [$x][0] == "~C") && (is_numeric($pos12)))//&& (strlen($csvarray [$x][1]) > 5))
    {
        switch (strtoupper($pos0)) {
            case ("P"):// Es un registro del tipo concepto Material Simple
                $NumMat++;
                $TablaMateriales[$NumMat][0] = $csvarray [$x][1]; //Código de Material
                $TablaMateriales[$NumMat][1] = $csvarray [$x][2]; //Unidad de Medida
                $TablaMateriales[$NumMat][2] = $csvarray [$x][3]; //Nombre del Material
                $TablaMateriales[$NumMat][3] = $csvarray [$x][4]; //Precio del Material Básico
                break;
            case ("M"):// Es un registro del tipo concepto Maquinaria
                $NumMaq++;
                $TablaMaquinaria[$NumMaq][0] = $csvarray [$x][1]; //Código de Maquinaria
                $TablaMaquinaria[$NumMaq][1] = $csvarray [$x][2]; //Unidad de Medida
                $TablaMaquinaria[$NumMaq][2] = $csvarray [$x][3]; //Nombre de la Maquinaria
                $TablaMaquinaria[$NumMaq][3] = $csvarray [$x][4]; //Precio de la Maquinaria
                break;
            case ("O"): // Es un registro del tipo concepto Mano de Obra
                $NumMao++;
                $TablaManodeobra[$NumMao][0] = $csvarray [$x][1]; //Código de Mano de obra
                $TablaManodeobra[$NumMao][1] = $csvarray [$x][2]; //Unidad de Medida
                $TablaManodeobra[$NumMao][2] = $csvarray [$x][3]; //Cargo que ocupa
                $TablaManodeobra[$NumMao][3] = $csvarray [$x][4]; //Precio del la Mano de obra
                break;
            case ("E"):
                $pos3 = substr($csvarray [$x][1], 3, 1);
                if (($pos3 == "#") && (strlen($csvarray [$x][1]) == 4))//Registro del tipo concepto Capítulo
                {
                    $NumCap++;
                    //echo "<br> NumCap: " . $NumCap;
                    $TablaCapitulos[$NumCap][0] = $csvarray [$x][1]; //Código del Capitulo ENN#
                    $TablaCapitulos[$NumCap][1] = $csvarray [$x][3]; //Nombre del Capítulo. ¡Ojo! Campo 3 no 2.
                } else {
                    if (validateLetras($pos3) && (strlen($csvarray [$x][1]) == 5))//Registro del tipo concepto Subcapítulo
                    {
                        $NumSub++;
                        $TablaSubcapitulos[$NumSub][0] = $csvarray [$x][1]; //Código del Subcapitulo ENNA#
                        $TablaSubcapitulos[$NumSub][1] = $csvarray [$x][3]; //Nombre del Subcapítulo. ¡Ojo! Campo 3 no 2.
                    } else {
                        if (strlen($csvarray [$x][1]) > 5)//Registro del tipo Concepto Partida
                        {
                            $NumPar++;
                            $TablaPartidas[$NumPar][0] = $csvarray [$x][1]; //Código de la Partida E02AM010
                            $TablaPartidas[$NumPar][1] = $csvarray [$x][2]; //Unidad de Medida
                            $TablaPartidas[$NumPar][2] = $csvarray [$x][3]; //Nombre de la Partida.
                            break;
                        }
                    }
                }
        }

    } else {
        if ($csvarray [$x][0] == "~D") {
            if ((strlen($csvarray [$x][1]) > 5) && ($pos0 == "E" || $pos0 == "A")) { // TABLA PARTIDAS MATERIALES
                //echo "Antes del for csvarray: ".$csvarray [$x]. " i_par: ".$i_par." pp  ". $pp;

                echo "<br>";
                $WrdArray = explode("\\", $csvarray[$x][2]);
                $n = count($WrdArray);
                $n--; //El último campo siempre está en blanco "\ |"
                //$campo;

                for ($z = 0; $z < $n; $z++) {
                    if ($i_par < 0 || $campo > 3) {
                        if ($i_par > -1) {//'Si ya se ha grabado un registro en la TablaParMat
                            $pos12aux = substr($TablaParMat[$i_par][1], 1, 2);
                            $pos0aux = substr($TablaParMat[$i_par][1], 0, 1);
                            if (($pos0aux == "E" || $pos0aux == "A") && (strlen($TablaParMat[$i_par][1]) > 5) && (is_numeric($pos12aux))) {
                                $pp++;
                                //echo "Grabando registro ParPar pp " . $pp . "<br>";
                                $TablaParPar[$pp][0] = $TablaParMat[$i_par][0];
                                $TablaParPar[$pp][1] = $TablaParMat[$i_par][1];
                                $TablaParPar[$pp][2] = $TablaParMat[$i_par][2];
                                $TablaParPar[$pp][3] = $TablaParMat[$i_par][3];
                                //echo "Grabando registro ParPar pp " . $pp . " " . $TablaParPar[$pp][1] . " " . $TablaParPar[$pp][2] . " " . $TablaParPar[$pp][3] . " " . $TablaParPar[$pp][4] . "<br>";
                                //echo "Antes de restar i_par " . $i_par . " " . $TablaParMat[$i_par][1] . " " . $TablaParMat[$i_par][2] . " " . $TablaParMat[$i_par][3] . " " . $TablaParMat[$i_par][4] . "<br>";
                                $i_par--;
                                //echo "Despues de restar i_par " . $i_par . " " . $TablaParMat[$i_par][1] . " " . $TablaParMat[$i_par][2] . " " . $TablaParMat[$i_par][3] . " " . $TablaParMat[$i_par][4] . "<br>";
                            }
                        }
                        $i_par++;
                        $TablaParMat[$i_par][0] = $csvarray[$x][1]; //Campo 0
                        $campo = 1;
                    }
                    $TablaParMat[$i_par][$campo] = $WrdArray[$z]; //Campo 1, Campo2, Campo3
                    $campo++;
                }


                // Cierra el For

                //if ($i_par > 0) {//'Si ya se ha grabado un registro en la TablaParMat
                //if ($csvarray[$x][1] == "A01A061") {
                //   echo "Dentro de ipar > 0 Valor de csvarray e i_par ". $csvarray[$x][1]."  ".$i_par;
                //    echo "<br>";
                //}


                //$pp++;
                //echo "Grabando Partida Partida 1: ".$TablaParPar[$pp][1]." ".$TablaParPar[$pp][2]." ". $TablaParPar[$pp][3] = $TablaParMat[$i_par][3]." ".$TablaParPar[$pp][4]." ";
                //$TablaParPar[$pp][1] = $TablaParMat[$i_par][1];
                //$TablaParPar[$pp][2] = $TablaParMat[$i_par][2];
                //$TablaParPar[$pp][3] = $TablaParMat[$i_par][3];
                //$TablaParPar[$pp][4] = $TablaParMat[$i_par][4];
                //$i_par--;
                //else {
                //}

                //else
            } else {

                if ($pos4 == "#" && strlen($csvarray [$x][1]) == 5) {    //TABLA SUBCAPITULOS PARTIDAS
                    $WrdArray = explode("\\", $csvarray[$x][2]);
                    $n = count($WrdArray);
                    $n--; //El último campo siempre está en blanco"\ |"
                    //$campo = 0;
                    //echo "Escribiendo en Entrada: ". $csvarray[$x][0]." ". $csvarray[$x][1]." ". $csvarray[$x][2]."<br>";

                    for ($z = 0; $z < $n; $z++) {

                        if ($sp < 0 || $campo > 3) {
                            $sp++;
                            $TablaSubPar[$sp][0] = $csvarray[$x][1];
                            $campo = 1;
                        }
                        //echo "Justo delante if: ". $csvarray[$x][0]." ". $csvarray[$x][1]." ". $csvarray[$x][2]."<br>";
                        //echo "campo: ". $campo. " Letra: ". substr($WrdArray[$z], 0, 1). "Almohadilla: ". substr($WrdArray[$z], 4, 1). " Longitud: ". strlen($WrdArray[$z])."<br>";
                        if ($campo == 1 && substr($WrdArray[$z], 0, 1) == "E" && substr($WrdArray[$z], 4, 1) == "#" && strlen($WrdArray[$z]) == 5) {
                            //echo "Escribiendo en TablaSubSub: ". $csvarray[$x][0]." ". $csvarray[$x][1]." ". $csvarray[$x][2]."<br>";
                            $ss++;
                            $TablaSubSub[$ss][0] = $csvarray [$x][1]; // TABLA SUBCAPITULOS SUBCAPITULOS
                            $TablaSubSub[$ss][1] = $WrdArray [$z];
                            $TablaSubSub[$ss][2] = $WrdArray [$z + 1];
                            $TablaSubSub[$ss][3] = $WrdArray [$z + 2];
                            $campo = 4;
                            $sp--;
                            $z += 2;

                        } else {
                            $TablaSubPar[$sp][$campo] = $WrdArray[$z];
                            $campo++;
                        }

                    }
                } else {
                    if ($pos0 == "E" && $pos3 == "#") {
                        $WrdArray = explode("\\", $csvarray[$x][2]);
                        $n = count($WrdArray);
                        $n--; //El último campo siempre está en blanco"\ |"
                        $campo = 0;

                        for ($z = 0; $z < $n; $z++) {

                            if ($cp < 0 || $campo > 3 || $campo == 0) {
                                $cp++;
                                $TablaCapPar[$cp][0] = $csvarray[$x][1];
                                $campo = 1;
                            }
                            //echo "<br>". $WrdArray[$z]. " Atnes del if campo: ". $campo. " Letra: ". substr($WrdArray[$z],0,1). " Almohadila: ". substr($WrdArray[$z],4,1). " Longitud: ". strlen($WrdArray[$z])."<br>";
                            if ($campo == 1 && substr($WrdArray[$z], 0, 1) == "E" && substr($WrdArray[$z], 4, 1) == "#" && strlen($WrdArray[$z]) == 5) {
                                $cs++;
                                $TablaCapSub[$cs][0] = $csvarray [$x][1]; // TABLA CAPITULOS SUBCAPITULOS
                                $TablaCapSub[$cs][1] = $WrdArray [$z];
                                $TablaCapSub[$cs][2] = $WrdArray [$z + 1];
                                $TablaCapSub[$cs][3] = $WrdArray [$z + 2];
                                $campo = 4;
                                $cp--;
                                $z += 2;
                            } else {
                                $TablaCapPar[$cp][$campo] = $WrdArray[$z]; // TABLA CAPITULOS PARTIDAS
                                $campo++;
                            }
                        }

                    }
                }
            }

        }
    }
}//Cirra el For de Lectura del Fichero de Entrada

//Si el último registro que se grabó en la TablaParMat era un registro del tipo Partida/Partida,
//lo eliminamos de la TablaParMat y lo grabamos en la TablaParPar
        $pos12aux = substr($TablaParMat[$i_par][1], 1, 2);
        $pos0aux = substr($TablaParMat[$i_par][1], 0, 1);
        if (($pos0aux == "E" || $pos0aux == "A") && (strlen($TablaParMat[$i_par][1]) > 5) && (is_numeric($pos12aux)))
        {
            $pp++;
            //echo "Grabando registro ParPar pp " . $pp . "<br>";
            $TablaParPar[$pp][0] = $TablaParMat[$i_par][0];
            $TablaParPar[$pp][1] = $TablaParMat[$i_par][1];
            $TablaParPar[$pp][2] = $TablaParMat[$i_par][2];
            $TablaParPar[$pp][3] = $TablaParMat[$i_par][3];
            //echo "Grabando registro ParPar pp " . $pp . " " . $TablaParPar[$pp][1] . " " . $TablaParPar[$pp][2] . " " . $TablaParPar[$pp][3] . " " . $TablaParPar[$pp][4] . "<br>";
            //echo "Antes de restar i_par " . $i_par . " " . $TablaParMat[$i_par][1] . " " . $TablaParMat[$i_par][2] . " " . $TablaParMat[$i_par][3] . " " . $TablaParMat[$i_par][4] . "<br>";
            $i_par--;
        }
//*************************************************************
//******** ORDENAMOS TablaParMat
//**************************************************************
//La columna de materiales, maquinaria y mano de obra la obligamos
// a poner indices con 'MatMaqMao', que es la segunda columna.
for($k=0;$k<$i_par;$k++){
    for($m=0;$m<=3;$m++){
        if ($m == 1){
            $TablaParMat [$k]['MatMaqMao'] = $TablaParMat [$k][$m];
        }
    }
}
//Creamos un array auxiliar para ordenar el Array/Lista por la columna de MatMaqMao
$aux = Array();
foreach($TablaParMat as &$MatMaqMao){
    $aux[] = &$MatMaqMao["MatMaqMao"];
}
//Ahora con la funcion de PHP array_multisort ordenamops el array $TablaParMat
array_multisort($aux, $TablaParMat);

//echo "Ahora LA VA L ATABLA parmattttttttttttttttttttttttttttttttttttttttttttttt";
//foreach($TablaParMat as &$MatMaqMao){
//    echo $MatMaqMao[1]. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $MatMaqMao["MatMaqMao"]. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $MatMaqMao[3]. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $MatMaqMao[4]."<br/>";
//}

//*************************************************************
//******** ORDENAMOS TablaSubSub
//**************************************************************
//La columna de subcapítulos la obligamos
// a poner indices con 'Subcapitulo', que es la segunda columna
for($k=0;$k<$ss;$k++){
    for($m=0;$m<=3;$m++){
        if ($m == 1){
            $TablaSubSub [$k]['Subcapitulo'] = $TablaSubSub [$k][$m];
        }
    }
}
//Creamos un array auxiliar para ordenar el Array/Lista por la columna de Subcapitulo
$aux = Array();
foreach($TablaSubSub as &$Subcapitulo){
    $aux[] = &$TablaSubSub["Subcapitulo"];
}
//Ahora con la funcion de PHP array_multisort ordenamops el array $TablaSubSub
array_multisort($aux, $TablaSubSub);

//echo "Ahora LA VA L ATABLA Supcapitulo ==========================================================================";
//foreach($TablaSubSub as &$Supcapitulo){
//    echo $Supcapitulo[1]. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $Supcapitulo["Subcapitulo"]. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $Supcapitulo[3]. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $Supcapitulo[4]."<br/>";
//}

//*************************************************************
//******** ORDENAMOS TablaParPar
//**************************************************************
//La columna de partida la obligamos
// a poner indices con 'Partida', que es la segunda columna.
for($k=0;$k<$pp;$k++){
    for($m=0;$m<=3;$m++){
        if ($m == 1){
            $TablaParPar [$k]['Partida'] = $TablaParPar [$k][$m];
        }
    }
}
//Creamos un array auxiliar para ordenar el Array/Lista por la columna de Partida 2ª columna
$aux = Array();
foreach($TablaParPar as &$Partida){
    $aux[] = &$Partida["Partida"];
}
//Ahora con la función de PHP array_multisort ordenamos el array $TablaParPar
array_multisort($aux, $TablaParPar);

//echo "Ahora LA VA LA TABLA ParPar";
//foreach($TablaParPar as &$Partida){
//    echo $Partida[1]. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $Partida["Partida"]. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $Partida[3]. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $Partida[4]."<br/>";
//}

//***************************************************************
//********* GENERAMOS EL INFORME MATERIALES
//***************************************************************

for ($x=0;$x<=$NumMat;$x++) {
    $LineaInf[$inf][0]= $TablaMateriales[$x][0]; // Codigo del Material (0)
    $LineaInf[$inf][1]= $TablaMateriales[$x][1]; // Unidad de Medida (1)
    $LineaInf[$inf][2]= $TablaMateriales[$x][2]; // Nombre del Material (2)
    $LineaInf[$inf][4]= $TablaMateriales[$x][3]; // Precio (4)
    for ($y=0; $y<=$i_par;$y++){
        if ($TablaMateriales[$x][0]==$TablaParMat [$y][1]) {
            $LineaInf[$inf][3] = $TablaParMat[$y][3]; //Cantidad del material básico en la partida. (3)
            $LineaInf[$inf][5] = $LineaInf[$inf][3] * $LineaInf[$inf][4]; //Importe = Cantidad * Precio.(5)
            $SuperCodigoCantidad = Obtener_SupercodigoyCantidad($TablaParMat[$y][0], $LineaInf[$inf][3], $TablaParPar, $pp);
            $LineaInf[$inf][6] = $SuperCodigoCantidad[0];//Codigo de la Partida de Mayor Rango (6)
            $LineaInf[$inf][3] = $SuperCodigoCantidad[1];//Cantidad de Material Básico a nivel Partidas (3)
            $NombreyUdPartida = Obtener_NombreyUdPartida($LineaInf[$inf][6],$TablaPartidas, $NumPar);
            $LineaInf[$inf][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
            $LineaInf[$inf][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)
            $CodigoCantidades = Obtener_CodigoCantidades($LineaInf[$inf][6], $LineaInf[$inf][3], $TablaSubPar, $sp);
            $LineaInf[$inf][10] = $CodigoCantidades[0]; //Código Subcapitulo Asociado a la Partida (10)
            $LineaInf[$inf][3]  = $CodigoCantidades[1]; //Cantidad del Material Básico a nivel Subcapítulo (3)
            $LineaInf[$inf][9]  = $CodigoCantidades[2]; //Cantidad en la Unidad de Material Básico Obra. (9)
            $SuperCodigoCantidad = Obtener_SupercodigoyCantidad($LineaInf[$inf][6], $LineaInf[$inf][3], $TablaSubSub, $ss);
            $LineaInf[$inf][10] = $SuperCodigoCantidad[0]; //Código Subcapitulo de Mayor Rango (10)
            $LineaInf[$inf][3]  = $SuperCodigoCantidad[1]; //Cantidad del Material Básico a nivel Subcapítulo (3)
            $LineaInf[$inf][11] = Obtener_NombreSuboCap ($LineaInf[$inf][10], $TablaSubcapitulos,$NumSub); //(11)
            $CodigoCantidades = Obtener_CodigoCantidades($LineaInf[$inf][10], $LineaInf[$inf][3], $TablaCapSub, $cs);
            $LineaInf[$inf][12] = $CodigoCantidades[0]; //Código del Capitulo (12)
            $LineaInf[$inf][3]  = $CodigoCantidades[1]; //Cantidad del Material Básico a nivel Capitulo (3).
            $LineaInf[$inf][9]  = $CodigoCantidades[2]; //Cantidad de Material Básico en la Unidad de Obra (9).
            $LineaInf[$inf][13] = Obtener_NombreSuboCap ($LineaInf[$inf][12], $TablaCapitulos,$NumCap);//(13)
        }
    }
    $inf++;
}

//for($j=0;$j<$inf;$j++) {
//    echo "&nbsp;".$LineaInf[$j][0]."&nbsp;".$LineaInf[$j][1]."&nbsp;".$LineaInf[$j][2]."&nbsp;".$LineaInf[$j][3]."&nbsp;".$LineaInf[$j][4]."&nbsp;".$LineaInf[$j][5]."&nbsp;".$LineaInf[$j][6]."&nbsp;".$LineaInf[$j][7]."&nbsp;".$LineaInf[$j][8]."&nbsp;".$LineaInf[$j][9]."&nbsp;".$LineaInf[$j][10]."&nbsp;".$LineaInf[$j][11]."&nbsp;".$LineaInf[$j][12]."&nbsp;".$LineaInf[$j][13]."&nbsp; <br>";
//}

//***************************************************************
//********* PINTAR EL INFORME
//***************************************************************
echo "<html>";
echo "<head>";
?>
<meta name="description" content="Convert HTML to CSV"/>
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<title>HTML To CSV Converter</title>
<script src="js/underscore-min.js"></script>
<script src="js/blob.js"></script>
<script src="js/filesaver.js"></script>
<script src="json2.js"></script>
<script src="strsup.js"></script>
<script src="localread.js"></script>
<script src="csvparse.js"></script>
<script src="csvsup.js"></script>
<link href="layout3col.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
    function assignText(s) {
        document.getElementById('txt1').value = s;
        document.getElementById('btnRun').click();
    }
    function excelit(){
        window.open("htmlexcel.php");
    }
    function odsit(){
        window.open("htmlods.php");
    }

    function runit() {
        var delimiter = radiovalue(document.getElementById('frm1').outsep);
        var noMultiLines = document.getElementById('chkNoBreaks').checked;
        if (delimiter == "o") delimiter = document.getElementById("outSepOtherVal").value;
        var whichTable = document.getElementById('selTabNum').value;
        whichTable = whichTable || "0";
        var bQuotes = (document.getElementById('chkCsvQuotes')).checked;
        var removeTags = (document.getElementById('chkRemoveTags')).checked;
        var html=document.getElementById('divHtml');
        //html.innerHTML=document.getElementById('txt1').value.replace(/<script/gmi,"<xxxxx");
        var s="";
        var cells;
        var value;
        //var tbl = html.getElementsByTagName('table');
        var tbl = document.getElementsByTagName('table');
        //var tbl = document.getElementById('txt1');
        //alert (tbl);
        var cnt=tbl.length;
        var re = new RegExp("<\/?\\w+((\\s+\\w+(\\s*=\\s*(?:\".*?\"|'.*?'|[^'\">\\s]+))?)+\\s*|\\s*)\/?>",'igm');

        for(var j=0;j<tbl.length;j++) {
            if( (""+(j+1)) != whichTable && whichTable!="0") continue;
            rows=tbl[j].getElementsByTagName('tr');
            for(var k=0;k<rows.length;k++) {
                if ('querySelectorAll' in document) {
                    cells=rows[k].querySelectorAll('td,th');
                } else {
                    cells=rows[k].getElementsByTagName('td');
                    if(!cells || cells.length==0) {
                        cells=rows[k].getElementsByTagName('th');
                    }
                }

                for(var n=0;n<cells.length;n++) {
                    value=cells[n].innerHTML;
                    if(value==null)value="";else value+="";
                    value = value.replace(/\r\n|\r|\n/gmi,' ');
                    if(noMultiLines) value = value.replace(/\n|<br>|<br\/>|<br \/>/gmi,' ');
                    else value = value.replace(/\n|<br>|<br\/>|<br \/>/gmi,'\n');
                    if (removeTags) value=value.replace(re,'');
                    value=_.unescape(value);
                    value=value.replace(/&nbsp;/gmi," ");
                    value=value.trim();
                    if(bQuotes) {
                        s += '"' + value.replace(/"/gmi, '""') + '"' + delimiter;
                    }
                    else {
                        s+=value.toCsv(delimiter,'"') + delimiter;
                    }
                }
                s=s.slice(0, delimiter.length*-1); // remove last delimiter
                s += "\n";
            }
        }
        document.getElementById('txta').value = s;
        if(cnt<1 && document.getElementById('txt1').value.trim() != "") {
            window.alert('No TABLE tag found in HTML. Please check your input.');
        }
        s = "<select id=\"selTabNum\"  onchange=\"document.getElementById('btnRun').click()\">";
        s += "<option value=0>-All-</option>"
        for(j=0;j<cnt;j++) {
            s+= "<option value=\"" + (j+1) + "\" ";
            if( (j+1)==whichTable) s+=" selected";
            s+= ">" + getOrdinal(j+1) + "</option>";
        }
        s+="</select>";
        document.getElementById("spanTabNum").innerHTML = s;
        document.getElementById('spanCount').innerHTML = "(Tables found: " + cnt + ")";
        saveFile(document.getElementById('txta').value,'csv');


    }
    function stringTabla(){
        return  "<table cellspacing=\'1px\' cellpadding=\'0\' border=\'1\' class=\'example\'><tr><th>Column 1</th><th>Column 2</th><th>Column 3</th><th>Column 4</th><th>Column 5</th><th>Column 6</th><th>Column 7</th><th>Column 8</th><th>Column 9</th> <th>Column 10</th><tr><td>9995</td><td>6489</td><td>3080</td><td>2065</td><td>1245</td><td>6292</td><td>2109</td><td>849</td><td>6945</td><td>3615</td></tr><tr><td>4230</td><td>6154</td><td>2524</td><td>6144</td><td>732</td><td>2463</td><td>8380</td><td>6423</td><td>8722</td><td>4873</td></tr><tr><td>9995</td><td>6489</td><td>3080</td><td>2065</td><td>1245</td><td>6292</td><td>2109</td><td>849</td><td>6945</td><td>3615</td></tr><tr><td>4230</td><td>6154</td><td>2524</td><td>6144</td><td>732</td><td>2463</td><td>8380</td><td>6423</td><td>8722</td><td>4873</td></tr><tr><td>9995</td><td>6489</td><td>3080</td><td>2065</td><td>1245</td><td>6292</td><td>2109</td><td>849</td><td>6945</td><td>3615</td></tr><tr><td>4230</td><td>6154</td><td>2524</td><td>6144</td><td>732</td><td>2463</td><td>8380</td><td>6423</td><td>8722</td><td>4873</td></tr><tr><td>9995</td><td>6489</td><td>3080</td><td>2065</td><td>1245</td><td>6292</td><td>2109</td><td>849</td><td>6945</td><td>3615</td></tr><tr><td>4230</td><td>6154</td><td>2524</td><td>6144</td><td>732</td><td>2463</td><td>8380</td><td>6423</td><td>8722</td><td>4873</td></tr><tr><td>9995</td><td>6489</td><td>3080</td><td>2065</td><td>1245</td><td>6292</td><td>2109</td><td>849</td><td>6945</td><td>3615</td></tr><tr><td>4230</td><td>6154</td><td>2524</td><td>6144</td><td>732</td><td>2463</td><td>8380</td><td>6423</td><td>8722</td><td>4873</td></tr></tabla>";

    }

</script>
<style>
    table { border-collapse:collapse; }
    table,th, td { border: 1px solid black; }
</style>
</head>

<?php
//echo "<link href=\"layout3col.css\" rel=\"stylesheet\" type=\"text/css\">";
echo "<style type='text/css'>";
echo ".thCabecera{font-weight:bold; color:#ffffff;}";
echo "</style>";
echo "</head>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
//echo "<b>testdata1</b> \t <u>testdata2</u> \t \n ";

//Cabececeras tabla
echo "<table><tr class='thCabecera'><th colspan='6' bgcolor='#9A3634' >MATERIAL BASICO</th><th colspan='4' bgcolor='#36609C'>UNIDAD DE OBRA</th><th colspan='2' bgcolor='#4F6228'>SUBCAPITULO</th><th colspan='2' bgcolor='#60497A'>CAPITULO</th></tr>";
//Subcabeceras tabla
echo "<tr><th bgcolor='#F2DCDB'>CODIGO</th><th bgcolor='#E6B8B7'>ud</th><th bgcolor='#DA9694'>NOMBRE MATERIAL</th><th bgcolor='#E6B8B7'>CANTIDAD</th><th bgcolor='#E6B8B7'>PRECIO</th><th bgcolor='#DA9694'>IMPORTE</th>";
echo "<th bgcolor='#DCE6F1'>CODIGO</th><th bgcolor='#8DB4E2'>ud</th><th bgcolor='#8DB4E2'>NOMBRE</th><th bgcolor='#244062'>CANTIDAD</th><th bgcolor='#D8E4BC'>CODIGO</th><th bgcolor='#C4D79B'>NOMBRE</th><th bgcolor='#CCC0DA'>CODIGO</th><th bgcolor='#B1A0C7'>NOMBRE</th></tr>";
//$tbl = 1000;
//filas tabla
$tablaHTML="";
for($j=0;$j<$inf;$j++) {
    $tablaHTML .= "<tr><td>".$LineaInf[$j][0]."</td><td>".$LineaInf[$j][1]."</td><td>".$LineaInf[$j][2]."</td><td>".$LineaInf[$j][3]."</td><td>".$LineaInf[$j][4]."</td><td>".$LineaInf[$j][5]."</td><td>".$LineaInf[$j][6]."</td><td>".$LineaInf[$j][7]."</td><td>".$LineaInf[$j][8]."</td><td>".$LineaInf[$j][9]."</td><td>".$LineaInf[$j][10]."</td><td>".$LineaInf[$j][11]."</td><td>".$LineaInf[$j][12]."</td><td>".$LineaInf[$j][13]."</td></tr>";
    echo "<tr><td>".$LineaInf[$j][0]."</td><td>".$LineaInf[$j][1]."</td><td>".$LineaInf[$j][2]."</td><td>".$LineaInf[$j][3]."</td><td>".$LineaInf[$j][4]."</td><td>".$LineaInf[$j][5]."</td><td>".$LineaInf[$j][6]."</td><td>".$LineaInf[$j][7]."</td><td>".$LineaInf[$j][8]."</td><td>".$LineaInf[$j][9]."</td><td>".$LineaInf[$j][10]."</td><td>".$LineaInf[$j][11]."</td><td>".$LineaInf[$j][12]."</td><td>".$LineaInf[$j][13]."</td></tr>";
}

echo "</table>";
//echo "Este es el valor de la variable tblaHTMLLLLLLLLLLLLLLLLLLLLLLLLLLLLL    ".$tablaHTML;
header("Cache-Control: no-cache");
header("Pragma: no-cache");
session_start();
/*session is started if you don't write this line can't use $_Session  global variable*/


$_SESSION['$tablaHTMLSess'] = $tablaHTML;
//$tablaHTML = "DUmmyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy";
?>


<form id="frm1">
    <!--
    <br/><b>Choose HTML file here</b>
    <input type="file" id="f1" onchange="loadTextFile(this,assignText)" title="Choose a local HTML file" />
    <br/><b>or Enter an URL</b> <input type="text" size="40" value="" name="url" id="url" title="Enter the URL of a web page" />
    <input type="button" id="btnUrl" value="Load URL" title="Load CSV via URL" onclick="loadURL(document.getElementById('url').value)" />
    <br/><b>or paste into Text Box below</b><br/>
    &nbsp;<input type="button" value="Clear Input" onclick="window.location.reload(true)">
    &nbsp; <input type="button" value="Example" title="Load and run example" onclick="document.getElementById('url').value='http://www.tournamentmaps.com/florida-tennis-colleges.htm';document.getElementById('btnUrl').click()" /><br/>
    <textarea class="xxxxlined" rows="10" cols="80" id="txt1" wrap="off" placeholder="HTML" onchange="runit()"></textarea>-->
    <br/>
    Separador de campos para el CSV:
    <label><input type="radio" name="outsep" id="outSepPipe" value="|" checked="checked"> Barra-|</label> &nbsp;
    <label><input type="radio" name="outsep" id="outSepComma" value="," > Comma-,</label> &nbsp;
    <label><input type="radio" name="outsep" id="outSepSemicolon" value=";" > Punto y coma-;</label> &nbsp;
    <label><input type="radio" name="outsep" id="outSepSemicolon" value=":" > Dos puntos-:</label> &nbsp;
    <label><input type="radio" name="outsep" id="outSepTab" value=" " onclick="this.value='\t'" > Tabulador</label> &nbsp;
    <label><input type="radio" name="outsep" id="outSepOther" value="o" > Elegir otros</label>
    <label><input type="text" size="2" id="outSepOtherVal" value="@"/></label>
    <br />
    <div style="visibility: hidden;">
    <label><input type="text" size="15" id="fn" value="document_name" title="Indique el nombre del fichero sin la extensión" />.csv</label>
        <input type="button" id="btnRun" class="ui-button-text-only" value="Convertir informe a CSV" title="Convertir informe a CSV"
               onclick="runit()">
        <!--<label><input type="button" value="Convertir informe a CSV" title="Convertir informe a CSV" onclick="saveFile(document.getElementById('txta').value,'csv')" /></label>-->


    </div>
    <input type="button" id="btnRun" class="ui-button-text-only" value="Convertir informe a CSV" title="Convertir informe a CSV"
           onclick="runit()">

    <input type="button" id="btnRun" class="ui-button-text-only" value="Convertir informe a LibreOffice Calc" title="Convertir informe a Excel"
           onclick="odsit()">

    <input type="button" id="btnRun" class="ui-button-text-only" value="Convertir informe a Excel" title="Convertir informe a Excel"
           onclick="excelit()">
     &nbsp;
    <div style="visibility: hidden; ">


    <label hidden="hidden">Which table? <span id="spanTabNum">
        <select id="selTabNum" hidden="hidden" onchange="document.getElementById('btnRun').click()">
            <option value="0" selected="selected">All</option>
        </select></span></label>
    <span id="spanCount"></span>

    </div>
   <!-- -->
    <br/>

    <div style="visibility: hidden;">
    <label><input id="chkCsvQuotes" type="checkbox" /> Force Wrap values in double quotes</label>
    <br />
    <label><input type="checkbox" id="chkNoBreaks" value="Y" checked="checked"> Change &lt;BR&gt; tags to space in CSV</label>
    (Use this to remove line breaks in field values)
    <br />
    <label><input type="checkbox" id="chkRemoveTags" value="Y" checked="checked"> Remove HTML tags in CSV</label>
    (Use this to prevent seeing HTML tags in your output)
        </div>
    <!--
   -->
</form>
<div style="visibility: hidden;">
<form id ="excel"  action="htmlexcel.php" method="post">
    <input type="hidden" name="tablaHTML" value=""><br>
    <input type="text" name="texto" ><br>

    <input type="submit" title="Enviar datos">

</form>
    </div>
</div>
<div style="visibility: hidden;">
    <!--TODO: poner esto todo con el mismo estilo -->
    <label><input type="text" size="15" id="fn" value="convertcsv" title="Enter filename without extension" />.csv</label>
    <label><input type="button" value="Save to Disk" onclick="saveFile(document.getElementById('txta').value,'csv')" /></label><br/>
    <textarea id="txta" rows="15" cols="100" wrap="off" placeholder="Output Results"></textarea></center>
</div>
<?php
//Fin tabla
echo "</body>";
echo "</html>";
//***************************************************************
//********* FUNCIONES UTILIZADAS EN LA GENERACIÓN DE INFORMES
//***************************************************************
function Obtener_SupercodigoYCantidad($Aux_Codigo, $Aux_Cantidad, $Aux_Tabla, $Aux_indice)
{
    for ($y = 0; $y <= $Aux_indice; $y++) {
    //echo "Dentro del forito ". $y. " ". $Aux_Tabla [$y][0]." ". $Aux_Tabla [$y][1]."<br>";
        if ($Aux_Codigo == $Aux_Tabla[$y][1]) {
            $Aux_Codigo = $Aux_Tabla[$y][0];
            //echo "Aux Codigo: ". $Aux_Codigo. "<br>";
            $Aux_Cantidad = $Aux_Cantidad * $Aux_Tabla[$y][3];
            //echo "Aux Cantidad:". $Aux_Cantidad. "<br>";
            $y =-1;
        }
    }
    $Aux_CodigoCantidad[0] = $Aux_Codigo;
    $Aux_CodigoCantidad[1] = $Aux_Cantidad;
    return ($Aux_CodigoCantidad);
}

function Obtener_NombreyUdPartida($Aux_Codigo, $Aux_Tabla,$Aux_indice)
{
    for ($y = 0; $y <= $Aux_indice; $y++) {
        //echo "Dentro del forito ". $y. " ". $Aux_Tabla [$y][0]." ". $Aux_Tabla [$y][1]."<br>";
        if ($Aux_Codigo == $Aux_Tabla[$y][0]) {
            $Aux_UdNombre= $Aux_Tabla[$y][1];
            $Aux_UdNombre= $Aux_Tabla[$y][2];
            return ($Aux_UdNombre);
        }
    }
}

function Obtener_CodigoCantidades($Aux_Codigo, $Aux_Cantidad, $Aux_Tabla, $Aux_indice)
{
    for ($y = 0; $y <= $Aux_indice; $y++) {
            //echo "Dentro del forito ". $y. " ". $Aux_Tabla [$y][0]." ". $Aux_Tabla [$y][1]."<br>";
        if ($Aux_Codigo == $Aux_Tabla[$y][1]) {
            $Aux_CodigoCantidad[0] = $Aux_Tabla[$y][0];
            $Aux_CodigoCantidad[1] = $Aux_Cantidad * $Aux_Tabla[$y][3];
            $Aux_CodigoCantidad[2] = $Aux_Tabla[$y][3];
            return ($Aux_CodigoCantidad);
        }
    }
}

function Obtener_NombreSuboCap($Aux_Codigo, $Aux_Tabla,$Aux_indice)
{
    for ($y = 0; $y <= $Aux_indice; $y++) {
        //echo "Dentro del forito ". $y. " ". $Aux_Tabla [$y][0]." ". $Aux_Tabla [$y][1]."<br>";
        if ($Aux_Codigo == $Aux_Tabla[$y][0]) {
            return ($Aux_Tabla[$y][1]);
        }
    }
}

        echo "<br>";
        echo "Materiales: NumMat: " . $NumMat . "<br>";
        for ($x = 0; $x <= $NumMat; $x++) {
            echo $TablaMateriales[$x][0] . " " . $TablaMateriales[$x][1] . " " . $TablaMateriales[$x][2] . " " . $TablaMateriales[$x][3];
            echo "<br>";
        }
        echo "<br>";
        echo "Maquinaria: NumMaq: " . $NumMaq . "<br>";
        for ($x = 0; $x <= $NumMaq; $x++) {
            echo $TablaMaquinaria[$x][0] . " " . $TablaMaquinaria[$x][1] . " " . $TablaMaquinaria[$x][2] . " " . $TablaMaquinaria[$x][3];
            echo "<br>";
        }
        echo "<br>";
        echo "ManodeObra: NumMao: " . $NumMao . "<br>";
        for ($x = 0; $x <= $NumMao; $x++) {
            echo $TablaManodeobra[$x][0] . " " . $TablaManodeobra[$x][1] . " " . $TablaManodeobra[$x][2] . " " . $TablaManodeobra[$x][3];
            echo "<br>";
        }
        echo "<br>";
        echo "Capitulos: NumCap: " . $NumCap . " <br>";
        for ($x = 0; $x <= $NumCap; $x++) {
            echo $TablaCapitulos[$x][0] . " " . $TablaCapitulos[$x][1];
            echo "<br>";
        }
        echo "<br>";
        echo "Subcapitulos: NumSub: " . $NumSub . " <br>";
        for ($x = 0; $x <= $NumSub; $x++) {
            echo $TablaSubcapitulos[$x][0] . " " . $TablaSubcapitulos[$x][1];
            echo "<br>";
        }
        echo "<br>";
        echo "Partidas: NumPar: " . $NumPar . "<br>";
        for ($x = 0; $x <= $NumPar; $x++) {
            echo $TablaPartidas[$x][0] . " " . $TablaPartidas[$x][1] . " " . $TablaPartidas[$x][2];
            echo "<br>";
        }
        echo "<br>";
        echo "Partidas Materiales: i_par: " . $i_par . " <br>";
        echo "<br>";
        for ($x = 0; $x <= $i_par; $x++) {
            echo $x . " " . $TablaParMat[$x][0] . " " . $TablaParMat[$x][1] . " " . $TablaParMat[$x][2] . " " . $TablaParMat[$x][3];
            echo "<br>";
        }
        echo "<br>";
        echo "Partidas Partidas: pp: " . $pp . " <br>";
        echo "<br>";
        for ($x = 0; $x <= $pp; $x++) {
            echo $x . " " . $TablaParPar[$x][0] . " " . $TablaParPar[$x][1] . " " . $TablaParPar[$x][2] . " " . $TablaParPar[$x][3];
            echo "<br>";
        }
        echo "<br>";
        echo "Subcapitulos Partidas Valor de sp:" . $sp;
        echo "<br>";
        for ($x = 0; $x <= $sp; $x++) {
            echo $TablaSubPar[$x][0] . " " . $TablaSubPar[$x][1] . " " . $TablaSubPar[$x][2] . " " . $TablaSubPar[$x][3];
            echo "<br>";
        }
        echo "<br>";
        echo "Subcapitulos Suubcapitulos: ss: " . $ss . " <br>";
        echo "<br>";
        for ($x = 0; $x <= $ss; $x++) {
            echo $TablaSubSub[$x][0] . " " . $TablaSubSub[$x][1] . " " . $TablaSubSub[$x][2] . " " . $TablaSubSub[$x][3];
            echo "<br>";
        }
        echo "<br>";
        echo "Capitulos Partidas: cp: " . $cp . " <br>";
        echo "<br>";
        for ($x = 0; $x <= $cp; $x++) {
            echo $TablaCapPar[$x][0] . " " . $TablaCapPar[$x][1] . " " . $TablaCapPar[$x][2] . " " . $TablaCapPar[$x][3];
            echo "<br>";
        }
        echo "<br>";
        echo "Capitulos Subcapitulos cs: " . $cs . " <br>";
        echo "<br>";
        for ($x = 0; $x <= $cs; $x++) {
            echo $TablaCapSub[$x][0] . " " . $TablaCapSub[$x][1] . " " . $TablaCapSub[$x][2] . " " . $TablaCapSub[$x][3];
            echo "<br>";
        }


//}
//Devuelve 6 caracteres desde el carácter 18
//echo substr($cadena, 18,6);
//Mayusculas y Minúsculas
//echo strtolower($cadena) ;
//echo strtoupper($cadena);
//Devuelve la longitud de una cadena
//$numero_letras = strlen($cadena);
//Preguntar por un número entero
//$numero_entero = 0;
//if (is_integer()($numero_entero)) {
//    echo ("numero_entero es del tipo integer");
//}


?>
