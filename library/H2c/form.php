<html>
<body>
<script language="JavaScript">

    function notEmpty(){
        if(!document.getElementById("uploadBox").value != "") {
            alert("Debe seleccionar un fichero");
            return false;
        }
    }

</script>

<form enctype="multipart/form-data" action="demo.php" method="post" onsubmit="return notEmpty()" >
    Seleccione fichero <input type="file" id="uploadBox" name="fichero" ><br>
    <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- Name of input element determines name in $_FILES array -->
    <input type="submit" value="Convertir informe a CSV"" title="Convertir informe a CSV">

    <input name="chkCalc" type="hidden" value="0" />
    <label><input name="chkCalc" type="checkbox" value="1"/> Generar informe en LibreOffice Calc</label>
    <input name="chkExcel" type="hidden" value="0" />
   <!-- <label><input name="chkExcel" type="checkbox" value="1"/> Generar informe en Excel</label>-->

</form>

</body>

</html>