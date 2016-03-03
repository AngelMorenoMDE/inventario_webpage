<?php
    require_once "ini.php";
    check_session();
    $_SESSION["actual_page"] = "edit_project.php";  
    $errores = "";
    $maxCar = 50;       
    
        
    if(array_key_exists("cancel", $_POST))
    {
    redirect("list_project.php");
    } 
    
    if(array_key_exists("idProject", $_SESSION)) 
    {
    
        $idProject = $_SESSION["idProject"];

        $selectProject = "select * from $tableProject where id_project=" . $idProject . ";";
        
        $rowProject = select_one($selectProject);
        
        $nameProject = $rowProject['name_project'];
        $status = $rowProject['id_project_status'];
        $summary = $rowProject['summary'];
        
        $nameUserM = $rowProject['id_user_modify'];
        $dateModify = $rowProject['date_modify'];
    }     
    else    
    {
        redirect("list_project.php");
    }
        
        //recogemos nuevos datos
    if(array_key_exists("saveProject", $_POST))
    {   
         
        $summary = $_POST["summary"];
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
        if(array_key_exists("status", $_POST))
        {
            $idUserDelete = getUserInSession();
            $dateDelete  = time();
            $status = 2;
            $editProject = "update $tableProject set name_project = " . comillas($nameProject) .
                        ", id_project_status =" . $status .     
                        ", id_user_delete =" . $idUserDelete . 
                        ", date_modify = " . $dateDelete .
                        ", summary = "  .comillas($summary) .
                        " where id_project =" . $idProject . ";";
        }
        else 
        {
            $id_user_modify = getUserInSession();
            $date_modify = time();   
        
            $editProject = "update $tableProject set name_project = " . comillas($nameProject) .
                        ", id_user_modify =" . $id_user_modify . 
                        ", date_modify = " . $date_modify .
                        ", summary = "  .comillas($summary) .
                        " where id_project =" . $idProject . ";";
        }
        
        

        if ($errores == "")
        {   
           
            if (execute_query($editProject))//comprobamos que la query se hizo correcta
            {
               
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
                                         <legend><B>EDITOR DE PROYECTO</B></legend>
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <table>
                                            <tr>
                                                <td>Nombre de Proyecto:</td>
                                                <td><input type="text" size="50" name="name_project" value="<?php echo $nameProject;?>"/> </td>
                                                <td><?php echo isFieldRequired("edit_project.php", "name_project"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Comentarios:</td>
                                                <td><textarea name="summary"><?php echo $summary;?></textarea></td>
                                                <td><?php echo isFieldRequired("edit_project.php", "name_project"); ?></td>
                                            </tr>
                                             <tr>
                                                <td>Finalizar Proyecto:</td>
                                                <td><input type="checkbox"  name="status"></input> </td>
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
