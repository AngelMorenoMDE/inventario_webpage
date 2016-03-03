<?php

    header('Content-Type: text/html; charset=UTF-8');
    require_once 'ini.php';
    check_session();
    $_SESSION["actual_page"] = "new_project_doc.php";
    
    //para depurar alguna parte del código...en el ini estan 
    //declaradas las constantes
    if (debugOff)
    {
        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";
    }
    //
    
    $errores = "";
    $extension = "";
    
    if(array_key_exists("idProject", $_SESSION)) 
    {
    
        $idProject = $_SESSION["idProject"];
        
        if(array_key_exists("save", $_POST))
        {     

                        
            $dateUpload = time();
            $userUopload = getUserInSession();

            $document_name = "";
            $document_ok = false;  //baliza para comprobar que le proceso se hace correcto
            if (is_empty($_FILES["document"]["name"]))
            {
                $document_name = "No hay documento";
                $document_ok = true;

            }

            else
            {
                $document_name = $_FILES["document"]["name"];
                $nombreDes = $document_name;
                $tamano = $_FILES["document"]["size"]; 
                $type = $_FILES["document"]["type"];

                if (check_extension_doc($document_name)) //comprobamos extensión correcta
                {
                      //cambiamos nombre de archivo por tiempo en microsegundos
                    $document_name = file_microseconds($document_name);
                    $document_ok = true;
                    $extension = sacarExtension($document_name);
                } 
                else    // En caso de fallo
                {
                    $errores .= "-Extensión incorrecta<br>";
                }
            }

            $insertDocument = "insert into $tableProjectDoc (id_project, name, name_description,";
            $insertDocument .= " mimetype, size, extension, date_upload, user_upload) ";
            $insertDocument .= "values ("  . $idProject . ",". comillas($document_name) . "," 
                                        . comillas($nombreDes). "," 
                                        . comillas($type) . ","
                                        . $tamano . ","   
                                        . comillas($extension) . ","
                                        . $dateUpload . ","
                                        . $userUopload . ");"; 

            $insertDocument_ok = false;

            if ($errores == "")
            {   
                if ($document_ok)     //si comprobación correcta:
                {
                    saveDocumentInServer("document", $document_name);
                }
                if (execute_query($insertDocument))
                    {
                        $insertDocument_ok = true;
                        redirect("detail_project.php");
                    }
                    else
                    {
                        die("Error de inserción");
                    }

            }
            else
            {
                $errores = "Se han producido los siguientes errores: <br>" .$errores;
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
                                            <legend><B>SUBIDA DE DOCUMENTOS DEL PROYECTO</B></legend>

                                        <form action="" method="post" enctype="multipart/form-data">
                                           <table>
                                               
                                               <tr>
                                                   <td>Documento:</td>
                                                   <td><input type="file" name="document" size="50" /> </td>
                                                    
                                               </tr>
                                               
                                                   <td></td><td></td> 
                                                   
                                                <tr>
                                                   <td><input type="submit" class="normalButton" name="save" value="Guardar documento"/> </td>
                                                   
                                                </tr>

                                           </table>
                                        </form>

                                        </fieldset>   

                                            
                                            
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


