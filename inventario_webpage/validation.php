<?php

    function getRequiredFieldsByPage($page)
    {
        if (($page == "new_user.php")||($page == "edit_user.php"))
        {
            return array("nombre", "mail", "pass");
        }
        
        if (($page == "new_rol.php")||($page == "edit_rol.php"))
        {
            return array("rol");
        }
        
        if (($page == "new_computer.php")|| ($page == "edit_computer.php"))
        {
            return array("urjc_code", "serial_number", "trademark", "model", "cpuname",
                    "cpumhz", "ramtype", "rammb", "hdd1type", "hdd1_gb", "graphiccard");
        }
        
        if (($page == "new_printer.php")||($page == "edit_printer.php"))
        {
            return array("urjc_code", "serial_number", "trademark", "model");
        }
        
        if (($page == "new_monitor.php")||($page == "edit_monitor.php"))
        {
            return array("urjc_code", "serial_number", "trademark", "model", "inch");
        }
        if (($page == "new_mouse.php")||($page == "edit_mouse.php"))
        {
            return array("urjc_code", "serial_number", "trademark", "model");
        }
        
        if (($page == "new_keyboard.php")||($page == "edit_keyboard.php"))
        {
            return array("urjc_code", "serial_number", "trademark", "model", "id_project");
        }
        
        if (($page == "new_wire.php")||($page == "edit_wire.php"))
        {
            return array("urjc_code", "serial_number");
        }
        if (($page == "new_other.php")||($page == "edit_other.php"))
        {
            return array("urjc_code", "serial_number", "name");
        }
        if (($page == "new_scanner.php")||($page == "edit_scanner.php"))
        {
            return array("urjc_code", "serial_number", "trademark", "model");
        }
        if (($page == "new_projector.php")||($page == "edit_projector.php"))
        {
            return array("urjc_code", "serial_number", "trademark", "model");
        }
        if (($page == "new_project.php")||($page == "edit_project.php"))
        {
            return array("name_project","status");
        }
        if (($page == "new_purchase.php")||($page == "edit_purchase.php"))
        {
            return array("name","price","date", "project","purchaser");
        }
        if (($page == "new_project_doc.php")||($page == "edit_project_doc.php"))
        {
            return array("name");
        }
        if (($page == "new_purchase_doc.php")||($page == "edit_project_doc.php"))
        {
            return array("name");
        }
        if (($page == "new_driver.php")||($page == "edit_driver.php"))
        {
            return array("name");
        }

    }

    function isFieldRequired($page, $fieldName)
    {
        if (in_array($fieldName, getRequiredFieldsByPage($page)))
        {
            return "<span style=\"color:red; font-weight:bold\">*</span>";
        }
        return "";                    
    }
    
    //------------validaciones
      
    function is_empty ($var)
    {
      if (is_null($var) || ($var == "")) 
      {
          return true; 
      }
      return false;   
    }

    function validar_cadena($valor,$max)
    {
            
        if (is_numeric($valor))
        {
            return 2;
        }
        else
        {
            if (strlen($valor)>$max) 
            {
                return 3;
            }
                   
        }
    }
    
    
    function validate_integer($valor)
    {
        if (ctype_digit($valor))
        {
            return true;
          
        }
        return false;
    }
    
    function validate_ip($valor)
    {
        if(filter_var($valor, FILTER_VALIDATE_IP))
        {
            return true;
        }
        return false;
    }

    
    //------------------------ fin validaciones
?>

