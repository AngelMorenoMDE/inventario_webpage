<?php
require_once "ini.php"; 
check_session();
$_SESSION["actual_page"] = "detail_office_eq.php";
$msg=null;
$conexion = new_conex_db();
$resultSearchHTML = "";
    
     $idOffice= $_SESSION ["idOffice"];
     $selB = "select id_building from office where id_office = " . $idOffice . ";";
     $resultB = select_one($selB);
     $nameOffice = GetNameOption($idOffice, "office", "id_office", "name_office");
     $nameBuilding = GetNameOption($resultB["id_building"], "building", "id_building", "name_building");
     
    
        $sel = "select id_electronic_eq, electronic_eq_type, urjc_code, status, id_user_asigned "
                . "from $tableElectEq where id_office = " .$idOffice . " order by electronic_eq_type;";
        $selectEq =  mysql_query($sel,$conexion);
        if (mysql_num_rows($selectEq)>0)
        {
        // Imprimir los resultados en HTML
        $resultSearchHTML .= "<table class=\"border\">";
        $resultSearchHTML .= "<caption>LISTADO DE EQUIPOS ELECTRONICOS</caption>";
        $resultSearchHTML .= "<th class=\"border\">Tipo Equipo Electrónico</th><th class=\"border\">Código URJC</th>";
        $resultSearchHTML .= "<th class=\"border\">Estado</th><th class=\"border\">Usuario Asignado</th>";
        

        while ($line = mysql_fetch_assoc($selectEq)) 
        {
            $resultSearchHTML .= "<tr class=\"border\">";
            $c = 0;
            foreach ($line as $valor) 
            {
                if ($c == 0)
                {
                    $idOffice= $valor;

                }
                if($c == 1)
                {
                    if($valor == 1)
                    {
                        $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/ordenadorp.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                    }
                    if($valor == 2)
                    {
                        $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/monitorp.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                    }
                    if($valor == 3)
                    {
                        $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/impresorap.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                    }
                    if($valor == 4)
                    {
                        $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/ratonp.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                    }
                    if($valor == 5)
                    {
                        $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/tecladop.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                    }
                    if($valor == 6)
                    {
                        $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/cablep.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                    }
                    if($valor == 7)
                    {
                        $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/scanerp.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                    }
                    if($valor == 8)
                    {
                        $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/proyectorp.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                    }
                    if($valor == 11)
                    {
                        $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/otherp.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                    }
                }
                if ($c == 3)
                {
                    $status = GetNameOption($valor, "status", "id_status", "name_status");
                    $resultSearchHTML .= "<td class=\"border\">$status</td>";
                }
                if ($c == 4)
                {
                    $user = GetNameOption($valor, "user", "id_user", "name");
                    $resultSearchHTML .= "<td class=\"border\">$user</td>";
                }
                if (($c != 0) && ($c != 1)&& ($c != 3)&& ($c != 4))
                {
                    $resultSearchHTML .= "<td class=\"border\">$valor</td>\n";
                }
                $c++;
            }
            //$resultHTML .= "<td class=\"border\"><input type=\"submit\" class=\"edit\" name=\"edit\" value=\"$idOffice\"></td>";
            //$resultHTML .= "<td class=\"border\"><input type=\"submit\" class=\"delete\" name=\"delete\" value=\"$idOffice\"></td>";
        }
        $resultSearchHTML .= "</table>";
    }
    else
    {
        $resultSearchHTML .= "<table><tr><td>No se ha encontrado ningún Equipo Electrónico registrado</td></tr></table>";
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
       
<div id="header-wrapper">
	<div id="header">
		<div id="logo">
			<h1>Está usted en: <?php echo $nameBuilding; ?> , <?php echo $nameOffice; ?></h1>
		</div>
	</div>
</div>


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
    
