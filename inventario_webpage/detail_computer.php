<?php


    require_once "ini.php";
    check_session();
    $_SESSION["actual_page"] = "detail_computer.php";
    $errores= "";
    $vga_checked="";
    $dvi_checked="";
    $hdmi_checked="";
    $tabla1 = "electronic_equipment";
    $tabla2 = "computer";
    $pathImage= getImagePath();
    $pathIcon = getIconPath();
    
    
    if(array_key_exists("download", $_POST))
    {
        $url = "";
        $idDriver = $_POST["download"];
        
        $sel = "select * from driver where id_driver = $idDriver;";
        $row = select_one($sel);
        
        $name = $row["name_driver"];
        $url = getDriverPath() . $name;
        $nameReal = $row["name_real_driver"];
        
        if (is_file($url))
        {
           header('Content-Type: application/force-download');
           header('Content-Disposition: attachment; filename='. $nameReal);
           header('Content-Transfer-Encoding: binary');
           header('Content-Length: '. filesize($url));

           readfile($url);
        }
        else
          $msg = "Archivo no descargado";
      
    }
    
    if(array_key_exists("deleteDriver", $_POST))
    {
        $idDriver = $_POST["deleteDriver"];
        unset($_SESSION["idElectronic"]);
        $_SESSION["idDriver"]= $idDriver;
        redirect("confirm_action.php");
    }

    if(array_key_exists("idElectronic", $_SESSION)) //conservamos id de boton modificar en  lis_user
    {
        $idElectronic = $_SESSION["idElectronic"];//guardamos id en una variable
        $conexion =  new_conex_db();

        $select1="select * from $tabla1 where id_electronic_eq=" . $idElectronic . ";" ;
        $select2="select * from $tabla2 where id_electronic_eq=" . $idElectronic . ";"  ; 

        $rowEquipment =  select_one($select1);
        $rowComputer = select_one($select2);

        $nameOffice = GetNameOption($rowEquipment['id_office'], "office", "id_office", "name_office");

        $id_office = $rowEquipment['id_office'];
        $selectBuilding = "select name_building from $tableBuilding where id_building in 
                           ( select id_building from office where id_office = $id_office);";
        $rowBuilding = select_one($selectBuilding);
        $nameBuilding = $rowBuilding["name_building"];
        
        $codeUrjc = $rowEquipment['urjc_code'];
        $serialNum = $rowEquipment['serial_number'];
        $image1_name = $rowEquipment['image_1'];
        $pathImage1 = $pathImage . $image1_name;
        $image2_name = $rowEquipment['image_2'];
        $pathImage2 = $pathImage . $image2_name;

        $nameStatus = GetNameOption($rowEquipment['status'], "status", "id_status", "name_status");
        $nameUserA = GetNameOption($rowEquipment["id_user_asigned"], "user", "id_user", "name");
        $nameUserC = GetNameOption($rowEquipment["id_user_creation"], "user", "id_user", "name");
        $nameUserM = GetNameOption($rowEquipment["id_user_modify"], "user", "id_user", "name");
        $nameUserD = GetNameOption($rowEquipment["id_user_delete"], "user", "id_user", "name");

        if($rowEquipment['id_user_delete'] == -1)
        {
             $nameUserD = ""; 
        }
        else
        {
            $id_user_delete = $rowEquipment['id_user_delete']; 
            $selectUser = "select * from user where id_user=" .$id_user_delete.";";
            $rowUser = select_one($selectUser);
            $nameUserD = $rowUser['name'];
        }

        $date_creation = $rowEquipment['date_creation'];
        $date_modify = $rowEquipment['date_modify'];
        $date_delete = $rowEquipment['date_delete'];
        
        if($rowEquipment['date_delete'] == -1)
        {
            $date_delete = "Equipo no descatalogado"; 
        }
        else
        {
            $dateDelete = $rowEquipment['date_delete'];
            $date_delete = date('d/m/Y',$dateDelete);
        }
        $description = $rowEquipment['description'];
        $trademark = $rowComputer['trademark'];
        $model = $rowComputer['model'];
        
        
        $nameComputerType = GetNameOption($rowComputer['type_computer'], 
                                    "computer_type", "id_computer_type", "name_computer_type");
                
        
        $cpuName = $rowComputer['cpu_name'];
        $cpuMhz = $rowComputer['no_mhz'];
        if($cpuMhz==-1)
        {
            $cpuMhzMostrar = "";
        }
        else
        {
            $cpuMhzMostrar = $cpuMhz;
        }
        
        $nameRamType = GetNameOption($rowComputer['ram_type'], 
                                    "ram_type", "id_ram_type", "name_ram_type");
                
        $ramMb = $rowComputer['ram_mb'];
        if($ramMb==-1)
        {
            $ramMbMostrar = "";
        }
        else
        {
            $ramMbMostrar = $ramMb;
        }
        $namehdd1 = GetNameOption($rowComputer['hdd1_type'], "hdd_type", "id_hdd_type", "name_hdd_type");
        $hdd1Gb = $rowComputer['hdd1_gb'];
        if($hdd1Gb==-1)
        {
            $hdd1GbMostrar = "";
        }
        else
        {
            $hdd1GbMostrar = $hdd1Gb;
        }
        $namehdd2 = GetNameOption($rowComputer['hdd2_type'], "hdd_type", "id_hdd_type", "name_hdd_type");
        $hdd2Gb = $rowComputer['hdd2_gb'];
        if($hdd2Gb==-1)
        {
            $hdd2GbMostrar = "";
        }
        else
        {
            $hdd2GbMostrar = $hdd2Gb;
        }
        $graphicCard = $rowComputer['graphic_card'];
        $soundCard = $rowComputer['sound_card'];
        $etherCard = $rowComputer['ethernet_card'];
        
        $nameCdType = GetNameOption($rowComputer['id_cd_unit1'], 
                                    "cd_type", "id_cd_type", "name_cd_type");
        
        
        $nameCdType2 = GetNameOption($rowComputer['id_cd_unit2'], 
                                    "cd_type", "id_cd_type", "name_cd_type");

        if($rowComputer['vga'])
        {
            $vga_checked = $pathIcon . "si.png";
        }
        else 
        {
            $vga_checked = $pathIcon . "no.png" ; 
        }

        if($rowComputer['dvi'])
        {
            $dvi_checked = $pathIcon . "si.png";
        }
        else 
        {
            $dvi_checked = $pathIcon . "no.png" ; 
        }

        if($rowComputer['hdmi'])
        {   
            $hdmi_checked = $pathIcon . "si.png";
        }
        else 
        {
            $hdmi_checked = $pathIcon . "no.png" ; 
        }
                
        $usb = $rowComputer['no_usb'];
        if($usb==-1)
        {
            $usbMostrar = "";
        }
        else
        {
            $usbMostrar = $usb;
        }
        $ssoo = $rowComputer['ssoo'];
        $ssooType = $rowComputer['ssoo_type'];
        $nameEquip = $rowComputer['name_equip'];
        $domain = $rowComputer["domain"];
        $ip = $rowComputer['ip'];
        $mask = $rowComputer['mask'];
        $dns1 = $rowComputer['dns_1'];
        $dns2 = $rowComputer['dns_2'];
        $gateway = $rowComputer['gateway'];
        
        
        //lista de drivers del equipo
        $resultSearchHTML2 = "";
       
        $selectDriver = "select id_driver, description, category_driver, name_driver, "
                . " size_driver,  user_upload, date_upload, version from driver where  "
                . "id_electronic_eq = $idElectronic;";

        $resultDriver =  mysql_query($selectDriver,$conexion);
        $rowDriver = select_one($selectDriver);
        $dateUpload = $rowDriver["date_upload"];

        if (mysql_num_rows($resultDriver)>0)
        {
            if(is_admin(getUserInSession()))
            {
                // Imprimir los resultados en HTML
                $resultSearchHTML2 .= "<table class=\"border\">";
                $resultSearchHTML2 .= "<caption>DRIVERS ASIGNADOS AL EQUIPO</caption><br>";
                $resultSearchHTML2 .= "<th class=\"border\">Descargar</th><th class=\"border\">Descripción</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Categoría</th><th class=\"border\">Nombre</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Tamaño</th><th class=\"border\">Usuario de subida</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Fecha de subida</th><th class=\"border\">Versión</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Comentarios</th><th class=\"border\">Eliminar</th>";
            }
            else 
            {
                $resultSearchHTML2 .= "<table class=\"border\">";
                $resultSearchHTML2 .= "<caption>DRIVERS ASIGNADOS AL EQUIPO</caption><br>";
                $resultSearchHTML2 .= "<th class=\"border\">Descargar</th><th class=\"border\">Descripción</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Categoría</th><th class=\"border\">Nombre</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Tamaño</th><th class=\"border\">Usuario de subida</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Fecha de subida</th><th class=\"border\">Versión</th>";   
                $resultSearchHTML2 .= "<th class=\"border\">Comentarios</th>";
                }
            while ($line = mysql_fetch_assoc($resultDriver)) 
            {
                $resultSearchHTML2 .= "<tr class=\"border\">";

                $c = 0;
                foreach ($line as $valor) 
                {
                    if ($c==0)
                    {

                        $idDriver = $valor;
                       $resultSearchHTML2 .= "<td class=\"border\"><input type=\"submit\" class=\"download\" name=\"download\" value=\"$valor\"/></input></td>";
                    }
                    if ($c==5)
                    {

                    $nameUser = GetNameOption($valor, "user", "id_user", "name");
                    $resultSearchHTML2 .= "<td class=\"border\">$nameUser</td>";
                    }
                    if ($c==6)
                    {
                        $date = date('d/m/Y',$dateUpload);
                        $resultSearchHTML2 .= "<td class=\"border\">$date</td>";

                    }
                  
                    if(($c != 0)&& ($c != 5) && ($c != 6)) 
                    {
                        $resultSearchHTML2 .= "<td class=\"border\">$valor</td>";
                    }


                    $c++;
                }
                if(is_admin(getUserRolInSession()))
                {
                $resultSearchHTML2 .= "<td class=\"border\"><input type=\"submit\" class=\"delete\" name=\"deleteDriver\" value=\"$idDriver\"/></input></td>";
                }
                $resultSearchHTML2 .= "</tr>\n";
            }
            $resultSearchHTML2 .= "</table>\n";
        }
        else
        {
            $resultSearchHTML2 .= "<table><tr><td>EL EQUIPO NO TIENE NINGÚN DRIVER ASIGNADO</td></tr></table>";
        }

        mysql_close($conexion);

    }
    else
    {
         redirect("search_computer.php");
    }

    
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Inventario Kybele</title>
<link href="http://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css" />
<link href="http://fonts.googleapis.com/css?family=Coda:400,800" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="./css/style_menu_search.css" type="text/css"/>
<link href="./css/style.css" rel="stylesheet" type="text/css" media="screen" />

