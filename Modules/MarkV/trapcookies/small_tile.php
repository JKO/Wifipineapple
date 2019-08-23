<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/trapcookies/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/trapcookies/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ trapcookies_init_small(); });
</script>

<div style='text-align:right'><a href="#" id="trapcookies_loading" class="refresh" onclick='javascript:trapcookies_refresh_tile();'></a></div>

<?php

if($is_ngrep_installed)
{
	if ($is_ngrep_running) 
	{
		echo "trapcookies <span id=\"trapcookies_status_small\"><font color=\"lime\"><strong>&#10004;</strong></font></span>";
		echo " | <a id=\"trapcookies_link_small\" href=\"javascript:trapcookies_toggle_small('stop');\"><strong>Stop</strong></a><br /><br />";
	}
	else
	{ 
		echo "trapcookies <span id=\"trapcookies_status_small\"><font color=\"red\"><strong>&#10008;</strong></font></span>";
		echo " | <a id=\"trapcookies_link_small\" href=\"javascript:trapcookies_toggle_small('start');\"><strong>Start</strong></a><br /><br />"; 
	}
	
	echo "<textarea class='trapcookies' readonly class='trapcookies' id='trapcookies_output_small' name='trapcookies_output_small'></textarea>";
}
else
{
	echo "ngrep";
	echo "&nbsp;<font color=\"red\"><strong>&#10008;</strong></font><br /><br />";
	
	echo "Install to <a id=\"install_int\" href=\"javascript:trapcookies_install('internal');\">Internal Storage</a> or <a id=\"install_sd\" href=\"javascript:trapcookies_install('sd');\">SD Storage</a>";
	
	echo '<script type="text/javascript">notify("ngrep is not installed", "trapcookies", "red");</script>';
		
	exit();	
}

?>