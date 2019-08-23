<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/notify/includes/js/jquery.idTabs.min.js'></script>
<script type='text/javascript' src='/components/infusions/notify/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/notify/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ notify_init_small(); });
</script>

<div style='text-align:right'><a href="#" id="notify_loading" class="refresh" onclick='javascript:notify_refresh_tile();'></a></div>

<?php

echo '<fieldset class="notify">';
echo '<legend class="notify">Dependencies</legend>';

echo '<table class="notify_table">';

if(!$is_msmtp_installed && !$is_curl_installed)
{
	echo '<tr>';
	echo '<td>msmtp</td>';
	echo '<td><font color="red"><strong>&#10008;</strong></font></td>';
	echo "<td>Install to <a id=\"install_int\" href=\"javascript:notify_install('msmtp', 'internal');\">Internal</a> or <a id=\"install_sd\" href=\"javascript:notify_install('msmtp', 'sd');\">SD</a> storage</td>";
	echo '</tr>';
	
	echo '<tr>';
	echo '<td>curl</td>';
	echo '<td><font color="red"><strong>&#10008;</strong></font></td>';
	echo "<td>Install to <a id=\"install_int\" href=\"javascript:notify_install('curl', 'internal');\">Internal</a> or <a id=\"install_sd\" href=\"javascript:notify_install('curl', 'sd');\">SD</a> storage</td>";
	echo '</tr>';
	
	exit();
}

if($is_curl_installed)
{
	echo '<tr>';
	echo '<td>curl</td>';
	echo '<td><font color="lime"><strong>&#10004;</strong></font></td>';	
	echo '</tr>';
}
else
{
	echo '<tr>';
	echo '<td>curl</td>';
	echo '<td><font color="red"><strong>&#10008;</strong></font></td>';
	echo "<td>Install to <a id=\"install_int\" href=\"javascript:notify_install('curl', 'internal');\">Internal</a> or <a id=\"install_sd\" href=\"javascript:notify_install('curl', 'sd');\">SD</a> storage</td>";
	echo '</tr>';
	
	exit();
}

if($is_msmtp_installed)
{
	echo '<tr>';
	echo '<td>msmtp</td>';
	echo '<td><font color="lime"><strong>&#10004;</strong></font></td>';	
	echo '</tr>';
}
else
{
	echo '<tr>';
	echo '<td>msmtp</td>';
	echo '<td><font color="red"><strong>&#10008;</strong></font></td>';	
	echo "<td>Install to <a id=\"install_int\" href=\"javascript:notify_install('msmtp', 'internal');\">Internal</a> or <a id=\"install_sd\" href=\"javascript:notify_install('msmtp', 'sd');\">SD</a> storage</td>";
	echo '<tr>';
	
	exit();
}

echo "</table>";
echo '</fieldset>';

echo "<br/>";

echo '<div id="notify_small_tile"></div>';

?>