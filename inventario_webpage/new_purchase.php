<?php

header('Content-Type: text/html; charset=UTF-8');
    
    require_once "ini.php";
    check_session();
    $_SESSION["actual_page"] = "new_purchase.php";
    $errores = "";
    $maxCar = 50;
    
   
    $price = "";
    $name_purchase = "";
    $date_purchase = "";
    $purchaser = "";
    
if(array_key_exists("cancel", $_POST))
    {
    redirect("new_eq.php");
    }
    
if(array_key_exists("savePurchase", $_POST))
    {
        if (!array_key_exists("name", $_POST))
        {
            $errores .= "No hay datos que guardar<br>";
        }
        else 
        {
            $name_purchase = $_POST["name"];
            trim($name_purchase);
            
            if (is_empty($name_purchase))
            {
                $errores .= "El campo \"Descripción\" no puede estar vacio<br>";
            }
            
        }
        
        if (!array_key_exists("price", $_POST))
        {
            $errores .= "No hay datos que guardar<br>";
        }
        else 
        {   
            $price = $_POST["price"];
            trim($price);
            
            if (is_empty($price))
            {
                $errores .= "El campo \"Precio\" no puede estar vacio<br>";
            }
            
            /*else 
            {
                if (!validate_integer($price))
                {
                    $errores .= "el campo codigo \"Precio\" debe contener un numero entero<br>";
                }
            }*/
        }
                    
        $project = $_POST["project"];
       
        
        $date_purchase = $_POST["date"];
        
        if(datecheck($date_purchase)==false)
        {
        $errores .= "La fecha no es correcta";
        }
        else
        {
        $date_purchase = strtotime($date_purchase);
        }
    
                                       
        if (!array_key_exists("purchaser", $_POST))
        {
            $errores .= "No hay datos que guardar<br>";
        }
        else 
        {   
            $purchaser = $_POST["purchaser"];
            trim($purchaser);
            
            if (is_empty($purchaser))
            {
                $errores .= "El campo \"Comprador\"  no puede estar vacio<br>";
            }
            
            else 
            {
                                               
                if (validar_cadena($purchaser,$maxCar)==3)
                {
                    $errores .= "el campo \"Comprador\"  no puede tener mas "
                                . "de " . $maxCar . " caracteres<br>";
                }
            }
        }
                                                    
        
        $insertPurchase = "insert into purchase (id_project, price, name_purchase, date_purchase, purchaser)";
        $insertPurchase .= "values (" . $project . ", " . $price . ", " . comillas($name_purchase) . "," ;
        $insertPurchase .=  $date_purchase . "," . comillas($purchaser). ");"  ;  
   
        if ($errores == "")
        {   
            if (execute_query($insertPurchase))
            {
                echo "Datos guardados";
                redirect("list_purchase.php");
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
                                            <legend><B>REGISTRO DE COMPRA</B></legend>
                                       <form action="" method="post" enctype="multipart/form-data">
                                            <table>
                                               <tr>
                                                   <td>Descripción:</td>
                                                   <td><input type="text" size="50" name="name" value="<?php echo $name_purchase;?>"/> </td>
                                                   <td><?php echo isFieldRequired("new_purchase.php", "name"); ?></td>
                                               </tr>
                                                <tr>
                                                   <td>Proyecto:</td>
                                                   <td><?php echo generateSelectWithOptions("project", "project",
                                                           "id_project", "name_project"); ?> </td>
                                                   <td><?php echo isFieldRequired("new_purchase.php", "project"); ?></td>
                                               </tr>
                                                <tr>
                                                   <td>Precio:</td>
                                                   <td><input type="text" size="50" name="price" value="<?php echo $price;?>"/>€</td>
                                                   <td><?php echo isFieldRequired("new_purchase.php", "price"); ?></td>
                                               </tr>
                                               <tr>
                                                   <td>Fecha (dd/mm/yyyy):</td>
                                                   <td><input type="text" size="30" name="date" value="<?php echo $date_purchase;?>"/></td>
                                                   <td><?php echo isFieldRequired("new_purchase.php", "date"); ?></td>
                                                   
                                               <tr>
                                                   <td>Comprador:</td>
                                                   <td><input type="text" size="50" name="purchaser" value="<?php echo $purchaser;?>"/></td>
                                                   <td><?php echo isFieldRequired("new_purchase.php", "purchaser"); ?></td>
                                               </tr>
                                                
                                                   <td></td><td></td> 
                                                   <td></td><td></td>

                                                   <td><input type="submit" class="normalButton" name="savePurchase" value="Guardar datos"/> </td>
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
                
