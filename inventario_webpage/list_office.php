<?php

    require_once "ini.php"; 
    check_session();
    $_SESSION["actual_page"] = "list_office.php";
    $msg=null;
    $conexion = new_conex_db();
   
    $resultSearchHTML = "";

   

    if(array_key_exists("delete", $_POST))
    {
        $idOffice = $_POST["delete"];
        $_SESSION["idOffice"] = $idOffice;
        redirect("confirm_action.php");
    }

    if(array_key_exists("edit", $_POST))
    {
        $idOffice= $_POST ["edit"];
        
        $_SESSION["idOffice"] = $idOffice;
       
        redirect ("edit_office.php");
      
    }

    if(array_key_exists("detail", $_POST))
    {
        
        $idOffice= $_POST ["detail"];
        
        $_SESSION["idOffice"] = $idOffice;
       
        redirect ("detail_office_eq.php");
    }
        
    
    if (array_key_exists("idBuilding", $_SESSION))
    {
        $idBuilding= $_SESSION ["idBuilding"];
        $selOffice = "select * from $tableOffice  where id_building = " . $idBuilding . ";";
        unset($_SESSION["idBuilding"]);
    }
    else 
    {
        $selOffice = "select * from $tableOffice ;";
    }
     
    $resultSearchHTML =""; 
   
    $selectOffice =  mysql_query($selOffice,$conexion);

    if (mysql_num_rows($selectOffice)>0)
    {
        if(is_admin(getUserRolInSession()))
        {
            // Imprimir los resultados en HTML
            $resultSearchHTML .= "<table class=\"border\">";
            $resultSearchHTML .= "<caption>LISTADO DE DESPACHOS</caption>";
            $resultSearchHTML .= "<th class=\"border\">Ver Equipos Electrónicos</th><th class=\"border\">Nombre del Despacho</th>";
            $resultSearchHTML .= "<th class=\"border\">Edificio</th><th class=\"border\">Número de planta</th>";
            $resultSearchHTML .= "<th class=\"border\">Modificar</th><th class=\"border\">Borrar</th>";
        }
        else
        {
            // Imprimir los resultados en HTML
            $resultSearchHTML .= "<table class=\"border\">";
            $resultSearchHTML .= "<caption>LISTADO DE DESPACHOS</caption>";
            $resultSearchHTML .= "<th class=\"border\">Ver Equipos Electrónicos</th><th class=\"border\">Nombre del Despacho</th>";
            $resultSearchHTML .= "<th class=\"border\">Edificio</th><th class=\"border\">Número de planta</th>";
            
        }
        
        while ($line = mysql_fetch_assoc($selectOffice)) {
            $resultSearchHTML .= "<tr class=\"border\">";
            $c = 0;
            foreach ($line as $valor) 
            {
                if ($c==0)
                {
                    $idOffice= $valor;
                    $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"detailOffice\" name=\"detail\" value=\"$idOffice\"></input></td>";


                }
                if ($c == 2)
                {
                    $building = GetNameOption($valor, "building", "id_building", "name_building");
                    $resultSearchHTML .= "<td class=\"border\">$building</td>";
                }
                if (($c != 0) && ($c != 2))
                {
                    $resultSearchHTML .= "<td class=\"border\">$valor</td>\n";
                }
                $c++;
            }
            if(is_admin(getUserRolInSession()))
            {
            $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"edit\" name=\"edit\" value=\"$idOffice\"></input></td>";
            $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"delete\" name=\"delete\" value=\"$idOffice\"></input></td>";
            }
            $resultSearchHTML .= "</tr>";
        }
        $resultSearchHTML .= "</table>";
    }
    else
    {
        $resultSearchHTML .= "<table><tr><td>No se ha encontrado ningún Despacho registrado</td></tr></table>";
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
    

