<?php



    require_once "ini.php"; 
    check_session();
    $_SESSION["actual_page"] = "electronic_to_project.php";  
    $msg=null;
   $idElectronic = $_SESSION["idElectronic"];
   
  
    if(array_key_exists("saveProject", $_POST))
    {
       if(!array_key_exists("id_project", $_POST))
       {
           $errores = "NO SE HA SELECCIONADO NINGÚN PROYECTO.";
       }
        else 
        {
           $listEq = $_POST["id_project"];
           foreach($listEq as $valor)
           {
               $sel= "insert into project_eq values (" . $valor . "," . $idElectronic . ");";
               execute_query($sel);
           }
           redirect("list_project.php");
       }
       
       

    }

    
   
    $resultSearchHTML = "";
    
    $conexion = new_conex_db();

    $sel = "select id_project, name_project, id_project_status "
            . "from $tableProject where id_project not in "
            . "(select id_project from project_eq where id_electronic_eq = " . $idElectronic . ") and "
            . "id_project_status != 2;";
   
    $result =  mysql_query($sel,$conexion);
    if (mysql_num_rows($result)>0)
    {
        // Imprimir los resultados en HTML
        $resultSearchHTML .= "<table class=\"border\">";
        $resultSearchHTML .= "<caption>LISTADO DE PROYECTOS</caption>";
        $resultSearchHTML .= "<th class=\"border\">Nombre</th><th class=\"border\">Estado</th>";
        $resultSearchHTML .= "<th class=\"border\">Asignar Proyecto</th>";
        
        while ($line = mysql_fetch_assoc($result))
        {
            $resultSearchHTML .= "<tr class=\"border\">";
            $c = 0;
            foreach ($line as $valor) 
            {
                if ($c==0)
                {

                    $idProject = $valor;
                    

                }
                if($c == 2)
                    {
                       $nameStatus = GetNameOption($valor, "project_status", "id_project_status", "name_project_status");
                       $resultSearchHTML .= "<td class=\"border\">$nameStatus</td>";
                    }
                if (($c != 0) && ($c != 2))
                {
                    $resultSearchHTML .= "<td class=\"border\">$valor</td>";
                }
          
                $c++;
            }

            $resultSearchHTML .= "<td class=\"border\"><input type=\"checkbox\" name=\"id_project[]\" value=\"$idProject\"></td>";
            
            
            $resultSearchHTML .= "</tr>";
        }
        $resultSearchHTML .= "</table>\n";
    }
    else
    {
        $resultSearchHTML .= "<table><tr><td>No se ha encontrado ningún Proyecto registrado</td></tr></table>";
    }

    mysql_close($conexion);

    if ($msg)
    {
        alert_js($msg);
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
       
         
                                    <form action="" method="post">
                                        <table>
                                                <tr>
                                                    <td>
                                                        <p><b> Seleccione un Proyecto y pulse Guardar:</b></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="submit" class="normalButton" name="saveProject" value="Guardar"/>
                                                    </td>
                                                </tr>
                                            
                                            
                                            </table>
                                            <?php echo $resultSearchHTML; ?>
                                        
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


