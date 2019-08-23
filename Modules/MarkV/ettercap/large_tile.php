</br></br><div class="my_large_tile_content">
	
<?php

global $directory, $rel_dir, $version, $name;
require($directory."includes/vars.php");

?>

<script type='text/javascript' src='/components/infusions/ettercap/includes/js/jquery.idTabs.min.js'></script>
<script type='text/javascript' src='/components/infusions/ettercap/includes/js/infusion.js'></script>
<style>@import url('/components/infusions/ettercap/includes/css/infusion.css')</style>

<script type="text/javascript">
	$(document).ready(function(){ ettercap_init(); });
</script>

<div class=sidePanelLeft>
<div class=sidePanelTitle><?php echo $name; ?> - v<?php echo $version; ?>&nbsp;<span id="ettercap" class="refresh_text"></span></div>
<div class=sidePanelContent>
<?php
if($is_ettercap_installed && $installed)
{
	echo '<fieldset class="ettercap">';
	echo '<legend class="nmap">Dependencies</legend>';
	
	echo "ettercap";
	echo "&nbsp;<font color=\"lime\"><strong>&#10004;</strong></font>";
		
	echo '</fieldset>';
}
else
{
	echo "All required dependencies have to be installed first. This may take a few minutes.<br /><br />";
	
	echo "Please wait, do not leave or refresh this page. Once the install is complete, this page will refresh automatically.<br /><br />";
	
	echo '[<a id="Install" href="javascript:ettercap_install();">Install</a>]';
			
	exit();
}
?>
</div>
</div>

<div id="ettercap" class="tab">
	<ul>
		<li><a class="selected" href="#General">General</a></li>
		<li><a href="#Visualization">Visualization</a></li>
		<li><a href="#MITM">MITM</a></li>
		<li><a href="#Options">Options</a></li>
		<li><a href="#Filters">Filters</a></li>
		<li><a href="#Editor">Editor</a></li>
	</ul>
	
<div id="General">
	<table id="ettercap" class="grid" cellspacing="0">
		<tr>
			<td>Interface: </td>
			<td><select class="ettercap" id="interface" name="interface">
			<option>--</option>
			<?php
				foreach($interfaces as $key => $value)
				{
					if($int_run != "" && $int_run == $key)
						echo '<option selected value="'.$value.'">'.$key.'</option>';
					else
						echo '<option value="'.$value.'">'.$key.'</option>';
				}
			?>
			</select></td>
		</tr>	
		<tr>
			<td>Target 1: </td>
			<td><input class="ettercap" type="text" id="target_1" name="target_1" value="" size="70"></td>
		</tr>
		<tr>
			<td>Target 2: </td>
			<td><input class="ettercap" type="text" id="target_2" name="target_2" value="" size="70"></td>
		</tr>
	</table>
</div>

<div id="MITM">
	<table id="ettercap" class="grid" cellspacing="0">
		<tr>
			<td>Perform a mitm attack: </td>
			<td><select class="ettercap" id="mitm_options" name="mitm_options">
			<option>--</option>
			<?php
				foreach($mitm_options as $key => $value)
				{
					echo '<option value="'.$value.'">'.$key.'</option>';
				}
			?>
			</select>
			<select class="ettercap" id="mitm_options_param" name="mitm_options_param">
			<option>--</option>
			</select>
			</td>
		</tr>
	</table>
</div>

<div id="Visualization">
	<table id="ettercap" class="grid" cellspacing="0">
		<tr>
			<td>Visualization method: </td>
			<td><select class="ettercap" id="visualization_format" name="visualization_format">
			<option>--</option>
			<?php
				foreach($visualization_format as $key => $value)
				{
					echo '<option value="'.$value.'">'.$key.'</option>';
				}
			?>
			</select></td>
		</tr>
		<tr>
			<td colspan="2">
			<?php
				foreach($visualization_options as $key => $value)
				{
					echo '<input class="ettercap" type="checkbox" name="'.$key.'" value="'.$value.'" />&nbsp;'.$key."<br />";
				}
			?>
			</td>
		</tr>
	</table>
</div>

