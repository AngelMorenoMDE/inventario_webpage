<?php

    require_once "ini.php";
    
    check_session();
    check_rol_privileges();
    $_SESSION["actual_page"] = "list_user.php";
        
    $msg = null;
    
    

   
    if(array_key_exists("delete", $_POST))
    {
        $idUser = $_POST["delete"];
        $_SESSION["idUser"] = $idUser;
        redirect("confirm_action.php");
       
    }
    
  
    if(array_key_exists("edit", $_POST))
    {
        $idUser= $_POST ["edit"];
        $_SESSION["idUser"] = $idUser;
       
        redirect ("edit_user.php");
      
    }
    
    $resultSearchHTML = "";
    $conexion = new_conex_db();

        $selectUser =  mysql_query("select id_user, name, surname, email, id_rol from $tableUser",$conexion);
        if (mysql_num_rows($selectUser)>0)
        {
            // Imprimir los resultados en HTML
            $resultSearchHTML .= "<table class=\"border\">";
            $resultSearchHTML .= "<caption>LISTADO DE USUARIOS</caption>";
            $resultSearchHTML .= "<th class=\"border\">Nombre</th><th class=\"border\">Apellidos</th><th class=\"border\">E-mail</th>";
            $resultSearchHTML .= "<th class=\"border\">Rol</th><th class=\"border\">Modificar</th><th class=\"border\">Borrar</th>";
            while ($line = mysql_fetch_assoc($selectUser))
            {
                $resultSearchHTML .= "<tr class=\"border\">";
                $c = 0;
                foreach ($line as $valor) 
                {
                    if ($c==0)
                    {
                        $idUser = $valor;        

                    }
                    
                    if ($c == 4)
                    {
                        $sel = "select * from $tableRoleUser where id_rol = $valor ;";
                        $rowRol = select_one($sel);
                        $nameRol = $rowRol["name"];
                        $resultSearchHTML .= "<td class=\"border\">$nameRol</td>";
                    }
                    if (($c != 0) && ($c != 4))
                     {
                         $resultSearchHTML .= "<td class=\"border\">$valor</td>\n";
                     }
                    

                 $c++;     
                }
                $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"edit\" name=\"edit\" value=\" $idUser\"></td>";
                $resultSearchHTML .= "<td class=\"border\"><input type=\"submit\" class=\"delete\" name=\"delete\" value=\" $idUser\"></td>";
                $resultSearchHTML .= "</tr>";  
            }
            $resultSearchHTML .= "</table>\n";
            
     }
    else
    {
        $resultSearchHTML .= "<table><tr><td>No se ha encontrado ningún usuario registrado</td></tr></table>";
    }

        mysql_close($conexion);

        if ($msg)
        {
            alert_js($msg);
        }


?>


<!DOCTYPE html>

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


