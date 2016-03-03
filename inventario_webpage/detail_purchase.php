<?php

require_once "ini.php";
    check_session();  
    $_SESSION["actual_page"] = "detail_purchase.php";  
 
    if(array_key_exists("delete", $_POST))
    {
        $idElect = $_POST["delete"];
        $_SESSION["idElect"] = $idElect;
        redirect("confirm_action.php");
       
    }
    
     if(array_key_exists("deletePur", $_POST))
    {
        $idPurchaseDoc = $_POST["deletePur"];
        unset($_SESSION["idElect"]);
        $_SESSION["idPurchaseDoc"] = $idPurchaseDoc;
        redirect("confirm_action.php");
        
    }
    
    if(array_key_exists("download", $_POST))
    {
        $url = "";
        $idPurchaseDoc = $_POST["download"];
        
        $sel = "select name from $tablePurchaseDoc where id_purchase_doc = $idPurchaseDoc;";
        $row = select_one($sel);
        
        $name = $row["name"];
        $url = getDocumentPath() . $name;
        $nameReal = $row["name_real_driver"];
        
        if (is_file($url))
        {
           header('Content-Type: application/force-download');
           header('Content-Disposition: attachment; filename='.$nameReal);
           header('Content-Transfer-Encoding: binary');
           header('Content-Length: '.filesize($url));

           readfile($url);
        }
        else
           $msg = "Archivo no descargado";
        
       

    }
    
    
    if(array_key_exists("idPurchase", $_SESSION)) 
    {
       $idPurchase = $_SESSION["idPurchase"];
       
       $sel = "select * from purchase where id_purchase =" . $idPurchase . ";";
       $rowPurchase = select_one($sel);
       
       $project = GetNameOption($rowPurchase["id_project"], "project", "id_project", "name_project");
       $price = $rowPurchase["price"];
       $name = $rowPurchase["name_purchase"];
       $datePurchase = $rowPurchase["date_purchase"];
       $purchaser = $rowPurchase["purchaser"];
   
       $resultSearchHTML ="";
        $conexion = new_conex_db();

        $sel = "select id_electronic_eq, electronic_eq_type, urjc_code, "
                .  "id_office, status from $tableElectEq where  "
                . "id_electronic_eq in (select id_electronic_eq from purchase_eq "
                . "where id_purchase = " . $idPurchase . ");";

        $result =  mysql_query($sel,$conexion);
        if (mysql_num_rows($result)>0)
        {
            if(is_admin(getUserRolInSession()))
            {
            // Imprimir los resultados en HTML
            $resultSearchHTML .= "<table class=\"border1\">";
            $resultSearchHTML .= "<caption>EQUIPOS ELECTRONICOS ASIGNADOS LA COMPRA</caption><br>";
            $resultSearchHTML .= "<th class=\"border\">Tipo Equipo</th><th class=\"border\">Código URJC</th>";
            $resultSearchHTML .= "<th class=\"border\">Despacho</th><th class=\"border\">Edificio</th>";
            $resultSearchHTML .= "<th class=\"border\">Estado</th><th class=\"border\">Eliminar</th>";
            }
            else
            {
                $resultSearchHTML .= "<table class=\"border1\">";
                $resultSearchHTML .= "<caption>EQUIPOS ELECTRONICOS ASIGNADOS LA COMPRA</caption><br>";
                $resultSearchHTML .= "<th class=\"border\">Tipo Equipo</th><th class=\"border\">Código URJC</th>";
                $resultSearchHTML .= "<th class=\"border\">Despacho</th><th class=\"border\">Edificio</th>";
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
                        if($c == 3)
                        {
                           $nameOffice = GetNameOption($valor, "office", "id_office", "name_office");
                           $resultSearchHTML .= "<td class=\"border\">$nameOffice</td>";
                           $selBuilding = "select name_building from building where id_building in "
                                   . "(select id_building from office where id_office = " .$valor . ");";
                           $row = select_one($selBuilding);
                           $nameBuilding = $row["name_building"];
                           $resultSearchHTML .= "<td class=\"border\">$nameBuilding</td>";

                        }

                        if($c == 4)
                        {
                           $status = GetNameOption($valor, "status", "id_status", "name_status");
                           $resultSearchHTML .= "<td class=\"border\">$status</td>";
                        }



                        if  (($c != 0)&& ($c != 1) && ($c != 3) && ($c != 4))
                        {
                            $resultSearchHTML .= "<td class=\"border\">$valor</td>";
                        }

                    }
                    $c++;
                }
                if(is_admin(getUserRolInSession()))
                {
                $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"delete\" name=\"delete\" value=\"$idElect\"></input></td>";
                }
                $resultSearchHTML .= "</tr>\n";
            }
            $resultSearchHTML .= "</table>\n";
        }
        else
        {
            $resultSearchHTML .= "<table><tr><td>LA COMPRA NO TIENE NINGÚN EQUIPO ELECTRÓNICO ASIGNADO</td></tr></table>";
        }


         //lista de documentos del pryecto
        $resultSearchHTML2 = "";
        //$conexion = new_conex_db();

        $selectDoc = "select id_purchase_doc, name, name_description, "
                . " size, date_upload, user_upload from $tablePurchaseDoc where  "
                . "id_purchase = $idPurchase;";

        $resultDoc =  mysql_query($selectDoc,$conexion);
        $rowDoc = select_one($selectDoc);
        $dateUpload = $rowDoc["date_upload"];

        if (mysql_num_rows($resultDoc)>0)
        {
            if(is_admin(getUserRolInSession()))
            {
                // Imprimir los resultados en HTML
                $resultSearchHTML2 .= "<table class=\"border1\">";
                $resultSearchHTML2 .= "<caption>DOCUMENTOS ASIGNADOS A LA COMPRA</caption><br>";
                $resultSearchHTML2 .= "<th class=\"border\">Descargar</th><th class=\"border\">Nombre</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Nombre Real</th><th class=\"border\">Tamaño</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Fecha de subida</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Usuario de subida</th><th class=\"border\">Eliminar</th>";
            }
            else
            {
                $resultSearchHTML2 .= "<table class=\"border1\">";
                $resultSearchHTML2 .= "<caption>DOCUMENTOS ASIGNADOS A LA COMPRA</caption><br>";
                $resultSearchHTML2 .= "<th class=\"border\">Descargar</th><th class=\"border\">Nombre</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Nombre Real</th><th class=\"border\">Tamaño</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Fecha de subida</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Usuario de subida</th>";
            }
            while ($line = mysql_fetch_assoc($resultDoc)) 
            {
                $resultSearchHTML2 .= "<tr class=\"border\">";

                $c = 0;
                foreach ($line as $valor) 
                {
                    if ($c==0)
                    {

                        $idPurchaseDoc = $valor;
                       $resultSearchHTML2 .= "<td class=\"border\"><input type=\"submit\" class=\"download\" name=\"download\" value=\"$valor\"/></input></td>";
                    }
                    if ($c==4)
                    {
                        $date = date('d/m/Y',$dateUpload);
                        $resultSearchHTML2 .= "<td class=\"border\">$date</td>";

                    }
                    if ($c==5)
                    {

                    $nameUser = GetNameOption($valor, "user", "id_user", "name");
                    $resultSearchHTML2 .= "<td class=\"border\">$nameUser</td>";
                    }

                    if(($c != 0)&& ($c != 4) && ($c != 5)) 
                    {
                        $resultSearchHTML2 .= "<td class=\"border\">$valor</td>";
                    }


                    $c++;
                }
                if(is_admin(getUserRolInSession()))
                {
                $resultSearchHTML2 .= "<td class=\"border\"><input type=\"submit\" class=\"delete\" name=\"deletePur\" value=\"$idPurchaseDoc\"/></input></td>";
                }
                $resultSearchHTML2 .= "</tr>";
            }
            $resultSearchHTML2 .= "</table>";
        }
        else
        {
            $resultSearchHTML2 .= "<table><tr><td>LA COMPRA NO TIENE NINGÚN DOCUMENTO ASIGNADO</td></tr></table>";
        }


        mysql_close($conexion);

        
    } 
    else
    {
        redirect("list_purchase.php");
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
       
                   
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <table class ="border">
                                            <caption>DETELLES DE LA COMPRA</caption>
                                            <tr class ="border">
                                                <td class ="tdBack">Descripción</td><td class ="border"><?php echo $name;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Proyecto</td><td class ="border"><?php echo $project;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Precio</td><td class ="border"><?php echo $price;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Fecha de compra </td><td class ="border"><?php echo date('d/m/Y', $datePurchase);?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Comprador</td><td class ="border"><?php echo $purchaser;?></td>
                                            </tr>

                                        </table>
                                        <?php echo $resultSearchHTML; ?>
                                        <?php echo $resultSearchHTML2; ?>
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