<div id="Options">
	<table id="ettercap" class="grid" cellspacing="0">
		<tr>
			<td>Sniff only PROTO packets: </td>
			<td><select class="ettercap" id="proto_options" name="proto_options">
			<option>--</option>
			<?php
				foreach($proto_options as $key => $value)
				{
					echo '<option value="'.$value.'">'.$key.'</option>';
				}
			?>
			</select></td>
		</tr>
		<tr>
			<td colspan="2">
			<?php
				foreach($sniffing_and_attack_options as $key => $value)
				{
					echo '<input class="ettercap" type="checkbox" name="'.$key.'" value="'.$value.'" />&nbsp;'.$key."<br />";
				}
			?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<?php
				foreach($ui_type as $key => $value)
				{
					echo '<input class="ettercap" type="checkbox" name="'.$key.'" value="'.$value.'" />&nbsp;'.$key."<br />";
				}
			?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<?php
				foreach($general_options as $key => $value)
				{
					echo '<input class="ettercap" type="checkbox" name="'.$key.'" value="'.$value.'" />&nbsp;'.$key."<br />";
				}
			?>
			</td>
		</tr>
	</table>
</div>

<div id="Filters">
	<table id="ettercap" class="grid" cellspacing="0">
		<tr>
			<td>Filter: </td>
			<td>
				<select class="ettercap" id="filter" name="filter">
				<option>--</option>
				<?php
					$filters_list = array_reverse(glob($directory."includes/filters/*.ef"));

					for($i=0;$i<count($filters_list);$i++)
					{
						echo '<option value="-F '.$filters_list[$i].'">'.basename($filters_list[$i]).'</option>';
					}
				?>
				</select> [<a id="refresh_filter" href="javascript:ettercap_refresh_filter();">Refresh Filter List</a>]
			</td>
		</tr>
	</table>
</div>

<div id="Editor">
	<table id="ettercap" class="grid" cellspacing="0">
		<tr>
			<td>Filter: </td>
			<td>
				<select class="ettercap" id="filter_editor" name="filter_editor">
				<option>--</option>
				<?php
					$filters_list = array_reverse(glob($directory."includes/filters/*.filter"));

					for($i=0;$i<count($filters_list);$i++)
					{
						echo '<option value="'.basename($filters_list[$i],".filter").'">'.basename($filters_list[$i]).'</option>';
					}
				?>
				</select> [<a id="delete_filter" href="javascript:ettercap_delete_filter();">Delete Filter</a>]
			</td>
		</tr>
		<tr>
			<td>Name: </td>
			<td>
				<input class="ettercap" type="text" id="filter_name" name="filter_name" value="" size="50"> [<a id="new_filter" href="javascript:ettercap_new_filter();">New Filter</a>]
			</td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td>
				<textarea class="ettercap" id='filter_content' name='filter_content' cols='114' rows='29'></textarea><br/><br/>
				[<a id="save_filter" href="javascript:ettercap_save_filter();">Save Filter</a>] [<a id="compile_filter" href="javascript:ettercap_compile_filter();">Compile Filter</a>]	
			</td>
		</tr>
	</table>
</div>

<div style="border-top: 1px solid black;">
<?php
if($cmd_run != "")
	echo 'Command: <input class="ettercap" type="text" id="command" name="command" value="'.$cmd_run.'" size="115"><br /><br />';
else	
	echo 'Command: <input class="ettercap" type="text" id="command" name="command" value="ettercap " size="115"><br /><br />';
?>

<span id="control">
	<?php
	if($is_ettercap_running)
	{
		echo '<a id="launch" href="javascript:ettercap_toggle(\'stop\');"><font color="red"><strong>Stop</strong></font></a>';
	}
	else
	{
		echo '<a id="launch" href="javascript:ettercap_toggle(\'start\');"><font color="lime"><strong>Start</strong></font></a>';
	}
	?>
</span>
</div>

</div>

<div id="ettercap2" class="tab">
	<ul>
		<li><a id="Output_link" class="selected" href="#Output">Output</a></li>
		<li><a id="History_link" href="#History">History</a></li>
	</ul>
	
<div id="Output">
	[<a id="refresh" href="javascript:ettercap_refresh();">Refresh</a>]<br /><br />
	<textarea class="ettercap" id='ettercap_output' name='ettercap_output' cols='85' rows='29'></textarea>
</div>

<div id="History">
	[<a id="refresh" href="javascript:ettercap_refresh_history();">Refresh</a>]<br />
	<div id="content"></div>
</div>

</div>
<br />
Auto-refresh <select class="ettercap" id="auto_time">
	<option value="1000">1 sec</option>
	<option value="5000">5 sec</option>
	<option value="10000">10 sec</option>
	<option value="15000">15 sec</option>
	<option value="20000">20 sec</option>
	<option value="25000">25 sec</option>
	<option value="30000">30 sec</option>
</select> <a id="ettercap_auto_refresh" href="javascript:void(0);"><font color="red">Off</font></a>

</div>