<?php

require("/pineapple/components/infusions/ettercap/handler.php");

global $directory;

require($directory."includes/vars.php");

if (isset($_GET['filter_list']))
{
	$filters_list = array_reverse(glob($directory."includes/filters/*.ef"));
	echo '<option>--</option>';
	for($i=0;$i<count($filters_list);$i++)
	{
		echo '<option value="-F '.$filters_list[$i].'">'.basename($filters_list[$i]).'</option>';
	}
}

if (isset($_GET['show_filter']))
{
	if (isset($_GET['which']))
	{
		$file = $directory."includes/filters/".$_GET['which'].".filter";
		echo file_get_contents($file);
	}
}

if (isset($_GET['delete_filter']))
{
	if (isset($_GET['which']))
	{
		exec("rm -rf ".$directory."includes/filters/".$_GET['which']."*");
	}
	
	echo '<font color="lime"><strong>done</strong></font>';
}

if (isset($_GET['compile_filter']))
{
	if (isset($_GET['which']))
	{
		$filename = $directory."includes/filters/".$_GET['which'].".filter";
		$filename_ef = $directory."includes/filters/".$_GET['which'].".ef";
		
		echo "Compile: ".$filename." to:".$filename_ef."\n";
		
		$output = shell_exec("etterfilter -o ".$filename_ef." ".$filename." 2>&1");
		echo trim($output);
		
		echo '<font color="lime"><strong>done</strong></font>';
	}
}

if (isset($_POST['new_filter']))
{
	if (isset($_POST['which']))
	{
		$filename = $directory."includes/filters/".$_POST['which'].".filter";
		
		if(!file_exists($filename))
		{
			$newdata = $_POST['newdata'];
			$newdata = ereg_replace(13,  "", $newdata);
			$fw = fopen($filename, 'w+');
			$fb = fwrite($fw,stripslashes($newdata));
			fclose($fw);
		
			$filename_ef = $directory."includes/filters/".$_POST['which'].".ef";
			
			echo '<font color="lime"><strong>done</strong></font>';
		}
	}
}

if (isset($_POST['save_filter']))
{
	if (isset($_POST['which']))
	{
		$filename = $directory."includes/filters/".$_POST['which'].".filter";

		$newdata = $_POST['newdata'];
		$newdata = ereg_replace(13,  "", $newdata);
		$fw = fopen($filename, 'w');
		$fb = fwrite($fw,stripslashes($newdata));
		fclose($fw);
		
		echo '<font color="lime"><strong>saved</strong></font>';
	}
}

?>