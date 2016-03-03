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
<title>::. Exportación de Datos de Despachos .::</title>
</head>
    <body>

    <?php
    //select para sacar los resultados de la tabla
    $conexion = new_conex_db();
    $sel = "select name_office, id_building, no_floor from office;";
    $result = mysql_query ($sel, $conexion);

    ?>
            <!-Cabecera de la tabla en excel-> 
       <table border=1 align="center" cellpadding=1 cellspacing=1>
            <tr>LISTADO DE DESPACHOS</tr>
           <tr>
           <td>NOMBRE DEL DESPACHO</td>
           <td>EDIFICIO</td>
           <td>NUMERO DE PLANTA</td>
           </tr>
               <?php
               //mostramos los datos
               while($row = mysql_fetch_array($result)) 
                {
                   $building = GetNameOption($row["id_building"], "building", "id_building", "name_building") ;
                   printf("<tr>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    </tr>", $row["name_office"], $building, $row["no_floor"]);
               }
               mysql_free_result($result);
               mysql_close($conexion); 
               ?>
       </table>
    </body>
</html>
    


