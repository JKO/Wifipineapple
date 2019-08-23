<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/ettercap/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/ettercap/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ ettercap_init_small(); });
</script>

<div style='text-align:right'><a href="#" id="ettercap_loading" class="refresh" onclick='javascript:ettercap_refresh_tile();'></a></div>

<?php

if($is_ettercap_installed && $installed)
{
	echo '<select class="ettercap" id="ettercap_interface_small" name="ettercap_interface_small"><option>--</option>';
	foreach($interfaces as $key => $value)
	{
		if($int_run != "" && $int_run == $key)
			echo '<option selected value="'.$value.'">'.$key.'</option>';
		else
			echo '<option value="'.$value.'">'.$key.'</option>';
	}
	echo '</select>&nbsp;';
	
	echo '<span id="control_small">';
	if($is_ettercap_running)
	{
		echo '<a id="launch_small" href="javascript:ettercap_toggle_small(\'stop\');"><font color="red"><strong>Stop</strong></font></a>';
	}
	else
	{
		echo '<a id="launch_small" href="javascript:ettercap_toggle_small(\'start\');"><font color="lime"><strong>Start</strong></font></a>';
	}
	echo '</span>';
	
	if($cmd_run != "")
		echo '<input class="ettercap" type="text" id="ettercap_command_small" name="ettercap_command_small" value="'.$cmd_run.'" size="70"><br /><br />';
	else
		echo '<input class="ettercap" type="text" id="ettercap_command_small" name="ettercap_command_small" value="ettercap " size="70"><br /><br />';
	
	echo "<textarea readonly class='ettercap' id='ettercap_output_small' name='ettercap_output_small'></textarea>";
}
else
{
	echo "All required dependencies have to be installed first. This may take a few minutes.<br /><br />";
	
	echo "Please wait, do not leave or refresh this page. Once the install is complete, this page will refresh automatically.<br /><br />";
	
	echo '[<a id="Install" href="javascript:ettercap_install();">Install</a>]';
			
	echo '<script type="text/javascript">notify("ettercap is not installed", "ettercap", "red");</script>';
	
	exit();
}

?>