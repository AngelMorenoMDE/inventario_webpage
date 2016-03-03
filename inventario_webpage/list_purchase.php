<?php

    require_once "ini.php"; 
    check_session();
    $_SESSION["actual_page"] = "list_purchase.php";
    $msg=null;
    
   
    if(array_key_exists("delete", $_POST))
    {
        $idPurchase= $_POST ["delete"];
        $_SESSION["idPurchase"] = $idPurchase;
        redirect("confirm_action.php");
      
    }

    if(array_key_exists("edit", $_POST))
    {
        $idPurchase= $_POST ["edit"];
        
        $_SESSION["idPurchase"] = $idPurchase;
       
        redirect ("edit_purchase.php");
      
    }
    
    if(array_key_exists("details", $_POST))
    {
        $idPurchase= $_POST ["details"];
        
        $_SESSION["idPurchase"] = $idPurchase;
       
        redirect ("detail_purchase.php");
      
    }
    if(array_key_exists("go", $_POST))
    {
        $idProject= $_POST ["go"];
        
        $_SESSION["idProject"] = $idProject;
       
        redirect ("detail_project.php");
      
    }
    
    
    // Comprobando si en sesión hay guardado un proyecto 
    if (array_key_exists("idProject", $_SESSION))
    {
        $idProject = $_SESSION["idProject"];
        $sel = "select * from purchase where id_project = " . $idProject . ";";
        $caption = "LISTADO DE COMPRAS DEL PROYECTO";
    }
    else
    {
        $sel = "select * from purchase;";
        $caption = "LISTADO DE COMPRAS";
        
    }
    
 
    $resultSearchHTML = "";
    $conexion = new_conex_db();

    $selectPurchase =  mysql_query($sel,$conexion);
    
    if (mysql_num_rows($selectPurchase)>0)
    {
        if(is_admin(getUserRolInSession()))
        {
        // Imprimir los resultados en HTML
        $resultSearchHTML .= "<table class=\"border\">";
        $resultSearchHTML .= "<caption>$caption</caption>";
        $resultSearchHTML .= "<th class=\"border\">Detalles</th><th class=\"border\">Proyecto</th><th class=\"border\">Ver Proyecto</th>";
        $resultSearchHTML .= "<th class=\"border\">Importe</th><th class=\"border\">Descripción de compra</th>";
        $resultSearchHTML .= "<th class=\"border\">Fecha de compra</th class=\"border\"><th class=\"border\">Comprador</th>";
        $resultSearchHTML .= "<th class=\"border\">Modificar</th class=\"border\">";
        }
        else
        {
            $resultSearchHTML .= "<table class=\"border\">";
            $resultSearchHTML .= "<caption>$caption</caption>";
            $resultSearchHTML .= "<th class=\"border\">Detalles</th><th class=\"border\">Proyecto</th><th class=\"border\">Ver Proyecto</th>";
            $resultSearchHTML .= "<th class=\"border\">Importe</th><th class=\"border\">Descripción de compra</th>";
            $resultSearchHTML .= "<th class=\"border\">Fecha de compra</th class=\"border\"><th class=\"border\">Comprador</th>";
        }
        while ($line = mysql_fetch_assoc($selectPurchase)) {
            $resultSearchHTML .= "<tr class=\"border\">";
            $c = 0;
            foreach ($line as $valor) 
            {
                if ($c == 0)
                {
                    $idPurchase = $valor;
                    $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"detail\" name=\"details\" value=\"$idPurchase\"></input></td>";
                }
                if ($c == 1)
                {
                    $project = GetNameOption($valor, "project", "id_project", "name_project");
                    $idProject = $valor;
                    $resultSearchHTML .= "<td class=\"border\">$project</td>";
                    $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"goProject\" name=\"go\" value=\"$idProject\"></input></td>";
                    
                }
                
                if($c==2)
                {
                    $precio = number_format($valor, 2, ",", ".");
                    $precioFinal = $precio . " €";
                    $resultSearchHTML .= "<td class=\"border\">$precioFinal</td>";
                }
                if ($c == 4)
                {
                    $date = date('d/m/Y', $valor);
                    $resultSearchHTML .= "<td class=\"border\">$date</td>";
                }
                
                if (($c != 0) && ($c != 1) && ($c != 2) && ($c != 4))
                {
                    $resultSearchHTML .= "<td class=\"border\">$valor</td>";
                }
                $c++;
            }
            if(is_admin(getUserRolInSession()))
            {
                $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"edit\" name=\"edit\" value=\"$idPurchase\"></input></td>";
                
            }
            $resultSearchHTML .= "</tr>";
        }
        $resultSearchHTML .= "</table>";
    }
    else
    {
        $resultSearchHTML .= "<table><tr><td>No se ha encontrado ninguna compra registrado</td></tr></table>";
        
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

