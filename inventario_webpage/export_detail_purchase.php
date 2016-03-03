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
    $idPurchase = $_SESSION["idPurchase"];
    $selPurchase = "select id_project, price, name_purchase, date_purchase, purchaser from purchase where id_purchase =" . $idPurchase . ";";
       $rowPurchase = select_one($selPurchase);
       
       $project = GetNameOption($rowPurchase["id_project"], "project", "id_project", "name_project");
       $price = $rowPurchase["price"];
       $name = $rowPurchase["name_purchase"];
       $datePurchase = $rowPurchase["date_purchase"];
       $datePurchase = date("d/m/Y", $datePurchase);
       $purchaser = $rowPurchase["purchaser"];
    
    $resulthtml = "<tr><b>DETALLES DE LA COMPRA</b></tr><tr><td>NOMBRE DEL PROYECTO</td><td>PRECIO</td>";
    $resulthtml .= "<td>DESCRIPCION DE LA COMPRA</td><td>FECHA DE COMPRA</td><td>COMPRADOR</td></tr>";
    $resulthtml .= "<td>$project</td><td>$price</td><td>$name</td><td>$datePurchase</td>";
    $resulthtml .= "<td>$purchaser</td></tr>";
    
    //sacamos la relación de equipos electrónicos
    
    $selEq = "select electronic_eq_type, urjc_code, serial_number, id_office,"
            . " status, id_user_asigned from $tableElectEq where id_electronic_eq in "
            . "(select id_electronic_eq from purchase_eq where id_purchase =" .$idPurchase. ");";
    $resultE = mysql_query ($selEq, $conexion);
    
    //sacamos la relacion de documentos
    
    $selDoc = "select name, name_description, size, extension, date_upload, user_upload from "
            . "$tablePurchaseDoc where id_purchase = ".$idPurchase. ";"; 
    $resultD = mysql_query ($selDoc, $conexion);
    
    

    ?>
            <!-Cabecera de la tabla en excel-> 
            <table border=1 align="center" cellpadding=1 cellspacing=1>
              <?php echo $resulthtml; ?>  
            </table>
       <table border=1 align="center" cellpadding=1 cellspacing=1>
           <tr><b>RELACION DE EQUIPOS ELECTRONICOS DE LA COMPRA</b></tr>
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
    


