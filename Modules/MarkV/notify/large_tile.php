<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/notify/includes/js/jquery.idTabs.min.js'></script>
<script type='text/javascript' src='/components/infusions/notify/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/notify/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ notify_init(); });
</script>

<div class=sidePanelLeft>
<div class=sidePanelTitle><?php echo $name; ?> - v<?php echo $version; ?>&nbsp;<span id="notify" class="refresh_text"></span></div>
<div class=sidePanelContent>
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

echo '<div id="notify_large_tile"></div>';

?>
</div>
</div>

<div id="notify" class="tab">
	<ul>
		<li><a id="Pushover_link" class="selected" href="#Pushover">Pushover</a></li>
		<li><a id="Email_link" href="#Email">Email</a></li>
	</ul>

<div id="Pushover">
	<strong>Pushover Settings</strong> [<a href="javascript:notify_update_conf($('#notify_form_pushover_conf').serialize(), 'pushover');">Save</a>] [<a href="javascript:notify_test_push();">Test</a>]<br /><br />
	<form id='notify_form_pushover_conf'>
	<table id="notify"  class="grid">
	<tr><td>App Token:</td> <td><input class="notify" type="text" id="apptoken" name="apptoken" value="<?php echo $apptoken_conf; ?>" size="50"></td></tr>
	<tr><td>User Key:</td> <td><input class="notify" type="text" id="userkey" name="userkey" value="<?php echo $userkey_conf; ?>" size="50"></td></tr>
	</table>
	</form>
</div>

<div id="Email">
	<strong>Email Settings</strong> [<a href="javascript:notify_update_conf($('#notify_form_email_conf').serialize(), 'email');">Save</a>] [<a href="javascript:notify_test_email();">Test</a>]<br /><br />
	<form id='notify_form_email_conf'>
	<table id="notify"  class="grid">
	<tr><td>To:</td> <td><input class="notify" type="text" id="to" name="to" value="<?php echo $to_conf; ?>" size="50"></td></tr>
	<tr><td>From:</td> <td><input class="notify" type="text" id="from" name="from" value="<?php echo $from_conf; ?>" size="50"></td></tr>
	</table>
	</form>
	<br />
	<form id='notify_form_msmtp_conf'>
	<?php
	if($is_msmtp_installed)
	{
		echo "<strong>SMTP Configuration</strong> [<a href=\"javascript:notify_update_conf($('#notify_form_msmtp_conf').serialize(), 'msmtp');\">Save</a>]<br /><br />";
		echo "<textarea class='notify' id='msmtp' name='msmtp' cols='85' rows='29'>"; if(file_exists($msmtp_path)) echo file_get_contents($msmtp_path); echo "</textarea>";
	}
	else
	{
		echo "<strong>SMTP Configuration</strong><br /><br />";
		echo "<em>msmtp not installed...</em>";
	}
	?>
	</form>
</div>

</div>