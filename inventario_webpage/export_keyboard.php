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
<title>::. Exportación de datos de teclados .::</title>
</head>
    <body>

    <?php
        //select para sacar los resultados de la tabla
        $conexion = new_conex_db();
        
        $sel = "select e.urjc_code, e.serial_number, e.id_office, e.status, e.id_user_asigned,";
        $sel .= " t.trademark, t.model, t.conector_type, t.wireless ";
        $sel .=  " from electronic_equipment as e inner join keyboard as t ";
        $sel .=  " on e.id_electronic_eq = t.id_electronic_eq;";
        
        $result = mysql_query ($sel, $conexion);

    ?>
            <!-Cabecera de la tabla en excel-> 
       <table border=1 align="center" cellpadding=1 cellspacing=1>
           <tr>LISTADO DE TECLADOS</tr>
           <tr>
           <td>CODIGO URJC</td>
           <td>NUMERO DE SERIE</td>
           <td>DESPACHO</td>
           <td>ESTADO</td>
           <td>USUARIO ASIGNADO</td>
           
           <td>MARCA</td>
           <td>MODELO</td>
           <td>TIPO DE CONECTOR</td>
           <td>WIRELESS</td>
          </tr>
               <?php
               //mostramos los datos
               while($row = mysql_fetch_array($result)) 
                {
                  
                   $user = GetNameOption($row["id_user_asigned"], "user", "id_user", "email");
                   $status = GetNameOption($row["status"], "status", "id_status", "name_status");
                   $office = GetNameOption($row["id_office"], "office", "id_office", "name_office"); 
                   $conector = GetNameOption($row["conector_type"], "wire_type", "id_wire_type", "name_wire_type");
                   $wire = $row["wireless"];
                   if ($wire == 1)
                   {
                       $wire ="SI";
                   }
                   else
                   {
                       $wire = "NO";
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
                    </tr>", $row["urjc_code"],$row["serial_number"],$office,$status,$user,
                            $row["trademark"],$row["model"],$conector ,$wire );
               }
               mysql_free_result($result);
               mysql_close($conexion); 
               ?>
       </table>
    </body>
</html>
    

