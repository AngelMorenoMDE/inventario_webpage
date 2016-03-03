<?php

    require_once "ini.php";
    check_session();
    check_rol_privileges();
    $errores= "";
    $maxCar = 50;
    $_SESSION["actual_page"] = "edit_user.php";  
    $passwordUser1 = "";
    $passwordUser2 = "";
    
    if(array_key_exists("cancel", $_POST))
    {
    redirect("list_user.php");
    } 
    
    if(session("idUser")) //conservamos id_user de boton modificar en  lis_user
    {

        $idUser = session("idUser");//guardamos id_user en una variable

        $conexion =  new_conex_db();


        $sel="select * from $tableUser where id_user=" . $idUser . ";"  ; 

        $result=mysql_query($sel,$conexion);     //select para mostrar los datos
        if ($result)                           
        {
            $datosusuario= mysql_fetch_assoc($result);

            $nameusu = $datosusuario['name'];
            $surnameusu = $datosusuario['surname'];
            $emailusu = $datosusuario['email'];
            //$passwordUser1 = $datosusuario['password'];
            $idrolusu = $datosusuario['id_rol'];

        }
        mysql_close($conexion);
    } 
    else
    {
        redirect("list_user.php");
    }

    if(post("saveUser"))//recogemos los datos nuevos
    {   
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
            $rolUser = $_POST["rol"];
            $passwordUser1 = $_POST["pass1"];
            

            if (!is_empty($passwordUser1))
            {
                $passwordUser1 = $_POST["pass2"];
                trim($passwordUser1);
                trim($passwordUser2);

                if (strlen($passwordUser1)<6 || strlen($passwordUser1)>12) 
                {
                    $errores.= "El campo password debe contener entre 6 y 12 caracteres</br>";  
                }

                if ($passwordUser1 != $passwordUser2)
                {
                    $errores .= "La confirmación de la password no es correcta, inténtelo de nuevo";
                }
            }
            
            if ($errores == "")
            {   
                $edit = "update $tableUser set name = " . comillas($nameUser);
                $edit .= " , surname =" .comillas($surnameUser);
                $edit .= " , email =" .comillas($emailUser);

                if ($passwordUser1 != "")
                {
                    $edit .= " , password =" .comillas(md5($passwordUser1));
                }

                $edit .= " , id_rol =" .comillas($rolUser);
                $edit .= " where id_user = $idUser;";
                
                if (execute_query($edit))//comprobamos que la query se hizo correcta
                {
                    alert_js("Datos guardados con éxito.");
                    redirect("list_user.php");
                }
            }
            else 
            {
                $errores = "Se han producido los siguientes errores: <br>".$errores;     
            }
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
                                            <legend><B>EDITOR DE USUARIO</B></legend>
                                       <form action="" method="post">
                                           <table>
                                               <tr>
                                                   <td>Nombre de usuario:</td>
                                                   <td><input type="text" name="nombre" size="30" value="<?php echo $nameusu ?>"/></td>
                                                   <td><?php echo isFieldRequired("edit_user.php", "nombre"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Apellido de usuario: </td>
                                                   <td><input type="text" name="apel" size="30" value="<?php echo $surnameusu ?> "/></td>
                                                   <td><?php echo isFieldRequired("edit_user.php", "apel"); ?></td>
                                               <tr>
                                                   <td>E-mail: </td>
                                                   <td><input type="text" name="mail" size="30" value="<?php echo $emailusu ?>"/></td>
                                                   <td><?php echo isFieldRequired("edit_user.php", "mail"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Introduzca Password:</td> 
                                                   <td><input type="password" name="pass1" size="30"/></td>
                                                   <td><//?php echo isFieldRequired("edit_user.php", "pass"); ?></td>
                                               </tr>
                                                <tr>
                                                   <td>Confirmar Password:</td> 
                                                   <td><input type="password" name="pass2" size="30"/></td>
                                                   <td><//?php echo isFieldRequired("edit_user.php", "pass"); ?></td>
                                               </tr>
                                                   
                                                   
                                                   <td>Privilegios: </td>

                                                   <td>  <?php echo generateSelectWithOptions("rol", "role_user", 
                                                           "id_rol", "name", $idrolusu); ?> </td>
                                                   <td><?php echo isFieldRequired("edit_user.php", "rol"); ?></td>
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


