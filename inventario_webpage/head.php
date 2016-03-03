<?php

    //$_SESSION["actual_page"] = "head.php";
    
    $page =  $_SESSION["actual_page"];
    $option = "";
    if ($page != "index.php")
    {
       if(is_admin(getUserRolInSession()))
        {
            $option = "<li>Bienvenido, Administrador</li>";
        }
        else
        {
            $option = "<li>Bienvenido, Usuario</li>";
        } 

    }
    else
    {
        $option = "<li>Bienvenido</li>";
    }
    
    
?>

<div id="menu-wrapper">
	<div id="menu">
		<ul>
			<li class="current_page_item"><a href="index.php">Cerrar Sesión</a></li>
                        <?php echo $option; ?>
		</ul>
	</div>
	<!-- end #menu -->
</div>
        

