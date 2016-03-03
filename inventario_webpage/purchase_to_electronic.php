<?php
    require_once "ini.php"; 
    check_session();
    $errores ="";
    $_SESSION["actual_page"] = "purchase_to_electronic.php";
   
    $msg=null;
    $idPurchase = $_SESSION["idPurchase"];
    

   
    if(array_key_exists("savePurchase", $_POST))
    {
       if(!array_key_exists("id_electronic", $_POST))
       {
           $errores = "NO SE HA SELECCIONADO NINGÚN EQUIPO ELECTRÓNICO.";
       }
        else 
        {
           $listEq = $_POST["id_electronic"];
           foreach($listEq as $valor)
           {
               $sel= "insert into purchase_eq values (" .$idPurchase . "," . $valor . ");";
               execute_query($sel);
           }
           redirect("detail_purchase.php");
       }
  
    }
    
    $resultSearchHTML ="";
    $conexion = new_conex_db();

    $sel = "select id_electronic_eq, electronic_eq_type, urjc_code, "
            . "serial_number, id_office, id_user_asigned from $tableElectEq where status <> 3 "
            . "and id_electronic_eq not in (select id_electronic_eq from purchase_eq "
            . "where id_purchase = " . $idPurchase . ") order by electronic_eq_type;";

    $result =  mysql_query($sel,$conexion);
    if (mysql_num_rows($result)>0)
    {
        // Imprimir los resultados en HTML
        $resultSearchHTML .= "<table class=\"border\">";
        $resultSearchHTML .= "<caption>LISTADO DE EQUIPOS ELECTRONICOS</caption><br>";
        $resultSearchHTML .= "<th class=\"border\">Seleccionar</th>";
        $resultSearchHTML .= "<th class=\"border\">Tipo Equipo</th><th class=\"border\">Características</th>";
        $resultSearchHTML .= "<th class=\"border\">Código URJC</th>";
        $resultSearchHTML .= "<th class=\"border\">Numero de serie</th><th class=\"border\">Despacho</th>";
        $resultSearchHTML .= "<th class=\"border\">Usuario Asignado</th>";
      

        while ($line = mysql_fetch_assoc($result)) 
        {
            $resultSearchHTML .= "<tr class=\"border\">";

            $c = 0;
            foreach ($line as $valor) 
            {
                if ($c==0)
                {

                    $idElect = $valor;
                    $resultSearchHTML .= "<td class=\"border\"><input type=\"checkbox\" name=\"id_electronic[]\" value=\"$idElect\"></td>";
                   
                }
                else
                {
                    if($c == 1)
                    {
                        if($valor == 1)
                        {
                            $sel = "select * from $tableComputer where id_electronic_eq = " . $idElect . ";";
                            $row = select_one($sel);
                            $cpu = $row["cpu_name"] . "  " . $row["ram_mb"] . "  "  . $row["hdd1_gb"] . "  "  . $row["ssoo"];
                            $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/ordenadorp.png\" name=\"type\" width=\"30\" height=\"30\"></td>";
                            $resultSearchHTML .= "<td class=\"border\">$cpu</td>";
                        }
                        if($valor == 2)
                        {
                            $sel = "select * from $tableMonitor where id_electronic_eq = " . $idElect . ";";
                            $row = select_one($sel);
                            if ($row["vga"] == 1)
                            {
                                $vga = "VGA";
                            }
                            else
                            {
                                 $vga ="";
                            }
                            if ($row["dvi"] == 1)
                            {
                                $dvi = "DVI";
                            }
                            else
                            {
                                 $dvi ="";
                            }
                            
                            
                            $monitor = $row["no_inch"] . "  " . GetNameOption($row["monitor_type"], "monitor_type", "id_monitor_type", "name_monitor_type") .  " , ";
                            $monitor .=  $vga . "  "  . $dvi ;
                            
                            $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/monitorp.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                            $resultSearchHTML .= "<td class=\"border\">$monitor</td>";
                        }
                        if($valor == 3)
                        {
                            $sel = "select * from $tablePrinter where id_electronic_eq = " . $idElect . ";";
                            $row = select_one($sel);
                            if ($row["color"] == 1)
                            {
                                $color = "Color";
                            }
                            else
                            {
                                 $color ="";
                            }
                            if ($row["laser"] == 1)
                            {
                                $laser = "Laser";
                            }
                            else
                            {
                                 $laser ="";
                            }
                            if ($row["paralel"] == 1)
                            {
                                $paralel = "Conector Paralelo";
                            }
                            else
                            {
                                 $paralel ="";
                            }
                            if ($row["usb"] == 1)
                            {
                                $usb = "Conector USB";
                            }
                            else
                            {
                                 $usb ="";
                            }
                            if ($row["ethernet"] == 1)
                            {
                                $ether = "Conector Ethernet";
                            }
                            else
                            {
                                 $ether ="";
                            }
                            
                            $printer =  $color . "  "  . $laser . "  "  . $paralel ."  "  . $usb ."  "  . $ether;
                            $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/impresorap.png\" name=\"type\" width=\"30\" height=\"30\"></td>";
                            $resultSearchHTML .= "<td class=\"border\">$printer</td>";
                        }
                        if($valor == 4)
                        {
                            $sel = "select * from $tableMouse where id_electronic_eq = " . $idElect . ";";
                            $row = select_one($sel);
                            if ($row["optik"] == 1)
                            {
                                $optik = "Optico";
                            }
                            else
                            {
                                 $optik ="";
                            }
                            if ($row["wireless"] == 1)
                            {
                                $wireless = "Wireless";
                            }
                            else
                            {
                                $wireless ="";
                            }
                            
                            $mouse = GetNameOption($row["conector_type"], "wire_type", "id_wire_type", "name_wire_type") . "  " ;
                            $mouse .=  $optik . "  " . $wireless ;
                            $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/ratonp.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                            $resultSearchHTML .= "<td class=\"border\">$mouse</td>";
                        }
                        if($valor == 5)
                        {
                            $sel = "select * from $tableKeyboard where id_electronic_eq = " . $idElect . ";";
                            $row = select_one($sel);
                            
                            
                            if ($row["wireless"] == 1)
                            {
                                $wireless = "Wireless";
                            }
                            else
                            {
                                $wireless ="";
                            }
                            
                            $keyboard = GetNameOption($row["conector_type"], "wire_type", "id_wire_type", "name_wire_type");
                            $keyboard .= "  " .$wireless;
                            $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/tecladop.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                            $resultSearchHTML .= "<td class=\"border\">$keyboard</td>";
                        }
                        if($valor == 6)
                        {
                            $sel = "select * from $tableWire where id_electronic_eq = " . $idElect . ";";
                            $row = select_one($sel);
                            $wire = GetNameOption($row["wire_type"], "wire_type", "id_wire_type", "name_wire_type");
                            $wire .= "  " . $row["conector_type_a"] . "  " . $row["conector_type_b"];
                            $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/cablep.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                            $resultSearchHTML .= "<td class=\"border\">$wire</td>";
                        }
                        if($valor == 7)
                        {
                            $sel = "select * from $tableScanner where id_electronic_eq = " . $idElect . ";";
                            $row = select_one($sel);
                            $scanner = $row["resolution"] ;
                            $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/scanerp.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                            $resultSearchHTML .= "<td class=\"border\">$scanner</td>";
                        }
                        if($valor == 8)
                        {
                            $sel = "select * from $tableProjector where id_electronic_eq = " . $idElect . ";";
                            $row = select_one($sel);
                            $projector = GetNameOption($row["type"], "projector_type", "id_type_projector", "name_projector");
                            $projector .= "  "  . $row["bright"] . "  " . $row["contrast"];
                            $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/proyectorp.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                            $resultSearchHTML .= "<td class=\"border\">$projector</td>";
                        }
                        if($valor == 11)
                        {
                            $sel = "select * from others where id_electronic_eq = " . $idElect . ";";
                            $row = select_one($sel);
                            
                            $other =  $row["name"] ;
                            $resultSearchHTML .= "<td class=\"border\"><img src=\"./icons/otherp.png\" name=\"type\" width=\"30\" height=\"30\"></td>"; 
                            $resultSearchHTML .= "<td class=\"border\">$other</td>";
                        }
                    }
                    if($c == 4)
                    {
                       $nameOffice = GetNameOption($valor, "office", "id_office", "name_office");
                            $resultSearchHTML .= "<td class=\"border\">$nameOffice</td>";
                    }
                    
                    if($c == 5)
                    {
                       $user = GetNameOption($valor, "user", "id_user", "name");
                            $resultSearchHTML .= "<td class=\"border\">$user</td>";
                    }
                   

                    if  (($c != 0)&& ($c != 1) && ($c != 4) && ($c != 5))
                    {
                        $resultSearchHTML .= "<td class=\"border\">$valor</td>";
                    }

                }
                $c++;
            }
            
            //$resultSearchHTML .= "<td class=\"border\"><input type=\"checkbox\" name=\"id_electronic[]\" value=\"$idElect\"></td>";
           
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
                                         <?php echo $errores; ?> 
       
                                        <form action="" method="post">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <p><b> Seleccione los Equipos a asociar a la Compra y pulse Guardar:</b></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="submit" class="normalButton" name="savePurchase" value="Guardar"/>
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


