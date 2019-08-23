<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/occupineapple/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/occupineapple/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ occupineapple_init_small(); });
</script>

<div style='text-align:right'><a href="#" id="occupineapple_loading" class="refresh" onclick='javascript:occupineapple_refresh_tile();'></a></div>

<?php

if($is_mdk3_installed)
{
	if ($is_mdk3_running)
	{
		echo "Occupineapple <span id=\"mdk3_status_small\"><font color=\"lime\"><strong>&#10004;</strong></font></span>";
		echo " | <a id=\"mdk3_link_small\" href=\"javascript:occupineapple_mdk3_toggle_small('stop');\"><strong>Stop</strong></a> ";
	}
	else
	{ 
		echo "Occupineapple <span id=\"mdk3_status_small\"><font color=\"red\"><strong>&#10008;</strong></font></span>";
		echo " | <a id=\"mdk3_link_small\" href=\"javascript:occupineapple_mdk3_toggle_small('start');\"><strong>Start</strong></a> "; 
	}
	
	if($is_mdk3_running)
		echo '<select class="occupineapple" disabled="disabled" id="list_small" name="list_small">';
	else
		echo '<select class="occupineapple" id="list_small" name="list_small">';
	
	echo '<option>--</option>';
	$lists_list = array_reverse(glob($directory."includes/lists/*"));

	for($i=0;$i<count($lists_list);$i++)
	{
		if($occupineapple_run == basename($lists_list[$i]))
			echo '<option selected value="'.basename($lists_list[$i]).'">'.basename($lists_list[$i]).'</option>';
		else
			echo '<option value="'.basename($lists_list[$i]).'">'.basename($lists_list[$i]).'</option>';
	}
	echo '</select> <br/><br/>';
	
	echo "<textarea readonly class='occupineapple' id='occupineapple_output_small' name='occupineapple_output_small'></textarea>";
}
else
{
	echo "mdk3";
	echo "&nbsp;<font color=\"red\"><strong>&#10008;</strong></font><br /><br />";
	
	echo "Install to <a id=\"install_int\" href=\"javascript:occupineapple_install('internal');\">Internal Storage</a> or <a id=\"install_sd\" href=\"javascript:occupineapple_install('sd');\">SD Storage</a>";
	
	echo '<script type="text/javascript">notify("mdk3 is not installed", "occupineapple", "red");</script>';
		
	exit();	
}

?>