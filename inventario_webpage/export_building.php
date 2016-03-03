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
    $result = mysql_query ("select * from building", $conexion);

    ?>
            <!-Cabecera de la tabla en excel-> 
       <table border=1 align="center" cellpadding=1 cellspacing=1>
            <tr>LISTADO DE EDIFICIOS</tr>
           <tr>
           <td>ID EDIFICIO</td>
           <td>NOMBRE</td>
           <td>CAMPUS</td>
           </tr>
               <?php
               //mostramos los datos
               while($row = mysql_fetch_array($result)) 
                {
                   $campus = GetNameOption($row["id_campus"], "campus", "id_campus", "name_campus") ;
                   printf("<tr>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    </tr>", $row["id_building"],$row["name_building"],$campus);
               }
               mysql_free_result($result);
               mysql_close($conexion); 
               ?>
       </table>
    </body>
</html>
    

