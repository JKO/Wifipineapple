<?php include_once('/pineapple/includes/api/tile_functions.php'); ?>
<?php include_once("{$directory}/functions.php"); ?>

<?php
$rtltcprunning = exec("pidof rtl_tcp");

if(empty($rtltcprunning)) {
	echo "RTL_TCP is <font color='red'>not Running</font>.";
        echo "<form method=\"POST\" action=\"/components/infusions/rtlradiostreamer/functions.php?action=startrtltcp\" id=\"startrtltcp\" onSubmit=\"\$(this).AJAXifyForm(notify); return false;\">";
        echo "<input type='submit' name='submit' value='Start rtl_tcp'>";
        echo "</form>";

} else { 
        echo "RTL_TCP is <font color='green'>Running</font>"; 
	echo "<form method=\"POST\" action=\"/components/infusions/rtlradiostreamer/functions.php?action=stoprtltcp\" id=\"stoprtltcp\" onSubmit=\"\$(this).AJAXifyForm(notify); return false;\">";
  	echo "<input type='submit' name='submit' value='Stop rtl_tcp'>";
	echo "</form>";
}
 
?>
