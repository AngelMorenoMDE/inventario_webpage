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
    $sel = "select name_project, id_project_status, id_user_creation, id_user_delete, "
            . "date_creation, date_delete, summary from project order by id_project_status;";
    $result = mysql_query ($sel, $conexion);
    

    ?>
            <!-Cabecera de la tabla en excel-> 
       <table border=1 align="center" cellpadding=1 cellspacing=1>
            <tr>LISTADO DE PROYECTOS</tr>
           <tr>
           <td>NOMBRE</td>
           <td>ESTADO</td>
           <td>USUARIO DE CREACION</td>
           <td>USUARIO DE CIERRE</td>
           <td>FECHA DE CREACION</td>
           <td>FECHA DE CIERRE</td>
           <td>SUMMARY</td>
           
           </tr>
               <?php
               //mostramos los datos
               while($row = mysql_fetch_array($result)) 
                {
                   $status = GetNameOption($row["id_project_status"], "project_status", "id_project_status", "name_project_status");
                   $userCreation = GetNameOption($row["id_user_creation"], "user", "id_user", "name");
                   $dateCreation = date ('d-m-Y', $row["date_creation"]);
                   $userDelete = GetNameOption($row["id_user_delete"], "user", "id_user", "name");
                   $dateDelete = $row["date_delete"];
                   if ($dateDelete == -1)
                   {
                       $dateDelete = "Abierto";
                   }
                   else
                   {
                       $dateDelete =  date ('d-m-Y', $row["date_delete"]);
                   }
                   
                   printf("<tr>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    </tr>", $row["name_project"], $status, $userCreation, $dateCreation, $dateCreation, $dateDelete, $row["summary"]);
               }
               mysql_free_result($result);
               mysql_close($conexion); 
               ?>
       </table>
    </body>
</html>
    
