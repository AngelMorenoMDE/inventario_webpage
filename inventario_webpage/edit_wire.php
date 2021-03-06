<?php
    require_once "ini.php";
    check_session();
    $errores= "";
    $maxCar = 50; 
    $pathImage= getImagePath();
    $_SESSION["actual_page"] = "edit_wire.php";
    //$description = "";
    
    if(array_key_exists("cancel", $_POST))
    {
    redirect("search_wire.php");
    }
    if(array_key_exists("idElectronic", $_SESSION)) 
    {
        $idElectronic = $_SESSION["idElectronic"];//guardamos id_user en una variable

        $selectEq = "select * from $tableElectEq where id_electronic_eq =" . $idElectronic . ";" ;
        $selectWire = "select * from $tableWire where id_electronic_eq=" . $idElectronic . ";"  ;  

        $rowElectronic= select_one($selectEq);   
        $rowWire= select_one($selectWire);

        $codeUrjc = $rowElectronic['urjc_code'];
        $serialNumber = $rowElectronic['serial_number'];
                
        $idOffice = $rowElectronic['id_office'];
        $idConjunto = generateIdConjunto($idOffice);
        
        $image1_name = $rowElectronic['image_1'];
        $pathImage1 = $pathImage . $image1_name;
        $image2_name = $rowElectronic['image_2'];
        $pathImage2 = $pathImage . $image2_name;
        
        $status = $rowElectronic['status'];
        $idUserAsigned = $rowElectronic['id_user_asigned'];
        $idUserModify = $rowElectronic['id_user_modify'];
        $dateModify = $rowElectronic['date_modify'];
        $description = $rowElectronic['description'];

        $meters = $rowWire['meters'];
        $conector1 = $rowWire['conector_type_a'];
        $conector2 = $rowWire['conector_type_b'];
        $wireType = $rowWire['wire_type'];

    } 
    else
    {
        redirect("list_wire.php");
    }

    if(array_key_exists("saveWire", $_POST))
    {
        //recogemos datos de equipo electrónico
        if (!array_key_exists("urjc_code", $_POST))
        {
            $errores .= "No hay datos que guardar<br>";
        }
        else 
        {
            $codeUrjc = $_POST["urjc_code"];
            trim($codeUrjc);

            if (is_empty($codeUrjc))
            {
                $errores .= "El campo codigo URJC no puede estar vacio<br>";
            }
            else
            {
                if (!validate_integer($codeUrjc))
                {
                    $errores .= "el campo codigo URJC debe contener un numero entero<br>";
                }
            }
        }
                
        if (!array_key_exists("serial_number", $_POST))
        {
            $errores .= "No hay datos que guardar";
        }
        else 
        {   
            $serialNumber = $_POST["serial_number"];
            trim($serialNumber);

            if (is_empty($serialNumber))
            {
                $errores .= "El campo numero de serie no puede estar vacio<br>";
            }
            else 
            {
                if (validar_cadena($serialNumber,$maxCar)==3)
                {
                    $errores .= "el campo numero de serie no puede tener mas "
                                . "de " . $maxCar . " caracteres<br>";
                }
            }
        }
        $idOfficeConjunto = $_POST["id_office"];
        $idOffice = sacaId($idOfficeConjunto);

        $image1_ok = false;  //baliza para comprobar que el proceso se hace correcto
        if (is_empty($_FILES["image_1"]["name"]))
        {
            $image1_ok = true;
        }
        else
        {
            $image1_name = $_FILES["image_1"]["name"];

            if (check_extension($image1_name)) //comprobamos extensión correcta
            {
                //cambiamos nombre de archivo por tiempo en microsegundos
                $image1_name = file_microseconds($image1_name);
                $image1_ok = true;
            } 
            else    // En caso de fallo
            {
                $errores .= "- Fichero 1 Extensión incorrecta<br>";
            }
        }   

        $image2_ok = false;  //baliza para comprobar que le proceso se hace correcto
        if (is_empty($_FILES["image_2"]["name"]))
        {
            $image2_ok = true;
        }
        else
        {
            $image2_name = $_FILES["image_2"]["name"];

            if (check_extension($image2_name)) //comprobamos extensión correcta
            {
                 //cambiamos nombre de archivo por tiempo en microsegundos
                $image2_name = file_microseconds($image2_name);
                $image2_ok = true;
            } 
            else    // En caso de fallo
            {
                $errores .= "- Fichero 2 Extensión incorrecta<br>";
            }
        }
                        
      
        
        //se modificará fecha y usuario si el estado es descatalogado
        $status = $_POST["status"];
        if ($status != 3)
        {
            $idUserDelete = -1;
            $dateDelete = -1;
        }
        if ($status == 3)
        {
            $idUserDelete = getUserInSession();
            $dateDelete = time();
        }
        $idUserAsigned = $_POST["id_user_asigned"];
        $idUserModify = getUserInSession();
        $dateModify = time();
        $description = $_POST["description"];


        //inicializamos los valores numéricos porque si luego los 
        //dejamos vacios nos da error porque el vacio lo coge como cadena
        $meters = -1;
        //si el post no está vacio machaca la variable con ese valor
        if (!is_empty($_POST["meters"]))
        {    
            $meters = $_POST["meters"];
        }

        $conector1 = $_POST["conector1"];
        $conector2 = $_POST["conector2"];
        $wireType = $_POST["wireType"];             

        //trim($conector1);
        //trim($conector2);

        if (!is_numeric($meters))
        {
            $errores.= "- El campo \"metros\" tiene que ser numérico</br>";
        }

        

        $editEq = "update $tableElectEq set urjc_code = " . $codeUrjc .
                    ", serial_number =" . comillas($serialNumber) .
                    ", id_office =" .$idOffice .
                    ", image_1 = " . comillas($image1_name) . 
                    ", image_2 = " . comillas($image2_name) .
                    ", status =" . $status . 
                    ", id_user_asigned =" . $idUserAsigned . 
                    ", id_user_modify =" . $idUserModify . 
                    ", id_user_delete =" . $idUserDelete . 
                    ", date_modify = " . $dateModify .
                    ", date_delete = " . $dateDelete .
                    ", description = " . comillas($description).
                    " where id_electronic_eq =" . $idElectronic. ";";

        $editWire= "update $tableWire set  meters =" . $meters .
                    ", conector_type_a =" . comillas($conector1) .
                    ", conector_type_b =" . comillas($conector2) .
                    ", wire_type =" . $wireType .
                    " where id_electronic_eq =" . $idElectronic. ";";      

        if ($errores == "")
        {   

            if ($image1_ok)     //si comprobación correcta:
            {
                saveImageInServer("image_1", $image1_name);
            }
            if ($image2_ok)
            {
                saveImageInServer("image_2", $image2_name);
            } 
            if ((execute_query($editEq)) && (execute_query($editWire)))//comprobamos que la query se hizo correcta
            {
                alert_js("Datos guardados con éxito.");
                redirect("search_wire.php");
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
                                         <legend><b>EDITOR DE CABLES</b></legend>
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <table>
                                            <tr>
                                                <td>Código URJC:</td>
                                                <td><input type="text" size="50" name="urjc_code" value="<?php echo $codeUrjc;?>"/> </td>
                                                <td><?php echo isFieldRequired("edit_wire.php", "urjc_code"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Número de Serie:</td>
                                                <td><input type="text" size="50" name="serial_number" value="<?php echo $serialNumber;?>"/> </td>
                                                <td><?php echo isFieldRequired("edit_wire.php", "serial_number"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Despacho:</td>
                                                <td><?php echo generateSelectOffice($idConjunto); ?> </td>
                                                <td><?php echo isFieldRequired("new_wire.php", "id_office"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Imagen 1:</td>
                                                <td><input name="image_1" type="file" size="50" /> </td>
                                                <td><a href="<?php echo $pathImage1 ;?>" target="_blank">Ver Imagen</a></td>
                                                <td><?php echo isFieldRequired("edit_wire.php", "image_1"); ?></td>
                                            </tr>

                                            <tr>
                                                <td>Imagen 2:</td>
                                                <td><input name="image_2" type="file" size="50" /> </td>
                                                <td><a href="<?php echo $pathImage2 ;?>" target="_blank">Ver Imagen</a></td>
                                                <td><?php echo isFieldRequired("edit_wire.php", "image_2"); ?></td>

                                            </tr>
                                            <tr>
                                                <td>Estado:</td>
                                                <td><?php echo generateSelectWithOptions("status", "status",
                                                        "id_status", "name_status", $status); ?> </td>
                                                <td><?php echo isFieldRequired("edit_wire.php", "status"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Asignado a usuario:</td>
                                                <td><?php echo generateSelectWithOptions("id_user_asigned", "user",
                                                        "id_user", "email", $idUserAsigned); ?> </td>
                                                <td><?php echo isFieldRequired("edit_wire.php", "id_user_asigned"); ?></td>
                                            </tr>

                                            <tr>
                                                <td>Metros:</td>
                                                <td><input type="text" size="50" name="meters" value="<?php echo $meters ?>"/></td>
                                                <td><?php echo isFieldRequired("edit_wire.php", "meters"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Conector 1:</td>
                                                <td><?php echo generateSelectWithOptions("conector1", "wire_type", 
                                                           "id_wire_type", "name_wire_type", $conector1); ?></td>
                                                <td><?php echo isFieldRequired("edit_wire.php", "conector1"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Conector 2:</td>
                                                <td><?php echo generateSelectWithOptions("conector2", "wire_type", 
                                                           "id_wire_type", "name_wire_type", $conector2); ?></td>
                                                <td><?php echo isFieldRequired("edit_wire.php", "conector2"); ?></td>

                                            </tr>
                                            <tr>
                                                <td>Tipo de cable: </td>

                                                <td> <?php echo generateSelectWithOptions("wireType", "wire_type", 
                                                        "id_wire_type", "name_wire_type", $wireType); ?></td>
                                                <td><?php echo isFieldRequired("edit_wire.php", "wireType"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Comentarios:</td>
                                                <td><textarea  name="description"><?php echo $description ?></textarea></td>
                                             
                                                <td></td><td></td> 
                                                <td></td><td></td>

                                                <td><input type="submit" class="normalButton" name="saveWire" value="Guardar datos"/> </td>

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


