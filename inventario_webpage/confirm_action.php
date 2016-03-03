<?php
require_once "ini.php";
    
check_session();
check_rol_privileges();
$msg = "";
   
$page = $_SESSION["actual_page"];


if (($page == "detail_computer.php")||($page == "detail_keyboard.php")
        &&($page == "detail_monitor.php")||($page == "detail_mouse.php")||
        ($page == "detail_printer.php")||($page == "detail_projector.php")||
        ($page == "detail_scanner.php")||($page == "detail_wire.php")&&
        (array_key_exists("idDriver", $_SESSION)))
{
     $question = "¿Está seguro que quiere eliminar este driver del Equipo?";
            if(array_key_exists("confirm", $_POST))
            {
                $idDriver = $_SESSION["idDriver"];
                $sel = "delete from driver where id_driver = " . $idDriver . ";";
        
                if(execute_query($sel))
                {
                       redirect("list_electronic_eq.php");
                } 
            }
           if(array_key_exists("cancel", $_POST)) 
            {
                
                $idDriver = $_SESSION["idDriver"];
                $select ="select id_electronic_eq from driver where id_driver = $idDriver;";
                $row = select_one($select);
                $idElectronic = $row['id_electronic_eq'];

                $selectType ="select electronic_eq_type from $tableElectEq where id_electronic_eq = $idElectronic ;";
                $rowtype = select_one($selectType);
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
                        
            }
}


if (($page == "detail_purchase.php")&&(array_key_exists("idPurchaseDoc", $_SESSION)))
{
     $question = "¿Está seguro que quiere eliminar este documento de la Compra?";
            if(array_key_exists("confirm", $_POST))
            {
                $idPurchaseDoc = $_SESSION["idPurchaseDoc"];
                $sel = "delete from purchase_doc where id_purchase_doc = " . $idPurchaseDoc . ";";
        
                    if(execute_query($sel))
                    {
                           redirect("detail_purchase.php");
                    }
            }
                             
        

            if(array_key_exists("cancel", $_POST)) 
            {
                     redirect("detail_purchase.php");     
            }
}


if (($page == "detail_purchase.php")&&(array_key_exists("idElect", $_SESSION)))
{
     $question = "¿Está seguro que quiere eliminar este equipo Electrónico de la Compra?";
            if(array_key_exists("confirm", $_POST))
            {
                
                $idElect = $_SESSION["idElect"];
                $sel = "delete from purchase_eq where id_electronic_eq = " . $idElect . ";";
        
                    if(execute_query($sel))
                    {
                           redirect("detail_purchase.php");
                    }
            }
                             
        

            if(array_key_exists("cancel", $_POST)) 
            {
                     redirect("detail_purchase.php");     
            }
}


if (($page == "detail_project.php")&&(array_key_exists("idProjectDoc", $_SESSION)))
{
     $question = "¿Está seguro que quiere eliminar este documento del Proyecto?";
            if(array_key_exists("confirm", $_POST))
            {
                $idProjectDoc = $_SESSION["idProjectDoc"];
                $sel = "delete from project_doc where id_project_doc = " . $idProjectDoc . ";";
        
                    if(execute_query($sel))
                    {
                           redirect("detail_project.php");
                    }
            }
                             
        

            if(array_key_exists("cancel", $_POST)) 
            {
                     redirect("detail_project.php");     
            }
}


if (($page == "detail_project.php")&&(array_key_exists("idElect", $_SESSION)))
{
     $question = "¿Está seguro que quiere eliminar este equipo Electrónico del Proyecto?";
            if(array_key_exists("confirm", $_POST))
            {
                
                $idElect = $_SESSION["idElect"];
                $idProject = $_SESSION["idProject"];
                $sel = "delete from project_eq where id_electronic_eq = " . $idElect . 
                " and id_project = " . $idProject . ";";
        
                    if(execute_query($sel))
                    {
                           redirect("detail_project.php");
                    }
            }
                             
        

            if(array_key_exists("cancel", $_POST)) 
            {
                     redirect("detail_project.php");     
            }
}



if ($page == "list_office.php")
{
     $question = "¿Está seguro que quiere borrar este Despacho?";
        if(array_key_exists("confirm", $_POST))
            {
                $idOffice = $_SESSION["idOffice"];
                $conexion = new_conex_db();
                $sel ="select * from $tableElectEq where id_office = $idOffice ;";
                $result =  mysql_query($sel,$conexion);
                    if (mysql_num_rows($result)>0)
                    {
                       $msg = "No se puede borrar este Despacho por tener Equipos Electrónicos asignados." ; 
                    }
                    else 
                    {
                        $del = "delete from $tableOffice where id_office=$idOffice;";
   
                            if (execute_query($del))
                            {
                                redirect("list_office.php");

                            }
                    }
                             
            }

         if(array_key_exists("cancel", $_POST)) 
            {
                     redirect("list_office.php");     
            }
}


