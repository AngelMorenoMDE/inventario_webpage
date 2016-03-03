<?php

    require_once "ini.php";
    check_session();
    $_SESSION["actual_page"] = "edit_computer.php";  
    $errores= "";
    $maxCar = 50;
    $vga_checked="";
    $dvi_checked="";
    $hdmi_checked="";
    $pathImage= getImagePath();

    if(array_key_exists("cancel", $_POST))
    {
    redirect("search_computer.php");
    } 
    
    if(array_key_exists("idElectronic", $_SESSION)) //conservamos id de boton modificar en  lis_user
    {

        $idElectronic = $_SESSION["idElectronic"];//guardamos id en una variable

        $conexion =  new_conex_db();

        $selectEq = "select * from $tableElectEq where id_electronic_eq=" . $idElectronic . ";" ;
        $selectComputer = "select * from $tableComputer where id_electronic_eq=" . $idElectronic . ";"  ; 

        $rowElectronic =  select_one($selectEq);
        $rowComputer = select_one($selectComputer);

        $codeUrjc = $rowElectronic['urjc_code'];
        $serialNumber = $rowElectronic['serial_number'];
        
        $idOffice = $rowElectronic['id_office'];
        $idConjunto = generateIdConjunto($idOffice);
        
        $image1_name = $rowElectronic['image_1'];
        $pathImage1 = $pathImage . $image1_name;
        $image2_name = $rowElectronic['image_2'];
        $pathImage2 = $pathImage . $image2_name;
        $status = $rowElectronic['status'];
        $idUserAsigned = $rowElectronic['id_user_asigned'];
         $description = $rowElectronic['description'];

        $trademark = $rowComputer['trademark'];
        $model = $rowComputer['model'];
        $typeComputer = $rowComputer['type_computer'];
        $cpuName = $rowComputer['cpu_name'];
        $cpuMhz = $rowComputer['no_mhz'];
        $ramType = $rowComputer['ram_type'];
        $ramMb = $rowComputer['ram_mb'];
        $hdd1Type = $rowComputer['hdd1_type'];
        $hdd1Gb = $rowComputer['hdd1_gb'];
        $hdd2Type = $rowComputer['hdd2_type'];
        $hdd2Gb = $rowComputer['hdd2_gb'];
        $graphicCard = $rowComputer['graphic_card'];
        $soundCard = $rowComputer['sound_card'];
        $etherCard = $rowComputer['ethernet_card'];
        $cdUnit1 = $rowComputer['id_cd_unit1'];
        $cdUnit2 = $rowComputer['id_cd_unit2'];
        
        $vga = $rowComputer['vga'];
        if($rowComputer['vga'])
        {
            $vga_checked="checked";
        }
        
        $dvi = $rowComputer['dvi'];
        if($rowComputer['dvi'])
        {
            $dvi_checked="checked";
        }
        
        $hdmi = $rowComputer['hdmi'];
        if($rowComputer['hdmi'])
        {
             $hdmi_checked="checked";
        }
                
        $usb = $rowComputer['no_usb'];
        $ssoo = $rowComputer['ssoo'];
        $ssooType = $rowComputer['ssoo_type'];
        $nameEquip = $rowComputer['name_equip'];
        $domain = $rowComputer ['domain'];
        $ip = $rowComputer['ip'];
        $mask = $rowComputer['mask'];
        $dns1 = $rowComputer['dns_1'];
        $dns2 = $rowComputer['dns_2'];
        $gateway = $rowComputer['gateway'];



    }
    else
    {
        redirect("list_computer.php");
    }


    //recogemos los datos nuevos 
    if(array_key_exists("saveComputer", $_POST))
    {   
        //recogemos datos de equipo electrónico
        if (!array_key_exists("urjc_code", $_POST))
        {
            $errores .= "No hay datos que guardar</br>";
        }
        else 
        {
            $codeUrjc = $_POST["urjc_code"];
            trim($codeUrjc);
            
            if (is_empty($codeUrjc))
            {
                $errores .= "El campo Código URJC no puede estar vacio</br>";
            }
            else
            {
                if (!validate_integer($codeUrjc))
                {
                    $errores .= "el campo Código URJC debe contener un numero entero</br>";
                }
            }
        }
        
        if (!array_key_exists("serial_number", $_POST))
        {
            $errores .= "No hay datos que guardar</br>";
        }
        else 
        {   
            $serialNumber = $_POST["serial_number"];
            trim($serialNumber);
            
            if (is_empty($serialNumber))
            {
                $errores .= "El campo Número de serie no puede estar vacio</br>";
            }
            else 
            {
                if (validar_cadena($serialNumber,$maxCar)==3)
                {
                    $errores .= "el campo Número de serie no puede tener mas "
                                . "de " . $maxCar . " caracteres</br>";
                }
            }
        }
            
        $idOfficeConjunto = $_POST["id_office"];
        $idOffice = sacaId($idOfficeConjunto);

        //recogemos datos del archivo de imagen

        $image1_ok = false;  //baliza para comprobar que el proceso se hace correcto
        if (is_empty($_FILES["image_1"]["name"]))
        {
            $image1_ok = true;
        }
        else
        {
            $image1_name = $_FILES["image_1"]["name"];

            if (check_extension($image1_name)) //comprobamos extensión correcta
            {
                //cambiamos nombre de archivo por tiempo en microsegundos
                $image1_name = file_microseconds($image1_name);
                $image1_ok = true;
            } 
            else    // En caso de fallo
            {
                $errores .= "- Fichero 1 Extensión incorrecta";
            }
        }   

        //recogemos datos del archivo de imagen
        $image2_ok = false;  //baliza para comprobar que le proceso se hace correcto
        if (is_empty($_FILES["image_2"]["name"]))
        {
            $image2_ok = true;
        }
        else
        {
            $image2_name = $_FILES["image_2"]["name"];

            if (check_extension($image2_name)) //comprobamos extensión correcta
            {
                //cambiamos nombre de archivo por tiempo en microsegundos
                $image2_name = file_microseconds($image2_name);
                $image2_ok = true;
            } 
            else    // En caso de fallo
            {
                $errores .= "- Fichero 2 Extensión incorrecta";
            }
        }
        //se modificará fecha y usuario si el estado es descatalogado
        $status = $_POST["status"];
        if ($status != 3)
        {
            $idUserDelete = -1;
            $dateDelete = -1;
        }
        if ($status == 3)
        {
            $idUserDelete = getUserInSession();
            $dateDelete = time();
        }
        $iduUserAsigned = $_POST["iduserasigned"];
        $idUserModify = getUserInSession();
        $dateModify = time();
        $description = $_POST["description"];

        //recogemos datos de ordenador
        if (!array_key_exists("trademark", $_POST))
        {
            $errores .= "No hay datos que guardar</br>";
        }
        else 
        {   
            $trademark = $_POST["trademark"];
            trim($trademark);
            
            if (is_empty($trademark))
            {
                $errores .= "El campo Marca no puede estar vacio</br>";
            }
       
            else 
            {
                if (validar_cadena($trademark,$maxCar)==2)
                {
                    $errores .= "el campo Marca no puede ser numerico</br>";
                } 
                else 
                {
                    if (validar_cadena($trademark,$maxCar)==3)
                    {
                        $errores .= "el campo Marca no puede tener mas "
                                    . "de " . $maxCar . " caracteres</br>";
                    }
                }
            }
        }
      
        if (!array_key_exists("model", $_POST))
        {
            $errores .= "No hay datos que guardar</br>";
        }
        else 
        {   
            $model = $_POST["model"];
            trim($model);
            
            if (is_empty($model))
            {
                $errores .= "El campo Modelo no puede estar vacio</br>";
            }
            
            else 
            {
                if (validar_cadena($model,$maxCar)==3)
                {
                    $errores .= "el campo Modelo no puede tener mas "
                                . "de " . $maxCar . " caracteres</br>";
                }
            }
        }
        
        $typeComputer = $_POST["typecomputer"];
        if (!array_key_exists("cpuname", $_POST))
        {
            $errores .= "No hay datos que guardar</br>";
        }
        else 
        {   
            $cpuName = $_POST["cpuname"];
            trim($cpuName);
            
            if (is_empty($cpuName))
            {
            $errores .= "El campo Nombre CPU no puede estar vacio</br>";
            }
            
            else 
            {
                if (validar_cadena($cpuName,$maxCar)==2)
                {
                    $errores .= "el campo Nombre CPU no puede ser numerico</br>";
                } 
                else 
                {
                    if (validar_cadena($cpuName,$maxCar)==3)
                    {
                        $errores .= "el campo Nombre CPU no puede tener mas "
                                    . "de " . $maxCar . " caracteres</br>";
                    }
                }
            }
        }
                                                    
        if (!array_key_exists("cpumhz", $_POST))
        {
        $errores .= "No hay datos que guardar</br>";
        }
        else 
        {
            $cpuMhz = $_POST["cpumhz"];
            trim($cpuMhz);
            
            if (is_empty($cpuMhz))
            {
                $errores .= "El campo Velocidad CPU no puede estar vacio</br>";
            }
            else
            {
                if (!validate_integer($cpuMhz))
                {
                    $errores .= "el campo Velocidad CPU debe contener un numero entero</br>";
                }
            }
        }

        $ramType = $_POST["ramtype"];

        if (!array_key_exists("rammb", $_POST))
        {
            $errores .= "No hay datos que guardar</br>";
        }
        else 
        {
            $ramMb = $_POST["rammb"];
            trim($ramMb);
            
            if (is_empty($ramMb))
            {
                $errores .= "El campo Capacidad RAM no puede estar vacio</br>";
            }
            else
            {
                if (!validate_integer($ramMb))
                {
                    $errores .= "el campo Capacidad RAM debe contener un numero entero</br>";
                }
            }
        }
        
        $hdd1Type = $_POST["hdd1type"];
        
        if (!array_key_exists("hdd1_gb", $_POST))
        {
            $errores .= "No hay datos que guardar</br>";
        }
        else 
        {
            $hdd1Gb = $_POST["hdd1_gb"];
            trim($hdd1Gb);
            
            if (is_empty($hdd1Gb))
            {
                $errores .= "El campo apacidad disco duro 1 no puede estar vacio</br>";
            }
            else
            {
                if (!validate_integer($hdd1Gb))
                {
                    $errores .= "el campo Capacidad disco duro 1 debe contener "
                                . "un numero entero</br>";
                }
            }
        }
        
        $hdd2Type = $_POST["hdd2type"];
        
        $hdd2Gb = -1;
        if (!is_empty($_POST["hdd2_gb"]))
        {
            $hdd2Gb = $_POST["hdd2_gb"];
        }
        
        if (!array_key_exists("graphiccard", $_POST))
        {
        $errores .= "No hay datos que guardar</br>";
        }
        else 
        {   
            $graphicCard = $_POST["graphiccard"];
            trim($graphicCard);
            
            if (is_empty($graphicCard))
            {
                $errores .= "El campo Tárjeta gráfica no puede estar vacio</br>";
            }
            else 
            {
                if (validar_cadena($graphicCard,$maxCar)==2)
                {
                    $errores .= "el campo Tárjeta gráfica no puede ser numerico</br>";
                } 
                else 
                {
                    if (validar_cadena($graphicCard,$maxCar)==3)
                    {
                        $errores .= "el campo Tárjeta gráfica no puede tener mas "
                                    . "de " . $maxCar . " caracteres</br>";
                    }
                }
            }
        }
        
        $soundCard = $_POST["soundcard"];
        $etherCard = $_POST["ethercard"];
        $cdUnit1 = $_POST["cdunit1"];
        $cdUnit2 = $_POST["cdunit2"];
        
        $usb = -1;
        if (!is_empty($_POST["usb"]))
        {
            $usb = $_POST["usb"];
        }
        
        if (!array_key_exists("ssoo", $_POST))
        {
            $errores .= "No hay datos que guardar</br>";
        }
        else 
        {   
            $ssoo = $_POST["ssoo"];
            trim($ssoo);
            
            if (is_empty($ssoo))
            {
                $errores .= "El campo Sistema Operativo no puede estar vacio</br>";
            }
            
            else 
            {
                if (validar_cadena($ssoo,$maxCar)==2)
                {
                    $errores .= "el campo Sistema Operativo no puede ser numerico</br>";
                } 
                else 
                {
                    if (validar_cadena($ssoo,$maxCar)==3)
                    {
                        $errores .= "el campo Sistema Operativo no puede tener mas "
                                    . "de " . $maxCar . " caracteres</br>";
                    }
                }
            }
        }
        
        $ssooType = $_POST["ssootype"];
        $nameEquip = $_POST["nameequip"];
        $domain = $_POST["domain"];
        $ip = $_POST["ip"];
        $mask = $_POST["mask"];
        $dns1 = $_POST["dns1"];
        $dns2 = $_POST["dns2"];
        $gateway = $_POST["gateway"];

        //para forzar a que el checbox tenga valores 0 ó 1, si no da error
        $vga = 0;
        if (array_key_exists("vga", $_POST))
        {
            $vga = 1;
        }

        $dvi = 0;
        if (array_key_exists("dvi", $_POST))
        {
            $dvi = 1;
        }

        $hdmi = 0;
        if (array_key_exists("hdmi", $_POST))
        {
            $hdmi = 1;
        }
         
        //evitamos los espacios antes de los campos varchar
        trim($soundCard);
        trim($etherCard);
        trim($ssooType);
        trim($nameEquip);
        trim($domain);
        trim($ip);
        trim($mask);
        trim($dns1);
        trim($dns2);
        trim($gateway);

        if  (!is_numeric($cpuMhz))                  
        {
            $errores.= "- El campo \"Velocidad CPU\" debe ser numérico</br>";
        }
            
        if  (!is_numeric($hdd2Gb))                  
        {
                $errores.= "- El campo \"capacidad disco interno 2\" debe ser numérico</br>";
        }
        if (strlen($soundCard)>50)                 
        {
            $errores.= "- El campo \"tarjeta de vídeo\" no puede contener mas de 50 caracteres</br>";
        }
        if (strlen($etherCard)>50)                 
        {
            $errores.= "- El campo \"tarjeta de red\" no puede contener mas de 50 caracteres</br>";
        }
        if  (!is_numeric($usb))                  
        {
            $errores.= "- El campo \"Número de usb\" debe ser numérico</br>";
        }
        if (strlen($ssooType)>20)                 
        {
            $errores.= "- El campo \"Tipo de sistema operativo\" no puede contener mas de 50 caracteres</br>";
        }
        if (strlen($nameEquip)>50)                 
        {
            $errores.= "- El campo \"Nombre de Equipo\" no puede contener mas de 50 caracteres</br>";
        }
        if (strlen($domain)>50)                 
        {
            $errores.= "- El campo \"Nombre de Dominio\" no puede contener mas de 50 caracteres</br>";
        }
        if (!validate_ip($ip))                 
        {
            $errores.= "El campo \"dirección IP\" no es válido</br>";
        }
        
        if (!validate_ip($mask))                 
        {
            $errores.= "El campo \"máscara de red\" no es válido</br>";
        }
        if (!validate_ip($dns1))                 
        {
            $errores.= "El campo \"dirección DNS primaria\" no es válido</br>";
        }
        if (!validate_ip($dns2))                 
        {
            $errores.= "El campo \"dirección DNS secundaria\" no es válido</br>";
        }
        if (!validate_ip($gateway))                 
        {
            $errores.= "El campo \"puerta de enlace\" no es válido</br>";
        }  

        //actualizamos datos de equipo electronico

        $editEq = "update $tableElectEq set urjc_code = " . $codeUrjc .
                                        ", serial_number =" . comillas($serialNumber) .
                                        ", id_office = " . $idOffice .
                                        ", image_1 = " . comillas($image1_name) . 
                                        ", image_2 = " . comillas($image2_name) .
                                        ", status = " . $status .
                                        ", id_user_asigned = " . $iduUserAsigned .
                                        ", id_user_modify =" . $idUserModify . 
                                        ", id_user_delete =" . $idUserDelete . 
                                        ", date_modify = " . $dateModify .
                                        ", date_delete = " . $dateDelete .
                                        ", description = " . comillas($description).
                                        " where id_electronic_eq =" . $idElectronic . ";";    

        $editComputer="update $tableComputer set trademark = " . comillas($trademark). 
                                " , model =" . comillas($model).
                                " , type_computer =" . $typeComputer.
                                " , cpu_name =" . comillas($cpuName).
                                " , no_mhz =" . $cpuMhz.
                                " , ram_type =" . $ramType.
                                " , ram_mb =" .$ramMb.
                                " , hdd1_type =" .$hdd1Type.
                                " , hdd1_gb =" .$hdd1Gb.
                                " , hdd2_type =" .$hdd2Type.
                                " , hdd2_gb =" .$hdd2Gb.
                                " , graphic_card =" . comillas($graphicCard).
                                " , sound_card =" .  comillas($soundCard).
                                " , ethernet_card =" .  comillas($etherCard).
                                " , id_cd_unit1 =" .$cdUnit1.
                                " , id_cd_unit2 =" .$cdUnit2.
                                " , vga =" .$vga.
                                " , dvi =" .$dvi.
                                " , hdmi =" .$hdmi.
                                " , no_usb =" .$usb.
                                " , ssoo =" .  comillas($ssoo).
                                " , ssoo_type =" .  comillas($ssooType).
                                " , name_equip =" .  comillas($nameEquip).
                                " , domain =" .  comillas($domain).
                                " , ip =" .comillas($ip).
                                " , mask =" .comillas($mask).
                                " , dns_1 =" .comillas($dns1).
                                " , dns_2 =" .comillas($dns2).
                                " , gateway =" .comillas($gateway).
                                " where id_electronic_eq = $idElectronic;";

        if ($errores == "")
        {   

            if ($image1_ok)     //si comprobación correcta:
            {
                saveImageInServer("image_1", $image1_name);
            }
            if ($image2_ok)
            {
                saveImageInServer("image_2", $image2_name);
            } 
            if ((execute_query($editEq)) && (execute_query($editComputer)))//comprobamos que la query se hizo correcta
            {
                alert_js("Datos guardados con éxito.");
                redirect("search_computer.php");
            }
        }
        else 
        {
            $errores = "Se han producido los siguientes errores: </br>".$errores;     
        }

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
       
                                        <?php echo $errores; ?> 


                                    <form action="" method="post" enctype="multipart/form-data">
                                        <fieldset>
                                            <legend><B>EDITOR DE ORDENADOR</B></legend>
                                        <table>
                                            <tr>
                                                <td>Código URJC:</td>
                                                <td><input type="text" name="urjc_code" size="50" value="<?php echo $codeUrjc;?>"/> </td>
                                                 <td><?php echo isFieldRequired("edit_computer.php", "urjc_code"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Número de Serie:</td>
                                                <td><input type="text" name="serial_number" size="50" value="<?php echo $serialNumber;?>"/> </td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "serial_number"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Despacho</td>
                                                <td><?php echo generateSelectOffice($idConjunto); ?> </td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "id_office", $idOffice); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Imagen 1:</td>
                                                <td><input name="image_1" type="file" size="50" /> </td>
                                                <td><a href="<?php echo $pathImage1 ;?>" target="_blank">Ver Imagen</a></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "image_1"); ?></td>
                                            </tr>

                                            <tr>
                                                <td>Imagen 2:</td>
                                                <td><input name="image_2" type="file" size="50" /> </td>
                                                <td><a href="<?php echo $pathImage2 ;?>" target="_blank">Ver Imagen</a></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "image_2"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Estado:</td>
                                                <td><?php echo generateSelectWithOptions("status", "status",
                                                        "id_status", "name_status", $status); ?> </td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "status"); ?></td>
                                            </tr>
                                             <tr>
                                                <td>Asignado a usuario:</td>
                                                <td><?php echo generateSelectWithOptions("iduserasigned", "user",
                                                        "id_user", "email", $idUserAsigned); ?> </td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "iduserasigned"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Marca :</td>
                                                <td><input type="text" name="trademark" size="50" value="<?php echo $trademark ?>"/> </td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "trademark"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Modelo:</td>
                                                <td><input type="text" name="model" size="50" value="<?php echo $model ?>"/></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "model"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tipo de ordenador:</td>
                                                <td><?php echo generateSelectWithOptions("typecomputer", "computer_type",
                                                        "id_computer_type", "name_computer_type", $typeComputer ); ?></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "typecomputer"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tipo CPU:</td> 
                                                <td><input type="text" name="cpuname" size="50" value="<?php echo $cpuName ?>"/></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "cpuname"); ?></td>
                                                <td></td>
                                                <td>Velocidad CPU:</td> 
                                                <td><input type="text" name="cpumhz" size="10" value="<?php echo $cpuMhz ?>"/>Mhz</td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "cpumhz"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tipo de RAM:</td> 
                                                <td><?php echo generateSelectWithOptions("ramtype", "ram_type",
                                                        "id_ram_type", "name_ram_type", $ramType); ?></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "ramtype"); ?></td>
                                                <td></td>
                                                <td>Capacidad RAM:</td> 
                                                <td><input type="text" name="rammb" size="10" value="<?php echo $ramMb ?>"/>Mb</td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "rammb"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tipo disco interno 1:</td> 
                                                <td><?php echo generateSelectWithOptions("hdd1type", "hdd_type",
                                                        "id_hdd_type", "name_hdd_type", $hdd1Type); ?></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "hdd1type"); ?></td>
                                                <td></td>
                                                <td>Capacidad disco 1:</td> 
                                                <td><input type="text" name="hdd1_gb" size="10" value="<?php echo $hdd1Gb ?>"/>Gb</td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "hdd1_gb"); ?></td>
                                            </tr>
                                            </tr>
                                            <tr>
                                                <td>Tipo disco interno 2:</td>
                                                <td><?php echo generateSelectWithOptions("hdd2type", "hdd_type",
                                                        "id_hdd_type", "name_hdd_type", $hdd2Type); ?></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "hdd2type"); ?></td>
                                                <td></td> 
                                                <td>Capacidad disco 2:</td> 
                                                <td><input type="text" name="hdd2_gb" size="10" value="<?php echo $hdd2Gb ?>"/>Gb</td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "hdd2_gb"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tarjeta gráfica :</td>
                                                <td><input type="text" name="graphiccard" size="50" value="<?php echo $graphicCard ?>"> </td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "graphiccard"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tarjeta de sonido :</td>
                                                <td><input type="text" name="soundcard" size="50" value="<?php echo $soundCard ?>"/> </td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "soundcard"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tarjeta de red :</td>
                                                <td><input type="text" name="ethercard" size="50" value="<?php echo $etherCard ?>"/> </td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "ethercard"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Unidad lectora 1:</td>
                                                <td><?php echo generateSelectWithOptions("cdunit1", "cd_type",
                                                        "id_cd_type", "name_cd_type", $cdUnit1); ?></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "cdunit1"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Unidad lectora 2:</td>
                                                <td><?php echo generateSelectWithOptions("cdunit2", "cd_type",
                                                        "id_cd_type", "name_cd_type", $cdUnit2); ?></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "cdunit2"); ?></td>
                                            <tr>
                                                <td>Conector de video :</td>
                                                <td>VGA:<input type="checkbox" name="vga" <?php echo $vga_checked;?>>
                                                    DVI:<input type="checkbox" name="dvi" <?php echo $dvi_checked;?>>
                                                    HDMI:<input type="checkbox" name="hdmi" <?php echo $hdmi_checked;?>></td>                
                                            </tr>
                                            <tr>
                                                <td>Número de conectores USB :</td>
                                                <td><input type="text" name="usb" size="15" value="<?php echo $usb ?>"/> </td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "usb"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Comentarios:</td>
                                                <td><textarea  name="description"><?php echo $description ?></textarea></td>
                                            </tr>
                                        </table> 
                                        </fieldset>
                                        <fieldset>
                                            <legend><B>DATOS DE CONFIGURACION</B></legend>
                                        <table>
                                            <tr>
                                                <td>Nombre del equipo :</td>
                                                <td><input type="text" name="nameequip" size="30" value="<?php echo $nameEquip ?>"/> </td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "nameequip"); ?></td>
                                                <td></td> 
                                                <td>Nombre del Dominio :</td>
                                                <td><input type="text" name="domain" size="30" value="<?php echo $domain ?>"/> </td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "domain"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Sistema Operativo:</td>
                                                <td><?php echo generateSSOO("ssoo", $ssoo); ?></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "ssoo"); ?></td>
                                                <td></td> 
                                                <td>Tipo de Sistema Operativo:</td> 
                                                <td><input type="text" name="ssootype" size="30" value="<?php echo $ssooType ?>"/></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "ssootype"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Dirección IP:</td>
                                                <td><input type="text" name="ip" size="30" value="<?php echo $ip ?>"/></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "ip"); ?></td>
                                                <td></td> 
                                                <td>Máscara de red:</td> 
                                                <td><input type="text" name="mask" size="30" value="<?php echo $mask ?>"/></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "mask"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Dirección DNS primaria:</td>
                                                <td><input type="text" name="dns1" size="30" value="<?php echo $dns1 ?>"/></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "dns1"); ?></td>
                                                <td></td> 
                                                <td>Dirección DNS secundaria:</td> 
                                                <td><input type="text" name="dns2" size="30" value="<?php echo $dns2 ?>"/></td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "dns2"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Puerta de enlace :</td>
                                                <td><input type="text" name="gateway" size="30" value="<?php echo $gateway ?>"/> </td>
                                                <td><?php echo isFieldRequired("edit_computer.php", "gateway"); ?></td>
                                                <td></td><td></td> 
                                                <td></td><td></td>

                                                <td><input type="submit" class="normalButton" name="saveComputer" value="Guardar datos"/> </td>
                                                <td></td><td></td><td></td>
                                                <td><input type="submit" class="normalButton" name="cancel" value="Cancelar"/> </td>
                                            </tr>

                                        </table>
                                        </fieldset>   

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

