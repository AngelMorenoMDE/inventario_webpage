<?php


     
    require_once "ini.php"; 
    check_session();
    $_SESSION["actual_page"] = "electronic_to_purchase.php"; 
    $msg=null;
    $idElectronic = $_SESSION["idElectronic"];
  
    if(array_key_exists("savePurchase", $_POST))
    {
       if(!array_key_exists("id_purchase", $_POST))
       {
           $errores = "NO SE HA SELECCIONADO NINGUNA COMPRA.";
       }
        else 
        {
           $idPurchase = $_POST["id_purchase"];
           
               $sel= "insert into purchase_eq values (" . $idPurchase . "," . $idElectronic . ");";
               execute_query($sel);
           
           redirect("list_purchase.php");
       }
       
    }
    

    
   
    $resultSearchHTML = "";
    
    $conexion = new_conex_db();

    $sel = "select id_purchase, price, name_purchase,  "
            . " date_purchase, purchaser from purchase where id_purchase in "
            . "(select id_purchase from purchase_eq where id_electronic_eq = "  . $idElectronic . ");";

    $result =  mysql_query($sel,$conexion);
    if (mysql_num_rows($result)>0)
    {
        
    $resultSearchHTML .= "ESTE EQUIPO YA ESTA REGISTRADO EN COMPRAS";
    }
    else
    {
        
        $sel = "select id_purchase, price, name_purchase,  "
            . " date_purchase, purchaser from purchase where id_purchase not in "
            . "(select id_purchase from purchase_eq where id_electronic_eq = "  . $idElectronic . ");";
    
        $result =  mysql_query($sel,$conexion);
            if (mysql_num_rows($result)>0)
            {
                // Imprimir los resultados en HTML
                $resultSearchHTML .= "<table><tr><td><p><b> Seleccione una Compra y pulse Guardar:</b></p>";
                $resultSearchHTML .= "</td></tr><tr><td>";
                $resultSearchHTML .= "<input type=\"submit\" class=\"normalButton\" name=\"savePurchase\" value=\"Guardar\"/>";
                $resultSearchHTML .= "</td></tr></table>";
                
                $resultSearchHTML .= "<table class=\"border\">";
                $resultSearchHTML .= "<caption>LISTADO DE COMPRAS</caption><th class=\"border\">Precio</th>";
                $resultSearchHTML .= "<th class=\"border\">Descripción</th><th class=\"border\">Fecha</th>";
                $resultSearchHTML .= "<th class=\"border\">Comprador</th><th class=\"border\">Asignar Compra</th>";

                while ($line = mysql_fetch_assoc($result))
                {
                    $resultSearchHTML .= "<tr class=\"border\">";
                    $c = 0;
                    foreach ($line as $valor) 
                    {
                        if ($c == 0)
                        {

                            $idPurchase = $valor;
                        }
                        if ($c == 3)
                        {

                            $datePurchase = date("d-m-Y", $valor);
                            $resultSearchHTML .= "<td class=\"border\">$datePurchase</td>";
                        }

                        if (($c != 0) && ($c != 3))
                        {
                            $resultSearchHTML .= "<td class=\"border\">$valor</td>";
                        }

                        $c++;
                    }

                    $resultSearchHTML .= "<td class=\"border\"><input type=\"radio\" name=\"id_purchase\" value=\"$idPurchase\"></td>";


                    $resultSearchHTML .= "</tr>";
                }
                $resultSearchHTML .= "</table>";
                
                
            }
            else
            {
                $resultSearchHTML .= "<table><tr><td>No se ha encontrado ninguna compra registrada</td></tr></table>";
            }

            mysql_close($conexion);

    }

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


