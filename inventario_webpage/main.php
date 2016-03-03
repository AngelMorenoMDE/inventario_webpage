<?php

    require_once "ini.php"; 
    check_session();
    unset($_SESSION["idProject"]);
    unset($_SESSION["idPurchase"]);
    unset($_SESSION["idoffice"]);
    unset($_SESSION["idbuilding"]);
    
    $errores = "";
    
    $_SESSION["actual_page"] = "main.php";
    
    if(array_key_exists("user", $_POST))
    {
               
        redirect ("list_user.php");
      
    }
    
    if(array_key_exists("purchase", $_POST))
    {
               
        redirect ("list_purchase.php");
      
    }
    
    if(array_key_exists("building", $_POST))
    {
               
        redirect ("list_building.php");
      
    }
    
    if(array_key_exists("project", $_POST))
    {
               
        redirect ("list_project.php");
      
    }
    
    if(array_key_exists("electronic_eq", $_POST))
    {
               
        redirect ("new_eq.php");
      
    }
    
    if(array_key_exists("search", $_POST))
    {
               
        redirect ("search.php");
      
    }
    
    if(array_key_exists("help", $_POST))
    {
               
        redirect ("help.php");
      
    }
    
    if(array_key_exists("exit", $_POST))
    {
               
        redirect ("exit.php");
      
    }
    
    $desha = "";
    if(!is_admin(getUserRolInSession()))
    {
        $desha = "disabled=\"true\"";
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
                                    

                                    <div class="post">
                                        <form action="" method="post">
                                                    <table>
                                                        <tr>
                                                            <td><input type="submit"  class="search" name="search"  title="Ir a Buscador" value="search" ></input></td>
                                                            <td><input type="submit" class="building" title="Ir a Edificios"name="building" value="building" ></input></td>
                                                            <td><input type="submit" class="project" title="Ir a Proyectos" name="project" value="project" ></input></td>
                                                            <td><input type="submit" class="purchase" name="purchase" title="Ir a Compras" value="purchase" ></input></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="submit" class="user" name="user" title="Ir a Usuarios" value="user" <?php echo $desha;?>></input></td>
                                                            <td><input type="submit" class="elect_eq" name="electronic_eq" title="Crear Equipos Electrónicos" value="electronic_eq" ></input></td>
                                                            <td><input type="submit" class="help" name="help" title="Ayuda" value="help" ></input></td>
                                                            <td><input type="submit" class="exit" name="exit" title="Salir" value="exit" ></input></td>
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

