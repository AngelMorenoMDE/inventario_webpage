<?php
    require_once "ini.php"; 
    check_session();
   $_SESSION["actual_page"] = "search_computer.php";
    
    $errores = "";
    $resultSearchHTML = "";
    
    $conexion = new_conex_db();

    $sel = "select e.id_electronic_eq, e.urjc_code, e.status, "
            . "c.cpu_name, c.ram_mb, c.hdd1_gb, c.ssoo, c.name_equip, c.ip"
            . " from electronic_equipment e, computer c  where "
            . "e.id_electronic_eq = c.id_electronic_eq;" ;


    $selectEq =  mysql_query($sel,$conexion);

    if (mysql_num_rows($selectEq)>0)
    {
        if(is_admin(getUserRolInSession()))
        {
            $resultSearchHTML .= "<table class=\"border\">";
            $resultSearchHTML .= "<th class=\"border\">Detalles</th>";
            $resultSearchHTML .= "<th class=\"border\">Código URJC</th>";
            $resultSearchHTML .= "<th class=\"border\">Estado</th>";
            $resultSearchHTML .= "<th class=\"border\">Tipo CPU</th>";
            $resultSearchHTML .= "<th class=\"border\">Capacidad de RAM</th>";
            $resultSearchHTML .= "<th class=\"border\">Capacidad disco Interno</th>";
            $resultSearchHTML .= "<th class=\"border\">Sistema Operativo</th>";
            $resultSearchHTML .= "<th class=\"border\">Nombre del equipo </th><th class=\"border\">Dirección IP</th>";
            $resultSearchHTML .= "<th class=\"border\">Modificar</th>";
        }
        else
        {
            $resultSearchHTML .= "<table class=\"border\">";
            $resultSearchHTML .= "<th class=\"border\">Detalles</th>";
            $resultSearchHTML .= "<th class=\"border\">Código URJC</th>";
            $resultSearchHTML .= "<th class=\"border\">Estado</th>";
            $resultSearchHTML .= "<th class=\"border\">Tipo CPU</th>";
            $resultSearchHTML .= "<th class=\"border\">Capacidad de RAM</th>";
            $resultSearchHTML .= "<th class=\"border\">Capacidad disco Interno</th>";
            $resultSearchHTML .= "<th class=\"border\">Sistema Operativo</th>";
            $resultSearchHTML .= "<th class=\"border\">Nombre del equipo </th><th class=\"border\">Dirección IP</th>";
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


                               if ($c == 2)
                               {
                                   $status = GetNameOption($valor, "status", "id_status", "name_status");
                                   $resultSearchHTML .= "<td class=\"border\">$status</td>";

                               }
                               if ($c == 4)
                               {
                                   if($valor == -1)
                                    {
                                        $ram = "";
                                    }
                                    else
                                    {
                                        $ram = $valor;
                                    }
                                    $resultSearchHTML .= "<td class=\"border\">$ram</td>";

                               }
                               if ($c == 5)
                               {
                                   if($valor == -1)
                                    {
                                        $hhdd = "";
                                    }
                                    else
                                    {
                                        $hhdd = $valor;
                                    }
                                    $resultSearchHTML .= "<td class=\"border\">$hhdd</td>";

                               }

                               if (($c != 0) && ($c != 2) && ($c != 4) && ($c != 5))
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
         $resultSearchHTML .= "<table><tr><td>No se ha encontrado ningún reultado en la búsqueda</td></tr></table>";
    }
mysql_close($conexion);
    
    $_SESSION["actual_page"] = "search_computer.php";
   
    if(array_key_exists("principal", $_POST))
    {
               
        redirect ("search.php");
      
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
    
    if(array_key_exists("details", $_POST))
    {
        $idElectronic= $_POST ["details"];
        $_SESSION["idElectronic"] = $idElectronic;
       
        redirect ("detail_computer.php");
      
    }
    
   
      
    if(array_key_exists("edit", $_POST))
    {
        $idElectronic= $_POST ["edit"];
        $_SESSION["idElectronic"] = $idElectronic;
       
        redirect ("edit_computer.php");
      
    }
    
     
     if(array_key_exists("search", $_POST))   
        {
            $where = "";
            $control = false;
            $resultSearchHTML = "";


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

            $cpu_name = $_POST["cpu_name"];
            if (!empty($cpu_name))
            {
                if ($control == true)
                {

                    $where .= " or (c.cpu_name = ". comillas($cpu_name) . ")" ;

                }
                else 
                {
                     $where .= "(c.cpu_name = ". comillas($cpu_name) . ")" ; 
                     $control = true;
                }    
            }

            $ram_type = $_POST["ram_type"];
            if (!empty($ram_type))
            {
                if ($control == true)
                {

                    $where .= " or (c.ram_type = ". $ram_type . ")" ;

                }
                else 
                {
                     $where .= "(c.ram_type = ". $ram_type . ")" ; 
                     $control = true;
                }    
            }
            $ram_mb = $_POST["ram_mb"];
            
            if (!empty($ram_mb))
            {
                if($ram_mb == 1)
                {
                   if ($control == true)
                    {
                        $where .= " or (c.ram_mb <= 256)" ;

                    }
                    else 
                    {
                        $where .= "(c.ram_mb <= 256)" ;  
                        $control = true;
                    }     
                }
                if($ram_mb == 2)
                {
                   if ($control == true)
                    {
                        $where .= " or (c.ram_mb > 256 and c.ram_mb <= 1024)" ;

                    }
                    else 
                    {
                        $where .= "(c.ram_mb > 256 and c.ram_mb <= 1024)" ;  
                        $control = true;
                    }     
                }
                if($ram_mb == 3)
                {
                   if ($control == true)
                    {
                        $where .= " or (c.ram_mb > 1024 and c.hdd1_gb <= 2048)" ;

                    }
                    else 
                    {
                        $where .= "(c.ram_mb > 1024 and c.ram_mb <= 2048)" ;  
                        $control = true;
                    }     
                }
                if($ram_mb == 4)
                {
                   if ($control == true)
                    {
                        $where .= " or (c.ram_mb > 20480)" ;

                    }
                    else 
                    {
                        $where .= "(c.ram_mb > 2048)" ;  
                        $control = true;
                    }     
                }

            }

            $hdd1_type = $_POST["hdd1_type"];
            if (!empty($hdd1_type))
            {
                if ($control == true)
                {

                    $where .= " or (c.hdd1_type = ". $hdd1_type . ")" ;

                }
                else 
                {
                     $where .= "(c.hdd1_type = ". $hdd1_type . ")" ; 
                     $control = true;
                }    
            }

            $hdd1_gb = $_POST["hdd1_gb"];
            if (!empty($hdd1_gb))
            {
                if($hdd1_gb == 1)
                {
                   if ($control == true)
                    {
                        $where .= " or (c.hdd1_gb <= 10)" ;

                    }
                    else 
                    {
                        $where .= "(c.hdd1_gb <= 10)" ;  
                        $control = true;
                    }     
                }
                if($hdd1_gb == 2)
                {
                   if ($control == true)
                    {
                        $where .= " or (c.hdd1_gb > 10 and c.hdd1_gb <= 50)" ;

                    }
                    else 
                    {
                        $where .= "(c.hdd1_gb > 10 and c.hdd1_gb <= 50)" ;  
                        $control = true;
                    }     
                }
                if($hdd1_gb == 3)
                {
                   if ($control == true)
                    {
                        $where .= " or (c.hdd1_gb > 50 and c.hdd1_gb <= 100)" ;

                    }
                    else 
                    {
                        $where .= "(c.hdd1_gb > 50 and c.hdd1_gb <= 100)" ;  
                        $control = true;
                    }     
                }
                if($hdd1_gb == 4)
                {
                   if ($control == true)
                    {
                        $where .= " or (c.hdd1_gb > 100)" ;

                    }
                    else 
                    {
                        $where .= "(c.hdd1_gb > 100)" ;  
                        $control = true;
                    }     
                }

            }

            $ssoo = $_POST["ssoo"];
            if ((!empty($ssoo)) && (!($ssoo == "")))
            {
                if ($control == true)
                {

                    $where .= " or (c.ssoo = ". comillas($ssoo) . ")" ;

                }
                else 
                {
                     $where .= "(c.ssoo = ". comillas($ssoo) . ")" ; 
                     $control = true;
                }    
            }
            $name_equip = $_POST["name_equip"];
            if (!empty($name_equip))
            {
                if ($control == true)
                {

                    $where .= " or (c.name_equip = ". comillas($name_equip) . ")" ;

                }
                else 
                {
                     $where .= "(c.name_equip = ". comillas($name_equip) . ")" ; 
                     $control = true;
                }    
            }

            $ip = $_POST["ip"];
            if (!empty($ip))
            {
                if (!validate_ip($ip))                 
                {
                    $errores.= "El campo \"dirección IP\" no es válido</br>";
                }
                if ($control == true)
                {

                    $where .= " or (c.ip = ". comillas($ip) . ")" ;

                }
                else 
                {
                     $where .= "(c.ip = ". comillas($ip) . ")" ; 
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
                    $where .= " or ((e.date_creation >" . $dateIni . ") and (e.date_creation < ". $dateEnd . "))";


               }
               if (($control != true) && ($errores == ""))
               {
                    $where .= "((e.date_creation >" . $dateIni . ") and (e.date_creation < ". $dateEnd . "))";
                    $control = true;
               }
            }
            if ($errores == "")
            {
                    $conexion = new_conex_db();

                    $sel = "select e.id_electronic_eq, e.urjc_code, e.status, "
                            . "c.cpu_name, c.ram_mb, c.hdd1_gb, c.ssoo, c.name_equip, c.ip"
                            . " from electronic_equipment e, computer c  where "
                            . "e.id_electronic_eq = c.id_electronic_eq and (" . $where . ");" ;


                    $selectEq =  mysql_query($sel,$conexion);

                    if (mysql_num_rows($selectEq)>0)
                    {
                        if(is_admin(getUserRolInSession()))
                        {
                            $resultSearchHTML .= "<table class=\"border\">";
                            $resultSearchHTML .= "<th class=\"border\">Detalles</th>";
                            $resultSearchHTML .= "<th class=\"border\">Código URJC</th>";
                            $resultSearchHTML .= "<th class=\"border\">Estado</th>";
                            $resultSearchHTML .= "<th class=\"border\">Tipo CPU</th>";
                            $resultSearchHTML .= "<th class=\"border\">Capacidad de RAM</th>";
                            $resultSearchHTML .= "<th class=\"border\">Capacidad disco Interno</th>";
                            $resultSearchHTML .= "<th class=\"border\">Sistema Operativo</th>";
                            $resultSearchHTML .= "<th class=\"border\">Nombre del equipo </th><th class=\"border\">Dirección IP</th>";
                            $resultSearchHTML .= "<th class=\"border\">Modificar</th>";
                        }
                        else
                        {
                            $resultSearchHTML .= "<table class=\"border\">";
                            $resultSearchHTML .= "<th class=\"border\">Detalles</th>";
                            $resultSearchHTML .= "<th class=\"border\">Código URJC</th>";
                            $resultSearchHTML .= "<th class=\"border\">Estado</th>";
                            $resultSearchHTML .= "<th class=\"border\">Tipo CPU</th>";
                            $resultSearchHTML .= "<th class=\"border\">Capacidad de RAM</th>";
                            $resultSearchHTML .= "<th class=\"border\">Capacidad disco Interno</th>";
                            $resultSearchHTML .= "<th class=\"border\">Sistema Operativo</th>";
                            $resultSearchHTML .= "<th class=\"border\">Nombre del equipo </th><th class=\"border\">Dirección IP</th>";
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
                                              
                                               
                                               if ($c == 2)
                                               {
                                                   $status = GetNameOption($valor, "status", "id_status", "name_status");
                                                   $resultSearchHTML .= "<td class=\"border\">$status</td>";

                                               }
                                               if ($c == 4)
                                               {
                                                   if($valor == -1)
                                                    {
                                                        $ram = "";
                                                    }
                                                    else
                                                    {
                                                        $ram = $valor;
                                                    }
                                                    $resultSearchHTML .= "<td class=\"border\">$ram</td>";

                                               }
                                               if ($c == 5)
                                               {
                                                   if($valor == -1)
                                                    {
                                                        $hhdd = "";
                                                    }
                                                    else
                                                    {
                                                        $hhdd = $valor;
                                                    }
                                                    $resultSearchHTML .= "<td class=\"border\">$hhdd</td>";

                                               }
                                               
                                               if (($c != 0) && ($c != 2) && ($c != 4) && ($c != 5))
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

<link rel="stylesheet" href="./css/style_table.css" type="text/css"/>
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
                                                        
                                                            <td>Tipo CPU: </td>
                                                            <td><input type="text" size="25" name="cpu_name"></input></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tipo RAM: </td>
                                                            <td><?php echo generateSelectWithOptionsSearch("ram_type", "ram_type",
                                                                    "id_ram_type", "name_ram_type"); ?></td>
                                                         
                                                            <td>Capacidad RAM: </td>
                                                            <td>
                                                                <select name="ram_mb" size="1">
                                                                <option value="-1"></option>
                                                                <option value="1"><=256</option>
                                                                <option value="2">>256 y <=1024</option>
                                                                <option value="3">>1024 y <=2048</option>
                                                                <option value="4">>2048</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tipo HHDD: </td>
                                                            <td><?php echo generateSelectWithOptionsSearch("hdd1_type", "hdd_type",
                                                                    "id_hdd_type", "name_hdd_type"); ?></td>
                                                        
                                                            <td>Capacidad HHDD:</td>
                                                            <td>
                                                                <select name="hdd1_gb" size="1">
                                                                <option value="-1"></option>
                                                                <option value="1"><=10</option>
                                                                <option value="2">>10 y <=50</option>
                                                                <option value="3">>50 y <=100</option>
                                                                <option value="4">>100</option>
                                                                </select>
                                                            </td>
                                                           
                                                        </tr>
                                                         <tr>
                                                            <td>SSOO: </td>
                                                            <td><?php echo generateSSOO("ssoo", $selected); ?></td>
                                                        
                                                            <td>Nombre Equipo: </td>
                                                            <td><input type="text" size="25" name="name_equip"></input></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Dirección IP: </td>
                                                            <td><input type="text" size="25" name="ip"></input></td>
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
                                                            <td><input type="submit" class="normalButton" name="search" value="Buscar"></input></td>
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



