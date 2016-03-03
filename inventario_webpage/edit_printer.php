<?php
    require_once "ini.php";
    check_session();
    $_SESSION["actual_page"] = "edit_printer.php";  
    $errores = "";
    $maxCar = 50; 
    
    $color_checked ="";
    $laser_checked ="";
    $paralel_checked ="";
    $usb_checked ="";
    $ethernet_checked ="";
    
    $pathImage = getImagePath();
       
    if(array_key_exists("cancel", $_POST))
    {
    redirect("search_printer.php");
    } 
    if(array_key_exists("idElectronic", $_SESSION)) 
    {
    
        $idElectronic = $_SESSION["idElectronic"];
        
        $selectEq = "select * from $tableElectEq where id_electronic_eq =" . $idElectronic . ";" ;
        $selectPrinter = "select * from $tablePrinter where id_electronic_eq=" . $idElectronic . ";"  ; 
        
       
        $rowElectronic = select_one($selectEq);
        $rowPrinter = select_one($selectPrinter);
        
        $codeUrjc = $rowElectronic['urjc_code'];
        $serialNumber = $rowElectronic['serial_number'];
                
        $idOffice = $rowElectronic['id_office'];
        $idConjunto = generateIdConjunto($idOffice);
        
        $image1_name = $rowElectronic['image_1'];
        $pathImage1 = $pathImage . $image1_name;
        $image2_name = $rowElectronic['image_2'];
        $pathImage2 = $pathImage . $image2_name;
        $id_office = $rowElectronic['id_office'];
        $status = $rowElectronic['status'];
        $idUserAsigned = $rowElectronic['id_user_asigned'];
         $description = $rowElectronic['description'];
        
        $trademark = $rowPrinter['trademark'];
        $model = $rowPrinter['model'];
        $color = $rowPrinter['color'];
        $laser = $rowPrinter['laser'];
        $paralel = $rowPrinter['paralel'];
        $usb = $rowPrinter['usb'];
        $ethernet = $rowPrinter['ethernet'];
        $nameEquip = $rowPrinter["name_equip"];
        $domain = $rowPrinter["domain"];
        $ip = $rowPrinter["ip"];
        $mask = $rowPrinter["mask"];
        $dns1 = $rowPrinter["dns_1"];
        $dns2 = $rowPrinter["dns_2"];
        $gateway = $rowPrinter["gateway"];


        if($rowPrinter['color'])
        {
            $color_checked = "checked";
        }
        
        if($rowPrinter['laser'])
        {
            $laser_checked="checked";
        }
        
        if($rowPrinter['paralel'])
        {
            $paralel_checked="checked";
        }
        
        if($rowPrinter['usb'])
        {
            $usb_checked="checked";
        }
        
        if($rowPrinter['ethernet'])
        {
            $ethernet_checked="checked";
        }
                       

    } 
    else
    {
        redirect("list_printer.php");
    }

    //salvamos las modificaciones 
    if(array_key_exists("savePrinter", $_POST))
    {   
        
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
                $errores .= "El campo codigo URJC no puede estar vacio</br>";
            }
            else
            {
                if (!validate_integer($codeUrjc))
                {
                    $errores .= "el campo codigo URJC debe contener un numero entero</br>";
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
                $errores .= "El campo numero de serie no puede estar vacio</br>";
            }
            
            else 
            {
                        
                if (validar_cadena($serialNumber,$maxCar)==3)
                {
                    $errores .= "el campo numero de serie no puede tener mas "
                                . "de " . $maxCar . " caracteres</br>";
                }
            }
        }
                        
        $idOfficeConjunto = $_POST["id_office"];
        $idOffice = sacaId($idOfficeConjunto);

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
                $errores .= "- Fichero 1 Extensión incorrecta</br>";
            }
        }   

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
                $errores .= "- Fichero 2 Extensión incorrecta</br>";
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
        $idUserAsigned = $_POST["idUserAsigned"];
        $idUserModify = getUserInSession();
        $dateModify = time();
        $description = $_POST["description"];

        //recogemos datos de la impresora

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
                $errores .= "El campo marca no puede estar vacio</br>";
            }
            
            else 
            {
                if (validar_cadena($trademark,$maxCar)==2)
                {
                    $errores .= "el campo marca no puede ser numerico</br>";
                } 
                else 
                {
                    if (validar_cadena($trademark,$maxCar)==3)
                    {
                        $errores .= "el campo marca no puede tener mas "
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
                $errores .= "El campo modelo no puede estar vacio</br>";
            }
            
            else 
            {
                                               
                if (validar_cadena($model,$maxCar)==3)
                {
                    $errores .= "el campo modelo no puede tener mas "
                                . "de " . $maxCar . " caracteres</br>";
                }
            }
        }

        $color = 0;
        if (array_key_exists("color", $_POST))
        {
            $color = 1;
        }

        $laser = 0;
        if (array_key_exists("laser", $_POST))
        {
            $laser = 1;
        }

        $paralel = 0;
        if (array_key_exists("paralel", $_POST))
        {
            $paralel = 1;
        }

        $usb = 0;
        if (array_key_exists("usb", $_POST))
        {
            $usb = 1;
        }

        $ethernet = 0;
        if (array_key_exists("ethernet", $_POST))
        {
            $ethernet = 1;
        }
                                        
        $nameEquip = $_POST["name_equip"];
        $domain = $_POST["domain"];
        $ip = $_POST["ip"];
        $mask = $_POST["mask"];
        $dns1 = $_POST["dns1"];
        $dns2 = $_POST["dns2"];
        $gateway = $_POST["gateway"];
                                       
        trim($nameEquip);
        trim($domain);
        trim($ip);
        trim($mask);
        trim($dns1);
        trim($dns2);
        trim($gateway);

                                            
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
                    ", id_office =" . $idOffice .
                    ", image_1 = " . comillas($image1_name) . 
                    ", image_2 = " . comillas($image2_name) .
                    ", status = " . $status .
                    ", id_user_asigned =" . $idUserAsigned .
                    ", id_user_modify =" . $idUserModify . 
                    ", id_user_delete =" . $idUserDelete . 
                    ", date_modify = " . $dateModify .
                    ", date_delete = " . $dateDelete .
                ", description = " . comillas($description).
                    " where id_electronic_eq =" . $idElectronic. ";";


        $editPrinter= "update $tablePrinter set trademark = " . comillas($trademark). 
                        ", model =" . comillas($model) .
                        ", color =" . $color .
                        ", laser =" . $laser .
                        ", paralel =" . $paralel .
                        ", usb =" . $usb .
                        ", ethernet =" . $ethernet .
                        ", name_equip =" . comillas($nameEquip) .
                        ", domain =" . comillas($domain) .
                        ", ip =" . comillas($ip) .
                        ", mask =" . comillas($mask) .
                        ", dns_1 =" . comillas($dns1) .
                        ", dns_2 =" . comillas($dns2) .
                        ", gateway =" . comillas($gateway) .
                        " where id_electronic_eq =" . $idElectronic . ";";

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
            if ((execute_query($editEq)) && (execute_query($editPrinter)))//comprobamos que la query se hizo correcta
            {
               
                redirect("search_printer.php");
            }
        }
        else 
        {
            $errores = "Se han producido los siguientes errores: <br>".$errores;     
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
                                           <legend><b>EDITOR DE IMPRESORA</b></legend>

                                           <table>
                                               <tr>
                                                   <td>Código URJC:</td>
                                                   <td><input type="text" name="urjc_code" size="50" value="<?php echo $codeUrjc;?>"/> </td>
                                                   <td><?php echo isFieldRequired("edit_printer.php", "urjc_code"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Número de Serie:</td>
                                                   <td><input type="text" name="serial_number" size="50" value="<?php echo $serialNumber;?>"/> </td>
                                                   <td><?php echo isFieldRequired("edit_printer.php", "serial_number"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Despacho</td>
                                                   <td><?php echo generateSelectOffice($idConjunto); ?> </td>
                                                   <td><?php echo isFieldRequired("new_printer.php", "id_office" ); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Imagen 1:</td>
                                                   <td><input name="image_1" type="file" size="50" /> </td>
                                                   <td><a href="<?php echo $pathImage1 ;?>" target="_blank">Ver Imagen</a></td>
                                                   <td><?php echo isFieldRequired("edit_printer.php", "image_1"); ?></td>
                                               </tr>

                                               <tr>
                                                   <td>Imagen 2:</td>
                                                   <td><input name="image_2" type="file" size="50" /> </td>
                                                   <td><a href="<?php echo $pathImage2 ;?>" target="_blank">Ver Imagen</a></td>
                                                   <td><?php echo isFieldRequired("edit_printer.php", "image_2"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Estado:</td>
                                                   <td><?php echo generateSelectWithOptions("status", "status",
                                                           "id_status", "name_status", $status); ?> </td>
                                                   <td><?php echo isFieldRequired("edit_printer.php", "status"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Usuario asignado:</td>
                                                   <td><?php echo generateSelectWithOptions("idUserAsigned", "user", "id_user", "email", $idUserAsigned);?></td>
                                                   <td><?php echo isFieldRequired("edit_printer.php", "idUserAsigned"); ?></td>
                                               </tr>  
                                               <tr>
                                                   <td>Marca:</td>
                                                   <td><input type="text" name="trademark" size="50" value="<?php echo $trademark;?>"/> </td>
                                                   <td><?php echo isFieldRequired("edit_printer.php", "trademark"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Modelo:</td>
                                                   <td><input type="text" name="model" size="50" value="<?php echo $model;?>"/></td>
                                                   <td><?php echo isFieldRequired("edit_printer.php", "model"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Tipo de impresión:</td><td></td><td>Tipo de conector:</td>
                                               </tr>
                                               <tr>
                                                   <td>Color</td><td><input type="checkbox" name="color" <?php echo $color_checked;?>/></td>
                                                   <td>Paralelo</td><td><input type="checkbox" name="paralel" <?php echo $paralel_checked;?>/></td>
                                               </tr>
                                               <tr>
                                                   <td>Láser</td><td><input type="checkbox" name="laser" <?php echo $laser_checked;?>/></td>
                                                   <td>USB</td><td><input type="checkbox" name="usb" <?php echo $usb_checked;?>/></td>
                                               </tr>

                                               <tr>
                                                   <td></td><td></td>
                                                   <td>Ethernet</td><td><input type="checkbox" name="ethernet" <?php echo $ethernet_checked;?>/></td>
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
                                                   <td><input type="text" name="name_equip" size="30" value="<?php echo $nameEquip;?>"/> </td>
                                                   <td><?php echo isFieldRequired("edit_printer.php", "name_equip"); ?></td>
                                                   <td></td> 
                                                   <td>Nombre del dominio :</td>
                                                   <td><input type="text" name="domain" size="30" value="<?php echo $domain;?>"/> </td>
                                                   <td><?php echo isFieldRequired("edit_printer.php", "domain"); ?></td>
                                               </tr>

                                               <tr>
                                                   <td>Dirección IP:</td>
                                                   <td><input type="text" name="ip" size="30" value="<?php echo $ip;?>"/></td>
                                                   <td><?php echo isFieldRequired("edit_printer.php", "ip"); ?></td>
                                                   <td></td> 
                                                   <td>Máscara de red:</td> 
                                                   <td><input type="text" name="mask" size="30" value="<?php echo $mask;?>"/></td>
                                                   <td><?php echo isFieldRequired("edit_printer.php", "mask"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Dirección DNS primaria:</td>
                                                   <td><input type="text" name="dns1" size="30" value="<?php echo $dns1;?>"/></td>
                                                   <td><?php echo isFieldRequired("edit_printer.php", "dns1"); ?></td>
                                                   <td></td> 
                                                   <td>Dirección DNS secundaria:</td> 
                                                   <td><input type="text" name="dns2" size="30" value="<?php echo $dns2;?>"/></td>
                                                   <td><?php echo isFieldRequired("edit_printer.php", "dns2"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Puerta de enlace :</td>
                                                   <td><input type="text" name="gateway" size="30" value="<?php echo $gateway;?>"/> </td>
                                                   <td><?php echo isFieldRequired("edit_printer.php", "gateway"); ?></td>
                                                   <td></td><td></td> 
                                                   <td></td><td></td>

                                                   <td><input type="submit" class="normalButton" name="savePrinter" value="Guardar datos"/> </td>
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




