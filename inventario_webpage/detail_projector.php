<?php
    
    require_once "ini.php";
    check_session();  
    $_SESSION["actual_page"] = "detail_projector.php";  

    $pathImage= getImagePath();
    $pathIcon = getIconPath();
    
    
     if(array_key_exists("download", $_POST))
    {
        $url = "";
        $idDriver = $_POST["download"];
        
        $sel = "select * from driver where id_driver = $idDriver;";
        $row = select_one($sel);
        
        $name = $row["name_driver"];
        $url = getDriverPath() . $name;
        $nameReal = $row["name_real_driver"];
        
        if (is_file($url))
        {
           header('Content-Type: application/force-download');
           header('Content-Disposition: attachment; filename='. $nameReal);
           header('Content-Transfer-Encoding: binary');
           header('Content-Length: '. filesize($url));

           readfile($url);
        }
        else
          $msg = "Archivo no descargado";
      
    }
    
    if(array_key_exists("deleteDriver", $_POST))
    {
        $idDriver = $_POST["deleteDriver"];
        unset($_SESSION["idElectronic"]);
        $_SESSION["idDriver"]= $idDriver;
        redirect("confirm_action.php");
    }
    
    
    if(array_key_exists("idElectronic", $_SESSION)) 
    {

        $idElectronic = $_SESSION["idElectronic"];
        $conexion =  new_conex_db();

        $selectEq = "select * from $tableElectEq where id_electronic_eq =" . $idElectronic . ";" ;
        $selectProj = "select * from $tableProjector where id_electronic_eq=" . $idElectronic . ";"  ; 

        $rowEquipment = select_one($selectEq);
        $rowProj = select_one($selectProj);

        $idOffice =  $rowEquipment['id_office'];
        $nameOffice = GetNameOption($rowEquipment['id_office'], "office", "id_office", "name_office");

        $selectBuilding = "select name_building from $tableBuilding where id_building in 
                            ( select id_building from office where id_office = $idOffice);";
        $rowBuilding = select_one($selectBuilding);
        $nameBuilding = $rowBuilding['name_building'];

        $codeUrjc =  $rowEquipment['urjc_code'];
        $serialNum =  $rowEquipment['serial_number'];
        $image1_name =  $rowEquipment['image_1'];
        $pathImage1 = $pathImage . $image1_name;
        $image2_name =  $rowEquipment['image_2'];
        $pathImage2 = $pathImage . $image2_name;

        $nameStatus = GetNameOption($rowEquipment['status'], "status", "id_status", "name_status");
        $nameUserA = GetNameOption($rowEquipment["id_user_asigned"], "user", "id_user", "name");
        $nameUserC = GetNameOption($rowEquipment["id_user_creation"], "user", "id_user", "name");
        $nameUserM = GetNameOption($rowEquipment["id_user_modify"], "user", "id_user", "name");
        $nameUserD = GetNameOption($rowEquipment["id_user_delete"], "user", "id_user", "name");

        $date_creation = $rowEquipment['date_creation'];
        $date_modify = $rowEquipment['date_modify'];
        $date_delete = $rowEquipment['date_delete'];
        if($rowEquipment['date_delete'] == -1)
        {
            $date_delete = "Equipo no descatalogado"; 
        }
        else
        {
            $date_Delete = $rowEquipment['date_delete'];
            $date_delete = date('d/m/Y',$date_Delete);
        }
        $description = $rowEquipment['description'];
        $trademark = $rowProj['trademark'];
        $model = $rowProj['model'];
        $typeProjector = GetNameOption($rowProj['type'], "projector_type", "id_type_projector", "name_projector");
        $bright = $rowProj['bright'];
        $contrast = $rowProj['contrast'];
        
        
        //lista de drivers del equipo
        $resultSearchHTML2 = "";
       
        $selectDriver = "select id_driver, description, category_driver, name_driver, "
                . " size_driver,  user_upload, date_upload, version from driver where  "
                . "id_electronic_eq = $idElectronic;";

        $resultDriver =  mysql_query($selectDriver,$conexion);
        $rowDriver = select_one($selectDriver);
        $dateUpload = $rowDriver["date_upload"];

        if (mysql_num_rows($resultDriver)>0)
        {
            if(is_admin(getUserInSession()))
            {
                // Imprimir los resultados en HTML
                $resultSearchHTML2 .= "<table class=\"border\">";
                $resultSearchHTML2 .= "<caption>DRIVERS ASIGNADOS AL EQUIPO</caption><br>";
                $resultSearchHTML2 .= "<th class=\"border\">Descargar</th><th class=\"border\">Descripción</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Categoría</th><th class=\"border\">Nombre</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Tamaño</th><th class=\"border\">Usuario de subida</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Fecha de subida</th><th class=\"border\">Versión</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Comentarios</th><th class=\"border\">Eliminar</th>";
            }
            else 
            {
                $resultSearchHTML2 .= "<table class=\"border\">";
                $resultSearchHTML2 .= "<caption>DRIVERS ASIGNADOS AL EQUIPO</caption><br>";
                $resultSearchHTML2 .= "<th class=\"border\">Descargar</th><th class=\"border\">Descripción</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Categoría</th><th class=\"border\">Nombre</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Tamaño</th><th class=\"border\">Usuario de subida</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Fecha de subida</th><th class=\"border\">Versión</th>";   
                $resultSearchHTML2 .= "<th class=\"border\">Comentarios</th>";
                
            }
            while ($line = mysql_fetch_assoc($resultDriver)) 
            {
                $resultSearchHTML2 .= "<tr class=\"border\">";

                $c = 0;
                foreach ($line as $valor) 
                {
                    if ($c==0)
                    {

                        $idDriver = $valor;
                       $resultSearchHTML2 .= "<td class=\"border\"><input type=\"submit\" class=\"download\" name=\"download\" value=\"$valor\"/></input></td>";
                    }
                    if ($c==5)
                    {

                    $nameUser = GetNameOption($valor, "user", "id_user", "name");
                    $resultSearchHTML2 .= "<td class=\"border\">$nameUser</td>";
                    }
                    if ($c==6)
                    {
                        $date = date('d/m/Y',$dateUpload);
                        $resultSearchHTML2 .= "<td class=\"border\">$date</td>";

                    }
                  
                    if(($c != 0)&& ($c != 5) && ($c != 6)) 
                    {
                        $resultSearchHTML2 .= "<td class=\"border\">$valor</td>";
                    }


                    $c++;
                }
                if(is_admin(getUserRolInSession()))
                {
                $resultSearchHTML2 .= "<td class=\"border\"><input type=\"submit\" class=\"delete\" name=\"deleteDriver\" value=\"$idDriver\"/></input></td>";
                }
                $resultSearchHTML2 .= "</tr>\n";
            }
            $resultSearchHTML2 .= "</table>\n";
        }
        else
        {
            $resultSearchHTML2 .= "<table><tr><td>EL EQUIPO NO TIENE NINGÚN DRIVER ASIGNADO</td></tr></table>";
        }

        mysql_close($conexion);

    } 
    else
    {
        redirect("list_projector.php");
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
                                            <caption>DETALLES DEL PROYECTOR</caption>
                                            <tr class ="border">
                                                <td class ="tdBack">Código URJC</td><td class ="border"><?php echo $codeUrjc;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Número de serie</td><td class ="border"><?php echo $serialNum;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Edificio</td><td class ="border"><?php echo $nameBuilding;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Despacho</td><td class ="border"><?php echo $nameOffice;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Imagen 1</td><td class ="border"><img src ="<?php echo $pathImage1;?>" width="100 "height="100"></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Imagen 2</td><td class ="border"><img src ="<?php echo $pathImage2;?>" width="100 "height="100"></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Estado</td><td class ="border"><?php echo$nameStatus; ;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Usuario asignado</td><td class ="border"><?php echo $nameUserA; ?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Usuario de creación</td><td class ="border"><?php echo $nameUserC; ?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Usuario de modificación</td><td class ="border"><?php echo $nameUserM; ?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Usuario de borrado</td><td class ="border"><?php echo $nameUserD; ?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Fecha de creación </td><td class ="border"><?php echo date('d/m/Y', $date_creation) ;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Fecha de modificación</td><td class ="border"><?php echo date('d/m/Y', $date_modify) ;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Fecha de borrado</td><td class ="border"><?php echo $date_delete ;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Marca</td><td class ="border"><?php echo $trademark;?></td>
                                            </tr>
                                             <tr class ="border">
                                                <td class ="tdBack">Modelo</td><td class ="border"><?php echo $model;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Tipo</td><td class ="border"><?php echo $typeProjector;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Brillo</td><td class ="border"><?php echo $bright;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Contraste</td><td class ="border"><?php echo $contrast;?></td>
                                            </tr>
                                            <tr class ="border">
                                                <td class ="tdBack">Comentarios:</td>
                                                <td class ="border"><?php echo $description ?></td>
                                            </tr>
                                        </table>
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



