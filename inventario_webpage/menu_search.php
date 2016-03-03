<?php 

require_once "ini.php"; 
check_session();

$page =  $_SESSION["actual_page"];

$selected["principal"] = "class=\"pestanaFija\"";
$selected["computer"] = "class=\"pestana\"";
$selected["monitor"] = "class=\"pestana\"";
$selected["printer"] = "class=\"pestana\"";
$selected["scanner"] = "class=\"pestana\"";
$selected["mouse"] = "class=\"pestana\"";
$selected["keyboard"] = "class=\"pestana\"";
$selected["projector"] = "class=\"pestana\"";
$selected["wire"] = "class=\"pestana\"";
$selected["other"] = "class=\"pestana\"";

if ($page == "search3.php")
{
    $selected["principal"] = "class=\"pestanaFija\"";
    
}

if ($page == "search_computer.php")
{
    $selected["computer"] = "class=\"pestanaActiva\"";
    $selected["principal"] = "class=\"pestanaFijaDesactivada\"";
}
if ($page == "search_monitor.php")
{
    $selected["monitor"] = "class=\"pestanaActiva\"";
    $selected["principal"] = "class=\"pestanaFijaDesactivada\"";
}
if ($page == "search_printer.php")
{
    $selected["printer"] = "class=\"pestanaActiva\"";
    $selected["principal"] = "class=\"pestanaFijaDesactivada\"";
}
if ($page == "search_scanner.php")
{
    $selected["scanner"] = "class=\"pestanaActiva\"";
    $selected["principal"] = "class=\"pestanaFijaDesactivada\"";
}
if ($page == "search_mouse.php")
{
    $selected["mouse"] = "class=\"pestanaActiva\"";
    $selected["principal"] = "class=\"pestanaFijaDesactivada\"";
}
if ($page == "search_keyboard.php")
{
    $selected["keyboard"] = "class=\"pestanaActiva\"";
    $selected["principal"] = "class=\"pestanaFijaDesactivada\"";
}
if ($page == "search_projector.php")
{
    $selected["projector"] = "class=\"pestanaActiva\"";
    $selected["principal"] = "class=\"pestanaFijaDesactivada\"";
}
if ($page == "search_wire.php")
{
    $selected["wire"] = "class=\"pestanaActiva\"";
    $selected["principal"] = "class=\"pestanaFijaDesactivada\"";
}
if ($page == "search_other.php")
{
    $selected["other"] = "class=\"pestanaActiva\"";
    $selected["principal"] = "class=\"pestanaFijaDesactivada\"";
}

?>


<div class="post">
    <form method="post" action="">
    <table  style="border-spacing: 0px;">
        <tr>
            <td><input <?php echo $selected["principal"];?> type="submit" name="principal" value="PRINCIPAL"></input></td>   
            <td>
                    <table style="border-spacing: 0px;">
                        <tr>
                            <td>
                                <input <?php echo $selected["computer"];?> type="submit" name="computer" value="ORDENADORES">
                                <input <?php echo $selected["monitor"];?> type="submit" name="monitor" value="MONITORES">
                                <input <?php echo $selected["printer"];?> type="submit" name="printer" value="IMPRESORAS">
                                <input <?php echo $selected["scanner"];?> type="submit" name="scanner" value="ESCANERS">
                                <input <?php echo $selected["mouse"];?> type="submit" name="mouse" value="RATONES">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input <?php echo $selected["keyboard"];?> type="submit" name="keyboard" value="TECLADOS">
                                <input <?php echo $selected["projector"];?> type="submit" name="projector" value="PROYECTORES">
                                <input <?php echo $selected["wire"];?> type="submit" name="wire" value="CABLES">
                                <input <?php echo $selected["other"];?> type="submit" name="other" value="OTROS">
                            </td>
                        </tr>
                    </table>
                </td>
        </tr>
                </table>
        </form>
    </div>
