<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/p0f/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/p0f/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ p0f_init_small(); });
</script>

<div style='text-align:right'><a href="#" id="p0f_loading" class="refresh" onclick='javascript:p0f_refresh_tile();'></a></div>

<?php

if($is_p0f_installed)
{
	if ($is_p0f_running) 
	{
		echo "p0f <span id=\"p0f_status_small\"><font color=\"lime\"><strong>&#10004;</strong></font></span>";
		echo " | <a id=\"p0f_link_small\" href=\"javascript:p0f_toggle_small('stop');\"><strong>Stop</strong></a> ";
	}
	else
	{ 
		echo "p0f <span id=\"p0f_status_small\"><font color=\"red\"><strong>&#10008;</strong></font></span>";
		echo " | <a id=\"p0f_link_small\" href=\"javascript:p0f_toggle_small('start');\"><strong>Start</strong></a> "; 
	}

	if($is_p0f_running)
		echo '<select class="p0f" disabled="disabled" id="p0f_interface_small" name="p0f_interface_small">';
	else
		echo '<select class="p0f" id="p0f_interface_small" name="p0f_interface_small">';

	for($i=0;$i<count($interfaces);$i++)
	{
		if($current_interface == $interfaces[$i])
			echo '<option selected value="'.$interfaces[$i].'">'.$interfaces[$i].'</option>';
		else
			echo '<option value="'.$interfaces[$i].'">'.$interfaces[$i].'</option>';
	}
	echo '</select><br /><br />';
	
	echo "<textarea readonly class='p0f' id='p0f_output_small' name='p0f_output_small'></textarea>";
}
else
{
	echo "p0f";
	echo "&nbsp;<font color=\"red\"><strong>&#10008;</strong></font><br /><br />";
	
	echo "Install to <a id=\"install_int\" href=\"javascript:p0f_install('internal');\">Internal Storage</a> or <a id=\"install_sd\" href=\"javascript:p0f_install('sd');\">SD Storage</a>";
	
	echo '<script type="text/javascript">notify("p0f is not installed", "p0f", "red");</script>';
		
	exit();	
}

?>