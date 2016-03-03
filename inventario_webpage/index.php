<?php
 
    require_once "ini.php";
    
    $errorlogin="Fallo en el inicio de sesión";     //definimos mensajes de error
    $errorconex="Fallo de conexión";                //definimos mensajes de error
                                     //definimos tabla 
    $errores="";
   
    $emailUser = "";
    $passwordUser = "";
    
    $_SESSION["actual_page"] = "index.php";
    
    if(array_key_exists("saveLogin", $_POST))   //comprobamos que se pulsa botón
    {
        
        if (!array_key_exists("email", $_POST))
        {
            $errores .= "No hay datos para comprobar</br>";
        }
        else 
        {   
            $emailUser = $_POST["email"];
            trim($emailUser);
            
            if (is_empty($emailUser))
            {
                 $errores .= "El campo email no puede estar vacio</br>";
            }
            
            else 
            {
                if(!filter_var($emailUser, FILTER_VALIDATE_EMAIL))
                {
                    $errores .= "El campo email no es valido</br>";
                }
            }
        }
        
        if (!array_key_exists("pass", $_POST))
        {
            $errores .= "No hay datos para comprobar</br>";
        }
        else 
        {   
            $passwordUser = $_POST["pass"];
            trim($passwordUser);
            
            if (is_empty($passwordUser))
            {
                 $errores .= "El campo password no puede estar vacio</br>";
            }
            
            else 
            {
                if (strlen($passwordUser)<6 || strlen($passwordUser)>18) 
                {
                    $errores.= "El campo password debe contener entre 6 y 12 caracteres</br>";  
                }
                else
                {
                    $passwordCod = md5($passwordUser);
                }
            }
        }
        
        
        if ($errores == "")
        {
            $conexion=new_conex_db();               //conectamos con base de datos

            $selectUser="select * from $tableUser where email= "     //select por id de usuario
               . comillas($emailUser). "and password=" .comillas($passwordCod).";";

            $resultSelectUser=mysql_query($selectUser,$conexion);    //recogemos resultado para contarlo

            if (!$resultSelectUser)                           //comprobamos que base de datos sigue conectada
            {
               error_js($errorconex);               //si desconectada mensaje de error
               die();
            }

            if (mysql_num_rows($resultSelectUser)>0)          //comprobamos que hay resultados
            {
                $selectRow = mysql_fetch_assoc($resultSelectUser);

                $_SESSION[USER_SESSION()] = $selectRow["id_user"]; //recogemos en sesion los valores
                $_SESSION[ROL_SESSION()] = $selectRow["id_rol"];   //del id_usuario e id_sesion

                redirect("main.php"); 
            }
            else 
            {
                error_js($errorlogin);              //si no hay resultados mensaje de error
            }
        }
        else // HAY ERRORES
        {
            $errores .= "Se han producido los siguientes errores: <br>".$errores;
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
                                    <div class="post">BIENVENIDO AL INVENTARIO DE EQUIPOS ELECTRONICOS</div>
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
