
<?php


    require_once "ini.php"; 

    $emailUser = "";
    $passwordUser = "";

    $linkURL = "";
    $nameCreateOption = "";

    $optionsHTML = "";
    $optionsLocationsHTML = "";

    $options = array();
    $optionsLocations = array();
    
    if (array_key_exists("actual_page", $_SESSION))
    {
        $actualPage = $_SESSION["actual_page"];


        if ($actualPage != "main.php")
        {
            $optionsLocations[]  = array("linkURL"=>"./main.php", "optionName"=>"Menú Principal");
        }
        
        /*if ($actualPage == "help.php")
        {
            $options[] = array("linkURL"=>"./new_eq.php", "optionName"=>"Crear Equipo Electrónico");
            
        }*/
        
        if ($actualPage != "search_computer.php" && $actualPage != "search.php" && $actualPage != "search_printer.php" && 
                $actualPage != "search_keyboard.php" && $actualPage != "search_monitor.php" && 
                $actualPage != "search_mouse.php" && $actualPage != "search_projector.php" && 
                $actualPage != "search_scanner.php" && $actualPage != "search_wire.php" && $actualPage != "main.php")
        {
            $optionsLocations[] = array("linkURL"=>"./search.php", "optionName"=>"Buscador de Equipos");
            
        }
        
        if ($actualPage == "search.php")
        {
            $options[] = array("linkURL"=>"./new_eq.php", "optionName"=>"Crear Equipo Electrónico");
            
        }
        
        if ($actualPage == "search_computer.php")
        {
            $options[] = array("linkURL"=>"./new_computer.php", "optionName"=>"Crear Ordenador");
            $options[] = array("linkURL"=>"./export_computer.php", "optionName"=>"Exportar a Excel");
            
        }

        if ($actualPage == "search_printer.php")
        {
            $options[] = array("linkURL"=>"./new_printer.php", "optionName"=>"Crear Impresora");
            $options[] = array("linkURL"=>"./export_printer.php", "optionName"=>"Exportar a Excel");
        }

        if ($actualPage == "search_monitor.php")
        {
            $options[] = array("linkURL"=>"./new_monitor.php", "optionName"=>"Crear Monitor");
            $options[] = array("linkURL"=>"./export_monitor.php", "optionName"=>"Exportar a Excel");
        }

        if ($actualPage == "search_keyboard.php")
        {
            $options[] = array("linkURL"=>"./new_keyboard.php", "optionName"=>"Crear Teclado");
            $options[] = array("linkURL"=>"./export_keyboard.php", "optionName"=>"Exportar a Excel");
        }

        if ($actualPage == "search_mouse.php")
        {
            $options[] = array("linkURL"=>"./new_mouse.php", "optionName"=>"Crear Ratón");
            $options[] = array("linkURL"=>"./export_mouse.php", "optionName"=>"Exportar a Excel");
        }

        if ($actualPage == "search_scanner.php")
        {
            $options[] = array("linkURL"=>"./new_scanner.php", "optionName"=>"Crear Escaner");
            $options[] = array("linkURL"=>"./export_scanner.php", "optionName"=>"Exportar a Excel");
        }

        if ($actualPage == "search_projector.php")
        {
            $options[] = array("linkURL"=>"./new_projector.php", "optionName"=>"Crear Proyector");
            $options[] = array("linkURL"=>"./export_projector.php", "optionName"=>"Exportar a Excel");
        }

        if ($actualPage == "search_wire.php")
        {
            $options[] = array("linkURL"=>"./new_wire.php", "optionName"=>"Crear Cable");
            $options[] = array("linkURL"=>"./export_wire.php", "optionName"=>"Exportar a Excel");
        }
        if ($actualPage == "search_other.php")
        {
            $options[] = array("linkURL"=>"./new_other.php", "optionName"=>"Crear Equipos Electrónicos Varios");
            $options[] = array("linkURL"=>"./export_other.php", "optionName"=>"Exportar a Excel");
        }
        
        if ($actualPage == "new_computer.php")
        {
            $options[] = array("linkURL"=>"./new_eq.php", "optionName"=>"Crear Equipo Electrónico");
            
        } 
        
                
        if ($actualPage == "new_keyboard.php")
        {
            $options[] = array("linkURL"=>"./new_eq.php", "optionName"=>"Crear Equipo Electrónico");
            
        }
        
        if ($actualPage == "new_monitor.php")
        {
            $options[] = array("linkURL"=>"./new_eq.php", "optionName"=>"Crear Equipo Electrónico");
            
        }
        
        if ($actualPage == "new_mouse.php")
        {
            $options[] = array("linkURL"=>"./new_eq.php", "optionName"=>"Crear Equipo Electrónico");
            
        } 
        
        if ($actualPage == "new_printer.php")
        {
            $options[] = array("linkURL"=>"./new_eq.php", "optionName"=>"Crear Equipo Electrónico");
            
        }
        if ($actualPage == "new_projector.php")
        {
            $options[] = array("linkURL"=>"./new_eq.php", "optionName"=>"Crear Equipo Electrónico");
           
        }
        if ($actualPage == "new_scanner.php")
        {
            $options[] = array("linkURL"=>"./new_eq.php", "optionName"=>"Crear Equipo Electrónico");
            
        }
        
        if ($actualPage == "new_wire.php")
        {
            $options[] = array("linkURL"=>"./new_eq.php", "optionName"=>"Crear Equipo Electrónico");
            
        }
        if ($actualPage == "new_other.php")
        {
            $options[] = array("linkURL"=>"./new_eq.php", "optionName"=>"Crear Equipo Electrónico");
            
        }
        
        if ($actualPage == "new_user.php")
        {
            $options[] = array("linkURL"=>"./list_user.php", "optionName"=>"Volver a Usuarios");
            
        }  
        
        
        if ($actualPage == "new_project.php")
        {
            $options[] = array("linkURL"=>"./list_project.php", "optionName"=>"Volver a Proyectos");
        }
        
        if ($actualPage == "new_project_doc.php")
        {
            $options[] = array("linkURL"=>"./list_project.php", "optionName"=>"Volver a Proyectos");
            
        }
        
        if ($actualPage == "new_purchase.php")
        {
            $options[] = array("linkURL"=>"./list_purchase.php", "optionName"=>"Volver a Compras");
        }
        
         if ($actualPage == "new_building.php")
        {
            $options[] = array("linkURL"=>"./list_building.php", "optionName"=>"Volver a Edificios");
        }
        
        if ($actualPage == "new_eq.php")
        {
            $options[] = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ver Equipos Electrónicos");
        }
        
        
        if ($actualPage == "list_user.php")
        {
            $options[] = array("linkURL"=>"./new_user.php", "optionName"=>"Crear Usuario");
            $options[] = array("linkURL"=>"./export_user.php", "optionName"=>"Exportar a Excel");
        }
      
        if ($actualPage == "list_office.php")
        {
            $options[]  = array("linkURL"=>"./list_building.php", "optionName"=>"Volver a Edificios");
            $options[] = array("linkURL"=>"./new_office.php", "optionName"=>"Crear Despacho");
            $options[] = array("linkURL"=>"./export_office.php", "optionName"=>"Exportar a Excel");
            
        }
        
        if ($actualPage == "list_building.php")
        {
            $options[] = array("linkURL"=>"./new_building.php", "optionName"=>"Crear nuevo Edificio");
            $options[] = array("linkURL"=>"./export_building.php", "optionName"=>"Exportar a Excel");
        }
        
        if ($actualPage == "list_project.php")
        {
            $options[] = array("linkURL"=>"./new_project.php", "optionName"=>"Crear nuevo Proyecto");
            $options[] = array("linkURL"=>"./export_project.php", "optionName"=>"Exportar a Excel");
        }
        
        if ($actualPage == "list_purchase.php")
        {
            $options[]  = array("linkURL"=>"./new_purchase.php", "optionName"=>"Crear nueva Compra");
            $options[] = array("linkURL"=>"./export_purchase.php", "optionName"=>"Exportar a Excel");
        }
        
        if ($actualPage == "list_electronic_eq.php")
        {
            $options[]  = array("linkURL"=>"./new_eq.php", "optionName"=>"Crear Equipo Electrónico");
            //$optionsLocations[]  = array("linkURL"=>"./search.php", "optionName"=>"Buscador de Equipos");
        }
  
        if ($actualPage == "detail_project.php")
        {
            if (is_admin(getUserRolInSession()))
            {
                $options[]  = array("linkURL"=>"./list_project.php", "optionName"=>" Volver a Proyectos");
                $options[] = array("linkURL"=>"./project_to_electonic.php", "optionName"=>"Asociar Equipo Electrónico");
                $options[] = array("linkURL"=>"./new_project_doc.php", "optionName"=>"Agregar Documento al Proyecto");
                $options[] = array("linkURL"=>"./edit_project.php", "optionName"=>"Editar Proyecto");
                $options[] = array("linkURL"=>"./export_detail_project.php", "optionName"=>"Exportar a Excel");
            }
            else 
            {
                $options[]  = array("linkURL"=>"./list_project.php", "optionName"=>" Volver a Proyectos");
                $options[] = array("linkURL"=>"./project_to_electonic.php", "optionName"=>"Asociar Equipo Electrónico");
                $options[] = array("linkURL"=>"./new_project_doc.php", "optionName"=>"Agregar Documento al Proyecto");
                $options[] = array("linkURL"=>"./export_detail_project.php", "optionName"=>"Exportar a Excel");
            }
                    
        }
        
        if ($actualPage == "detail_purchase.php")
        {
            if (is_admin(getUserRolInSession()))
            {
                $options[]  = array("linkURL"=>"./list_purchase.php", "optionName"=>"Volver a Compras");
                $options[] = array("linkURL"=>"./purchase_to_electronic.php", "optionName"=>"Asociar Equipo Electrónico");
                $options[] = array("linkURL"=>"./new_purchase_doc.php", "optionName"=>"Agregar Documento a la Compra");
                $options[] = array("linkURL"=>"./edit_purchase.php", "optionName"=>"Editar Compra");
                $options[] = array("linkURL"=>"./export_detail_purchase.php", "optionName"=>"Exportar a Excel");
            }
            else
            {
                $options[]  = array("linkURL"=>"./list_purchase.php", "optionName"=>"Volver a Compras");
                $options[] = array("linkURL"=>"./purchase_to_electronic.php", "optionName"=>"Asociar Equipo Electrónico");
                $options[] = array("linkURL"=>"./new_purchase_doc.php", "optionName"=>"Agregar Documento a la Compra");
                $options[] = array("linkURL"=>"./export_detail_purchase.php", "optionName"=>"Exportar a Excel");
            }
            
        }
        
        if ($actualPage == "detail_wire.php")
        {
            if (is_admin(getUserRolInSession()))
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                $options[] = array("linkURL"=>"./edit_wire.php", "optionName"=>"Editar Cable");
            }
            else
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                
            }
        }
            
         if ($actualPage == "detail_other.php")
        {
            if (is_admin(getUserRolInSession()))
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                $options[] = array("linkURL"=>"./edit_other.php", "optionName"=>"Editar Equipos Varios");
            }
            else
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                
            }
                
        }
        
        if ($actualPage == "detail_scanner.php")
        {
            if (is_admin(getUserRolInSession()))
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                $options[] = array("linkURL"=>"./edit_scanner.php", "optionName"=>"Editar Escaner");
            }
            else
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                
            }
            
        }
        
        if ($actualPage == "detail_projector.php")
        {
            if (is_admin(getUserRolInSession()))
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                $options[] = array("linkURL"=>"./edit_projector.php", "optionName"=>"Editar Proyector");
            }
            else
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                
            }
            
        }
        
        if ($actualPage == "detail_printer.php")
        {
            if (is_admin(getUserRolInSession()))
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                $options[] = array("linkURL"=>"./edit_printer.php", "optionName"=>"Editar Impresora");
            }
            else 
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                
            }
            
        }
        
        if ($actualPage == "detail_mouse.php")
        {
            if (is_admin(getUserRolInSession()))
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                $options[] = array("linkURL"=>"./edit_mouse.php", "optionName"=>"Editar Ratón");
            }
            else
            { 
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                
            }
        }
        
        if ($actualPage == "detail_monitor.php")
        {
            if (is_admin(getUserRolInSession()))
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                $options[] = array("linkURL"=>"./edit_monitor.php", "optionName"=>"Editar Monitor");
            }
            else 
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
           
            }
        }
        
        if ($actualPage == "detail_keyboard.php")
        {
            if (is_admin(getUserRolInSession()))
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                $options[] = array("linkURL"=>"./edit_keyboard.php", "optionName"=>"Editar Teclado");
            }
            else
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                
            }
            
        }
        
        if ($actualPage == "detail_computer.php")
        {
            if (is_admin(getUserRolInSession()))
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                $options[] = array("linkURL"=>"./edit_computer.php", "optionName"=>"Editar Ordenador");
            }
            else 
            {
                $options[]  = array("linkURL"=>"./list_electronic_eq.php", "optionName"=>"Ir a Listado General");
                $options[] = array("linkURL"=>"./electronic_to_project.php", "optionName"=>"Asociar este Equipo a Proyecto");
                $options[] = array("linkURL"=>"./electronic_to_purchase.php", "optionName"=>"Asociar este Equipo a Compras");
                $options[] = array("linkURL"=>"./new_driver.php", "optionName"=>"Agregar Driver al Equipo");
                
            }
        }
           
        if ($actualPage == "detail_office_eq.php")
        {
           $options[]  = array("linkURL"=>"./list_office.php", "optionName"=>"Volver a Despachos");
        }
        
        $options[] = array("linkURL"=>"javascript:window.print()", "optionName"=>"Imprimir Página");
        $optionsLocations[] = array("linkURL"=>"./exit.php", "optionName"=>"Cerrar Sesión");
        
        $optionsHTML = generateOptionsSideBar($options); 
        $optionsLocationsHTML = generateOptionsSideBar($optionsLocations);

}
    
