<?php

//configuración en el servidor
    function DEBUG()
    {
        return true;
    }

    function DBHOST()
    {
        return "localhost";
    }

    function DBUSER()
    {
        return "";
    }

    function DBPASSWORD()
    {
        return "";
    }

    function DBDATABASE()
    {
        return "inventario";
    }

    //obtine las extensiones válidas para los archivos de imagen
    function getImageExtensions ()
    {

        return array("jpg","png","gif","jpeg","bmp", "png");
    }
    
    //obtine las extensiones válidas para los documentos
    function getDocumentExtensions ()
    {

        return array("pdf","doc","docx","xls","xlsx");
    }
    
    function getDriverExtensions ()
    {

        return array("rar","zip","exe","com","7z");
    }
    
    //ruta donde se guardan las imágenes
    function getImagePath ()
    {
        return "./images/";
    }

    //ruta donde se guardan los iconos
    function getIconPath ()
    {
        return "./icons/";
    }
    
    //ruta donde se guardan los documentos
    function getDocumentPath()
    {
        return "./document/";
    }
    
    function getDriverPath()
    {
        return "./driver/";
    }
    
    function getShortMonth ()
    {
        return array ('2','4','6','9','11');
    }

    
    function generateDay ($day) //funcion para generar los dias del mes
    {
       $html = "";
       $html .= "<select name=\"$day\">";
       $days = array('Día','1','2','3','4','5','6','7','8','9','10','11','12','13',
           '14','15','16','17','18','19','20','21','22','23','24','25',
           '26','27','28','29','30','31');

       foreach ($days as $number)                       //recorremos array 
            {    
                
                 $html .= "<option value =\"$number\">$number</option>";
            }
        
            $html .= "</select>";
            return $html;
    }
    
    
    function generateMonth ($month) //funcion para generar los meses del año
    {
       $html = "";
       $html .= "<select name=\"$month\">";
       $months = array('Mes','1','2','3','4','5','6','7','8','9','10','11','12');

       foreach ($months as $number)                       //recorremos array 
            {                                           //con todos los valores para el option
                 $html .= "<option value =\"$number\">$number</option>";
            }
        
            $html .= "</select>";
            return $html;
    }
    
    function generateYear ($year) //funcion para generar los años
    {
       $html = "";
       $html .= "<select name=\"$year\">";
       $years = array('Año','2000','2001','2002','2003','2004','2005','2006',
           '2007','2008','2009','2010','2011','2012','2013','2014','2015');

       foreach ($years as $number)                       //recorremos array 
            {                                           //con todos los valores para el option
               
           $html .= "<option value =\"$number\">$number</option>";
            }
        
            $html .= "</select>";
            return $html;
    }
    
    function generateRam ($ram) //funcion para generar tipos de ram. Parametro el nombre del campo html
    {
       $html = "";
       $html .= "<select name=\"$ram\">";
       $rams = array('','128','256','512','1024','2048','4096','8192');

       foreach ($rams as $number)                       //recorremos array 
            {                                           //con todos los valores para el option
               
           $html .= "<option value =\"$number\">$number</option>";
            }
        
            $html .= "</select>";
            return $html;
    }
    
    function generateSSOO ($ssoo, $value_selected = 0)
    {
       $html = "";
       $html .= "<select name=\"$ssoo\">";
       $ssoos = array('','Windows 98','Windows Vista','Windows XP','Windows 7', 'Windows 8','Windows 2003 Server',
           'Windows 2008 Server','Windows 2012 Server', 'Ubuntu', 'Fedora', 'Mac', 'Debian', 'Android');

       foreach ($ssoos as $valor)                       //recorremos array 
            {                                           //con todos los valores para el option
           $selected = "";
           if ($valor == $value_selected)
           {
               $selected = "selected";
           }
               
           $html .= "<option value =\"$valor\" $selected>$valor</option>";
            }
        
            $html .= "</select>";
            return $html;
    }
    
    function generateHddGb ($hdd) //funcion que genera opciones de GB de hdd
    {
       $html = "";
       $html .= "<select name=\"$hdd\">";
       $hdds = array('','10','20','30','40','50','60','70','80','90','100');

       foreach ($hdds as $number)                       //recorremos array 
            {                                           //con todos los valores para el option
               
           $html .= "<option value =\"$number\">$number</option>";
            }
        
            $html .= "</select>";
            return $html;
    }
    
    function debugOn()
    {
        return FALSE;
    }
?>