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
<title>::. Exportación de datos de impresoras .::</title>
</head>
    <body>

    <?php
        //select para sacar los resultados de la tabla
        $conexion = new_conex_db();
        
        $sel = "select e.urjc_code, e.serial_number, e.id_office, e.status, e.id_user_asigned,";
        $sel .= " p.trademark, p.model, p.color, p.laser, p.paralel, p.usb, p.ethernet, ";
        $sel .= " p.name_equip, p.domain, p.ip, p.mask ";
        $sel .=  " from electronic_equipment as e inner join printer as p ";
        $sel .=  " on e.id_electronic_eq = p.id_electronic_eq;";
        
        $result = mysql_query ($sel, $conexion);

    ?>
            <!-Cabecera de la tabla en excel-> 
       <table border=1 align="center" cellpadding=1 cellspacing=1>
           <tr>LISTADO DE IMPRESORAS</tr>
           <tr>
           <td>CODIGO URJC</td>
           <td>NUMERO DE SERIE</td>
           <td>DESPACHO</td>
           <td>ESTADO</td>
           <td>USUARIO ASIGNADO</td>
           
           <td>MARCA</td>
           <td>MODELO</td>
           <td>COLOR</td>
           <td>LASER</td>
           <td>PUERTO PARALELO</td>
           <td>PUERTO USB</td>
           <td>PUERTO ETHERNET</td>
           <td>NOMBRE DEL EQUIPO</td>
           <td>DOMINIO</td>
           <td>DIRECCION IP</td>
           <td>MASCARA DE SUBRED</td>
          </tr>
               <?php
               //mostramos los datos
               while($row = mysql_fetch_array($result)) 
                {
                   $user = GetNameOption($row["id_user_asigned"], "user", "id_user", "email");
                   $status = GetNameOption($row["status"], "status", "id_status", "name_status");
                   $office = GetNameOption($row["id_office"], "office", "id_office", "name_office");  
                   $color = $row["color"];
                   if ($color == 1)
                    {
                        $color = "SI";
                    }
                    else 
                    {
                        $color = "NO";
                    }
                   $laser = $row["laser"];
                   if ($laser == 1)
                    {
                        $laser = "SI";
                    }
                    else 
                    {
                        $laser = "NO";
                    }
                   $paralel = $row["paralel"];
                   if ($paralel == 1)
                    {
                        $paralel = "SI";
                    }
                    else 
                    {
                        $paralel = "NO";
                    }
                   $usb = $row["usb"];
                   if ($usb == 1)
                    {
                        $usb = "SI";
                    }
                    else 
                    {
                        $usb = "NO";
                    }
                   $ether = $row["ethernet"];
                   if ($ether == 1)
                    {
                        $ether = "SI";
                    }
                    else 
                    {
                        $ether = "NO";
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
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    </tr>", $row["urjc_code"],$row["serial_number"],$office,$status,$user,
                            $row["trademark"],$row["model"],$color, $laser, $paralel,
                            $usb, $ether,$row["name_equip"],$row["domain"],$row["ip"],$row["mask"] );
               }
               mysql_free_result($result);
               mysql_close($conexion); 
               ?>
       </table>
    </body>
</html>
    

