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
<title>::. Exportación de datos de monitores .::</title>
</head>
    <body>

    <?php
        //select para sacar los resultados de la tabla
        $conexion = new_conex_db();
        
        $sel = "select e.urjc_code, e.serial_number, e.id_office, e.status, e.id_user_asigned,";
        $sel .= " m.trademark, m.model, m.no_inch, m.monitor_type, m.vga, m.dvi ";
        $sel .=  " from electronic_equipment as e inner join monitor as m ";
        $sel .=  " on e.id_electronic_eq = m.id_electronic_eq;";
        
        $result = mysql_query ($sel, $conexion);

    ?>
            <!-Cabecera de la tabla en excel-> 
       <table border=1 align="center" cellpadding=1 cellspacing=1>
           <tr>LISTADO DE MONITORES</tr>
           <tr>
           <td>CODIGO URJC</td>
           <td>NUMERO DE SERIE</td>
           <td>DESPACHO</td>
           <td>ESTADO</td>
           <td>USUARIO ASIGNADO</td>
           
           <td>MARCA</td>
           <td>MODELO</td>
           <td>NUMERO DE PULGADAS</td>
           <td>TIPO DE MONITOR</td>
           <td>CONECTOR VGA</td>
           <td>CONECTOR DVI</td>
          </tr>
               <?php
               //mostramos los datos
               while($row = mysql_fetch_array($result)) 
                {
                   $user = GetNameOption($row["id_user_asigned"], "user", "id_user", "email");
                   $status = GetNameOption($row["status"], "status", "id_status", "name_status");
                   $office = GetNameOption($row["id_office"], "office", "id_office", "name_office"); 
                   $type = GetNameOption($row["monitor_type"], "monitor_type", "id_monitor_type", "name_monitor_type");
                   $vga = $row["vga"];
                   if ($vga == 1)
                    {
                        $vga = "SI";
                    }
                    else 
                    {
                        $vga = "NO";
                    }
                    $dvi = $row["dvi"];
                   if ($dvi == 1)
                    {
                        $dvi = "SI";
                    }
                    else 
                    {
                        $dvi ="NO";
                    }
                   printf("<tr>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    </tr>", $row["urjc_code"],$row["serial_number"],$office,$status,$user,
                            $row["trademark"],$row["model"],$row["no_inch"],$type, $vga, $dvi );
               }
               mysql_free_result($result);
               mysql_close($conexion); 
               ?>
       </table>
    </body>
</html>
    