if ($page == "list_building.php")
{
    
    $question = "¿Está seguro que quiere borrar este edificio?";
        if(array_key_exists("confirm", $_POST))
            {
                $idBuilding = $_SESSION["idBuilding"];
                $conexion = new_conex_db();
                $sel ="select * from office where id_building = $idBuilding";
                $result =  mysql_query($sel,$conexion);
                    if (mysql_num_rows($result)>0)
                    {
                       $msg = "No se puede borrar este Edificio por tener Despachos asignados." ; 
                    }
                    else 
                    {
                        $del = "delete from $tableBuilding where id_building=$idBuilding;";
   
                            if (execute_query($del))
                            {
                                redirect("list_building.php");

                            }
                    }
                             
            }

         if(array_key_exists("cancel", $_POST)) 
            {
                     redirect("list_building.php");     
            }
}

if ($page == "list_user.php")
{
    
    $question = "¿Está seguro que quiere borrar este usuario?";
    if(array_key_exists("confirm", $_POST))
    {
        $idUser = $_SESSION["idUser"];
        $conexion = new_conex_db();
        $sel = "select * from $tableElectEq where id_user_asigned = $idUser;";
        $result =  mysql_query($sel,$conexion);
        if (mysql_num_rows($result)>0)
        {
           $msg .= "No se puede borrar este Usuario por tener Equipos Electrónicos asignados." ; 
        }
        else 
        {

            $selectAdmin = "select id_user from $tableUser where id_rol = 1 && id_user = $idUser;";
            $resultAdmin = mysql_query($selectAdmin, $conexion);
            $rowAdmin = select_one($selectAdmin);
            $idUserAdmin = $rowAdmin['id_user'];

            if(mysql_num_rows($resultAdmin)>1)
            {
                $del = "delete from $tableUser where id_user=$idUser;";

                if (execute_query($del))
                {
                    redirect("list_user.php");

                } 

            }
            else 
            {

               if($idUser==$idUserAdmin)
                {
                   $msg .= "No se puede borrar este Usuario por ser el único Administrador"; 
                }
                else
                {
                   $del = "delete from $tableUser where id_user=$idUser;";

                    if (execute_query($del))
                    {
                        redirect("list_user.php");

                    }  
                }

            }

        }
    }

    if(array_key_exists("cancel", $_POST)) 
    {
             redirect("list_user.php");     
    }
}


if ($page == "list_project.php")
{
    $question = "¿Está seguro que quiere cerrar el proyecto?";
            if(array_key_exists("confirm", $_POST))
            {
                $idProject = $_SESSION["idProject"];
                $idUserDelete = $_SESSION[USER_SESSION()];
                $dateDelete  = time();
                $status = 2;
                $delProject = "update $tableProject set  id_project_status =" . $status .
                                            ", id_user_delete =" . $idUserDelete . 
                                            ", date_delete = " . $dateDelete .
                            " where id_project =" . $idProject. ";";

                if(execute_query($delProject))
                 {

                    redirect("list_project.php");

                 }
            }

         if(array_key_exists("cancel", $_POST)) 
            {
                     redirect("list_project.php");     
            }
}

if ($page == "list_purchase.php")
{
    $question = "¿Está seguro que quiere borrar la compra?";
        if(array_key_exists("confirm", $_POST))
            {
                $idPurchase = $_SESSION["idPurchase"];
                $del = "delete from purchase where id_purchase ="  . $idPurchase . ";";
   
                if (execute_query($del))
                {
                    redirect("list_purchase.php");

                }
            }

         if(array_key_exists("cancel", $_POST)) 
            {
                     redirect("list_purchase.php");     
            }
    
    
}
   
    

    
    $resulthtml = "<table align = \"center\"><tr><td><h3>$question</h3></td><td></td></tr></table>";
    $resulthtml .= "<table align=\"center\"><tr>";
    $resulthtml .= "<td><input type=\"submit\" class=\"normalButton\" name=\"confirm\" value=\"Confirmar\" />";
    $resulthtml .="</td><td></td><td></td><td></td><td></td><td>";
    $resulthtml .= "<input type=\"submit\" class=\"normalButton\" name=\"cancel\" value=\"Cancelar\" />";
    $resulthtml .= "</td></tr></table>";   
    
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
                                            
                                           <?php echo $resulthtml; ?>
                                            <?php echo $msg; ?>
                                        </form>
                                     </div>
                                    <div class="post">
                                 </div>                                    
                                </div>
				
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

    


