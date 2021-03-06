<?php

    header('Content-Type: text/html; charset=UTF-8');
    
    require_once "ini.php";
    check_session();
    $_SESSION["actual_page"] = "new_building.php";
    $errores = "";
    $maxCar = 50;
    $nameBuilding = "";
    
    if(array_key_exists("cancel", $_POST))
    {
    redirect("list_building.php");
    }
   
    if(array_key_exists("saveBuilding", $_POST))
    {
        if(!array_key_exists("nombre", $_POST))
        {
            echo "No hay datos que guardar<br>";
        }  
        else
        {
            $nameBuilding = $_POST["nombre"];
            trim($nameBuilding);
            
            if (is_empty ($nameBuilding))
            {
                $errores.= "- El campo nombre no puede estar vacio</br>";
            }
            else
            {
                if (validar_cadena($nameBuilding,$maxCar)==2)
                {
                    $errores .= "el campo nombre no puede ser numericobr>";
                } 
                else 
                {
                    if (validar_cadena($nameBuilding,$maxCar)==3)
                    {
                        $errores .= "el campo nombre no puede tener mas "
                                . "de " . $maxCar . " caracteresbr>";
                    }
                }
            }
        }
               
        $idCampus = $_POST["campus"];

        $insertBuilding = "insert into $tableBuilding (name_building, id_campus) values ("
                            . comillas($nameBuilding). "," .$idCampus. ")";

        if ($errores == "")
        {   

            if (execute_query($insertBuilding))//comprobamos que la query se hizo correcta
            {
                alert_js("Datos guardados con éxito.");
                redirect("list_building.php");
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
                                         <legend><B>RETISTRO DE EDIFICIO</B></legend>
                                    <form action="" method="post">
                                        <table>

                                            <tr><td>Nombre del Edificio:</td><td><input type="text" name="nombre" value="<?php echo $nameBuilding;?>"/></td></tr>
                                            <tr><td>Nombre del Campus: </td>

                                                <td> <?php echo generateSelectWithOptions("campus", "campus", 
                                                                                           "id_campus", "name_campus"); ?></td>
                                                <td></td><td></td> 
                                                <td></td><td></td>

                                                <td><input type="submit" class="normalButton" name="saveBuilding" value="Guardar datos"/> </td>
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
