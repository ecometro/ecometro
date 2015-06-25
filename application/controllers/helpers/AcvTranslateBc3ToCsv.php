<?php 

/**
 * Class Controller Helper for translating bc3 format to csv
 * =demo.php from traductor Lidia
 */
class Zend_Controller_Action_Helper_AcvTranslateBc3ToCsv extends Zend_Controller_Action_Helper_Abstract
{
 
    public function getAcvTranslateBc3ToCsv($file) 
    {
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


        if (($handle = fopen($file['tmp_name'], 'rb')) !== FALSE) {
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
                            if ($this->validateLetras($pos3) && (strlen($csvarray [$x][1]) == 5))//Registro del tipo concepto Subcapítulo
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
                            $SuperCodigoCantidad = $this->Obtener_SupercodigoyCantidad($TablaParPar[$j][0], $TablaParPar[$j][1], $LineaInf[$inf][3], $TablaParPar, $pp);
                            if ($SuperCodigoCantidad[0] != Null) {
                                $LineaInf[$inf][6] = $SuperCodigoCantidad[0];//Codigo de la Partida de Mayor Rango (6)
                                $LineaInf[$inf][3] = $SuperCodigoCantidad[1];//Cantidad de Material Básico a nivel Partidas (3)
                            }

                            $NombreyUdPartida = $this->Obtener_NombreyUdPartida($LineaInf[$inf][6], $TablaPartidas, $NumPar);
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
                                    $SuperCodigoCantidad = $this->Obtener_SupercodigoyCantidad(" ", $LineaInf[$inf][10], $LineaInf[$inf][3], $TablaSubSub, $ss);
                                    if ($SuperCodigoCantidad[0] != Null) {
                                        $LineaInf[$inf][10] = $SuperCodigoCantidad[0]; //Código Subcapitulo de Mayor Rango (10)
                                        $LineaInf[$inf][3] = $SuperCodigoCantidad[1]; //Cantidad del Material Básico a nivel Subcapítulo (3)
                                    }

                                    $LineaInf[$inf][11] = $this->Obtener_NombreSuboCap($LineaInf[$inf][10], $TablaSubcapitulos, $NumSub); //(11)
                                    $CodigoCantidades = $this->Obtener_CodigoCantidades($LineaInf[$inf][10], $LineaInf[$inf][3], $TablaCapSub, $cs);
                                    $LineaInf[$inf][12] = $CodigoCantidades[0]; //Código del Capitulo (12)
                                    $LineaInf[$inf][3] = $CodigoCantidades[1]; //Cantidad del Material Básico a nivel Capitulo (3).
                                    $LineaInf[$inf][9] = $CodigoCantidades[2]; //Cantidad de Material Básico en la Unidad de Obra (9).
                                    $LineaInf[$inf][5] = $LineaInf[$inf][3] * $LineaInf[$inf][4]; //Importe = Cantidad * Precio.(5)
                                    $LineaInf[$inf][13] = $this->Obtener_NombreSuboCap($LineaInf[$inf][12], $TablaCapitulos, $NumCap);//(13)
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
                                        $LineaInf[$inf][13] = $this->Obtener_NombreSuboCap($LineaInf[$inf][12], $TablaCapitulos, $NumCap);//(13)
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
                                $NombreyUdPartida = $this->Obtener_NombreyUdPartida($LineaInf[$inf][6], $TablaPartidas, $NumPar);
                                $LineaInf[$inf][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
                                $LineaInf[$inf][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)

                                $LineaInf[$inf][10] = $TablaSubPar[$h][0]; //Código Subcapitulo Asociado a la Partida (10)
                                $LineaInf[$inf][3]  = $LineaInf[$inf][3] * $TablaSubPar[$h][3]; //Cantidad del Material Básico a nivel Subcapítulo (3)
                                $LineaInf[$inf][9]  = $TablaSubPar[$h][3]; //Cantidad en la Unidad de Material Básico Obra. (9)
                                $SuperCodigoCantidad = Null;
                                $SuperCodigoCantidad = $this->Obtener_SupercodigoyCantidad(" ", $LineaInf[$inf][10], $LineaInf[$inf][3], $TablaSubSub, $ss);
                                if ($SuperCodigoCantidad[0] != Null) {
                                    $LineaInf[$inf][10] = $SuperCodigoCantidad[0]; //Código Subcapitulo de Mayor Rango (10)
                                    $LineaInf[$inf][3] = $SuperCodigoCantidad[1]; //Cantidad del Material Básico a nivel Subcapítulo (3)
                                }
                                $LineaInf[$inf][11] = $this->Obtener_NombreSuboCap($LineaInf[$inf][10], $TablaSubcapitulos, $NumSub); //(11)
                                $CodigoCantidades = $this->Obtener_CodigoCantidades($LineaInf[$inf][10], $LineaInf[$inf][3], $TablaCapSub, $cs);
                                $LineaInf[$inf][12] = $CodigoCantidades[0]; //Código del Capitulo (12)
                                $LineaInf[$inf][3] = $CodigoCantidades[1]; //Cantidad del Material Básico a nivel Capitulo (3).
                                $LineaInf[$inf][9] = $CodigoCantidades[2]; //Cantidad de Material Básico en la Unidad de Obra (9).
                                $LineaInf[$inf][5] = $LineaInf[$inf][3] * $LineaInf[$inf][4]; //Importe = Cantidad * Precio.(5)
                                $LineaInf[$inf][13] = $this->Obtener_NombreSuboCap($LineaInf[$inf][12], $TablaCapitulos, $NumCap);//(13)
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
                                    $NombreyUdPartida = $this->Obtener_NombreyUdPartida($LineaInf[$inf][6], $TablaPartidas, $NumPar);
                                    $LineaInf[$inf][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
                                    $LineaInf[$inf][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)
                                    $LineaInf[$inf][12] = $TablaCapPar [$k][0];
                                    $LineaInf[$inf][3] = $LineaInf[$inf][3] *  $TablaCapPar [$k][3];
                                    $LineaInf[$inf][9] = $TablaCapPar [$k][3];
                                    $LineaInf[$inf][5] = $LineaInf[$inf][3] * $LineaInf[$inf][4]; //Importe = Cantidad * Precio.(5)
                                    $LineaInf[$inf][13] = $this->Obtener_NombreSuboCap($LineaInf[$inf][12], $TablaCapitulos, $NumCap);//(13)
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
                            $SuperCodigoCantidad = $this->Obtener_SupercodigoyCantidad($TablaParPar[$j][0], $TablaParPar[$j][1], $LineaInf1[$inf1][3], $TablaParPar, $pp);
                            if ($SuperCodigoCantidad[0] != Null) {
                                $LineaInf1[$inf1][6] = $SuperCodigoCantidad[0];//Codigo de la Partida de Mayor Rango (6)
                                $LineaInf1[$inf1][3] = $SuperCodigoCantidad[1];//Cantidad de Maquinaria a nivel Partidas (3)
                            }

                            $NombreyUdPartida = $this->Obtener_NombreyUdPartida($LineaInf1[$inf1][6], $TablaPartidas, $NumPar);
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
                                    $SuperCodigoCantidad = $this->Obtener_SupercodigoyCantidad(" ", $LineaInf1[$inf1][10], $LineaInf1[$inf1][3], $TablaSubSub, $ss);
                                    if ($SuperCodigoCantidad[0] != Null) {
                                        $LineaInf1[$inf1][10] = $SuperCodigoCantidad[0]; //Código Subcapitulo de Mayor Rango (10)
                                        $LineaInf1[$inf1][3] = $SuperCodigoCantidad[1]; //Cantidad de Maquinaria a nivel Subcapítulo (3)
                                    }

                                    $LineaInf1[$inf1][11] = $this->Obtener_NombreSuboCap($LineaInf1[$inf1][10], $TablaSubcapitulos, $NumSub); //(11)
                                    $CodigoCantidades = $this->Obtener_CodigoCantidades($LineaInf1[$inf1][10], $LineaInf1[$inf1][3], $TablaCapSub, $cs);
                                    $LineaInf1[$inf1][12] = $CodigoCantidades[0]; //Código del Capitulo (12)
                                    $LineaInf1[$inf1][3] = $CodigoCantidades[1]; //Cantidad de Maquinaria a nivel Capitulo (3).
                                    $LineaInf1[$inf1][9] = $CodigoCantidades[2]; //Cantidad de Maquinaria en la Unidad de Obra (9).
                                    $LineaInf1[$inf1][5] = $LineaInf1[$inf1][3] * $LineaInf1[$inf1][4]; //Importe = Cantidad * Precio.(5)
                                    $LineaInf1[$inf1][13] = $this->Obtener_NombreSuboCap($LineaInf1[$inf1][12], $TablaCapitulos, $NumCap);//(13)
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
                                        $LineaInf1[$inf1][13] = $this->Obtener_NombreSuboCap($LineaInf1[$inf1][12], $TablaCapitulos, $NumCap);//(13)
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
                                $NombreyUdPartida = $this->Obtener_NombreyUdPartida($LineaInf1[$inf1][6], $TablaPartidas, $NumPar);
                                $LineaInf1[$inf1][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
                                $LineaInf1[$inf1][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)

                                $LineaInf1[$inf1][10] = $TablaSubPar[$h][0]; //Código Subcapitulo Asociado a la Partida (10)
                                $LineaInf1[$inf1][3]  = $LineaInf1[$inf1][3] * $TablaSubPar[$h][3]; //Cantidad de Maquinaria a nivel Subcapítulo (3)
                                $LineaInf1[$inf1][9]  = $TablaSubPar[$h][3]; //Cantidad en la Unidad de Maquinaria (9)
                                $SuperCodigoCantidad = Null;
                                $SuperCodigoCantidad = $this->Obtener_SupercodigoyCantidad(" ", $LineaInf1[$inf1][10], $LineaInf1[$inf1][3], $TablaSubSub, $ss);
                                if ($SuperCodigoCantidad[0] != Null) {
                                    $LineaInf1[$inf1][10] = $SuperCodigoCantidad[0]; //Código Subcapitulo de Mayor Rango (10)
                                    $LineaInf1[$inf1][3] = $SuperCodigoCantidad[1]; //Cantidad del Maquinaria a nivel Subcapítulo (3)
                                }

                                $LineaInf1[$inf1][11] = $this->Obtener_NombreSuboCap($LineaInf1[$inf1][10], $TablaSubcapitulos, $NumSub); //(11)
                                $CodigoCantidades = $this->Obtener_CodigoCantidades($LineaInf1[$inf1][10], $LineaInf1[$inf1][3], $TablaCapSub, $cs);
                                $LineaInf1[$inf1][12] = $CodigoCantidades[0]; //Código del Capitulo (12)
                                $LineaInf1[$inf1][3] = $CodigoCantidades[1]; //Cantidad del Maquinaria a nivel Capitulo (3).
                                $LineaInf1[$inf1][9] = $CodigoCantidades[2]; //Cantidad de Maquinaria en la Unidad de Obra (9).
                                $LineaInf1[$inf1][5] = $LineaInf1[$inf1][3] * $LineaInf1[$inf1][4]; //Importe = Cantidad * Precio.(5)
                                $LineaInf1[$inf1][13] = $this->Obtener_NombreSuboCap($LineaInf1[$inf1][12], $TablaCapitulos, $NumCap);//(13)
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
                                    $NombreyUdPartida = $this->Obtener_NombreyUdPartida($LineaInf1[$inf1][6], $TablaPartidas, $NumPar);
                                    $LineaInf1[$inf1][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
                                    $LineaInf1[$inf1][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)
                                    $LineaInf1[$inf1][12] = $TablaCapPar [$k][0];
                                    $LineaInf1[$inf1][3] = $LineaInf1[$inf1][3] *  $TablaCapPar [$k][3];
                                    $LineaInf1[$inf1][9] = $TablaCapPar [$k][3];
                                    $LineaInf1[$inf1][5] = $LineaInf1[$inf1][3] * $LineaInf1[$inf1][4]; //Importe = Cantidad * Precio.(5)
                                    $LineaInf1[$inf1][13] = $this->Obtener_NombreSuboCap($LineaInf1[$inf1][12], $TablaCapitulos, $NumCap);//(13)
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
                        $SuperCodigoCantidad = $this->Obtener_SupercodigoyCantidad($TablaParPar[$j][0], $TablaParPar[$j][1], $LineaInf2[$inf2][3], $TablaParPar, $pp);
                        if ($SuperCodigoCantidad[0] != Null) {
                            $LineaInf2[$inf2][6] = $SuperCodigoCantidad[0];//Codigo de la Partida de Mayor Rango (6)
                            $LineaInf2[$inf2][3] = $SuperCodigoCantidad[1];//Cantidad de Mano de Obra a nivel Partidas (3)
                        }

                        $NombreyUdPartida = $this->Obtener_NombreyUdPartida($LineaInf2[$inf2][6], $TablaPartidas, $NumPar);
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
                                $SuperCodigoCantidad = $this->Obtener_SupercodigoyCantidad(" ", $LineaInf2[$inf2][10], $LineaInf2[$inf2][3], $TablaSubSub, $ss);
                                if ($SuperCodigoCantidad[0] != Null) {
                                    $LineaInf2[$inf2][10] = $SuperCodigoCantidad[0]; //Código Subcapitulo de Mayor Rango (10)
                                    $LineaInf2[$inf2][3] = $SuperCodigoCantidad[1]; //Cantidad de Mano de Obra a nivel Subcapítulo (3)
                                }

                                $LineaInf2[$inf2][11] = $this->Obtener_NombreSuboCap($LineaInf2[$inf2][10], $TablaSubcapitulos, $NumSub); //(11)
                                $CodigoCantidades = $this->Obtener_CodigoCantidades($LineaInf2[$inf2][10], $LineaInf2[$inf2][3], $TablaCapSub, $cs);
                                $LineaInf2[$inf2][12] = $CodigoCantidades[0]; //Código del Capitulo (12)
                                $LineaInf2[$inf2][3] = $CodigoCantidades[1]; //Cantidad de Mano de Obra a nivel Capitulo (3).
                                $LineaInf2[$inf2][9] = $CodigoCantidades[2]; //Cantidad de Mano de Obra en la Unidad (9).
                                $LineaInf2[$inf2][5] = $LineaInf2[$inf2][3] * $LineaInf2[$inf2][4]; //Importe = Cantidad * Precio.(5)
                                $LineaInf2[$inf2][13] = $this->Obtener_NombreSuboCap($LineaInf2[$inf2][12], $TablaCapitulos, $NumCap);//(13)
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
                                    $LineaInf2[$inf2][13] = $this->Obtener_NombreSuboCap($LineaInf2[$inf2][12], $TablaCapitulos, $NumCap);//(13)
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
                            $NombreyUdPartida = $this->Obtener_NombreyUdPartida($LineaInf2[$inf2][6], $TablaPartidas, $NumPar);
                            $LineaInf2[$inf2][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
                            $LineaInf2[$inf2][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)

                            $LineaInf2[$inf2][10] = $TablaSubPar[$h][0]; //Código Subcapitulo Asociado a la Partida (10)
                            $LineaInf2[$inf2][3]  = $LineaInf2[$inf2][3] * $TablaSubPar[$h][3]; //Cantidad de Mano de Obra a nivel Subcapítulo (3)
                            $LineaInf2[$inf2][9]  = $TablaSubPar[$h][3]; //Cantidad en la Unidad de Mano de Obra. (9)
                            $SuperCodigoCantidad = Null;
                            $SuperCodigoCantidad = $this->Obtener_SupercodigoyCantidad(" ", $LineaInf2[$inf2][10], $LineaInf2[$inf2][3], $TablaSubSub, $ss);
                            if ($SuperCodigoCantidad[0] != Null) {
                                $LineaInf2[$inf2][10] = $SuperCodigoCantidad[0]; //Código Subcapitulo de Mayor Rango (10)
                                $LineaInf2[$inf2][3] = $SuperCodigoCantidad[1]; //Cantidad de Mano de Obra a nivel Subcapítulo (3)
                            }
                            $LineaInf2[$inf2][11] = $this->Obtener_NombreSuboCap($LineaInf2[$inf2][10], $TablaSubcapitulos, $NumSub); //(11)
                            $CodigoCantidades = $this->Obtener_CodigoCantidades($LineaInf2[$inf2][10], $LineaInf2[$inf2][3], $TablaCapSub, $cs);
                            $LineaInf2[$inf2][12] = $CodigoCantidades[0]; //Código del Capitulo (12)
                            $LineaInf2[$inf2][3] = $CodigoCantidades[1]; //Cantidad de Mano de Obra a nivel Capitulo (3).
                            $LineaInf2[$inf2][9] = $CodigoCantidades[2]; //Cantidad de Mano de Obra en la Unidad de Obra (9).
                            $LineaInf2[$inf2][5] = $LineaInf2[$inf2][3] * $LineaInf2[$inf2][4]; //Importe = Cantidad * Precio.(5)
                            $LineaInf2[$inf2][13] = $this->Obtener_NombreSuboCap($LineaInf2[$inf2][12], $TablaCapitulos, $NumCap);//(13)
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
                                $NombreyUdPartida = $this->Obtener_NombreyUdPartida($LineaInf2[$inf2][6], $TablaPartidas, $NumPar);
                                $LineaInf2[$inf2][7] = $NombreyUdPartida[0];//Unidad de Medida de la Partida (7)
                                $LineaInf2[$inf2][8] = $NombreyUdPartida[1];//Nombre de la Partida (8)
                                $LineaInf2[$inf2][12] = $TablaCapPar [$k][0];
                                $LineaInf2[$inf2][3] = $LineaInf2[$inf2][3] *  $TablaCapPar [$k][3];
                                $LineaInf2[$inf2][9] = $TablaCapPar [$k][3];
                                $LineaInf2[$inf2][5] = $LineaInf2[$inf2][3] * $LineaInf2[$inf2][4]; //Importe = Cantidad * Precio.(5)
                                $LineaInf2[$inf2][13] = $this->Obtener_NombreSuboCap($LineaInf2[$inf2][12], $TablaCapitulos, $NumCap);//(13)
                                $inf2++; //Partida-Mano de Obra / Capitulo-Partida
                            }
                        }
                    }
                }


            }
        }

    }
    
