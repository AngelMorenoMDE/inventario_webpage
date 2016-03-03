    <?php

    require_once "ini.php"; 
    check_session();
    
    $_SESSION["actual_page"] = "list_building.php";
    $msg=null;

    if(array_key_exists("delete", $_POST))
    {
        $idBuilding = $_POST["delete"];
        $_SESSION["idBuilding"]= $idBuilding;
        redirect("confirm_action.php");

    }

    if (array_key_exists("go", $_POST))
    {
        $idBuilding= $_POST ["go"];

        $_SESSION["idBuilding"] = $idBuilding;

        redirect ("list_office.php");

    }

    if(array_key_exists("edit", $_POST))
    {
        $idBuilding= $_POST ["edit"];

        $_SESSION["idBuilding"] = $idBuilding;

        redirect ("edit_building.php");

    }

    $resultSearchHTML ="";
    $conexion = new_conex_db();

    $result =  mysql_query("select * from $tableBuilding",$conexion);
    if (mysql_num_rows($result)>0)
    {
        if(is_admin(getUserRolInSession()))
        {
            // Imprimir los resultados en HTML
        $resultSearchHTML .= "<table class=\"border\">";
        $resultSearchHTML .= "<caption>LISTADO DE EDIFICIOS</caption>";
        $resultSearchHTML .= "<th class=\"border\">Ver Despachos</th><th class=\"border\">Nombre Edificio</th>";
        $resultSearchHTML .= "<th class=\"border\">Campus</th><th class=\"border\">Modificar</th><th class=\"border\">Borrar</th>";
        }
        else
        {
        $resultSearchHTML .= "<table class=\"border\">";
        $resultSearchHTML .= "<caption>LISTADO DE EDIFICIOS</caption>";
        $resultSearchHTML .= "<th class=\"border\">Ver Despachos</th><th class=\"border\">Nombre Edificio</th>";
        $resultSearchHTML .= "<th class=\"border\">Campus</th>";
        }
        

        while ($line = mysql_fetch_assoc($result))
        {
            $resultSearchHTML .= "<tr class=\"border\">";
            $c = 0;
            foreach ($line as $valor) 
            {
                if ($c==0)
                {
                    $idElect =$valor;
                                        
                    $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"detailBuilding\" name=\"go\" value=\"$valor\"></input></td>";
                  
                }
                else
                {
                   if ($c == 2)
                   {
                        $nameCampus = GetNameOption($valor, "campus", "id_campus", "name_campus");
                        $resultSearchHTML .= "<td class=\"border\">$nameCampus</td>";
                   }
                   else
                   {
                        $resultSearchHTML .= "<td class=\"border\">$valor</td>";
                   }
                }
                $c++;
            }
            
            if(is_admin(getUserRolInSession()))
            {
                $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"edit\" name=\"edit\" value=\"$idElect\"></input></td>";
                $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"delete\" name=\"delete\" value=\"$idElect\"></input></td>"; 
            }
            
           
            $resultSearchHTML .= "</tr>";
        }
        $resultSearchHTML .= "</table>\n";
    }
    else
    {
        $resultSearchHTML .= "<table><tr><td>No se ha encontrado ningún Edificio registrado</td></tr></table>";
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
    