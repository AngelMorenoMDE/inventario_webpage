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
<title>::. Exportación de datos de ordenadores .::</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
    <body>

    <?php
        //select para sacar los resultados de la tabla
        $conexion = new_conex_db();
        
        $sel = "select e.urjc_code, e.serial_number, e.id_office, e.status, e.id_user_asigned, ";
        $sel .= "c.trademark, c.model, c.type_computer, c.cpu_name, c.no_mhz, c.ram_type, c.ram_mb, ";
        $sel .= "c.hdd1_type, c.hdd1_gb, c.hdd2_type, c.hdd2_gb, c.graphic_card, c.sound_card, c.ethernet_card, ";
        $sel .= "c.id_cd_unit1, c.id_cd_unit2, c.vga, c.dvi, c.no_usb, c.ssoo, c.ssoo_type, c.name_equip, ";
        $sel .= "c.domain, c.ip, c.mask, c.dns_1, c.dns_2, c.gateway  ";
        $sel .=  "from electronic_equipment as e inner join computer as c ";
        $sel .=  "on e.id_electronic_eq = c.id_electronic_eq;";
        
        $result = mysql_query ($sel, $conexion);

    ?>
            <!-Cabecera de la tabla en excel-> 
       <table border=1 align="center" cellpadding=1 cellspacing=1>
           <tr>LISTADO DE ORDENADORES</tr>
           <tr>
                <td>CODIGO URJC</td>
                <td>NUMERO DE SERIE</td>
                <td>DESPACHO</td>
                <td>ESTADO</td>
                <td>USUARIO ASIGNADO</td>

                <td>MARCA</td>
                <td>MODELO</td>
                <td>TIPO DE ORDENADOR</td>
                <td>TIPO CPU</td>
                <td>VELOCIDAD CPU</td>
                <td>TIPO MEMORIA RAM</td>
                <td>CAPACIDAD MEMORIA RAM</td>
                <td>TIPO DISCO INTERNO 1</td>
                <td>CAPACIDAD DISCO INTERNO 1</td>
                <td>TIPO DISCO INTERNO 2</td>
                <td>CAPACIDAD DISCO INTERNO 2</td>
                <td>TARJETA GRAFICA</td>
                <td>TARJETA DE SONIDO</td>
                <td>TARJETA DE RED</td>
                <td>UNIDAD LECTORA 1</td>
                <td>UNIDAD LECTORA 2</td>
                <td>CONECTOR VGA</td>
                <td>CONECTOR DVI</td>
                <td>NUMERO PUERTOS USB</td>
                <td>SISTEMA OPERATIVO</td>
                <td>TIPO DE SISTEMA OPERATIVO</td>
                <td>NOMBRE DEL EQUIPO</td>
                <td>DOMINIO</td>
                <td>IP</td>
                <td>MASCARA</td>
                <td>SERVIDOR DNS PRIMARIO</td>
                <td>SERVIDOR DNS SECUNDARIO</td>
                <td>PUERTA DE ENLACE</td>
           </tr>
               <?php
               //mostramos los datos
               while($row = mysql_fetch_array($result)) 
                {
                   $user = GetNameOption($row["id_user_asigned"], "user", "id_user", "email");
                   $status = GetNameOption($row["status"], "status", "id_status", "name_status");
                   $office = GetNameOption($row["id_office"], "office", "id_office", "name_office");  
                   $typeComputer = GetNameOption($row["type_computer"], "computer_type", "id_computer_type", "name_computer_type");
                   $ramType = GetNameOption($row["ram_type"], "ram_type", "id_ram_type", "name_ram_type");
                   $hdd1Type = GetNameOption($row["hdd1_type"], "hdd_type", "id_hdd_type", "name_hdd_type");
                   $hdd2Type = GetNameOption($row["hdd2_type"], "hdd_type", "id_hdd_type", "name_hdd_type");
                   $cd1 = GetNameOption($row["id_cd_unit1"], "cd_type", "id_cd_type", "name_cd_type");
                   $cd2 = GetNameOption($row["id_cd_unit2"], "cd_type", "id_cd_type", "name_cd_type");
                   $vga = $row["vga"];
                   if ($vga == 1)
                    {
                        $vga = "SI";
                    }
                    else 
                    {
                        $vga ="NO";
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
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    <td>&nbsp;%s</td>
                    </tr>", $row["urjc_code"],$row["serial_number"],$office,$status,$user,
                            $row["trademark"],$row["model"],$typeComputer,$row["cpu_name"], $row["no_mhz"],
                            $ramType,$row["ram_mb"],$hdd1Type,$row["hdd1_gb"], $hdd2Type,
                            $row["hdd2_gb"],$row["graphic_card"],$row["sound_card"],$row["ethernet_card"], 
                            $cd1, $cd2, $vga, $dvi, $row["no_usb"],$row["ssoo"],
                            $row["ssoo_type"],$row["name_equip"],$row["domain"],$row["ip"],$row["mask"],
                            $row["dns_1"],$row["dns_2"],$row["gateway"] );
               }
               mysql_free_result($result);
               mysql_close($conexion); 
               ?>
       </table>
    </body>
</html>
    

