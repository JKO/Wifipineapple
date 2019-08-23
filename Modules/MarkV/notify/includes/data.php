<?php

require("/pineapple/components/infusions/notify/handler.php");

global $directory;

require($directory."includes/vars.php");

if(isset($_GET['status']))
{
	echo '<fieldset class="notify">';
	echo '<legend class="notify">Notification Type</legend>';
	
	echo '<table class="notify_table">';
	
	echo '<tr>';
	echo '<td>Email Notification</td>';
	echo '<td>';
	if($is_email_enabled)
		echo '<font color="lime"><strong>&#10004;</strong></font>'; 
	else
		echo '<font color="red"><strong>&#10008;</strong></font>';
	echo '</td>';
	
	echo '<td>';
	if($to_conf != "" && $from_conf != "")
	{
		if($is_email_enabled)
			echo '<a id="disable" href="javascript:notify_notificationtype_toggle(\'notification_email\',\'disable\');">[Disable]</a>';
		else
			echo '<a id="enable" href="javascript:notify_notificationtype_toggle(\'notification_email\',\'enable\');">[Enable]</a>';
	}
	else
	{
		echo '<font color="red"><strong>Configuration not set !</strong></font>';
	}
	echo '</td>';
	
	echo '</tr>';
	
	echo '<tr>';
	echo '<td>Push Notification</td>';
	echo '<td>';
	if($is_push_enabled)
		echo '<font color="lime"><strong>&#10004;</strong></font>'; 
	else
		echo '<font color="red"><strong>&#10008;</strong></font>';
	echo '</td>';
	
	echo '<td>';
	if($apptoken_conf != "" && $userkey_conf != "")
	{
		if($is_push_enabled)
			echo '<a id="disable" href="javascript:notify_notificationtype_toggle(\'notification_push\',\'disable\');">[Disable]</a>';
		else
			echo '<a id="enable" href="javascript:notify_notificationtype_toggle(\'notification_push\',\'enable\');">[Enable]</a>';
	}
	else
	{
		echo '<font color="red"><strong>Configuration not set !</strong></font>';
	}
	echo '</td>';
	
	echo '</tr>';
	
}
echo "</table>";
echo '</fieldset>';

?>