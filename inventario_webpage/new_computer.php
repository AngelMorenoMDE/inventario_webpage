<?php
    header('Content-Type: text/html; charset=UTF-8');
    
    
    require_once "ini.php";
    check_session();
    $_SESSION["actual_page"] = "new_computer.php";
    
    $errores = "";
    $maxCar = 50;

    $codeUrjc = "";
    $serialNumber = "";
    $trademark = "";
    $model = "";
    $cpuName = "";
    $cpuMhz = "";
    $ramMb = "";
    $hdd1Gb = "";
    $hdd2Gb = "";
    $graphicCard = "";
    $soundCard = "";
    $etherCard = "";
    $usb = "";
    $ssoo = "";
    $ssooType = "";
    $nameEquip = "";
    $domain = "";
    $ip = "0.0.0.0";
    $mask = "0.0.0.0";
    $dns1 = "0.0.0.0";
    $dns2 = "0.0.0.0";
    $gateway = "0.0.0.0";
    $description = "";
    
   if(array_key_exists("cancel", $_POST))
    {
    redirect("new_eq.php");
    }
    // cuando pulsamos tecla guardar comenzamos la  query
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
        $image1_name = "";
        $image1_ok = false;  //baliza para comprobar que le proceso se hace correcto
        if (is_empty($_FILES["image_1"]["name"]))
        {
            $image1_name = "No hay foto";
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
                $errores .= "Fichero 1 Extensión incorrecta</br>";
            }
        }   

        //recogemos datos del archivo de imagen
        $image2_name = "";
        $image2_ok = false;  //baliza para comprobar que le proceso se hace correcto
        if (is_empty($_FILES["image_2"]["name"]))
        {
            $image2_name = "No hay foto";
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
                $errores .= "- Fichero 2 Extensión incorrecta</br>";
            }
        }

        $status = $_POST["status"];
        $idUserAsigned = $_POST["id_user_asigned"];
        $idUserCreation = getUserInSession();
        $idUserModify = getUserInSession();
        $dateCreation = time();
        $dateModify = time();
        
        if($status==3)
        {
            $idUserDelete = getUserInSession();
            $dateDelete = time();
        }
        else
        {
            $idUserDelete = -1;
            $dateDelete = -1;
        }
        
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
                                                                                            
        
        $ssoo = $_POST["ssoo"];
                                                                                           
        $ssooType = $_POST["ssootype"];
        $nameEquip = $_POST["nameequip"];
        $domain = $_POST["domain"];

        $ip = $_POST["ip"];
        if(!filter_var($ip, FILTER_VALIDATE_IP))
        {
            $errores .="IP no válida"; 
        }

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
        trim($mask);
        trim($dns1);
        trim($dns2);
        trim($gateway);


        if  (!is_numeric($hdd2Gb))                  
        {
            $errores.= "El campo \"capacidad disco interno 2\" debe ser numérico</br>";
        }
        if (strlen($soundCard)>50)                 
        {
            $errores.= "El campo \"tarjeta de sonido\" no puede contener mas de 50 caracteres</br>";
        }
        if (strlen($etherCard)>50)                 
        {
            $errores.= "El campo \"tarjeta de red\" no puede contener mas de 50 caracteres</br>";
        }
        if  (!is_numeric($usb))                  
        {
            $errores.= "El campo \"Número de usb\" debe ser numérico</br>";
        }
        if (strlen($ssooType)>20)                 
        {
            $errores.= "El campo \"Tipo de sistema operativo\" no puede contener mas de 50 caracteres</br>";
        }
        if (strlen($nameEquip)>50)                 
        {
            $errores.= "El campo \"Nombre de Equipo\" no puede contener mas de 50 caracteres</br>";
        }
        if (strlen($domain)>50)                 
        {
            $errores.= "El campo \"Nombre de Dominio\" no puede contener mas de 50 caracteres</br>";
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

        //select para sacar id de tipo equipo electronico
        $selectTypeEq= "select id_elect_eq_type from $tableElectEqType where name_elect_eq_type ='ordenador';";
        $rowTypeEq= select_one($selectTypeEq);
        $idElectronicEqType = $rowTypeEq['id_elect_eq_type'];

        // Insertamos datos en equipo electonico
        $insertEquip = "insert into $tableElectEq (electronic_eq_type, urjc_code, serial_number,";
        $insertEquip .= "id_office, image_1, image_2, status, id_user_asigned, id_user_creation, id_user_modify,";
        $insertEquip .= "id_user_delete, date_creation, date_modify, date_delete, description) values ";
        $insertEquip .= "(" .$idElectronicEqType . "," . $codeUrjc . "," . comillas($serialNumber) .
                        "," . $idOffice . "," . comillas($image1_name) . "," . comillas($image2_name) .
                        "," . $status . "," . $idUserAsigned . "," . $idUserCreation .
                        "," . $idUserModify . "," . $idUserDelete . "," . $dateCreation .
                        "," . $dateModify . "," . $dateDelete . "," . comillas($description) .");";

        // Inser ELec EQ
        $insertELEQ_ok = false;
        if ($errores == "")
        {   
            if (execute_query($insertEquip))
            {
                $insertELEQ_ok = true;
            }
            else
            {
                die("Error de inserción");
            }
        }
        
        if ($insertELEQ_ok)
        {
            // Hacemos select para sacar el id del equipo electónico
            $selectEq= "select * from $tableElectEq where date_creation = $dateCreation;";
            $rowEq= select_one($selectEq);
            $idElectronic = $rowEq['id_electronic_eq']; 

            $insertComputer = "insert into $tableComputer ";
            $insertComputer .= "(id_electronic_eq, trademark, model, type_computer, cpu_name, no_mhz, ram_type,";
            $insertComputer .=  "ram_mb, hdd1_type, hdd1_gb, hdd2_type, hdd2_gb, graphic_card,";
            $insertComputer .= "sound_card, ethernet_card, id_cd_unit1, id_cd_unit2, vga, dvi, hdmi,";
            $insertComputer .= "no_usb, ssoo, ssoo_type, name_equip, domain, ip, mask, dns_1, dns_2, gateway) ";
            $insertComputer .= "values (" . $idElectronic . "," . comillas($trademark) . ","
                                . comillas($model) . "," . $typeComputer . ","  
                                . comillas($cpuName) . "," . $cpuMhz . ","             
                                . $ramType . "," . $ramMb . ","   
                                . $hdd1Type . ",". $hdd1Gb . ","   
                                . $hdd2Type . "," . $hdd2Gb . ","   
                                . comillas($graphicCard) . ","   
                                . comillas($soundCard) . ","   
                                . comillas($etherCard) . ","   
                                . $cdUnit1 . ",". $cdUnit2 . ","   
                                . $vga . "," . $dvi . ","   
                                . $hdmi . "," . $usb . ","   
                                . comillas($ssoo) . ","  
                                . comillas($ssooType) . ","  
                                . comillas($nameEquip) . ","  
                                . comillas($domain) . ","
                                . comillas($ip) . ","  
                                . comillas($mask) . ","  
                                . comillas($dns1) . ","  
                                . comillas($dns2) . ","  
                                . comillas($gateway) . ");";         

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
                    if (execute_query($insertComputer))
                    {
                        alert_js("Datos guardados con éxito.");
                        redirect("search_computer.php");

                    }
            }
            else
            {
                $errores= "Se han producido los siguientes errores: <br>" .$errores;
            }
        }
        else // Falla Insert EL EQ
        {
           echo "error al insertar equipo"; 
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
                                               <legend><B>DATOS DE ORDENADOR</B></legend>
                                           <table>
                                               <tr>
                                                   <td>Código URJC:</td>
                                                   <td><input type="text" size="50" name="urjc_code" value="<?php echo $codeUrjc;?>"/> </td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "urjc_code"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Número de Serie:</td>
                                                   <td><input type="text" size="50" name="serial_number" value="<?php echo $serialNumber;?>"/> </td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "serial_number"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Despacho</td>
                                                   <td><?php echo generateSelectOffice(); ?> </td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "id_office"); ?></td>
                                               </tr>
                                               
                                               <tr>
                                                   <td>Imagen 1:</td>
                                                   <td><input name="image_1" type="file" size="50" /> </td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "image_1"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Imagen 2:</td>
                                                   <td><input name="image_2" type="file" size="50" /> </td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "image_2"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Estado:</td>
                                                   <td><?php echo generateSelectWithOptions("status", "status",
                                                           "id_status", "name_status"); ?> </td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "status"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Asignado a usuario:</td>
                                                   <td><?php echo generateSelectWithOptions("id_user_asigned", "user",
                                                           "id_user", "email"); ?> </td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "id_user_asigned"); ?></td>
                                               </tr>
                                               
                                               <tr>
                                                   <td>Marca :</td>
                                                   <td><input type="text" size="50" name="trademark" value="<?php echo $trademark;?>"/> </td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "trademark"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Modelo:</td>
                                                   <td><input type="text" size="50" name="model" value="<?php echo $model;?>"/></td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "model"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Tipo de ordenador:</td>
                                                   <td><?php echo generateSelectWithOptions("typecomputer", "computer_type",
                                                           "id_computer_type", "name_computer_type"); ?></td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "typecomputer"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Tipo CPU:</td> 
                                                   <td><input type="text" size="50" name="cpuname" value="<?php echo $cpuName;?>"/></td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "cpuname"); ?></td>
                                                   <td></td>
                                                   <td>Velocidad CPU:</td> 
                                                   <td><input type="text"  name="cpumhz" size="10" value="<?php echo $cpuMhz;?>"/>Mhz</td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "cpumhz"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Tipo de RAM:</td> 
                                                   <td><?php echo generateSelectWithOptions("ramtype", "ram_type",
                                                           "id_ram_type", "name_ram_type"); ?></td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "ramtype"); ?></td>
                                                   <td></td>
                                                   <td>Capacidad RAM:</td> 
                                                   <td><input type="text"  name="rammb" size="10"value="<?php echo $ramMb;?>"/>Mb</td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "rammb"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Tipo disco interno 1:</td> 
                                                   <td><?php echo generateSelectWithOptions("hdd1type", "hdd_type",
                                                           "id_hdd_type", "name_hdd_type"); ?></td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "hdd1type"); ?></td>
                                                   <td></td>
                                                   <td>Capacidad disco interno 1:</td> 
                                                   <td><input type="text" name="hdd1_gb" size="10" value="<?php echo $hdd1Gb;?>">Gb</td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "hdd1_gb"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Tipo disco interno 2:</td>
                                                   <td><?php echo generateSelectWithOptions("hdd2type", "hdd_type",
                                                           "id_hdd_type", "name_hdd_type"); ?></td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "hdd2type"); ?></td>
                                                   <td></td>
                                                   <td>Capacidad disco interno 2:</td> 
                                                   <td><input type="text" name="hdd2_gb" size="10" value="<?php echo $hdd2Gb;?>"/>Gb</td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "hdd2_gb"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Tarjeta gráfica :</td>
                                                   <td><input type="text" size="50" name="graphiccard" value="<?php echo $graphicCard;?>"/> </td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "graphiccard"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Tarjeta de sonido :</td>
                                                   <td><input type="text" size="50" name="soundcard" value="<?php echo $soundCard;?>"/> </td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "soundcard"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Tarjeta de red :</td>
                                                   <td><input type="text" size="50" name="ethercard" value="<?php echo $etherCard;?>"/> </td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "ethercard"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Unidad unidad lectora 1:</td>
                                                   <td><?php echo generateSelectWithOptions("cdunit1", "cd_type",
                                                           "id_cd_type", "name_cd_type"); ?></td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "cdunit1"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Unidad unidad lectora 2:</td>
                                                   <td><?php echo generateSelectWithOptions("cdunit2", "cd_type",
                                                           "id_cd_type", "name_cd_type"); ?></td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "cdunit2"); ?></td>
                                               <tr>
                                                   <td>Conector de video :</td>
                                                   <td>VGA:<input type="checkbox" name="vga"/>
                                                       DVI:<input type="checkbox" name="dvi"/>
                                                       HDMI:<input type="checkbox" name="hdmi"/></td>                
                                               </tr>
                                               <tr>
                                                   <td>Número de conectores USB :</td>
                                                   <td><input type="text" size="20" name="usb" value="<?php echo $usb;?>"> </td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "usb"); ?></td>
                                               </tr>
                                                <tr>
                                                    <td>Comentarios:</td>
                                                    <td><textarea  name="description"><?php echo $description;?></textarea></td>
                                                </tr>
                                           </table> 
                                           </fieldset>
                                           <fieldset>
                                            <legend><B>DATOS DE CONFIGURACION</B></legend>
                                           <table>
                                               <tr>
                                                   <td>Nombre del equipo :</td>
                                                   <td><input type="text" size="30" name="nameequip" value="<?php echo $nameEquip;?>"/> </td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "nameequip"); ?></td>
                                                   <td>Nombre del dominio :</td>
                                                   <td><input type="text" size="30" name="domain" value="<?php echo $domain;?>"/> </td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "domain"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Sistema Operativo:</td>
                                                   <td><?php echo generateSSOO("ssoo", $ssoo); ?></td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "ssoo"); ?></td> 
                                                   <td>Tipo de Sistema Operativo:</td> 
                                                   <td><input type="text" size="30" name="ssootype" value="<?php echo $ssooType;?>"/></td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "ssootype"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Dirección IP:</td>
                                                   <td><input type="text" size="30" name="ip" value="<?php echo $ip;?>"/></td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "ip"); ?></td> 
                                                   <td>Máscara de red:</td> 
                                                   <td><input type="text" size="30" name="mask" value="<?php echo $mask;?>"/></td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "mask"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Dirección DNS primaria:</td>
                                                   <td><input type="text" size="30" name="dns1" value="<?php echo $dns1;?>"/></td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "dns1"); ?></td>
                                                   <td>Dirección DNS secundaria:</td> 
                                                   <td><input type="text" size="30" name="dns2" value="<?php echo $dns2;?>"/></td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "dns2"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Puerta de enlace :</td>
                                                   <td><input type="text" size="30" name="gateway" value="<?php echo $gateway;?>"/> </td>
                                                   <td><?php echo isFieldRequired("new_computer.php", "gateway"); ?></td>

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