</head>
    
   <body>
     <?php require_once "head.php";?>


<div id="wrapper">
	<!-- end #header -->
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
                            
				<div id="content">
                                    

                                    <div class="post">
       
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <table class ="border">
                                            <caption>DETALLES DEL ORDENADOR</caption>
                                            <tr class ="border">
                                                <td class ="tdBack">Código URJC</td><td class ="border"><?php echo $codeUrjc;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Número de serie</td><td class ="border"><?php echo $serialNum;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Edificio</td><td class ="border"><?php echo $nameBuilding;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Despacho</td><td class ="border"><?php echo $nameOffice;?></td>
                                            </tr>

                                            <tr class ="border">
                                                <td class ="tdBack">Imagen 1</td><td class ="border"><img src ="<?php echo $pathImage1;?>" width="30 "height="30"></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Imagen 2</td><td class ="border"><img src ="<?php echo $pathImage2;?>" width="30 "height="30"></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Estado</td><td class ="border"><?php echo$nameStatus; ;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Asignado a usuario: </td><td class ="border"><?php echo $nameUserA?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Usuario creación: </td><td class ="border"><?php echo $nameUserC?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Usuario modificación: </td><td class ="border"><?php echo $nameUserM?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Usuario eliminacion: </td><td class ="border"><?php echo $nameUserD?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Fecha creación: </td><td class ="border"><?php echo date('d/m/Y',$date_creation)?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Fecha modificación: </td><td class ="border"><?php echo date('d/m/Y',$date_modify)?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Fecha eleminación: </td><td class ="border"><?php echo $date_delete?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Marca</td><td class ="border"><?php echo $trademark;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Modelo</td><td class ="border"><?php echo $model;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Tipo de ordenador</td><td class ="border"><?php echo $nameComputerType;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Tipo de microprocesador</td><td class ="border"><?php echo $cpuName;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Velocidad de microprocesador</td><td class ="border"><?php echo $cpuMhzMostrar;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Tipo de memoria</td><td class ="border"><?php echo $nameRamType;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Capacidad de memoria</td><td class ="border"><?php echo $ramMbMostrar;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Tipo de Disco duro 1</td><td class ="border"><?php echo $namehdd1;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Capacidad de disco duro 1</td><td class ="border"><?php echo $hdd1GbMostrar;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class="tdBack">Tipo de Disco duro 2</td><td class ="border"><?php echo $namehdd2;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Capacidad de disco duro 2</td><td class ="border"><?php echo $hdd2GbMostrar;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Tarjeta gráfica</td><td class ="border"><?php echo $graphicCard;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Tarjeta de sonido</td><td class ="border"><?php echo $soundCard;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Tarjeta de red</td><td class ="border"><?php echo $etherCard;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Unidad lectora 1</td><td class ="border"><?php echo $nameCdType;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Unidad lectoria 2</td><td class ="border"><?php echo $nameCdType2;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Conector de video VGA</td>
                                                <td class ="border"><img src ="<?php echo $vga_checked;?>"></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Conector de video DVI</td>
                                                <td class ="border"><img src ="<?php echo $dvi_checked;?>"></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Conector de video HDMI</td>
                                                <td class ="border"><img src ="<?php echo $hdmi_checked;?>"></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Número de puertos USB</td><td><?php echo $usbMostrar;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Comentarios:</td>
                                                <td class ="border"><?php echo $description ?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Sistema operativo</td><td class ="border"><?php echo $ssoo;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Tipo de Sistema Operativo</td><td class ="border"><?php echo $ssooType;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Nombre del equipo</td><td class ="border"><?php echo $nameEquip;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Nombre Dominio</td><td class ="border"><?php echo $domain;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Dirección IP</td><td class ="border"><?php echo $ip;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Máscara de subred</td><td class ="border"><?php echo $mask;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Servidor DNS primario</td><td class ="border"><?php echo $dns1;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Servidor DNS secundario</td><td class ="border"><?php echo $dns2;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Puerta de Enlace</td><td class ="border"><?php echo $gateway;?></td>
                                            </tr>

                                        </table>

                                    <?php echo $resultSearchHTML2; ?>
                                    </form>
                                    </div>
                                    <div class="post">
                                 </div>                                    
                                </div>
				<!-- end #content -->
                                <?php require_once "sidebar.php";?>
				<!-- end #sidebar -->
				<div style="clear: both;">&nbsp;</div>
                                
			</div>
		</div>
	</div>
	<!-- end #page -->
</div>
<div id="footer">
	<p>&copy; 2014 Inventario Kybele. Grupo de Investigación Kybele. Universidad Rey Juan Carlos</p>
</div>
<!-- end #footer -->
</body>
</html>
