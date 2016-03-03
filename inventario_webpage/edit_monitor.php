<?php
    require_once "ini.php";
    check_session();
    $_SESSION["actual_page"] = "edit_monitor.php";  
    $errores = "";
    $maxCar = 50; 
    
    $vga_checked="";
    $dvi_checked="";
    $pathImage= getImagePath();
    
    if(array_key_exists("cancel", $_POST))
    {
    redirect("search_monitor.php");
    } 
    
    if(array_key_exists("idElectronic", $_SESSION)) 
    {
    
        $idElectronic = $_SESSION["idElectronic"];

        $selectEq = "select * from $tableElectEq where id_electronic_eq =" .  $idElectronic . ";" ;
        $selectMonitor = "select * from $tableMonitor where id_electronic_eq=" .  $idElectronic . ";"  ; 

        $rowElectronic = select_one($selectEq);
        $rowMonitor = select_one($selectMonitor);
        
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
        
        $trademark = $rowMonitor['trademark'];
        $model = $rowMonitor['model'];
        $no_inch = $rowMonitor['no_inch'];
        $monitor_type = $rowMonitor['monitor_type'];
        $vga = $rowMonitor['vga'];
        $dvi = $rowMonitor['dvi'];

        
        if($rowMonitor['vga'])
        {
            $vga_checked="checked";
        }
        
        if($rowMonitor['dvi'])
        {
            $dvi_checked="checked";
        }

        
    } 
    else
    {
        redirect("list_monitor.php");
    }

    if(array_key_exists("saveMonitor", $_POST))
    {   
        if (!array_key_exists("urjc_code", $_POST))
        {
            $errores .= "No hay datos que guardar<br>";
        }
        else 
        {
            $codeUrjc = $_POST["urjc_code"];
            trim($codeUrjc);
            
            if (is_empty($codeUrjc))
            {
                $errores .= "El campo codigo URJC no puede estar vacio<br>";
            }
            else
            {
                if (!validate_integer($codeUrjc))
                {
                    $errores .= "el campo codigo URJC debe contener un numero entero<br>";
                }
            }
        }
    
        
        if (!array_key_exists("serial_number", $_POST))
        {
            $errores .= "No hay datos que guardar<br>";
        }
        else 
        {   
            $serialNumber = $_POST["serial_number"];
            trim($serialNumber);

            if (is_empty($serialNumber))
            {
                $errores .= "El campo numero de serie no puede estar vacio<br>";
            }

            else 
            {

                if (validar_cadena($serialNumber,$maxCar)==3)
                {
                    $errores .= "el campo numero de serie no puede tener mas "
                                . "de " . $maxCar . " caracteres<br>";
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
                $errores .= "- Fichero 1 Extensión incorrecta<br>";
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
                $errores .= "- Fichero 2 Extensión incorrecta<br>";
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
        $idUserAsigned = $_POST["id_user_asigned"];
        $idUserModify = getUserInSession();
        $dateModify = time();
        $description = $_POST["description"];

        //recogemos datos de monitor
        if (!array_key_exists("trademark", $_POST))
        {
            $errores .= "No hay datos que guardar";
        }
        else 
        {   
            $trademark = $_POST["trademark"];
            trim($trademark);

            if (is_empty($trademark))
            {
                $errores .= "El campo marca no puede estar vacio<br>";
            }

            else 
            {
                if (validar_cadena($trademark,$maxCar)==2)
                {
                    $errores .= "el campo marca no puede ser numerico<br>";
                } 
                else 
                {
                    if (validar_cadena($trademark,$maxCar)==3)
                    {
                        $errores .= "el campo marca no puede tener mas "
                                    . "de " . $maxCar . " caracteres<br>";
                    }
                }
            }
        }
                                        
        if (!array_key_exists("model", $_POST))
        {
            $errores .= "No hay datos que guardar<br>";
        }
        else 
        {   
            $model = $_POST["model"];
            trim($model);

            if (is_empty($model))
            {
            $errores .= "El campo modelo no puede estar vacio<br>";
            }

            else 
            {

                if (validar_cadena($model,$maxCar)==3)
                {
                    $errores .= "el campo modelo no puede tener mas "
                                . "de " . $maxCar . " caracteres<br>";
                }
            }
        }

        
        $no_inch = $_POST["inch"];
            
        $monitor_type = $_POST["monitor_type"];

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

        $editEq = "update $tableElectEq set urjc_code = " . $codeUrjc .
                    ", serial_number =" . comillas($serialNumber) .
                    ", id_office =" . $idOffice .
                    ", image_1 = " . comillas($image1_name) . 
                    ", image_2 = " . comillas($image2_name) .
                     ", status =" . $status .
                    ", id_user_asigned =" . $idUserAsigned .
                    ", id_user_modify =" . $idUserModify . 
                    ", id_user_delete =" . $idUserDelete . 
                    ", date_modify = " . $dateModify .
                    ", date_delete = " . $dateDelete .
                ", description = " . comillas($description).
                    " where id_electronic_eq =" .  $idElectronic . ";";

        $editMonitor = "update $tableMonitor set trademark = " . comillas($trademark). 
                        ", model =" . comillas($model) .
                        ", no_inch =" . $no_inch .
                        ", monitor_type =" . comillas($monitor_type) .
                        ", vga =" . $vga .
                        ", dvi =" . $dvi .
                        " where id_electronic_eq =" .  $idElectronic . ";";

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
            if ((execute_query($editEq)) && (execute_query($editMonitor)))//comprobamos que la query se hizo correcta
            {
                alert_js("Datos guardados con éxito.");
                redirect("search_monitor.php");
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

                                     <fieldset>
                                         <legend><B>EDITOR DE MONITOR</B></legend>
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <table>
                                            <tr>
                                                <td>Código URJC:</td>
                                                <td><input type="text" size="50" name="urjc_code" value="<?php echo $codeUrjc;?>"/> </td>
                                                <td><?php echo isFieldRequired("edit_monitor.php", "urjc_code"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Número de Serie:</td>
                                                <td><input type="text" size="50" name="serial_number" value="<?php echo $serialNumber;?>"/> </td>
                                                <td><?php echo isFieldRequired("edit_monitor.php", "serial_number"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Despacho</td>
                                                <td><?php echo generateSelectOffice($idConjunto); ?> </td>
                                                <td><?php echo isFieldRequired("edit_monitor.php", "id_office"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Imagen 1:</td>
                                                <td><input name="image_1" type="file" size="50" /> </td>
                                                <td><a href="<?php echo $pathImage1 ;?>" target="_blank">Ver Imagen</a></td>
                                                <td><?php echo isFieldRequired("edit_monitor.php", "image_1"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Imagen 2:</td>
                                                <td><input name="image_2" type="file" size="50" /> </td>
                                                <td><a href="<?php echo $pathImage2 ;?>" target="_blank">Ver Imagen</a></td>
                                                <td><?php echo isFieldRequired("edit_monitor.php", "image_2"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Estado:</td>
                                                <td><?php echo generateSelectWithOptions("status", "status",
                                                        "id_status", "name_status", $status); ?> </td>
                                                <td><?php echo isFieldRequired("edit_monitor.php", "status"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Asignado a usuario:</td>
                                                <td><?php echo generateSelectWithOptions("id_user_asigned", "user",
                                                        "id_user", "email", $idUserAsigned); ?> </td>
                                                <td><?php echo isFieldRequired("edit_monitor.php", "id_user_asigned"); ?></td>
                                            </tr> 
                                            <tr>
                                                <td>Marca:</td>
                                                <td><input type="text" size="50" name="trademark" value="<?php echo $trademark;?>"/> </td>
                                                <td><?php echo isFieldRequired("edit_monitor.php", "trademark"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Modelo:</td>
                                                <td><input type="text" size="50" name="model" value="<?php echo $model;?>"/></td>
                                                <td><?php echo isFieldRequired("edit_monitor.php", "model"); ?></td>
                                            </tr>
                                            <tr>
                                                    <td>Pulgadas: </td>
                                                    <td><SELECT NAME="inch" SIZE="1">
                                                        <OPTION VALUE="1">15</OPTION>
                                                        <OPTION VALUE="2">17</OPTION>
                                                        <OPTION VALUE="3">19</OPTION>
                                                        <OPTION VALUE="4">21</OPTION>
                                                        </SELECT></td> 
                                                </tr>
                                                <td>Tipo de monitor: </td>
                                                <td> <?php echo generateSelectWithOptions("monitor_type", "monitor_type",
                                                        "id_monitor_type", "name_monitor_type",$monitor_type ); ?> </td>
                                                <td><?php echo isFieldRequired("edit_monitor.php", "monitor_type"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>VGA</td><td><input type="checkbox" name="vga" <?php echo $vga_checked;?>/></td>
                                            </tr>
                                            <tr>
                                                <td>DVI</td><td><input type="checkbox" name="dvi" <?php echo $dvi_checked;?>/></td>
                                            </tr>
                                            <tr>
                                                <td>Comentarios:</td>
                                                <td><textarea  name="description"><?php echo $description ?></textarea></td>
                                           
                                             <td></td><td></td> 
                                            <td></td><td></td>

                                                <td><input type="submit" class="normalButton" name="saveMonitor" value="Guardar datos"/> </td>
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
