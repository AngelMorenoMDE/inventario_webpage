<?php

    require_once "ini.php"; 
    check_session();
    
    $errores = "";
    
    $_SESSION["actual_page"] = "new_eq.php";
    
    if(array_key_exists("computer", $_POST))
    {
               
        redirect ("new_computer.php");
      
    }
    
    if(array_key_exists("monitor", $_POST))
    {
               
        redirect ("new_monitor.php");
      
    }
    
    if(array_key_exists("printer", $_POST))
    {
               
        redirect ("new_printer.php");
      
    }
    
    if(array_key_exists("scanner", $_POST))
    {
               
        redirect ("new_scanner.php");
      
    }
    
    if(array_key_exists("mouse", $_POST))
    {
               
        redirect ("new_mouse.php");
      
    }
    
    if(array_key_exists("keyboard", $_POST))
    {
               
        redirect ("new_keyboard.php");
      
    }
    
    if(array_key_exists("projector", $_POST))
    {
               
        redirect ("new_projector.php");
      
    }
    
    if(array_key_exists("wire", $_POST))
    {
               
        redirect ("new_wire.php");
      
    }
    if(array_key_exists("other", $_POST))
    {
               
        redirect ("new_other.php");
      
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
                                                    <table>
                                                        <tr>
                                                            <td><input type="submit" class="computer" name="computer" title="Crear Ordenador" value="computer" /></td>
                                                            <td><input type="submit" class="monitor" name="monitor" title="Crear Monitor" value="monitor" /></td>
                                                            <td><input type="submit" class="printer" name="printer" title="Crear Impresora" value="printer" /></td>
                                                            <td><input type="submit" class="scanner" name="scanner" title="Crear Escaner" value="scanner" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="submit" class="projector" name="projector" title="Crear Proyector" value="projector" /></td>
                                                            <td><input type="submit" class="keyboard" name="keyboard" title="Crear Teclado" value="keyboard" /></td>
                                                            <td><input type="submit" class="mouse" name="mouse" title="Crear Ratón" value="mouse" /></td>
                                                            <td><input type="submit" class="wire" name="wire" title="Crear Cables" value="wire" /></td>
                                                            <td><input type="submit" class="other" name="other" title="Crear Otros Equipos" value="wire" /></td>
                                                        </tr>                                                        
                                                    </table>
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
