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
    //select para sacar los resultados de la tabla
    $conexion = new_conex_db();
    $sel = "select id_project, price, name_purchase, date_purchase, purchaser from purchase;";
    $result = mysql_query ($sel, $conexion);
    

    ?>
            <!-Cabecera de la tabla en excel-> 
       <table border=1 align="center" cellpadding=1 cellspacing=1>
            <tr>LISTADO DE COMPRAS</tr>
           <tr>
           <td>NOMBRE</td>
           <td>PRECIO</td>
           <td>PROYECTO</td>
           <td>COMPRADOR</td>
           <td>FECHA DE COMPRA</td>
           </tr>
               <?php
               //mostramos los datos
               while($row = mysql_fetch_array($result)) 
                {
                   $project = getNameOption($row["id_project"], "project", "id_project", "name_project");
                   $datePurchase = date ('d-m-Y', $row["date_purchase"]);
                   printf("<tr>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    
                    </tr>", $row["name_purchase"], $row["price"], $project , $row["purchaser"], $datePurchase) ;
               }
               mysql_free_result($result);
               mysql_close($conexion); 
               ?>
       </table>
    </body>
</html>
    

