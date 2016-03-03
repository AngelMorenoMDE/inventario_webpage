<?php

    function getUserInSession()
    {
        return $_SESSION[USER_SESSION()];
    }

    function getUserRolInSession()
    {
        return $_SESSION[ROL_SESSION()];
    }

    function is_admin($rol)
    {
        return $rol == 1;
    }

    function USER_SESSION()
    {
        return "user_session";
    }

    function ROL_SESSION()
    {
        return "rol_session";
    }

    function comillas($var)
    {
        return "'$var'";
    }

    function redirect($page)
    {
        header("Location: ./$page");
    }

    function alert_js($msg)
    {    
        echo "<script>alert(\"$msg\");</script>"; 
    }
    
    function check_session()
    {
        if (!array_key_exists(USER_SESSION(), $_SESSION))
        {
            redirect("index.php");
        }
    }
    
    function check_rol_privileges()
    {
        if (!is_admin(getUserRolInSession()))
        {
            redirect("search.php");
        }
    }
            
    //si existe la clave $key en post me devuelve el valor asociado a key, 
    //si no devuelve falso
    function post($key)  
    {
        if (array_key_exists($key, $_POST))
        {
            return $_POST[$key];
        }
        else
        {
            return false;
        }
    }
    
    //si existe la clave $key en session me devuelve el valor asociado a key, 
    //si no devuelve falso
    function session($key)
    {
        if (array_key_exists($key, $_SESSION))
        {
            return $_SESSION[$key];
        }
        else
        {
            return false;
        }
    }
    
    function sacarExtension($archivo_nombre)
    {
        $filename_parts = "";
        $extension = "";
        //separamos el nombre del archivo por el punto
        $filename_parts =explode (".", $archivo_nombre);
        //cogemos lo que nos ha qedado a la derecha del punto
        $extension = $filename_parts[1];
        
        return $extension;
    }
    
    function nombreTime($archivo_nombre)
    {
        //duerme un micrisegundo
        usleep(1);
        //separamos lo q da el microtime por el punto
        $by_coma = explode(".", microtime());
        //separamos la parte que nos a qedado antes en la derecha por el espacio
        $by_space = explode(" ", $by_coma[1]);
        //de lo q hemos separado antes cogemos lo q hay a la izquierda
        $time = $by_space[0];
        //llamamos a la funcion paa q nos de la extension del archivo
        $extension = sacarExtension($archivo_nombre);
        //concatenamos el tiempo q nos qedó de separar y la extension
        $archivo_nombre = $time. "." . $extension;
        
        return $archivo_nombre;
    }
    
    function check_extension($archivo_nombre)
    {
        
        //aqui podemos añadir las extensiones que deseemos permitir
        $extensiones_val = getImageExtensions();
        //llamamos a la función para q nos de la extensión
        $extension = sacarExtension($archivo_nombre);
        //si la extensión q nos a dado está en el array...
        if(in_array(strtolower($extension), $extensiones_val))
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    //funcion para validar extensiones de documentos
    function check_extension_doc($archivo_nombre)
    {
        
        //aqui podemos añadir las extensiones que deseemos permitir
        $extensiones_val = getDocumentExtensions();
        //llamamos a la función para q nos de la extensión
        $extension = sacarExtension($archivo_nombre);
        //si la extensión q nos a dado está en el array...
        if(in_array(strtolower($extension), $extensiones_val))
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    function check_extension_driver($archivo_nombre)
    {
        
        //aqui podemos añadir las extensiones que deseemos permitir
        $extensiones_val = getDriverExtensions();
        //llamamos a la función para q nos de la extensión
        $extension = sacarExtension($archivo_nombre);
        //si la extensión q nos a dado está en el array...
        if(in_array(strtolower($extension), $extensiones_val))
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    //cambia nombre de archivo a hora actual en microsegundos
    function file_microseconds($file)
    {
        usleep(1);
        $by_coma = explode(".", microtime());
        $by_space = explode(" ", $by_coma[1]);
        $time = $by_space[0];
        $filename_parts =explode (".", $file); 
        $extension = $filename_parts[count($filename_parts)-1];
        $file=  $time. "." . $extension;
        
        return $file;
    }
    
    //funcion para guardar imágenes en el servidor
    //pasamos por parámetros el nombre dado en el html y el nombre con el que
    //lo vamos a guardar en el servidor
    function saveImageInServer ($nameInputHTML, $newImageNameInServer)
    {
        $imageTempPathInServer = $_FILES[$nameInputHTML]["tmp_name"];        
        $newImagePathInServer = getImagePath().$newImageNameInServer;
        move_uploaded_file($imageTempPathInServer, $newImagePathInServer);
    }
    
    //funcion para guardar archivos en el servidor
    //pasamos por parámetros el nombre dado en el html y el nombre con el que
    //lo vamos a guardar en el servidor
    function saveDocumentInServer ($nameInputHTML, $newDocumentNameInServer)
    {
        
        $documentTempPathInServer = $_FILES[$nameInputHTML]["tmp_name"];        
        $newDocumentPathInServer = getDocumentPath().$newDocumentNameInServer;
        move_uploaded_file($documentTempPathInServer, $newDocumentPathInServer);
    }
    
    function saveDriverInServer ($nameInputHTML, $newDriverNameInServer)
    {
        
        $driverTempPathInServer = $_FILES[$nameInputHTML]["tmp_name"];        
        $newDriverPathInServer = getDriverPath().$newDriverNameInServer;
        move_uploaded_file($driverTempPathInServer, $newDriverPathInServer);
    }
 
   //funcion para mostrar sólo el nombre del campo email
    function getUserName ($email)
    {
        $name_parts = explode("@" , $email);
        $name = $name_parts[0];
        
        return $name;
    }
    
    function generateOptionsSideBar($options)
    {
        $str = "";
        foreach ($options as $option) 
        {
            $str .= "<li><a href=\"".$option["linkURL"]."\">".$option["optionName"]."</a></li>";
        }
        return $str;
    }
    
    //funcion para validar las fechas
       function datecheck($input,$format="")
    {
        $separator_type= array(
            "/",
            "-",
            "."
        );
        foreach ($separator_type as $separator) {
            $find= stripos($input,$separator);
            if($find<>false){
                $separator_used= $separator;
            }
        }
        $input_array= explode($separator_used,$input);
        if ($format=="mdy") {
            return checkdate($input_array[0],$input_array[1],$input_array[2]);
        } elseif ($format=="ymd") {
            return checkdate($input_array[1],$input_array[2],$input_array[0]);
        } else {
            return checkdate($input_array[1],$input_array[0],$input_array[2]);
        }
        $input_array=array();
    }
    
   function sacaId($idOfficeConjunto)
    {
      
        $by_raya = explode("-", $idOfficeConjunto);
        
        $idOffice = $by_raya[2];
                
        return $idOffice;
    }

    
?>