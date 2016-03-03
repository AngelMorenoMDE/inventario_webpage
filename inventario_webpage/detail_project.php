<?php
    require_once "ini.php"; 
    check_session();
    $errores = "";
    $_SESSION["actual_page"] = "detail_project.php";
   
    
    if(array_key_exists("delete", $_POST))
    {
        $idElect = $_POST["delete"];
        $_SESSION["idElect"] = $idElect;
        redirect("confirm_action.php");
        
    }
    
    if(array_key_exists("deletePro", $_POST))
    {
        $idProjectDoc = $_POST["deletePro"];
        unset($_SESSION["idElect"]);
        $_SESSION["idProjectDoc"] = $idProjectDoc;
        redirect("confirm_action.php");
    }
    
    if(array_key_exists("download", $_POST))
    {
        $url = "";
        $idProjectDoc = $_POST["download"];
        
        $sel = "select name from $tableProjectDoc where id_project_doc = $idProjectDoc;";
        $row = select_one($sel);
        
        $name = $row["name"];
        $url = getDocumentPath() . $name;
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
         
    if(array_key_exists("idProject", $_SESSION)) 
    {
    
        $idProject = $_SESSION["idProject"];
                
        $selectProject = "select * from $tableProject where id_project=" . $idProject . ";"; 
         
        $rowProject = select_one($selectProject);
                            
        $nameProject = $rowProject['name_project'];
        $nameStatus = GetNameOption($rowProject['id_project_status'], "project_status", "id_project_status", "name_project_status");
        $summary = $rowProject['summary'];
        $nameUserC = GetNameOption($rowProject["id_user_creation"], "user", "id_user", "name");
        $date_creation = $rowProject['date_creation'];
        $nameUserM = GetNameOption($rowProject["id_user_modify"], "user", "id_user", "name");
        $date_modify = $rowProject['date_modify'];
        $nameUserD = GetNameOption($rowProject["id_user_delete"], "user", "id_user", "name");
        $date_delete = $rowProject['date_delete'];
     
        if($rowProject['id_user_delete'] == -1)
        {
            $nameUserD = ""; 
        }
        else
        {
            $id_user_delete = $rowProject['id_user_delete']; 
            $selectUser = "select * from $tableUser where id_user=" .$id_user_delete.";";
            $rowUser = select_one($selectUser);
            $nameUserD = $rowUser['name'];
        }
        
         if($rowProject['date_delete'] == -1)
        {
            $date_delete = "Proyecto no terminado"; 
        }
        else
        {
            $dateDelete = $rowProject['date_delete'];
            $date_delete = date('d/m/Y',$dateDelete);
        }
        
        //lista de equipos del proyecto
        $resultSearchHTML ="";
        $conexion = new_conex_db();

        $sel = "select id_electronic_eq, electronic_eq_type, urjc_code, "
                . " id_office, status from $tableElectEq where  "
                . "id_electronic_eq in (select id_electronic_eq from project_eq "
                . "where id_project = " . $idProject . ") order by electronic_eq_type;";

        $result =  mysql_query($sel,$conexion);
        if (mysql_num_rows($result)>0)
        {
            if(is_admin(getUserRolInSession()))
            {
            // Imprimir los resultados en HTML
            $resultSearchHTML .= "<table class=\"border1\">";
            $resultSearchHTML .= "<caption>EQUIPOS ELECTRONICOS ASIGNADOS AL PROYECTO</caption><br>";
            $resultSearchHTML .= "<th class=\"border\">Tipo Equipo</th><th class=\"border\">Código URJC</th>";
            $resultSearchHTML .= "<th class=\"border\">Despacho</th><th class=\"border\">Edificio</th>";
            $resultSearchHTML .= "<th class=\"border\">Estado</th><th class=\"border\">Eliminar</th>";
            }
            else 
            {
                $resultSearchHTML .= "<table class=\"border1\">";
                $resultSearchHTML .= "<caption>EQUIPOS ELECTRONICOS ASIGNADOS AL PROYECTO</caption><br>";
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
            $resultSearchHTML .= "<table><tr><td>EL PROYECTO NO TIENE NINGÚN EQUIPO ELECTRÓNICO ASIGNADO</td></tr></table>";
        }


        //lista de documentos del proyecto
        $resultSearchHTML2 = "";
        //$conexion = new_conex_db();

        $selectDoc = "select id_project_doc, name, name_description, "
                . " size, date_upload, user_upload from $tableProjectDoc where  "
                . "id_project = $idProject;";

        $resultDoc =  mysql_query($selectDoc,$conexion);
        $rowDoc = select_one($selectDoc);
        $dateUpload = $rowDoc["date_upload"];

        if (mysql_num_rows($resultDoc)>0)
        {
            if(is_admin(getUserInSession()))
            {
                // Imprimir los resultados en HTML
                $resultSearchHTML2 .= "<table class=\"border1\">";
                $resultSearchHTML2 .= "<caption>DOCUMENTOS ASIGNADOS AL PROYECTO</caption><br>";
                $resultSearchHTML2 .= "<th class=\"border\">Descargar</th><th class=\"border\">Nombre</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Nombre Real</th><th class=\"border\">Tamaño</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Fecha de subida</th>";
                $resultSearchHTML2 .= "<th class=\"border\">Usuario de subida</th><th class=\"border\">Eliminar</th>";
            }
            else 
            {
                $resultSearchHTML2 .= "<table class=\"border1\">";
                $resultSearchHTML2 .= "<caption>DOCUMENTOS ASIGNADOS AL PROYECTO</caption><br>";
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

                        $idProjectDoc = $valor;
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
                $resultSearchHTML2 .= "<td class=\"border\"><input type=\"submit\" class=\"delete\" name=\"deletePro\" value=\"$idProjectDoc\"/></input></td>";
                }
                $resultSearchHTML2 .= "</tr>\n";
            }
            $resultSearchHTML2 .= "</table>\n";
        }
        else
        {
            $resultSearchHTML2 .= "<table><tr><td>EL PROYECTO NO TIENE NINGÚN DOCUMENTO ASIGNADO</td></tr></table>";
        }

        mysql_close($conexion);
   
        
    } 
    else
    {
        redirect("list_project.php");
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
                                                <table class ="border">
                                                    <caption>DETALLES DEL PROYECTO</caption>
                                                    <tr class ="border">
                                                        <td id = "1" class ="tdBack">Nombre de proyecto: </td><td class ="border"><?php echo $nameProject?></td>
                                                    </tr>
                                                    
                                                    <tr class ="border">
                                                        <td class ="tdBack">Estado: </td><td class ="border"><?php echo $nameStatus?></td>
                                                    </tr>
                                                    <tr class ="border">
                                                        <td class ="tdBack">Usuario creación: </td><td class ="border"><?php echo $nameUserC;?></td>
                                                    </tr>
                                                    <tr class ="border">
                                                        <td class ="tdBack">Fecha creación: </td><td class ="border"><?php echo date('d/m/Y',$date_creation)?></td>
                                                    </tr>
                                                    <tr class ="border">
                                                        <td class ="tdBack">Usuario modificación: </td><td class ="border"><?php echo $nameUserM;?></td>
                                                    </tr>
                                                    <tr class ="border">
                                                        <td class ="tdBack">Fecha modificación: </td><td class ="border"><?php echo date('d/m/Y',$date_modify)?></td>
                                                    </tr>
                                                    <tr class ="border">
                                                        <td class ="tdBack">Usuario finalización: </td><td class ="border"><?php echo $nameUserD;?></td>
                                                    </tr>
                                                    <tr class ="border">
                                                        <td class ="tdBack">Fecha finalización: </td><td class ="border"><?php echo $date_delete?></td>
                                                    </tr>
                                                    <tr class ="border">
                                                        <td class ="tdBack">Comentarios: </td><td class ="border"><?php echo $summary?></td>
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

