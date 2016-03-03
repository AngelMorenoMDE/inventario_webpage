<?php
    header('Content-Type: text/html; charset=UTF-8');
  
    require_once "ini.php";
    check_session();
      $_SESSION["actual_page"] = "new_project.php";
    $errores = "";
    $maxCar = 50;
    
    $nameProject = "";
    $summary = "";
    
    if(array_key_exists("cancel", $_POST))
    {
    redirect("list_project.php");
    }
    
        
    if(array_key_exists("saveProject", $_POST))
    {
        //recogemos datos de equipo electrónico
        if (!array_key_exists("name_project", $_POST))
        {
            $errores .= "No hay datos que guardar<br>";
        }
        else 
        {
            $nameProject = $_POST["name_project"];
            trim($nameProject);
            
            if (is_empty($nameProject))
            {
                $errores .= "El campo nombre no puede estar vacio";
            }
             else 
            {
                        
                if (validar_cadena($nameProject,$maxCar)==3)
                {
                    $errores .= "el campo nombre no puede tener mas "
                                . "de " . $maxCar . " caracteres<br>";
                }
            }
            
        }
        
        $status = $_POST["status"];
        
        if($status==2)
        {
            $idUserDelete = getUserInSession();
            $dateDelete = time();
        }
        else
        {
            $idUserDelete = -1;
            $dateDelete = -1;
        }
        
        $summary = $_POST["summary"];
    
        $idUserCreation = getUserInSession();
        $idUserModify = getUserInSession();
        $dateCreation = time();
        $dateModify = time();
        
       
        $insertProject = "insert into $tableProject (name_project, id_project_status, id_user_creation, ";
        $insertProject .=   "id_user_modify, id_user_delete, date_creation, date_modify, date_delete, summary) values ";
        $insertProject .=  "(" . comillas($nameProject) .
                                  "," . $status .
                                  "," . $idUserCreation .
                                  "," . $idUserModify . 
                                  "," . $idUserDelete .
                                  "," . $dateCreation .
                                  "," . $dateModify .
                                  "," . $dateDelete . 
                                  "," . comillas($summary) .");";
        
        

            if ($errores == "")
            {   

                if (execute_query($insertProject))//comprobamos que la query se hizo correcta
                {
                    alert_js("Datos guardados con éxito.");
                    redirect("list_project.php");
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
                                                        <legend><b>REGISTRO DE PROYECTOS</b></legend>
                                       <form action="" method="post" enctype="multipart/form-data">
                                            <table>
                                               <tr>
                                                   <td>Nombre de Proyecto:</td>
                                                   <td><input type="text" size="50" name="name_project" value="<?php echo $nameProject;?>"/> </td>
                                                   <td><?php echo isFieldRequired("new_project.php", "name_project"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Estado:</td>
                                                   <td><?php echo generateSelectWithOptions("status", "project_status",
                                                           "id_project_status", "name_project_status"); ?> </td>
                                                   <td><?php echo isFieldRequired("new_project.php", "status"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Comentarios:</td>
                                                   <td><textarea name="summary"> <?php echo $summary;?></textarea></td>
                                               </tr>
                                                   <td></td><td></td> 
                                                   <td></td><td></td>
                                                   <td><input type="submit" class="normalButton" name="saveProject" value="Guardar datos"/> </td>
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
                