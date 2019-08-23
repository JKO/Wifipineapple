<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/sslstrip/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/sslstrip/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ sslstrip_init_small(); });
</script>

<div style='text-align:right'><a href="#" id="sslstrip_loading" class="refresh" onclick='javascript:sslstrip_refresh_tile();'></a></div>

<?php

if($is_sslstrip_installed)
{
	if ($is_sslstrip_running)
	{
		echo "sslstrip <span id=\"sslstrip_status_small\"><font color=\"lime\"><strong>&#10004;</strong></font></span>";
		echo " | <a id=\"sslstrip_link_small\" href=\"javascript:sslstrip_toggle_small('stop');\"><strong>Stop</strong></a> ";
		if($is_verbose)
			echo '<input class="sslstrip" type="checkbox" checked="checked" disabled="disabled" id="verbose_small" name="verbose_small" value="verbose" /> Verbose<br /><br />';
		else
			echo '<input class="sslstrip" type="checkbox" disabled="disabled" id="verbose_small" name="verbose_small" value="verbose" /> Verbose<br /><br />';
	}
	else
	{ 
		echo "sslstrip <span id=\"sslstrip_status_small\"><font color=\"red\"><strong>&#10008;</strong></font></span>";
		echo " | <a id=\"sslstrip_link_small\" href=\"javascript:sslstrip_toggle_small('start');\"><strong>Start</strong></a> "; 
		if($is_verbose)
			echo '<input class="sslstrip" type="checkbox" checked="checked" id="verbose_small" name="verbose_small" value="verbose" /> Verbose<br /><br />';
		else
			echo '<input class="sslstrip" type="checkbox" id="verbose_small" name="verbose_small" value="verbose_small" /> Verbose<br /><br />';
	}
	
	echo "<textarea readonly class='sslstrip' id='sslstrip_output_small' name='sslstrip_output_small'></textarea>";
}
else
{
	echo "sslstrip";
	echo "&nbsp;<font color=\"red\"><strong>&#10008;</strong></font><br /><br />";
	
	echo "Install to <a id=\"install_int\" href=\"javascript:sslstrip_install('internal');\">Internal Storage</a> or <a id=\"install_sd\" href=\"javascript:sslstrip_install('sd');\">SD Storage</a>";
	
	echo '<script type="text/javascript">notify("sslstrip is not installed", "sslstrip", "red");</script>';
		
	exit();	
}

?>