<?php
    require_once "ini.php";
    check_session();  


    //Exportar a excel
    header("Content-Type: application/vnd.ms-excel" );
    header("Expires: 0" );
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0" );
    header("content-disposition: attachment;filename=Reportes.xls" );
 ?>

<html lang="es">
<title>::. Exportación de Datos .::</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
    <body>

    <?php
    //sacamos los detelles de proyecto
    $conexion = new_conex_db();
    $idProject = $_SESSION["idProject"];
    $selProj = "select name_project, id_project_status, id_user_creation, date_creation,"
            . " id_user_delete, date_delete, summary from project where id_project = " .$idProject. ";";
    $rowProject = select_one($selProj);
        $nameProject = $rowProject['name_project'];
        $nameStatus = GetNameOption($rowProject['id_project_status'], "project_status", "id_project_status", "name_project_status");
        $summary = $rowProject['summary'];
        $nameUserC = GetNameOption($rowProject["id_user_creation"], "user", "id_user", "name");
        $date_creation = $rowProject['date_creation'];
        $date_creation = date("d/m/Y", $date_creation);
        $nameUserD = GetNameOption($rowProject["id_user_delete"], "user", "id_user", "name");
        $date_delete = $rowProject['date_delete'];
        $date_delete = date("d/m/Y", $date_delete);
    
    $resulthtml = "<tr><b>DETALLES DEL PROYECTO</b></tr><tr><td>NOMBRE DEL PROYECTO</td><td>ESTADO</td>";
    $resulthtml .= "<td>USUARIO DE CREACION</td><td>FECHA DE CREACION</td><td>USUARIO DE CIERRE</td>";
    $resulthtml .= "<td>FECHA DE CIERRE</td><td>COMENTARIOS</td></tr>";
    $resulthtml .= "<td>$nameProject</td><td>$nameStatus</td><td>$nameUserC</td><td>$date_creation</td>";
    $resulthtml .= "<td>$nameUserD</td><td>$date_delete</td><td>$summary</td></tr>";
    
    //sacamos la relación de equipos electrónicos
    
    $selEq = "select electronic_eq_type, urjc_code, serial_number, id_office,"
            . " status, id_user_asigned from $tableElectEq where id_electronic_eq in "
            . "(select id_electronic_eq from project_eq where id_project =" .$idProject. ");";
    $resultE = mysql_query ($selEq, $conexion);
    
    //sacamos la relacion de documentos
    
    $selDoc = "select name, name_description, size, extension, date_upload, user_upload from "
            . "$tableProjectDoc where id_project = ".$idProject. ";"; 
    $resultD = mysql_query ($selDoc, $conexion);
    
    

    ?>
            <!-Cabecera de la tabla en excel-> 
            <table border=1 align="center" cellpadding=1 cellspacing=1>
              <?php echo $resulthtml; ?>  
            </table>
       <table border=1 align="center" cellpadding=1 cellspacing=1>
           <tr><b>RELACION DE EQUIPOS ELECTRONICOS DEL PROYECTO</b></tr>
           <tr>
            <td>TIPO DE EQUIPO ELECTRÓNICO</td>
            <td>CODIGO URJC</td>
            <td>NUMERO DE SERIE</td>
            <td>DESPACHO</td>
            <td>ESTADO</td>
            <td>USUARIO ASIGNADO</td>
           </tr>
               <?php
               //mostramos los datos
               while($row = mysql_fetch_array($resultE)) 
                {
                   $elecType = GetNameOption($row["electronic_eq_type"], "electronic_eq_type", "id_elect_eq_type", "name_elect_eq_type") ;
                   $office = GetNameOption($row["id_office"], "office", "id_office", "name_office");
                   $status = GetNameOption($row["status"], "status", "id_status", "name_status");
                   $user = GetNameOption($row["id_user_asigned"], "user", "id_user", "name");
                   printf("<tr>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    </tr>", $elecType, $row["urjc_code"], $row["serial_number"],$office, $status, $user);
               }
               mysql_free_result($resultE);
               mysql_close($conexion); 
               ?>
       </table>
            
            
            <table border=1 align="center" cellpadding=1 cellspacing=1>
            <tr><b>RELACION DE DOCUMENTOS DEL PROYECTO</b></tr>
            <tr>
                <td>NOMBRE</td>
                <td>DESCRIPCION</td>
                <td>TAMAÑO</td>
                <td>EXTENSION</td>
                <td>FECHA DE SUBIDA</td>
                <td>USUARIO DE SUBIDA</td>
            </tr>
               <?php
               //mostramos los datos
               while($rowD = mysql_fetch_array($resultD)) 
                {
                   $dateUp = date("d/m/Y", $rowD["date_upload"]);
                   $userUp = GetNameOption($rowD["user_upload"], "user", "id_user", "name");
                   printf("<tr>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    </tr>", $rowD["name"], $rowD["name_description"], $rowD["size"],$rowD["extension"], $dateUp, $userUp);
               }
               mysql_free_result($resultD);
               //mysql_close($conexion); 
               ?>
       </table>
    </body>
</html>
    