    return array(
                'materiales' => $LineaInf,
                'maquinaria' => $LineaInf1,
                'mano_de_obra' => $LineaInf2
            );

    }
    
    private function validateLetras($texto) {
        $patrón = '/[a-zA-Z]/';
        return (bool)preg_match($patrón, $texto);
    }

    /***************************************************************/
    /*     FUNCIONES UTILIZADAS EN PHP LA GENERACIÓN DE INFORMES   */
    /***************************************************************/
    private function Obtener_SupercodigoYCantidad($Aux_Supercodigo, $Aux_Codigo, $Aux_Cantidad, $Aux_Tabla, $Aux_indice)
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

    private function Obtener_NombreyUdPartida($Aux_Codigo, $Aux_Tabla,$Aux_indice)
    {
        for ($y=0;$y<$Aux_indice;$y++) {

            if ($Aux_Codigo == $Aux_Tabla[$y][0]) {
                $Aux_UdNombre[0] = $Aux_Tabla[$y][1];
                $Aux_UdNombre[1] = $Aux_Tabla[$y][2];
                return ($Aux_UdNombre);
            }
        }
    }

    private function Obtener_CodigoCantidades($Aux_Codigo, $Aux_Cantidad, $Aux_Tabla, $Aux_indice)
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

    private function Obtener_NombreSuboCap($Aux_Codigo, $Aux_Tabla, $Aux_indice)
    {
        for ($y = 0; $y < $Aux_indice; $y++) {

            if ($Aux_Codigo == $Aux_Tabla[$y][0]) {
                return ($Aux_Tabla[$y][1]);
            }
        }
    }

    public function direct($file)
    {
        return $this->getAcvTranslateBc3ToCsv($file);
    }
}
?>