<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/dnsspoof/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/dnsspoof/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ dnsspoof_init_small(); });
</script>

<div style='text-align:right'><a href="#" id="dnsspoof_loading" class="refresh" onclick='javascript:dnsspoof_refresh_tile();'></a></div>

<?php

if($is_dnsspoof_installed)
{
	if ($is_dnsspoof_running) 
	{
		echo "dnsspoof <span id=\"dnsspoof_status_small\"><font color=\"lime\"><strong>&#10004;</strong></font></span>";
		echo " | <a id=\"dnsspoof_link_small\" href=\"javascript:dnsspoof_toggle_small('stop');\"><strong>Stop</strong></a><br /><br />";
	}
	else
	{ 
		echo "dnsspoof <span id=\"dnsspoof_status_small\"><font color=\"red\"><strong>&#10008;</strong></font></span>";
		echo " | <a id=\"dnsspoof_link_small\" href=\"javascript:dnsspoof_toggle_small('start');\"><strong>Start</strong></a><br /><br />"; 
	}
	
	echo "<textarea class='dnsspoof' readonly class='dnsspoof' id='dnsspoof_output_small' name='dnsspoof_output_small'></textarea>";
}
else
{
	echo "dnsspoof";
	echo "&nbsp;<font color=\"red\"><strong>&#10008;</strong></font><br /><br />";
	echo '<script type="text/javascript">notify("dnsspoof is not installed", "dnsspoof", "red");</script>';
}

?>