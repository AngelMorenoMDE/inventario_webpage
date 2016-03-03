<?php
    require_once "ini.php"; 
    check_session();
    $msg = null;
    $errores = "";
    $resultSearchHTML = "";
    
    $_SESSION["actual_page"] = "search_other.php";
    
    $conexion = new_conex_db();

        $sel = "select e.id_electronic_eq, e.urjc_code, e.serial_number, e.status,"
                . " o.name from $tableElectEq e, others o  where "
                . "e.id_electronic_eq = o.id_electronic_eq;" ;


        $selectEq =  mysql_query($sel,$conexion);

        if (mysql_num_rows($selectEq)>0)
        {
            if(is_admin(getUserRolInSession()))
            {
                $resultSearchHTML .= "<table class=\"border\">";
                $resultSearchHTML .= "<th class=\"border\">Detalles</th><th class=\"border\">Código URJC</th>";
                $resultSearchHTML .= "<th class=\"border\">Número de serie</th><th class=\"border\">Estado</th><th class=\"border\">Nombre</th>";
                $resultSearchHTML .= "<th class=\"border\">Modificar</th>";
            }
            else
            {
                $resultSearchHTML .= "<table class=\"border\">";
                $resultSearchHTML .= "<th class=\"border\">Detalles</th><th class=\"border\">Código URJC</th>";
                $resultSearchHTML .= "<th class=\"border\">Número de serie</th><th class=\"border\">Estado</th><th class=\"border\">Nombre</th>";
                
            }
            while ($line = mysql_fetch_assoc($selectEq)) 
            {

                $resultSearchHTML .= "<tr class=\"border\">";
                $c = 0;
                foreach ($line as $valor) 
                {
                    if ($c == 0)
                    {
                        $idElect = $valor;
                        $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"detail\" name=\"details\" value=\"$valor\"></input></td>";
                    }
                    if ($c == 3)
                    {
                        $status = GetNameOption($valor, "status", "id_status", "name_status");
                        $resultSearchHTML .=  "<td class=\"border\">$status</td>";
                    } 
                    
                    
                    

                    if (($c != 0) && ($c != 3))
                    {
                        $resultSearchHTML .= "<td class=\"border\">$valor</td>\n";
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
            $resultSearchHTML .= "<table><tr><td>No se ha encontrado ningún resultado en la búsqueda</td></tr></table>";
        }
        mysql_close($conexion);
        
    
    if(array_key_exists("principal", $_POST))
    {
               
        redirect ("search.php");
      
    }
    
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
    
   
  
    if(array_key_exists("edit", $_POST))
    {
        $idElectronic= $_POST ["edit"];
        $_SESSION["idElectronic"] = $idElectronic;
       
        redirect ("edit_other.php");
              
    }
    
    if(array_key_exists("details", $_POST))
    {
        $idElectronic= $_POST ["details"];
        $_SESSION["idElectronic"] = $idElectronic;
        
       
        redirect ("detail_other.php");
      
    }
 
    
    if(array_key_exists("search", $_POST))//recogemos los datos nuevos    
    {
        $resultSearchHTML = "";
        $where = "";
        $control = false;

        $urjc_code = $_POST["urjc_code"];    
        if (!empty($urjc_code))
        {
            $where .= " (e.urjc_code = ". $urjc_code . ")";
            $control = true;
        }


        $serial_number = $_POST["serial_number"];

        if (!empty($serial_number))
        {
            if ($control == true)
            {
                $where .= " or (e.serial_number= ". $serial_number . ")" ;

            }
            else 
            {
                $where .= "(e.serial_number= ". $serial_number . ")" ;
                $control = true;
            }
        }


        $status = $_POST["status"];
        if (!empty($status))
        {
            if ($control == true)
            {
                $where .= " or (e.status= ". $status . ")" ;

            }
            else 
            {
                $where .= "(e.status = ". $status . ")" ;  
                $control = true;
            }    
        }

        $name = $_POST["name"];
        if (!empty($name))
        {
            if ($name == true)
            {
                $where .= " or (o.name= ". $name . ")" ;

            }
            else 
            {
                $where .= "(o.name = ". $name . ")" ;  
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
                $where .= " or (e.id_electronic_eq in (select id_electronic_eq from project_eq where id_project = " . $project . "))";

            }
            else 
            {
                $where .= " (e.id_electronic_eq in (select id_electronic_eq from project_eq where id_project = " . $project . "))";
                $control = true;
            }    
        }
        $purchase = $_POST["purchase"];
        if (!empty($purchase))
        {
            if ($control == true)
            {
                $where .= " or (e.id_electronic_eq in (select id_electronic_eq from purchase_eq where id_purchase = " . $purchase . "))";

            }
            else 
            {
                $where .= " (e.id_electronic_eq in (select id_electronic_eq from purchase_eq where id_purchase = " . $purchase . "))";
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
            $where .= " or ((e.date_creation >" . $dateIni . ") "
                    . "and (e.date_creation < ". $dateEnd . "))";


        }
        if (($control != true) && ($errores == ""))
        {
            $where .= "((e.date_creation >" . $dateIni . ") "
                    . "and (e.date_creation < ". $dateEnd . "))";
            $control = true;
        }
    }
    if ($errores == "")
    {
        $conexion = new_conex_db();

        $sel = "select e.id_electronic_eq, e.urjc_code, e.serial_number, e.status,"
                . " o.name  from $tableElectEq e, others o where "
                . "e.id_electronic_eq = o.id_electronic_eq and (" . $where . ");" ;


        $selectEq =  mysql_query($sel,$conexion);

        if (mysql_num_rows($selectEq)>0)
        {
            if(is_admin(getUserRolInSession()))
            {
                $resultSearchHTML .= "<table class=\"border\">";
                $resultSearchHTML .= "<th class=\"border\">Detalles</th><th class=\"border\">Código URJC</th>";
                $resultSearchHTML .= "<th class=\"border\">Número de serie</th><th class=\"border\">Estado</th><th class=\"border\">Metros</th>";
                $resultSearchHTML .= "<th class=\"border\">Modificar</th>";
            }
            else
            {
                $resultSearchHTML .= "<table class=\"border\">";
                $resultSearchHTML .= "<th class=\"border\">Detalles</th><th class=\"border\">Código URJC</th>";
                $resultSearchHTML .= "<th class=\"border\">Número de serie</th><th class=\"border\">Estado</th><th class=\"border\">Nombre</th>";
                
            }

            while ($line = mysql_fetch_assoc($selectEq)) 
            {

                $resultSearchHTML .= "<tr class=\"border\">";
                $c = 0;
                foreach ($line as $valor) 
                {
                    if ($c == 0)
                    {
                        $idElect = $valor;
                        $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"detail\" name=\"details\" value=\"$valor\"></input></td>";
                    }
                    if ($c == 3)
                    {
                        $status = GetNameOption($valor, "status", "id_status", "name_status");
                        $resultSearchHTML .=  "<td class=\"border\">$status</td>";
                    } 
                    
                    if (($c != 0) && ($c != 3)  )
                    {
                        $resultSearchHTML .= "<td class=\"border\">$valor</td>\n";
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
            $resultSearchHTML .= "<table><tr><td>No se ha encontrado ningún resultado en la búsqueda</td></tr></table>";
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
<link rel="stylesheet" href="css/style_table.css" type="text/css"/>

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
                                                        
                                                            <td>Nombre: </td>
                                                            <td><input type="text" size="25" name="name"></input></td>
                                            
                                                        </tr>
                                                        <tr>
                                                        <td>Despacho: </td>
                                                            <td><?php echo generateSelectOfficeSearch();?></td>
                                                        </tr>
                                                        <tr>
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
                                                                Deste el 
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
                                                            <td><input type="submit" class="normalButton" name="search" value="Buscar" ></input></td>
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



