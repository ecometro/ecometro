<?php
if(isset($_FILES['fichero'])) {
    $errors     = array();
    $maxsize    = 900000;
    $acceptable = array(
        'application/octet-stream',
        'text/csv-schema',
        'text/csv',
        'text/xml'
    );
    $allowed =  array('bc3','BC·');
    $filename = $_FILES['fichero']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if(($_FILES['fichero']['size'] >= $maxsize) || ($_FILES["fichero"]["size"] == 0)) {
        $errors[] = 'Fichero demasiado largo debe ser menor de 900 Kb';
    }
    //echo "El formato del fichero es ........ ". $_FILES['fichero']['type'];
    if(!in_array($_FILES['fichero']['type'], $acceptable ) ||!in_array($ext,$allowed) ) {//&& (!empty($_FILES["uploaded_file"]["type"])
        $errors[] = 'Tipo de fichero incorrecto. Sólo se admiten ficheros de tipo BC3.';
    }
    /*

    if(!in_array($ext,$allowed) ) {
        echo 'error';
    }
    */
    if(count($errors) != 0) {
        foreach($errors as $error) {
            echo '<script>alert("'.$error.'");</script>';
            //header( 'Location: ' ) ;
            die("<script>location.href = 'form.php'</script>");
            exit();
        }
    }
}
$campo = 0;

$numLineas = 0;
$pos0 = "";
$pos12 = "";
$pos3 = "";
$pos4 = "";
$pos0aux = "";
$pos12aux = "";
$pos3aux = "";

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
$Aux_Tabla = array();
$NumMat = 0;
$NumMaq = 0;
$NumMao = 0;
$NumCap = 0;
$NumSub = 0;
$NumPar = 0;
$i_par = 0;
$sp = 0;
$ss = 0;
$cp = 0;
$cs = 0;
$pp = 0;
$inf = 0;
$inf1 = 0;
$inf2 = 0;
$sw_parpar = FALSE;
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
        if ($data[0] != "~C" && $data[0] != "~D")
        {
            continue;
        }
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
//***************************************************************
//********* LEEMOS EL FICHERO DE ENTRADA Y GENERAMOS LAS TABLAS
//***************************************************************
$numLineas = count($csvarray);

