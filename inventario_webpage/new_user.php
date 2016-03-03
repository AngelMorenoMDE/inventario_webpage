<?php

    header('Content-Type: text/html; charset=UTF-8');
    
    require_once "ini.php";
    check_session();
    check_rol_privileges();
    $_SESSION["actual_page"] = "new_user.php";
    $errores = "";
    $maxCar = 50;
    
    $nameUser = "";
    $surnameUser = "";
    $emailUser = "";
    $passwordUser1 = "";
    $passwordUser2 = "";
    
    if(array_key_exists("cancel", $_POST))
    {
    redirect("list_user.php");
    }
    
    if(array_key_exists("saveUser", $_POST))
    {
        
        if (!array_key_exists("nombre", $_POST))
        {
            $errores .= "No hay datos que guardar</br>";
        }
        else 
        {   
            $nameUser = $_POST["nombre"];
            trim($nameUser);
            
            if (is_empty($nameUser))
            {
                $errores .= "El campo nombre no puede estar vacio</br>";
            }
            
            else 
            {
                if (validar_cadena($nameUser,$maxCar)==2)
                {
                    $errores .= "el campo nombre no puede ser numerico</br>";
                } 
                else 
                {
                    if (validar_cadena($nameUser,$maxCar)==3)
                    {
                    $errores .= "el campo nombre no puede tener mas "
                                . "de " . $maxCar . " caracteres</br>";
                    }
                }
            }
        }
      
        $surnameUser = $_POST["apel"];
        trim($surnameUser);
        if (strlen($surnameUser)>$maxCar)
        {
            $errores.= "- El campo apellidos no puede ser contener mas de 50 caracteres</br>";
        }
                
        if (!array_key_exists("mail", $_POST))
        {
            $errores .= "No hay datos que guardar</br>";
        }
        else 
        {   
            $emailUser = $_POST["mail"];
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
                        
        if (!array_key_exists("pass1", $_POST)&& (!array_key_exists("pass2", $_POST)))
        {
            $errores .= "No hay datos que guardar</br>";
        }
        else 
        {   
            $passwordUser1 = $_POST["pass1"];
            $passwordUser2 = $_POST["pass2"];
            trim($passwordUser1);
            trim($passwordUser2);
                        
            if (is_empty($passwordUser1))
            {
                 $errores .= "El campo password no puede estar vacio</br>";
            }
            
            else 
            {
                if (strlen($passwordUser1)<6 || strlen($passwordUser1)>12) 
                {
                    $errores.= "El campo password debe contener entre 6 y 12 caracteres</br>";  
                }
                else
                {
                    $passwordCod1 = $passwordUser1;
                    $passwordCod2 = $passwordUser2;
                    if ($passwordCod1 != $passwordCod2)
                    {
                        $errores .= "La confirmación de la password no es correcta, inténtelo de nuevo";
                    }
                    else 
                    {
                        $passwordCod = md5($passwordCod1);
                    }
                }
            }
        }
        
        $rolUser = $_POST["rol"];
               
 
        $insertUser = "insert into $tableUser ";
        $insertUser .= "(name, surname, email, password, id_rol) ";
        $insertUser .= "values (" . comillas($nameUser) . ","   // nombre
                                    . comillas($surnameUser) . ","  // apellido
                                    . comillas($emailUser) . ","  // email
                                    . comillas($passwordCod) . ","   // password
                                    . $rolUser . ");";         // id_rol

        if ($errores == "")
        {   

            if (execute_query($insertUser))
            {
                alert_js("Datos guardados con éxito.");
                redirect("list_user.php");

            }
        }
        else
        {
            $errores= "Se han producido los siguientes errores: <br>" .$errores;
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


<div id="wrapper">
	<!-- end #header -->
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
                            
				<div id="content">
                                    

                                    <div class="post">
                                        <?php echo $errores; ?> 

                                    <fieldset>
                                        <legend><B>REGISTRO DE USUARIO</B></legend>
                                   <form action="" method="post">
                                       <table>
                                           <tr>

                                               <td>Introduzca nombre de usuario:</td>
                                               <td><input type="text" size="30" name="nombre" value="<?php echo $nameUser;?>"/> </td>
                                               <td><?php echo isFieldRequired("new_user.php", "nombre"); ?></td>

                                           </tr>
                                           <tr>
                                               <td>Introduzca apellido de usuario:</td>
                                               <td><input type="text" size="30" name="apel" value="<?php echo $surnameUser;?>"/></td>
                                               <td><?php echo isFieldRequired("new_user.php", "apel"); ?></td>
                                           </tr>
                                           <tr>
                                               <td>Introduzca e-mail:</td>
                                               <td><input type="text" size="30" name="mail" value="<?php echo $emailUser;?>"/></td>
                                               <td><?php echo isFieldRequired("new_user.php", "mail"); ?></td>
                                           <tr>
                                               <td>Introduzca password:</td> 
                                               <td><input type="password" size="30" name="pass1" value="<?php echo $passwordUser1;?>"></td>
                                               <td><?php echo isFieldRequired("new_user.php", "pass"); ?></td>
                                           </tr>
                                           <tr>
                                               <td>Confirmar Password:</td> 
                                               <td><input type="password" size="30" name="pass2" value="<?php echo $passwordUser2;?>"></td>
                                               <td><?php echo isFieldRequired("new_user.php", "pass"); ?></td>
                                           </tr>
                                           <tr>
                                               <td>Seleccione privilegios: </td>

                                               <td> <?php echo generateSelectWithOptions("rol", "role_user", "id_rol", "name"); ?></td>
                                               <td><?php echo isFieldRequired("new_user.php", "rol"); ?></td>

                                               <td></td><td></td> 
                                               <td></td><td></td>

                                               <td><input type="submit" class="normalButton" name="saveUser" value="Guardar datos"/> </td>
                                               <td></td><td></td><td></td>
                                               <td><input type="submit" class="normalButton" name="cancel" value="Cancelar"/> </td>
                                           </tr>

                                       </table>
                                       </fieldset>   

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