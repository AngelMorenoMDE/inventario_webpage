<?php
    require_once "ini.php";
    check_session();
    $_SESSION["actual_page"] = "edit_building.php";  
    $errores = "";
    $maxCar = 50;
    
    
    if(array_key_exists("cancel", $_POST))
    {
    redirect("list_building.php");
    } 
    
    if(array_key_exists("idBuilding", $_SESSION)) 
    {
        $idbuilding = $_SESSION["idBuilding"];

        $selectBuilding = "select * from $tableBuilding where id_building=" . $idbuilding . ";"  ; 

        $rowBuilding = select_one($selectBuilding);

        $nameBuilding = $rowBuilding['name_building'];
        $idCampus = $rowBuilding['id_campus'];

        

    } 
    else
    {
        redirect("list_building.php");
    }

    if(array_key_exists("saveBuilding", $_POST))//recogemos los datos nuevos
    {   

        if(!array_key_exists("nombre", $_POST))
        {
            echo "No hay datos que guardar";
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
                    $errores .= "el campo nombre no puede ser numerico</br>";
                } 
                else 
                {
                    if (validar_cadena($nameBuilding,$maxCar)==3)
                    {
                        $errores .= "el campo nombre no puede tener mas "
                                    . "de " . $maxCar . " caracteres</br>";
                    }  
                    $idcampus = $_POST["campus"];


                    $editBuilding="update $tableBuilding set name_building = "
                                    . "" . comillas($nameBuilding). 
                                    " , id_campus =" . $idcampus .
                                    " where id_building = $idbuilding;";

                    if ($errores == "")
                    {   
                        if (execute_query($editBuilding))
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
            }
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
                                         <legend><B>EDITOR DE EDIFICIO</B></legend>
                                    <form action="" method="post">
                                        <table>
                                            <tr>
                                                <td>
                                                    Nombre del edificio: 
                                                </td>
                                                <td>
                                                    <input type="text" name="nombre" value="<?php echo $nameBuilding; ?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Nomre del campus:                   
                                                </td>
                                                <td>
                                                    <?php echo $campus_select = generateSelectWithOptions("campus", 
                                                                                   "campus", 
                                                                                   "id_campus", 
                                                                                   "name_campus",
                                                                                   $idCampus); ?>                   
                                                </td>                
                                            </tr>

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