for ($x=0;$x<$numLineas;$x++) {
    //if ($csvarray [$x][1]!= Null) {
        $pos0 = substr($csvarray  [$x][1], 0, 1);
        $pos12 = substr($csvarray [$x][1], 1, 2);
        $pos3 = substr($csvarray [$x][1], 3, 1);
        $pos4 = substr($csvarray [$x][1], 4, 1);
    //}

    if (($csvarray [$x][0] == "~C") && (is_numeric($pos12)))//&& (strlen($csvarray [$x][1]) > 5))
    {
        switch (strtoupper($pos0)) {
            case ("P"):// Es un registro del tipo concepto Material Simple
                $TablaMateriales[$NumMat][0] = $csvarray [$x][1]; //Código de Material
                $TablaMateriales[$NumMat][1] = $csvarray [$x][2]; //Unidad de Medida
                $TablaMateriales[$NumMat][2] = $csvarray [$x][3]; //Nombre del Material
                $TablaMateriales[$NumMat][3] = $csvarray [$x][4]; //Precio del Material Básico
                $NumMat++;
                break;
            case ("M"):// Es un registro del tipo concepto Maquinaria

                $TablaMaquinaria[$NumMaq][0] = $csvarray [$x][1]; //Código de Maquinaria
                $TablaMaquinaria[$NumMaq][1] = $csvarray [$x][2]; //Unidad de Medida
                $TablaMaquinaria[$NumMaq][2] = $csvarray [$x][3]; //Nombre de la Maquinaria
                $TablaMaquinaria[$NumMaq][3] = $csvarray [$x][4]; //Precio de la Maquinaria
                $NumMaq++;
                break;
            case ("O"): // Es un registro del tipo concepto Mano de Obra

                $TablaManodeobra[$NumMao][0] = $csvarray [$x][1]; //Código de Mano de obra
                $TablaManodeobra[$NumMao][1] = $csvarray [$x][2]; //Unidad de Medida
                $TablaManodeobra[$NumMao][2] = $csvarray [$x][3]; //Cargo que ocupa
                $TablaManodeobra[$NumMao][3] = $csvarray [$x][4]; //Precio del la Mano de obra
                $NumMao++;
                break;
            case ("E"):
                $pos3 = substr($csvarray [$x][1], 3, 1);
                if (($pos3 == "#") && (strlen($csvarray [$x][1]) == 4))//Registro del tipo concepto Capítulo
                {

                    $TablaCapitulos[$NumCap][0] = $csvarray [$x][1]; //Código del Capitulo ENN#
                    $TablaCapitulos[$NumCap][1] = $csvarray [$x][3]; //Nombre del Capítulo. ¡Ojo! Campo 3 no 2.
                    $NumCap++;
                } else {
                    if (validateLetras($pos3) && (strlen($csvarray [$x][1]) == 5))//Registro del tipo concepto Subcapítulo
                    {

                        $TablaSubcapitulos[$NumSub][0] = $csvarray [$x][1]; //Código del Subcapitulo ENNA#
                        $TablaSubcapitulos[$NumSub][1] = $csvarray [$x][3]; //Nombre del Subcapítulo. ¡Ojo! Campo 3 no 2.
                        $NumSub++;

                    } else {
                        if (strlen($csvarray [$x][1]) > 5)//Registro del tipo Concepto Partida
                        {

                            $TablaPartidas[$NumPar][0] = $csvarray [$x][1]; //Código de la Partida E02AM010
                            $TablaPartidas[$NumPar][1] = $csvarray [$x][2]; //Unidad de Medida
                            $TablaPartidas[$NumPar][2] = $csvarray [$x][3]; //Nombre de la Partida.
                            $NumPar++;
                            break;
                        }
                    }
                }
        }

    } else {
        if ($csvarray [$x][0] == "~D") {
            if ((strlen($csvarray [$x][1]) > 5) && ($pos0 == "E" || $pos0 == "A") && (is_numeric($pos12))) { // TABLA PARTIDAS MATERIALES
                $WrdArray = explode("\\", $csvarray[$x][2]);
                $n = count($WrdArray);
                $n--; //El último campo siempre está en blanco "\ |"
                for ($z = 0; $z < $n; $z++) {
                    if ($i_par == 0 || $campo > 3) {
                        if ($i_par > 0) {
                            $pos12aux = substr($TablaParMat[$i_par][1], 1, 2);
                            $pos0aux = substr($TablaParMat[$i_par][1], 0, 1);
                            if (($pos0aux == "E" || $pos0aux == "A") && (strlen($TablaParMat[$i_par][1]) > 5) && (is_numeric($pos12aux))) {
                                $pp++;
                                $TablaParPar[$pp][0] = $TablaParMat[$i_par][0];
                                $TablaParPar[$pp][1] = $TablaParMat[$i_par][1];
                                $TablaParPar[$pp][2] = $TablaParMat[$i_par][2];
                                $TablaParPar[$pp][3] = $TablaParMat[$i_par][3];
                                $i_par--;

                            }
                        }

                        $i_par++;
                        $TablaParMat[$i_par][0] = $csvarray[$x][1]; //Campo 0
                        $campo = 1;
                    }
                    $TablaParMat[$i_par][$campo] = $WrdArray[$z]; //Campo 1, Campo2, Campo3
                    $campo++;
                }

            } else {

                if ($pos4 == "#" && strlen($csvarray [$x][1]) == 5) {    //TABLA SUBCAPITULOS PARTIDAS
                    $WrdArray = explode("\\", $csvarray[$x][2]);
                    $n = count($WrdArray);
                    $n--; //El último campo siempre está en blanco"\ |"

                    for ($z = 0; $z < $n; $z++) {

                        if ($sp == 0 || $campo > 3) {//antes < 0
                            $sp++;
                            $TablaSubPar[$sp][0] = $csvarray[$x][1];
                            $campo = 1;
                        }
                        if ($campo == 1 && substr($WrdArray[$z], 0, 1) == "E" && substr($WrdArray[$z], 4, 1) == "#" && strlen($WrdArray[$z]) == 5) {

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

                            if ($cp == 0 || $campo > 3 || $campo == 0) {//antes > 0
                                $cp++;
                                $TablaCapPar[$cp][0] = $csvarray[$x][1];
                                $campo = 1;
                            }

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
}
        $pos12aux = substr($TablaParMat[$i_par][1], 1, 2);
        $pos0aux = substr($TablaParMat[$i_par][1], 0, 1);
        if (($pos0aux == "E" || $pos0aux == "A") && (strlen($TablaParMat[$i_par][1]) > 5) && (is_numeric($pos12aux)))
        {
            $pp++;

            $TablaParPar[$pp][0] = $TablaParMat[$i_par][0];
            $TablaParPar[$pp][1] = $TablaParMat[$i_par][1];
            $TablaParPar[$pp][2] = $TablaParMat[$i_par][2];
            $TablaParPar[$pp][3] = $TablaParMat[$i_par][3];
            $i_par--;
        }
//*************************************************************
//******** ORDENAMOS TablaParMat
//**************************************************************

for($k=1;$k<=$i_par;$k++){

    for($m=0;$m<=3;$m++){
        if ($m == 1){

            $TablaParMat [$k]['MatMaqMao'] = $TablaParMat [$k][$m];
        }
    }
}
$aux = Array();
foreach($TablaParMat as &$MatMaqMao){
    $aux[] = &$MatMaqMao["MatMaqMao"];
}
array_multisort($aux, $TablaParMat);

//*************************************************************
//******** ORDENAMOS TablaSubSub
//**************************************************************
if ($ss>1) {
    for ($k = 1; $k <= $ss; $k++) {
        for ($m = 0; $m <= 3; $m++) {
            if ($m == 1) {
                $TablaSubSub [$k]['Subcapitulo'] = $TablaSubSub [$k][$m];
            }
        }
    }
    $aux = Array();
    foreach ($TablaSubSub as &$Subcapitulo) {
        $aux[] = &$TablaSubSub["Subcapitulo"];
    }
    array_multisort($aux, $TablaSubSub);
}else
{
    if ($ss==1){
        $TablaSubSub[0][0] = $TablaSubSub[1][0];
        $TablaSubSub[0][1] = $TablaSubSub[1][1];
        $TablaSubSub[0][2] = $TablaSubSub[1][2];
        $TablaSubSub[0][3] = $TablaSubSub[1][3];
        $TablaSubSub[1][0] = "";
        $TablaSubSub[1][1] = "";
        $TablaSubSub[1][2] = "";
        $TablaSubSub[1][3] = "";
    }
}
//*************************************************************
//******** ORDENAMOS TablaParPar
//**************************************************************
for($k=1;$k<=$pp;$k++){
    for($m=0;$m<=3;$m++){
        if ($m == 1){
            $TablaParPar [$k]['Partida'] = $TablaParPar [$k][$m];
        }
    }
}
$aux = Array();
foreach($TablaParPar as &$Partida){
    $aux[] = &$Partida["Partida"];
}
array_multisort($aux, $TablaParPar);

//***************************************************************
//********* GENERAMOS EL INFORME MATERIALES
//***************************************************************

for ($x=0;$x<$NumMat;$x++) {
    for($z=0;$z<14;$z++){
        $LineaInf[$inf][$z] = " ";
    }
    for ($y=0; $y<$i_par;$y++){
        if ($TablaMateriales[$x][0]==$TablaParMat [$y][1]) {
            $sw_parpar = FALSE;
            $j=1;
            for ($j=0; $j<$pp; $j++) {
                if ($TablaParPar[$j][1] == $TablaParMat[$y][0]){
                    $sw_parpar = TRUE;
                    $LineaInf[$inf][0]= $TablaMateriales[$x][0]; // Codigo del Material (0)
                    $LineaInf[$inf][1]= $TablaMateriales[$x][1]; // Unidad de Medida (1)
                    $LineaInf[$inf][2]= $TablaMateriales[$x][2]; // Nombre del Material (2)
                    $LineaInf[$inf][4]= $TablaMateriales[$x][3]; // Precio (4)
                    $LineaInf[$inf][3] = $TablaParMat[$y][3]; //Cantidad del material básico en la partida. (3)
                    $LineaInf[$inf][6] = $TablaParMat[$y][0]; //Partida asociada al material

                    $SuperCodigoCantidad = Null;
                    $SuperCodigoCantidad = Obtener_SupercodigoyCantidad($TablaParPar[$j][0], $TablaParPar[$j][1], $LineaInf[$inf][3], $TablaParPar, $pp);
                    if ($SuperCodigoCantidad[0] != Null) {
                        $LineaInf[$inf][6] = $SuperCodigoCantidad[0];//Codigo de la Partida de Mayor Rango (6)
                        $LineaInf[$inf][3] = $SuperCodigoCantidad[1];//Cantidad de Material Básico a nivel Partidas (3)
                    }

                    $NombreyUdPartida = Obtener_NombreyUdPartida($LineaInf[$inf][6], $TablaPartidas, $NumPar);
                    $LineaInf[$inf][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
                    $LineaInf[$inf][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)
                    $Aux_Cantidad3 = $LineaInf[$inf][3];
                    $LineasSub = 0;

                    $Aux_Partida6 = $LineaInf[$inf][6];
                    for ($h=1; $h<=$sp; $h++) {

                        if ($TablaSubPar[$h][1] == $Aux_Partida6) {
                            $LineasSub++;
                            if ($LineasSub > 1){
                                $LineaInf[$inf][0]= $LineaInf[$inf-1][0]; // Codigo del Material (0)
                                $LineaInf[$inf][1]= $LineaInf[$inf-1][1]; // Unidad de Medida (1)
                                $LineaInf[$inf][2]= $LineaInf[$inf-1][2]; // Nombre del Material (2)
                                $LineaInf[$inf][4]= $LineaInf[$inf-1][4]; // Precio (4)
                                $LineaInf[$inf][3]= $Aux_Cantidad3;
                                $LineaInf[$inf][6]= $LineaInf[$inf-1][6];
                                $LineaInf[$inf][7]= $LineaInf[$inf-1][7];
                                $LineaInf[$inf][8]= $LineaInf[$inf-1][8];

                            }
                            $LineaInf[$inf][10] = $TablaSubPar[$h][0]; //Código Subcapitulo Asociado a la Partida (10)
                            $LineaInf[$inf][3]  = $LineaInf[$inf][3] * $TablaSubPar[$h][3]; //Cantidad del Material Básico a nivel Subcapítulo (3)
                            $LineaInf[$inf][9]  = $TablaSubPar[$h][3]; //Cantidad en la Unidad de Material Básico Obra. (9)
                            $SuperCodigoCantidad = Null;
                            $SuperCodigoCantidad = Obtener_SupercodigoyCantidad(" ", $LineaInf[$inf][10], $LineaInf[$inf][3], $TablaSubSub, $ss);
                            if ($SuperCodigoCantidad[0] != Null) {
                                $LineaInf[$inf][10] = $SuperCodigoCantidad[0]; //Código Subcapitulo de Mayor Rango (10)
                                $LineaInf[$inf][3] = $SuperCodigoCantidad[1]; //Cantidad del Material Básico a nivel Subcapítulo (3)
                            }

                            $LineaInf[$inf][11] = Obtener_NombreSuboCap($LineaInf[$inf][10], $TablaSubcapitulos, $NumSub); //(11)
                            $CodigoCantidades = Obtener_CodigoCantidades($LineaInf[$inf][10], $LineaInf[$inf][3], $TablaCapSub, $cs);
                            $LineaInf[$inf][12] = $CodigoCantidades[0]; //Código del Capitulo (12)
                            $LineaInf[$inf][3] = $CodigoCantidades[1]; //Cantidad del Material Básico a nivel Capitulo (3).
                            $LineaInf[$inf][9] = $CodigoCantidades[2]; //Cantidad de Material Básico en la Unidad de Obra (9).
                            $LineaInf[$inf][5] = $LineaInf[$inf][3] * $LineaInf[$inf][4]; //Importe = Cantidad * Precio.(5)
                            $LineaInf[$inf][13] = Obtener_NombreSuboCap($LineaInf[$inf][12], $TablaCapitulos, $NumCap);//(13)
                            $inf++;//Partida-Material / Partida-Partida / Subcapitulo-Partida / Capitulo-Subcapitulo
                        }
                    }
                    If ($LineasSub ==0){

                        $Aux_Cantidad3 = $LineaInf[$inf][3];
                        $Aux_Partida6 = $LineaInf[$inf][6];
                        $LineasCap = 0;
                        for ($k = 1; $k <= $cp; $k++) { //Una partida asociada a diferentes capitulos.
                            if ($TablaCapPar[$k][1] == $Aux_Partida6)
                            {
                                $LineasCap++;
                                If ($LineasCap > 1) {
                                    $LineaInf[$inf][0] = $LineaInf[$inf - 1][0]; // Codigo del Material (0)
                                    $LineaInf[$inf][1] = $LineaInf[$inf - 1][1]; // Unidad de Medida (1)
                                    $LineaInf[$inf][2] = $LineaInf[$inf - 1][2]; // Nombre del Material (2)
                                    $LineaInf[$inf][4] = $LineaInf[$inf - 1][4]; // Precio (4)
                                    $LineaInf[$inf][3] = $Aux_Cantidad3;
                                    $LineaInf[$inf][6] = $Aux_Partida6;
                                    $LineaInf[$inf][7] = $LineaInf[$inf - 1][7];
                                    $LineaInf[$inf][8] = $LineaInf[$inf - 1][8];
                                }
                                $LineaInf[$inf][10] = " ";
                                $LineaInf[$inf][11] = " ";
                                $LineaInf[$inf][12] = $TablaCapPar [$k][0];
                                $LineaInf[$inf][3] = $LineaInf[$inf][3] *  $TablaCapPar [$k][3];
                                $LineaInf[$inf][9] = $TablaCapPar [$k][3];
                                $LineaInf[$inf][5] = $LineaInf[$inf][3] * $LineaInf[$inf][4]; //Importe = Cantidad * Precio.(5)
                                $LineaInf[$inf][13] = Obtener_NombreSuboCap($LineaInf[$inf][12], $TablaCapitulos, $NumCap);//(13)
                                $inf++; //Partida-Material / Partida-Partida / Capitulo-Partida
                            }
                        }

                    }

                }
            }
            If ($sw_parpar == FALSE){
                $LineaInf[$inf][0]= $TablaMateriales[$x][0]; // Codigo del Material (0)
                $LineaInf[$inf][1]= $TablaMateriales[$x][1]; // Unidad de Medida (1)
                $LineaInf[$inf][2]= $TablaMateriales[$x][2]; // Nombre del Material (2)
                $LineaInf[$inf][4]= $TablaMateriales[$x][3]; // Precio (4)
                $LineaInf[$inf][3] = $TablaParMat[$y][3]; //Cantidad del material básico en la partida. (3)
                $LineaInf[$inf][6] = $TablaParMat[$y][0]; //Partida asociada al material
                $Aux_Cantidad3 = $LineaInf[$inf][3];
                $LineasSub = 0;
                $Aux_Partida6 = $LineaInf[$inf][6];
                for ($h=1; $h<=$sp; $h++) {
                    if ($TablaSubPar[$h][1] == $Aux_Partida6) {
                        $LineasSub++;
                        if ($LineasSub > 1){
                            $LineaInf[$inf][0]= $LineaInf[$inf-1][0]; // Codigo del Material (0)
                            $LineaInf[$inf][1]= $LineaInf[$inf-1][1]; // Unidad de Medida (1)
                            $LineaInf[$inf][2]= $LineaInf[$inf-1][2]; // Nombre del Material (2)
                            $LineaInf[$inf][4]= $LineaInf[$inf-1][4]; // Precio (4)
                            $LineaInf[$inf][3]= $Aux_Cantidad3;
                            $LineaInf[$inf][6]= $LineaInf[$inf-1][6];
                            $LineaInf[$inf][7]= $LineaInf[$inf-1][7];
                            $LineaInf[$inf][8]= $LineaInf[$inf-1][8];

                        }
                        $NombreyUdPartida = Obtener_NombreyUdPartida($LineaInf[$inf][6], $TablaPartidas, $NumPar);
                        $LineaInf[$inf][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
                        $LineaInf[$inf][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)

                        $LineaInf[$inf][10] = $TablaSubPar[$h][0]; //Código Subcapitulo Asociado a la Partida (10)
                        $LineaInf[$inf][3]  = $LineaInf[$inf][3] * $TablaSubPar[$h][3]; //Cantidad del Material Básico a nivel Subcapítulo (3)
                        $LineaInf[$inf][9]  = $TablaSubPar[$h][3]; //Cantidad en la Unidad de Material Básico Obra. (9)
                        $SuperCodigoCantidad = Null;
                        $SuperCodigoCantidad = Obtener_SupercodigoyCantidad(" ", $LineaInf[$inf][10], $LineaInf[$inf][3], $TablaSubSub, $ss);
                        if ($SuperCodigoCantidad[0] != Null) {
                            $LineaInf[$inf][10] = $SuperCodigoCantidad[0]; //Código Subcapitulo de Mayor Rango (10)
                            $LineaInf[$inf][3] = $SuperCodigoCantidad[1]; //Cantidad del Material Básico a nivel Subcapítulo (3)
                        }
                        $LineaInf[$inf][11] = Obtener_NombreSuboCap($LineaInf[$inf][10], $TablaSubcapitulos, $NumSub); //(11)
                        $CodigoCantidades = Obtener_CodigoCantidades($LineaInf[$inf][10], $LineaInf[$inf][3], $TablaCapSub, $cs);
                        $LineaInf[$inf][12] = $CodigoCantidades[0]; //Código del Capitulo (12)
                        $LineaInf[$inf][3] = $CodigoCantidades[1]; //Cantidad del Material Básico a nivel Capitulo (3).
                        $LineaInf[$inf][9] = $CodigoCantidades[2]; //Cantidad de Material Básico en la Unidad de Obra (9).
                        $LineaInf[$inf][5] = $LineaInf[$inf][3] * $LineaInf[$inf][4]; //Importe = Cantidad * Precio.(5)
                        $LineaInf[$inf][13] = Obtener_NombreSuboCap($LineaInf[$inf][12], $TablaCapitulos, $NumCap);//(13)
                        $inf++; //Partida-Material / Subcapitulo-Partida / Capitulo-Subcapitulo
                    }
                }
                If ($LineasSub ==0) {


                    for ($k = 1; $k <= $cp; $k++) { //Una partida asociada a diferentes capitulos.
                        if ($TablaCapPar[$k][1] == $TablaParMat[$y][0]) {

                            $LineaInf[$inf][10] = " ";
                            $LineaInf[$inf][11] = " ";
                            $LineaInf[$inf][0] = $TablaMateriales[$x][0]; // Codigo del Material (0)
                            $LineaInf[$inf][1] = $TablaMateriales[$x][1]; // Unidad de Medida (1)
                            $LineaInf[$inf][2] = $TablaMateriales[$x][2]; // Nombre del Material (2)
                            $LineaInf[$inf][4] = $TablaMateriales[$x][3]; // Precio (4)
                            $LineaInf[$inf][3] = $TablaParMat[$y][3]; //Cantidad del material básico en la partida. (3)
                            $LineaInf[$inf][6] = $TablaParMat[$y][0]; //Partida asociada al material
                            $NombreyUdPartida = Obtener_NombreyUdPartida($LineaInf[$inf][6], $TablaPartidas, $NumPar);
                            $LineaInf[$inf][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
                            $LineaInf[$inf][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)
                            $LineaInf[$inf][12] = $TablaCapPar [$k][0];
                            $LineaInf[$inf][3] = $LineaInf[$inf][3] *  $TablaCapPar [$k][3];
                            $LineaInf[$inf][9] = $TablaCapPar [$k][3];
                            $LineaInf[$inf][5] = $LineaInf[$inf][3] * $LineaInf[$inf][4]; //Importe = Cantidad * Precio.(5)
                            $LineaInf[$inf][13] = Obtener_NombreSuboCap($LineaInf[$inf][12], $TablaCapitulos, $NumCap);//(13)
                            $inf++; //Partida-Material / Capitulo-Partida
                        }
                    }
                }
            }


        }
    }

}

//***************************************************************
//********* GENERAMOS EL INFORME MAQUINARIA
//***************************************************************
for ($x=0;$x<$NumMaq;$x++) {
    for($z=0;$z<14;$z++){
        $LineaInf1[$inf1][$z] = " ";
    }
    for ($y=0; $y<$i_par;$y++){
        if ($TablaMaquinaria[$x][0]==$TablaParMat [$y][1]) {
            $sw_parpar = FALSE;
            $j=1;
            for ($j=0; $j<$pp; $j++) {
                if ($TablaParPar[$j][1] == $TablaParMat[$y][0]){
                    $sw_parpar = TRUE;
                    $LineaInf1[$inf1][0]= $TablaMaquinaria[$x][0]; // Codigo de Maquinaria  (0)
                    $LineaInf1[$inf1][1]= $TablaMaquinaria[$x][1]; // Unidad de Medida (1)
                    $LineaInf1[$inf1][2]= $TablaMaquinaria[$x][2]; // Nombre de Maquinaria  (2)
                    $LineaInf1[$inf1][4]= $TablaMaquinaria[$x][3]; // Precio (4)
                    $LineaInf1[$inf1][3] = $TablaParMat[$y][3]; //Cantidad del maquinaria en la partida. (3)
                    $LineaInf1[$inf1][6] = $TablaParMat[$y][0]; //Partida asociada a la maquinaria

                    $SuperCodigoCantidad = Null;
                    $SuperCodigoCantidad = Obtener_SupercodigoyCantidad($TablaParPar[$j][0], $TablaParPar[$j][1], $LineaInf1[$inf1][3], $TablaParPar, $pp);
                    if ($SuperCodigoCantidad[0] != Null) {
                        $LineaInf1[$inf1][6] = $SuperCodigoCantidad[0];//Codigo de la Partida de Mayor Rango (6)
                        $LineaInf1[$inf1][3] = $SuperCodigoCantidad[1];//Cantidad de Maquinaria a nivel Partidas (3)
                    }

                    $NombreyUdPartida = Obtener_NombreyUdPartida($LineaInf1[$inf1][6], $TablaPartidas, $NumPar);
                    $LineaInf1[$inf1][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
                    $LineaInf1[$inf1][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)
                    $Aux_Cantidad3 = $LineaInf1[$inf1][3];
                    $LineasSub = 0;

                    $Aux_Partida6 = $LineaInf1[$inf1][6];
                    for ($h=1; $h<=$sp; $h++) {

                        if ($TablaSubPar[$h][1] == $Aux_Partida6) {
                            $LineasSub++;
                            if ($LineasSub > 1){
                                $LineaInf1[$inf1][0]= $LineaInf1[$inf1-1][0]; // Codigo de Maquinaria (0)
                                $LineaInf1[$inf1][1]= $LineaInf1[$inf1-1][1]; // Unidad de Medida (1)
                                $LineaInf1[$inf1][2]= $LineaInf1[$inf1-1][2]; // Nombre de Maquinaria (2)
                                $LineaInf1[$inf1][4]= $LineaInf1[$inf1-1][4]; // Precio (4)
                                $LineaInf1[$inf1][3]= $Aux_Cantidad3;
                                $LineaInf1[$inf1][6]= $LineaInf1[$inf1-1][6];
                                $LineaInf1[$inf1][7]= $LineaInf1[$inf1-1][7];
                                $LineaInf1[$inf1][8]= $LineaInf1[$inf1-1][8];

                            }
                            $LineaInf1[$inf1][10] = $TablaSubPar[$h][0]; //Código Subcapitulo Asociado a la Partida (10)
                            $LineaInf1[$inf1][3]  = $LineaInf1[$inf1][3] * $TablaSubPar[$h][3]; //Cantidad del Maquinaria a nivel Subcapítulo (3)
                            $LineaInf1[$inf1][9]  = $TablaSubPar[$h][3]; //Cantidad en la Unidad de Maquinaria Obra. (9)
                            $SuperCodigoCantidad = Null;
                            $SuperCodigoCantidad = Obtener_SupercodigoyCantidad(" ", $LineaInf1[$inf1][10], $LineaInf1[$inf1][3], $TablaSubSub, $ss);
                            if ($SuperCodigoCantidad[0] != Null) {
                                $LineaInf1[$inf1][10] = $SuperCodigoCantidad[0]; //Código Subcapitulo de Mayor Rango (10)
                                $LineaInf1[$inf1][3] = $SuperCodigoCantidad[1]; //Cantidad de Maquinaria a nivel Subcapítulo (3)
                            }

                            $LineaInf1[$inf1][11] = Obtener_NombreSuboCap($LineaInf1[$inf1][10], $TablaSubcapitulos, $NumSub); //(11)
                            $CodigoCantidades = Obtener_CodigoCantidades($LineaInf1[$inf1][10], $LineaInf1[$inf1][3], $TablaCapSub, $cs);
                            $LineaInf1[$inf1][12] = $CodigoCantidades[0]; //Código del Capitulo (12)
                            $LineaInf1[$inf1][3] = $CodigoCantidades[1]; //Cantidad de Maquinaria a nivel Capitulo (3).
                            $LineaInf1[$inf1][9] = $CodigoCantidades[2]; //Cantidad de Maquinaria en la Unidad de Obra (9).
                            $LineaInf1[$inf1][5] = $LineaInf1[$inf1][3] * $LineaInf1[$inf1][4]; //Importe = Cantidad * Precio.(5)
                            $LineaInf1[$inf1][13] = Obtener_NombreSuboCap($LineaInf1[$inf1][12], $TablaCapitulos, $NumCap);//(13)
                            $inf1++;//Partida-Maquinaria / Partida-Partida / Subcapitulo-Partida / Capitulo-Subcapitulo
                        }
                    }
                    If ($LineasSub ==0){

                        $Aux_Cantidad3 = $LineaInf1[$inf1][3];
                        $Aux_Partida6 = $LineaInf1[$inf1][6];
                        $LineasCap = 0;
                        for ($k = 1; $k <= $cp; $k++) { //Una partida asociada a diferentes capitulos.
                            if ($TablaCapPar[$k][1] == $Aux_Partida6)
                            {
                                $LineasCap++;
                                If ($LineasCap > 1) {
                                    $LineaInf1[$inf1][0] = $LineaInf1[$inf1 - 1][0]; // Codigo de Maquinaria (0)
                                    $LineaInf1[$inf1][1] = $LineaInf1[$inf1 - 1][1]; // Unidad de Medida (1)
                                    $LineaInf1[$inf1][2] = $LineaInf1[$inf1 - 1][2]; // Nombre de Maquinaria (2)
                                    $LineaInf1[$inf1][4] = $LineaInf1[$inf1 - 1][4]; // Precio (4)
                                    $LineaInf1[$inf1][3] = $Aux_Cantidad3;
                                    $LineaInf1[$inf1][6] = $Aux_Partida6;
                                    $LineaInf1[$inf1][7] = $LineaInf1[$inf1 - 1][7];
                                    $LineaInf1[$inf1][8] = $LineaInf1[$inf1 - 1][8];
                                }
                                $LineaInf1[$inf1][10] = " ";
                                $LineaInf1[$inf1][11] = " ";
                                $LineaInf1[$inf1][12] = $TablaCapPar [$k][0];
                                $LineaInf1[$inf1][3] = $LineaInf1[$inf1][3] *  $TablaCapPar [$k][3];
                                $LineaInf1[$inf1][9] = $TablaCapPar [$k][3];
                                $LineaInf1[$inf1][5] = $LineaInf1[$inf1][3] * $LineaInf1[$inf1][4]; //Importe = Cantidad * Precio.(5)
                                $LineaInf1[$inf1][13] = Obtener_NombreSuboCap($LineaInf1[$inf1][12], $TablaCapitulos, $NumCap);//(13)
                                $inf1++; //Partida-Maquinaria / Partida-Partida / Capitulo-Partida
                            }
                        }

                    }

                }
            }
            If ($sw_parpar == FALSE){
                $LineaInf1[$inf1][0]= $TablaMaquinaria[$x][0]; // Codigo del Maquinaria (0)
                $LineaInf1[$inf1][1]= $TablaMaquinaria[$x][1]; // Unidad de Medida (1)
                $LineaInf1[$inf1][2]= $TablaMaquinaria[$x][2]; // Nombre del Maquinaria (2)
                $LineaInf1[$inf1][4]= $TablaMaquinaria[$x][3]; // Precio (4)
                $LineaInf1[$inf1][3] = $TablaParMat[$y][3]; //Cantidad de Maquinaria en la partida. (3)
                $LineaInf1[$inf1][6] = $TablaParMat[$y][0]; //Partida asociada a la Maquinaria
                $Aux_Cantidad3 = $LineaInf1[$inf1][3];
                $LineasSub = 0;
                $Aux_Partida6 = $LineaInf1[$inf1][6];
                for ($h=1; $h<=$sp; $h++) {
                    if ($TablaSubPar[$h][1] == $Aux_Partida6) {
                        $LineasSub++;
                        if ($LineasSub > 1){
                            $LineaInf1[$inf1][0]= $LineaInf1[$inf1-1][0]; // Codigo de Maquinaria (0)
                            $LineaInf1[$inf1][1]= $LineaInf1[$inf1-1][1]; // Unidad de Medida (1)
                            $LineaInf1[$inf1][2]= $LineaInf1[$inf1-1][2]; // Nombre de Maquinaria (2)
                            $LineaInf1[$inf1][4]= $LineaInf1[$inf1-1][4]; // Precio (4)
                            $LineaInf1[$inf1][3]= $Aux_Cantidad3;
                            $LineaInf1[$inf1][6]= $LineaInf1[$inf1-1][6];
                            $LineaInf1[$inf1][7]= $LineaInf1[$inf1-1][7];
                            $LineaInf1[$inf1][8]= $LineaInf1[$inf1-1][8];

                        }
                        $NombreyUdPartida = Obtener_NombreyUdPartida($LineaInf1[$inf1][6], $TablaPartidas, $NumPar);
                        $LineaInf1[$inf1][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
                        $LineaInf1[$inf1][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)

                        $LineaInf1[$inf1][10] = $TablaSubPar[$h][0]; //Código Subcapitulo Asociado a la Partida (10)
                        $LineaInf1[$inf1][3]  = $LineaInf1[$inf1][3] * $TablaSubPar[$h][3]; //Cantidad de Maquinaria a nivel Subcapítulo (3)
                        $LineaInf1[$inf1][9]  = $TablaSubPar[$h][3]; //Cantidad en la Unidad de Maquinaria (9)
                        $SuperCodigoCantidad = Null;
                        $SuperCodigoCantidad = Obtener_SupercodigoyCantidad(" ", $LineaInf1[$inf1][10], $LineaInf1[$inf1][3], $TablaSubSub, $ss);
                        if ($SuperCodigoCantidad[0] != Null) {
                            $LineaInf1[$inf1][10] = $SuperCodigoCantidad[0]; //Código Subcapitulo de Mayor Rango (10)
                            $LineaInf1[$inf1][3] = $SuperCodigoCantidad[1]; //Cantidad del Maquinaria a nivel Subcapítulo (3)
                        }

                        $LineaInf1[$inf1][11] = Obtener_NombreSuboCap($LineaInf1[$inf1][10], $TablaSubcapitulos, $NumSub); //(11)
                        $CodigoCantidades = Obtener_CodigoCantidades($LineaInf1[$inf1][10], $LineaInf1[$inf1][3], $TablaCapSub, $cs);
                        $LineaInf1[$inf1][12] = $CodigoCantidades[0]; //Código del Capitulo (12)
                        $LineaInf1[$inf1][3] = $CodigoCantidades[1]; //Cantidad del Maquinaria a nivel Capitulo (3).
                        $LineaInf1[$inf1][9] = $CodigoCantidades[2]; //Cantidad de Maquinaria en la Unidad de Obra (9).
                        $LineaInf1[$inf1][5] = $LineaInf1[$inf1][3] * $LineaInf1[$inf1][4]; //Importe = Cantidad * Precio.(5)
                        $LineaInf1[$inf1][13] = Obtener_NombreSuboCap($LineaInf1[$inf1][12], $TablaCapitulos, $NumCap);//(13)
                        $inf1++; //Partida-Maquinaria / Subcapitulo-Partida / Capitulo-Subcapitulo
                    }
                }
                If ($LineasSub ==0) {


                    for ($k = 1; $k <= $cp; $k++) { //Una partida asociada a diferentes capitulos.
                        if ($TablaCapPar[$k][1] == $TablaParMat[$y][0]) {

                            $LineaInf1[$inf1][10] = " ";
                            $LineaInf1[$inf1][11] = " ";
                            $LineaInf1[$inf1][0] = $TablaMaquinaria[$x][0]; // Codigo de Maquinaria (0)
                            $LineaInf1[$inf1][1] = $TablaMaquinaria[$x][1]; // Unidad de Medida (1)
                            $LineaInf1[$inf1][2] = $TablaMaquinaria[$x][2]; // Nombre del Maquinaria (2)
                            $LineaInf1[$inf1][4] = $TablaMaquinaria[$x][3]; // Precio (4)
                            $LineaInf1[$inf1][3] = $TablaParMat[$y][3]; //Cantidad de maquinaria básico en la partida. (3)
                            $LineaInf1[$inf1][6] = $TablaParMat[$y][0]; //Partida asociada a la maquinari
                            $NombreyUdPartida = Obtener_NombreyUdPartida($LineaInf1[$inf1][6], $TablaPartidas, $NumPar);
                            $LineaInf1[$inf1][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
                            $LineaInf1[$inf1][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)
                            $LineaInf1[$inf1][12] = $TablaCapPar [$k][0];
                            $LineaInf1[$inf1][3] = $LineaInf1[$inf1][3] *  $TablaCapPar [$k][3];
                            $LineaInf1[$inf1][9] = $TablaCapPar [$k][3];
                            $LineaInf1[$inf1][5] = $LineaInf1[$inf1][3] * $LineaInf1[$inf1][4]; //Importe = Cantidad * Precio.(5)
                            $LineaInf1[$inf1][13] = Obtener_NombreSuboCap($LineaInf1[$inf1][12], $TablaCapitulos, $NumCap);//(13)
                            $inf1++; //Partida-Maquinaria / Capitulo-Partida
                        }
                    }
                }
            }


        }
    }

}


//***************************************************************
//********* GENERAMOS EL INFORME MANO DE OBRA
//***************************************************************

for ($x=0;$x<$NumMao;$x++) {
    for($z=0;$z<14;$z++){
        $LineaInf2[$inf2][$z] = " ";
    }
    for ($y=0; $y<$i_par;$y++){
        if ($TablaManodeobra[$x][0]==$TablaParMat [$y][1]) {
            $sw_parpar = FALSE;
            $j=1;
            for ($j=0; $j<$pp; $j++) {
                if ($TablaParPar[$j][1] == $TablaParMat[$y][0]){
                    $sw_parpar = TRUE;
                    $LineaInf2[$inf2][0]= $TablaManodeobra[$x][0]; // Codigo Mano de Obra (0)
                    $LineaInf2[$inf2][1]= $TablaManodeobra[$x][1]; // Unidad de Medida (1)
                    $LineaInf2[$inf2][2]= $TablaManodeobra[$x][2]; // Nombre Mano de obra (2)
                    $LineaInf2[$inf2][4]= $TablaManodeobra[$x][3]; // Precio (4)
                    $LineaInf2[$inf2][3] = $TablaParMat[$y][3]; //Cantidad del Mano de Obra en la partida. (3)
                    $LineaInf2[$inf2][6] = $TablaParMat[$y][0]; //Partida asociada a la Mano de Obra

                    $SuperCodigoCantidad = Null;
                    $SuperCodigoCantidad = Obtener_SupercodigoyCantidad($TablaParPar[$j][0], $TablaParPar[$j][1], $LineaInf2[$inf2][3], $TablaParPar, $pp);
                    if ($SuperCodigoCantidad[0] != Null) {
                        $LineaInf2[$inf2][6] = $SuperCodigoCantidad[0];//Codigo de la Partida de Mayor Rango (6)
                        $LineaInf2[$inf2][3] = $SuperCodigoCantidad[1];//Cantidad de Mano de Obra a nivel Partidas (3)
                    }

                    $NombreyUdPartida = Obtener_NombreyUdPartida($LineaInf2[$inf2][6], $TablaPartidas, $NumPar);
                    $LineaInf2[$inf2][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
                    $LineaInf2[$inf2][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)
                    $Aux_Cantidad3 = $LineaInf2[$inf2][3];
                    $LineasSub = 0;

                    $Aux_Partida6 = $LineaInf2[$inf2][6];
                    for ($h=1; $h<=$sp; $h++) {

                        if ($TablaSubPar[$h][1] == $Aux_Partida6) {
                            $LineasSub++;
                            if ($LineasSub > 1){
                                $LineaInf2[$inf2][0]= $LineaInf2[$inf2-1][0]; // Codigo de Mano de Obra (0)
                                $LineaInf2[$inf2][1]= $LineaInf2[$inf2-1][1]; // Unidad de Medida (1)
                                $LineaInf2[$inf2][2]= $LineaInf2[$inf2-1][2]; // Nombre de  Mano de Obra (2)
                                $LineaInf2[$inf2][4]= $LineaInf2[$inf2-1][4]; // Precio (4)
                                $LineaInf2[$inf2][3]= $Aux_Cantidad3;
                                $LineaInf2[$inf2][6]= $LineaInf2[$inf2-1][6];
                                $LineaInf2[$inf2][7]= $LineaInf2[$inf2-1][7];
                                $LineaInf2[$inf2][8]= $LineaInf2[$inf2-1][8];

                            }
                            $LineaInf2[$inf2][10] = $TablaSubPar[$h][0]; //Código Subcapitulo Asociado a la Partida (10)
                            $LineaInf2[$inf2][3]  = $LineaInf2[$inf2][3] * $TablaSubPar[$h][3]; //Cantidad del Mano de Obra a nivel Subcapítulo (3)
                            $LineaInf2[$inf2][9]  = $TablaSubPar[$h][3]; //Cantidad en la Unidad de Mano de Obra. (9)
                            $SuperCodigoCantidad = Null;
                            $SuperCodigoCantidad = Obtener_SupercodigoyCantidad(" ", $LineaInf2[$inf2][10], $LineaInf2[$inf2][3], $TablaSubSub, $ss);
                            if ($SuperCodigoCantidad[0] != Null) {
                                $LineaInf2[$inf2][10] = $SuperCodigoCantidad[0]; //Código Subcapitulo de Mayor Rango (10)
                                $LineaInf2[$inf2][3] = $SuperCodigoCantidad[1]; //Cantidad de Mano de Obra a nivel Subcapítulo (3)
                            }

                            $LineaInf2[$inf2][11] = Obtener_NombreSuboCap($LineaInf2[$inf2][10], $TablaSubcapitulos, $NumSub); //(11)
                            $CodigoCantidades = Obtener_CodigoCantidades($LineaInf2[$inf2][10], $LineaInf2[$inf2][3], $TablaCapSub, $cs);
                            $LineaInf2[$inf2][12] = $CodigoCantidades[0]; //Código del Capitulo (12)
                            $LineaInf2[$inf2][3] = $CodigoCantidades[1]; //Cantidad de Mano de Obra a nivel Capitulo (3).
                            $LineaInf2[$inf2][9] = $CodigoCantidades[2]; //Cantidad de Mano de Obra en la Unidad (9).
                            $LineaInf2[$inf2][5] = $LineaInf2[$inf2][3] * $LineaInf2[$inf2][4]; //Importe = Cantidad * Precio.(5)
                            $LineaInf2[$inf2][13] = Obtener_NombreSuboCap($LineaInf2[$inf2][12], $TablaCapitulos, $NumCap);//(13)
                            $inf2++;//Partida-Mano de Obra / Partida-Partida / Subcapitulo-Partida / Capitulo-Subcapitulo
                        }
                    }
                    If ($LineasSub ==0){

                        $Aux_Cantidad3 = $LineaInf2[$inf2][3];
                        $Aux_Partida6 = $LineaInf2[$inf2][6];
                        $LineasCap = 0;
                        for ($k = 1; $k <= $cp; $k++) { //Una partida asociada a diferentes capitulos.
                            if ($TablaCapPar[$k][1] == $Aux_Partida6)
                            {
                                $LineasCap++;
                                If ($LineasCap > 1) {
                                    $LineaInf2[$inf2][0] = $LineaInf2[$inf2 - 1][0]; // Codigo de la Mano de Obra (0)
                                    $LineaInf2[$inf2][1] = $LineaInf2[$inf2 - 1][1]; // Unidad de Medida (1)
                                    $LineaInf2[$inf2][2] = $LineaInf2[$inf2 - 1][2]; // Nombre de Mano de Obra (2)
                                    $LineaInf2[$inf2][4] = $LineaInf2[$inf2 - 1][4]; // Precio (4)
                                    $LineaInf2[$inf2][3] = $Aux_Cantidad3;
                                    $LineaInf2[$inf2][6] = $Aux_Partida6;
                                    $LineaInf2[$inf2][7] = $LineaInf2[$inf2 - 1][7];
                                    $LineaInf2[$inf2][8] = $LineaInf2[$inf2 - 1][8];
                                }
                                $LineaInf2[$inf2][10] = " ";
                                $LineaInf2[$inf2][11] = " ";
                                $LineaInf2[$inf2][12] = $TablaCapPar [$k][0];
                                $LineaInf2[$inf2][3] = $LineaInf2[$inf2][3] *  $TablaCapPar [$k][3];
                                $LineaInf2[$inf2][9] = $TablaCapPar [$k][3];
                                $LineaInf2[$inf2][5] = $LineaInf2[$inf2][3] * $LineaInf2[$inf2][4]; //Importe = Cantidad * Precio.(5)
                                $LineaInf2[$inf2][13] = Obtener_NombreSuboCap($LineaInf2[$inf2][12], $TablaCapitulos, $NumCap);//(13)
                                $inf2++; //Partida-Mano de Obra / Partida-Partida / Capitulo-Partida
                            }
                        }

                    }

                }
            }
            If ($sw_parpar == FALSE){
                $LineaInf2[$inf2][0]= $TablaManodeobra[$x][0]; // Codigo de Mano de Obra (0)
                $LineaInf2[$inf2][1]= $TablaManodeobra[$x][1]; // Unidad de Medida (1)
                $LineaInf2[$inf2][2]= $TablaManodeobra[$x][2]; // Nombre de Mano de Obra (2)
                $LineaInf2[$inf2][4]= $TablaManodeobra[$x][3]; // Precio (4)
                $LineaInf2[$inf2][3] = $TablaParMat[$y][3]; //Cantidad de Mano de Obra en la partida. (3)
                $LineaInf2[$inf2][6] = $TablaParMat[$y][0]; //Partida asociada a la Mano de Obra
                $Aux_Cantidad3 = $LineaInf2[$inf2][3];
                $LineasSub = 0;
                $Aux_Partida6 = $LineaInf2[$inf2][6];
                for ($h=1; $h<=$sp; $h++) {
                    if ($TablaSubPar[$h][1] == $Aux_Partida6) {
                        $LineasSub++;
                        if ($LineasSub > 1){
                            $LineaInf2[$inf2][0]= $LineaInf2[$inf2-1][0]; // Codigo de Mano de Obra (0)
                            $LineaInf2[$inf2][1]= $LineaInf2[$inf2-1][1]; // Unidad de Mano de Obra (1)
                            $LineaInf2[$inf2][2]= $LineaInf2[$inf2-1][2]; // Nombre de Mano de Obra(2)
                            $LineaInf2[$inf2][4]= $LineaInf2[$inf2-1][4]; // Precio (4)
                            $LineaInf2[$inf2][3]= $Aux_Cantidad3;
                            $LineaInf2[$inf2][6]= $LineaInf2[$inf2-1][6];
                            $LineaInf2[$inf2][7]= $LineaInf2[$inf2-1][7];
                            $LineaInf2[$inf2][8]= $LineaInf2[$inf2-1][8];

                        }
                        $NombreyUdPartida = Obtener_NombreyUdPartida($LineaInf2[$inf2][6], $TablaPartidas, $NumPar);
                        $LineaInf2[$inf2][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
                        $LineaInf2[$inf2][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)

                        $LineaInf2[$inf2][10] = $TablaSubPar[$h][0]; //Código Subcapitulo Asociado a la Partida (10)
                        $LineaInf2[$inf2][3]  = $LineaInf2[$inf2][3] * $TablaSubPar[$h][3]; //Cantidad de Mano de Obra a nivel Subcapítulo (3)
                        $LineaInf2[$inf2][9]  = $TablaSubPar[$h][3]; //Cantidad en la Unidad de Mano de Obra. (9)
                        $SuperCodigoCantidad = Null;
                        $SuperCodigoCantidad = Obtener_SupercodigoyCantidad(" ", $LineaInf2[$inf2][10], $LineaInf2[$inf2][3], $TablaSubSub, $ss);
                        if ($SuperCodigoCantidad[0] != Null) {
                            $LineaInf2[$inf2][10] = $SuperCodigoCantidad[0]; //Código Subcapitulo de Mayor Rango (10)
                            $LineaInf2[$inf2][3] = $SuperCodigoCantidad[1]; //Cantidad de Mano de Obra a nivel Subcapítulo (3)
                        }
                        $LineaInf2[$inf2][11] = Obtener_NombreSuboCap($LineaInf2[$inf2][10], $TablaSubcapitulos, $NumSub); //(11)
                        $CodigoCantidades = Obtener_CodigoCantidades($LineaInf2[$inf2][10], $LineaInf2[$inf2][3], $TablaCapSub, $cs);
                        $LineaInf2[$inf2][12] = $CodigoCantidades[0]; //Código del Capitulo (12)
                        $LineaInf2[$inf2][3] = $CodigoCantidades[1]; //Cantidad de Mano de Obra a nivel Capitulo (3).
                        $LineaInf2[$inf2][9] = $CodigoCantidades[2]; //Cantidad de Mano de Obra en la Unidad de Obra (9).
                        $LineaInf2[$inf2][5] = $LineaInf2[$inf2][3] * $LineaInf2[$inf2][4]; //Importe = Cantidad * Precio.(5)
                        $LineaInf2[$inf2][13] = Obtener_NombreSuboCap($LineaInf2[$inf2][12], $TablaCapitulos, $NumCap);//(13)
                        $inf2++; //Partida-Mano de Obra / Subcapitulo-Partida / Capitulo-Subcapitulo
                    }
                }
                If ($LineasSub ==0) {


                    for ($k = 1; $k <= $cp; $k++) { //Una partida asociada a diferentes capitulos.
                        if ($TablaCapPar[$k][1] == $TablaParMat[$y][0]) {

                            $LineaInf2[$inf2][10] = " ";
                            $LineaInf2[$inf2][11] = " ";
                            $LineaInf2[$inf2][0] = $TablaManodeobra[$x][0]; // Codigo Mano de Obra(0)
                            $LineaInf2[$inf2][1] = $TablaManodeobra[$x][1]; // Unidad de Medida (1)
                            $LineaInf2[$inf2][2] = $TablaManodeobra[$x][2]; // Nombre Mano de Obra(2)
                            $LineaInf2[$inf2][4] = $TablaManodeobra[$x][3]; // Precio (4)
                            $LineaInf2[$inf2][3] = $TablaParMat[$y][3]; //Cantidad de Mano de Obra en la partida. (3)
                            $LineaInf2[$inf2][6] = $TablaParMat[$y][0]; //Partida asociada a la Mano de Obra
                            $NombreyUdPartida = Obtener_NombreyUdPartida($LineaInf2[$inf2][6], $TablaPartidas, $NumPar);
                            $LineaInf2[$inf2][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
                            $LineaInf2[$inf2][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)
                            $LineaInf2[$inf2][12] = $TablaCapPar [$k][0];
                            $LineaInf2[$inf2][3] = $LineaInf2[$inf2][3] *  $TablaCapPar [$k][3];
                            $LineaInf2[$inf2][9] = $TablaCapPar [$k][3];
                            $LineaInf2[$inf2][5] = $LineaInf2[$inf2][3] * $LineaInf2[$inf2][4]; //Importe = Cantidad * Precio.(5)
                            $LineaInf2[$inf2][13] = Obtener_NombreSuboCap($LineaInf2[$inf2][12], $TablaCapitulos, $NumCap);//(13)
                            $inf2++; //Partida-Mano de Obra / Capitulo-Partida
                        }
                    }
                }
            }


        }
    }

}
//***************************************************************
//********* FUNCIONES UTILIZADAS EN PHP LA GENERACIÓN DE INFORMES
//***************************************************************
function Obtener_SupercodigoYCantidad($Aux_Supercodigo, $Aux_Codigo, $Aux_Cantidad, $Aux_Tabla, $Aux_indice)
{
    $Aux_CodigoCantidad [0]=0;
    $Aux_CodigoCantidad [1]=0;
    for ($y = 0; $y < $Aux_indice; $y++) {

        if (($Aux_Supercodigo == $Aux_Tabla[$y][0] || $Aux_Supercodigo == " ")  && $Aux_Codigo == $Aux_Tabla[$y][1]) {
            $Aux_Codigo = $Aux_Tabla[$y][0];
            $Aux_Cantidad = $Aux_Cantidad * $Aux_Tabla[$y][3]; //Ojo lo está multiplicando 2 veces.

            $y =0;
            $Aux_CodigoCantidad[0] = $Aux_Codigo;
            $Aux_CodigoCantidad[1] = $Aux_Cantidad;
            $Aux_Supercodigo = " ";
        }
    }
    return ($Aux_CodigoCantidad);
}

function Obtener_NombreyUdPartida($Aux_Codigo, $Aux_Tabla,$Aux_indice)
{
    for ($y=0;$y<$Aux_indice;$y++) {

        if ($Aux_Codigo == $Aux_Tabla[$y][0]) {
            $Aux_UdNombre[0] = $Aux_Tabla[$y][1];
            $Aux_UdNombre[1] = $Aux_Tabla[$y][2];
            return ($Aux_UdNombre);
        }
    }
}

function Obtener_CodigoCantidades($Aux_Codigo, $Aux_Cantidad, $Aux_Tabla, $Aux_indice)
{
    $Aux_CodigoCantidad[0]=0;
    $Aux_CodigoCantidad[1]=0;
    $Aux_CodigoCantidad[2]=0;

    for ($y = 1; $y <= $Aux_indice; $y++) {

        if ($Aux_Codigo == $Aux_Tabla[$y][1]) {

            $Aux_CodigoCantidad[0] = $Aux_Tabla[$y][0];
            $Aux_CodigoCantidad[1] = $Aux_Cantidad * $Aux_Tabla[$y][3];
            $Aux_CodigoCantidad[2] = $Aux_Tabla[$y][3];
            return ($Aux_CodigoCantidad);
        }
    }
}

function Obtener_NombreSuboCap($Aux_Codigo, $Aux_Tabla, $Aux_indice)
{
    for ($y = 0; $y < $Aux_indice; $y++) {

        if ($Aux_Codigo == $Aux_Tabla[$y][0]) {
            return ($Aux_Tabla[$y][1]);
        }
    }
}

//***************************************************
//**** TABLAS GENERADAS A PARTIR DEL BC3 DE ENTRADA
//***************************************************
/*echo "<br>";
echo "Materiales: NumMat: " . $NumMat . "<br>";
for ($x = 0; $x < $NumMat; $x++) {
    echo $x. " ". $TablaMateriales[$x][0] . " " . $TablaMateriales[$x][1] . " " . $TablaMateriales[$x][2] . " " . $TablaMateriales[$x][3];
    echo "<br>";
}
echo "<br>";
echo "Maquinaria: NumMaq: " . $NumMaq . "<br>";
for ($x = 0; $x < $NumMaq; $x++) {
    echo $x. " ".$TablaMaquinaria[$x][0] . " " . $TablaMaquinaria[$x][1] . " " . $TablaMaquinaria[$x][2] . " " . $TablaMaquinaria[$x][3];
    echo "<br>";
}
echo "<br>";
echo "ManodeObra: NumMao: " . $NumMao . "<br>";
for ($x = 0; $x < $NumMao; $x++) {
    echo $x. " ".$TablaManodeobra[$x][0] . " " . $TablaManodeobra[$x][1] . " " . $TablaManodeobra[$x][2] . " " . $TablaManodeobra[$x][3];
    echo "<br>";
}
echo "<br>";
echo "Capitulos: NumCap: " . $NumCap . " <br>";
for ($x = 0; $x < $NumCap; $x++) {
    echo $x. " ".$TablaCapitulos[$x][0] . " " . $TablaCapitulos[$x][1];
    echo "<br>";
}
echo "<br>";
echo "Subcapitulos: NumSub: " . $NumSub . " <br>";
for ($x = 0; $x < $NumSub; $x++) {
    echo $x. " ".$TablaSubcapitulos[$x][0] . " " . $TablaSubcapitulos[$x][1];
    echo "<br>";
}
echo "<br>";
echo "Partidas: NumPar: " . $NumPar . "<br>";
for ($x = 0; $x < $NumPar; $x++) {
    echo $x. " ".$TablaPartidas[$x][0] . " " . $TablaPartidas[$x][1] . " " . $TablaPartidas[$x][2];
    echo "<br>";
}
echo "<br>";
echo "Partidas Materiales: i_par: " . $i_par . " <br>";
echo "<br>";
for ($x = 0; $x <$i_par; $x++) {
    echo $x . " " . $TablaParMat[$x][0] . " " . $TablaParMat[$x][1] . " " . $TablaParMat[$x][2] . " " . $TablaParMat[$x][3];
    echo "<br>";
}
echo "<br>";
echo "Partidas Partidas: pp: " . $pp . " <br>";
echo "<br>";
for ($x = 0; $x < $pp; $x++) {
    echo $x . " " . $TablaParPar[$x][0] . " " . $TablaParPar[$x][1] . " " . $TablaParPar[$x][2] . " " . $TablaParPar[$x][3];
    echo "<br>";
}
echo "<br>";
echo "Subcapitulos Partidas Valor de sp:" . $sp;
echo "<br>";
for ($x = 1; $x <= $sp; $x++) {
    echo $x. " ".$TablaSubPar[$x][0] . " " . $TablaSubPar[$x][1] . " " . $TablaSubPar[$x][2] . " " . $TablaSubPar[$x][3];
    echo "<br>";
}
echo "<br>";
echo "Subcapitulos Suubcapitulos: ss: " . $ss . " <br>";
echo "<br>";
for ($x = 0; $x < $ss; $x++) {
    echo $x. " ".$TablaSubSub[$x][0] . " " . $TablaSubSub[$x][1] . " " . $TablaSubSub[$x][2] . " " . $TablaSubSub[$x][3];
    echo "<br>";
}
echo "<br>";
echo "Capitulos Partidas: cp: " . $cp . " <br>";
echo "<br>";
for ($x = 1; $x <= $cp; $x++) {
    echo $x. " ".$TablaCapPar[$x][0] . " " . $TablaCapPar[$x][1] . " " . $TablaCapPar[$x][2] . " " . $TablaCapPar[$x][3];
    echo "<br>";
}
echo "<br>";
echo "Capitulos Subcapitulos cs: " . $cs . " <br>";
echo "<br>";
for ($x = 1; $x <= $cs; $x++) {
    echo $x. " ".$TablaCapSub[$x][0] . " " . $TablaCapSub[$x][1] . " " . $TablaCapSub[$x][2] . " " . $TablaCapSub[$x][3];
    echo "<br>";
}
*/
//***************************************************************
//******* PINTAMOS EL HTML DE LA TABLA Y EL JAVASCRIPT PARA CSV
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

    var bExcel = '<?php echo $_POST['chkExcel'] ?>';
    var bCalc = '<?php echo $_POST['chkCalc'] ?>';

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

<?php
//******************************************************
//********** PINTAMOS EL INFORME
//*****************************************************
//echo "<link href=\"layout3col.css\" rel=\"stylesheet\" type=\"text/css\">";
echo "<style type='text/css'>";
echo ".thCabecera{font-weight:bold; color:#ffffff;}";
echo "</style>";
echo "</head>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body onload='runit()'>";
//echo "<b>testdata1</b> \t <u>testdata2</u> \t \n ";
echo "<div style='visibility: hidden;'>";
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
$tablaHTML1="";
//Cabececeras tabla Maquinaria
echo "<table><tr class='thCabecera'><th colspan='6' bgcolor='#9A3634' >MAQUINARIA</th><th colspan='4' bgcolor='#36609C'>UNIDAD DE OBRA</th><th colspan='2' bgcolor='#4F6228'>SUBCAPITULO</th><th colspan='2' bgcolor='#60497A'>CAPITULO</th></tr>";
//Subcabeceras tabla Maquinaria
echo "<tr><th bgcolor='#F2DCDB'>CODIGO</th><th bgcolor='#E6B8B7'>ud</th><th bgcolor='#DA9694'>NOMBRE MAQUINARIA</th><th bgcolor='#E6B8B7'>CANTIDAD</th><th bgcolor='#E6B8B7'>PRECIO</th><th bgcolor='#DA9694'>IMPORTE</th>";
echo "<th bgcolor='#DCE6F1'>CODIGO</th><th bgcolor='#8DB4E2'>ud</th><th bgcolor='#8DB4E2'>NOMBRE</th><th bgcolor='#244062'>CANTIDAD</th><th bgcolor='#D8E4BC'>CODIGO</th><th bgcolor='#C4D79B'>NOMBRE</th><th bgcolor='#CCC0DA'>CODIGO</th><th bgcolor='#B1A0C7'>NOMBRE</th></tr>";

for($j=0;$j<$inf1;$j++) {
    $tablaHTML1 .= "<tr><td>".$LineaInf1[$j][0]."</td><td>".$LineaInf1[$j][1]."</td><td>".$LineaInf1[$j][2]."</td><td>".$LineaInf1[$j][3]."</td><td>".$LineaInf1[$j][4]."</td><td>".$LineaInf1[$j][5]."</td><td>".$LineaInf1[$j][6]."</td><td>".$LineaInf1[$j][7]."</td><td>".$LineaInf1[$j][8]."</td><td>".$LineaInf1[$j][9]."</td><td>".$LineaInf1[$j][10]."</td><td>".$LineaInf1[$j][11]."</td><td>".$LineaInf1[$j][12]."</td><td>".$LineaInf1[$j][13]."</td></tr>";
    echo "<tr><td>".$LineaInf1[$j][0]."</td><td>".$LineaInf1[$j][1]."</td><td>".$LineaInf1[$j][2]."</td><td>".$LineaInf1[$j][3]."</td><td>".$LineaInf1[$j][4]."</td><td>".$LineaInf1[$j][5]."</td><td>".$LineaInf1[$j][6]."</td><td>".$LineaInf1[$j][7]."</td><td>".$LineaInf1[$j][8]."</td><td>".$LineaInf1[$j][9]."</td><td>".$LineaInf1[$j][10]."</td><td>".$LineaInf1[$j][11]."</td><td>".$LineaInf1[$j][12]."</td><td>".$LineaInf1[$j][13]."</td></tr>";
}
echo "</table>";
//Cabececeras tabla Mano de obra
echo "<table><tr class='thCabecera'><th colspan='6' bgcolor='#9A3634' >MANO DE OBRA</th><th colspan='4' bgcolor='#36609C'>UNIDAD DE OBRA</th><th colspan='2' bgcolor='#4F6228'>SUBCAPITULO</th><th colspan='2' bgcolor='#60497A'>CAPITULO</th></tr>";
//Subcabeceras tabla Mano de obra
echo "<tr><th bgcolor='#F2DCDB'>CODIGO</th><th bgcolor='#E6B8B7'>ud</th><th bgcolor='#DA9694'>NOMBRE MANO DE OBRA</th><th bgcolor='#E6B8B7'>CANTIDAD</th><th bgcolor='#E6B8B7'>PRECIO</th><th bgcolor='#DA9694'>IMPORTE</th>";
echo "<th bgcolor='#DCE6F1'>CODIGO</th><th bgcolor='#8DB4E2'>ud</th><th bgcolor='#8DB4E2'>NOMBRE</th><th bgcolor='#244062'>CANTIDAD</th><th bgcolor='#D8E4BC'>CODIGO</th><th bgcolor='#C4D79B'>NOMBRE</th><th bgcolor='#CCC0DA'>CODIGO</th><th bgcolor='#B1A0C7'>NOMBRE</th></tr>";

$tablaHTML2="";
for($j=0;$j<$inf2;$j++) {
    $tablaHTML2 .= "<tr><td>".$LineaInf2[$j][0]."</td><td>".$LineaInf2[$j][1]."</td><td>".$LineaInf2[$j][2]."</td><td>".$LineaInf2[$j][3]."</td><td>".$LineaInf2[$j][4]."</td><td>".$LineaInf2[$j][5]."</td><td>".$LineaInf2[$j][6]."</td><td>".$LineaInf2[$j][7]."</td><td>".$LineaInf2[$j][8]."</td><td>".$LineaInf2[$j][9]."</td><td>".$LineaInf2[$j][10]."</td><td>".$LineaInf2[$j][11]."</td><td>".$LineaInf2[$j][12]."</td><td>".$LineaInf2[$j][13]."</td></tr>";
    echo "<tr><td>".$LineaInf2[$j][0]."</td><td>".$LineaInf2[$j][1]."</td><td>".$LineaInf2[$j][2]."</td><td>".$LineaInf2[$j][3]."</td><td>".$LineaInf2[$j][4]."</td><td>".$LineaInf2[$j][5]."</td><td>".$LineaInf2[$j][6]."</td><td>".$LineaInf2[$j][7]."</td><td>".$LineaInf2[$j][8]."</td><td>".$LineaInf2[$j][9]."</td><td>".$LineaInf2[$j][10]."</td><td>".$LineaInf2[$j][11]."</td><td>".$LineaInf2[$j][12]."</td><td>".$LineaInf2[$j][13]."</td></tr>";
}

echo "</table>";
echo "</div>";
session_start();
$_SESSION['$tablaHTMLSess'] = $tablaHTML;
$_SESSION['$tablaHTML1Sess'] = $tablaHTML1;
$_SESSION['$tablaHTML2Sess'] = $tablaHTML2;
?>
<!----------------------------------------------------------------------->
<!-- PINTAMOS LOS BOTONES PARA GENERAR FICHEROS CSV/Y/O/EXCEL/Y/O/CALC -->
<!----------------------------------------------------------------------->

<form id="frm1">
    <div style="visibility: hidden;">
        <!--TODO: poner esto todo con el mismo estilo -->
        <label><input type="text" size="15" id="fn" value="convertcsv" title="Enter filename without extension" />.csv</label>
        <label><input type="button" value="Save to Disk" onclick="saveFile(document.getElementById('txta').value,'csv')" /></label><br/>
        <textarea id="txta" rows="15" cols="100" wrap="off" placeholder="Output Results"></textarea></center>
    </div>
    <br/>
    <div style="visibility: hidden;">
    Separador de campos para el CSV:
    <label><input type="radio" name="outsep" id="outSepPipe" value="|" > Barra-|</label> &nbsp;
    <label><input type="radio" name="outsep" id="outSepComma" value="," checked="checked"> Comma-,</label> &nbsp;
    <label><input type="radio" name="outsep" id="outSepSemicolon" value=";" > Punto y coma-;</label> &nbsp;
    <label><input type="radio" name="outsep" id="outSepSemicolon" value=":" > Dos puntos-:</label> &nbsp;
    <label><input type="radio" name="outsep" id="outSepTab" value=" " onclick="this.value='\t'" > Tabulador</label> &nbsp;
    <label><input type="radio" name="outsep" id="outSepOther" value="o" > Elegir otros</label>
    <label><input type="text" size="2" id="outSepOtherVal" value="@"/></label>
    <br />
    </div>
    <div style="visibility: hidden;">
    <label><input type="text" size="15" id="fn" value="document_name" title="Indique el nombre del fichero sin la extensión" />.csv</label>
        <input type="button" id="btnRun" class="ui-button-text-only" value="Convertir informe a CSV" title="Convertir informe a CSV"
               onclick="runit()">
        <!--<label><input type="button" value="Convertir informe a CSV" title="Convertir informe a CSV" onclick="saveFile(document.getElementById('txta').value,'csv')" /></label>-->


    </div>
    <div style="visibility: hidden;">

    <input type="button" id="btnRun" class="ui-button-text-only" value="Convertir informe a CSV" title="Convertir informe a CSV"
           onclick="runit()">

    <input type="button" id="btnRun" class="ui-button-text-only" value="Convertir informe a LibreOffice Calc" title="Convertir informe a Excel"
           onclick="odsit()">

    <input type="button" id="btnRun" class="ui-button-text-only" value="Convertir informe a Excel" title="Convertir informe a Excel"
           onclick="excelit()">
     &nbsp;

    </div>
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

<script>
    if (bCalc == 1){
        odsit();
    }
    if (bExcel == 1){
        excelit();
    }


</script>

<?php
//Fin tabla

echo "</body>";
echo "</html>";





?>
