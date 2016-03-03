<?php

    require_once "ini.php"; 
    check_session();
    
    $_SESSION["actual_page"] = "search.php";
    
    $errores = "";
    $resultSearchHTML = "";
    
    $conexion = new_conex_db();
    if (array_key_exists("idOffice", $_SESSION))
    {
        $idOffice = $_SESSION["idOffice"];
        $sel = "select id_electronic_eq, electronic_eq_type, urjc_code, serial_number, id_office, "
                    . "status from $tableElectEq where id_office = " . $idOffice . " order by electronic_eq_type;";
        unset($_SESSION["idOffice"]);
    }
    else 
    {
        $sel = "select id_electronic_eq, electronic_eq_type, urjc_code, serial_number, id_office, "
                    . "status from $tableElectEq order by electronic_eq_type;";
    }
            $selectEq =  mysql_query($sel,$conexion);

            if (mysql_num_rows($selectEq)>0)
            {
                if(is_admin(getUserRolInSession()))
                {
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
                while ($line = mysql_fetch_assoc($selectEq)) 
                {
                    $resultSearchHTML .= "<tr class=\"border\">";

                    $c = 0;
                    foreach ($line as $valor) 
                    {
                        if ($c==0)
                        {

                            $idElect = $valor;
                            $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"detail\"name=\"detail\" value=\"$valor\"></input></td>";


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

                        if  (($c != 0)&& ($c != 1) && ($c != 4) && ($c != 5))
                        {
                            $resultSearchHTML .= "<td class=\"border\">$valor</td>";
                        }
                            $c++;    

                    }
                    if(is_admin(getUserRolInSession()))
                    {
                        $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"edit\" name=\"edit\" value=\"$idElect\"></input></td>";
                        
                    }
                    $resultSearchHTML .= "</tr>";
                    
                }
                $resultSearchHTML .= "</table>";
            }

            else 
            {
                $resultSearchHTML .= "<table><tr><td>No se ha encontrado ningún reultado en la búsqueda</td></tr></table>";
            }
            mysql_close($conexion);
            
            
    
    if(array_key_exists("computer", $_POST))
    {
               
        redirect ("search_computer.php");
      
    }
    
    if(array_key_exists("monitor", $_POST))
    {
               
        redirect ("search_monitor.php");
      
    }
    
    if(array_key_exists("printer", $_POST))
    {
               
        redirect ("search_printer.php");
      
    }
    
    if(array_key_exists("scanner", $_POST))
    {
               
        redirect ("search_scanner.php");
      
    }
    
    if(array_key_exists("mouse", $_POST))
    {
               
        redirect ("search_mouse.php");
      
    }
    
    if(array_key_exists("keyboard", $_POST))
    {
               
        redirect ("search_keyboard.php");
      
    }
    
    if(array_key_exists("projector", $_POST))
    {
               
        redirect ("search_projector.php");
      
    }
    
    if(array_key_exists("wire", $_POST))
    {
               
        redirect ("search_wire.php");
      
    }
    
    if(array_key_exists("other", $_POST))
    {
               
        redirect ("search_other.php");
      
    }
    
   if(array_key_exists("detail", $_POST))
    {
        $idElectronic= $_POST ["detail"];

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
    
   
      
    if(array_key_exists("edit", $_POST))
    {
        $idElectronic= $_POST ["edit"];

        $select ="select electronic_eq_type from $tableElectEq where id_electronic_eq = $idElectronic ;";
        $rowtype = select_one($select);
        $idType = $rowtype['electronic_eq_type'];
        
        if ($idType == 1)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("edit_computer.php");
        }

        if ($idType == 2)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("edit_monitor.php");
        }
        
        if ($idType == 3)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("edit_printer.php");
        }
        
        if ($idType == 4)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("edit_mouse.php");
        }
        
        if ($idType == 5)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("edit_keyboard.php");
        }
        
        if ($idType == 6)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("edit_wire.php");
        }
        if ($idType == 7)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("edit_scanner.php");
        }
        if ($idType == 8)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("edit_projector.php");
        }
        if ($idType == 11)
        {
            $_SESSION["idElectronic"] = $idElectronic;
            redirect ("edit_other.php");
        }
      
    }
    
    
    if(array_key_exists("search", $_POST))   
    {
        $where = "";
        $control = false;
        $resultSearchHTML = "";

        $urjc_code = $_POST["urjc_code"];    
        if (!empty($urjc_code))
        {
            $where .= " (urjc_code = ". $urjc_code . ")";
            $control = true;
        }


        $serial_number = $_POST["serial_number"];

        if (!empty($serial_number))
        {
            if ($control == true)
            {
                $where .= " or (serial_number= ". $serial_number . ")" ;

            }
            else 
            {
                $where .= "(serial_number= ". $serial_number . ")" ;
                $control = true;
            }
        }


        $status = $_POST["status"];
        if (!empty($status))
        {
            if ($control == true)
            {
                $where .= " or (status= ". $status . ")" ;

            }
            else 
            {
                $where .= "(status = ". $status . ")" ;  
                $control = true;
            }    
        }
        
       $idOfficeConjunto = $_POST["id_office"];
        if($idOfficeConjunto != -1)
            {
            $idOffice = sacaId($idOfficeConjunto);
            }
        if (!empty($idOffice))
        {
            if ($control == true)
            {
                $where .= " or (id_office  = " . $idOffice . ")";

            }
            else 
            {
                $where .= " (id_office  = " . $idOffice . ")"; 
                $control = true;
            }    
        }
        
        $project = $_POST["project"];
        if (!empty($project))
        {
            if ($control == true)
            {
                $where .= " or (id_electronic_eq in (select id_electronic_eq from project_eq where id_project = " . $project . "))";

            }
            else 
            {
                $where .= " (id_electronic_eq in (select id_electronic_eq from project_eq where id_project = " . $project . "))";
                $control = true;
            }    
        }
        $purchase = $_POST["purchase"];
        if (!empty($purchase))
        {
            if ($control == true)
            {
                $where .= " or (id_electronic_eq in (select id_electronic_eq from purchase_eq where id_purchase = " . $purchase . "))";

            }
            else 
            {
                $where .= " (id_electronic_eq in (select id_electronic_eq from purchase_eq where id_purchase = " . $purchase . "))";
                $control = true;
            }    
        }



        $dayIni = $_POST["day_ini"];
        $monthIni = $_POST["month_ini"];
        $yearIni = $_POST["year_ini"];
        $dayEnd = $_POST["day_end"];
        $monthEnd = $_POST["month_end"];
        $yearEnd = $_POST["year_end"];

        if ((!($dayIni == "Día")) && (!($monthIni == "Mes")) && 
                (!($yearIni == "Año"))&& (!($dayEnd == "Día")) && 
                (!($monthEnd == "Mes")) && (!($yearEnd == "Año"))&&
                (!empty($dayIni)) && (!empty($monthIni)) && 
                (!empty($yearIni))&& (!empty($dayEnd)) && 
                (!empty($monthEnd)) && (!empty($yearEnd)))
        {

            if (((in_array($monthIni, getShortMonth())) && ($dayIni > 30)) || ($monthIni == 2 && $dayIni > 29 ))
            {

                $errores .= "La fecha de inicio es incorrecta. </br>" ;

            }
            else 
            {
                if ($errores == "")
                {
                    $dateIni = mktime(0, 0, 0, $monthIni, $dayIni, $yearIni);
                }
            }


            if (((in_array($monthEnd, getShortMonth()))&& ($dayEnd > 30)) || ($monthEnd == 2 && $dayEnd > 29 ))
            {

                $errores .= "La fecha de fin es incorrecta. </br>" ;

            }
            else 
            {
                if ($errores == "")
                {
                    $dateEnd = mktime(0, 0, 0, $monthEnd, $dayEnd, $yearEnd);
                }

            }

            if ($errores == "")
            {
                if ($dateEnd < $dateIni)
                {
                    $errores .= "El rango de fechas es incorrecto. </br>";

                }
            }

            if (($control == true) && ($errores == ""))
            {
                $where .= " or ((date_creation >" . $dateIni . ") "
                        . "and (date_creation < ". $dateEnd . "))";


            }
            if (($control != true) && ($errores == ""))
            {
                $where .= "((date_creation >" . $dateIni . ") "
                        . "and (date_creation < ". $dateEnd . "))";
                $control = true;
            }
        }
        if ($errores == "")
        {
            $conexion = new_conex_db();

            $sel = "select id_electronic_eq, electronic_eq_type, urjc_code, serial_number, id_office, "
                    . "status from $tableElectEq where $where order by electronic_eq_type;";


            $selectEq =  mysql_query($sel,$conexion);

            if (mysql_num_rows($selectEq)>0)
            {
if(is_admin(getUserRolInSession()))
                {
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

                while ($line = mysql_fetch_assoc($selectEq)) 
                {
                    $resultSearchHTML .= "<tr class=\"border\">";

                    $c = 0;
                    foreach ($line as $valor) 
                    {
                        if ($c==0)
                        {

                            $idElect = $valor;
                            $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"detail\"name=\"detail\" value=\"$valor\"></input></td>";


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
                            $c++;    

                    }
                    if(is_admin(getUserRolInSession()))
                    {
                        $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"edit\" name=\"edit\" value=\"$idElect\"></input></td>";

                        


                    }
                    $resultSearchHTML .= "</tr>";
                    
                }
                $resultSearchHTML .= "</table>";
            }

            else 
            {
                $resultSearchHTML .= "<table><tr><td>No se ha encontrado ningún reultado en la búsqueda</td></tr></table>";
            }
            mysql_close($conexion);
        }
        
        else 
        {
            $resultSearchHTML .=  "Se han producido los siguientes errores: " . $errores;
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
    
<!--<div id="header-wrapper">
	<div id="header">
		<div id="logo">
			<h1><a href="#">Inventario</a></h1>
		</div>
	</div>
</div>-->
<div id="wrapper">
	<!-- end #header -->
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
                            
				<div id="content">
                                    
                                    <?php require_once "menu_search.php"; ?>
                                    
                                    <div class="post">
                                        <form action="" method="post">
                                                    <table>
                                                        <tr>
                                                            <td>Código URJC: </td>
                                                            <td><input type="text" size="25" name="urjc_code"></input></td>
                                                        
                                                            <td>Número de serie: </td>
                                                            <td><input type="text" size="25" name="serial_number"></input></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Estado: </td>
                                                            <td><?php echo generateSelectWithOptionsSearch("status", "status",
                                                                    "id_status", "name_status"); ?></td>
                                                            <td>Despacho: </td>
                                                            <td><?php echo generateSelectOfficeSearch();?></td>
                                                        </tr>
                                                        <tr>
                                                                                                               
                                                            <td>Proyecto: </td>
                                                            <td><?php echo generateSelectWithOptionsSearch("project", "project",
                                                                    "id_project", "name_project"); ?></td>
                                                            <td>Compra: </td>
                                                            <td><?php echo generateSelectWithOptionsSearch("purchase", "purchase",
                                                                    "id_purchase", "name_purchase"); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Fecha Registro:</td>
                                                                     
                                                            <td colspan="3">
                                                                Desde el 
                                                                <?php echo generateDay("day_ini"); ?>
                                                                 / <?php echo generateMonth("month_ini"); ?>
                                                                 / <?php echo generateYear("year_ini"); ?>
                                                                 Hasta el 
                                                                 <?php echo generateDay("day_end"); ?>
                                                                 / <?php echo generateMonth("month_end"); ?>
                                                                 / <?php echo generateYear("year_end"); ?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="4"><input type="submit" class="normalButton" name="search" value="Buscar" ></input></td>
                                                        </tr>
                                                    </table>
                                        </form>
                                    </div>
                                    <div class="post">
                                        <form action="" method="post">

                                                    <table>
                                                        <tr>
                                                            <td><h1>Resultados</h1></td>                                                            
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <?php echo $resultSearchHTML; ?>
                                                            </td>
                                                            
                                                        </tr>                                                        
                                                    </table>

                                        </form>
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
