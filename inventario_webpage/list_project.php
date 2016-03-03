<?php

    require_once "ini.php"; 
    check_session();

    $msg=null;
    
    $_SESSION["actual_page"] = "list_project.php";
    
    if(array_key_exists("delete", $_POST))
    {
        $idProject = $_POST["delete"];
        $_SESSION["idProject"] = $idProject;
        redirect("confirm_action.php");
        
    }

    if(array_key_exists("edit", $_POST))
    {
        $idProject= $_POST ["edit"];

        $_SESSION["idProject"] = $idProject;

        redirect ("edit_project.php");

    }
    
    if(array_key_exists("details", $_POST))
    {
        $idProject= $_POST ["details"];
        $_SESSION["idProject"] = $idProject;
        
       
        redirect ("detail_project.php");
      
    }
    if(array_key_exists("go", $_POST))
    {
        $idProject= $_POST ["go"];
        $_SESSION["idProject"] = $idProject;
              
        redirect ("list_purchase.php");
      
    }
   
    $resultSearchHTML = "";
    
    $conexion = new_conex_db();

    $result =  mysql_query("select id_project, name_project, id_project_status "
            . "from $tableProject",$conexion);
    if (mysql_num_rows($result)>0)
    {
        if(is_admin(getUserRolInSession()))
        {
            // Imprimir los resultados en HTML
            $resultSearchHTML .= "<table class=\"border\">";
            $resultSearchHTML .= "<caption>LISTADO DE PROYECTOS</caption>";
            $resultSearchHTML .= "<th class=\"border\">Detalles</th><th class=\"border\">Nombre</th>";
            $resultSearchHTML .= "<th class=\"border\">Estado</th>";
            $resultSearchHTML .= "<th class=\"border\">Ver Compras</th><th class=\"border\">Editar</th><th class=\"border\">Cerrar Proyecto</th>";
        }
        else
        {
            $resultSearchHTML .= "<table class=\"border\">";
            $resultSearchHTML .= "<caption>LISTADO DE PROYECTOS</caption>";
            $resultSearchHTML .= "<th class=\"border\">Detalles</th><th class=\"border\">Nombre</th>";
            $resultSearchHTML .= "<th class=\"border\">Estado</th>";
            $resultSearchHTML .= "<th class=\"border\">Ver Compras</th>";
        }
        while ($line = mysql_fetch_assoc($result))
        {
            $resultSearchHTML .= "<tr class=\"border\">";
            $c = 0;
            foreach ($line as $valor) 
            {
                if ($c==0)
                {

                    $idProject = $valor;
                    $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"detail\"name=\"details\" value=\"$valor\"></input></td>";
                    
                }
                if($c == 2)
                    {
                       $nameStatus = GetNameOption($valor, "project_status", "id_project_status", "name_project_status");
                       $resultSearchHTML .= "<td class=\"border\">$nameStatus</td>";
                       $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"goPurchase\" name=\"go\" value=\"$idProject\"></input></td>";    
                    }
                if (($c != 0) && ($c != 2))
                {
                    $resultSearchHTML .= "<td class=\"border\">$valor</td>";
                }
          
                $c++;
            }
            if(is_admin(getUserRolInSession()))
            {

                $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"edit\" name=\"edit\" value=\"$idProject\"></input></td>";
                if($nameStatus == "Activo")
                {
                    $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"endProject\" name=\"delete\" value=\"$idProject\"></input></td>";
                }
                else
                {
                    $resultSearchHTML .= "<td class=\"border\"></td>";
                }
            }
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

