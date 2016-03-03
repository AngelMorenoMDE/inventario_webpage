<?php
    
    $tableBuilding = "building";
    $tableCampus = "campus";
    $tableCdType = "cd_type";
    $tableComputer = "computer";
    $tableComputerType = "computer_type";
    $tableElectEq = "electronic_equipment";
    $tableElectEqType = "electronic_eq_type";
    $tableHddType = "hdd_type";
    $tableKeyboard = "keyboard";
    $tableMonitor = "monitor";
    $tableMonitorType = "monitor_type";
    $tableMouse = "mouse";
    $tableOffice = "office";
    $tablePrinter = "printer";
    $tableRamType = "ram_type";
    $tableRoleUser = "role_user";
    $tableStatus = "status";
    $tableUser = "user";
    $tableWire = "wire";
    $tableWireType = "wire_type";
    $tableScanner = "scanner";
    $tableProjector = "projector";
    $tableProject = "project";
    $tableProjectEq = "project_eq";
    $tableProjectDoc = "project_doc";
    $tablePurchase = "purchase";
    $tablePurchaseEq = "purchase_eq";
    $tablePurchaseDoc = "purchase_doc";
    
    function error_js($msg)
    {    
        echo "<script>alert(\"$msg\");</script>"; 
    }

    function error_conect_db()
    {
        $msg = "Fallo conexión con la base de datos";
        error_js($msg);
    }

    function error_query_db($error)
    {
        $msg = "Fallo sentencia mysql ".$error;
        error_js($msg);
    }

    function confirm_save_db()
    {
        $msg = "Datos guardados con éxito";
        error_js($msg);
    }

    function new_conex_db()
    {
            $conexion = mysql_connect(DBHOST(),DBUSER(),DBPASSWORD(), true);

            if (!$conexion)
            { 
                error_conect_db();

                die("Error Grave");
            }

            mysql_select_db(DBDATABASE(),$conexion);
            mysql_set_charset("utf8", $conexion);
            
            return $conexion;
    }
    
    function execute_query($query)
    {
        $conexion = new_conex_db();
        
        if (!mysql_query($query, $conexion))
        {
            error_query_db(mysql_error($conexion). " Query: ".$query);
            die();
        }
        
        mysql_close($conexion);	
        
        return true;
    }
    
    function select_one($query)
    {
        $conexion = new_conex_db();
        
        $result_query = mysql_query($query,$conexion);
        
        if ($result_query)                           
        {
           $row = mysql_fetch_assoc($result_query);
        }
        
        mysql_close($conexion);
        
        return $row;
    }
    
    //Genera un desplegable html dinámico a partir de una tabla de la BBDD
    // Parámetros: 
    //      - $name : atributo html name del select
    //      - $table : nombre de la tabla de BBDD
    //      - $column_value : columna id de la tabla
    //      - $column_name : columna nombre de la tabla
    //      - $value_selected :  id opción seleccionada por defecto ó id recogido)
    function generateSelectWithOptions($name,$table,$column_value,$column_name,$value_selected = 0)
    {
        $select_html = "";
        $select_html .= "<select name=\"$name\">";

        $conexion = new_conex_db();

        $select_query = "select * from $table;";

        $result = mysql_query($select_query, $conexion);

        if ($result)
        {           
            while ($row =  mysql_fetch_assoc($result)) //recorremos array de resultado
            {                                           //con todos los valores para el option
                $selected = "";
                $value = $row[$column_value];
                $name = $row[$column_name];

                if ($value == $value_selected) //si coincide lo marca como seleccionado
                {
                    $selected = "selected";
                }
                //vamos acumulando los valores de rol en el option
                 $select_html .= "<option value =\"$value\" $selected>$name</option>";

            }
        }
        mysql_close($conexion);

        $select_html .= "</select>";

        return $select_html;
    }
    
    
    //funcion para mostrar la opción seleccionada del desplegable en los listados
    //Parámetros:
        //identificador que recogemos de la select
        //nombre de la tabla del deplegable
        //id de la tabla
        //nombre de la tabla a mostrar
    function GetNameOption($id, $table, $column_value, $column_name)
    {
        $conexion = new_conex_db();
    
        $sel = "select $column_name from $table where $column_value = $id;";
        $row = select_one($sel);
        $name = $row[$column_name];
        mysql_close($conexion);
    
        return $name; 
    }
    
    //Genera un desplegable html dinámico a partir de una tabla de la BBDD
    //con un hueco vacio para los buscadores
    // Parámetros: 
    //      - $name : atributo html name del select
    //      - $table : nombre de la tabla de BBDD
    //      - $column_value : columna id de la tabla
    //      - $column_name : columna nombre de la tabla
    //      - $value_selected :  id opción seleccionada por defecto ó id recogido)
    function generateSelectWithOptionsSearch($name, 
                                       $table, 
                                       $column_value, 
                                       $column_name, 
                                       $value_selected = 0)
    {
        
        $valuePrimera = -1;
        $namePrimero ="";
        
        $select_html = "";
        $select_html .= "<select name=\"$name\">";

           $conexion = new_conex_db();

           $select_query = "select * from $table;";

           $result = mysql_query($select_query, $conexion);

           if ($result)
           {     
               $select_html .= "<option value =\"$valuePrimera\" >$namePrimero</option>";
                while ($row =  mysql_fetch_assoc($result)) //recorremos array de resultado
                {                                           //con todos los valores para el option
                    
                    $value = $row[$column_value];
                    $name = $row[$column_name];

                   
                //vamos acumulando los valores de rol en el option
                 $select_html .= "<option value =\"$value\" >$name</option>";


                    }
        }
        mysql_close($conexion);

        $select_html .= "</select>";

        return $select_html;
    }
    
    function generateSelectOffice($value_selected="")
    {
      
        
        $select_html = "";
        $select_html .= "<select name=\"id_office\">";

                
        $nameOffice = "";
        $nameBuilding = "";
        $nameCampus = "";
        $nameSelect = ""; 
        
        $valueOffice = "";
        $valueBuilding = "";
        $valueCampus = "";
        $valueOptions = "";
        
        $conexion = new_conex_db();
        
        
        $selectOffice = "select * from office;";
        $resultOffice = mysql_query($selectOffice, $conexion);
        
        if ($resultOffice)
        {           
            while ($rowOffice =  mysql_fetch_assoc($resultOffice)) //recorremos array de resultado
            {                                           //con todos los valores para el option
                
                $nameOffice = $rowOffice["name_office"];
                $valueOffice = $rowOffice["id_office"];
                $building = $rowOffice["id_building"];
                
                $selectBuilding = "select * from building where id_building in "
                                    . "(select id_building from office where "
                                    . "id_building = $building);";
                $rowBuilding = select_one($selectBuilding);
                $nameBuilding = $rowBuilding["name_building"];
                $valueBuilding = $rowBuilding["id_building"];
                $campus = $rowBuilding["id_campus"];
                
                $selectCampus = "select * from campus where id_campus in "
                                    . "(select id_campus from building where "
                                    . "id_campus = $campus);";
                $rowCampus = select_one($selectCampus);
                $nameCampus = $rowCampus["name_campus"];
                $valueCampus = $rowCampus["id_campus"];

                $selected = "";
                $nameOptions = $nameCampus . "-" . $nameBuilding . "-" . $nameOffice;
                $valueOptions = $valueCampus . "-" . $valueBuilding . "-" . $valueOffice;
                
                if ($valueOptions == $value_selected) //si coincide lo marca como seleccionado
                {
                    $selected = "selected";
                }
                

                //vamos acumulando los valores de rol en el option
                 $select_html .= "<option value =\"$valueOptions\" $selected>$nameOptions</option>";

            }
        }
        mysql_close($conexion);

        $select_html .= "</select>";

        return $select_html;
    }
    
    function generateSelectOfficeSearch()
    {
      
        
        $select_html = "";
        $select_html .= "<select name=\"id_office\">";

        $valuePrimera = -1;
        $namePrimero ="";
                
        $nameOffice = "";
        $nameBuilding = "";
        $nameCampus = "";
        $nameSelect = ""; 
        
        $valueOffice = "";
        $valueBuilding = "";
        $valueCampus = "";
        $valueOptions = "";
        
        $conexion = new_conex_db();
        
        
        $selectOffice = "select * from office;";
        $resultOffice = mysql_query($selectOffice, $conexion);
        
        if ($resultOffice)
        {    
            $select_html .= "<option value =\"$valuePrimera\" >$namePrimero</option>";
            while ($rowOffice =  mysql_fetch_assoc($resultOffice)) //recorremos array de resultado
            {                                           //con todos los valores para el option
                
                $nameOffice = $rowOffice["name_office"];
                $valueOffice = $rowOffice["id_office"];
                $building = $rowOffice["id_building"];
                
                $selectBuilding = "select * from building where id_building in "
                                    . "(select id_building from office where "
                                    . "id_building = $building);";
                $rowBuilding = select_one($selectBuilding);
                $nameBuilding = $rowBuilding["name_building"];
                $valueBuilding = $rowBuilding["id_building"];
                $campus = $rowBuilding["id_campus"];
                
                $selectCampus = "select * from campus where id_campus in "
                                    . "(select id_campus from building where "
                                    . "id_campus = $campus);";
                $rowCampus = select_one($selectCampus);
                $nameCampus = $rowCampus["name_campus"];
                $valueCampus = $rowCampus["id_campus"];

                /*$selected = "";
                
                if ($valueOptions == $value_selected) //si coincide lo marca como seleccionado
                {
                    $selected = "selected";
                }*/
                
                $nameOptions = $nameCampus . "-" . $nameBuilding . "-" . $nameOffice;
                $valueOptions = $valueCampus . "-" . $valueBuilding . "-" . $valueOffice;
                //vamos acumulando los valores de rol en el option
                 $select_html .= "<option value =\"$valueOptions\">$nameOptions</option>";

            }
        }
        mysql_close($conexion);

        $select_html .= "</select>";

        return $select_html;
    }
    
    
    function generateIdConjunto($idOffice)
    {
     
        $idConjunto = "";
        
        $selectBuilding = "select * from office where id_office = $idOffice;";        
        $rowBuilding = select_one($selectBuilding);
        $idBuilding = $rowBuilding["id_building"];        
                
        $selectCampus = "select * from building where id_building = $idBuilding;";        
        $rowCampus = select_one($selectCampus);
        $idCampus = $rowCampus["id_campus"];        
        
        $idConjunto = $idCampus . "-" . $idBuilding. "-" . $idOffice;
        

        return $idConjunto;
    }

?>
