<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/urlsnarf/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/urlsnarf/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ urlsnarf_init_small(); });
</script>

<div style='text-align:right'><a href="#" id="urlsnarf_loading" class="refresh" onclick='javascript:urlsnarf_refresh_tile();'></a></div>

<?php

if($is_urlsnarf_installed)
{
	if ($is_urlsnarf_running) 
	{
		echo "urlsnarf <span id=\"urlsnarf_status_small\"><font color=\"lime\"><strong>&#10004;</strong></font></span>";
		echo " | <a id=\"urlsnarf_link_small\" href=\"javascript:urlsnarf_toggle_small('stop');\"><strong>Stop</strong></a> ";
	}
	else
	{ 
		echo "urlsnarf <span id=\"urlsnarf_status_small\"><font color=\"red\"><strong>&#10008;</strong></font></span>";
		echo " | <a id=\"urlsnarf_link_small\" href=\"javascript:urlsnarf_toggle_small('start');\"><strong>Start</strong></a> "; 
	}

	if($is_urlsnarf_running)
		echo '<select class="urlsnarf" disabled="disabled" id="urlsnarf_interface_small" name="urlsnarf_interface_small">';
	else
		echo '<select class="urlsnarf" id="urlsnarf_interface_small" name="urlsnarf_interface_small">';

	for($i=0;$i<count($interfaces);$i++)
	{
		if($current_interface == $interfaces[$i])
			echo '<option selected value="'.$interfaces[$i].'">'.$interfaces[$i].'</option>';
		else
			echo '<option value="'.$interfaces[$i].'">'.$interfaces[$i].'</option>';
	}
	echo '</select><br /><br />';
	
	echo "<textarea readonly class='urlsnarf' id='urlsnarf_output_small' name='urlsnarf_output_small'></textarea>";
}
else
{
	echo "urlsnarf";
	echo "&nbsp;<font color=\"red\"><strong>&#10008;</strong></font><br /><br />";
	echo '<script type="text/javascript">notify("urlsnarf is not installed", "urlsnarf", "red");</script>';
}

?>