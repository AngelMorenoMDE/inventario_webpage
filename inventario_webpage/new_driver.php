<?php

    header('Content-Type: text/html; charset=UTF-8');
    require_once 'ini.php';
    check_session();
    $_SESSION["actual_page"] = "new_driver.php";
    
    //para depurar alguna parte del código...en el ini estan 
    //declaradas las constantes
    if (debugOff)
    {
        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";
    }
    //
    
    $errores = "";
    $extension = "";
    
    if(array_key_exists("idElectronic", $_SESSION)) 
    {
    
        $idElectronic = $_SESSION["idElectronic"];
        
        if(array_key_exists("save", $_POST))
        {     
                        
            $description = $_POST["description"];
            $category = $_POST["category_driver"];
            $version = $_POST["version"];
            
            $dateUpload = time();
            $userUopload = getUserInSession();

            $driver_name = "";
            $driver_ok = false;  //baliza para comprobar que le proceso se hace correcto
            if (is_empty($_FILES["driver"]["name"]))
            {
                $driver_name = "No hay driver";
                $driver_ok = true;

            }

            else
            {
                $driver_name = $_FILES["driver"]["name"];
                $nameReal = $driver_name;
                $tamano = $_FILES["driver"]["size"]; 
                $type = $_FILES["driver"]["type"];

                if (check_extension_driver($driver_name)) //comprobamos extensión correcta
                {
                      //cambiamos nombre de archivo por tiempo en microsegundos
                    $driver_name = file_microseconds($driver_name);
                    $driver_ok = true;
                    $extension = sacarExtension($driver_name);
                } 
                else    // En caso de fallo
                {
                    $errores .= "-Extensión incorrecta<br>";
                }
            }

            $insertDriver = "insert into driver (id_electronic_eq, description, category_driver, name_real_driver, name_driver,";
            $insertDriver .= " extension_driver, mimetype_driver, size_driver, user_upload, date_upload, version) ";
            $insertDriver .= "values ("  . $idElectronic . ",". comillas($description) . "," 
                                        . comillas($category). "," 
                                        . comillas($nameReal) . ","
                                        . comillas($driver_name) . ","
                                        . comillas($extension) . ","
                                        . comillas($type). ","
                                        . $tamano . ","   
                                        . comillas($userUopload) . ","
                                        . $dateUpload . ","
                                        . comillas($version) .");";
                                         

            $insertDriver_ok = false;

            if ($errores == "")
            {   
                if ($driver_ok)     //si comprobación correcta:
                {
                    saveDriverInServer("driver", $driver_name);
                }
                if (execute_query($insertDriver))
                    {
                        $insertDriver_ok = true;
                        
                        $select ="select electronic_eq_type from $tableElectEq where id_electronic_eq = $idElectronic ;";
                        $rowtype = select_one($select);
                        $idType = $rowtype['electronic_eq_type'];

                        if ($idType == 1)
                        {
                            $_SESSION["idElectronic"] = $idElectronic;
                            redirect ("detail_computer.php");
                        }

                        if ($idType == 2)
                        {
                            $_SESSION["idElectronic"] = $idElectronic;
                            redirect ("detail_monitor.php");
                        }

                        if ($idType == 3)
                        {
                            $_SESSION["idElectronic"] = $idElectronic;
                            redirect ("detail_printer.php");
                        }

                        if ($idType == 4)
                        {
                            $_SESSION["idElectronic"] = $idElectronic;
                            redirect ("detail_mouse.php");
                        }

                        if ($idType == 5)
                        {
                            $_SESSION["idElectronic"] = $idElectronic;
                            redirect ("detail_keyboard.php");
                        }

                        if ($idType == 6)
                        {
                            $_SESSION["idElectronic"] = $idElectronic;
                            redirect ("detail_wire.php");
                        }
                        if ($idType == 7)
                        {
                            $_SESSION["idElectronic"] = $idElectronic;
                            redirect ("detail_scanner.php");
                        }
                        if ($idType == 8)
                        {
                            $_SESSION["idElectronic"] = $idElectronic;
                            redirect ("detail_projector.php");
                        }
                    }
                    else
                    {
                        die("Error de inserción");
                    }

            }
            else
            {
                $errores = "Se han producido los siguientes errores: <br>" .$errores;
            }               


        }
        
    }
    else
    {
        echo "no hay idElectronic en sesion";
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
                                            <legend><B>SUBIDA DE DRIVERS</B></legend>

                                        <form action="" method="post" enctype="multipart/form-data">
                                           <table>
                                               
                                               <tr>
                                                   <td>Categoría:</td>
                                                   <td><?php echo generateSelectWithOptions("category_driver", "category_driver_type",
                                                            "id_category", "name_category"); ?></td>
                                                   <td><?php echo isFieldRequired("new_driver.php", "category_driver"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Versión:</td>
                                                   <td><input type="text" size="50" name="version"/> </td>
                                                   <td><?php echo isFieldRequired("new_driver.php", "version"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Driver:</td>
                                                   <td><input type="file" name="driver" size="50" /> </td>
                                                    
                                               </tr>
                                               <tr>
                                                   <td>Comentarios:</td>
                                                   <td><textarea name="description"><?php echo $description;?></textarea> </td>
                                                   
                                               </tr>
                                               
                                                   <td></td><td></td> 
                                                   
                                                <tr>
                                                    <td><input type="submit" class="normalButton" name="save" value="Guardar driver"></input></td>
                                                   
                                                </tr>

                                           </table>
                                        </form>

                                        </fieldset>   
             
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

