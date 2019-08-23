<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/logcheck/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/logcheck/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ logcheck_init_small(); });
</script>

<div style='text-align:right'><a href="#" id="logcheck_loading" class="refresh" onclick='javascript:logcheck_refresh_tile();'></a></div>

<?php

if($is_ssmtp_installed)
{
	if ($is_logcheck_running) 
	{
		echo "Logcheck <span id=\"logcheck_status_small\"><font color=\"lime\"><strong>&#10004;</strong></font></span>";
		echo " | <a id=\"logcheck_link_small\" href=\"javascript:logcheck_toggle_small('stop');\"><strong>Stop</strong></a><br /><br />";
	}
	else 
	{ 
		echo "Logcheck <span id=\"logcheck_status_small\"><font color=\"red\"><strong>&#10008;</strong></font></span>";
		echo " | <a id=\"logcheck_link_small\" href=\"javascript:logcheck_toggle_small('start');\"><strong>Start</strong></a><br /><br />"; 
	}
	
	echo "<textarea readonly class='logcheck' id='logcheck_output_small' name='logcheck_output_small'></textarea>";
}
else
{
	echo "ssmtp";
	echo "&nbsp;<font color=\"red\"><strong>&#10008;</strong></font><br /><br />";
	
	echo "Install to <a id=\"install_int\" href=\"javascript:logcheck_install('internal');\">Internal Storage</a> or <a id=\"install_sd\" href=\"javascript:logcheck_install('sd');\">SD Storage</a>";
	
	echo '<script type="text/javascript">notify("ssmtp is not installed", "logcheck", "red");</script>';
		
	exit();	
}

?>
