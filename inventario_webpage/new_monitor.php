<?php

    header('Content-Type: text/html; charset=UTF-8');
    
    require_once "ini.php";
    check_session();
    $_SESSION["actual_page"] = "new_monitor.php";
    $errores = "";
    $maxCar = 50;
    
    $codeUrjc = "";
    $serialNumber = "";
    $trademark = "";
    $model = "";
    $description = "";
        
    if(array_key_exists("cancel", $_POST))
    {
    redirect("new_eq.php");
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
                $errores .= "- Fichero 1 Extensión incorrecta<br>";
            }
        }   

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
                $errores .= "- Fichero 2 Extensión incorrecta<br>";
            }
        }

        $status = $_POST["status"];
        $idUserAsigned = $_POST["idUserAsigned"];
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
        
        if (!array_key_exists("trademark", $_POST))
        {
            $errores .= "No hay datos que guardar<br>";
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

        
        $inch = $_POST["inch"];
                                                                            
        $type = $_POST["type"];

        //para que estas variables siempre tengan un valor 
        //porque si no marcas el checkbox el post se qeda vacio y da error
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

        $selectTypeEq= "select id_elect_eq_type from $tableElectEqType where name_elect_eq_type ='monitor';";
        $rowTypeEq= select_one($selectTypeEq);
        $idElectronicEqType = $rowTypeEq['id_elect_eq_type'];

        $insertEquip = "insert into $tableElectEq (electronic_eq_type, urjc_code, serial_number,";
        $insertEquip .= "id_office, image_1, image_2, status, id_user_asigned,id_user_creation, id_user_modify,";
        $insertEquip .= "id_user_delete, date_creation, date_modify, date_delete, description) values ";
        $insertEquip .= "(" .$idElectronicEqType . "," . $codeUrjc .
                            "," . comillas($serialNumber) .
                            "," . $idOffice .
                            "," . comillas($image1_name) .
                            "," . comillas($image2_name) .
                            "," . $status . "," . $idUserAsigned .
                            "," . $idUserCreation .
                            "," . $idUserModify .
                            "," . $idUserDelete . 
                            "," . $dateCreation .
                            "," . $dateModify .
                            "," . $dateDelete . "," . comillas($description).");";

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

            $selectEq= "select * from $tableElectEq where date_creation = $dateCreation;";
            $rowEq= select_one($selectEq);

            $idElectronic = $rowEq['id_electronic_eq']; 

            $insertMonitor = "insert into $tableMonitor ";
            $insertMonitor .= "(id_electronic_eq, trademark, model, no_inch, monitor_type, vga, dvi) ";
            $insertMonitor .= "values (" . $idElectronic .
                                    "," . comillas($trademark) .
                                    "," . comillas($model) . 
                                    "," . $inch . 
                                    "," . comillas($type) .
                                    ","  . $vga .
                                    "," . $dvi . ");";         


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
                    if (execute_query($insertMonitor))
                    {
                        alert_js("Datos guardados con éxito.");
                        redirect("search_monitor.php");

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

                                         <fieldset>
                                             <legend><B>REGISTRO DE MONITOR</B></legend>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <table>
                                                <tr>
                                                    <td>Código URJC:</td>
                                                    <td><input type="text" size="50" name="urjc_code" value="<?php echo $codeUrjc;?>"/> </td>
                                                    <td><?php echo isFieldRequired("new_monitor.php", "urjc_code"); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Número de Serie:</td>
                                                    <td><input type="text" size="50" name="serial_number" value="<?php echo $serialNumber;?>"/> </td>
                                                    <td><?php echo isFieldRequired("new_monitor.php", "serial_number"); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Despacho</td>
                                                    <td><?php echo generateSelectOffice(); ?> </td>
                                                    <td><?php echo isFieldRequired("new_monitor.php", "id_office"); ?></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>Imagen 1:</td>
                                                    <td><input name="image_1" type="file" size="50" /> </td>
                                                    <td><?php echo isFieldRequired("new_monitor.php", "image_1"); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Imagen 2:</td>
                                                    <td><input name="image_2" type="file" size="50" /> </td>
                                                    <td><?php echo isFieldRequired("new_monitor.php", "image_2"); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Estado:</td>
                                                    <td><?php echo generateSelectWithOptions("status", "status",
                                                            "id_status", "name_status"); ?> </td>
                                                    <td><?php echo isFieldRequired("new_monitor.php", "status"); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Usuario asignado:</td>
                                                    <td><?php echo generateSelectWithOptions("idUserAsigned", "user", "id_user", "email");?></td>
                                                    <td><?php echo isFieldRequired("new_monitor.php", "idUserAsigned"); ?></td>
                                                </tr> 
                                                
                                                <tr>
                                                    <td>Marca:</td>
                                                    <td><input type="text" size="50" name="trademark" value="<?php echo $trademark;?>"/> </td>
                                                    <td><?php echo isFieldRequired("new_monitor.php", "trademark"); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Modelo:</td>
                                                    <td><input type="text" size="50" name="model" value="<?php echo $model;?>"/></td>
                                                    <td><?php echo isFieldRequired("new_monitor.php", "model"); ?></td>
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
                                                
                                                <tr>
                                                    <td>Tipo de monitor: </td>

                                                    <td> <?php echo generateSelectWithOptions("type", "monitor_type",
                                                            "id_monitor_type", "name_monitor_type"); ?></td>
                                                    <td><?php echo isFieldRequired("new_monitor.php", "type"); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>VGA</td><td><input type="checkbox" name="vga"></td>
                                                </tr>
                                                <tr>
                                                    <td>DVI</td><td><input type="checkbox" name="dvi"/></td>
                                                </tr>
                                                <tr>
                                                   <td>Comentarios:</td>
                                                   <td><textarea  name="description"><?php echo $description;?></textarea></td>
                                                
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