?>

<div id="sidebar">
        <ul>
                <li>
                        <?php if ($actualPage =="index.php") { ?>
                            
                            <h2>Iniciar Sesión</h2>
                            <form action="" method="post">
                            <ul style="margin-left: 20px; font-weight: bold">
                                <li>Introduzca Email:<input type="text" name="email" value="<?php echo $emailUser;?>"></li>
                                <li>Introduzca Password:<input type="password" name="pass" value="<?php echo $passwordUser;?>"></li>
                                <li><input type="submit" name="saveLogin" value="Enviar"></li>
                            </ul>
                            </form>
                            
                        <?php } ?>
                    
                        <!--<//?php if (count($options)) { ?>
                            
                            <h2>Opciones</h2>
                            <ul>
                                <//?php echo $optionsHTML; ?>
                            </ul>
                            
                        <//?php } ?>-->
                        
                        <!-- No muestro el menu de ubicaciones cuando me encuentro en la página de iniciar sesión -->
                        <?php if ($actualPage !="index.php") { ?>
                            <h2>Opciones</h2>
                            <ul>
                                <?php echo $optionsHTML; ?>
                                    
                            </ul>
                            <h2>Ubicaciones</h2>
                            <ul>
                                <?php echo $optionsLocationsHTML; ?>
                                    
                            </ul>
                        
                        <?php } ?>
                     
                </li>

        </ul>
</div>
