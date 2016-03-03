<?php
  
require_once "ini.php"; 
    check_session();
    $_SESSION["actual_page"] = "list_electronic_eq.php";  

    $msg=null;

   
    if(array_key_exists("edit", $_POST))
    {
        $idElectronic= $_POST ["edit"];
        
        $_SESSION["idElectronic"] = $idElectronic;
        
        $selectElecEqType = "select electronic_eq_type from $tableElectEq where "
                . "id_electronic_eq=" . $idElectronic .";";
        $rowTypeEq = select_one($selectElecEqType);
        $type = $rowTypeEq['electronic_eq_type'];
        
        if($type==1)
        {
            redirect ("edit_computer.php");
        }
        if($type==2)
        {
            redirect ("edit_monitor.php");
        }
        if($type==3)
        {
            redirect ("edit_printer.php");
        }
        if($type==4)
        {
            redirect ("edit_mouse.php");
        }
        if($type==5)
        {
            redirect ("edit_keyboard.php");
        }
        if($type==6)
        {
            redirect ("edit_wire.php");
        }
        if($type==7)
        {
            redirect ("edit_scanner.php");
        }
        if($type==8)
        {
            redirect ("edit_projector.php");
        }
        if($type==11)
        {
            redirect ("edit_other.php");
        }
   
    }
    
    if(array_key_exists("details", $_POST))
    {
        $idElectronic= $_POST ["details"];

        $select ="select electronic_eq_type from $tableElectEq where id_electronic_eq = $idElectronic ;";
        $rowtype = select_one($select);
        $idType = $rowtype['electronic_eq_type'];
        
        if ($idType == 1)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("detail_computer.php");
        }

        if ($idType == 2)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("detail_monitor.php");
        }
        
        if ($idType == 3)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("detail_printer.php");
        }
        
        if ($idType == 4)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("detail_mouse.php");
        }
        
        if ($idType == 5)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("detail_keyboard.php");
        }
        
        if ($idType == 6)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("detail_wire.php");
        }
        if ($idType == 7)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("detail_scanner.php");
        }
        if ($idType == 8)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("detail_projector.php");
        }
        if ($idType == 11)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("detail_other.php");
        }

    }
    $resultSearchHTML ="";
    $conexion = new_conex_db();

    $sel = "select id_electronic_eq, electronic_eq_type, urjc_code, "
            . "serial_number, id_office, status from $tableElectEq order by electronic_eq_type;";

    $result =  mysql_query($sel,$conexion);
    if (mysql_num_rows($result)>0)
    {
        if(is_admin(getUserRolInSession()))
        {
        // Imprimir los resultados en HTML
        $resultSearchHTML .= "<table class=\"border\">";
        $resultSearchHTML .= "<caption>LISTADO DE EQUIPOS ELECTRONICOS</caption><br>";
        $resultSearchHTML .= "<th class=\"border\">Detalles</th><th class=\"border\">Tipo Equipo</th>";
        $resultSearchHTML .= "<th class=\"border\">Código URJC</th><th class=\"border\">Número de serie</th>";
        $resultSearchHTML .= "<th class=\"border\">Despacho</th>";
        $resultSearchHTML .= "<th class=\"border\">Estado</th><th class=\"border\">Modificar</th>";
        }
        else
        {
            $resultSearchHTML .= "<table class=\"border\">";
            $resultSearchHTML .= "<caption>LISTADO DE EQUIPOS ELECTRONICOS</caption><br>";
            $resultSearchHTML .= "<th class=\"border\">Detalles</th><th class=\"border\">Tipo Equipo</th>";
            $resultSearchHTML .= "<th class=\"border\">Código URJC</th><th class=\"border\">Número de serie</th>";
            $resultSearchHTML .= "<th class=\"border\">Despacho</th>";
            $resultSearchHTML .= "<th class=\"border\">Estado</th>";
        }
        while ($line = mysql_fetch_assoc($result)) 
        {
            $resultSearchHTML .= "<tr class=\"border\">";

            $c = 0;
            foreach ($line as $valor) 
            {
                if ($c==0)
                {

                    $idElect = $valor;
                    $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"detail\"name=\"details\" value=\"$valor\"></td>";


                }
                else
                {
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
                    if($c == 4)
                    {
                       $nameOffice = GetNameOption($valor, "office", "id_office", "name_office");
                            $resultSearchHTML .= "<td class=\"border\">$nameOffice</td>";
                    }
                    
                    if($c == 5)
                    {
                       $nameStatus = GetNameOption($valor, "status", "id_status", "name_status");
                            $resultSearchHTML .= "<td class=\"border\">$nameStatus</td>";
                    }

                    if  (($c != 0)&& ($c != 1) && ($c != 4) && ($c != 5) && ($c != 6))
                    {
                        $resultSearchHTML .= "<td class=\"border\">$valor</td>";
                    }

                }
                $c++;
            }
            if(is_admin(getUserRolInSession()))
            {
            $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"edit\" name=\"edit\" value=\"$idElect\"></td>";
            //$resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"delete\" name=\"delete\" value=\"$idElect\"></td>";
            }
            $resultSearchHTML .= "</tr>\n";
        }
        $resultSearchHTML .= "</table>\n";
    }
    else
    {
        $resultSearchHTML .= "<table><tr><td>No se ha encontrado ningún Equipo registrado</td></tr></table>";
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


